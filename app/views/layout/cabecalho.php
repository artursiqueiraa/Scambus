<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scambus | Economia Colaborativa</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>
<body>

<!-- NAVBAR -->
<header class="navbar">
    <div class="container navbar__inner">
        
        <!-- LOGO -->
        <a href="?url=home" class="navbar__brand">
            <div class="navbar__logo-icon">S</div>
            <div>
                <span class="navbar__logo-text">SCAMBUS</span>
                <span class="navbar__logo-sub">economia colaborativa</span>
            </div>
        </a>

        <!-- MENU PRINCIPAL (DRAWER NO MOBILE) -->
        <nav class="navbar__nav" id="navbarMenu">
            <div class="mobile-only" style="padding-bottom: 1.5rem; border-bottom: 1px solid var(--color-border); margin-bottom: 1.5rem;">
                <span style="font-weight: 800; color: var(--color-accent);">MENU SCAMBUS</span>
            </div>
            
            <a href="?url=home" class="navbar__link">Início</a>
            <a href="?url=servico/listar" class="navbar__link">Explorar</a>
            <a href="?url=comunidade" class="navbar__link">Comunidade</a>
            
            <?php if(isset($_SESSION['usuario_id'])): ?>
                <a href="?url=troca/minhas" class="navbar__link">Minhas trocas</a>
                <a href="?url=usuario/dashboard" class="navbar__link">Dashboard</a>
                
                <!-- Ações movidas para dentro do menu no mobile -->
                <div class="mobile-only" style="margin-top: 1rem; flex-direction: column; gap: 1rem; padding-top: 1rem; border-top: 1px solid var(--color-border);">
                    <a href="?url=notificacao/listar" class="navbar__link">🔔 Notificações</a>
                    <a href="?url=usuario/favoritos" class="navbar__link">⭐ Favoritos</a>
                    <?php if(isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] == 'admin'): ?>
                        <a href="?url=admin/dashboard" style="color: #EF4444; font-weight: 600;">Admin Panel</a>
                    <?php endif; ?>
                    <a href="?url=autenticacao/logout" class="btn btn--outline" style="width: 100%;">Sair</a>
                </div>
            <?php else: ?>
                <div class="mobile-only" style="margin-top: 2rem; flex-direction: column; gap: 1rem;">
                    <a href="?url=autenticacao/login" class="btn btn--ghost">Entrar</a>
                    <a href="?url=autenticacao/cadastro" class="btn btn--accent">Criar conta</a>
                </div>
            <?php endif; ?>
        </nav>

        <!-- LADO DIREITO (AÇÕES DESKTOP + TOGGLE MOBILE) -->
        <div class="navbar__right flex items-center gap-md">
            
            <!-- AÇÕES (APARECE APENAS NO DESKTOP) -->
            <div class="navbar__actions desktop-only flex items-center gap-md">
                <?php if(isset($_SESSION['usuario_id'])): ?>
                    <?php
                    require_once "../app/modelos/Notificacao.php";
                    $notificacaoModel = new Notificacao();
                    $totalNotif = $notificacaoModel->contarNaoLidas($_SESSION['usuario_id']);
                    ?>
                    <a href="?url=notificacao/listar" title="Notificações" class="btn btn--ghost flex items-center gap-sm" style="position: relative; padding: 0.5rem;">
                        🔔
                        <?php if($totalNotif > 0): ?>
                            <span class="badge" style="position: absolute; top: 0; right: 0; background: #EF4444; color: white; border-radius: 50%; padding: 2px 6px; font-size: 0.65rem;"><?= $totalNotif ?></span>
                        <?php endif; ?>
                    </a>
                    <a href="?url=usuario/favoritos" title="Favoritos" class="btn btn--ghost" style="padding: 0.5rem;">⭐</a>
                    <?php if(isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] == 'admin'): ?>
                        <a href="?url=admin/dashboard" style="color: #EF4444; font-weight: 600; font-size: 0.95rem;">Admin</a>
                    <?php endif; ?>
                    <a href="?url=autenticacao/logout" class="btn btn--outline">Sair</a>
                <?php else: ?>
                    <a href="?url=autenticacao/login" class="btn btn--ghost">Entrar</a>
                    <a href="?url=autenticacao/cadastro" class="btn btn--accent">Criar conta</a>
                <?php endif; ?>
            </div>

            <!-- BOTÃO HAMBURGER (Sempre visível no mobile) -->
            <button class="navbar__toggle" id="navbarToggle" aria-label="Abrir menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>

    </div>
</header>

<script>
    // Menu Mobile Toggle
    const navbarToggle = document.getElementById('navbarToggle');
    const navbarMenu = document.getElementById('navbarMenu');

    if (navbarToggle && navbarMenu) {
        navbarToggle.addEventListener('click', () => {
            navbarToggle.classList.toggle('is-active');
            navbarMenu.classList.toggle('is-active');
            document.body.style.overflow = navbarMenu.classList.contains('is-active') ? 'hidden' : '';
        });

        // Fechar ao clicar em um link
        navbarMenu.querySelectorAll('.navbar__link').forEach(link => {
            link.addEventListener('click', () => {
                navbarToggle.classList.remove('is-active');
                navbarMenu.classList.remove('is-active');
                document.body.style.overflow = '';
            });
        });

        // Fechar ao clicar fora
        document.addEventListener('click', (e) => {
            if (!navbarMenu.contains(e.target) && !navbarToggle.contains(e.target) && navbarMenu.classList.contains('is-active')) {
                navbarToggle.classList.remove('is-active');
                navbarMenu.classList.remove('is-active');
                document.body.style.overflow = '';
            }
        });
    }

    <?php if(isset($_SESSION['usuario_id'])): ?>
    async function atualizarBadgeNotificacoes() {
        try {
            const response = await fetch('?url=notificacao/api_contar');
            const data = await response.json();
            
            const badgeContainer = document.querySelector('a[href="?url=notificacao/listar"]');
            if (!badgeContainer) return;

            let badge = badgeContainer.querySelector('.badge');
            
            if (data.total > 0) {
                if (!badge) {
                    badge = document.createElement('span');
                    badge.className = 'badge';
                    badge.style.cssText = 'position: absolute; top: 0; right: 0; background: #EF4444; color: white; border-radius: 50%; padding: 2px 6px; font-size: 0.65rem;';
                    badgeContainer.appendChild(badge);
                }
                badge.textContent = data.total;
            } else if (badge) {
                badge.remove();
            }
        } catch (e) {
            console.error("Erro ao atualizar badge:", e);
        }
    }

    // Atualiza a cada 10 segundos para economizar recursos (o polling da lista é mais frequente)
    setInterval(atualizarBadgeNotificacoes, 10000);
    <?php endif; ?>
</script>