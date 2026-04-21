-- ============================================================
-- SCAMBUS — MIGRAÇÃO CORRIGIDA
-- Execute TUDO de uma vez (selecione tudo e clique Execute)
-- ============================================================

-- Desabilitar modo seguro temporariamente
SET SQL_SAFE_UPDATES = 0;

-- ═══════════════════════════════════════════════════════════
-- PASSO 1: TABELA USUARIOS (se já rodou, vai dar aviso, ignore)
-- ═══════════════════════════════════════════════════════════

ALTER TABLE usuarios
  ADD COLUMN IF NOT EXISTS saldo_bloqueado DECIMAL(10,2) NOT NULL DEFAULT 0.00
  AFTER saldo_scoins;

ALTER TABLE usuarios
  ADD COLUMN IF NOT EXISTS aceite_termos TINYINT(1) NOT NULL DEFAULT 0;

-- ═══════════════════════════════════════════════════════════
-- PASSO 2: TABELA TROCAS — um por vez
-- ═══════════════════════════════════════════════════════════

ALTER TABLE trocas
  ADD COLUMN IF NOT EXISTS valor_scoins DECIMAL(10,2) NOT NULL DEFAULT 0.00
  AFTER status;

ALTER TABLE trocas
  ADD COLUMN IF NOT EXISTS scoins_creditados TINYINT(1) NOT NULL DEFAULT 0
  AFTER valor_scoins;

ALTER TABLE trocas
  ADD COLUMN IF NOT EXISTS cancelado_por INT(11) DEFAULT NULL
  AFTER scoins_creditados;

-- ═══════════════════════════════════════════════════════════
-- PASSO 3: MARCAR TROCAS JÁ FINALIZADAS
-- ═══════════════════════════════════════════════════════════

UPDATE trocas SET scoins_creditados = 1 WHERE status = 'FINALIZADA';

-- ═══════════════════════════════════════════════════════════
-- PASSO 4: LIMPAR CRÉDITOS DUPLICADOS
-- Mantém o registro com menor ID de cada combinação
-- ═══════════════════════════════════════════════════════════

DELETE FROM transacoes_scoins
WHERE id NOT IN (
    SELECT min_id FROM (
        SELECT MIN(id) as min_id
        FROM transacoes_scoins
        GROUP BY usuario_id, troca_id, tipo
    ) AS ids_unicos
);

-- ═══════════════════════════════════════════════════════════
-- PASSO 5: CRIAR ÍNDICE UNIQUE (agora sem duplicatas)
-- ═══════════════════════════════════════════════════════════

-- Dropar se já existir (para evitar erro)
DROP INDEX IF EXISTS idx_unico_credito ON transacoes_scoins;

ALTER TABLE transacoes_scoins
  ADD UNIQUE INDEX idx_unico_credito (usuario_id, troca_id, tipo);

-- ═══════════════════════════════════════════════════════════
-- PASSO 6: REATIVAR MODO SEGURO
-- ═══════════════════════════════════════════════════════════

SET SQL_SAFE_UPDATES = 1;

-- ═══════════════════════════════════════════════════════════
-- PASSO 7: VERIFICAÇÃO — confira se está tudo certo
-- ═══════════════════════════════════════════════════════════

SELECT 'COLUNAS TROCAS' as info, COLUMN_NAME 
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = 'scambus_db' AND TABLE_NAME = 'trocas'
ORDER BY ORDINAL_POSITION;

SELECT 'COLUNAS USUARIOS' as info, COLUMN_NAME 
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = 'scambus_db' AND TABLE_NAME = 'usuarios'
ORDER BY ORDINAL_POSITION;

SELECT 'TRANSACOES (sem duplicatas)' as info, COUNT(*) as total FROM transacoes_scoins;
