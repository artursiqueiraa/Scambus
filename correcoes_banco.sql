-- =====================================================
-- SCAMBUS — CORREÇÕES DE BANCO DE DADOS
-- Execute este arquivo no phpMyAdmin do InfinityFree
-- Ordem: execute de cima para baixo
-- =====================================================

-- ─────────────────────────────────────────────────────
-- 1. VERIFICAR NOME REAL DA COLUNA DE TERMOS
--    (Descubra qual coluna existe no seu banco)
-- ─────────────────────────────────────────────────────
SHOW COLUMNS FROM usuarios LIKE 'aceit%';

-- ─────────────────────────────────────────────────────
-- 2. SE A COLUNA FOR aceite_termos, adicionar aceitou_termos
--    (Para compatibilidade total do código)
-- ─────────────────────────────────────────────────────
-- Execute APENAS se a query acima mostrar "aceite_termos":
ALTER TABLE usuarios ADD COLUMN IF NOT EXISTS aceitou_termos TINYINT(1) DEFAULT 0;
UPDATE usuarios SET aceitou_termos = aceite_termos WHERE aceitou_termos = 0 AND aceite_termos = 1;

-- ─────────────────────────────────────────────────────
-- 3. SE A COLUNA FOR aceitou_termos, adicionar aceite_termos
-- ─────────────────────────────────────────────────────
-- Execute APENAS se a query acima mostrar "aceitou_termos":
ALTER TABLE usuarios ADD COLUMN IF NOT EXISTS aceite_termos TINYINT(1) DEFAULT 0;
UPDATE usuarios SET aceite_termos = aceitou_termos WHERE aceite_termos = 0 AND aceitou_termos = 1;

-- ─────────────────────────────────────────────────────
-- 4. ZERRAR SERVIÇOS AUTOMÁTICOS (usuários de teste)
--    Identifica serviços suspeitos de usuários de teste
-- ─────────────────────────────────────────────────────
-- Primeiro, verifique quais são:
SELECT s.id, s.titulo, s.usuario_id, u.nome, u.email
FROM servicos s
JOIN usuarios u ON u.id = s.usuario_id
ORDER BY s.id ASC
LIMIT 20;

-- Se houver usuários de teste, delete os serviços deles:
-- (Substitua os IDs abaixo pelos IDs reais dos usuários de teste)
-- DELETE FROM servicos WHERE usuario_id IN (1, 2); -- descomente se necessário

-- Verifica triggers que criam serviços automaticamente:
SHOW TRIGGERS;

-- ─────────────────────────────────────────────────────
-- 5. AJUSTAR VALOR MÍNIMO DOS SERVIÇOS
--    Serviços sem valor definido ficam com 10 SCoins
-- ─────────────────────────────────────────────────────
UPDATE servicos SET valor_scoins = 10 WHERE valor_scoins IS NULL OR valor_scoins = 0;

-- ─────────────────────────────────────────────────────
-- 6. DAR 50 SCOINS AOS USUÁRIOS JÁ CADASTRADOS
--    (Retroativo para usuários que já estavam sem saldo)
-- ─────────────────────────────────────────────────────
-- Credita 50 SCoins aos usuários com saldo zero que ainda não receberam bônus:
INSERT INTO transacoes_scoins (usuario_id, troca_id, valor, tipo, descricao)
SELECT u.id, NULL, 50, 'CREDITO', 'Bônus de boas-vindas Scambus 🎉'
FROM usuarios u
WHERE u.saldo_scoins = 0
AND NOT EXISTS (
    SELECT 1 FROM transacoes_scoins t
    WHERE t.usuario_id = u.id AND t.descricao LIKE '%boas-vindas%'
);

UPDATE usuarios u
SET saldo_scoins = saldo_scoins + 50
WHERE saldo_scoins = 0
AND NOT EXISTS (
    SELECT 1 FROM transacoes_scoins t
    WHERE t.usuario_id = u.id AND t.descricao LIKE '%boas-vindas%'
    AND t.valor = 50
);

-- ─────────────────────────────────────────────────────
-- 7. GARANTIR QUE TABELAS DE COMUNIDADE EXISTEM
-- ─────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS comunidade_curtidas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    usuario_id INT NOT NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_curtida (post_id, usuario_id)
);

CREATE TABLE IF NOT EXISTS comunidade_comentarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    usuario_id INT NOT NULL,
    texto TEXT NOT NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ─────────────────────────────────────────────────────
-- 8. VERIFICAÇÃO FINAL — Confira os saldos
-- ─────────────────────────────────────────────────────
SELECT id, nome, email, saldo_scoins, saldo_bloqueado, nivel
FROM usuarios
ORDER BY id DESC
LIMIT 20;
