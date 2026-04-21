<?php

require_once "../app/modelos/Usuario.php";
require_once "../app/modelos/Servico.php";
require_once "../app/modelos/Troca.php";

class ControladorAdmin extends Controlador
{

    public function dashboard()
    {
        $this->auth();
        if ($_SESSION['usuario_tipo'] != 'admin') {
            echo "Acesso restrito.";
            return;
        }

        $usuarioModel = new Usuario();
        $servicoModel = new Servico();
        $trocaModel = new Troca();

        $totalUsuarios = $usuarioModel->contarUsuarios();
        $totalServicos = $servicoModel->contarServicos();
        $totalTrocas = $trocaModel->contarTrocas();

        require_once "../app/views/layout/cabecalho.php";
        require_once "../app/views/admin/dashboard.php";
        require_once "../app/views/layout/rodape.php";
    }

    public function usuarios()
    {
        $this->auth();
        if ($_SESSION['usuario_tipo'] != 'admin') {
            echo "Acesso restrito.";
            return;
        }

        $usuarioModel = new Usuario();
        $usuarios = $usuarioModel->listarTodos();

        require_once "../app/views/layout/cabecalho.php";
        require_once "../app/views/admin/usuarios.php";
        require_once "../app/views/layout/rodape.php";
    }

    public function servicos()
    {
        $this->auth();
        if ($_SESSION['usuario_tipo'] != 'admin') {
            echo "Acesso restrito.";
            return;
        }

        $servicoModel = new Servico();
        $servicos = $servicoModel->listar();

        require_once "../app/views/layout/cabecalho.php";
        require_once "../app/views/admin/servicos.php";
        require_once "../app/views/layout/rodape.php";
    }

    /* =========================
       BLOQUEAR
    ========================= */
    public function bloquearUsuario($id)
    {

        if ($_SESSION['usuario_tipo'] != 'admin') {
            echo "Acesso restrito.";
            return;
        }

        if ($id == $_SESSION['usuario_id']) {
            echo "Você não pode bloquear seu próprio usuário.";
            return;
        }

        $usuarioModel = new Usuario();
        $usuarioModel->bloquear($id);

        header("Location: ?url=admin/usuarios");
        exit;
    }

    /* =========================
       DESBLOQUEAR
    ========================= */
    public function desbloquearUsuario($id)
    {

        if ($_SESSION['usuario_tipo'] != 'admin') {
            echo "Acesso restrito.";
            return;
        }

        $usuarioModel = new Usuario();
        $usuarioModel->desbloquear($id);

        header("Location: ?url=admin/usuarios");
        exit;
    }

    /* =========================
       EXCLUIR USUÁRIO
    ========================= */
    public function excluirUsuario($id)
    {

        if ($_SESSION['usuario_tipo'] != 'admin') {
            echo "Acesso restrito.";
            return;
        }

        if ($id == $_SESSION['usuario_id']) {
            echo "Você não pode excluir seu próprio usuário.";
            return;
        }

        $usuarioModel = new Usuario();
        $usuarioModel->excluir($id);

        header("Location: ?url=admin/usuarios");
        exit;
    }

    /* =========================
       EXCLUIR SERVIÇO
    ========================= */
    public function excluirServico($id)
    {

        if ($_SESSION['usuario_tipo'] != 'admin') {
            echo "Acesso restrito.";
            return;
        }

        $servicoModel = new Servico();
        $servicoModel->excluir($id);

        header("Location: ?url=admin/servicos");
        exit;
    }

    /* =========================
       DOCUMENTAÇÃO UML
    ========================= */
    public function documentacao()
    {
        $this->auth();
        if ($_SESSION['usuario_tipo'] != 'admin') {
            echo "Acesso restrito.";
            return;
        }

        require_once "../app/views/layout/cabecalho.php";
        require_once "../app/views/admin/documentacao.php";
        require_once "../app/views/layout/rodape.php";
    }

    /* =========================
       TRABALHO ACADÊMICO
       — Engenharia de Sistemas
    ========================= */
    public function trabalho()
    {
        $this->auth();
        if ($_SESSION['usuario_tipo'] != 'admin') {
            echo "Acesso restrito.";
            return;
        }

        // Esta view tem seu próprio HTML completo (<!DOCTYPE html>)
        // então não usa cabecalho/rodape do layout
        require_once "../app/views/admin/trabalho.php";
    }

}