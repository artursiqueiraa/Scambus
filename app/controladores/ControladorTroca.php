<?php

require_once "../app/modelos/Troca.php";
require_once "../app/modelos/Mensagem.php";
require_once "../app/modelos/Servico.php";

class ControladorTroca extends Controlador {

    /* ============================
       MINHAS TROCAS
    ============================ */
    public function minhas(){

        $this->auth();

        $usuario_id = $_SESSION['usuario_id'];

        $trocaModel = new Troca();
        $trocas = $trocaModel->listarPorUsuario($usuario_id);

        require_once "../app/views/layout/cabecalho.php";
        require_once "../app/views/trocas/minhas.php";
        require_once "../app/views/layout/rodape.php";
    }

    /* ============================
       PROPOR TROCA (com Escrow)
    ============================ */
    public function propor($servico_id){

        $this->auth();

        require_once "../app/modelos/Scoin.php";
        require_once "../app/modelos/Notificacao.php";

        $usuario_id = $_SESSION['usuario_id'];

        $servicoModel = new Servico();
        $servico = $servicoModel->buscarPorId($servico_id);

        if(!$servico){
            $_SESSION['erro_flash'] = 'Serviço não encontrado.';
            $this->redirect('servico/listar');
            return;
        }

        if($servico['usuario_id'] == $usuario_id){
            $_SESSION['erro_flash'] = 'Você não pode propor troca para seu próprio serviço.';
            $this->redirect('servico/ver/' . $servico_id);
            return;
        }

        $trocaModel = new Troca();
        $trocasHoje = $trocaModel->contarTrocasHoje($usuario_id);
        if($trocasHoje >= 10){
            $_SESSION['erro_flash'] = 'Você atingiu o limite de 10 propostas de troca por dia.';
            $this->redirect('servico/ver/' . $servico_id);
            return;
        }

        $valor_scoins = isset($servico['valor_scoins']) ? (float)$servico['valor_scoins'] : 10;

        if($valor_scoins > 0){
            $scoinModel = new Scoin();
            $saldoDisponivel = $scoinModel->saldoDisponivel($usuario_id);

            if($saldoDisponivel < $valor_scoins){
                $_SESSION['erro_flash'] = 'Saldo insuficiente de SCoins. Disponível: ' . number_format($saldoDisponivel, 0) . ' | Necessário: ' . number_format($valor_scoins, 0);
                $this->redirect('servico/ver/' . $servico_id);
                return;
            }
        }

        $troca_id = $trocaModel->criar(
            $servico_id,
            $usuario_id,
            $servico['usuario_id'],
            $valor_scoins
        );

        if($valor_scoins > 0){
            $scoinModel->bloquear($usuario_id, $troca_id, $valor_scoins);
        }

        $notificacao = new Notificacao();
        $mensagem = "Nova proposta de troca no seu serviço: " . $servico['titulo'];
        $link = "?url=troca/chat/" . $troca_id;
        $notificacao->criar($servico['usuario_id'], $mensagem, $link);

        $_SESSION['sucesso_flash'] = 'Proposta de troca enviada! 🎉';
        $this->redirect('troca/minhas');
    }

    /* ============================
       ACEITAR TROCA
    ============================ */
    public function aceitar($troca_id){

        $this->auth();

        require_once "../app/modelos/Notificacao.php";

        $usuario_id = $_SESSION['usuario_id'];

        $trocaModel = new Troca();
        $resultado = $trocaModel->aceitar($troca_id, $usuario_id);

        if($resultado){
            $troca = $trocaModel->buscarPorId($troca_id);
            $notificacao = new Notificacao();
            $notificacao->criar(
                $troca['usuario_origem_id'],
                "Sua proposta de troca foi aceita! Negocie os detalhes no chat.",
                "?url=troca/chat/" . $troca_id
            );
            $_SESSION['sucesso_flash'] = 'Proposta aceita! 👍';
        }

        $this->redirect('troca/chat/' . $troca_id);
    }

    /* ============================
       CANCELAR TROCA
    ============================ */
    public function cancelar($troca_id){

        $this->auth();

        require_once "../app/modelos/Scoin.php";
        require_once "../app/modelos/Notificacao.php";

        $usuario_id = $_SESSION['usuario_id'];

        $trocaModel = new Troca();
        $troca = $trocaModel->cancelar($troca_id, $usuario_id);

        if($troca){
            $valor = (float)($troca['valor_scoins'] ?? 0);
            if($valor > 0){
                $scoinModel = new Scoin();
                $scoinModel->desbloquear($troca['usuario_origem_id'], $troca_id, $valor);
            }

            $notificacao = new Notificacao();
            $outraParte = ($troca['usuario_origem_id'] == $usuario_id) 
                ? $troca['usuario_destino_id'] 
                : $troca['usuario_origem_id'];
            $notificacao->criar(
                $outraParte,
                "Uma troca foi cancelada.",
                "?url=troca/minhas"
            );
            $_SESSION['sucesso_flash'] = 'Troca cancelada! ❌';
        }

        $this->redirect('troca/minhas');
    }

