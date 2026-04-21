<?php

require_once "../configuracao/banco.php";

class Usuario {

    private $conexao;

    public function __construct() {

        $banco = new Banco();
        $this->conexao = $banco->conectar();

    }

    /*
    BUSCAR USUÁRIO PELO EMAIL
    */
    public function buscarPorEmail($email) {

        $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);

    }

    /*
    CRIAR USUÁRIO
    */
    public function criar($nome, $email, $telefone, $senha, $aceitouTermos = 0) {

        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (nome, email, telefone, senha, aceitou_termos)
                VALUES (:nome, :email, :telefone, :senha, :aceitou_termos)";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":telefone", $telefone);
        $stmt->bindParam(":senha", $senhaHash);
        $stmt->bindParam(":aceitou_termos", $aceitouTermos, PDO::PARAM_INT);

        return $stmt->execute();

    }

    /*
    ACEITAR TERMOS DE USO (pós-login)
    */
    public function aceitarTermos($usuario_id) {

        $sql = "UPDATE usuarios SET aceitou_termos = 1 WHERE id = :id";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(":id", $usuario_id, PDO::PARAM_INT);

        return $stmt->execute();

    }

    /*
    CALCULAR NÍVEL DO USUÁRIO (compatibilidade)
    */
    public function calcularNivel($total_trocas) {

        if($total_trocas >= 20) return "🥇 Ouro";
        if($total_trocas >= 5)  return "🥈 Prata";
        return "🥉 Bronze";

    }

    /*
    RECALCULAR NÍVEL AUTOMÁTICO (nunca desce)
    Bronze: padrão
    Prata: 300 SCoins ganhos OU 5 trocas finalizadas
    Ouro: 1000 SCoins ganhos OU 20 trocas finalizadas
    */
    public function recalcularNivel($usuario_id) {

        // Buscar dados atuais
        $sql = "SELECT total_trocas_finalizadas, nivel FROM usuarios WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(":id", $usuario_id);
        $stmt->execute();
        $u = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$u) return 'Bronze';

        // Calcular total de SCoins GANHOS (soma de créditos, não saldo atual)
        $sql2 = "SELECT COALESCE(SUM(valor), 0) as total_ganho 
                 FROM transacoes_scoins 
                 WHERE usuario_id = :id AND tipo = 'CREDITO'";
        $stmt2 = $this->conexao->prepare($sql2);
        $stmt2->bindParam(":id", $usuario_id);
        $stmt2->execute();
        $ganho = (float)$stmt2->fetch(PDO::FETCH_ASSOC)['total_ganho'];

        $trocas = (int)$u['total_trocas_finalizadas'];
        $nivelAtual = $u['nivel'] ?? 'Bronze';

        // Hierarquia: Ouro > Prata > Bronze
        $hierarquia = ['Bronze' => 1, 'Prata' => 2, 'Ouro' => 3];
        $posicaoAtual = $hierarquia[$nivelAtual] ?? 1;

        $novoNivel = 'Bronze';

        if ($ganho >= 1000 || $trocas >= 20) {
            $novoNivel = 'Ouro';
        } elseif ($ganho >= 300 || $trocas >= 5) {
            $novoNivel = 'Prata';
        }

        // Nunca reduzir nível
        $posicaoNovo = $hierarquia[$novoNivel] ?? 1;
        if ($posicaoNovo > $posicaoAtual) {
            $sql3 = "UPDATE usuarios SET nivel = :nivel WHERE id = :id";
            $stmt3 = $this->conexao->prepare($sql3);
            $stmt3->bindParam(":nivel", $novoNivel);
            $stmt3->bindParam(":id", $usuario_id);
            $stmt3->execute();
            return $novoNivel;
        }

        return $nivelAtual;
    }

    /*
    VERIFICAR PADRÃO DE FRAUDE (farming entre mesmos usuários)
    Retorna true se detectar padrão suspeito
    */
    public function verificarPadraoSuspeito($usuario_id) {

        $sql = "SELECT 
                    CASE 
                        WHEN usuario_origem_id = :id THEN usuario_destino_id
                        ELSE usuario_origem_id 
                    END as parceiro,
                    COUNT(*) as total
                FROM trocas
                WHERE (usuario_origem_id = :id2 OR usuario_destino_id = :id3)
                AND status = 'FINALIZADA'
                AND data_finalizacao >= DATE_SUB(NOW(), INTERVAL 7 DAY)
                GROUP BY parceiro
                HAVING total >= 5";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(":id", $usuario_id);
        $stmt->bindParam(":id2", $usuario_id);
        $stmt->bindParam(":id3", $usuario_id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
    }

    /*
    BUSCAR PERFIL DO USUÁRIO
    */
    public function buscarPerfil($id) {

        $sql = "SELECT 
                    usuarios.*,
                    (SELECT COUNT(*) 
                     FROM trocas 
                     WHERE (usuario_origem_id = usuarios.id OR usuario_destino_id = usuarios.id)
                     AND status = 'FINALIZADA') as total_trocas,
                    (SELECT AVG(nota)
                     FROM avaliacoes
                     WHERE avaliado_id = usuarios.id) as avaliacao_media
                FROM usuarios
                WHERE id = :id";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        $usuario['nivel'] = $this->calcularNivel($usuario['total_trocas']);

        return $usuario;

    }

    /*
    DADOS PARA O DASHBOARD
    */
    public function dadosDashboard($usuario_id) {

        $sql = "SELECT 
                    usuarios.nome,
                    usuarios.saldo_scoins,
                    (SELECT COUNT(*)
                     FROM trocas
                     WHERE (usuario_origem_id = usuarios.id OR usuario_destino_id = usuarios.id)
                     AND status = 'FINALIZADA') as total_trocas,
                    (SELECT COUNT(*)
                     FROM servicos
                     WHERE usuario_id = usuarios.id) as total_servicos,
                    (SELECT AVG(nota)
                     FROM avaliacoes
                     WHERE avaliado_id = usuarios.id) as avaliacao_media
                FROM usuarios
                WHERE usuarios.id = :id";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(":id", $usuario_id);
        $stmt->execute();

        $dados = $stmt->fetch(PDO::FETCH_ASSOC);
        $dados['nivel'] = $this->calcularNivel($dados['total_trocas']);

        return $dados;

    }

    /*
    BUSCAR PERFIL PÚBLICO
    */
    public function buscarPerfilPublico($id) {

        $sql = "SELECT 
                    usuarios.*,
                    (SELECT COUNT(*)
                     FROM trocas
                     WHERE (usuario_origem_id = usuarios.id OR usuario_destino_id = usuarios.id)
                     AND status = 'FINALIZADA') as total_trocas,
                    (SELECT AVG(nota)
                     FROM avaliacoes
                     WHERE avaliado_id = usuarios.id) as avaliacao_media
                FROM usuarios
                WHERE id = :id";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);

    }

    /*
    ATUALIZAR PERFIL
    */
    public function atualizarPerfil($id, $nome, $foto) {

        if($foto){
            $sql = "UPDATE usuarios SET nome = :nome, foto = :foto WHERE id = :id";
        } else {
            $sql = "UPDATE usuarios SET nome = :nome WHERE id = :id";
        }

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":nome", $nome);

        if($foto){
            $stmt->bindParam(":foto", $foto);
        }

        $stmt->execute();

    }

    /*
    ATUALIZAR PERFIL COMPLETO
    */
    public function atualizarPerfilCompleto($id, $nome, $idade, $cidade, $estado, $bio, $formacao, $foto) {

        $sql = "UPDATE usuarios SET
                    nome = :nome,
                    idade = :idade,
                    cidade = :cidade,
                    estado = :estado,
                    bio = :bio,
                    formacao = :formacao";

        if($foto){
            $sql .= ", foto = :foto";
        }

        $sql .= " WHERE id = :id";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":idade", $idade);
        $stmt->bindParam(":cidade", $cidade);
        $stmt->bindParam(":estado", $estado);
        $stmt->bindParam(":bio", $bio);
        $stmt->bindParam(":formacao", $formacao);

        if($foto){
            $stmt->bindParam(":foto", $foto);
        }

        $stmt->execute();

    }

    /*
    LISTAR TODOS OS USUÁRIOS
    — inclui coluna status para o painel admin
    */
    public function listarTodos() {

        $sql = "SELECT id, nome, email, telefone, saldo_scoins, status, foto_perfil, nivel
                FROM usuarios
                ORDER BY id DESC";

        $stmt = $this->conexao->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    /*
    BLOQUEAR USUÁRIO
    */
    public function bloquear($id) {

        $sql = "UPDATE usuarios SET status = 'BLOQUEADO' WHERE id = :id";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

    }

    /*
    DESBLOQUEAR USUÁRIO
    */
    public function desbloquear($id) {

        $sql = "UPDATE usuarios SET status = 'ATIVO' WHERE id = :id";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

    }

    /*
    EXCLUIR USUÁRIO
    — remove dependências antes para evitar erro de chave estrangeira
    */
    public function excluir($id) {

        try {

            $this->conexao->beginTransaction();

            // Remove serviços do usuário
            $stmt = $this->conexao->prepare("DELETE FROM servicos WHERE usuario_id = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            // Remove trocas do usuário
            $stmt = $this->conexao->prepare("DELETE FROM trocas WHERE usuario_origem_id = :id OR usuario_destino_id = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            // Remove avaliações do usuário
            $stmt = $this->conexao->prepare("DELETE FROM avaliacoes WHERE avaliado_id = :id OR avaliador_id = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            // Remove o usuário
            $stmt = $this->conexao->prepare("DELETE FROM usuarios WHERE id = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            $this->conexao->commit();
            return true;

        } catch(Exception $e) {

            $this->conexao->rollBack();
            return false;

        }

    }

    /*
    CONTAR USUÁRIOS
    */
    public function contarUsuarios() {

        $sql = "SELECT COUNT(*) as total FROM usuarios";

        $stmt = $this->conexao->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];

    }

}