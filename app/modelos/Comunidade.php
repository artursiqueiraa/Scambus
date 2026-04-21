<?php

require_once "../configuracao/banco.php";

class Comunidade {

    private $conexao;

    public function __construct(){
        $banco = new Banco();
        $this->conexao = $banco->conectar();
    }

    // ─── POSTS ───────────────────────────────────────────
public function criarPost($usuario_id, $texto, $imagem = null, $video = null, $servico_id = null, $tipo_post = 'DICA'){

    $sql = "INSERT INTO comunidade_posts (usuario_id, texto, imagem, video, servico_id, tipo_post)
            VALUES (:usuario_id, :texto, :imagem, :video, :servico_id, :tipo_post)";

    $stmt = $this->conexao->prepare($sql);
    $stmt->bindParam(":usuario_id", $usuario_id);
    $stmt->bindParam(":texto",      $texto);
    $stmt->bindParam(":imagem",     $imagem);
    $stmt->bindParam(":video",      $video);
    $stmt->bindParam(":servico_id", $servico_id);
    $stmt->bindParam(":tipo_post",  $tipo_post);
    $stmt->execute();

    return $this->conexao->lastInsertId();
}

    public function listarPosts($tipo = null, $usuario_id_logado = null){

        $sql = "SELECT 
                    p.*,
                    u.nome,
                    u.foto_perfil,
                    u.nivel,
                    s.titulo AS servico_titulo,
                    s.valor_scoins AS servico_valor,
                    s.imagem AS servico_imagem,
                    (SELECT COUNT(*) FROM comunidade_curtidas WHERE post_id = p.id) AS total_curtidas,
                    (SELECT COUNT(*) FROM comunidade_comentarios WHERE post_id = p.id) AS total_comentarios,
                    (SELECT COUNT(*) FROM comunidade_curtidas WHERE post_id = p.id AND usuario_id = :usuario_logado) AS ja_curtiu
                FROM comunidade_posts p
                JOIN usuarios u ON u.id = p.usuario_id
                LEFT JOIN servicos s ON s.id = p.servico_id";

        $filtros = [];
        $filtros[':usuario_logado'] = $usuario_id_logado;

        if ($tipo && in_array($tipo, ['OFERECENDO', 'PROCURANDO', 'DICA'])) {
            $sql .= " WHERE p.tipo_post = :tipo ";
            $filtros[':tipo'] = $tipo;
        }

        $sql .= " ORDER BY p.data_criacao DESC";

        $stmt = $this->conexao->prepare($sql);
        $stmt->execute($filtros);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPostPorId($id){

        $sql = "SELECT 
                    p.*,
                    u.nome,
                    u.foto_perfil,
                    u.nivel,
                    s.titulo AS servico_titulo,
                    s.valor_scoins AS servico_valor,
                    s.imagem AS servico_imagem
                FROM comunidade_posts p
                JOIN usuarios u ON u.id = p.usuario_id
                LEFT JOIN servicos s ON s.id = p.servico_id
                WHERE p.id = :id
                LIMIT 1";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ─── CURTIDAS ─────────────────────────────────────────

    public function curtir($post_id, $usuario_id){

        // Se já curtiu, descurte. Se não, curte.
        $sql = "SELECT id FROM comunidade_curtidas
                WHERE post_id = :post AND usuario_id = :usuario";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(":post",    $post_id);
        $stmt->bindParam(":usuario", $usuario_id);
        $stmt->execute();

        $existe = $stmt->fetch();

        if($existe){
            $sql = "DELETE FROM comunidade_curtidas
                    WHERE post_id = :post AND usuario_id = :usuario";
        } else {
            $sql = "INSERT INTO comunidade_curtidas (post_id, usuario_id)
                    VALUES (:post, :usuario)";
        }

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(":post",    $post_id);
        $stmt->bindParam(":usuario", $usuario_id);
        $stmt->execute();
    }

    public function usuarioCurtiu($post_id, $usuario_id){

        $sql = "SELECT id FROM comunidade_curtidas
                WHERE post_id = :post AND usuario_id = :usuario";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(":post",    $post_id);
        $stmt->bindParam(":usuario", $usuario_id);
        $stmt->execute();

        return $stmt->fetch() ? true : false;
    }

    // ─── COMENTÁRIOS ──────────────────────────────────────

    public function comentar($post_id, $usuario_id, $texto){

        $sql = "INSERT INTO comunidade_comentarios (post_id, usuario_id, texto)
                VALUES (:post, :usuario, :texto)";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(":post",    $post_id);
        $stmt->bindParam(":usuario", $usuario_id);
        $stmt->bindParam(":texto",   $texto);
        $stmt->execute();
    }

    public function listarComentarios($post_id){

        $sql = "SELECT 
                    cm.*,
                    u.nome,
                    u.foto_perfil
                FROM comunidade_comentarios cm
                JOIN usuarios u ON u.id = cm.usuario_id
                WHERE cm.post_id = :post
                ORDER BY cm.data_criacao ASC";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(":post", $post_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ─── EDITAR / EXCLUIR ─────────────────────────────────────

    public function editarPost($post_id, $usuario_id, $texto){

        $sql = "UPDATE comunidade_posts SET texto = :texto
                WHERE id = :id AND usuario_id = :usuario";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(":texto",   $texto);
        $stmt->bindParam(":id",      $post_id);
        $stmt->bindParam(":usuario", $usuario_id);
        $stmt->execute();
    }

    public function excluirPost($post_id, $usuario_id){

        // Exclui curtidas do post
        $sql = "DELETE FROM comunidade_curtidas WHERE post_id = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(":id", $post_id);
        $stmt->execute();

        // Exclui comentários do post
        $sql = "DELETE FROM comunidade_comentarios WHERE post_id = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(":id", $post_id);
        $stmt->execute();

        // Exclui o post (somente se for do próprio usuário)
        $sql = "DELETE FROM comunidade_posts WHERE id = :id AND usuario_id = :usuario";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(":id",      $post_id);
        $stmt->bindParam(":usuario", $usuario_id);
        $stmt->execute();
    }

    // ─── CONTAR CURTIDAS ─────────────────────────────────────────
    public function contarCurtidas($post_id) {
        $sql = "SELECT COUNT(*) as total FROM comunidade_curtidas WHERE post_id = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(":id", $post_id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)($row['total'] ?? 0);
    }
}