<main class="w-full" style="background: var(--color-bg-base); min-height: 80vh; padding: 4rem 0;">
    <div class="container" style="max-width: 1000px;">

        <!-- HEADER -->
        <div style="text-align: center; margin-bottom: 3rem;">
            <h2 class="hero__title" style="font-size: 2.5rem; margin-bottom: 0.5rem;">👋 Bem-vindo, <?= $dados['nome'] ?></h2>
            <p style="color: var(--color-text-muted); font-size: 1.1rem;">
                Nível: <span style="font-weight: 700; color: var(--color-accent);"><?= $dados['nivel'] ?? '🥉 Bronze' ?></span>
            </p>
        </div>

        <!-- CARDS -->
        <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem; margin-bottom: 4rem;">

            <a href="?url=carteira/index" style="text-decoration: none;">
                <div class="glass-panel" style="background: white; padding: 2rem; border-top: 4px solid var(--color-primary); text-align: center;">
                    <div style="font-size: 0.9rem; color: var(--color-text-muted); font-weight: 600; text-transform: uppercase;">Saldo</div>
                    <div style="font-size: 2.5rem; font-weight: 800; color: var(--color-text-title); margin: 0.5rem 0; font-family: 'Outfit';"><?= $dados['saldo_scoins'] ?></div>
                    <div style="font-size: 0.85rem; color: var(--color-text-body);">Scoins</div>
                </div>
            </a>

            <a href="?url=troca/minhas" style="text-decoration: none;">
                <div class="glass-panel" style="background: white; padding: 2rem; border-top: 4px solid var(--color-accent); text-align: center;">
                    <div style="font-size: 0.9rem; color: var(--color-text-muted); font-weight: 600; text-transform: uppercase;">Trocas</div>
                    <div style="font-size: 2.5rem; font-weight: 800; color: var(--color-text-title); margin: 0.5rem 0; font-family: 'Outfit';"><?= $dados['total_trocas'] ?></div>
                    <div style="font-size: 0.85rem; color: var(--color-text-body);">Realizadas</div>
                </div>
            </a>

            <a href="?url=servico/meus" style="text-decoration: none;">
                <div class="glass-panel" style="background: white; padding: 2rem; border-top: 4px solid #10B981; text-align: center;">
                    <div style="font-size: 0.9rem; color: var(--color-text-muted); font-weight: 600; text-transform: uppercase;">Serviços</div>
                    <div style="font-size: 2.5rem; font-weight: 800; color: var(--color-text-title); margin: 0.5rem 0; font-family: 'Outfit';"><?= $dados['total_servicos'] ?></div>
                    <div style="font-size: 0.85rem; color: var(--color-text-body);">Cadastrados</div>
                </div>
            </a>

            <a href="?url=usuario/perfil" style="text-decoration: none;">
                <div class="glass-panel" style="background: white; padding: 2rem; border-top: 4px solid #8B5CF6; text-align: center;">
                    <div style="font-size: 0.9rem; color: var(--color-text-muted); font-weight: 600; text-transform: uppercase;">Avaliação</div>
                    <div style="font-size: 2.5rem; font-weight: 800; color: var(--color-text-title); margin: 0.5rem 0; font-family: 'Outfit';">
                        ⭐ <?= $dados['avaliacao_media'] ? round($dados['avaliacao_media'], 1) : 0 ?>
                    </div>
                    <div style="font-size: 0.85rem; color: var(--color-text-body);">Média Geral</div>
                </div>
            </a>

        </div>

        <!-- AÇÕES RÁPIDAS -->
        <div style="text-align: center; background: white; padding: 3rem; border-radius: var(--radius-lg); border: 1px solid var(--color-border); box-shadow: var(--shadow-sm);">
            
            <h3 style="font-size: 1.5rem; font-family: 'Outfit'; font-weight: 700; color: var(--color-text-title); margin-bottom: 2rem;">
                ⚡ Ações rápidas
            </h3>

            <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem;">
                
                <a href="?url=servico/criar" class="btn btn--accent" style="width: 100%;">
                    ➕ Criar serviço
                </a>

                <a href="?url=troca/minhas" class="btn btn--outline" style="width: 100%;">
                    🔁 Minhas trocas
                </a>

                <a href="?url=servico/listar" class="btn btn--primary" style="width: 100%;">
                    🔍 Explorar
                </a>

                <a href="?url=usuario/perfil" class="btn btn--outline" style="width: 100%;">
                    👤 Meu perfil
                </a>

                <a href="?url=usuario/editar" class="btn btn--outline" style="width: 100%; border-color: rgba(0,0,0,0.1);">
                    ✏️ Editar perfil
                </a>

            </div>

        </div>

    </div>
</main>