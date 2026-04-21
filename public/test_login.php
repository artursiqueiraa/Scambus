<?php
require_once "configuracao/banco.php";
$banco = new Banco();
$conexao = $banco->conectar();
$stmt = $conexao->prepare("SELECT email FROM usuarios LIMIT 1");
$stmt->execute();
$user = $stmt->fetch();

if ($user) {
    // Redefine a senha para 123456 para podermos logar e testar
    $senha_hash = password_hash('123456', PASSWORD_DEFAULT);
    $stmt2 = $conexao->prepare("UPDATE usuarios SET senha = :senha WHERE email = :email");
    $stmt2->execute(['senha' => $senha_hash, 'email' => $user['email']]);
    echo "Email: " . $user['email'] . "\nSenha: 123456\n";
} else {
    echo "Nenhum usuario encontrado.\n";
}
