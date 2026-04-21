<?php

require_once "../app/modelos/Servico.php";
require_once "../nucleo/Sessao.php";

class ControladorServico extends Controlador {

    // Proteção via $this->auth()

    public function criar(){
        $this->auth();
        require_once "../app/views/layout/cabecalho.php";
        require_once "../app/views/servicos/criar.php";
        require_once "../app/views/layout/rodape.php";
    }

    public function salvar(){
        $this->auth();
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('servico/criar');
            return;
        }
        require_once "../nucleo/Seguranca.php";
        if(!Seguranca::validarCsrf($_POST['csrf_token'] ?? '')){
            $_SESSION['erro_flash'] = 'Sessão expirada. Tente novamente.';
            $this->redirect('servico/criar');
            return;
        }

        $usuario_id = $_SESSION['usuario_id'];

        $categoria = $_POST['categoria_id'];

        $titulo = $_POST['titulo'];
        $oferece = $_POST['oferece'];
        $aceita = $_POST['aceita'];

        $fotoNome = null;

        if(!empty($_FILES['foto']['tmp_name'])){
            require_once "../nucleo/Seguranca.php";
            $uploadDir = ROOT . '/uploads/servicos/';
            if (!is_dir($uploadDir)) @mkdir($uploadDir, 0755, true);
            $fotoNome = Seguranca::uploadSeguro($_FILES['foto']['tmp_name'], $uploadDir, ['image/jpeg', 'image/png', 'image/webp']);
            if (!$fotoNome) { $fotoNome = null; }
        }

        $servico = new Servico();

        // ✅ CORREÇÃO: Captura o ID DIRETAMENTE do método criar()
        $servico_id = $servico->criar($usuario_id,$categoria,$titulo,$oferece,$aceita,$fotoNome);

        // ✅ VALIDAÇÃO: Verifica se o ID é válido
        if (!$servico_id || $servico_id == 0) {
            error_log("ERRO: Serviço criado mas sem ID válido. ID retornado: " . $servico_id);
            $_SESSION['erro_flash'] = 'Erro ao criar serviço. Tente novamente.';
            $this->redirect('servico/criar');
            return;
        }

        // 🔥 SALVAR VÁRIAS IMAGENS
        if(!empty($_FILES['fotos']['tmp_name'][0])){
            require_once "../nucleo/Seguranca.php";
            $uploadDir = ROOT . '/uploads/servicos/';
            if (!is_dir($uploadDir)) @mkdir($uploadDir, 0755, true);
            $conexao = $servico->getConexao();
            
            foreach($_FILES['fotos']['tmp_name'] as $key => $tmp_name){
                if(empty($tmp_name)) continue;
                $nomeArquivo = Seguranca::uploadSeguro($tmp_name, $uploadDir, ['image/jpeg', 'image/png', 'image/webp']);
                
                if($nomeArquivo){

                $sql = "INSERT INTO servico_fotos (servico_id, caminho_foto)
                        VALUES (:servico, :foto)";

                $stmt = $conexao->prepare($sql);

                $stmt->bindParam(":servico", $servico_id, PDO::PARAM_INT);
                $stmt->bindParam(":foto", $nomeArquivo);

                $stmt->execute();
                } // fecha if($nomeArquivo)
            }
        }

