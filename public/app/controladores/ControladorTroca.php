<?php

require_once "../app/modelos/Troca.php";
require_once "../app/modelos/Mensagem.php";
require_once "../app/modelos/Servico.php";

class ControladorTroca {

    /* ============================
       VERIFICAR LOGIN (segurança)
    ============================ */
    private function verificarLogin(){
        if(empty($_SESSION['usuario_id'])){
            header("Location: ?url=autenticacao/login");
            exit;
        }
    }

    /* ============================
       MINHAS TROCAS
    ============================ */
    public function minhas(){

        $this->verificarLogin();

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

        $this->verificarLogin();

        require_once "../app/modelos/Scoin.php";
        require_once "../app/modelos/Notificacao.php";

        $usuario_id = $_SESSION['usuario_id'];

        $servicoModel = new Servico();
        $servico = $servicoModel->buscarPorId($servico_id);

        if(!$servico){
            echo "Serviço não encontrado.";
            return;
        }

        // Anti-fraude: Não pode propor troca consigo mesmo
        if($servico['usuario_id'] == $usuario_id){
            echo "Você não pode propor troca para seu próprio serviço.";
            return;
        }

        // Anti-fraude: Limite de 10 propostas por dia
        $trocaModel = new Troca();
        $trocasHoje = $trocaModel->contarTrocasHoje($usuario_id);
        if($trocasHoje >= 10){
            echo "Você atingiu o limite de 10 propostas de troca por dia.";
            return;
        }

        // Definir valor de SCoins da troca
        $valor_scoins = isset($servico['valor_scoins']) ? (float)$servico['valor_scoins'] : 10;

        // Escrow: Verificar e bloquear saldo
        if($valor_scoins > 0){
            $scoinModel = new Scoin();

            $saldoDisponivel = $scoinModel->saldoDisponivel($usuario_id);

            if($saldoDisponivel < $valor_scoins){
                echo "Saldo insuficiente de SCoins. Disponível: " . $saldoDisponivel . " | Necessário: " . $valor_scoins;
                return;
            }
        }

        // Criar troca
        $troca_id = $trocaModel->criar(
            $servico_id,
            $usuario_id,
            $servico['usuario_id'],
            $valor_scoins
        );

        // Bloquear SCoins (escrow)
        if($valor_scoins > 0){
            $scoinModel->bloquear($usuario_id, $troca_id, $valor_scoins);
        }

        // Notificar o destinatário
        $notificacao = new Notificacao();
        $mensagem = "Nova proposta de troca no seu serviço: " . $servico['titulo'];
        $link = "?url=troca/chat/" . $troca_id;
        $notificacao->criar($servico['usuario_id'], $mensagem, $link);

        header("Location: ?url=troca/minhas");
        exit;
    }

    /* ============================
       ACEITAR TROCA (NOVO)
    ============================ */
    public function aceitar($troca_id){

        $this->verificarLogin();

        require_once "../app/modelos/Notificacao.php";

        $usuario_id = $_SESSION['usuario_id'];

        $trocaModel = new Troca();
        $resultado = $trocaModel->aceitar($troca_id, $usuario_id);

        if($resultado){
            // Notificar o proponente
            $troca = $trocaModel->buscarPorId($troca_id);
            $notificacao = new Notificacao();
            $notificacao->criar(
                $troca['usuario_origem_id'],
                "Sua proposta de troca foi aceita! Negocie os detalhes no chat.",
                "?url=troca/chat/" . $troca_id
            );
        }

        header("Location: ?url=troca/chat/" . $troca_id);
        exit;
    }

    /* ============================
       CANCELAR TROCA (NOVO, com devolução de SCoins)
    ============================ */
    public function cancelar($troca_id){

        $this->verificarLogin();

        require_once "../app/modelos/Scoin.php";
        require_once "../app/modelos/Notificacao.php";

        $usuario_id = $_SESSION['usuario_id'];

        $trocaModel = new Troca();
        $troca = $trocaModel->cancelar($troca_id, $usuario_id);

        if($troca){
            // Devolver SCoins bloqueados ao proponente (origem)
            $valor = (float)($troca['valor_scoins'] ?? 0);
            if($valor > 0){
                $scoinModel = new Scoin();
                $scoinModel->desbloquear($troca['usuario_origem_id'], $troca_id, $valor);
            }

            // Notificar a outra parte
            $notificacao = new Notificacao();
            $outraParte = ($troca['usuario_origem_id'] == $usuario_id) 
                ? $troca['usuario_destino_id'] 
                : $troca['usuario_origem_id'];
            $notificacao->criar(
                $outraParte,
                "Uma troca foi cancelada.",
                "?url=troca/minhas"
            );
        }

        header("Location: ?url=troca/minhas");
        exit;
    }

