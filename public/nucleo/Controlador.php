<?php

require_once __DIR__ . '/Sessao.php';
require_once __DIR__ . '/Seguranca.php';

abstract class Controlador {

    public function __construct() {}

    protected function view($nomeDaView, $dados = []) {
        extract($dados);
        require_once ROOT . "/app/views/layout/cabecalho.php";
        require_once ROOT . "/app/views/" . $nomeDaView . ".php";
        require_once ROOT . "/app/views/layout/rodape.php";
    }

    // ✅ Redireciona com fallback JS para InfinityFree
    protected function redirect($urlInterna) {
        $url = APP_URL . '/?url=' . ltrim($urlInterna, '/');

        if (ob_get_level() > 0) {
            ob_end_clean();
        }

        if (!headers_sent()) {
            header("Location: " . $url);
            exit;
        }

        // Fallback: JavaScript redirect
        echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><meta http-equiv="refresh" content="0;url=' . htmlspecialchars($url) . '"><script>window.location.href=' . json_encode($url) . ';</script></head><body>Redirecionando...</body></html>';
        exit;
    }

    protected function auth() {
        if (!Sessao::estaLogado()) {
            $this->redirect('autenticacao/login');
        }
    }

    protected function enforceCsrf() {
        $tokenEnviado = $_POST['csrf_token'] ?? '';
        if (!Seguranca::validarCsrf($tokenEnviado)) {
            http_response_code(403);
            $this->redirect('home');
        }
    }
}