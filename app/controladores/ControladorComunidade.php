<?php

require_once "../app/modelos/Comunidade.php";

class ControladorComunidade extends Controlador {

    public function index() {

        $this->auth();

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

        $this->auth();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            require_once "../nucleo/Seguranca.php";
            if(!Seguranca::validarCsrf($_POST['csrf_token'] ?? '')){
                $_SESSION['erro_flash'] = 'Sessão expirada. Tente novamente.';
                $this->redirect('comunidade');
                return;
            }
            $texto   = trim($_POST['texto'] ?? '');
            $imagem  = null;
            $video   = null;
            $usuario = $_SESSION['usuario_id'];
            $servico_id = !empty($_POST['servico_id']) ? (int)$_POST['servico_id'] : null;
            $tipo_post  = !empty($_POST['tipo_post']) ? $_POST['tipo_post'] : 'DICA';

            // ✅ VALIDAÇÃO: tipo_post é válido
            if (!in_array($tipo_post, ['OFERECENDO', 'PROCURANDO', 'DICA'])) {
                $tipo_post = 'DICA';
            }

            if(empty($texto)){
                $_SESSION['erro_flash'] = 'O texto da publicação não pode estar vazio.';
                $this->redirect('comunidade');
                return;
            }

            // Upload de imagem (opcional)
            if(!empty($_FILES['imagem']['tmp_name'])){
                require_once "../nucleo/Seguranca.php";
                $uploadDir = ROOT . '/uploads/comunidade/';  // ✅ CORRIGIDO: ROOT em vez de ../
                if (!is_dir($uploadDir)) @mkdir($uploadDir, 0755, true);
                $imagem = Seguranca::uploadSeguro($_FILES['imagem']['tmp_name'], $uploadDir, ['image/jpeg','image/png','image/webp','image/gif']);
                if(!$imagem) { $imagem = null; }
            }

            // Upload de vídeo (opcional)
            if(!empty($_FILES['video']['tmp_name'])){
                require_once "../nucleo/Seguranca.php";
                $uploadDir = ROOT . '/uploads/comunidade/';  // ✅ CORRIGIDO: ROOT em vez de ../
                if (!is_dir($uploadDir)) @mkdir($uploadDir, 0755, true);
                $video = Seguranca::uploadSeguro($_FILES['video']['tmp_name'], $uploadDir, ['video/mp4','video/webm']);
                if(!$video) { $video = null; }
            }

            $comunidadeModel = new Comunidade();
            $post_id = $comunidadeModel->criarPost($usuario, $texto, $imagem, $video, $servico_id, $tipo_post);

            if ($post_id) {
                $_SESSION['sucesso_flash'] = 'Publicação criada com sucesso! 🎉';
            } else {
                $_SESSION['erro_flash'] = 'Erro ao criar publicação. Tente novamente.';
            }
        }

