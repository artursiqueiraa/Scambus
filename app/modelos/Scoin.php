<?php

require_once "../configuracao/banco.php";

class Scoin {

    private $conexao;

    public function __construct(){
        $banco = new Banco();
        $this->conexao = $banco->conectar();
    }

    /*
    CREDITAR SCOINS (com proteção anti-duplicidade e transação atômica)
    */
    public function creditar($usuario_id, $troca_id, $valor, $descricao = 'Troca finalizada'){

        try {
            $this->conexao->beginTransaction();

            // Verificar se já existe crédito para esta troca/usuário
            $sqlCheck = "SELECT id FROM transacoes_scoins 
                         WHERE usuario_id = :usuario 
                         AND troca_id = :troca 
                         AND tipo = 'CREDITO' LIMIT 1";
            $stmtCheck = $this->conexao->prepare($sqlCheck);
            $stmtCheck->bindParam(":usuario", $usuario_id);
            $stmtCheck->bindParam(":troca", $troca_id);
            $stmtCheck->execute();

            if ($stmtCheck->fetch()) {
                // Já foi creditado — aborta sem erro
                $this->conexao->rollBack();
                return false;
            }

            // Registrar transação
            $sql = "INSERT INTO transacoes_scoins
                    (usuario_id, troca_id, valor, tipo, descricao)
                    VALUES
                    (:usuario, :troca, :valor, 'CREDITO', :descricao)";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindParam(":usuario", $usuario_id);
            $stmt->bindParam(":troca", $troca_id);
            $stmt->bindParam(":valor", $valor);
            $stmt->bindParam(":descricao", $descricao);
            $stmt->execute();

            // Atualizar saldo do usuário
            $sql2 = "UPDATE usuarios
                     SET saldo_scoins = saldo_scoins + :valor,
                         total_trocas_finalizadas = total_trocas_finalizadas + 1
                     WHERE id = :usuario";
            $stmt2 = $this->conexao->prepare($sql2);
            $stmt2->bindParam(":valor", $valor);
            $stmt2->bindParam(":usuario", $usuario_id);
            $stmt2->execute();

            $this->conexao->commit();
            return true;

        } catch (Exception $e) {
            $this->conexao->rollBack();
            return false;
        }
    }

    /*
    DEBITAR SCOINS (para o lado que paga na troca)
    */
    public function debitar($usuario_id, $troca_id, $valor, $descricao = 'Pagamento de troca'){

        try {
            $this->conexao->beginTransaction();

            // Verificar se já existe débito para esta troca/usuário
            $sqlCheck = "SELECT id FROM transacoes_scoins 
                         WHERE usuario_id = :usuario 
                         AND troca_id = :troca 
                         AND tipo = 'DEBITO' LIMIT 1";
            $stmtCheck = $this->conexao->prepare($sqlCheck);
            $stmtCheck->bindParam(":usuario", $usuario_id);
            $stmtCheck->bindParam(":troca", $troca_id);
            $stmtCheck->execute();

            if ($stmtCheck->fetch()) {
                $this->conexao->rollBack();
                return false;
            }

            // Registrar transação de débito
            $sql = "INSERT INTO transacoes_scoins
                    (usuario_id, troca_id, valor, tipo, descricao)
                    VALUES
                    (:usuario, :troca, :valor, 'DEBITO', :descricao)";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindParam(":usuario", $usuario_id);
            $stmt->bindParam(":troca", $troca_id);
            $stmt->bindParam(":valor", $valor);
            $stmt->bindParam(":descricao", $descricao);
            $stmt->execute();

            // Descontar saldo
            $sql2 = "UPDATE usuarios
                     SET saldo_scoins = saldo_scoins - :valor
                     WHERE id = :usuario";
            $stmt2 = $this->conexao->prepare($sql2);
            $stmt2->bindParam(":valor", $valor);
            $stmt2->bindParam(":usuario", $usuario_id);
            $stmt2->execute();

            $this->conexao->commit();
            return true;

        } catch (Exception $e) {
            $this->conexao->rollBack();
            return false;
        }
    }

