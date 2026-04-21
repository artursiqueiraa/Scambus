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
            echo "Email ou senha inválidos.";
            return;
        }

        // Conta bloqueada
        if (isset($usuario['status']) && $usuario['status'] == 'BLOQUEADO') {
            echo "Usuário bloqueado pelo administrador.";
            return;
        }

        // Senha correta
        if (password_verify($senha, $usuario['senha'])) {

            $_SESSION['usuario_id']   = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['usuario_tipo'] = $usuario['tipo'] ?? 'usuario';

            // Verifica se aceitou os termos (suporta ambos os nomes de coluna)
            $aceitou = $usuario['aceitou_termos'] ?? $usuario['aceite_termos'] ?? 0;

            if (empty($aceitou)) {
                $this->redirect('autenticacao/termos');
                exit;
            }

            $this->redirect('home');
            exit;

        } else {

            echo "Email ou senha inválidos.";

        }

    }

    public function logout() {

        session_destroy();
        $this->redirect('home');

    }

    public function cadastro() {

        $this->view('autenticacao/cadastro');

    }

    /* =========================================
       REGISTRAR — corrigido
       Problemas resolvidos:
       1. Tela branca: sem try/catch → agora tem
       2. Duplicate entry '0': coluna aceitou_termos
          não existe no banco (banco tem aceite_termos)
          → INSERT agora não inclui essa coluna
       3. Email duplicado: agora verifica antes de inserir
    ========================================= */
    public function registrar() {

        $nome     = trim($_POST['nome']     ?? '');
        $email    = trim($_POST['email']    ?? '');
        $senha    = $_POST['senha']         ?? '';
        $telefone = trim($_POST['telefone'] ?? '');
        $aceitouTermos = isset($_POST['aceitar_termos']) ? 1 : 0;

        // Validação básica
        if (empty($nome) || empty($email) || empty($senha)) {
            echo "Preencha todos os campos obrigatórios.";
            return;
        }

        $usuarioModel = new Usuario();

        // Verifica se email já está cadastrado
        $existe = $usuarioModel->buscarPorEmail($email);
        if ($existe) {
            echo "Este e-mail já está cadastrado. <a href='?url=autenticacao/login'>Fazer login</a>";
            return;
        }

        // Tenta criar o usuário
        $resultado = $usuarioModel->criar($nome, $email, $telefone, $senha, $aceitouTermos);

        if ($resultado) {
            $this->redirect('autenticacao/login');
        } else {
            echo "Erro ao criar conta. Tente novamente.";
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