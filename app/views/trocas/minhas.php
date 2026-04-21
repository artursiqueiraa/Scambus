<main class="w-full" style="background: var(--color-bg-base); min-height: 80vh; padding: 4rem 0;">
    <div class="container" style="max-width: 1000px;">
        <h2 class="hero__title" style="font-size: 2.5rem; margin-bottom: 2.5rem; text-align: left;">🔁 Minhas Trocas</h2>

        <?php if(empty($trocas)): ?>
            <div class="glass-panel" style="background: white; padding: 4rem; text-align: center;">
                <h3 style="font-size: 1.5rem; color: var(--color-text-title); margin-bottom: 1rem;">Você ainda não possui trocas ativas</h3>
                <p style="color: var(--color-text-body); margin-bottom: 2rem;">Explore serviços maravilhosos oferecidos pela comunidade e comece 🚀</p>
                <a href="?url=servico/listar" class="btn btn--accent">🔍 Explorar serviços</a>
            </div>
        <?php else: ?>
            <div class="grid" style="grid-template-columns: repeat(auto-fill, minmax(400px, 1fr)); gap: 1.5rem;">
                <?php foreach($trocas as $troca): ?>
                    <div class="glass-panel" style="background: white; padding: 1.5rem; display: flex; gap: 1.5rem; align-items: start;">
                        <!-- IMAGEM -->
                        <div style="flex-shrink: 0;">
                            <?php if($troca['caminho_foto']): ?>
                                <img src="<?= BASE_URL ?>/uploads/servicos/<?= htmlspecialchars($troca['caminho_foto']) ?>" style="width: 100px; height: 100px; object-fit: cover; border-radius: var(--radius-sm); border: 1px solid var(--color-border);">
                            <?php else: ?>
                                <div style="width: 100px; height: 100px; background: var(--color-bg-base); display: flex; align-items: center; justify-content: center; border-radius: var(--radius-sm); border: 1px solid var(--color-border); font-size: 0.8rem; color: var(--color-text-muted);">Sem Imagem</div>
                            <?php endif; ?>
                        </div>

                        <!-- CONTEÚDO -->
                        <div style="flex: 1;">
                            <div style="display: flex; justify-content: space-between; align-items: start; gap: 1rem; margin-bottom: 0.5rem;">
                                <h3 style="font-size: 1.1rem; font-weight: 700; color: var(--color-text-title); line-height: 1.3; margin: 0;"><?= htmlspecialchars($troca['titulo']) ?></h3>
                                <?php 
                                    $status = strtolower($troca['status']);
                                    $bg = 'var(--color-bg-base)';
                                    $cor = 'var(--color-text-body)';
                                    if($status == "pendente") { $bg = '#FEF3C7'; $cor = '#D97706'; }
                                    if($status == "aceito" || $status == "em_andamento") { $bg = 'var(--color-primary-light)'; $cor = 'var(--color-primary)'; }
                                    if($status == "recusado") { $bg = '#FEE2E2'; $cor = '#EF4444'; }
                                    if($status == "finalizado") { $bg = '#DCFCE7'; $cor = '#16A34A'; }
                                ?>
                                <span class="badge" style="background: <?= $bg ?>; color: <?= $cor ?>; padding: 0.3rem 0.6rem; font-size: 0.75rem; white-space: nowrap;">
                                    <?= htmlspecialchars($troca['status']) ?>
                                </span>
                            </div>

                            <div style="font-size: 0.9rem; color: var(--color-text-body); margin-bottom: 0.25rem;"><strong style="color: var(--color-text-title);">Origem:</strong> <?= htmlspecialchars($troca['nome_origem']) ?></div>
                            <div style="font-size: 0.9rem; color: var(--color-text-body); margin-bottom: 1rem;"><strong style="color: var(--color-text-title);">Destino:</strong> <?= htmlspecialchars($troca['nome_destino']) ?></div>

                            <div style="display: flex; gap: 0.75rem;">
                                <a href="?url=troca/chat/<?= $troca['id'] ?>" class="btn btn--primary" style="flex: 1; padding: 0.5rem; border-radius: var(--radius-sm); font-size: 0.9rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">💬 Chat</a>
                                <a href="?url=servico/ver/<?= $troca['servico_id'] ?>" class="btn btn--outline" style="flex: 1; padding: 0.5rem; border-radius: var(--radius-sm); font-size: 0.9rem; display: flex; align-items: center; justify-content: center;">👁 Ver Serviço</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</main>