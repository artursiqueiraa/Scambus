<div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: var(--color-bg-base); padding: 2rem;">

    <div class="glass-panel" style="background: white; width: 100%; max-width: 420px; padding: 3rem 2rem;">
        
        <!-- TÍTULO -->
        <div style="text-align: center; margin-bottom: 2rem;">
            <div class="navbar__logo-icon" style="margin: 0 auto 1rem;">S</div>
            <h2 style="font-family: 'Outfit'; font-weight: 800; font-size: 2rem; color: var(--color-text-title);">
                Entrar
            </h2>
            <p style="color: var(--color-text-muted); font-size: 0.95rem; margin-top: 0.5rem;">
                Acesse sua conta e comece a trocar <span style="color: var(--color-accent); font-weight: 600;">habilidades</span>
            </p>
        </div>

        <!-- MENSAGEM DE ERRO DE LOGIN -->
        <?php if (!empty($_SESSION['erro_login'])): ?>
        <div style="
            background: #fee2e2;
            border: 1px solid #fca5a5;
            color: #dc2626;
            padding: 0.85rem 1.2rem;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        ">
            ⚠️ <?= htmlspecialchars($_SESSION['erro_login']) ?>
        </div>
        <?php unset($_SESSION['erro_login']); ?>
        <?php endif; ?>

        <!-- MENSAGEM DE SUCESSO (vinda do cadastro) -->
        <?php if (!empty($_SESSION['sucesso_cadastro'])): ?>
        <div style="
            background: #dcfce7;
            border: 1px solid #86efac;
            color: #16a34a;
            padding: 0.85rem 1.2rem;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        ">
            ✅ <?= htmlspecialchars($_SESSION['sucesso_cadastro']) ?>
        </div>
        <?php unset($_SESSION['sucesso_cadastro']); ?>
        <?php endif; ?>

        <!-- FORM -->
        <form method="POST" action="?url=autenticacao/autenticar" style="display: flex; flex-direction: column; gap: 1.5rem;">
            <?= Seguranca::csrfCampo() ?>
            
            <!-- EMAIL -->
            <div>
                <label style="font-size: 0.85rem; font-weight: 600; color: var(--color-text-body); margin-bottom: 0.5rem; display: block;">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    required 
                    class="input-glass"
                    placeholder="voce@exemplo.com"
                >
            </div>

            <!-- SENHA -->
            <div>
                <label style="font-size: 0.85rem; font-weight: 600; color: var(--color-text-body); margin-bottom: 0.5rem; display: block;">Senha</label>
                <input 
                    type="password" 
                    name="senha" 
                    required 
                    class="input-glass"
                    placeholder="••••••••"
                >
            </div>

            <!-- BOTÃO -->
            <button 
                type="submit" 
                class="btn btn--primary"
                style="width: 100%; margin-top: 1rem;"
            >
                Entrar na SCAMBUS
            </button>

        </form>

        <!-- LINK CADASTRO -->
        <div style="text-align: center; margin-top: 2rem; font-size: 0.9rem; color: var(--color-text-body);">
            Não tem conta? 
            <a href="?url=autenticacao/cadastro" style="color: var(--color-primary); font-weight: 600;">
                Criar conta
            </a>
        </div>

    </div>

</div>