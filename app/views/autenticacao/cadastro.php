<div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: var(--color-bg-base); padding: 2rem;">

    <div class="glass-panel" style="background: white; width: 100%; max-width: 480px; padding: 3rem 2rem;">
        
        <!-- TÍTULO -->
        <div style="text-align: center; margin-bottom: 2rem;">
            <div class="navbar__logo-icon" style="margin: 0 auto 1rem;">S</div>
            <h2 style="font-family: 'Outfit'; font-weight: 800; font-size: 2rem; color: var(--color-text-title);">
                Criar Conta
            </h2>
            <p style="color: var(--color-text-muted); font-size: 0.95rem; margin-top: 0.5rem;">
                Entre para a comunidade colaborativa premium.
            </p>
        </div>

        <!-- MENSAGEM DE ERRO DE CADASTRO -->
        <?php if (!empty($_SESSION['erro_cadastro'])): ?>
        <div style="background:#fee2e2;border:1px solid #fca5a5;color:#dc2626;padding:0.85rem 1.2rem;border-radius:10px;font-size:0.9rem;font-weight:600;margin-bottom:1.5rem;display:flex;align-items:center;gap:0.5rem;">
            ⚠️ <?= htmlspecialchars($_SESSION['erro_cadastro']) ?>
        </div>
        <?php unset($_SESSION['erro_cadastro']); ?>
        <?php endif; ?>

        <!-- FORM -->
        <form method="POST" action="?url=autenticacao/registrar" style="display: flex; flex-direction: column; gap: 1.25rem;">
            <?= Seguranca::csrfCampo() ?>
            
            <!-- NOME -->
            <div>
                <label style="font-size: 0.85rem; font-weight: 600; color: var(--color-text-body); margin-bottom: 0.5rem; display: block;">Nome</label>
                <input 
                    type="text" 
                    name="nome" 
                    required 
                    class="input-glass"
                    placeholder="Seu nome completo"
                >
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
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

                <!-- TELEFONE -->
                <div>
                    <label style="font-size: 0.85rem; font-weight: 600; color: var(--color-text-body); margin-bottom: 0.5rem; display: block;">Telefone</label>
                    <input 
                        type="text" 
                        name="telefone" 
                        required 
                        class="input-glass"
                        placeholder="(11) 99999-9999"
                    >
                </div>
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

            <!-- TERMOS DE USO -->
            <div style="display: flex; align-items: flex-start; gap: 0.75rem; margin-top: 0.5rem;">
                <input 
                    type="checkbox" 
                    name="aceitar_termos" 
                    id="aceitar_termos"
                    required
                    style="margin-top: 4px; width: 18px; height: 18px; accent-color: var(--color-primary); cursor: pointer; flex-shrink: 0;"
                >
                <label for="aceitar_termos" style="font-size: 0.85rem; color: var(--color-text-body); line-height: 1.5; cursor: pointer;">
                    Li e concordo com os 
                    <a href="javascript:void(0)" onclick="abrirModal('modal-termos')" style="color: var(--color-primary); font-weight: 600; text-decoration: underline;">Termos de Uso</a> 
                    e a 
                    <a href="javascript:void(0)" onclick="abrirModal('modal-privacidade')" style="color: var(--color-primary); font-weight: 600; text-decoration: underline;">Política de Privacidade</a>.
                </label>
            </div>

            <!-- BOTÃO -->
            <button 
                type="submit" 
                class="btn btn--primary"
                style="width: 100%; margin-top: 1rem;"
            >
                Finalizar Cadastro
            </button>

        </form>

        <!-- LINK LOGIN -->
        <div style="text-align: center; margin-top: 2rem; font-size: 0.9rem; color: var(--color-text-body);">
            Já tem conta? 
            <a href="?url=autenticacao/login" style="color: var(--color-primary); font-weight: 600;">
                Entrar
            </a>
        </div>

    </div>

</div>

<!-- ═══════════════════════════════════════
     MODAL: TERMOS DE USO
