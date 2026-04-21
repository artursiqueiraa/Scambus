<?php

require_once "../configuracao/banco.php";

class Scoin {

    private $conexao;

    public function __construct(){
        $banco = new Banco();
        $this->conexao = $banco->conectar();
    }

    /*
    ✅ NOVO: TRANSFERÊNCIA BILATERAL (MÉTODO FALTAVA!)
    Ambos recebem o mesmo valor em transação atômica
    */
    public function transferirBilateral($usuario_origem_id, $usuario_destino_id, $troca_id, $valor_origem, $valor_destino, $descricao = 'Troca de serviços'){

        try {
            $this->conexao->beginTransaction();

            // Se não especificar valor_destino, usa o mesmo da origem
            if ($valor_destino <= 0) {
                $valor_destino = $valor_origem;
            }

            // ✅ Validação: valores devem ser > 0
            if ($valor_origem <= 0 || $valor_destino <= 0) {
                $this->conexao->rollBack();
                return false;
            }

            // ✅ 1. DÉBITO da origem
            $sqlDebit = "INSERT INTO transacoes_scoins
                        (usuario_id, troca_id, valor, tipo, descricao, data_criacao)
                        VALUES
                        (:usuario, :troca, :valor, 'DEBITO', :desc, NOW())";
            $stmtDebit = $this->conexao->prepare($sqlDebit);
            $stmtDebit->bindParam(":usuario", $usuario_origem_id, PDO::PARAM_INT);
            $stmtDebit->bindParam(":troca", $troca_id, PDO::PARAM_INT);
            $stmtDebit->bindParam(":valor", $valor_origem);
            $stmtDebit->bindParam(":desc", $descricao);
            $stmtDebit->execute();

            // ✅ 2. CRÉDITO no destino
            $sqlCredit = "INSERT INTO transacoes_scoins
                         (usuario_id, troca_id, valor, tipo, descricao, data_criacao)
                         VALUES
                         (:usuario, :troca, :valor, 'CREDITO', :desc, NOW())";
            $stmtCredit = $this->conexao->prepare($sqlCredit);
            $stmtCredit->bindParam(":usuario", $usuario_destino_id, PDO::PARAM_INT);
            $stmtCredit->bindParam(":troca", $troca_id, PDO::PARAM_INT);
            $stmtCredit->bindParam(":valor", $valor_destino);
            $stmtCredit->bindParam(":desc", $descricao);
            $stmtCredit->execute();

            // ✅ 3. ATUALIZAR saldos em UMA query (ATOMICIDADE)
            $sqlUpdate = "UPDATE usuarios 
                          SET saldo_scoins = CASE 
                              WHEN id = :origem THEN saldo_scoins - :valor_origem
                              WHEN id = :destino THEN saldo_scoins + :valor_destino
                              ELSE saldo_scoins
                          END,
                          total_trocas_finalizadas = total_trocas_finalizadas + 1
                          WHERE id = :origem OR id = :destino";
            $stmtUpdate = $this->conexao->prepare($sqlUpdate);
            $stmtUpdate->bindParam(":origem", $usuario_origem_id, PDO::PARAM_INT);
            $stmtUpdate->bindParam(":destino", $usuario_destino_id, PDO::PARAM_INT);
            $stmtUpdate->bindParam(":valor_origem", $valor_origem);
            $stmtUpdate->bindParam(":valor_destino", $valor_destino);
            $stmtUpdate->execute();

            $this->conexao->commit();
            return true;

        } catch (Exception $e) {
            $this->conexao->rollBack();
            error_log("Erro transferirBilateral: " . $e->getMessage());
            return false;
        }
    }

