<?php

require_once "../app/modelos/Usuario.php";
require_once "../app/modelos/Servico.php";

class ControladorUsuario {

    public function perfil($id = null){

        require_once "../app/modelos/Avaliacao.php";

        // SE NÃO VIER ID → USA O USUÁRIO LOGADO
        if(!$id){
            if(empty($_SESSION['usuario_id'])){
                header("Location: ?url=autenticacao/login");
                exit;
            }
            $id = $_SESSION['usuario_id'];
        }

$usuarioModel = new Usuario();
$servicoModel = new Servico();
$avaliacaoModel = new Avaliacao();

$usuario = $usuarioModel->buscarPerfil($id);
$servicos = $servicoModel->listarPorUsuario($id);
$avaliacoes = $avaliacaoModel->listarPorUsuario($id);

require_once "../app/views/layout/cabecalho.php";
require_once "../app/views/usuarios/perfil.php";
require_once "../app/views/layout/rodape.php";

}


public function dashboard(){

if(empty($_SESSION['usuario_id'])){
    header("Location: ?url=autenticacao/login");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

$usuarioModel = new Usuario();

$dados = $usuarioModel->dadosDashboard($usuario_id);

require_once "../app/views/layout/cabecalho.php";
require_once "../app/views/usuarios/dashboard.php";
require_once "../app/views/layout/rodape.php";

}


public function editar(){

if(empty($_SESSION['usuario_id'])){
    header("Location: ?url=autenticacao/login");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

$model = new Usuario();

$usuario = $model->buscarPerfil($usuario_id);

require_once "../app/views/layout/cabecalho.php";
require_once "../app/views/usuarios/editar.php";
require_once "../app/views/layout/rodape.php";

}


public function salvarPerfil(){

if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ?url=usuario/perfil");
    exit;
}

if(empty($_SESSION['usuario_id'])){
    header("Location: ?url=autenticacao/login");
    exit;
}

require_once "../nucleo/Seguranca.php";
if(!Seguranca::validarCsrf($_POST['csrf_token'] ?? '')){
    die("CSRF detectado na configuração de perfil.");
}

$usuario_id = $_SESSION['usuario_id'];

$nome = $_POST['nome'];
$idade = $_POST['idade'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];
$bio = $_POST['bio'];
$formacao = $_POST['formacao'];

$fotoNome = null;

if(!empty($_FILES['foto']['tmp_name'])){
    require_once "../nucleo/Seguranca.php";
    $nomeArq = Seguranca::uploadSeguro($_FILES['foto']['tmp_name'], "../uploads/perfis/", ['image/jpeg', 'image/png', 'image/webp']);
    if($nomeArq) {
        $fotoNome = $nomeArq;
    }
}

$model = new Usuario();

$model->atualizarPerfilCompleto(
$usuario_id,
$nome,
$idade,
$cidade,
$estado,
$bio,
$formacao,
$fotoNome
);

// REDIRECIONA PARA PERFIL (MELHOR UX)
header("Location: ?url=usuario/perfil");

}


    public function favoritos(){

        if(empty($_SESSION['usuario_id'])){
            header("Location: ?url=autenticacao/login");
            exit;
        }

        $usuario_id = $_SESSION['usuario_id'];

        $servicoModel = new Servico();

        $favoritos = $servicoModel->favoritosDoUsuario($usuario_id);

require_once "../app/views/layout/cabecalho.php";
require_once "../app/views/usuarios/favoritos.php";
require_once "../app/views/layout/rodape.php";

}

}