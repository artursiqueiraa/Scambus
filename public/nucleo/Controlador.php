<?php

require_once __DIR__ . '/Sessao.php';
require_once __DIR__ . '/Seguranca.php';

abstract class Controlador {

    public function __construct() {
        // Construtor base
    }

    // Carrega Views dinamicamente envolvendo com Cabeçalho e Rodapé
    protected function view($nomeDaView, $dados = []) {
        extract($dados);

        require_once ROOT . "/app/views/layout/cabecalho.php";
        require_once ROOT . "/app/views/" . $nomeDaView . ".php";
        require_once ROOT . "/app/views/layout/rodape.php";
    }

    // Facilita o redirecionamento baseado no root
    protected function redirect($urlInterna) {
        header("Location: " . APP_URL . "/?url=" . ltrim($urlInterna, '/'));
        exit;
    }

    // Tranca o acesso à página se não estiver logado
    protected function auth() {
        if (!Sessao::estaLogado()) {
            $this->redirect('autenticacao/login');
        }
    }

    // Redireciona com Erro 403 se falhar
    protected function enforceCsrf() {
        $tokenEnviado = $_POST['csrf_token'] ?? '';
        if (!Seguranca::validarCsrf($tokenEnviado)) {
            http_response_code(403);
            die("Requisição bloqueada por segurança CSRF. O token é inválido ou expirou.");
        }
    }
}
