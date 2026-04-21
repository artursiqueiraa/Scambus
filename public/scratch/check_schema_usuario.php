<?php
$_SERVER['HTTP_HOST'] = 'localhost';
require 'configuracao/banco.php';
$b = new Banco();
$c = $b->conectar();
$desc = $c->query('DESCRIBE usuarios')->fetchAll(PDO::FETCH_ASSOC);
foreach($desc as $row) {
    echo $row['Field'] . " (" . $row['Type'] . ")\n";
}
