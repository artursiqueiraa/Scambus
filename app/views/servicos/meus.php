<main class="w-full" style="background: var(--color-bg-base); min-height: 80vh; padding: 4rem 0;">
    <div class="container" style="max-width: 1000px;">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem;">
            <h2 class="hero__title" style="font-size: 2.2rem; text-align: left; margin: 0;">🛠 Meus Serviços</h2>
            <a href="?url=servico/criar" class="btn btn--accent" style="font-size: 1rem;">+ Novo Serviço</a>
        </div>

        <?php if(empty($servicos)): ?>
            <div class="glass-panel" style="background: white; padding: 4rem; text-align: center;">
                <h3 style="font-size: 1.5rem; color: var(--color-text-title); margin-bottom: 1rem;">Você ainda não ofertou nenhum serviço</h3>
                <p style="color: var(--color-text-body); font-size: 1.1rem; margin-bottom: 1.5rem;">Crie anúncios para a comunidade e receba propostas de troca ou pague com Scoins.</p>
                <a href="?url=servico/criar" class="btn btn--primary">Publicar o primeiro</a>
            </div>
        <?php else: ?>
            <div class="grid" style="grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">
                <?php foreach($servicos as $s): ?>
                    <div class="service-card glass-panel" style="padding: 0; background: white; display: flex; flex-direction: column;">
                        <?php if(!empty($s['caminho_foto'])): ?>
                            <img src="<?= BASE_URL ?>/uploads/servicos/<?= htmlspecialchars($s['caminho_foto']) ?>" class="service-card__image">
                        <?php else: ?>
                            <div class="service-card__image" style="background: var(--color-primary-light); display: flex; align-items: center; justify-content: center; color: var(--color-primary); font-weight: 600;">Sem Imagem</div>
                        <?php endif; ?>

                        <div class="service-card__content">
                            <h4 class="service-card__title"><?= htmlspecialchars($s['titulo']) ?></h4>
                            <p class="service-card__desc" style="flex: 1;"><?= substr(htmlspecialchars($s['descricao_oferece']), 0, 70) ?>...</p>

                            <div class="service-card__footer" style="padding-top: 1rem; margin-top: auto; border-top: 1px solid var(--color-border); display: flex; gap: 0.5rem; justify-content: center;">
                                <a href="?url=servico/ver/<?= $s['id'] ?>" class="btn btn--outline" style="flex: 1; padding: 0.5rem; text-align: center; border-radius: var(--radius-sm);">Ver</a>
                                <a href="?url=servico/editar/<?= $s['id'] ?>" class="btn btn--primary" style="flex: 1; padding: 0.5rem; text-align: center; border-radius: var(--radius-sm);">Editar</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</main>