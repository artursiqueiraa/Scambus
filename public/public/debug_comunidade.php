<?php
/*
|--------------------------------------------------------------------------
| Script de DEBUG da Comunidade
|--------------------------------------------------------------------------
*/
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🔍 Debug Scambus - Comunidade</h1>";

try {
    echo "<p>1. Verificando sessão...</p>";
    session_start();
    if (!isset($_SESSION['usuario_id'])) {
        echo "<p>⚠️ Usuário não logado. Simulando ID 1 para teste.</p>";
        $user_id = 1;
    } else {
        $user_id = $_SESSION['usuario_id'];
    }

    echo "<p>2. Tentando carregar o Banco...</p>";
    require_once __DIR__ . '/../configuracao/banco.php';
    $banco = new Banco();
    $conexao = $banco->conectar();
    echo "<p>✅ Conexão OK!</p>";

    echo "<p>3. Tentando carregar o Modelo Comunidade...</p>";
    require_once __DIR__ . '/../app/modelos/Comunidade.php';
    $comunidadeModel = new Comunidade();
    echo "<p>✅ Modelo carregado!</p>";

    echo "<p>4. Executando query listarPosts...</p>";
    // Simulando a chamada do controlador
    $posts = $comunidadeModel->listarPosts(null, $user_id);
    echo "<p>✅ Query listarPosts retornou " . count($posts) . " posts.</p>";
    
    echo "<pre>";
    print_r(array_slice($posts, 0, 1));
    echo "</pre>";

    echo "<p>5. Tentando carregar as Views...</p>";
    // Aqui não vamos carregar o cabeçalho/rodape para não misturar HTML, 
    // apenas verificar se os arquivos existem.
    $files = [
        '../app/views/comunidade/index.php',
        '../app/views/layout/cabecalho.php',
        '../app/views/layout/rodape.php'
    ];
    foreach($files as $f) {
        if(file_exists(__DIR__ . '/' . $f)) {
            echo "<p>✅ Arquivo $f existe.</p>";
        } else {
            echo "<p>❌ ARQUIVO $f NÃO ENCONTRADO!</p>";
        }
    }

    echo "<h3>🎉 Tudo parece OK no backend! Se a página continua branca, o erro pode estar dentro da View index.php</h3>";

} catch (Exception $e) {
    echo "<div style='background:#fee; padding:20px; border:2px solid red;'>";
    echo "<h2>❌ ERRO FATAL ENCONTRADO:</h2>";
    echo "<p><strong>Mensagem:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>Arquivo:</strong> " . $e->getFile() . "</p>";
    echo "<p><strong>Linha:</strong> " . $e->getLine() . "</p>";
    echo "</div>";
} catch (Error $e) {
    echo "<div style='background:#fee; padding:20px; border:2px solid red;'>";
    echo "<h2>❌ ERRO DE SINTAXE/LÓGICA:</h2>";
    echo "<p><strong>Mensagem:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>Arquivo:</strong> " . $e->getFile() . "</p>";
    echo "<p><strong>Linha:</strong> " . $e->getLine() . "</p>";
    echo "</div>";
}
