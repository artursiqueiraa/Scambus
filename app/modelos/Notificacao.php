<?php

require_once "../configuracao/banco.php";

class Notificacao {

    private $conexao;

    public function __construct(){
        $banco = new Banco();
        $this->conexao = $banco->conectar();
    }

    /*
    ✅ CRIAR NOTIFICAÇÃO com timestamp correto
    */
    public function criar($usuario_id, $mensagem, $link){

        $sql = "INSERT INTO notificacoes
                (usuario_id, mensagem, link, data_criacao)
                VALUES
                (:usuario, :mensagem, :link, NOW())";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bindParam(":usuario", $usuario_id, PDO::PARAM_INT);
        $stmt->bindParam(":mensagem", $mensagem);
        $stmt->bindParam(":link", $link);

        $stmt->execute();

        return $this->conexao->lastInsertId();
    }

    /*
    ✅ LISTAR NOTIFICAÇÕES com formatação de data correta
    */
    public function listarPorUsuario($usuario_id){

        $sql = "SELECT 
                    id,
                    usuario_id,
                    mensagem,
                    link,
                    lida,
                    DATE_FORMAT(data_criacao, '%d/%m/%Y %H:%i') as data_criacao,
                    data_criacao as data_raw
                FROM notificacoes
                WHERE usuario_id = :usuario
                ORDER BY data_criacao DESC
                LIMIT 10";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bindParam(":usuario", $usuario_id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
    CONTAR NÃO LIDAS
    */
    public function contarNaoLidas($usuario_id){

        $sql = "SELECT COUNT(*) as total
                FROM notificacoes
                WHERE usuario_id = :usuario
                AND lida = 0";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bindParam(":usuario", $usuario_id, PDO::PARAM_INT);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return (int)$result['total'];
    }

    /*
    MARCAR COMO LIDA
    */
    public function marcarComoLida($id){

        $sql = "UPDATE notificacoes
                SET lida = 1
                WHERE id = :id";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    /*
    MARCAR TODAS COMO LIDAS
    */
    public function marcarTodasComoLidas($usuario_id){

        $sql = "UPDATE notificacoes
                SET lida = 1
                WHERE usuario_id = :usuario
                AND lida = 0";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bindParam(":usuario", $usuario_id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->rowCount();
    }

    /*
    DELETAR NOTIFICAÇÃO ANTIGA
    */
    public function deletarAntiga($usuario_id, $dias = 30){

        $sql = "DELETE FROM notificacoes
                WHERE usuario_id = :usuario
                AND data_criacao < DATE_SUB(NOW(), INTERVAL :dias DAY)
                AND lida = 1";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bindParam(":usuario", $usuario_id, PDO::PARAM_INT);
        $stmt->bindParam(":dias", $dias, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->rowCount();
    }
}