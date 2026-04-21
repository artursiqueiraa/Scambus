<?php

class Seguranca {

    // Gera um token e o armazena na sessão
    public static function csrfToken() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    // Gera o campo oculto HTML para colocar dentro de <form>
    public static function csrfCampo() {
        $token = self::csrfToken();
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
    }

    // Valida se o token enviado corresponde ao gerado
    public static function validarCsrf($tokenEnviado) {
        if (!isset($_SESSION['csrf_token']) || empty($tokenEnviado)) {
            return false;
        }
        return hash_equals($_SESSION['csrf_token'], $tokenEnviado);
    }
    
    // Upload Seguro de Arquivos Estáticos (Prevê RCE)
    public static function uploadSeguro($tmpName, $destinoDiretorio, $tiposPermitidos = ['image/jpeg', 'image/png', 'image/webp', 'video/mp4']) {
        if (!is_uploaded_file($tmpName)) {
            return false;
        }
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($tmpName);
        
        // Mapeia o MIME type real para a extensão segura correspondente
        $mapaMimesExtensao = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp',
            'video/mp4'  => 'mp4'
        ];

        // Rejeita arquivos falsificados, payloads php encapsulados ou não autorizados
        if (!in_array($mime, $tiposPermitidos, true) || !isset($mapaMimesExtensao[$mime])) {
            return false; 
        }

        $ext = $mapaMimesExtensao[$mime];
        $nomeArquivo = uniqid() . '.' . $ext;
        $destinoFinal = rtrim($destinoDiretorio, '/') . '/' . $nomeArquivo;

        if (move_uploaded_file($tmpName, $destinoFinal)) {
            return $nomeArquivo;
        }

        return false;
    }
}
