<main class="w-full" style="background: var(--color-bg-base); min-height: 80vh; padding: 4rem 0;">
    <div class="container" style="max-width: 650px;">
        <div class="glass-panel" style="background: white; padding: 3rem;">
            <div style="text-align: center; margin-bottom: 2.5rem;">
                <h2 class="hero__title" style="font-size: 2.2rem; margin: 0; line-height: 1.1;">✏️ Editar Serviço</h2>
            </div>

            <form method="POST" action="?url=servico/atualizar" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 1.5rem;">
                <?= Seguranca::csrfCampo() ?>
                <input type="hidden" name="id" value="<?= $servico['id'] ?>">

                <div>
                    <label style="font-weight: 600; color: var(--color-text-title); display: block; margin-bottom: 0.5rem;">Título</label>
                    <input type="text" name="titulo" value="<?= htmlspecialchars($servico['titulo']) ?>" required class="input-glass" style="border: 1px solid var(--color-border); background: var(--color-bg-base); width: 100%;">
                </div>

                <div>
                    <label style="font-weight: 600; color: var(--color-text-title); display: block; margin-bottom: 0.5rem;">Categoria</label>
                    <select name="categoria_id" class="input-glass" style="border: 1px solid var(--color-border); background: var(--color-bg-base); cursor: pointer; width: 100%;">
                        <option value="1" <?= $servico['categoria_id'] == 1 ? 'selected' : '' ?>>Tecnologia</option>
                        <option value="2" <?= $servico['categoria_id'] == 2 ? 'selected' : '' ?>>Educação</option>
                        <option value="3" <?= $servico['categoria_id'] == 3 ? 'selected' : '' ?>>Casa</option>
                        <option value="4" <?= $servico['categoria_id'] == 4 ? 'selected' : '' ?>>Serviços Gerais</option>
                        <option value="5" <?= $servico['categoria_id'] == 5 ? 'selected' : '' ?>>Saúde</option>
                        <option value="6" <?= $servico['categoria_id'] == 6 ? 'selected' : '' ?>>Aulas</option>
                    </select>
                </div>

                <div>
                    <label style="font-weight: 600; color: var(--color-text-title); display: block; margin-bottom: 0.5rem;">O que você oferece</label>
                    <textarea name="oferece" required class="input-glass" style="border: 1px solid var(--color-border); background: var(--color-bg-base); width: 100%; height: 100px; resize: none; border-radius: var(--radius-md);"><?= htmlspecialchars($servico['descricao_oferece']) ?></textarea>
                </div>

                <div>
                    <label style="font-weight: 600; color: var(--color-text-title); display: block; margin-bottom: 0.5rem;">O que aceita em troca</label>
                    <textarea name="aceita" required class="input-glass" style="border: 1px solid var(--color-border); background: var(--color-bg-base); width: 100%; height: 100px; resize: none; border-radius: var(--radius-md);"><?= htmlspecialchars($servico['descricao_aceita']) ?></textarea>
                </div>

                <div style="background: var(--color-bg-base); padding: 1.5rem; border-radius: var(--radius-md); border: 2px dashed var(--color-border);">
                    <label style="font-weight: 600; color: var(--color-text-title); display: block; margin-bottom: 0.5rem;">Nova foto (Opcional)</label>
                    <input type="file" name="foto" style="width: 100%; cursor: pointer;">
                </div>

                <button type="submit" class="btn btn--primary" style="padding: 1rem; margin-top: 1rem; font-size: 1.1rem;">Salvar alterações</button>
            </form>
        </div>
    </div>
</main>