    /* ============================
       CHAT
    ============================ */
    public function chat($troca_id){

        $this->auth();

        $usuario_id = $_SESSION['usuario_id'];

        $trocaModel = new Troca();
        $troca = $trocaModel->buscarPorId($troca_id);

        if(!$troca){
            echo "Troca não encontrada.";
            return;
        }

        if(
            $troca['usuario_origem_id'] != $usuario_id &&
            $troca['usuario_destino_id'] != $usuario_id
        ){
            echo "Você não tem permissão para acessar esta troca.";
            return;
        }

        $servicoModel = new Servico();
        $servico = $servicoModel->buscarPorId($troca['servico_id']);

        $mensagemModel = new Mensagem();
        $mensagens = $mensagemModel->listarPorTroca($troca_id);

        require_once "../app/views/layout/cabecalho.php";
        require_once "../app/views/trocas/chat.php";
        require_once "../app/views/layout/rodape.php";
    }

    /* ============================
       ENVIAR MENSAGEM
    ============================ */
    public function enviarMensagem(){

        $this->auth();
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            require_once "../nucleo/Seguranca.php";
            if(!Seguranca::validarCsrf($_POST['csrf_token'] ?? '')){
                $_SESSION['erro_flash'] = 'Sessão expirada. Tente novamente.';
                $this->redirect('troca/minhas');
                return;
            }
        }

        $troca_id = $_POST['troca_id'];
        $mensagem = $_POST['mensagem'];
        $usuario_id = $_SESSION['usuario_id'];

        $mensagemModel = new Mensagem();
        $mensagemModel->enviar($troca_id, $usuario_id, $mensagem);

