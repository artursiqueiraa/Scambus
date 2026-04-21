<?php
$_SERVER['HTTP_HOST'] = 'localhost';
require 'configuracao/banco.php';
$b = new Banco();
$c = $b->conectar();
$u = $c->query("SELECT id, nome, email, tipo FROM usuarios WHERE tipo = 'ADMIN' OR id = 1")->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($u);
