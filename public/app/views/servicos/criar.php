<main class="w-full" style="background: var(--color-bg-base); min-height: 80vh; padding: 4rem 0;">
    <div class="container" style="max-width: 650px;">
        
        <div class="glass-panel" style="background: white; padding: 3rem;">
            <div style="text-align: center; margin-bottom: 2.5rem;">
                <div style="width: 60px; height: 60px; background: var(--color-primary-light); color: var(--color-primary); border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin: 0 auto 1rem;">🚀</div>
                <h2 class="hero__title" style="font-size: 2rem; margin: 0; line-height: 1.1;">Criar novo serviço</h2>
                <p style="color: var(--color-text-muted); font-size: 1rem; margin-top: 0.5rem;">Compartilhe suas habilidades com a comunidade</p>
            </div>

            <form method="POST" action="?url=servico/salvar" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 1.5rem;">
                <?= Seguranca::csrfCampo() ?>

                <div>
                    <label style="font-weight: 600; font-size: 0.9rem; color: var(--color-text-title); margin-bottom: 0.5rem; display: block;">Título do Serviço</label>
                    <input type="text" name="titulo" required class="input-glass" placeholder="Ex: Aulas de Violão para Iniciantes" style="border: 1px solid var(--color-border); background: var(--color-bg-base);">
                </div>

                <div>
                    <label style="font-weight: 600; font-size: 0.9rem; color: var(--color-text-title); margin-bottom: 0.5rem; display: block;">O que você oferece</label>
                    <textarea name="oferece" required rows="3" class="input-glass" placeholder="Descreva os detalhes do que você fará" style="border: 1px solid var(--color-border); background: var(--color-bg-base); border-radius: var(--radius-md);"></textarea>
                </div>

                <div>
                    <label style="font-weight: 600; font-size: 0.9rem; color: var(--color-text-title); margin-bottom: 0.5rem; display: block;">O que aceita em troca</label>
                    <textarea name="aceita" required rows="3" class="input-glass" placeholder="Descreva as habilidades ou Scoins desejadas" style="border: 1px solid var(--color-border); background: var(--color-bg-base); border-radius: var(--radius-md);"></textarea>
                </div>

                <div>
                    <label style="font-weight: 600; font-size: 0.9rem; color: var(--color-text-title); margin-bottom: 0.5rem; display: block;">Categoria</label>
                    <select name="categoria_id" required class="input-glass" style="border: 1px solid var(--color-border); background: var(--color-bg-base); cursor: pointer;">
                        <option value="">Selecione uma categoria</option>
                        <option value="1">Tecnologia</option>
                        <option value="2">Educação</option>
                        <option value="3">Casa</option>
                        <option value="4">Serviços Gerais</option>
                        <option value="5">Saúde</option>
                        <option value="6">Aulas</option>
                    </select>
                </div>

                <div style="background: var(--color-bg-base); padding: 1.5rem; border-radius: var(--radius-md); border: 2px dashed var(--color-border);">
                    <label style="font-weight: 600; font-size: 0.9rem; color: var(--color-text-title); margin-bottom: 0.5rem; display: block;">Fotos do serviço</label>
                    <input type="file" name="fotos[]" multiple onchange="previewFotos(event)" style="width: 100%; margin-bottom: 1rem; cursor: pointer;">
                    
                    <!-- PREVIEW -->
                    <div id="preview" style="display: flex; gap: 0.75rem; flex-wrap: wrap;"></div>
                </div>

                <button type="submit" class="btn btn--primary" style="padding: 1rem; font-size: 1.1rem; margin-top: 1rem;">
                    Publicar Serviço
                </button>

            </form>

        </div>
    </div>
</main>

<script>
function previewFotos(event){
    const preview = document.getElementById('preview');
    preview.innerHTML = "";

    for(let file of event.target.files){
        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        img.style.width = "80px";
        img.style.height = "80px";
        img.style.objectFit = "cover";
        img.style.borderRadius = "var(--radius-sm)";
        img.style.border = "1px solid var(--color-border)";
        preview.appendChild(img);
    }
}
</script>