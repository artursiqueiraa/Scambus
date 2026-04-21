
<?php

/*
|--------------------------------------------------------------------------
| Classe de conexão com banco de dados
|--------------------------------------------------------------------------
| Essa classe será usada por todos os modelos para acessar o MySQL.
| Usamos PDO porque ele permite prepared statements, que evitam
| ataques de SQL Injection.
*/

class Banco {

    private $host;
    private $dbname;
    private $usuario;
    private $senha;

    public function __construct() {
        if ($_SERVER['HTTP_HOST'] === 'localhost' || $_SERVER['HTTP_HOST'] === '127.0.0.1') {
            // Configurações Locais (seu XAMPP)
            $this->host = "localhost";
            $this->dbname = "scambus_db";
            $this->usuario = "root";
            $this->senha = "";
        } else {
            // Configurações de Produção (InfinityFree)
            // IMPORTANTE: Preencha aqui com os dados do painel do InfinityFree
            $this->host = "sql306.infinityfree.com"; // Veja no Painel > MySQL Databases
            $this->dbname = "if0_41696045_scambus_db"; // Nome que você criou no painel
            $this->usuario = "if0_41696045";       // Seu usuário do painel
            $this->senha = "Artur191236";        // Mesma senha da conta
        }
    }

    public function conectar() {

        try {

            $conexao = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4",
                $this->usuario,
                $this->senha
            );

            // Faz o PDO mostrar erros caso aconteçam
            $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $conexao;

        } catch (PDOException $erro) {

            error_log("Scambus DB Error: " . $erro->getMessage());
            http_response_code(500);
            echo "<!DOCTYPE html><html lang='pt-BR'><head><meta charset='UTF-8'><title>Erro</title></head><body style='font-family:sans-serif;display:flex;align-items:center;justify-content:center;height:100vh;margin:0;background:#f9fafb'><div style='text-align:center;padding:2rem'><h2 style='color:#dc2626'>⚠️ Erro Interno</h2><p style='color:#6b7280'>Não foi possível conectar ao banco de dados. Tente novamente em instantes.</p></div></body></html>";
            exit;

        }

    }

}