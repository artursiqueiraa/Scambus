<!-- FOOTER GLOBA L-->
<footer class="footer">
    <div class="container footer__grid">
        
        <div>
            <div class="footer__brand">SCAMBUS</div>
            <p style="color: var(--color-text-muted); font-size: 0.95rem; margin-top: 0.5rem; max-width: 250px;">
                Crie valor através de conexões humanas e habilidades compartilhadas. Economia colaborativa de verdade.
            </p>
        </div>
        
        <div>
            <h4 class="footer__title">Plataforma</h4>
            <ul class="footer__list">
                <li><a href="?url=home">Início</a></li>
                <li><a href="?url=servico/listar">Explorar Serviços</a></li>
                <li><a href="?url=comunidade">Comunidade</a></li>

            </ul>
        </div>
        
        <div>
            <h4 class="footer__title">Suporte</h4>
            <ul class="footer__list">
                <li><a href="?url=institucional/ajuda">Central de Ajuda</a></li>
                <li><a href="?url=institucional/termos">Termos de Uso</a></li>
                <li><a href="?url=institucional/privacidade">Privacidade</a></li>
            </ul>
        </div>
        
        <div>
            <h4 class="footer__title">Contato</h4>
            <ul class="footer__list">
                <li><a href="mailto:contato@scambus.com">contato@scambus.com</a></li>
                <li><a href="#">Discord da Comunidade</a></li>
            </ul>
        </div>
        
    </div>
    
    <div class="container">
        <div class="footer__bottom">
            &copy; <?= date("Y") ?> SCAMBUS. Todos os direitos reservados.
        </div>
    </div>
</footer>

<!-- ═══════════════════════════════════════
     FLASH MESSAGES GLOBAIS
     Exibe erros/sucessos de qualquer controller
═══════════════════════════════════════ -->
<?php if (!empty($_SESSION['erro_flash'])): ?>
<div id="flash-erro" style="
    position: fixed;
    bottom: 1.5rem;
    left: 50%;
    transform: translateX(-50%);
    background: #dc2626;
    color: white;
    padding: 0.9rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.9rem;
    z-index: 99999;
    box-shadow: 0 8px 30px rgba(220,38,38,0.35);
    max-width: 90vw;
    text-align: center;
    animation: flashIn 0.3s ease;
">
    ⚠️ <?= htmlspecialchars($_SESSION['erro_flash']) ?>
</div>
<?php unset($_SESSION['erro_flash']); ?>
<?php endif; ?>

<?php if (!empty($_SESSION['sucesso_flash'])): ?>
<div id="flash-sucesso" style="
    position: fixed;
    bottom: 1.5rem;
    left: 50%;
    transform: translateX(-50%);
    background: #16a34a;
    color: white;
    padding: 0.9rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.9rem;
    z-index: 99999;
    box-shadow: 0 8px 30px rgba(22,163,74,0.35);
    max-width: 90vw;
    text-align: center;
    animation: flashIn 0.3s ease;
">
    ✅ <?= htmlspecialchars($_SESSION['sucesso_flash']) ?>
</div>
<?php unset($_SESSION['sucesso_flash']); ?>
<?php endif; ?>

<style>
@keyframes flashIn {
    from { opacity: 0; transform: translateX(-50%) translateY(20px); }
    to   { opacity: 1; transform: translateX(-50%) translateY(0); }
}
</style>
<script>
// Auto-dismiss flash messages após 4 segundos
setTimeout(function() {
    ['flash-erro','flash-sucesso'].forEach(function(id) {
        var el = document.getElementById(id);
        if (el) { el.style.transition = 'opacity 0.5s'; el.style.opacity = '0'; setTimeout(function(){ if(el) el.remove(); }, 500); }
    });
}, 4000);
</script>

</body>
</html>
