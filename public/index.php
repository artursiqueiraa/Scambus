<?php

// Inicia o buffer de saída para evitar erros de 'headers already sent'
ob_start();

// Configura sessão ANTES de iniciar (mais robusto no InfinityFree)
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_samesite', 'Lax');
ini_set('session.gc_maxlifetime', 3600);
ini_set('session.cookie_lifetime', 3600);

// Inicia a sessão imediatamente no topo
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/*
|--------------------------------------------------------------------------
| Definições Globais do Scambus
|--------------------------------------------------------------------------
*/
/*
|--------------------------------------------------------------------------
| Definições Globais do Scambus
|--------------------------------------------------------------------------
*/
define('ROOT', dirname(__DIR__));

// Detecta a URL base dinamicamente (Local ou Produção)
$protocolo = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];

// Caminho para o diretório public
$script_name = $_SERVER['SCRIPT_NAME']; // e.g. /scambus/public/index.php ou /public/index.php
$public_path = str_replace('/index.php', '', $script_name);

// Caminho para a raiz do projeto (onde fica uploads e public)
$root_path = dirname($public_path);
if ($root_path === DIRECTORY_SEPARATOR || $root_path === '.') {
    $root_path = '';
}

// Garante que não haja barras sobrando ou faltantes
$root_path = rtrim($root_path, '/\\');

define('BASE_URL', $protocolo . "://" . $host . $root_path);
define('APP_URL', $protocolo . "://" . $host . $public_path);

/*
|--------------------------------------------------------------------------
| Configurações de Erro
|--------------------------------------------------------------------------
*/
if ($_SERVER['HTTP_HOST'] === 'localhost' || $_SERVER['HTTP_HOST'] === '127.0.0.1') {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
    ini_set('log_errors', 1);
    ini_set('error_log', ROOT . '/logs/php_errors.log');
}

/*
|--------------------------------------------------------------------------
| Garante que pastas de upload existem
|--------------------------------------------------------------------------
*/
$uploadDirs = [
    ROOT . '/uploads/servicos',
    ROOT . '/uploads/comunidade',
    ROOT . '/uploads/perfis',
    ROOT . '/uploads/icons',
    ROOT . '/logs',
];
foreach ($uploadDirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

/*
|--------------------------------------------------------------------------
| Cabecalhos de Segurança
|--------------------------------------------------------------------------
*/
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');

/*
|--------------------------------------------------------------------------
| Carrega arquivos principais
|--------------------------------------------------------------------------
*/

require_once "../configuracao/banco.php";
require_once "../nucleo/Seguranca.php";
require_once "../nucleo/Controlador.php";
require_once "../nucleo/Roteador.php";

/*
|--------------------------------------------------------------------------
| Inicia o roteador
|--------------------------------------------------------------------------
*/

$roteador = new Roteador();
$roteador->iniciar();