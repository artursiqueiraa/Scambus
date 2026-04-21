<?php if(!$usuario): ?>
    <p class="container mt-lg text-center" style="color: var(--color-text-body);">Usuário não encontrado.</p>
<?php return; endif; ?>

<main class="w-full" style="background: var(--color-bg-base); min-height: 80vh; padding: 4rem 0;">
    <div class="container" style="max-width: 1000px;">
    
        <!-- HEADER -->
        <div class="glass-panel" style="background: white; padding: 2.5rem; display: flex; align-items: center; gap: 2.5rem; margin-bottom: 4rem;">
            <div style="flex-shrink: 0;">
                <?php if(!empty($usuario['foto'])): ?>
                    <img src="<?= BASE_URL ?>/uploads/perfis/<?= htmlspecialchars($usuario['foto']) ?>" style="width: 140px; height: 140px; border-radius: 50%; object-fit: cover; border: 4px solid var(--color-primary-light);">
                <?php else: ?>
                    <div style="width: 140px; height: 140px; border-radius: 50%; background: var(--color-primary-light); color: var(--color-primary); display: flex; justify-content: center; align-items: center; font-size: 3.5rem;">👤</div>
                <?php endif; ?>
            </div>
            
            <div>
                <h2 class="hero__title" style="font-size: 2.2rem; margin-bottom: 0.5rem; text-align: left; line-height: 1.1;"><?= htmlspecialchars($usuario['nome']) ?></h2>
                <div class="badge" style="margin-bottom: 1rem; background: var(--color-accent); color: white;">
                    ⭐ <?= $usuario['avaliacao_media'] ? round($usuario['avaliacao_media'], 1) : "Novo Membro" ?>
                </div>
                <div style="color: var(--color-text-body); font-size: 0.95rem; margin-bottom: 0.4rem;">
                    🔁 Trocas realizadas: <strong style="color: var(--color-text-title);"><?= $usuario['total_trocas'] ?></strong>
                </div>
                <div style="color: var(--color-text-body); font-size: 0.95rem; margin-bottom: 0.4rem;">
                    📍 <?= htmlspecialchars($usuario['cidade'] ?? '-') ?> / <?= htmlspecialchars($usuario['estado'] ?? '-') ?>
                </div>
                <div style="color: var(--color-text-body); font-size: 0.95rem; margin-bottom: 0.4rem;">
                    🎓 <?= htmlspecialchars($usuario['formacao'] ?? 'Formação não informada') ?>
                </div>
                <div style="color: var(--color-text-body); font-size: 0.95rem;">
                    📝 <?= htmlspecialchars($usuario['bio'] ?? 'Nenhuma biografia cadastrada.') ?>
                </div>
            </div>
        </div>

        <!-- SERVIÇOS -->
        <h3 style="font-size: 1.5rem; font-family: 'Outfit'; font-weight: 700; color: var(--color-text-title); margin-bottom: 1.5rem;">🛠️ Serviços oferecidos</h3>
        <?php if(!empty($servicos)): ?>
            <div class="grid" style="grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 4rem;">
                <?php foreach($servicos as $servico): ?>
                    <div class="glass-panel service-card" style="padding: 0; display: flex; flex-direction: column;">
                        <?php if(!empty($servico['caminho_foto'])): ?>
                            <img src="<?= BASE_URL ?>/uploads/servicos/<?= htmlspecialchars($servico['caminho_foto']) ?>" class="service-card__image">
                        <?php else: ?>
                            <div class="service-card__image" style="background: var(--color-primary-light); color: var(--color-primary); display: flex; justify-content: center; align-items: center; font-weight: 600;">Sem foto</div>
                        <?php endif; ?>
                        
                        <div class="service-card__content">
                            <h4 class="service-card__title"><?= htmlspecialchars($servico['titulo']) ?></h4>
                            <p class="service-card__desc" style="flex: 1;"><?= substr(htmlspecialchars($servico['descricao_oferece']), 0, 70) ?>...</p>
                            
                            <div class="service-card__footer" style="margin-top: auto; padding-top: 1rem; border-top: 1px solid var(--color-border); text-align: center;">
                                <a href="?url=servico/ver/<?= $servico['id'] ?>" class="btn btn--outline" style="width: 100%; border-radius: var(--radius-sm); padding: 0.6rem;">
                                    Ver detalhes
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="glass-panel" style="background: white; padding: 2rem; margin-bottom: 4rem; text-align: center;">
                <p style="color: var(--color-text-body);">Este usuário ainda não possui serviços cadastrados.</p>
            </div>
        <?php endif; ?>

        <!-- AVALIAÇÕES -->
        <h3 style="font-size: 1.5rem; font-family: 'Outfit'; font-weight: 700; color: var(--color-text-title); margin-bottom: 1.5rem;">⭐ Avaliações recebidas</h3>
        <?php if(!empty($avaliacoes)): ?>
            <div class="grid" style="grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
                <?php foreach($avaliacoes as $a): ?>
                    <div class="glass-panel" style="background: white; padding: 1.5rem; border-top: 3px solid var(--color-accent);">
                        <div style="font-weight: 800; color: var(--color-accent); font-size: 1.2rem; margin-bottom: 0.5rem;">⭐ <?= $a['nota'] ?>.0</div>
                        <p style="color: var(--color-text-body); font-size: 0.95rem; margin-bottom: 1rem; line-height: 1.6; font-style: italic;">"<?= htmlspecialchars($a['comentario']) ?>"</p>
                        <div style="font-size: 0.8rem; color: var(--color-text-muted); font-weight: 600; text-transform: uppercase;">Avaliador: <span style="color: var(--color-text-title);"><?= htmlspecialchars($a['avaliador_nome']) ?></span></div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="glass-panel" style="background: white; padding: 2rem; text-align: center;">
                <p style="color: var(--color-text-body);">Este usuário ainda não possui avaliações.</p>
            </div>
        <?php endif; ?>

    </div>
</main>