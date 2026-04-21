<?php

require_once "../app/modelos/Comunidade.php";

class ControladorComunidade {

    public function index() {

        if(!isset($_SESSION['usuario_id'])){
            header("Location: ?url=autenticacao/login");
            exit;
        }

        $comunidadeModel = new Comunidade();
        
        $tipo = $_GET['tipo'] ?? null;
        if($tipo && !in_array($tipo, ['OFERECENDO', 'PROCURANDO', 'DICA'])) {
            $tipo = null;
        }

        $posts = $comunidadeModel->listarPosts($tipo, $_SESSION['usuario_id']);

        require_once "../app/modelos/Servico.php";
        $servicoModel = new Servico();
        $meus_servicos = $servicoModel->listarPorUsuario($_SESSION['usuario_id']);

        require_once "../app/modelos/Usuario.php";
        $usuarioModel = new Usuario();
        $topContribuidores = $usuarioModel->listarTodos(); 
        usort($topContribuidores, function($a, $b) {
            return $b['saldo_scoins'] <=> $a['saldo_scoins'];
        });
        $topContribuidores = array_slice($topContribuidores, 0, 5);

        require_once "../app/views/layout/cabecalho.php";
        require_once "../app/views/comunidade/index.php";
        require_once "../app/views/layout/rodape.php";
    }

public function postar(){

    if(!isset($_SESSION['usuario_id'])){
        header("Location: ?url=autenticacao/login");
        exit;
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        require_once "../nucleo/Seguranca.php";
        if(!Seguranca::validarCsrf($_POST['csrf_token'] ?? '')){
            die("CSRF detectado.");
        }
        $texto   = trim($_POST['texto'] ?? '');
        $imagem  = null;
        $video   = null;
        $usuario = $_SESSION['usuario_id'];
        $servico_id = !empty($_POST['servico_id']) ? $_POST['servico_id'] : null;
        $tipo_post  = !empty($_POST['tipo_post']) ? $_POST['tipo_post'] : 'DICA';

        if(empty($texto)){
            header("Location: ?url=comunidade");
            exit;
        }

        // Upload de imagem (opcional)
        if(!empty($_FILES['imagem']['tmp_name'])){
            require_once "../nucleo/Seguranca.php";
            $imagem = Seguranca::uploadSeguro($_FILES['imagem']['tmp_name'], "../uploads/comunidade/", ['image/jpeg','image/png','image/webp','image/gif']);
            if(!$imagem) { $imagem = null; }
        }

        // Upload de vídeo (opcional)
        if(!empty($_FILES['video']['tmp_name'])){
            require_once "../nucleo/Seguranca.php";
            $video = Seguranca::uploadSeguro($_FILES['video']['tmp_name'], "../uploads/comunidade/", ['video/mp4','video/webm']);
            if(!$video) { $video = null; }
        }

        $comunidadeModel = new Comunidade();
        $comunidadeModel->criarPost($usuario, $texto, $imagem, $video, $servico_id, $tipo_post);
    }

    header("Location: ?url=comunidade");
    exit;
}

    public function curtir($id){

        if(!isset($_SESSION['usuario_id'])){
            header("Location: ?url=autenticacao/login");
            exit;
        }

        $comunidadeModel = new Comunidade();
        $jaCurtiu = $comunidadeModel->usuarioCurtiu($id, $_SESSION['usuario_id']);
        
        $comunidadeModel->curtir($id, $_SESSION['usuario_id']);

        if (!$jaCurtiu) {
            $post = $comunidadeModel->buscarPostPorId($id);
            if ($post && $post['usuario_id'] != $_SESSION['usuario_id']) {
                require_once "../app/modelos/Notificacao.php";
                $notificacaoModel = new Notificacao();
                $minhaSessaoNome = $_SESSION['usuario_nome'] ?? 'Alguém';
                $notificacaoModel->criar($post['usuario_id'], "{$minhaSessaoNome} curtiu sua publicação na comunidade.", "?url=comunidade#post-{$id}");
            }
        }

        header("Location: ?url=comunidade");
        exit;
    }

    public function comentar($id){

        if(!isset($_SESSION['usuario_id'])){
            header("Location: ?url=autenticacao/login");
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            require_once "../nucleo/Seguranca.php";
            if(!Seguranca::validarCsrf($_POST['csrf_token'] ?? '')){
                die("Erro CSRF detectado");
            }
            
            $texto = trim($_POST['texto'] ?? '');

            if(!empty($texto)){
                $comunidadeModel = new Comunidade();
                $comunidadeModel->comentar($id, $_SESSION['usuario_id'], $texto);

                $post = $comunidadeModel->buscarPostPorId($id);
                if ($post && $post['usuario_id'] != $_SESSION['usuario_id']) {
                    require_once "../app/modelos/Notificacao.php";
                    $notificacaoModel = new Notificacao();
                    $minhaSessaoNome = $_SESSION['usuario_nome'] ?? 'Alguém';
                    $notificacaoModel->criar($post['usuario_id'], "{$minhaSessaoNome} comentou na sua publicação.", "?url=comunidade#post-{$id}");
                }
            }
        }

        header("Location: ?url=comunidade");
        exit;
    }

    public function editar($id){

        if(!isset($_SESSION['usuario_id'])){
            header("Location: ?url=autenticacao/login");
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            require_once "../nucleo/Seguranca.php";
            if(!Seguranca::validarCsrf($_POST['csrf_token'] ?? '')){
                die("CSRF detectado.");
            }
            $texto = trim($_POST['texto'] ?? '');

            if(!empty($texto)){
                $comunidadeModel = new Comunidade();
                $comunidadeModel->editarPost($id, $_SESSION['usuario_id'], $texto);
            }
        }

        header("Location: ?url=comunidade");
        exit;
    }

    public function excluir($id){

        if(!isset($_SESSION['usuario_id'])){
            header("Location: ?url=autenticacao/login");
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            require_once "../nucleo/Seguranca.php";
            if(!Seguranca::validarCsrf($_POST['csrf_token'] ?? '')){
                die("CSRF detectado.");
            }
            $comunidadeModel = new Comunidade();
            $comunidadeModel->excluirPost($id, $_SESSION['usuario_id']);
        }

        header("Location: ?url=comunidade");
        exit;
    }

    public function gorjeta($post_id){
        if(!isset($_SESSION['usuario_id'])){
            header("Location: ?url=autenticacao/login");
            exit;
        }
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            require_once "../nucleo/Seguranca.php";
            if(!Seguranca::validarCsrf($_POST['csrf_token'] ?? '')){
                die("CSRF detectado.");
            }
            $valor = floatval($_POST['valor'] ?? 5);
            
            if ($valor > 0) {
                $comunidadeModel = new Comunidade();
                $post = $comunidadeModel->buscarPostPorId($post_id);
                
                if ($post && $post['usuario_id'] != $_SESSION['usuario_id']) {
                    require_once "../app/modelos/Scoin.php";
                    $scoinModel = new Scoin();
                    $sucesso = $scoinModel->gorjeta($_SESSION['usuario_id'], $post['usuario_id'], $valor, $post_id);
                    
                    if ($sucesso) {
                        require_once "../app/modelos/Notificacao.php";
                        $notificacaoModel = new Notificacao();
                        $minhaSessaoNome = $_SESSION['usuario_nome'] ?? 'Alguém';
                        $notificacaoModel->criar($post['usuario_id'], "Você recebeu {$valor} SCoins de gorjeta de {$minhaSessaoNome} em uma publicação!", "?url=comunidade#post-{$post_id}");
                    }
                }
            }
        }
        header("Location: ?url=comunidade");
        exit;
    }
}