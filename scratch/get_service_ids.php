<?php
$_SERVER['HTTP_HOST'] = 'localhost';
require 'configuracao/banco.php';
$b = new Banco();
$c = $b->conectar();
$res = $c->query('SELECT id, titulo FROM servicos')->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($res);