    /*
    CREDITAR SCOINS (com proteção anti-duplicidade)
    */
    public function creditar($usuario_id, $troca_id, $valor, $descricao = 'Troca finalizada'){

        try {
            $this->conexao->beginTransaction();

            if ($valor <= 0) {
                $this->conexao->rollBack();
                return false;
            }

            $sqlCheck = "SELECT id FROM transacoes_scoins 
                         WHERE usuario_id = :usuario 
                         AND troca_id = :troca 
                         AND tipo = 'CREDITO' LIMIT 1";
            $stmtCheck = $this->conexao->prepare($sqlCheck);
            $stmtCheck->bindParam(":usuario", $usuario_id, PDO::PARAM_INT);
            $stmtCheck->bindParam(":troca", $troca_id, PDO::PARAM_INT);
            $stmtCheck->execute();

            if ($stmtCheck->fetch()) {
                $this->conexao->rollBack();
                return false;
            }

            $sql = "INSERT INTO transacoes_scoins
                    (usuario_id, troca_id, valor, tipo, descricao, data_criacao)
                    VALUES
                    (:usuario, :troca, :valor, 'CREDITO', :descricao, NOW())";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindParam(":usuario", $usuario_id, PDO::PARAM_INT);
            $stmt->bindParam(":troca", $troca_id, PDO::PARAM_INT);
            $stmt->bindParam(":valor", $valor);
            $stmt->bindParam(":descricao", $descricao);
            $stmt->execute();

            $sql2 = "UPDATE usuarios
                     SET saldo_scoins = saldo_scoins + :valor,
                         total_trocas_finalizadas = total_trocas_finalizadas + 1
                     WHERE id = :usuario";
            $stmt2 = $this->conexao->prepare($sql2);
            $stmt2->bindParam(":valor", $valor);
            $stmt2->bindParam(":usuario", $usuario_id, PDO::PARAM_INT);
            $stmt2->execute();

            $this->conexao->commit();
            return true;

        } catch (Exception $e) {
            $this->conexao->rollBack();
            error_log("Erro creditar: " . $e->getMessage());
            return false;
        }
    }

    /*
    DEBITAR SCOINS
    */
    public function debitar($usuario_id, $troca_id, $valor, $descricao = 'Pagamento de troca'){

        try {
            $this->conexao->beginTransaction();

            if ($valor <= 0) {
                $this->conexao->rollBack();
                return false;
            }

            $sqlCheck = "SELECT id FROM transacoes_scoins 
                         WHERE usuario_id = :usuario 
                         AND troca_id = :troca 
                         AND tipo = 'DEBITO' LIMIT 1";
            $stmtCheck = $this->conexao->prepare($sqlCheck);
            $stmtCheck->bindParam(":usuario", $usuario_id, PDO::PARAM_INT);
            $stmtCheck->bindParam(":troca", $troca_id, PDO::PARAM_INT);
            $stmtCheck->execute();

            if ($stmtCheck->fetch()) {
                $this->conexao->rollBack();
                return false;
            }

            $sql = "INSERT INTO transacoes_scoins
                    (usuario_id, troca_id, valor, tipo, descricao, data_criacao)
                    VALUES
                    (:usuario, :troca, :valor, 'DEBITO', :descricao, NOW())";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindParam(":usuario", $usuario_id, PDO::PARAM_INT);
            $stmt->bindParam(":troca", $troca_id, PDO::PARAM_INT);
            $stmt->bindParam(":valor", $valor);
            $stmt->bindParam(":descricao", $descricao);
            $stmt->execute();

            $sql2 = "UPDATE usuarios
                     SET saldo_scoins = saldo_scoins - :valor
                     WHERE id = :usuario";
            $stmt2 = $this->conexao->prepare($sql2);
            $stmt2->bindParam(":valor", $valor);
            $stmt2->bindParam(":usuario", $usuario_id, PDO::PARAM_INT);
            $stmt2->execute();

            $this->conexao->commit();
            return true;

        } catch (Exception $e) {
            $this->conexao->rollBack();
            error_log("Erro debitar: " . $e->getMessage());
            return false;
        }
    }

