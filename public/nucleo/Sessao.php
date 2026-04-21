<?php

class Sessao {

    // Retorna o ID do usuário se logado, ou null
    public static function getUsuarioId() {
        return $_SESSION['usuario_id'] ?? null;
    }

    // Retorna as informações base (nome, tipo)
    public static function getUsuario() {
        return [
            'id' => $_SESSION['usuario_id'] ?? null,
            'nome' => $_SESSION['usuario_nome'] ?? '',
            'tipo' => $_SESSION['usuario_tipo'] ?? 'usuario'
        ];
    }

    // Retorna true se estiver logado
    public static function estaLogado() {
        return !empty($_SESSION['usuario_id']);
    }

    // Força o bloqueio. Redireciona o usuário caso não esteja logado
    public static function verificarAcessoBase() {
        if (!self::estaLogado()) {
            http_response_code(401);
            header("Location: " . APP_URL . "/?url=autenticacao/login");
            exit;
        }
    }
}
