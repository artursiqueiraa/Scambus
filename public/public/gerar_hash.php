<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerador de Hash Scambus</title>
    <style>
        body { font-family: sans-serif; background: #f4f7f6; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); width: 100%; max-width: 500px; }
        h2 { color: #1e8e3e; margin-top: 0; }
        input { width: 100%; padding: 0.8rem; margin: 1rem 0; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; font-size: 1rem; }
        button { background: #1e8e3e; color: white; border: none; padding: 0.8rem 1.5rem; border-radius: 4px; cursor: pointer; width: 100%; font-size: 1rem; font-weight: bold; }
        .result { background: #e6f4ea; padding: 1rem; border-left: 4px solid #1e8e3e; margin-top: 1.5rem; font-family: monospace; word-break: break-all; font-size: 0.9rem; }
        .warning { color: #d93025; font-size: 0.8rem; margin-top: 1rem; text-align: center; }
    </style>
</head>
<body>

<div class="card">
    <h2>🛠️ Gerador de Senha</h2>
    <p>Digite a nova senha que você deseja usar no admin:</p>
    
    <form method="POST">
        <input type="text" name="password" placeholder="Sua nova senha aqui..." required>
        <button type="submit">Gerar Comando SQL</button>
    </form>

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['password'])): 
        $password = $_POST['password'];
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $email = 'teste02@email.com';
    ?>
        <div class="result">
            <strong>SQL para rodar no phpMyAdmin:</strong><br><br>
            UPDATE usuarios SET senha = '<?= $hash ?>' WHERE email = '<?= $email ?>';
        </div>
        
        <p class="warning">⚠️ Copie o comando acima, rode no seu banco de dados e delete este arquivo em seguida!</p>
    <?php endif; ?>
</div>

</body>
</html>
