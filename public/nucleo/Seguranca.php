<?php

class Seguranca {

    // CSRF com fallback cookie para InfinityFree
    public static function csrfToken() {
        if (!empty($_SESSION['csrf_token'])) {
            if (empty($_COOKIE['csrf_token'])) {
                setcookie('csrf_token', $_SESSION['csrf_token'], 0, '/', '', false, false);
            }
            return $_SESSION['csrf_token'];
        }

        if (!empty($_COOKIE['csrf_token'])) {
            $_SESSION['csrf_token'] = $_COOKIE['csrf_token'];
            return $_COOKIE['csrf_token'];
        }

        $token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $token;
        setcookie('csrf_token', $token, 0, '/', '', false, false);
        return $token;
    }

    public static function csrfCampo() {
        $token = self::csrfToken();
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
    }

    public static function validarCsrf($tokenEnviado) {
        if (empty($tokenEnviado)) {
            return false;
        }

        if (!empty($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $tokenEnviado)) {
            return true;
        }

        if (!empty($_COOKIE['csrf_token']) && hash_equals($_COOKIE['csrf_token'], $tokenEnviado)) {
            $_SESSION['csrf_token'] = $_COOKIE['csrf_token'];
            return true;
        }

        return false;
    }

    // ✅ Upload Seguro Melhorado
    public static function uploadSeguro($tmpName, $destinoDiretorio, $tiposPermitidos = ['image/jpeg', 'image/png', 'image/webp', 'video/mp4']) {
        if (!is_uploaded_file($tmpName)) {
            error_log("Arquivo não é um upload válido: {$tmpName}");
            return false;
        }

        try {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($tmpName);
        } catch (Exception $e) {
            error_log("Erro ao detectar MIME type: " . $e->getMessage());
            return false;
        }
        
        $mapaMimesExtensao = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp',
            'image/gif'  => 'gif',
            'video/mp4'  => 'mp4',
            'video/webm' => 'webm',
        ];

        if (!in_array($mime, $tiposPermitidos, true) || !isset($mapaMimesExtensao[$mime])) {
            error_log("MIME type não permitido: {$mime}");
            return false; 
        }

        $ext = $mapaMimesExtensao[$mime];
        $nomeArquivo = 'scambus_' . uniqid('', true) . '.' . $ext;

        if (!is_dir($destinoDiretorio)) {
            if (!@mkdir($destinoDiretorio, 0755, true)) {
                error_log("Falha ao criar diretório: {$destinoDiretorio}");
                return false;
            }
        }

        $destinoFinal = rtrim($destinoDiretorio, '/') . '/' . $nomeArquivo;

        if (!move_uploaded_file($tmpName, $destinoFinal)) {
            error_log("Falha ao mover arquivo: {$tmpName}");
            return false;
        }

        @chmod($destinoFinal, 0644);
        return $nomeArquivo;
    }
}