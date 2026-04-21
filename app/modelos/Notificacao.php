<?php

require_once "../configuracao/banco.php";

class Notificacao {

private $conexao;

public function __construct(){

$banco = new Banco();

$this->conexao = $banco->conectar();

}


public function criar($usuario_id,$mensagem,$link){

$sql = "INSERT INTO notificacoes
(usuario_id,mensagem,link)
VALUES
(:usuario,:mensagem,:link)";

$stmt = $this->conexao->prepare($sql);

$stmt->bindParam(":usuario",$usuario_id);
$stmt->bindParam(":mensagem",$mensagem);
$stmt->bindParam(":link",$link);

$stmt->execute();

}


public function listarPorUsuario($usuario_id){

$sql = "SELECT *
FROM notificacoes
WHERE usuario_id = :usuario
ORDER BY data_criacao DESC
LIMIT 10";

$stmt = $this->conexao->prepare($sql);

$stmt->bindParam(":usuario",$usuario_id);

$stmt->execute();

return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


public function contarNaoLidas($usuario_id){

$sql = "SELECT COUNT(*) as total
FROM notificacoes
WHERE usuario_id = :usuario
AND lida = 0";

$stmt = $this->conexao->prepare($sql);

$stmt->bindParam(":usuario",$usuario_id);

$stmt->execute();

$result = $stmt->fetch(PDO::FETCH_ASSOC);

return $result['total'];

}


public function marcarComoLida($id){

$sql = "UPDATE notificacoes
SET lida = 1
WHERE id = :id";

$stmt = $this->conexao->prepare($sql);

$stmt->bindParam(":id",$id);

$stmt->execute();

}

}
