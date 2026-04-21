<?php

/*
|--------------------------------------------------------------------------
| Classe de conexão com banco de dados
|--------------------------------------------------------------------------
| Usa PDO com prepared statements para evitar SQL Injection
|--------------------------------------------------------------------------
*/

class Banco {

    private $host;
    private $dbname;
    private $usuario;
    private $senha;

    public function __construct() {
        if ($_SERVER['HTTP_HOST'] === 'localhost' || $_SERVER['HTTP_HOST'] === '127.0.0.1') {
            // Configurações Locais (XAMPP)
            $this->host = "localhost";
            $this->dbname = "scambus_db";
            $this->usuario = "root";
            $this->senha = "";
        } else {
            // Configurações de Produção (InfinityFree)
            $this->host = "sql306.infinityfree.com";
            $this->dbname = "if0_41696045_scambus_db";
            $this->usuario = "if0_41696045";
            $this->senha = "Artur191236";
        }
    }

    public function conectar() {

        try {

            $conexao = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4",
                $this->usuario,
                $this->senha
            );

            $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // ✅ Definir timezone por sessão (funciona em hospedagem grátis)
            $conexao->query("SET time_zone = '-03:00'");

            return $conexao;

        } catch (PDOException $erro) {

            error_log("Scambus DB Error: " . $erro->getMessage());
            http_response_code(500);
            echo "<!DOCTYPE html>
<html lang='pt-BR'>
<head>
    <meta charset='UTF-8'>
    <title>Erro de Conexão</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .container {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            text-align: center;
            max-width: 400px;
        }
        h2 {
            color: #dc2626;
            margin: 0 0 1rem 0;
        }
        p {
            color: #6b7280;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class='container'>
        <h2>⚠️ Erro de Conexão</h2>
        <p>Não foi possível conectar ao banco de dados. Tente novamente em instantes.</p>
    </div>
</body>
</html>";
            exit;

        }

    }

}