<main class="w-full" style="background: var(--color-bg-base); min-height: 80vh; padding: 4rem 0;">
    <div class="container" style="max-width: 800px;">
        <!-- SALDO -->
        <div class="glass-panel" style="background: var(--color-primary); color: white; padding: 2.5rem; border-radius: var(--radius-lg); margin-bottom: 3rem; position: relative; overflow: hidden;">
            <div style="position: absolute; right: -20px; bottom: -40px; font-size: 10rem; opacity: 0.05;">💰</div>
            <h2 style="font-family: 'Outfit'; margin: 0; font-size: 1.25rem; color: var(--color-primary-light);">Minha Carteira</h2>
            <div style="font-size: 3.5rem; font-weight: 800; font-family: 'Outfit'; margin-top: 0.5rem; line-height: 1;">
                <?= $usuario['saldo_scoins'] ?> <span style="font-size: 1.5rem; font-weight: 600; color: var(--color-primary-light);">Scoins</span>
            </div>
        </div>

        <!-- HISTÓRICO -->
        <h3 class="hero__title" style="font-size: 1.8rem; margin-bottom: 1.5rem; text-align: left;">📊 Histórico de transações</h3>
        
        <?php if($transacoes): ?>
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <?php foreach($transacoes as $t): ?>
                    <div class="glass-panel" style="background: white; display: flex; justify-content: space-between; align-items: center; padding: 1.5rem;">
                        <div style="display: flex; flex-direction: column; gap: 0.4rem;">
                            <span style="font-weight: 700; color: var(--color-text-title); font-size: 1.1rem;"><?= htmlspecialchars($t['descricao']) ?></span>
                            <span style="font-size: 0.85rem; color: var(--color-text-muted); font-family: 'Outfit'; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;"><?= $t['tipo'] ?></span>
                            <span style="font-size: 0.85rem; color: var(--color-text-muted);"><?= date('d/m/Y H:i', strtotime($t['data_criacao'])) ?></span>
                        </div>
                        <div style="font-size: 1.5rem; font-weight: 800; font-family: 'Outfit'; color: <?= $t['tipo'] == 'CREDITO' ? 'var(--color-accent)' : '#EF4444' ?>;">
                            <?= $t['tipo'] == 'CREDITO' ? '+' : '-' ?><?= $t['valor'] ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="glass-panel" style="background: white; padding: 4rem; text-align: center;">
                <h3 style="font-size: 1.5rem; color: var(--color-text-title); margin-bottom: 1rem;">😢 Nenhuma transação ainda</h3>
                <p style="color: var(--color-text-body);">Realize trocas para ganhar Scoins 🚀</p>
                <a href="?url=servico/listar" class="btn btn--accent" style="margin-top: 1.5rem;">Achar Serviços</a>
            </div>
        <?php endif; ?>
    </div>
</main>