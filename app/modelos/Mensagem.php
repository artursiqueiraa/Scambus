
<?php

require_once "../configuracao/banco.php";

class Mensagem {

    private $conexao;

    public function __construct(){

        $banco = new Banco();
        $this->conexao = $banco->conectar();

    }

    public function listarPorTroca($troca_id){

       $sql = "SELECT 
            mensagens.*,
            usuarios.nome,
            usuarios.foto
        FROM mensagens

        JOIN usuarios
        ON usuarios.id = mensagens.remetente_id

        WHERE troca_id = :troca
        ORDER BY data_envio ASC";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bindParam(":troca",$troca_id);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function enviar($troca_id,$usuario_id,$mensagem){

        $sql = "INSERT INTO mensagens
                (troca_id,remetente_id,mensagem)
                VALUES
                (:troca,:usuario,:mensagem)";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bindParam(":troca",$troca_id);
        $stmt->bindParam(":usuario",$usuario_id);
        $stmt->bindParam(":mensagem",$mensagem);

        return $stmt->execute();

    }

}
