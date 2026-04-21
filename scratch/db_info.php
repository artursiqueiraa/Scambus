<?php
require 'configuracao/banco.php';
$b = new Banco();
$c = $b->conectar();
$u = $c->query('SELECT id, nome FROM usuarios')->fetchAll(PDO::FETCH_ASSOC);
$cat = $c->query('SELECT id, nome FROM categorias')->fetchAll(PDO::FETCH_ASSOC);
echo json_encode(['users' => $u, 'categories' => $cat]);
