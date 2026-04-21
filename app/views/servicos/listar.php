<main class="w-full" style="background: var(--color-bg-base); min-height: 80vh; padding: 4rem 0;">
    <div class="container" style="max-width: var(--max-width);">

        <div style="display: flex; flex-wrap: wrap; gap: 3rem;">

            <!-- SIDEBAR -->
            <aside style="flex: 1; min-width: 250px; max-width: 320px; display: flex; flex-direction: column; gap: 2rem;">

                <!-- BUSCA -->
                <div class="glass-panel" style="background: white; padding: 1.5rem;">
                    <form method="GET" action="?url=servico/listar" style="display: flex; flex-direction: column; gap: 1rem;">
                        <input type="hidden" name="url" value="servico/listar">
                        <input 
                            type="text" 
                            name="q" 
                            placeholder="O que você precisa?" 
                            class="input-glass" 
                            style="width: 100%; border: 1px solid var(--color-border); padding: 0.8rem 1rem;"
                        >
                        <button type="submit" class="btn btn--accent" style="width: 100%;">Filtrar</button>
                    </form>
                </div>

                <!-- CATEGORIAS -->
                <div class="glass-panel" style="background: white; padding: 1.5rem;">
                    <h3 style="font-weight: 700; color: var(--color-text-title); font-family: 'Outfit'; margin-bottom: 1.25rem;">Categorias</h3>
                    <ul style="display: flex; flex-direction: column; gap: 0.75rem;">
                        <?php
                        $cats = [
                            1 => "💻 Tecnologia",
                            2 => "🎓 Educação",
                            3 => "🏠 Casa",
                            4 => "🔧 Serviços",
                            5 => "⚕ Saúde",
                            6 => "📚 Aulas"
                        ];
                        foreach($cats as $id => $nome):
                        ?>
                            <li>
                                <a href="?url=servico/categoria/<?= $id ?>" style="display: flex; justify-content: space-between; color: var(--color-text-body); text-decoration: none; font-weight: 500; font-size: 0.95rem;">
                                    <?= $nome ?>
                                    <span style="color: var(--color-primary);">→</span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

            </aside>

            <!-- CONTEÚDO -->
            <section style="flex: 3; min-width: 300px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                    <h1 class="hero__title" style="font-size: 2.2rem; text-align: left; margin: 0; line-height: 1.1;">Explorar serviços</h1>
                </div>

                <?php if(!empty($servicos)): ?>
                    <div class="grid" style="grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">
                        <?php foreach($servicos as $servico): ?>
                            <div class="service-card glass-panel" style="padding: 0; background: white;">
                                
                                <!-- IMAGEM -->
                                <?php if($servico['caminho_foto']): ?>
                                    <img src="<?= BASE_URL ?>/uploads/servicos/<?= htmlspecialchars($servico['caminho_foto']) ?>" class="service-card__image">
                                <?php else: ?>
                                    <div class="service-card__image" style="background: var(--color-primary-light); display: flex; align-items: center; justify-content: center; color: var(--color-primary); font-weight: 600;">Sem imagem</div>
                                <?php endif; ?>

                                <div class="service-card__content">
                                    <?php if(isset($servico['categoria'])): ?>
                                        <div class="badge badge--primary" style="margin-bottom: 0.75rem; display: inline-block;"><?= htmlspecialchars($servico['categoria']) ?></div>
                                    <?php endif; ?>

                                    <h3 class="service-card__title"><?= htmlspecialchars($servico['titulo']) ?></h3>
                                    
                                    <div style="color: var(--color-accent); font-size: 0.9rem; font-weight: 700; margin-bottom: 1rem;">
                                        ⭐ <?= $servico['avaliacao_media'] ? round($servico['avaliacao_media'],1) : "Nova" ?>
                                    </div>

                                    <div class="service-card__desc" style="flex: 1; display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.9rem;">
                                        <div><strong style="color: var(--color-text-title);">Oferece:</strong> <?= substr(htmlspecialchars($servico['descricao_oferece']), 0, 70) ?>...</div>
                                        <div><strong style="color: var(--color-text-title);">Troca por:</strong> <?= substr(htmlspecialchars($servico['descricao_aceita']), 0, 50) ?>...</div>
                                    </div>

                                    <div style="font-size: 0.8rem; color: var(--color-text-muted); margin-bottom: 1.5rem; margin-top: 1rem;">
                                        Ofertado por <strong style="color: var(--color-primary);"><?= htmlspecialchars($servico['nome']) ?></strong>
                                    </div>

                                    <div class="service-card__footer" style="margin-top: auto; padding-top: 0; border: none; display: flex; gap: 0.5rem;">
                                        <a href="?url=servico/ver/<?= $servico['id'] ?>" class="btn btn--accent" style="flex: 1; padding: 0.6rem; border-radius: var(--radius-pill); font-size: 0.85rem;">Ver</a>
                                        <a href="?url=usuario/perfil/<?= $servico['usuario_id'] ?>" class="btn btn--outline" style="flex: 1; padding: 0.6rem; border-radius: var(--radius-pill); font-size: 0.85rem;">Perfil</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="glass-panel" style="background: white; padding: 4rem; text-align: center;">
                        <p style="color: var(--color-text-body); font-size: 1.25rem;">Nenhum serviço encontrado 😢</p>
                    </div>
                <?php endif; ?>
            </section>

        </div>
    </div>
</main>