    /*
    BLOQUEAR SCOINS (reserva para escrow ao propor troca)
    */
    public function bloquear($usuario_id, $troca_id, $valor){

        try {
            $this->conexao->beginTransaction();

            // Verificar saldo disponível (saldo - bloqueado)
            $sqlSaldo = "SELECT (saldo_scoins - saldo_bloqueado) as disponivel 
                         FROM usuarios WHERE id = :id";
            $stmtSaldo = $this->conexao->prepare($sqlSaldo);
            $stmtSaldo->bindParam(":id", $usuario_id);
            $stmtSaldo->execute();
            $dados = $stmtSaldo->fetch(PDO::FETCH_ASSOC);

            if (!$dados || $dados['disponivel'] < $valor) {
                $this->conexao->rollBack();
                return false; // Saldo insuficiente
            }

            // Bloquear saldo
            $sql = "UPDATE usuarios 
                    SET saldo_bloqueado = saldo_bloqueado + :valor 
                    WHERE id = :id";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindParam(":valor", $valor);
            $stmt->bindParam(":id", $usuario_id);
            $stmt->execute();

            // Registrar transação de bloqueio
            $sql2 = "INSERT INTO transacoes_scoins
                     (usuario_id, troca_id, valor, tipo, descricao)
                     VALUES
                     (:usuario, :troca, :valor, 'BLOQUEIO', 'SCoins reservados para troca')";
            $stmt2 = $this->conexao->prepare($sql2);
            $stmt2->bindParam(":usuario", $usuario_id);
            $stmt2->bindParam(":troca", $troca_id);
            $stmt2->bindParam(":valor", $valor);
            $stmt2->execute();

            $this->conexao->commit();
            return true;

        } catch (Exception $e) {
            $this->conexao->rollBack();
            return false;
        }
    }

    /*
    DESBLOQUEAR SCOINS (devolve ao cancelar troca)
    */
    public function desbloquear($usuario_id, $troca_id, $valor){

        try {
            $this->conexao->beginTransaction();

            // Desbloquear saldo
            $sql = "UPDATE usuarios 
                    SET saldo_bloqueado = GREATEST(saldo_bloqueado - :valor, 0) 
                    WHERE id = :id";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindParam(":valor", $valor);
            $stmt->bindParam(":id", $usuario_id);
            $stmt->execute();

            // Registrar transação de estorno
            $sql2 = "INSERT INTO transacoes_scoins
                     (usuario_id, troca_id, valor, tipo, descricao)
                     VALUES
                     (:usuario, :troca, :valor, 'ESTORNO', 'SCoins devolvidos - troca cancelada')";
            $stmt2 = $this->conexao->prepare($sql2);
            $stmt2->bindParam(":usuario", $usuario_id);
            $stmt2->bindParam(":troca", $troca_id);
            $stmt2->bindParam(":valor", $valor);
            $stmt2->execute();

            $this->conexao->commit();
            return true;

        } catch (Exception $e) {
            $this->conexao->rollBack();
            return false;
        }
    }

    /*
    SALDO DISPONÍVEL DO USUÁRIO
    */
    public function saldoDisponivel($usuario_id){

        $sql = "SELECT (saldo_scoins - saldo_bloqueado) as disponivel 
                FROM usuarios WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(":id", $usuario_id);
        $stmt->execute();
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        return $dados ? (float)$dados['disponivel'] : 0;
    }