        $this->redirect('comunidade');

    }

    public function curtir($id){

        $this->auth();

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

        $this->redirect('comunidade');

    }

    public function comentar($id){

        $this->auth();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            require_once "../nucleo/Seguranca.php";
            if(!Seguranca::validarCsrf($_POST['csrf_token'] ?? '')){
                $_SESSION['erro_flash'] = 'Sessão expirada. Tente novamente.';
                $this->redirect('comunidade');
                return;
            }
            
            $texto = trim($_POST['texto'] ?? '');

            if(!empty($texto)){
                $comunidadeModel = new Comunidade();
                
                // ✅ VALIDAÇÃO: Verifica se post existe antes de comentar
                $post = $comunidadeModel->buscarPostPorId($id);
                if (!$post) {
                    $_SESSION['erro_flash'] = 'Publicação não encontrada.';
                    $this->redirect('comunidade');
                    return;
                }

                $comunidadeModel->comentar($id, $_SESSION['usuario_id'], $texto);

                if ($post && $post['usuario_id'] != $_SESSION['usuario_id']) {
                    require_once "../app/modelos/Notificacao.php";
                    $notificacaoModel = new Notificacao();
                    $minhaSessaoNome = $_SESSION['usuario_nome'] ?? 'Alguém';
                    $notificacaoModel->criar($post['usuario_id'], "{$minhaSessaoNome} comentou na sua publicação.", "?url=comunidade#post-{$id}");
                }

                $_SESSION['sucesso_flash'] = 'Comentário adicionado! 👍';
            } else {
                $_SESSION['erro_flash'] = 'O comentário não pode estar vazio.';
            }
        }

        $this->redirect('comunidade');

    }

    public function editar($id){

        $this->auth();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            require_once "../nucleo/Seguranca.php";
            if(!Seguranca::validarCsrf($_POST['csrf_token'] ?? '')){
                $_SESSION['erro_flash'] = 'Sessão expirada. Tente novamente.';
                $this->redirect('comunidade');
                return;
            }
            $texto = trim($_POST['texto'] ?? '');

            if(!empty($texto)){
                $comunidadeModel = new Comunidade();
                $resultado = $comunidadeModel->editarPost($id, $_SESSION['usuario_id'], $texto);
                
                if ($resultado) {
                    $_SESSION['sucesso_flash'] = 'Publicação atualizada com sucesso! ✏️';
                } else {
                    $_SESSION['erro_flash'] = 'Você não tem permissão para editar esta publicação.';
                }
            } else {
                $_SESSION['erro_flash'] = 'O texto não pode estar vazio.';
            }
        }

        $this->redirect('comunidade');

    }

    public function excluir($id){

        $this->auth();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            require_once "../nucleo/Seguranca.php";
            if(!Seguranca::validarCsrf($_POST['csrf_token'] ?? '')){
                $_SESSION['erro_flash'] = 'Sessão expirada. Tente novamente.';
                $this->redirect('comunidade');
                return;
            }
            $comunidadeModel = new Comunidade();
            $resultado = $comunidadeModel->excluirPost($id, $_SESSION['usuario_id']);
            
            if ($resultado) {
                $_SESSION['sucesso_flash'] = 'Publicação excluída com sucesso! 🗑️';
            } else {
                $_SESSION['erro_flash'] = 'Você não tem permissão para excluir esta publicação.';
            }
        }

        $this->redirect('comunidade');

    }

    public function gorjeta($post_id){

        $this->auth();
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            require_once "../nucleo/Seguranca.php";
            if(!Seguranca::validarCsrf($_POST['csrf_token'] ?? '')){
                $_SESSION['erro_flash'] = 'Sessão expirada. Tente novamente.';
                $this->redirect('comunidade');
                return;
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
                        
                        $_SESSION['sucesso_flash'] = 'Gorjeta enviada com sucesso! 💰';
                    } else {
                        $_SESSION['erro_flash'] = 'Saldo insuficiente para enviar gorjeta.';
                    }
                } else {
                    $_SESSION['erro_flash'] = 'Você não pode enviar gorjeta para sua própria publicação.';
                }
            } else {
                $_SESSION['erro_flash'] = 'O valor da gorjeta deve ser maior que 0.';
            }
        }

        $this->redirect('comunidade');

    }

    // ─── CURTIR VIA AJAX (retorna JSON) ───────────────────────────
    public function curtirAjax($id) {

        header('Content-Type: application/json; charset=utf-8');

        if (!isset($_SESSION['usuario_id'])) {
            echo json_encode(['ok' => false, 'msg' => 'Não autenticado']);
            exit;
        }

        require_once "../nucleo/Seguranca.php";
        if (!Seguranca::validarCsrf($_POST['csrf_token'] ?? '')) {
            echo json_encode(['ok' => false, 'msg' => 'CSRF inválido']);
            exit;
        }

        try {
            $id = (int)$id;

            // ✅ VALIDAÇÃO: Verifica se post existe
            $comunidadeModel = new Comunidade();
            $post = $comunidadeModel->buscarPostPorId($id);
            
            if (!$post) {
                echo json_encode(['ok' => false, 'msg' => 'Publicação não encontrada']);
                exit;
            }

            $jaCurtiu = $comunidadeModel->usuarioCurtiu($id, $_SESSION['usuario_id']);
            $comunidadeModel->curtir($id, $_SESSION['usuario_id']);

            if (!$jaCurtiu) {
                if ($post && $post['usuario_id'] != $_SESSION['usuario_id']) {
                    require_once "../app/modelos/Notificacao.php";
                    $notif = new Notificacao();
                    $nome = $_SESSION['usuario_nome'] ?? 'Alguém';
                    $notif->criar($post['usuario_id'], "{$nome} curtiu sua publicação.", "?url=comunidade#post-{$id}");
                }
            }

            $total  = $comunidadeModel->contarCurtidas($id);
            $curtiu = !$jaCurtiu;

            echo json_encode(['ok' => true, 'curtiu' => $curtiu, 'total' => $total]);

        } catch (Exception $e) {
            error_log("Erro curtirAjax: " . $e->getMessage());
            echo json_encode(['ok' => false, 'msg' => 'Erro interno']);
        }
        exit;
    }
}