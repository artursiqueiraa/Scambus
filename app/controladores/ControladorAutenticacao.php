<?php

require_once "../app/modelos/Usuario.php";

class ControladorAutenticacao extends Controlador {

    public function login() {
        $this->view('autenticacao/login');
    }

    public function autenticar() {

        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';

        $usuarioModel = new Usuario();
        $usuario = $usuarioModel->buscarPorEmail($email);

        // Usuário não encontrado
        if (!$usuario) {
            $_SESSION['erro_login'] = 'Email ou senha inválidos.';
            $this->redirect('autenticacao/login');
            return;
        }

        // Usuário bloqueado
        if (isset($usuario['status']) && $usuario['status'] == 'BLOQUEADO') {
            $_SESSION['erro_login'] = 'Esta conta foi bloqueada pelo administrador.';
            $this->redirect('autenticacao/login');
            return;
        }

        // Senha correta
        if (password_verify($senha, $usuario['senha'])) {

            $_SESSION['usuario_id']   = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['usuario_tipo'] = $usuario['tipo'] ?? 'usuario';

            // Verifica aceite dos termos — compatível com ambas as colunas
            $aceitou = $usuario['aceite_termos'] ?? $usuario['aceitou_termos'] ?? 0;

            if (empty($aceitou)) {
                $this->redirect('autenticacao/termos');
                exit;
            }

            $this->redirect('home');
            exit;
        }

        // Senha errada
        $_SESSION['erro_login'] = 'Email ou senha inválidos.';
        $this->redirect('autenticacao/login');
    }

    public function logout() {
        session_destroy();
        $this->redirect('home');
    }

    public function cadastro() {
        $this->view('autenticacao/cadastro');
    }

    public function registrar() {

        $nome         = trim($_POST['nome']   ?? '');
        $email        = trim($_POST['email']  ?? '');
        $senha        = $_POST['senha']        ?? '';
        $telefone     = trim($_POST['telefone'] ?? '');
        $aceitouTermos = isset($_POST['aceitar_termos']) ? 1 : 0;

        if (empty($nome) || empty($email) || empty($senha)) {
            $_SESSION['erro_cadastro'] = 'Preencha todos os campos obrigatórios.';
            $this->redirect('autenticacao/cadastro');
            return;
        }

        $usuarioModel = new Usuario();

        // Verifica email duplicado
        $jaExiste = $usuarioModel->buscarPorEmail($email);
        if ($jaExiste) {
            $_SESSION['erro_cadastro'] = 'Este email já está cadastrado.';
            $this->redirect('autenticacao/cadastro');
            return;
        }

        $resultado = $usuarioModel->criar($nome, $email, $telefone, $senha, $aceitouTermos);

        if ($resultado) {
            // Busca o novo usuário para pegar o ID
            $novoUsuario = $usuarioModel->buscarPorEmail($email);
            if ($novoUsuario) {
                // ✅ Bônus de boas-vindas: 50 SCoins
                require_once "../app/modelos/Scoin.php";
                $scoin = new Scoin();
                $scoin->creditarBoasVindas($novoUsuario['id'], 50, 'Bônus de boas-vindas Scambus 🎉');
            }
            $_SESSION['sucesso_cadastro'] = 'Conta criada com sucesso! Você ganhou 50 SCoins de boas-vindas 🎉';
            $this->redirect('autenticacao/login');
        } else {
            $_SESSION['erro_cadastro'] = 'Ocorreu um erro ao criar sua conta. Tente novamente.';
            $this->redirect('autenticacao/cadastro');
        }
    }

    /* =========================================
       TELA DE ACEITE DE TERMOS (pós-login)
    ========================================= */
    public function termos() {

        if (!isset($_SESSION['usuario_id'])) {
            $this->redirect('autenticacao/login');
            exit;
        }

        $this->view('autenticacao/aceitar_termos');
    }

    public function aceitarTermos() {

        if (!isset($_SESSION['usuario_id'])) {
            $this->redirect('autenticacao/login');
            exit;
        }

        $usuarioModel = new Usuario();
        $usuarioModel->aceitarTermos($_SESSION['usuario_id']);

        $this->redirect('home');
        exit;
    }

}
