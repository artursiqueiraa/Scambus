<?php

class Seguranca {

    // ─── CSRF: Double-Submit Cookie Pattern ──────────────────────────────────
    // Funciona mesmo quando a sessão PHP é reiniciada entre requests (InfinityFree)
    // O token fica na sessão E num cookie. Valida contra qualquer um dos dois.

    public static function csrfToken() {
        // 1. Tenta pegar da sessão
        if (!empty($_SESSION['csrf_token'])) {
            // Garante que o cookie também existe
            if (empty($_COOKIE['csrf_token'])) {
                setcookie('csrf_token', $_SESSION['csrf_token'], 0, '/', '', false, false);
            }
            return $_SESSION['csrf_token'];
        }

        // 2. Tenta recuperar do cookie (sessão reiniciada)
        if (!empty($_COOKIE['csrf_token'])) {
            $_SESSION['csrf_token'] = $_COOKIE['csrf_token'];
            return $_COOKIE['csrf_token'];
        }

        // 3. Gera novo token
        $token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $token;
        setcookie('csrf_token', $token, 0, '/', '', false, false);
        return $token;
    }

    // Gera o campo oculto HTML para usar dentro de <form>
    public static function csrfCampo() {
        $token = self::csrfToken();
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
    }

    // Valida o token enviado — aceita sessão OU cookie
    public static function validarCsrf($tokenEnviado) {
        if (empty($tokenEnviado)) {
            return false;
        }

        // Verifica contra a sessão
        if (!empty($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $tokenEnviado)) {
            return true;
        }

        // Verifica contra o cookie (fallback para quando sessão reinicia)
        if (!empty($_COOKIE['csrf_token']) && hash_equals($_COOKIE['csrf_token'], $tokenEnviado)) {
            // Restaura na sessão
            $_SESSION['csrf_token'] = $_COOKIE['csrf_token'];
            return true;
        }

        return false;
    }

    // Upload Seguro de Arquivos Estáticos (Prevê RCE)
    public static function uploadSeguro($tmpName, $destinoDiretorio, $tiposPermitidos = ['image/jpeg', 'image/png', 'image/webp', 'video/mp4']) {
        if (!is_uploaded_file($tmpName)) {
            return false;
        }
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($tmpName);
        
        $mapaMimesExtensao = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp',
            'image/gif'  => 'gif',
            'video/mp4'  => 'mp4',
            'video/webm' => 'webm',
        ];

        if (!in_array($mime, $tiposPermitidos, true) || !isset($mapaMimesExtensao[$mime])) {
            return false; 
        }

        $ext = $mapaMimesExtensao[$mime];
        $nomeArquivo = uniqid('', true) . '.' . $ext;

        // Garante que o diretório existe
        if (!is_dir($destinoDiretorio)) {
            @mkdir($destinoDiretorio, 0755, true);
        }

        $destinoFinal = rtrim($destinoDiretorio, '/') . '/' . $nomeArquivo;

        if (move_uploaded_file($tmpName, $destinoFinal)) {
            return $nomeArquivo;
        }

        return false;
    }
}
