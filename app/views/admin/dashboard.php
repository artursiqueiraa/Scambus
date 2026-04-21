<main class="w-full" style="background: var(--color-bg-base); min-height: 80vh; padding: 4rem 0;">
    <div class="container" style="max-width: 1100px;">

        <!-- HEADER -->
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 3rem; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h2 class="hero__title" style="font-size: 2.5rem; margin: 0; text-align: left;">⚙️ Painel Administrativo</h2>
                <p style="color: var(--color-text-muted); margin-top: 0.5rem; font-size: 1.05rem;">Controle e monitoramento geral da plataforma Scambus</p>
            </div>
            <div style="background: var(--color-primary); color: white; padding: 0.6rem 1.25rem; border-radius: var(--radius-pill); font-family: 'Outfit'; font-weight: 700; font-size: 0.85rem; letter-spacing: 0.5px;">
                🛡️ ADMIN
            </div>
        </div>

        <!-- CARDS DE MÉTRICAS -->
        <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem; margin-bottom: 3rem;">

            <div class="glass-panel" style="background: white; padding: 2rem; border-left: 5px solid var(--color-primary); position: relative; overflow: hidden;">
                <div style="position: absolute; right: 1rem; top: 1rem; font-size: 2.5rem; opacity: 0.08;">👥</div>
                <div style="font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: var(--color-primary);">Usuários cadastrados</div>
                <div style="font-size: 3rem; font-weight: 800; font-family: 'Outfit'; color: var(--color-text-title); line-height: 1.1; margin-top: 0.5rem;"><?= $totalUsuarios ?></div>
            </div>

            <div class="glass-panel" style="background: white; padding: 2rem; border-left: 5px solid var(--color-accent); position: relative; overflow: hidden;">
                <div style="position: absolute; right: 1rem; top: 1rem; font-size: 2.5rem; opacity: 0.08;">🧰</div>
                <div style="font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: var(--color-accent);">Serviços publicados</div>
                <div style="font-size: 3rem; font-weight: 800; font-family: 'Outfit'; color: var(--color-text-title); line-height: 1.1; margin-top: 0.5rem;"><?= $totalServicos ?></div>
            </div>

            <div class="glass-panel" style="background: white; padding: 2rem; border-left: 5px solid #10b981; position: relative; overflow: hidden;">
                <div style="position: absolute; right: 1rem; top: 1rem; font-size: 2.5rem; opacity: 0.08;">🔁</div>
                <div style="font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #10b981;">Trocas realizadas</div>
                <div style="font-size: 3rem; font-weight: 800; font-family: 'Outfit'; color: var(--color-text-title); line-height: 1.1; margin-top: 0.5rem;"><?= $totalTrocas ?></div>
            </div>

        </div>

        <!-- ACESSO RÁPIDO -->
        <h3 class="hero__title" style="font-size: 1.6rem; text-align: left; margin-bottom: 1.5rem;">🛠 Gerenciamento</h3>

        <div class="grid" style="grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1.25rem;">

            <a href="?url=admin/usuarios" class="glass-panel" style="background: white; padding: 2rem; text-decoration: none; display: flex; align-items: center; gap: 1.25rem; transition: all 0.2s; border: 2px solid transparent;">
                <div style="width: 52px; height: 52px; background: var(--color-primary-light); border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; flex-shrink: 0;">👥</div>
                <div>
                    <div style="font-weight: 700; color: var(--color-text-title); font-size: 1.05rem;">Gerenciar Usuários</div>
                    <div style="font-size: 0.85rem; color: var(--color-text-muted); margin-top: 0.25rem;">Bloquear, desbloquear e excluir</div>
                </div>
            </a>

            <a href="?url=admin/servicos" class="glass-panel" style="background: white; padding: 2rem; text-decoration: none; display: flex; align-items: center; gap: 1.25rem; transition: all 0.2s; border: 2px solid transparent;">
                <div style="width: 52px; height: 52px; background: #FEF3C7; border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; flex-shrink: 0;">🧰</div>
                <div>
                    <div style="font-weight: 700; color: var(--color-text-title); font-size: 1.05rem;">Gerenciar Serviços</div>
                    <div style="font-size: 0.85rem; color: var(--color-text-muted); margin-top: 0.25rem;">Moderar e remover publicações</div>
                </div>
            </a>

            <a href="?url=admin/documentacao" class="glass-panel" style="background: white; padding: 2rem; text-decoration: none; display: flex; align-items: center; gap: 1.25rem; transition: all 0.2s; border: 2px solid transparent;">
                <div style="width: 52px; height: 52px; background: #DCFCE7; border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; flex-shrink: 0;">📐</div>
                <div>
                    <div style="font-weight: 700; color: var(--color-text-title); font-size: 1.05rem;">Documentação Técnica</div>
                    <div style="font-size: 0.85rem; color: var(--color-text-muted); margin-top: 0.25rem;">Diagramas UML e arquitetura</div>
                </div>
            </a>

            <a href="?url=admin/trabalho" class="glass-panel" style="background: white; padding: 2rem; text-decoration: none; display: flex; align-items: center; gap: 1.25rem; transition: all 0.2s; border: 2px solid transparent;">
                <div style="width: 52px; height: 52px; background: #EDE9FE; border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; flex-shrink: 0;">🚀</div>
                <div>
                    <div style="font-weight: 700; color: var(--color-text-title); font-size: 1.05rem;">Apresentação</div>
                    <div style="font-size: 0.85rem; color: var(--color-text-muted); margin-top: 0.25rem;">Slides técnicos do projeto</div>
                </div>
            </a>

        </div>

    </div>
</main>

<style>
.glass-panel[href]:hover {
    border-color: var(--color-primary-light) !important;
    transform: translateY(-3px);
    box-shadow: var(--shadow-md);
}
</style>