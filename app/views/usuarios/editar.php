<main class="w-full" style="background: var(--color-bg-base); min-height: 80vh; padding: 4rem 0;">
    <div class="container" style="max-width: 650px;">
        <div class="glass-panel" style="background: white; padding: 3rem;">
            
            <div style="text-align: center; margin-bottom: 2.5rem;">
                <h2 class="hero__title" style="font-size: 2.2rem; margin: 0;">👤 Editar Perfil</h2>
            </div>

            <form method="POST" action="?url=usuario/salvarPerfil" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 1.5rem;">
                <?= Seguranca::csrfCampo() ?>

                <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; margin-bottom: 1rem;">
                    <?php if(!empty($usuario['foto'])): ?>
                        <img id="preview" src="<?= BASE_URL ?>/uploads/perfis/<?= htmlspecialchars($usuario['foto']) ?>" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 3px solid var(--color-primary-light); margin-bottom: 1rem;">
                    <?php else: ?>
                        <div id="preview" style="width: 120px; height: 120px; border-radius: 50%; background: var(--color-bg-base); border: 2px dashed var(--color-border); display: flex; align-items: center; justify-content: center; font-size: 2.5rem; margin-bottom: 1rem;">📷</div>
                    <?php endif; ?>
                    <label class="btn btn--outline" style="cursor: pointer; font-size: 0.9rem; padding: 0.6rem 1.5rem; border-radius: var(--radius-pill); font-weight: 600;">
                        Alterar Foto
                        <input type="file" name="foto" id="foto" accept="image/*" style="display: none;">
                    </label>
                </div>

                <div>
                    <label style="font-weight: 600; color: var(--color-text-title); display: block; margin-bottom: 0.5rem;">Nome Completo</label>
                    <input type="text" name="nome" value="<?= htmlspecialchars($usuario['nome'] ?? '') ?>" class="input-glass" style="width: 100%; border: 1px solid var(--color-border); background: var(--color-bg-base); padding: 0.8rem 1rem;">
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem;">
                    <div>
                        <label style="font-weight: 600; color: var(--color-text-title); display: block; margin-bottom: 0.5rem;">Idade</label>
                        <input type="number" name="idade" value="<?= htmlspecialchars($usuario['idade'] ?? '') ?>" class="input-glass" style="width: 100%; border: 1px solid var(--color-border); background: var(--color-bg-base); padding: 0.8rem;">
                    </div>
                    <div>
                        <label style="font-weight: 600; color: var(--color-text-title); display: block; margin-bottom: 0.5rem;">Cidade</label>
                        <input type="text" name="cidade" value="<?= htmlspecialchars($usuario['cidade'] ?? '') ?>" class="input-glass" style="width: 100%; border: 1px solid var(--color-border); background: var(--color-bg-base); padding: 0.8rem;">
                    </div>
                    <div>
                        <label style="font-weight: 600; color: var(--color-text-title); display: block; margin-bottom: 0.5rem;">Estado</label>
                        <input type="text" name="estado" value="<?= htmlspecialchars($usuario['estado'] ?? '') ?>" class="input-glass" style="width: 100%; border: 1px solid var(--color-border); background: var(--color-bg-base); padding: 0.8rem;">
                    </div>
                </div>

                <div>
                    <label style="font-weight: 600; color: var(--color-text-title); display: block; margin-bottom: 0.5rem;">Formação Acadêmica</label>
                    <textarea name="formacao" rows="3" class="input-glass" placeholder="Quais são seus cursos e experiências?" style="width: 100%; resize: none; border-radius: var(--radius-md); border: 1px solid var(--color-border); background: var(--color-bg-base); padding: 1rem;"><?= htmlspecialchars($usuario['formacao'] ?? '') ?></textarea>
                </div>

                <div>
                    <label style="font-weight: 600; color: var(--color-text-title); display: block; margin-bottom: 0.5rem;">Biografia (Bio)</label>
                    <textarea name="bio" rows="4" class="input-glass" placeholder="Fale um pouco sobre você e seus objetivos..." style="width: 100%; resize: none; border-radius: var(--radius-md); border: 1px solid var(--color-border); background: var(--color-bg-base); padding: 1rem;"><?= htmlspecialchars($usuario['bio'] ?? '') ?></textarea>
                </div>

                <button type="submit" class="btn btn--accent" style="padding: 1rem; margin-top: 1rem; font-size: 1.1rem;">Atualizar Perfil</button>
            </form>
        </div>
    </div>
</main>

<script>
document.getElementById("foto").addEventListener("change", function(event){
    let file = event.target.files[0];
    if(file){
        let reader = new FileReader();
        reader.onload = function(e){
            let preview = document.getElementById("preview");
            if (preview.tagName.toLowerCase() === 'div') {
                let img = document.createElement('img');
                img.id = 'preview';
                img.src = e.target.result;
                img.style.width = '120px';
                img.style.height = '120px';
                img.style.borderRadius = '50%';
                img.style.objectFit = 'cover';
                img.style.border = '3px solid var(--color-primary-light)';
                img.style.marginBottom = '1rem';
                preview.parentNode.replaceChild(img, preview);
            } else {
                preview.src = e.target.result;
            }
        }
        reader.readAsDataURL(file);
    }
});
</script>