═══════════════════════════════════════ -->
<div id="modal-termos" class="modal-overlay" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center; padding:1rem;">
    <div style="background:#fff; width:100%; max-width:700px; max-height:85vh; border-radius:16px; overflow:hidden; display:flex; flex-direction:column; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <!-- Header -->
        <div style="padding:1.25rem 1.5rem; border-bottom:1px solid #e2e8f0; display:flex; align-items:center; justify-content:space-between; flex-shrink:0;">
            <h3 style="font-family:'Outfit',sans-serif; font-size:1.25rem; font-weight:700; color:#0d2b6e; margin:0;">📜 Termos de Uso</h3>
            <button onclick="fecharModal('modal-termos')" style="background:none; border:none; font-size:1.5rem; cursor:pointer; color:#94a3b8; line-height:1;">✕</button>
        </div>
        <!-- Body -->
        <div style="padding:1.5rem; overflow-y:auto; font-size:0.9rem; color:#334155; line-height:1.8;">
            <p style="margin-bottom:1rem;"><strong>Última atualização:</strong> <?= date('d/m/Y') ?></p>

            <h4 style="color:#0d2b6e; margin:1.25rem 0 0.5rem;">1. Definições</h4>
            <ul style="padding-left:1.25rem; margin-bottom:1rem;">
                <li><strong>"Scambus"</strong> — plataforma digital de economia colaborativa para troca de serviços.</li>
                <li><strong>"SCoins"</strong> — moeda virtual fictícia exclusiva do ecossistema, sem valor monetário real.</li>
                <li><strong>"Troca"</strong> — acordo mútuo entre dois usuários para prestação recíproca de serviços.</li>
            </ul>

            <h4 style="color:#0d2b6e; margin:1.25rem 0 0.5rem;">2. Natureza da Plataforma</h4>
            <p>O Scambus atua como <strong>intermediador tecnológico</strong>. Não é parte das trocas e não se responsabiliza pela qualidade dos serviços oferecidos pelos usuários.</p>

            <h4 style="color:#0d2b6e; margin:1.25rem 0 0.5rem;">3. SCoins</h4>
            <p>SCoins <strong>não possuem valor monetário real</strong> e não podem ser convertidos em moeda fiduciária. É proibida a compra, venda ou comercialização de SCoins fora da plataforma.</p>

            <h4 style="color:#0d2b6e; margin:1.25rem 0 0.5rem;">4. Cadastro e Conta</h4>
            <p>O usuário declara que todas as informações são verdadeiras. Cada pessoa pode manter apenas <strong>uma conta ativa</strong>. O aceite destes Termos é obrigatório.</p>

            <h4 style="color:#0d2b6e; margin:1.25rem 0 0.5rem;">5. Trocas de Serviços</h4>
            <p>Ao propor uma troca, o sistema bloqueia temporariamente os SCoins (escrow). São liberados somente após confirmação mútua de ambas as partes.</p>

            <h4 style="color:#0d2b6e; margin:1.25rem 0 0.5rem;">6. Condutas Proibidas</h4>
            <ul style="padding-left:1.25rem; margin-bottom:1rem;">
                <li>Criar múltiplas contas para manipular SCoins</li>
                <li>Realizar trocas fictícias (farming)</li>
                <li>Publicar conteúdo ofensivo ou ilegal</li>
                <li>Explorar vulnerabilidades técnicas</li>
            </ul>

            <h4 style="color:#0d2b6e; margin:1.25rem 0 0.5rem;">7. Penalidades</h4>
            <p>Descumprimento pode resultar em advertência, suspensão, bloqueio permanente ou zeramento de SCoins.</p>

            <h4 style="color:#0d2b6e; margin:1.25rem 0 0.5rem;">8. Contato</h4>
            <p>Dúvidas: <strong>contato@scambus.com</strong></p>
        </div>
        <!-- Footer -->
        <div style="padding:1rem 1.5rem; border-top:1px solid #e2e8f0; text-align:right; flex-shrink:0;">
            <button onclick="fecharModal('modal-termos')" style="background:#0d2b6e; color:#fff; border:none; padding:0.7rem 2rem; border-radius:10px; font-weight:700; font-size:0.9rem; cursor:pointer;">Entendido</button>
        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════
     MODAL: POLÍTICA DE PRIVACIDADE
