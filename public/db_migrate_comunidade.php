<?php
require_once "configuracao/banco.php";

$banco = new Banco();
$conexao = $banco->conectar();

try {
    $sql1 = "ALTER TABLE comunidade_posts ADD COLUMN servico_id INT NULL DEFAULT NULL AFTER usuario_id;";
    $conexao->exec($sql1);
    echo "Coluna servico_id adicionada.\n";
} catch(PDOException $e) {
    echo "Erro/Aviso servico_id: " . $e->getMessage() . "\n";
}

try {
    $sql2 = "ALTER TABLE comunidade_posts ADD CONSTRAINT fk_cp_servico FOREIGN KEY (servico_id) REFERENCES servicos(id) ON DELETE SET NULL;";
    $conexao->exec($sql2);
    echo "FK fk_cp_servico adicionada.\n";
} catch(PDOException $e) {
    echo "Erro/Aviso fk_cp_servico: " . $e->getMessage() . "\n";
}

try {
    $sql3 = "ALTER TABLE comunidade_posts ADD COLUMN tipo_post ENUM('OFERECENDO','PROCURANDO','DICA') DEFAULT 'DICA' AFTER texto;";
    $conexao->exec($sql3);
    echo "Coluna tipo_post adicionada.\n";
} catch(PDOException $e) {
    echo "Erro/Aviso tipo_post: " . $e->getMessage() . "\n";
}

echo "Migracao finalizada.\n";
