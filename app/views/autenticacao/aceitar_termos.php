<div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: var(--color-bg-base); padding: 2rem;">

    <div class="glass-panel" style="background: white; width: 100%; max-width: 600px; padding: 3rem 2rem;">
        
        <!-- TÍTULO -->
        <div style="text-align: center; margin-bottom: 2rem;">
            <div class="navbar__logo-icon" style="margin: 0 auto 1rem;">S</div>
            <h2 style="font-family: 'Outfit'; font-weight: 800; font-size: 1.75rem; color: var(--color-text-title);">
                Termos de Uso
            </h2>
            <p style="color: var(--color-text-muted); font-size: 0.95rem; margin-top: 0.5rem;">
                Para continuar usando o Scambus, você precisa aceitar os termos.
            </p>
        </div>

        <!-- RESUMO DOS TERMOS -->
        <div style="background: var(--color-bg-base); border-radius: 12px; padding: 1.5rem; margin-bottom: 2rem; max-height: 320px; overflow-y: auto; border: 1px solid #e2e8f0; font-size: 0.9rem; color: var(--color-text-body); line-height: 1.7;">
            <p style="margin-bottom: 1rem;"><strong>Ao usar o Scambus, você concorda que:</strong></p>
            <ul style="padding-left: 1.25rem;">
                <li style="margin-bottom: 0.5rem;">As <strong>SCoins</strong> são uma moeda virtual sem valor monetário real.</li>
                <li style="margin-bottom: 0.5rem;">Você é responsável pela veracidade dos seus dados cadastrais.</li>
                <li style="margin-bottom: 0.5rem;">As trocas de serviços são de responsabilidade exclusiva dos usuários envolvidos.</li>
                <li style="margin-bottom: 0.5rem;">É proibido criar múltiplas contas ou realizar trocas fictícias.</li>
                <li style="margin-bottom: 0.5rem;">Seus dados pessoais serão protegidos conforme a <strong>LGPD</strong>.</li>
                <li style="margin-bottom: 0.5rem;">Condutas abusivas podem resultar em bloqueio ou exclusão da conta.</li>
            </ul>
            <p style="margin-top: 1rem; color: var(--color-text-muted); font-size: 0.85rem;">
                📄 Leia o documento completo: 
                <a href="?url=institucional/termos" target="_blank" style="color: var(--color-primary); font-weight: 600;">Termos de Uso</a> · 
                <a href="?url=institucional/privacidade" target="_blank" style="color: var(--color-primary); font-weight: 600;">Política de Privacidade</a>
            </p>
        </div>

        <!-- FORM DE ACEITE -->
        <form method="POST" action="?url=autenticacao/aceitarTermos">
            <?= Seguranca::csrfCampo() ?>

            <div style="display: flex; align-items: flex-start; gap: 0.75rem; margin-bottom: 1.5rem;">
                <input 
                    type="checkbox" 
                    name="aceitar" 
                    id="aceitar_check"
                    required
                    style="margin-top: 4px; width: 18px; height: 18px; accent-color: var(--color-primary); cursor: pointer; flex-shrink: 0;"
                >
                <label for="aceitar_check" style="font-size: 0.9rem; color: var(--color-text-body); line-height: 1.5; cursor: pointer;">
                    Declaro que li e concordo com os <strong>Termos de Uso</strong> e a <strong>Política de Privacidade</strong> do Scambus.
                </label>
            </div>

            <button 
                type="submit" 
                class="btn btn--primary"
                style="width: 100%;"
            >
                ✅ Aceitar e Continuar
            </button>
        </form>

        <!-- OPÇÃO SAIR -->
        <div style="text-align: center; margin-top: 1.5rem;">
            <a href="?url=autenticacao/logout" style="color: var(--color-text-muted); font-size: 0.85rem;">
                Não concordo — sair da plataforma
            </a>
        </div>

    </div>

</div>
