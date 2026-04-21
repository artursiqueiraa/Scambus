<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
echo "<h1>🔍 Debug Scambus - Comunidade</h1>";

try {
    session_start();
    require_once __DIR__ . '/../configuracao/banco.php';
    $banco = new Banco();
    $conexao = $banco->conectar();
    echo "<p>✅ Conexão Banco: OK!</p>";

    require_once __DIR__ . '/../app/modelos/Comunidade.php';
    $comunidadeModel = new Comunidade();
    echo "<p>✅ Modelo Comunidade: OK!</p>";

    $posts = $comunidadeModel->listarPosts(null, $_SESSION['usuario_id'] ?? 1);
    echo "<p>✅ Consulta SQL: OK! (Retornou " . count($posts) . " posts)</p>";
    
    echo "<h3>🎉 Backend parece saudável. O erro deve estar na View (HTML/PHP do mural).</h3>";
    
    require_once __DIR__ . '/../app/views/comunidade/index.php';

} catch (Throwable $e) {
    echo "<div style='background:#fee; padding:20px; border:2px solid red;'>";
    echo "<h2>❌ ERRO ENCONTRADO:</h2>";
    echo "<p><strong>Mensagem:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>Arquivo:</strong> " . $e->getFile() . " na linha " . $e->getLine() . "</p>";
    echo "</div>";
}
