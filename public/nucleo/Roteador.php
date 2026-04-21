<?php

class Roteador {

    public function iniciar() {

        $url = $_GET['url'] ?? 'home';

        $url = filter_var($url, FILTER_SANITIZE_URL);

        $partes = explode('/', $url);

        $controlador = "Controlador" . ucfirst($partes[0]);

        $arquivoControlador = "../app/controladores/" . $controlador . ".php";

        if (file_exists($arquivoControlador)) {

            require_once $arquivoControlador;

            if (class_exists($controlador)) {

                $obj = new $controlador();

                $metodo = $partes[1] ?? "index";

                if (method_exists($obj, $metodo)) {

                    $parametros = array_slice($partes, 2);

                    call_user_func_array([$obj, $metodo], $parametros);

                } else {

                    echo "Método não encontrado.";

                }

            }

        } else {

            echo "Página não encontrada.";

        }

    }

}