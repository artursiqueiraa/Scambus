<?php
$_SERVER['HTTP_HOST'] = 'localhost';
require 'configuracao/banco.php';

$b = new Banco();
$c = $b->conectar();

$updates = [
    16 => 'service_16.png',
    17 => 'service_17.png',
    18 => 'service_18.png',
    19 => 'service_19.png',
    20 => 'service_20.png'
];

echo "Vinculando imagens aos serviços...\n";

foreach ($updates as $id => $foto) {
    // Limpa se já existir (limpeza preventiva)
    $c->prepare("DELETE FROM servico_fotos WHERE servico_id = :id")->execute(['id' => $id]);
    
    // Insere novo vínculo
    $sql = "INSERT INTO servico_fotos (servico_id, caminho_foto) VALUES (:id, :foto)";
    $stmt = $c->prepare($sql);
    $stmt->execute(['id' => $id, 'foto' => $foto]);
    
    echo "Serviço #{$id} vinculado à imagem {$foto}\n";
}

echo "Associação de fotos concluída para os 5 primeiros serviços.\n";
