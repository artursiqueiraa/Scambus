
<?php

require_once ROOT . "/nucleo/Controlador.php";
require_once "../app/modelos/Servico.php";

class ControladorHome extends Controlador {

    public function index() {

        $servicoModel = new Servico();

        $servicos = $servicoModel->listar();

        $this->view('home/inicio', get_defined_vars());

    }

}
