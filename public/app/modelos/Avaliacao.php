
<?php

require_once "../configuracao/banco.php";

class Avaliacao {

    private $conexao;

    public function __construct(){

        $banco = new Banco();
        $this->conexao = $banco->conectar();

    }

    public function salvar($troca_id,$avaliador,$avaliado,$nota,$comentario){

        $sql = "INSERT INTO avaliacoes
                (troca_id,avaliador_id,avaliado_id,nota,comentario)
                VALUES
                (:troca,:avaliador,:avaliado,:nota,:comentario)";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bindParam(":troca",$troca_id);
        $stmt->bindParam(":avaliador",$avaliador);
        $stmt->bindParam(":avaliado",$avaliado);
        $stmt->bindParam(":nota",$nota);
        $stmt->bindParam(":comentario",$comentario);

        return $stmt->execute();

    }

    public function listarPorUsuario($usuario_id){

$sql = "SELECT 
avaliacoes.*,
usuarios.nome as avaliador_nome

FROM avaliacoes

JOIN usuarios
ON usuarios.id = avaliacoes.avaliador_id

WHERE avaliacoes.avaliado_id = :usuario

ORDER BY avaliacoes.data_criacao DESC";

$stmt = $this->conexao->prepare($sql);

$stmt->bindParam(":usuario",$usuario_id);

$stmt->execute();

return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


}