    /*
    HISTÓRICO DE TRANSAÇÕES
    */
    public function historicoPorUsuario($usuario_id){

        $sql = "SELECT
                    valor,
                    tipo,
                    descricao,
                    data_criacao
                FROM transacoes_scoins
                WHERE usuario_id = :usuario
                ORDER BY data_criacao DESC";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(":usuario", $usuario_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
    ENVIAR GORJETA NA COMUNIDADE
    */
    public function gorjeta($pagador_id, $recebedor_id, $valor, $post_id){
        try {
            $this->conexao->beginTransaction();

            $sqlSaldo = "SELECT (saldo_scoins - saldo_bloqueado) as disponivel FROM usuarios WHERE id = :id";
            $stmtSaldo = $this->conexao->prepare($sqlSaldo);
            $stmtSaldo->bindParam(":id", $pagador_id);
            $stmtSaldo->execute();
            $dados = $stmtSaldo->fetch(PDO::FETCH_ASSOC);

            if (!$dados || $dados['disponivel'] < $valor) {
                $this->conexao->rollBack();
                return false;
            }

            $sqlDebit = "INSERT INTO transacoes_scoins (usuario_id, troca_id, valor, tipo, descricao) VALUES (:pagador, NULL, :valor, 'DEBITO', 'Gorjeta enviada na comunidade')";
            $stmtDebit = $this->conexao->prepare($sqlDebit);
            $stmtDebit->bindParam(":pagador", $pagador_id);
            $stmtDebit->bindParam(":valor", $valor);
            $stmtDebit->execute();

            $sqlUpDebit = "UPDATE usuarios SET saldo_scoins = saldo_scoins - :valor WHERE id = :pagador";
            $stmtUpDebit = $this->conexao->prepare($sqlUpDebit);
            $stmtUpDebit->bindParam(":valor", $valor);
            $stmtUpDebit->bindParam(":pagador", $pagador_id);
            $stmtUpDebit->execute();

            $sqlCredit = "INSERT INTO transacoes_scoins (usuario_id, troca_id, valor, tipo, descricao) VALUES (:recebedor, NULL, :valor, 'CREDITO', 'Gorjeta recebida na comunidade')";
            $stmtCredit = $this->conexao->prepare($sqlCredit);
            $stmtCredit->bindParam(":recebedor", $recebedor_id);
            $stmtCredit->bindParam(":valor", $valor);
            $stmtCredit->execute();

            $sqlUpCredit = "UPDATE usuarios SET saldo_scoins = saldo_scoins + :valor WHERE id = :recebedor";
            $stmtUpCredit = $this->conexao->prepare($sqlUpCredit);
            $stmtUpCredit->bindParam(":valor", $valor);
            $stmtUpCredit->bindParam(":recebedor", $recebedor_id);
            $stmtUpCredit->execute();

            $this->conexao->commit();
            return true;

        } catch (Exception $e) {
            $this->conexao->rollBack();
            return false;
        }
    }

    /*
    BÔNUS DE BOAS-VINDAS (50 SCoins para novos usuários)
    Protegido contra duplicidade: só crédita uma vez por usuário
    */
    public function creditarBoasVindas($usuario_id, $valor = 50, $descricao = 'Bônus de boas-vindas') {
        try {
            $this->conexao->beginTransaction();

            // Verifica se já recebeu o bônus (evita duplicidade)
            $check = $this->conexao->prepare(
                "SELECT id FROM transacoes_scoins 
                 WHERE usuario_id = :id AND descricao LIKE '%boas-vindas%' LIMIT 1"
            );
            $check->bindParam(":id", $usuario_id, PDO::PARAM_INT);
            $check->execute();
            if ($check->fetch()) {
                $this->conexao->rollBack();
                return false; // já recebeu
            }

            // Registra a transação de bônus
            $ins = $this->conexao->prepare(
                "INSERT INTO transacoes_scoins (usuario_id, troca_id, valor, tipo, descricao)
                 VALUES (:id, NULL, :valor, 'CREDITO', :desc)"
            );
            $ins->execute([':id' => $usuario_id, ':valor' => $valor, ':desc' => $descricao]);

            // Credita no saldo
            $upd = $this->conexao->prepare(
                "UPDATE usuarios SET saldo_scoins = saldo_scoins + :valor WHERE id = :id"
            );
            $upd->execute([':valor' => $valor, ':id' => $usuario_id]);

            $this->conexao->commit();
            return true;

        } catch (Exception $e) {
            $this->conexao->rollBack();
            error_log("Erro creditarBoasVindas: " . $e->getMessage());
            return false;
        }
    }
}
