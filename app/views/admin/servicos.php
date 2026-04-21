<main class="w-full" style="background: var(--color-bg-base); min-height: 80vh; padding: 4rem 0;">
    <div class="container" style="max-width: 1100px;">

        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2.5rem; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h2 class="hero__title" style="font-size: 2.2rem; margin: 0; text-align: left;">🧰 Serviços Cadastrados</h2>
                <p style="color: var(--color-text-muted); margin-top: 0.25rem;">Moderação dos serviços publicados na plataforma</p>
            </div>
            <a href="?url=admin/dashboard" class="btn btn--outline" style="border-radius: var(--radius-pill); padding: 0.6rem 1.5rem;">← Voltar ao Painel</a>
        </div>

        <?php if(!empty($servicos)): ?>

            <div class="grid" style="grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">

                <?php foreach($servicos as $servico): ?>

                    <div class="glass-panel" style="background: white; padding: 0; overflow: hidden; display: flex; flex-direction: column;">

                        <?php if(!empty($servico['caminho_foto'])): ?>
                            <img src="<?= BASE_URL ?>/uploads/servicos/<?= htmlspecialchars($servico['caminho_foto']) ?>" style="width: 100%; height: 160px; object-fit: cover;">
                        <?php else: ?>
                            <div style="width: 100%; height: 160px; background: var(--color-primary-light); display: flex; align-items: center; justify-content: center; color: var(--color-primary); font-weight: 600;">Sem imagem</div>
                        <?php endif; ?>

                        <div style="padding: 1.25rem; flex: 1; display: flex; flex-direction: column; gap: 0.5rem;">

                            <div style="display: flex; justify-content: space-between; align-items: start; gap: 0.5rem;">
                                <h3 style="font-size: 1rem; font-weight: 700; color: var(--color-text-title); margin: 0; line-height: 1.3;"><?= htmlspecialchars($servico['titulo']) ?></h3>
                                <?php if($servico['status'] == 'ATIVO'): ?>
                                    <span style="background: #DCFCE7; color: #16A34A; padding: 0.25rem 0.6rem; border-radius: var(--radius-pill); font-size: 0.7rem; font-weight: 700; white-space: nowrap;">Ativo</span>
                                <?php else: ?>
                                    <span style="background: #FEE2E2; color: #DC2626; padding: 0.25rem 0.6rem; border-radius: var(--radius-pill); font-size: 0.7rem; font-weight: 700; white-space: nowrap;">Inativo</span>
                                <?php endif; ?>
                            </div>

                            <div style="font-size: 0.85rem; color: var(--color-text-muted);">📂 <?= htmlspecialchars($servico['categoria'] ?? 'Sem categoria') ?></div>
                            <div style="font-size: 0.85rem; color: var(--color-text-muted);">👤 <?= htmlspecialchars($servico['nome']) ?></div>

                            <div style="display: flex; gap: 0.75rem; margin-top: auto; padding-top: 1rem; border-top: 1px solid var(--color-border);">
                                <a href="?url=servico/ver/<?= $servico['id'] ?>" class="btn btn--outline" style="flex: 1; text-align: center; padding: 0.5rem; border-radius: var(--radius-sm); font-size: 0.85rem;">👁 Ver</a>
                                <a href="?url=admin/excluirServico/<?= $servico['id'] ?>"
                                   onclick="return confirm('Deseja excluir este serviço?')"
                                   class="btn btn--outline" style="flex: 1; text-align: center; padding: 0.5rem; border-radius: var(--radius-sm); font-size: 0.85rem; border-color: #DC2626; color: #DC2626;">🗑 Excluir</a>
                            </div>

                        </div>
                    </div>

                <?php endforeach; ?>

            </div>

        <?php else: ?>
            <div class="glass-panel" style="background: white; padding: 4rem; text-align: center;">
                <h3 style="color: var(--color-text-title); font-size: 1.5rem;">😢 Nenhum serviço cadastrado</h3>
            </div>
        <?php endif; ?>

    </div>
</main>