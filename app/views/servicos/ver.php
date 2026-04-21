<main class="w-full" style="background: var(--color-bg-base); min-height: 80vh; padding: 4rem 0;">
    <div class="container" style="max-width: 1000px;">
        
        <div class="glass-panel" style="background: white; padding: 4rem; border-top: 4px solid var(--color-primary);">

            <!-- HEADER -->
            <div style="display: flex; justify-content: space-between; align-items: start; gap: 2rem; margin-bottom: 2.5rem; flex-wrap: wrap;">
                <h2 class="hero__title" style="font-size: 2.5rem; text-align: left; margin: 0; line-height: 1.1;"><?= htmlspecialchars($servico['titulo']) ?></h2>
                <span class="badge" style="background: <?= $servico['status'] == 'ATIVO' ? 'var(--color-accent)' : '#EF4444' ?>; color: white; padding: 0.5rem 1rem; font-size: 0.9rem;">
                    <?= $servico['status'] ?>
                </span>
            </div>

            <!-- GALERIA -->
            <div style="display: flex; gap: 1rem; margin-bottom: 4rem; flex-wrap: wrap;">
                <div style="flex: 1; min-width: 300px;">
                    <img id="imgPrincipal" src="<?= BASE_URL ?>/uploads/servicos/<?= $fotos[0]['caminho_foto'] ?? 'sem.jpg' ?>" style="width: 100%; height: 450px; object-fit: cover; border-radius: var(--radius-lg); border: 1px solid var(--color-border); box-shadow: var(--shadow-sm);">
                </div>
                
                <?php if(count($fotos) > 1): ?>
                <div style="display: flex; flex-direction: column; gap: 1rem; width: 90px;">
                    <?php foreach($fotos as $foto): ?>
                        <img src="<?= BASE_URL ?>/uploads/servicos/<?= htmlspecialchars($foto['caminho_foto']) ?>" onclick="trocarImagem(this.src)" style="width: 90px; height: 90px; object-fit: cover; border-radius: var(--radius-md); border: 2px solid transparent; cursor: pointer; transition: 0.2s;" onmouseover="this.style.borderColor='var(--color-primary)'" onmouseout="this.style.borderColor='transparent'">
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- DESCRIÇÃO -->
            <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 4rem; margin-bottom: 3rem;">
                <div>
                    <h4 style="font-family: 'Outfit'; font-weight: 700; font-size: 1.25rem; color: var(--color-text-title); margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.75rem;"><span style="font-size: 1.5rem;">💼</span> O que oferece</h4>
                    <div style="color: var(--color-text-body); line-height: 1.8; font-size: 1rem;"><?= nl2br(htmlspecialchars($servico['descricao_oferece'])) ?></div>
                </div>

                <div>
                    <h4 style="font-family: 'Outfit'; font-weight: 700; font-size: 1.25rem; color: var(--color-text-title); margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.75rem;"><span style="font-size: 1.5rem;">🔁</span> O que aceita em troca</h4>
                    <div style="color: var(--color-text-body); line-height: 1.8; font-size: 1rem;"><?= nl2br(htmlspecialchars($servico['descricao_aceita'])) ?></div>
                </div>
            </div>

            <div style="padding-top: 2rem; border-top: 1px solid var(--color-border); margin-bottom: 3rem; display: flex; align-items: center; gap: 1rem;">
                <div style="width: 50px; height: 50px; background: var(--color-primary-light); color: var(--color-primary); border-radius: var(--radius-pill); display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">👤</div>
                <div>
                    <h4 style="font-family: 'Outfit'; font-weight: 700; font-size: 1.1rem; color: var(--color-text-title); margin: 0; margin-bottom: 0.2rem;">Ofertado por</h4>
                    <div style="color: var(--color-text-body); font-size: 0.95rem;"><a href="?url=usuario/perfil/<?= $servico['usuario_id'] ?>" style="color: var(--color-primary); font-weight: 600; text-decoration: none;"><?= htmlspecialchars($servico['nome']) ?></a></div>
                </div>
            </div>

            <!-- AÇÕES -->
            <div style="display: flex; gap: 1.5rem; flex-wrap: wrap;">
                <?php if($_SESSION['usuario_id'] == $servico['usuario_id']): ?>
                    <a href="?url=servico/editar/<?= $servico['id'] ?>" class="btn btn--primary">✏️ Editar Serviço</a>
                    <a href="?url=servico/status/<?= $servico['id'] ?>" class="btn btn--outline" style="background: white;">Ativar/Desativar</a>
                    <a href="?url=servico/excluir/<?= $servico['id'] ?>" class="btn btn--outline" style="border-color: #EF4444; color: #EF4444;">Excluir</a>
                <?php else: ?>
                    <a href="?url=troca/propor/<?= $servico['id'] ?>" class="btn btn--accent" style="font-size: 1.1rem; padding: 1rem 2.5rem; width: 100%;">🤝 Propor Troca</a>
                <?php endif; ?>
            </div>

        </div>

    </div>
</main>

<script>
function trocarImagem(src){
    document.getElementById('imgPrincipal').src = src;
}
</script>