        $this->redirect('troca/chat/' . $troca_id);
    }

    /* ============================
       ✅ CONFIRMAR TROCA (CORRIGIDO - USA transferirBilateral)
    ============================ */
    /* ============================
   ✅ CONFIRMAR TROCA (CORRIGIDO)
============================ */
public function confirmar($troca_id){

    $this->auth();

    require_once "../app/modelos/Scoin.php";
    require_once "../app/modelos/Usuario.php";
    require_once "../app/modelos/Notificacao.php";
    require_once "../configuracao/banco.php";

    $usuario_id = $_SESSION['usuario_id'];

    $trocaModel = new Troca();
    $finalizada = $trocaModel->confirmar($troca_id, $usuario_id);

    if($finalizada){

        $troca = $trocaModel->buscarPorId($troca_id);
        $scoin = new Scoin();
        $usuarioModel = new Usuario();
        $notif = new Notificacao();

        $valor = (float)($troca['valor_scoins'] ?? 10);

        // ✅ Validação
        if($valor <= 0){
            $_SESSION['erro_flash'] = 'Valor inválido para troca.';
            $this->redirect('troca/chat/' . $troca_id);
            return;
        }

        try {
            // ✅ 1. DESBLOQUEAR saldo (CRÍTICO!)
            $banco = new Banco();
            $conn = $banco->conectar();
            
            $sqlDesbloquear = "UPDATE usuarios 
                              SET saldo_bloqueado = GREATEST(saldo_bloqueado - :valor, 0) 
                              WHERE id = :id";
            $stmtDesbloquear = $conn->prepare($sqlDesbloquear);
            $stmtDesbloquear->bindParam(":valor", $valor);
            $stmtDesbloquear->bindParam(":id", $troca['usuario_origem_id'], PDO::PARAM_INT);
            
            if(!$stmtDesbloquear->execute()){
                throw new Exception("Erro ao desbloquear saldo");
            }

            // ✅ 2. TRANSFERÊNCIA BILATERAL (ATÔMICA)
            $sucesso = $scoin->transferirBilateral(
                $troca['usuario_origem_id'],
                $troca['usuario_destino_id'],
                $troca_id,
                $valor,
                $valor,
                'Troca de serviços finalizada'
            );

            if ($sucesso) {
                // ✅ 3. Recalcular níveis
                $usuarioModel->recalcularNivel($troca['usuario_origem_id']);
                $usuarioModel->recalcularNivel($troca['usuario_destino_id']);

                // ✅ 4. Notificar ambos
                $notif->criar(
                    $troca['usuario_origem_id'],
                    "✅ Troca finalizada! Você recebeu {$valor} SCoins.",
                    "?url=troca/chat/" . $troca_id
                );

                $notif->criar(
                    $troca['usuario_destino_id'],
                    "✅ Troca finalizada! Você recebeu {$valor} SCoins.",
                    "?url=troca/chat/" . $troca_id
                );

                $_SESSION['sucesso_flash'] = "✅ Troca finalizada! Ambos receberam {$valor} SCoins!";
            } else {
                throw new Exception("Erro ao processar transferência bilateral");
            }

        } catch (Exception $e) {
            error_log("Erro ao confirmar troca: " . $e->getMessage());
            $_SESSION['erro_flash'] = 'Erro ao processar a troca: ' . $e->getMessage();
        }
    }

    $this->redirect('troca/chat/' . $troca_id);
}

    /* ============================
       ✅ AVALIAR (CORRIGIDO - COM VALIDAÇÕES)
    ============================ */
    public function avaliar($troca_id){

        $this->auth();

        $usuario_id = $_SESSION['usuario_id'];

        $trocaModel = new Troca();
        $troca = $trocaModel->buscarPorId($troca_id);

        // Validações
        if(!$troca){
            $_SESSION['erro_flash'] = 'Troca não encontrada.';
            $this->redirect('troca/minhas');
            return;
        }

        // Só pode avaliar se finalizou
        if($troca['status'] !== 'FINALIZADA'){
            $_SESSION['erro_flash'] = 'Esta troca não pode ser avaliada neste momento.';
            $this->redirect('troca/minhas');
            return;
        }

        // Só pode avaliar se participou
        if($troca['usuario_origem_id'] != $usuario_id && $troca['usuario_destino_id'] != $usuario_id){
            $_SESSION['erro_flash'] = 'Você não pode avaliar esta troca.';
            $this->redirect('troca/minhas');
            return;
        }

        require_once "../app/views/layout/cabecalho.php";
        require_once "../app/views/trocas/avaliar.php";
        require_once "../app/views/layout/rodape.php";
    }

    /* ============================
       ✅ SALVAR AVALIAÇÃO (NOVO - COM VALIDAÇÕES)
    ============================ */
    public function salvarAvaliacao(){

        $this->auth();
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            require_once "../nucleo/Seguranca.php";
            if(!Seguranca::validarCsrf($_POST['csrf_token'] ?? '')){
                $_SESSION['erro_flash'] = 'Sessão expirada. Tente novamente.';
                $this->redirect('troca/minhas');
                return;
            }
        }

        require_once "../app/modelos/Avaliacao.php";
        require_once "../app/modelos/Troca.php";

        $usuario_id = $_SESSION['usuario_id'];
        $troca_id = (int)$_POST['troca_id'];
        $nota = (int)$_POST['nota'];
        $comentario = trim($_POST['comentario'] ?? '');
        $avaliado = (int)$_POST['avaliado_id'];

        // ✅ Validações
        if($nota < 1 || $nota > 5){
            $_SESSION['erro_flash'] = 'Nota inválida (deve ser entre 1 e 5).';
            $this->redirect('troca/minhas');
            return;
        }

        $trocaModel = new Troca();
        $troca = $trocaModel->buscarPorId($troca_id);

        if(!$troca){
            $_SESSION['erro_flash'] = 'Troca não encontrada.';
            $this->redirect('troca/minhas');
            return;
        }

        if($troca['status'] !== 'FINALIZADA'){
            $_SESSION['erro_flash'] = 'Troca não pode ser avaliada neste momento.';
            $this->redirect('troca/minhas');
            return;
        }

        if($troca['usuario_origem_id'] != $usuario_id && $troca['usuario_destino_id'] != $usuario_id){
            $_SESSION['erro_flash'] = 'Você não pode avaliar esta troca.';
            $this->redirect('troca/minhas');
            return;
        }

        // ✅ Salvar avaliação
        $model = new Avaliacao();
        $resultado = $model->salvar($troca_id, $usuario_id, $avaliado, $nota, $comentario);

        if($resultado){
            $_SESSION['sucesso_flash'] = '⭐ Avaliação registrada com sucesso!';
        } else {
            $_SESSION['erro_flash'] = 'Erro ao registrar avaliação. Tente novamente.';
        }

        $this->redirect('troca/minhas');
    }

    /* ============================
       BUSCAR MENSAGENS (AJAX)
    ============================ */
    public function buscarMensagens(){

        $troca_id = $_GET['troca_id'];

        $mensagemModel = new Mensagem();
        $mensagens = $mensagemModel->listarPorTroca($troca_id);

        header('Content-Type: application/json');
        echo json_encode($mensagens);
    }
}