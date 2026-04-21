<?php
$_SERVER['HTTP_HOST'] = 'localhost';
require 'configuracao/banco.php';
$b = new Banco();
$c = $b->conectar();
$desc = $c->query('DESCRIBE usuarios')->fetchAll(PDO::FETCH_ASSOC);
echo "Columns in 'usuarios':\n";
foreach($desc as $row) {
    echo $row['Field'] . "\n";
}
