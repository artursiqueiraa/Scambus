<?php
class ControladorInstitucional {

    public function ajuda() {
        require_once "../app/views/layout/cabecalho.php";
        require_once "../app/views/institucional/ajuda.php";
        require_once "../app/views/layout/rodape.php";
    }

    public function termos() {
        require_once "../app/views/layout/cabecalho.php";
        require_once "../app/views/institucional/termos.php";
        require_once "../app/views/layout/rodape.php";
    }

    public function privacidade() {
        require_once "../app/views/layout/cabecalho.php";
        require_once "../app/views/institucional/privacidade.php";
        require_once "../app/views/layout/rodape.php";
    }

    public function projeto() {
        require_once "../app/views/layout/cabecalho.php";
        require_once "../app/views/institucional/projeto.php";
        require_once "../app/views/layout/rodape.php";
    }

    public function documentacao() {
        // Esta página possui layout próprio de dashboard, não utiliza cabeçalho padrão
        require_once "../app/views/institucional/documentacao_sistema.php";
    }

}
