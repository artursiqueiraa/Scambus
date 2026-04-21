<?php

require_once "../configuracao/banco.php";

class Troca {

    private $conexao;

    public function __construct(){
        $banco = new Banco();
        $this->conexao = $banco->conectar();
    }

    /*
    CRIAR TROCA (com valor de SCoins)
    */
    public function criar($servico_id, $usuario_origem, $usuario_destino, $valor_scoins = 0){

        $sql = "INSERT INTO trocas
                (servico_id, usuario_origem_id, usuario_destino_id, status, valor_scoins)
                VALUES
                (:servico, :origem, :destino, 'PENDENTE', :valor)";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(":servico", $servico_id);
        $stmt->bindParam(":origem", $usuario_origem);
        $stmt->bindParam(":destino", $usuario_destino);
        $stmt->bindParam(":valor", $valor_scoins);
        $stmt->execute();

        return $this->conexao->lastInsertId();
    }

    /*
    LISTAR TROCAS DO USUÁRIO
    */
    public function listarPorUsuario($usuario_id){

        $sql = "SELECT 
                trocas.*,
                servicos.titulo,
                servico_fotos.caminho_foto,
                origem.nome as nome_origem,
                destino.nome as nome_destino
                FROM trocas
                JOIN servicos ON servicos.id = trocas.servico_id
                LEFT JOIN servico_fotos ON servico_fotos.servico_id = servicos.id
                JOIN usuarios origem ON origem.id = trocas.usuario_origem_id
                JOIN usuarios destino ON destino.id = trocas.usuario_destino_id
                WHERE trocas.usuario_origem_id = :usuario
                OR trocas.usuario_destino_id = :usuario
                GROUP BY trocas.id
                ORDER BY trocas.data_criacao DESC";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(":usuario", $usuario_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
    ACEITAR TROCA (PENDENTE → EM_ANDAMENTO)
    Somente o usuario_destino pode aceitar
    */
    public function aceitar($troca_id, $usuario_id){

        $troca = $this->buscarPorId($troca_id);

        if (!$troca) return false;
        if ($troca['status'] !== 'PENDENTE') return false;
        if ($troca['usuario_destino_id'] != $usuario_id) return false;

        $sql = "UPDATE trocas SET status = 'EM_ANDAMENTO' WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(":id", $troca_id);
        $stmt->execute();

        return true;
    }

    /*
    CONFIRMAR ENTREGA (com proteção de status e anti-duplicidade)
    */
    public function confirmar($troca_id, $usuario_id){

        $sql = "SELECT * FROM trocas WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(":id", $troca_id);
        $stmt->execute();
        $troca = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$troca) return false;

        // Só pode confirmar se EM_ANDAMENTO
        if ($troca['status'] !== 'EM_ANDAMENTO') return false;

        // Marcar confirmação do lado correto
        if ($troca['usuario_origem_id'] == $usuario_id) {
            $sql = "UPDATE trocas SET confirmacao_origem = 1 WHERE id = :id";
        } elseif ($troca['usuario_destino_id'] == $usuario_id) {
            $sql = "UPDATE trocas SET confirmacao_destino = 1 WHERE id = :id";
        } else {
            return false; // Usuário não pertence a esta troca
        }

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(":id", $troca_id);
        $stmt->execute();

        // Re-buscar para ver se ambos confirmaram
        $sql2 = "SELECT * FROM trocas WHERE id = :id";
        $stmt2 = $this->conexao->prepare($sql2);
        $stmt2->bindParam(":id", $troca_id);
        $stmt2->execute();
        $troca = $stmt2->fetch(PDO::FETCH_ASSOC);

        if ($troca['confirmacao_origem'] && $troca['confirmacao_destino']) {

            // Verificar flag anti-duplicidade
            if ($troca['scoins_creditados'] == 1) {
                return false; // Já foi processado
            }

            // Marcar como finalizada E proteger contra re-crédito
            $sql3 = "UPDATE trocas
                     SET status = 'FINALIZADA',
                         data_finalizacao = NOW(),
                         scoins_creditados = 1
                     WHERE id = :id AND scoins_creditados = 0";
            $stmt3 = $this->conexao->prepare($sql3);
            $stmt3->bindParam(":id", $troca_id);
            $stmt3->execute();

            // Retorna true somente se realmente atualizou (proteção race condition)
            return $stmt3->rowCount() > 0;
        }

        return false;
    }

    /*
    CANCELAR TROCA
    */
    public function cancelar($troca_id, $usuario_id){

        $troca = $this->buscarPorId($troca_id);

        if (!$troca) return false;
        if ($troca['status'] === 'FINALIZADA' || $troca['status'] === 'CANCELADA') return false;

        // Verificar que o usuário pertence à troca
        if ($troca['usuario_origem_id'] != $usuario_id && $troca['usuario_destino_id'] != $usuario_id) {
            return false;
        }

        $sql = "UPDATE trocas 
                SET status = 'CANCELADA', cancelado_por = :usuario 
                WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(":usuario", $usuario_id);
        $stmt->bindParam(":id", $troca_id);
        $stmt->execute();

        return $troca; // Retorna dados da troca para processar o estorno
    }

    /*
    CONTAR TROCAS PROPOSTAS HOJE (anti-fraude)
    */
    public function contarTrocasHoje($usuario_id){

        $sql = "SELECT COUNT(*) as total FROM trocas 
                WHERE usuario_origem_id = :id 
                AND DATE(data_criacao) = CURDATE()";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(":id", $usuario_id);
        $stmt->execute();

        return (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    /*
    BUSCAR POR ID
    */
    public function buscarPorId($troca_id){

        $sql = "SELECT 
                trocas.*,
                u1.nome as nome_origem,
                u2.nome as nome_destino
            FROM trocas
            JOIN usuarios u1 ON u1.id = trocas.usuario_origem_id
            JOIN usuarios u2 ON u2.id = trocas.usuario_destino_id
            WHERE trocas.id = :id";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(":id", $troca_id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /*
    CONTAR TROCAS
    */
    public function contarTrocas(){

        $sql = "SELECT COUNT(*) as total FROM trocas";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
}