    /* ============================
       CHAT
    ============================ */
    public function chat($troca_id){

        $this->verificarLogin();

        $usuario_id = $_SESSION['usuario_id'];

        $trocaModel = new Troca();
        $troca = $trocaModel->buscarPorId($troca_id);

        // Segurança
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

        // Buscar serviço
        $servicoModel = new Servico();
        $servico = $servicoModel->buscarPorId($troca['servico_id']);

        // Mensagens
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

        $this->verificarLogin();
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            require_once "../nucleo/Seguranca.php";
            if(!Seguranca::validarCsrf($_POST['csrf_token'] ?? '')){
                die("Erro CSRF detectado em mensagem.");
            }
        }

        $troca_id = $_POST['troca_id'];
        $mensagem = $_POST['mensagem'];
        $usuario_id = $_SESSION['usuario_id'];

        $mensagemModel = new Mensagem();
        $mensagemModel->enviar($troca_id, $usuario_id, $mensagem);

        header("Location: ?url=troca/chat/" . $troca_id);
    }

    /* ============================
       CONFIRMAR TROCA (com proteção total)
    ============================ */
    public function confirmar($troca_id){

        $this->verificarLogin();

        require_once "../app/modelos/Scoin.php";
        require_once "../app/modelos/Usuario.php";

        $usuario_id = $_SESSION['usuario_id'];

        $trocaModel = new Troca();

        $finalizada = $trocaModel->confirmar($troca_id, $usuario_id);

        // Ambos confirmaram E nunca foi creditado antes
        if($finalizada){

            $troca = $trocaModel->buscarPorId($troca_id);
            $scoin = new Scoin();
            $usuarioModel = new Usuario();

            $valor = (float)($troca['valor_scoins'] ?? 10);

            // 1. Desbloquear saldo do proponente (origem)
            $sqlDesbloqueio = "UPDATE usuarios SET saldo_bloqueado = GREATEST(saldo_bloqueado - :valor, 0) WHERE id = :id";
            $banco = new Banco();
            $conn = $banco->conectar();
            $stmt = $conn->prepare($sqlDesbloqueio);
            $stmt->bindParam(":valor", $valor);
            $stmt->bindParam(":id", $troca['usuario_origem_id']);
            $stmt->execute();

            // 2. Debitar do proponente (origem)
            $scoin->debitar($troca['usuario_origem_id'], $troca_id, $valor, 'Pagamento de troca finalizada');

            // 3. Creditar para o prestador (destino)
            $scoin->creditar($troca['usuario_destino_id'], $troca_id, $valor, 'Recebimento de troca finalizada');

            // 4. Recalcular nível de ambos
            $usuarioModel->recalcularNivel($troca['usuario_origem_id']);
            $usuarioModel->recalcularNivel($troca['usuario_destino_id']);

            // 5. Verificar padrão suspeito
            if($usuarioModel->verificarPadraoSuspeito($troca['usuario_origem_id'])){
                // Log para admin (futuro: bloquear automaticamente)
                error_log("ALERTA ANTI-FRAUDE: Padrão suspeito detectado para usuário ID " . $troca['usuario_origem_id']);
            }
        }

        header("Location: ?url=troca/chat/" . $troca_id);
    }

    /* ============================
       AVALIAR
    ============================ */
    public function avaliar($troca_id){

        $this->verificarLogin();

        $trocaModel = new Troca();
        $troca = $trocaModel->buscarPorId($troca_id);

        require_once "../app/views/layout/cabecalho.php";
        require_once "../app/views/trocas/avaliar.php";
        require_once "../app/views/layout/rodape.php";
    }

    public function salvarAvaliacao(){

        $this->verificarLogin();
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            require_once "../nucleo/Seguranca.php";
            if(!Seguranca::validarCsrf($_POST['csrf_token'] ?? '')){
                die("Erro CSRF detectado em avaliacao.");
            }
        }

        require_once "../app/modelos/Avaliacao.php";

        $troca_id = $_POST['troca_id'];
        $nota = $_POST['nota'];
        $comentario = $_POST['comentario'];

        $avaliador = $_SESSION['usuario_id'];
        $avaliado = $_POST['avaliado_id'];

        $model = new Avaliacao();
        $model->salvar($troca_id, $avaliador, $avaliado, $nota, $comentario);

        header("Location: ?url=troca/minhas");
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