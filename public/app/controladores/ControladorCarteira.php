
<?php

require_once "../app/modelos/Scoin.php";
require_once "../app/modelos/Usuario.php";

class ControladorCarteira {

public function index(){

if(empty($_SESSION['usuario_id'])){
    header("Location: ?url=autenticacao/login");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

$scoinModel = new Scoin();
$usuarioModel = new Usuario();

/*
saldo atual
*/
$usuario = $usuarioModel->buscarPerfil($usuario_id);

/*
histórico
*/
$transacoes = $scoinModel->historicoPorUsuario($usuario_id);

require_once "../app/views/layout/cabecalho.php";
require_once "../app/views/carteira/index.php";
require_once "../app/views/layout/rodape.php";

}

}