    /*
    BLOQUEAR SCOINS (para escrow)
    */
    public function bloquear($usuario_id, $troca_id, $valor){

        try {
            $this->conexao->beginTransaction();

            if ($valor <= 0) {
                $this->conexao->rollBack();
                return false;
            }

            $sqlSaldo = "SELECT (saldo_scoins - saldo_bloqueado) as disponivel 
                         FROM usuarios WHERE id = :id";
            $stmtSaldo = $this->conexao->prepare($sqlSaldo);
            $stmtSaldo->bindParam(":id", $usuario_id, PDO::PARAM_INT);
            $stmtSaldo->execute();
            $dados = $stmtSaldo->fetch(PDO::FETCH_ASSOC);

            if (!$dados || $dados['disponivel'] < $valor) {
                $this->conexao->rollBack();
                return false;
            }

            $sql = "UPDATE usuarios 
                    SET saldo_bloqueado = saldo_bloqueado + :valor 
                    WHERE id = :id";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindParam(":valor", $valor);
            $stmt->bindParam(":id", $usuario_id, PDO::PARAM_INT);
            $stmt->execute();

            $sql2 = "INSERT INTO transacoes_scoins
                     (usuario_id, troca_id, valor, tipo, descricao, data_criacao)
                     VALUES
                     (:usuario, :troca, :valor, 'BLOQUEIO', 'SCoins reservados para troca', NOW())";
            $stmt2 = $this->conexao->prepare($sql2);
            $stmt2->bindParam(":usuario", $usuario_id, PDO::PARAM_INT);
            $stmt2->bindParam(":troca", $troca_id, PDO::PARAM_INT);
            $stmt2->bindParam(":valor", $valor);
            $stmt2->execute();

            $this->conexao->commit();
            return true;

        } catch (Exception $e) {
            $this->conexao->rollBack();
            error_log("Erro bloquear: " . $e->getMessage());
            return false;
        }
    }

    /*
    DESBLOQUEAR SCOINS (ao cancelar)
    */
    public function desbloquear($usuario_id, $troca_id, $valor){

        try {
            $this->conexao->beginTransaction();

            if ($valor <= 0) {
                $this->conexao->rollBack();
                return false;
            }

            $sql = "UPDATE usuarios 
                    SET saldo_bloqueado = GREATEST(saldo_bloqueado - :valor, 0) 
                    WHERE id = :id";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindParam(":valor", $valor);
            $stmt->bindParam(":id", $usuario_id, PDO::PARAM_INT);
            $stmt->execute();

            $sql2 = "INSERT INTO transacoes_scoins
                     (usuario_id, troca_id, valor, tipo, descricao, data_criacao)
                     VALUES
                     (:usuario, :troca, :valor, 'ESTORNO', 'SCoins devolvidos - troca cancelada', NOW())";
            $stmt2 = $this->conexao->prepare($sql2);
            $stmt2->bindParam(":usuario", $usuario_id, PDO::PARAM_INT);
            $stmt2->bindParam(":troca", $troca_id, PDO::PARAM_INT);
            $stmt2->bindParam(":valor", $valor);
            $stmt2->execute();

            $this->conexao->commit();
            return true;

        } catch (Exception $e) {
            $this->conexao->rollBack();
            error_log("Erro desbloquear: " . $e->getMessage());
            return false;
        }
    }