        // 🔥 Redireciona para a página do serviço após salvar
        $_SESSION['sucesso_flash'] = 'Serviço criado com sucesso! 🎉';
        $this->redirect('servico/ver/'.$servico_id);

    }


    public function ver($id){

        $servicoModel = new Servico();

        $servico = $servicoModel->buscarPorId($id);

        // 🔥 NOVO
        $fotos = $servicoModel->buscarFotos($id);

        require_once "../app/views/layout/cabecalho.php";
        require_once "../app/views/servicos/ver.php";
        require_once "../app/views/layout/rodape.php";

    }

    public function editar($id){
        $this->auth();
        $servicoModel = new Servico();

        $servico = $servicoModel->buscarPorId($id);

        /*
        verifica se serviço existe
        */

        if(!$servico){

            echo "Serviço não encontrado.";
            return;

        }

        /*
        proteção de segurança
        somente dono pode editar
        */

        if($servico['usuario_id'] != $_SESSION['usuario_id']){

            echo "Você não tem permissão para editar este serviço.";
            return;

        }

        require_once "../app/views/layout/cabecalho.php";
        require_once "../app/views/servicos/editar.php";
        require_once "../app/views/layout/rodape.php";

    }




    /*
    PROPOR TROCA — Redireciona para ControladorTroca::propor
    que agora possui o fluxo completo com Escrow e anti-fraude
    */
    public function proporTroca($servico_id){

        $this->redirect('troca/propor/' . $servico_id);

    }


    public function listar(){

        $model = new Servico();

        $servicos = $model->listarTodos();

        require_once "../app/views/layout/cabecalho.php";
        require_once "../app/views/servicos/listar.php";
        require_once "../app/views/layout/rodape.php";

    }


    public function buscar(){

        $termo = $_GET['q'] ?? '';

        $servicoModel = new Servico();

        $servicos = $servicoModel->buscar($termo);

        require_once "../app/views/layout/cabecalho.php";
        require_once "../app/views/servicos/listar.php";
        require_once "../app/views/layout/rodape.php";

    }


    public function categoria($id){

        $servicoModel = new Servico();

        $servicos = $servicoModel->listarPorCategoria($id);

        require_once "../app/views/layout/cabecalho.php";
        require_once "../app/views/servicos/listar.php";
        require_once "../app/views/layout/rodape.php";

    }

    public function status($id){

        $servicoModel = new Servico();

        $servico = $servicoModel->buscarPorId($id);

        if(!$servico){

            echo "Serviço não encontrado.";
            return;

        }

        /*
        proteção: somente dono
        */

        if($servico['usuario_id'] != $_SESSION['usuario_id']){

            echo "Acesso negado.";
            return;

        }

        /*
        alterna status
        */

        $novoStatus = ($servico['status'] == 'ATIVO') ? 'INATIVO' : 'ATIVO';

        $servicoModel->alterarStatus($id,$novoStatus);

        $this->redirect('servico/ver/'.$id);

    }


    public function atualizar(){
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('servico/meus');
            return;
        }
        require_once "../nucleo/Seguranca.php";
        if(!Seguranca::validarCsrf($_POST['csrf_token'] ?? '')){
            $_SESSION['erro_flash'] = 'Sessão expirada. Tente novamente.';
            $this->redirect('servico/meus');
            return;
        }

        $id = $_POST['id'];

        $servicoModel = new Servico();

        /*
        buscar serviço
        */

        $servico = $servicoModel->buscarPorId($id);

        /*
        verifica se serviço existe
        */

        if(!$servico){

            echo "Serviço não encontrado.";
            return;

        }

        /*
        proteção de segurança
        somente dono pode editar
        */

        if($servico['usuario_id'] != $_SESSION['usuario_id']){

            echo "Acesso negado.";
            return;

        }

        $categoria = $_POST['categoria_id'];
        $titulo = $_POST['titulo'];
        $oferece = $_POST['oferece'];
        $aceita = $_POST['aceita'];

        $fotoNome = null;

        if(!empty($_FILES['foto']['tmp_name'])){
            require_once "../nucleo/Seguranca.php";
            $uploadDir = ROOT . '/uploads/servicos/';
            if (!is_dir($uploadDir)) @mkdir($uploadDir, 0755, true);
            $nomeArq = Seguranca::uploadSeguro($_FILES['foto']['tmp_name'], $uploadDir, ['image/jpeg', 'image/png', 'image/webp']);
            if($nomeArq) {
                $fotoNome = $nomeArq;
            }
        }

        $servicoModel->atualizar(
            $id,
            $categoria,
            $titulo,
            $oferece,
            $aceita,
            $fotoNome
        );

        $this->redirect('servico/ver/'.$id);

    }

    public function favorito($id){
        $this->auth();
        $usuario = $_SESSION['usuario_id'];

        $servicoModel = new Servico();

        $servicoModel->favoritar($usuario,$id);

        $this->redirect('servico/ver/'.$id);

    }


    public function meus(){

        $this->auth();

        $model = new Servico();

        $servicos = $model->listarPorUsuario($_SESSION['usuario_id']);

        require_once "../app/views/layout/cabecalho.php";
        require_once "../app/views/servicos/meus.php";
        require_once "../app/views/layout/rodape.php";
    }


    public function alterarStatus($id, $status)
    {
        require_once "../nucleo/Seguranca.php";
        if($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET'){
            if(isset($_POST['csrf_token']) || isset($_GET['csrf_token'])) {
                $token = $_POST['csrf_token'] ?? $_GET['csrf_token'] ?? '';
                if(!Seguranca::validarCsrf($token)){
                    die("CSRF detectado na tentativa de status.");
                }
            }
        }
        
        require_once "../app/modelos/Servico.php";

        $servico = new Servico();

        // Segurança: só dono pode alterar
        $dados = $servico->buscarPorId($id);

        if($dados['usuario_id'] != $_SESSION['usuario_id']){
            die("Acesso negado");
        }

        $servico->alterarStatus($id, $status);

        $this->redirect('servico/ver/'.$id);
    }


    public function excluir($id)
    {
        $this->auth();
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once "../nucleo/Seguranca.php";
            if(!Seguranca::validarCsrf($_POST['csrf_token'] ?? '')){
                $_SESSION['erro_flash'] = 'Sessão expirada. Tente novamente.';
                $this->redirect('servico/meus');
                return;
            }
        }
        
        require_once "../app/modelos/Servico.php";

        $servico = new Servico();

        // Segurança
        $dados = $servico->buscarPorId($id);

        if($dados['usuario_id'] != $_SESSION['usuario_id']){
            die("Acesso negado");
        }

        $servico->excluir($id);

        $this->redirect('servico/meus');
    }


}