═══════════════════════════════════════ -->
<div id="modal-privacidade" class="modal-overlay" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center; padding:1rem;">
    <div style="background:#fff; width:100%; max-width:700px; max-height:85vh; border-radius:16px; overflow:hidden; display:flex; flex-direction:column; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <!-- Header -->
        <div style="padding:1.25rem 1.5rem; border-bottom:1px solid #e2e8f0; display:flex; align-items:center; justify-content:space-between; flex-shrink:0;">
            <h3 style="font-family:'Outfit',sans-serif; font-size:1.25rem; font-weight:700; color:#0d2b6e; margin:0;">🔒 Política de Privacidade</h3>
            <button onclick="fecharModal('modal-privacidade')" style="background:none; border:none; font-size:1.5rem; cursor:pointer; color:#94a3b8; line-height:1;">✕</button>
        </div>
        <!-- Body -->
        <div style="padding:1.5rem; overflow-y:auto; font-size:0.9rem; color:#334155; line-height:1.8;">
            <p style="margin-bottom:1rem;"><strong>Última atualização:</strong> <?= date('d/m/Y') ?></p>

            <h4 style="color:#0d2b6e; margin:1.25rem 0 0.5rem;">1. Dados Coletados</h4>
            <ul style="padding-left:1.25rem; margin-bottom:1rem;">
                <li><strong>Nome completo</strong> — identificação na plataforma</li>
                <li><strong>E-mail</strong> — login e comunicação</li>
                <li><strong>Telefone</strong> — contato alternativo</li>
                <li><strong>Senha</strong> — autenticação (armazenada como hash bcrypt)</li>
                <li><strong>Foto de perfil</strong> — identificação visual</li>
            </ul>

            <h4 style="color:#0d2b6e; margin:1.25rem 0 0.5rem;">2. Finalidade do Tratamento</h4>
            <p>Os dados são utilizados exclusivamente para o funcionamento da plataforma: autenticação, exibição de perfil, comunicação entre usuários e cálculo de reputação.</p>

            <h4 style="color:#0d2b6e; margin:1.25rem 0 0.5rem;">3. Proteção dos Dados</h4>
            <ul style="padding-left:1.25rem; margin-bottom:1rem;">
                <li>Senhas armazenadas como <strong>hash bcrypt</strong> (nunca em texto puro)</li>
                <li>Acesso ao banco via <strong>PDO com Prepared Statements</strong></li>
                <li>Rotas protegidas por verificação de sessão</li>
            </ul>

            <h4 style="color:#0d2b6e; margin:1.25rem 0 0.5rem;">4. Direitos do Usuário (LGPD)</h4>
            <ul style="padding-left:1.25rem; margin-bottom:1rem;">
                <li>✅ <strong>Acessar</strong> seus dados na tela de perfil</li>
                <li>✅ <strong>Corrigir</strong> informações via "Editar Perfil"</li>
                <li>✅ <strong>Excluir</strong> a conta (deleta todos os dados)</li>
            </ul>

            <h4 style="color:#0d2b6e; margin:1.25rem 0 0.5rem;">5. Compartilhamento</h4>
            <p>O Scambus <strong>não compartilha dados com terceiros</strong>. Não há integração com anunciantes ou redes de publicidade.</p>

            <h4 style="color:#0d2b6e; margin:1.25rem 0 0.5rem;">6. Contato</h4>
            <p>Para exercer seus direitos: <strong>contato@scambus.com</strong></p>
        </div>
        <!-- Footer -->
        <div style="padding:1rem 1.5rem; border-top:1px solid #e2e8f0; text-align:right; flex-shrink:0;">
            <button onclick="fecharModal('modal-privacidade')" style="background:#0d2b6e; color:#fff; border:none; padding:0.7rem 2rem; border-radius:10px; font-weight:700; font-size:0.9rem; cursor:pointer;">Entendido</button>
        </div>
    </div>
</div>

<script>
function abrirModal(id) {
    document.getElementById(id).style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function fecharModal(id) {
    document.getElementById(id).style.display = 'none';
    document.body.style.overflow = '';
}
// Fechar ao clicar fora do modal
document.querySelectorAll('.modal-overlay').forEach(function(overlay) {
    overlay.addEventListener('click', function(e) {
        if (e.target === overlay) {
            overlay.style.display = 'none';
            document.body.style.overflow = '';
        }
    });
});
</script>