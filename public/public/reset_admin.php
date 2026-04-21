<?php
/*
|--------------------------------------------------------------------------
| Resetador de Senha Admin - Scambus
|--------------------------------------------------------------------------
| Este script redefine a senha da conta administrativa.
| Como usar:
| 1. Suba este arquivo para a pasta 'public' do seu servidor.
| 2. Acesse via navegador: seudominio.com/public/reset_admin.php
| 3. REMOVA O ARQUIVO IMEDIATAMENTE APÓS O USO POR SEGURANÇA.
*/

// Forçar conexão local se rodar via CLI, ou usar configuração padrão no host
if (php_sapi_name() === 'cli') {
    $_SERVER['HTTP_HOST'] = 'localhost';
}

require_once __DIR__ . '/../configuracao/banco.php';

$nova_senha = 'admin123'; // <--- A senha que você quer definir
$email_admin = 'teste02@email.com'; // <--- O email da conta admin (encontrado: teste02@email.com)

try {
    $banco = new Banco();
    $conexao = $banco->conectar();

    $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);

    $sql = "UPDATE usuarios SET senha = :senha, tipo = 'admin' WHERE email = :email";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':senha', $senha_hash);
    $stmt->bindParam(':email', $email_admin);
    
    if ($stmt->execute()) {
        echo "✅ SENHA ATUALIZADA COM SUCESSO!\n\n";
        echo "Email: " . $email_admin . "\n";
        echo "Nova Senha: " . $nova_senha . "\n\n";
        echo "⚠️ IMPORTANTE: Remova este script do servidor agora!";
    } else {
        echo "❌ ERRO ao atualizar a senha.";
    }

} catch (Exception $e) {
    echo "❌ ERRO: " . $e->getMessage();
}
