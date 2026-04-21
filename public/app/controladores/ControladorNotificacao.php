<?php

require_once "../app/modelos/Notificacao.php";

class ControladorNotificacao {

    public function listar(){

        if(empty($_SESSION['usuario_id'])){
            header("Location: ?url=autenticacao/login");
            exit;
        }

        $usuario_id = $_SESSION['usuario_id'];
        $model = new Notificacao();

        // Ao listar, podemos opcionalmente marcar tudo como lido, 
        // mas o usuário pediu para "sumir ao clicar no serviço", então não marcaremos aqui.
        $notificacoes = $model->listarPorUsuario($usuario_id);

        require_once "../app/views/layout/cabecalho.php";
        require_once "../app/views/notificacoes/listar.php";
        require_once "../app/views/layout/rodape.php";

    }

    /* =========================================
       API: BUSCAR TOTAL NÃO LIDAS (JSON)
    ========================================= */
    public function api_contar() {
        if(empty($_SESSION['usuario_id'])){
            echo json_encode(['total' => 0]);
            return;
        }

        $model = new Notificacao();
        $total = $model->contarNaoLidas($_SESSION['usuario_id']);
        echo json_encode(['total' => $total]);
    }

    /* =========================================
       API: LISTAR RECENTES (JSON)
    ========================================= */
    public function api_listar() {
        if(empty($_SESSION['usuario_id'])){
            echo json_encode([]);
            return;
        }

        $model = new Notificacao();
        $notificacoes = $model->listarPorUsuario($_SESSION['usuario_id']);
        echo json_encode($notificacoes);
    }

    /* =========================================
       MARCAR COMO LIDA E REDIRECIONAR
    ========================================= */
    public function abrir($id) {
        if(empty($_SESSION['usuario_id'])){
            header("Location: ?url=autenticacao/login");
            exit;
        }

        $model = new Notificacao();
        // Buscar a notificação primeiro para pegar o link
        $notif = null;
        $todas = $model->listarPorUsuario($_SESSION['usuario_id']);
        foreach($todas as $n) {
            if($n['id'] == $id) {
                $notif = $n;
                break;
            }
        }

        if($notif) {
            $model->marcarComoLida($id);
            header("Location: " . $notif['link']);
        } else {
            header("Location: ?url=notificacao/listar");
        }
        exit;
    }

}
