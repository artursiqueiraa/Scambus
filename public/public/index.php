<?php

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
| Inicia sessão do sistema
|--------------------------------------------------------------------------
*/
session_start();

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
require_once "../nucleo/Roteador.php";

/*
|--------------------------------------------------------------------------
| Inicia o roteador
|--------------------------------------------------------------------------
*/

$roteador = new Roteador();
$roteador->iniciar();