    /*
    SALDO DISPONÍVEL
    */
    public function saldoDisponivel($usuario_id){

        $sql = "SELECT (saldo_scoins - saldo_bloqueado) as disponivel 
                FROM usuarios WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(":id", $usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        return $dados ? (float)$dados['disponivel'] : 0;
    }

    /*
    HISTÓRICO DE TRANSAÇÕES (com formatação correta)
    */
    public function historicoPorUsuario($usuario_id){

        $sql = "SELECT
                    valor,
                    tipo,
                    descricao,
                    DATE_FORMAT(data_criacao, '%d/%m/%Y %H:%i') as data_criacao_formatada,
                    data_criacao
                FROM transacoes_scoins
                WHERE usuario_id = :usuario
                ORDER BY data_criacao DESC";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(":usuario", $usuario_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
    GORJETA NA COMUNIDADE
    */
    public function gorjeta($pagador_id, $recebedor_id, $valor, $post_id){
        try {
            $this->conexao->beginTransaction();

            if ($valor <= 0) {
                $this->conexao->rollBack();
                return false;
            }

            $sqlSaldo = "SELECT (saldo_scoins - saldo_bloqueado) as disponivel FROM usuarios WHERE id = :id";
            $stmtSaldo = $this->conexao->prepare($sqlSaldo);
            $stmtSaldo->bindParam(":id", $pagador_id, PDO::PARAM_INT);
            $stmtSaldo->execute();
            $dados = $stmtSaldo->fetch(PDO::FETCH_ASSOC);

            if (!$dados || $dados['disponivel'] < $valor) {
                $this->conexao->rollBack();
                return false;
            }

            $sqlDebit = "INSERT INTO transacoes_scoins (usuario_id, troca_id, valor, tipo, descricao, data_criacao) VALUES (:pagador, NULL, :valor, 'DEBITO', 'Gorjeta enviada na comunidade', NOW())";
            $stmtDebit = $this->conexao->prepare($sqlDebit);
            $stmtDebit->bindParam(":pagador", $pagador_id, PDO::PARAM_INT);
            $stmtDebit->bindParam(":valor", $valor);
            $stmtDebit->execute();

            $sqlUpDebit = "UPDATE usuarios SET saldo_scoins = saldo_scoins - :valor WHERE id = :pagador";
            $stmtUpDebit = $this->conexao->prepare($sqlUpDebit);
            $stmtUpDebit->bindParam(":valor", $valor);
            $stmtUpDebit->bindParam(":pagador", $pagador_id, PDO::PARAM_INT);
            $stmtUpDebit->execute();

            $sqlCredit = "INSERT INTO transacoes_scoins (usuario_id, troca_id, valor, tipo, descricao, data_criacao) VALUES (:recebedor, NULL, :valor, 'CREDITO', 'Gorjeta recebida na comunidade', NOW())";
            $stmtCredit = $this->conexao->prepare($sqlCredit);
            $stmtCredit->bindParam(":recebedor", $recebedor_id, PDO::PARAM_INT);
            $stmtCredit->bindParam(":valor", $valor);
            $stmtCredit->execute();

            $sqlUpCredit = "UPDATE usuarios SET saldo_scoins = saldo_scoins + :valor WHERE id = :recebedor";
            $stmtUpCredit = $this->conexao->prepare($sqlUpCredit);
            $stmtUpCredit->bindParam(":valor", $valor);
            $stmtUpCredit->bindParam(":recebedor", $recebedor_id, PDO::PARAM_INT);
            $stmtUpCredit->execute();

            $this->conexao->commit();
            return true;

        } catch (Exception $e) {
            $this->conexao->rollBack();
            error_log("Erro gorjeta: " . $e->getMessage());
            return false;
        }
    }

    /*
    BÔNUS DE BOAS-VINDAS
    */
    public function creditarBoasVindas($usuario_id, $valor = 50, $descricao = 'Bônus de boas-vindas') {
        try {
            $this->conexao->beginTransaction();

            if ($valor <= 0) {
                $this->conexao->rollBack();
                return false;
            }

            $check = $this->conexao->prepare(
                "SELECT id FROM transacoes_scoins 
                 WHERE usuario_id = :id AND descricao LIKE '%boas-vindas%' LIMIT 1"
            );
            $check->bindParam(":id", $usuario_id, PDO::PARAM_INT);
            $check->execute();
            if ($check->fetch()) {
                $this->conexao->rollBack();
                return false;
            }

            $ins = $this->conexao->prepare(
                "INSERT INTO transacoes_scoins (usuario_id, troca_id, valor, tipo, descricao, data_criacao)
                 VALUES (:id, NULL, :valor, 'CREDITO', :desc, NOW())"
            );
            $ins->execute([':id' => $usuario_id, ':valor' => $valor, ':desc' => $descricao]);

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