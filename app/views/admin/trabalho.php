<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trabalho — Engenharia de Sistemas — Scambus</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
        --navy: #0d2b6e;
        --navy-dark: #091e4e;
        --gold: #C9A227;
        --gold-light: #f5d87a;
        --bg: #f1f5f9;
        --white: #ffffff;
        --slate: #64748b;
        --text: #1e293b;
        --border: #e2e8f0;
        --success: #16a34a;
        --warning: #d97706;
        --danger: #dc2626;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background: var(--bg);
        color: var(--text);
        min-height: 100vh;
    }

    /* ── LAYOUT ── */
    .tw-layout {
        display: flex;
        min-height: 100vh;
    }

    /* ── SIDEBAR ── */
    .tw-sidebar {
        width: 260px;
        background: var(--navy-dark);
        position: fixed;
        top: 0; left: 0; bottom: 0;
        overflow-y: auto;
        z-index: 100;
        display: flex;
        flex-direction: column;
    }

    .tw-sidebar-logo {
        padding: 28px 24px 20px;
        border-bottom: 1px solid rgba(255,255,255,0.08);
    }

    .tw-sidebar-logo h1 {
        font-family: 'Outfit', sans-serif;
        font-size: 20px;
        font-weight: 800;
        color: #fff;
        margin-bottom: 2px;
    }

    .tw-sidebar-logo p {
        font-size: 11px;
        color: rgba(255,255,255,0.4);
        text-transform: uppercase;
        letter-spacing: .08em;
    }

    .tw-nav {
        padding: 16px 12px;
        flex: 1;
    }

    .tw-nav-group {
        margin-bottom: 24px;
    }

    .tw-nav-group-label {
        font-size: 10px;
        font-weight: 700;
        color: rgba(255,255,255,0.3);
        text-transform: uppercase;
        letter-spacing: .1em;
        padding: 0 12px;
        margin-bottom: 8px;
    }

    .tw-nav-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 12px;
        border-radius: 10px;
        color: rgba(255,255,255,0.6);
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: all .2s;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
        text-decoration: none;
    }

    .tw-nav-item:hover { background: rgba(255,255,255,0.06); color: #fff; }
    .tw-nav-item.active { background: rgba(201,162,39,0.15); color: var(--gold); font-weight: 700; }
    .tw-nav-item .nav-icon { font-size: 15px; width: 20px; text-align: center; }
    .tw-nav-item .nav-num {
        margin-left: auto;
        background: rgba(255,255,255,0.1);
        color: rgba(255,255,255,0.4);
        font-size: 10px;
        padding: 2px 7px;
        border-radius: 100px;
        font-weight: 700;
    }
    .tw-nav-item.active .nav-num { background: rgba(201,162,39,0.2); color: var(--gold); }

    .tw-sidebar-footer {
        padding: 16px;
        border-top: 1px solid rgba(255,255,255,0.08);
    }

    .tw-back-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 14px;
        background: rgba(255,255,255,0.06);
        border-radius: 10px;
        color: rgba(255,255,255,0.5);
        text-decoration: none;
        font-size: 12px;
        font-weight: 600;
        transition: all .2s;
    }

    .tw-back-btn:hover { background: rgba(255,255,255,0.1); color: #fff; }

    /* ── MAIN ── */
    .tw-main {
        margin-left: 260px;
        flex: 1;
        padding: 40px;
        max-width: calc(100% - 260px);
    }

    /* ── HERO ── */
    .tw-hero {
        background: linear-gradient(135deg, var(--navy-dark) 0%, #1a3d8f 60%, #0d2b6e 100%);
        border-radius: 20px;
        padding: 48px;
        margin-bottom: 36px;
        position: relative;
        overflow: hidden;
    }

    .tw-hero::before {
        content: 'SCAMBUS';
        position: absolute;
        right: -20px;
        top: 50%;
        transform: translateY(-50%);
        font-family: 'Outfit', sans-serif;
        font-size: 120px;
        font-weight: 800;
        color: rgba(255,255,255,0.04);
        letter-spacing: -4px;
        pointer-events: none;
    }

    .tw-hero-tag {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(201,162,39,0.15);
        border: 1px solid rgba(201,162,39,0.3);
        color: var(--gold);
        padding: 5px 14px;
        border-radius: 100px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
        margin-bottom: 16px;
    }

    .tw-hero h1 {
        font-family: 'Outfit', sans-serif;
        font-size: 36px;
        font-weight: 800;
        color: #fff;
        margin-bottom: 10px;
        line-height: 1.15;
    }

    .tw-hero p {
        color: rgba(255,255,255,0.6);
        font-size: 15px;
        max-width: 580px;
        line-height: 1.7;
        margin-bottom: 28px;
    }

    .tw-hero-stats {
        display: flex;
        gap: 32px;
        flex-wrap: wrap;
    }

    .tw-hero-stat { text-align: left; }
    .tw-hero-stat-val { font-family: 'Outfit', sans-serif; font-size: 28px; font-weight: 800; color: var(--gold); line-height: 1; }
    .tw-hero-stat-lbl { font-size: 12px; color: rgba(255,255,255,0.4); margin-top: 3px; }

    /* ── SECTION ── */
    .tw-section { display: none; animation: fadeUp .35s ease both; }
    .tw-section.active { display: block; }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ── SECTION HEADER ── */
    .tw-section-header {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 28px;
        padding-bottom: 20px;
        border-bottom: 2px solid var(--border);
    }

    .tw-section-icon {
        width: 48px; height: 48px;
        border-radius: 14px;
        background: var(--navy);
        display: flex; align-items: center; justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .tw-section-header h2 {
        font-family: 'Outfit', sans-serif;
        font-size: 22px;
        font-weight: 800;
        color: var(--navy);
        margin-bottom: 2px;
    }

    .tw-section-header p {
        font-size: 13px;
        color: var(--slate);
    }

    /* ── CARD ── */
    .tw-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 28px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,.04);
    }

    .tw-card h3 {
        font-size: 15px;
        font-weight: 700;
        color: var(--navy);
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .tw-card p, .tw-card li {
        font-size: 14px;
        color: #475569;
        line-height: 1.75;
    }

    .tw-card ul { padding-left: 20px; }
    .tw-card ul li { margin-bottom: 6px; }

    /* ── GRID ── */
    .tw-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .tw-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; }
    .tw-grid-4 { display: grid; grid-template-columns: repeat(4,1fr); gap: 16px; }

    @media(max-width: 900px) {
        .tw-grid-4 { grid-template-columns: repeat(2,1fr); }
        .tw-grid-3 { grid-template-columns: 1fr 1fr; }
    }

    /* ── TABLE ── */
    .tw-table { width: 100%; border-collapse: collapse; }
    .tw-table th {
        background: #f8fafc;
        padding: 11px 14px;
        text-align: left;
        font-size: 11px;
        font-weight: 700;
        color: var(--slate);
        text-transform: uppercase;
        letter-spacing: .06em;
        border-bottom: 2px solid var(--border);
    }
    .tw-table td {
        padding: 12px 14px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13.5px;
        color: #334155;
        vertical-align: top;
    }
    .tw-table tr:last-child td { border: none; }
    .tw-table tr:hover td { background: #fafbfc; }

    /* ── BADGE ── */
    .tw-badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 100px;
        font-size: 11px;
        font-weight: 700;
    }
    .tw-badge-red    { background: #fee2e2; color: #dc2626; }
    .tw-badge-yellow { background: #fef9c3; color: #ca8a04; }
    .tw-badge-green  { background: #dcfce7; color: #16a34a; }
    .tw-badge-blue   { background: #dbeafe; color: #1d4ed8; }
    .tw-badge-navy   { background: #e0e7ff; color: var(--navy); }

    /* ── HIGHLIGHT BOX ── */
    .tw-highlight {
        background: linear-gradient(135deg, #f0f4ff, #e8eeff);
        border: 1px solid #c7d2fe;
        border-left: 4px solid var(--navy);
        border-radius: 12px;
        padding: 20px 24px;
        margin-bottom: 20px;
    }

    .tw-highlight h4 {
        font-size: 13px;
        font-weight: 700;
        color: var(--navy);
        text-transform: uppercase;
        letter-spacing: .06em;
        margin-bottom: 6px;
    }

    .tw-highlight p {
        font-size: 14px;
        color: #334155;
        line-height: 1.7;
    }

    /* ── MANUTENÇÃO CARDS ── */
    .tw-manut-card {
        border-radius: 14px;
        padding: 22px;
        border: 1px solid var(--border);
    }

    .tw-manut-card.corretiva  { background: #fff5f5; border-color: #fecaca; border-top: 4px solid #dc2626; }
    .tw-manut-card.preventiva { background: #fffbeb; border-color: #fde68a; border-top: 4px solid #f59e0b; }
    .tw-manut-card.evolutiva  { background: #f0fdf4; border-color: #bbf7d0; border-top: 4px solid #16a34a; }

    .tw-manut-card h3 { font-size: 15px; font-weight: 700; margin-bottom: 10px; display: flex; align-items: center; gap: 8px; }
    .tw-manut-card.corretiva  h3 { color: #dc2626; }
    .tw-manut-card.preventiva h3 { color: #d97706; }
    .tw-manut-card.evolutiva  h3 { color: #16a34a; }
    .tw-manut-card p { font-size: 13.5px; color: #475569; line-height: 1.7; }

    /* ── RISCO ── */
    .tw-risco-item {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 2fr;
        gap: 12px;
        padding: 14px;
        border-radius: 10px;
        border: 1px solid var(--border);
        background: #fff;
        margin-bottom: 10px;
        align-items: center;
    }

    .tw-risco-item p { font-size: 13px; color: #334155; }
    .tw-risco-item span { font-size: 12px; color: var(--slate); }

    /* ── ETAPA CRONOGRAMA ── */
    .tw-timeline {
        position: relative;
        padding-left: 32px;
    }

    .tw-timeline::before {
        content: '';
        position: absolute;
        left: 10px; top: 8px; bottom: 8px;
        width: 2px;
        background: var(--border);
    }

    .tw-timeline-item {
        position: relative;
        margin-bottom: 24px;
    }

    .tw-timeline-dot {
        position: absolute;
        left: -26px;
        top: 4px;
        width: 16px; height: 16px;
        border-radius: 50%;
        background: var(--navy);
        border: 3px solid var(--bg);
    }

    .tw-timeline-item h4 { font-size: 14px; font-weight: 700; color: var(--navy); margin-bottom: 4px; }
    .tw-timeline-item p  { font-size: 13px; color: var(--slate); line-height: 1.6; }
    .tw-timeline-item .tw-badge { margin-bottom: 6px; }

    /* ── CONCORRENTE ── */
    .tw-concorrente {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 22px;
    }

    .tw-concorrente h4 { font-size: 15px; font-weight: 700; color: var(--navy); margin-bottom: 14px; }
    .tw-concorrente .pro { color: #16a34a; font-size: 13px; margin-bottom: 4px; }
    .tw-concorrente .con { color: #dc2626; font-size: 13px; margin-bottom: 4px; }

    /* ── TELA PROTÓTIPO ── */
    .tw-screen {
        background: #0f172a;
        border-radius: 14px;
        overflow: hidden;
        border: 1px solid #334155;
    }

    .tw-screen-bar {
        background: #1e293b;
        padding: 8px 14px;
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        color: #64748b;
    }

    .tw-screen-bar .dot { width: 8px; height: 8px; border-radius: 50%; }
    .tw-screen-body { padding: 20px; }

    /* ── MOBILE ── */
    @media(max-width: 768px) {
        .tw-sidebar { width: 0; overflow: hidden; }
        .tw-main { margin-left: 0; padding: 20px; max-width: 100%; }
        .tw-grid-2 { grid-template-columns: 1fr; }
        .tw-hero { padding: 28px; }
        .tw-hero h1 { font-size: 24px; }
    }
    </style>
</head>
<body>

<div class="tw-layout">

<!-- ══════════════════════════════════
     SIDEBAR
══════════════════════════════════ -->
<aside class="tw-sidebar">
    <div class="tw-sidebar-logo">
        <h1>🔄 Scambus</h1>
        <p>Engenharia de Sistemas · 2025</p>
    </div>

    <nav class="tw-nav">

        <div class="tw-nav-group">
            <div class="tw-nav-group-label">Visão Geral</div>
            <button class="tw-nav-item active" onclick="showSection('s-ideia', this)">
                <span class="nav-icon">🚀</span> Ideia do Sistema <span class="nav-num">1</span>
            </button>
            <button class="tw-nav-item" onclick="showSection('s-usuarios', this)">
                <span class="nav-icon">👥</span> Usuários <span class="nav-num">2</span>
            </button>
        </div>

        <div class="tw-nav-group">
            <div class="tw-nav-group-label">Requisitos</div>
            <button class="tw-nav-item" onclick="showSection('s-rf', this)">
                <span class="nav-icon">⚙️</span> Req. Funcionais <span class="nav-num">3</span>
            </button>
            <button class="tw-nav-item" onclick="showSection('s-rnf', this)">
                <span class="nav-icon">🔒</span> Req. Não Funcionais <span class="nav-num">4</span>
            </button>
        </div>

        <div class="tw-nav-group">
            <div class="tw-nav-group-label">Conformidade</div>
            <button class="tw-nav-item" onclick="showSection('s-lgpd', this)">
                <span class="nav-icon">🧾</span> LGPD <span class="nav-num">5</span>
            </button>
            <button class="tw-nav-item" onclick="showSection('s-seguranca', this)">
                <span class="nav-icon">🛡️</span> Segurança <span class="nav-num">5b</span>
            </button>
        </div>

        <div class="tw-nav-group">
            <div class="tw-nav-group-label">Mercado & Produto</div>
            <button class="tw-nav-item" onclick="showSection('s-mercado', this)">
                <span class="nav-icon">📊</span> Estudo de Mercado <span class="nav-num">6</span>
            </button>
            <button class="tw-nav-item" onclick="showSection('s-arquitetura', this)">
                <span class="nav-icon">🏗️</span> Arquitetura <span class="nav-num">7</span>
            </button>
        </div>

        <div class="tw-nav-group">
            <div class="tw-nav-group-label">Gestão</div>
            <button class="tw-nav-item" onclick="showSection('s-planejamento', this)">
                <span class="nav-icon">📅</span> Planejamento <span class="nav-num">8</span>
            </button>
            <button class="tw-nav-item" onclick="showSection('s-testes', this)">
                <span class="nav-icon">🧪</span> Testes & Qualidade <span class="nav-num">10</span>
            </button>
            <button class="tw-nav-item" onclick="showSection('s-manutencao', this)">
                <span class="nav-icon">🔄</span> Manutenção <span class="nav-num">11</span>
            </button>
        </div>

        <div class="tw-nav-group">
            <div class="tw-nav-group-label">Entrega</div>
            <button class="tw-nav-item" onclick="showSection('s-prototipo', this)">
                <span class="nav-icon">📱</span> Prototipagem <span class="nav-num">12</span>
            </button>
            <button class="tw-nav-item" onclick="showSection('s-implantacao', this)">
                <span class="nav-icon">🚀</span> Implantação <span class="nav-num">13</span>
            </button>
            <button class="tw-nav-item" onclick="showSection('s-riscos', this)">
                <span class="nav-icon">⚠️</span> Gestão de Riscos <span class="nav-num">14</span>
            </button>
        </div>

    </nav>

    <div class="tw-sidebar-footer">
        <a href="?url=admin/dashboard" class="tw-back-btn">← Voltar ao Painel</a>
    </div>
</aside>

<!-- ══════════════════════════════════
     MAIN
══════════════════════════════════ -->
<main class="tw-main">

    <!-- HERO -->
    <div class="tw-hero">
        <div class="tw-hero-tag">📐 Trabalho Prático · Engenharia de Sistemas</div>
        <h1>Scambus — Plataforma de<br>Troca de Serviços</h1>
        <p>Economia colaborativa digital baseada em escambo moderno. Usuários trocam habilidades e serviços utilizando Scoins como moeda interna da plataforma.</p>
        <div class="tw-hero-stats">
            <div class="tw-hero-stat">
                <div class="tw-hero-stat-val">9</div>
                <div class="tw-hero-stat-lbl">Controladores</div>
            </div>
            <div class="tw-hero-stat">
                <div class="tw-hero-stat-val">9</div>
                <div class="tw-hero-stat-lbl">Modelos</div>
            </div>
            <div class="tw-hero-stat">
                <div class="tw-hero-stat-val">8</div>
                <div class="tw-hero-stat-lbl">Tabelas no Banco</div>
            </div>
            <div class="tw-hero-stat">
                <div class="tw-hero-stat-val">20+</div>
                <div class="tw-hero-stat-lbl">Views</div>
            </div>
            <div class="tw-hero-stat">
                <div class="tw-hero-stat-val">PHP8</div>
                <div class="tw-hero-stat-lbl">Tecnologia</div>
            </div>
        </div>
    </div>

    <!-- ══ 1. IDEIA ══ -->
    <div class="tw-section active" id="s-ideia">
        <div class="tw-section-header">
            <div class="tw-section-icon">🚀</div>
            <div>
                <h2>1. Apresentação da Ideia do Sistema</h2>
                <p>O que é o Scambus, qual problema resolve e quais benefícios oferece</p>
            </div>
        </div>

        <div class="tw-highlight">
            <h4>Nome do Sistema</h4>
            <p><strong>Scambus</strong> — Plataforma Digital de Troca de Serviços (Economia Colaborativa)</p>
        </div>

        <div class="tw-card">
            <h3>📋 Descrição Geral</h3>
            <p>O <strong>Scambus</strong> é uma plataforma digital de economia colaborativa onde usuários trocam serviços entre si sem uso de dinheiro. O sistema utiliza uma moeda interna chamada <strong>Scoins</strong>, que funciona como crédito intermediário para facilitar as trocas.</p>
            <br>
            <p>A ideia central é o <strong>escambo moderno</strong>: em vez de pagar, você oferece uma habilidade e recebe outra em troca. Por exemplo: um designer troca um logotipo com um programador que desenvolve uma funcionalidade para ele.</p>
        </div>

        <div class="tw-grid-2">
            <div class="tw-card">
                <h3>❗ Problema que o Sistema Resolve</h3>
                <p>Muitas pessoas possuem habilidades valiosas mas não têm dinheiro para contratar serviços que precisam. O Scambus elimina essa barreira financeira ao permitir que competências sejam trocadas diretamente, democratizando o acesso a serviços e valorizando o conhecimento de cada pessoa.</p>
            </div>
            <div class="tw-card">
                <h3>🎯 Objetivo Principal</h3>
                <ul>
                    <li>Facilitar a troca de habilidades e serviços sem dinheiro</li>
                    <li>Reduzir a dependência financeira para acesso a serviços</li>
                    <li>Criar uma comunidade colaborativa e de confiança</li>
                    <li>Valorizar o conhecimento e o tempo das pessoas</li>
                    <li>Gerar reputação digital baseada em avaliações reais</li>
                </ul>
            </div>
        </div>

        <div class="tw-card">
            <h3>✅ Benefícios Oferecidos</h3>
            <div class="tw-grid-3" style="margin-top:8px">
                <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:16px">
                    <div style="font-size:22px;margin-bottom:6px">💡</div>
                    <strong style="font-size:13px;color:#166534">Para o Usuário</strong>
                    <p style="font-size:13px;color:#475569;margin-top:4px">Acesso a serviços sem gastar dinheiro, usando suas próprias habilidades como moeda de troca.</p>
                </div>
                <div style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:10px;padding:16px">
                    <div style="font-size:22px;margin-bottom:6px">🤝</div>
                    <strong style="font-size:13px;color:#1e40af">Para a Comunidade</strong>
                    <p style="font-size:13px;color:#475569;margin-top:4px">Fortalece redes de confiança locais e incentiva a cooperação entre pessoas com diferentes habilidades.</p>
                </div>
                <div style="background:#fdf4ff;border:1px solid #e9d5ff;border-radius:10px;padding:16px">
                    <div style="font-size:22px;margin-bottom:6px">📈</div>
                    <strong style="font-size:13px;color:#7e22ce">Para a Economia</strong>
                    <p style="font-size:13px;color:#475569;margin-top:4px">Movimenta capital intelectual que estaria ocioso, criando valor real sem circulação de dinheiro.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- ══ 2. USUÁRIOS ══ -->
    <div class="tw-section" id="s-usuarios">
        <div class="tw-section-header">
            <div class="tw-section-icon">👥</div>
            <div>
                <h2>2. Usuários do Sistema</h2>
                <p>Público-alvo, perfis e como cada tipo de usuário interage com a plataforma</p>
            </div>
        </div>

        <div class="tw-grid-2">
            <div class="tw-card">
                <h3>🔹 Usuário Comum</h3>
                <p style="margin-bottom:12px"><strong>Perfil:</strong> Jovens e adultos de 18 a 45 anos com alguma habilidade ou serviço para oferecer — freelancers, estudantes, profissionais autônomos.</p>
                <p><strong>O que pode fazer:</strong></p>
                <ul style="margin-top:8px">
                    <li>Cadastrar serviços com fotos e descrição</li>
                    <li>Explorar e filtrar serviços por categoria</li>
                    <li>Favoritar serviços de interesse</li>
                    <li>Propor trocas e conversar via chat</li>
                    <li>Confirmar serviços e receber Scoins</li>
                    <li>Avaliar outros usuários após a troca</li>
                    <li>Participar da comunidade (feed social)</li>
                    <li>Ver seu saldo, extrato e histórico</li>
                </ul>
            </div>
            <div class="tw-card">
                <h3>🔸 Administrador</h3>
                <p style="margin-bottom:12px"><strong>Perfil:</strong> Gestor da plataforma com acesso total ao sistema, responsável por manter a integridade e o funcionamento do ambiente.</p>
                <p><strong>O que pode fazer:</strong></p>
                <ul style="margin-top:8px">
                    <li>Acessar o painel administrativo</li>
                    <li>Ver estatísticas gerais do sistema</li>
                    <li>Listar, bloquear e desbloquear usuários</li>
                    <li>Excluir usuários com cascade no banco</li>
                    <li>Visualizar e excluir serviços cadastrados</li>
                    <li>Acessar documentação técnica e UML</li>
                    <li>Visualizar este trabalho acadêmico</li>
                </ul>
            </div>
        </div>

        <div class="tw-card">
            <h3>🎯 Público-Alvo Detalhado</h3>
            <table class="tw-table">
                <thead><tr><th>Perfil</th><th>Idade</th><th>Como utiliza</th><th>Habilidades típicas</th></tr></thead>
                <tbody>
                    <tr><td><strong>Freelancer</strong></td><td>22–35</td><td>Cadastra serviços e propõe trocas ativamente</td><td>Design, programação, marketing</td></tr>
                    <tr><td><strong>Estudante</strong></td><td>18–25</td><td>Oferece serviços simples em troca de outros</td><td>Aulas, redação, social media</td></tr>
                    <tr><td><strong>Autônomo</strong></td><td>25–45</td><td>Usa como canal alternativo de captação</td><td>Mecânica, culinária, elétrica</td></tr>
                    <tr><td><strong>Profissional criativo</strong></td><td>20–40</td><td>Troca por serviços que não sabe fazer</td><td>Fotografia, música, arquitetura</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ══ 3. REQUISITOS FUNCIONAIS ══ -->
    <div class="tw-section" id="s-rf">
        <div class="tw-section-header">
            <div class="tw-section-icon">⚙️</div>
            <div>
                <h2>3. Requisitos Funcionais</h2>
                <p>O que o sistema faz — funcionalidades implementadas e seu impacto</p>
            </div>
        </div>

        <div class="tw-card" style="padding:0;overflow:hidden">
            <table class="tw-table">
                <thead>
                    <tr><th>Código</th><th>Requisito Funcional</th><th>Descrição</th><th>Impacto</th></tr>
                </thead>
                <tbody>
                    <tr><td><strong>RF01</strong></td><td><strong>Cadastro de Usuários</strong></td><td>Criação de conta com nome, e-mail, telefone e senha criptografada</td><td><span class="tw-badge tw-badge-red">Crítico</span></td></tr>
                    <tr><td><strong>RF02</strong></td><td><strong>Autenticação e Sessão</strong></td><td>Login com verificação de credenciais e controle de sessão PHP por tipo de usuário</td><td><span class="tw-badge tw-badge-red">Crítico</span></td></tr>
                    <tr><td><strong>RF03</strong></td><td><strong>Cadastro de Serviços</strong></td><td>Usuário cria serviços com título, descrição, categoria, o que aceita em troca e múltiplas fotos</td><td><span class="tw-badge tw-badge-red">Crítico</span></td></tr>
                    <tr><td><strong>RF04</strong></td><td><strong>Explorar Serviços</strong></td><td>Marketplace com cards, filtro por categoria e visualização detalhada com galeria de fotos</td><td><span class="tw-badge tw-badge-yellow">Alto</span></td></tr>
                    <tr><td><strong>RF05</strong></td><td><strong>Sistema de Trocas</strong></td><td>Proposta de troca entre usuários com status (PENDENTE → ACEITA → FINALIZADA)</td><td><span class="tw-badge tw-badge-red">Crítico</span></td></tr>
                    <tr><td><strong>RF06</strong></td><td><strong>Chat em Tempo Real</strong></td><td>Comunicação via AJAX polling entre usuários vinculados em uma troca ativa</td><td><span class="tw-badge tw-badge-yellow">Alto</span></td></tr>
                    <tr><td><strong>RF07</strong></td><td><strong>Confirmação Dupla</strong></td><td>Ambos os usuários devem confirmar a conclusão do serviço para finalizar a troca</td><td><span class="tw-badge tw-badge-red">Crítico</span></td></tr>
                    <tr><td><strong>RF08</strong></td><td><strong>Sistema de Scoins</strong></td><td>Crédito de +10 Scoins para cada usuário ao finalizar uma troca, com extrato de transações</td><td><span class="tw-badge tw-badge-yellow">Alto</span></td></tr>
                    <tr><td><strong>RF09</strong></td><td><strong>Avaliação de Usuários</strong></td><td>Nota de 1 a 5 e comentário após troca finalizada, gerando reputação com média calculada</td><td><span class="tw-badge tw-badge-yellow">Alto</span></td></tr>
                    <tr><td><strong>RF10</strong></td><td><strong>Notificações</strong></td><td>Alertas em tempo real para novas propostas, aceites e Scoins recebidos</td><td><span class="tw-badge tw-badge-blue">Médio</span></td></tr>
                    <tr><td><strong>RF11</strong></td><td><strong>Favoritos</strong></td><td>Salvar serviços de interesse para acesso rápido posterior</td><td><span class="tw-badge tw-badge-blue">Médio</span></td></tr>
                    <tr><td><strong>RF12</strong></td><td><strong>Comunidade</strong></td><td>Feed social com posts, imagens, vídeos, curtidas e comentários entre usuários</td><td><span class="tw-badge tw-badge-blue">Médio</span></td></tr>
                    <tr><td><strong>RF13</strong></td><td><strong>Painel Admin</strong></td><td>Dashboard com estatísticas, gestão de usuários (bloquear/excluir) e serviços</td><td><span class="tw-badge tw-badge-red">Crítico</span></td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ══ 4. REQUISITOS NÃO FUNCIONAIS ══ -->
    <div class="tw-section" id="s-rnf">
        <div class="tw-section-header">
            <div class="tw-section-icon">🔒</div>
            <div>
                <h2>4. Requisitos Não Funcionais & Regras de Negócio</h2>
                <p>Segurança, desempenho, restrições e regras que governam o sistema</p>
            </div>
        </div>

        <div class="tw-grid-2">
            <div>
                <div class="tw-card">
                    <h3>🔐 Segurança</h3>
                    <ul>
                        <li><strong>RNF01 —</strong> Senhas criptografadas com <code>password_hash()</code> (bcrypt)</li>
                        <li><strong>RNF02 —</strong> Rotas protegidas por verificação de sessão em todos os controladores</li>
                        <li><strong>RNF03 —</strong> Prevenção de SQL Injection via PDO com Prepared Statements</li>
                        <li><strong>RNF04 —</strong> Sanitização de inputs com <code>htmlspecialchars()</code></li>
                    </ul>
                </div>
                <div class="tw-card">
                    <h3>⚡ Desempenho</h3>
                    <ul>
                        <li><strong>RNF05 —</strong> Chat com AJAX polling a cada 2 segundos sem recarregar a página</li>
                        <li><strong>RNF06 —</strong> Imagens de serviços e perfis otimizadas e armazenadas no servidor</li>
                        <li><strong>RNF07 —</strong> Consultas SQL com índices nas chaves estrangeiras principais</li>
                    </ul>
                </div>
            </div>
            <div>
                <div class="tw-card">
                    <h3>📋 Regras de Negócio</h3>
                    <ul>
                        <li><strong>RN01 —</strong> Um usuário só pode propor troca para serviços de outros usuários (não os próprios)</li>
                        <li><strong>RN02 —</strong> A troca só é finalizada quando AMBOS os usuários confirmam a conclusão</li>
                        <li><strong>RN03 —</strong> Scoins são creditados automaticamente apenas após a finalização da troca</li>
                        <li><strong>RN04 —</strong> Usuário bloqueado pelo admin não consegue fazer login</li>
                        <li><strong>RN05 —</strong> Um usuário não pode se auto-avaliar</li>
                        <li><strong>RN06 —</strong> Admin não pode bloquear ou excluir sua própria conta</li>
                        <li><strong>RN07 —</strong> Ao excluir usuário, todos os registros vinculados são removidos (cascade)</li>
                        <li><strong>RN08 —</strong> O nível (Bronze/Prata/Ouro) é calculado pelo total de trocas finalizadas</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- ══ 5. LGPD ══ -->
    <div class="tw-section" id="s-lgpd">
        <div class="tw-section-header">
            <div class="tw-section-icon">🧾</div>
            <div>
                <h2>5. Adequação à LGPD</h2>
                <p>Lei Geral de Proteção de Dados — como o Scambus protege os dados dos usuários</p>
            </div>
        </div>

        <div class="tw-highlight">
            <h4>O que é a LGPD</h4>
            <p>A Lei Geral de Proteção de Dados (Lei nº 13.709/2018) regula como empresas e sistemas devem coletar, armazenar e usar dados pessoais. O Scambus foi planejado para respeitar todos os seus princípios.</p>
        </div>

        <div class="tw-grid-2">
            <div class="tw-card">
                <h3>📦 Dados Coletados</h3>
                <table class="tw-table" style="margin-top:8px">
                    <thead><tr><th>Dado</th><th>Por que é necessário</th></tr></thead>
                    <tbody>
                        <tr><td>Nome completo</td><td>Identificação do usuário na plataforma</td></tr>
                        <tr><td>E-mail</td><td>Login e comunicação com o usuário</td></tr>
                        <tr><td>Telefone</td><td>Contato alternativo entre usuários</td></tr>
                        <tr><td>Senha</td><td>Autenticação (armazenada em hash)</td></tr>
                        <tr><td>Foto de perfil</td><td>Identificação visual na plataforma</td></tr>
                        <tr><td>Histórico de trocas</td><td>Comprovação de transações realizadas</td></tr>
                        <tr><td>Avaliações recebidas</td><td>Cálculo da reputação do usuário</td></tr>
                    </tbody>
                </table>
            </div>

            <div>
                <div class="tw-card">
                    <h3>✅ Consentimento do Usuário</h3>
                    <p>Ao se cadastrar, o usuário concorda com os <strong>Termos de Uso</strong> e a <strong>Política de Privacidade</strong> disponíveis no sistema (páginas <code>/institucional/termos</code> e <code>/institucional/privacidade</code>). Não é possível criar conta sem aceitar esses documentos.</p>
                </div>
                <div class="tw-card" style="margin-top:16px">
                    <h3>👤 Direitos do Usuário</h3>
                    <ul>
                        <li>✅ <strong>Visualizar</strong> seus dados na tela de perfil</li>
                        <li>✅ <strong>Corrigir</strong> informações via "Editar Perfil"</li>
                        <li>✅ <strong>Excluir</strong> a conta (remove todos os dados com cascade DELETE)</li>
                        <li>✅ <strong>Portabilidade</strong> via extrato da carteira</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="tw-grid-2">
            <div class="tw-card">
                <h3>🔐 Proteção dos Dados</h3>
                <ul>
                    <li>Senhas armazenadas como <strong>hash bcrypt</strong> (nunca em texto puro)</li>
                    <li>Acesso ao banco apenas via <strong>PDO com Prepared Statements</strong></li>
                    <li>Dados de sessão controlados pelo <strong>PHP Session</strong></li>
                    <li>Rotas protegidas: nenhum dado é acessível sem autenticação</li>
                </ul>
            </div>
            <div class="tw-card">
                <h3>🚫 Compartilhamento de Dados</h3>
                <p>O Scambus <strong>não compartilha dados com terceiros</strong>. Não há integração com sistemas de pagamento externo, anunciantes ou redes de publicidade. Todos os dados ficam armazenados localmente no banco de dados MySQL do servidor.</p>
            </div>
        </div>
    </div>

    <!-- ══ 5b. SEGURANÇA ══ -->
    <div class="tw-section" id="s-seguranca">
        <div class="tw-section-header">
            <div class="tw-section-icon">🛡️</div>
            <div>
                <h2>5b. Medidas de Segurança</h2>
                <p>Como o Scambus protege usuários, dados e transações contra ameaças</p>
            </div>
        </div>

        <div class="tw-grid-2">
            <div class="tw-card">
                <h3>🔑 Autenticação de Usuários</h3>
                <p>Login com e-mail e senha. A senha é verificada com <code>password_verify()</code> contra o hash bcrypt armazenado. Contas bloqueadas pelo admin são impedidas de acessar o sistema automaticamente.</p>
            </div>
            <div class="tw-card">
                <h3>🚦 Autorização e Controle de Acesso</h3>
                <p>Dois níveis de acesso: <strong>usuário comum</strong> e <strong>admin</strong>. Cada controlador verifica <code>$_SESSION['usuario_tipo']</code> antes de executar qualquer ação. Rotas do admin retornam "Acesso restrito" para usuários comuns.</p>
            </div>
            <div class="tw-card">
                <h3>💉 Prevenção de SQL Injection</h3>
                <p>100% das consultas ao banco utilizam <strong>PDO com Prepared Statements e bindParam()</strong>. Nenhuma query constrói SQL concatenando variáveis diretamente, eliminando a vulnerabilidade de SQL Injection.</p>
            </div>
            <div class="tw-card">
                <h3>🧹 Validação de Entradas (XSS)</h3>
                <p>Todos os dados exibidos nas views passam por <code>htmlspecialchars()</code>, convertendo caracteres especiais em entidades HTML e prevenindo ataques de Cross-Site Scripting (XSS).</p>
            </div>
            <div class="tw-card">
                <h3>🔒 Criptografia de Senhas</h3>
                <p>Algoritmo <strong>bcrypt</strong> via <code>password_hash($senha, PASSWORD_DEFAULT)</code>. O PHP escolhe automaticamente o custo adequado. Nunca armazenamos senhas em texto puro — nem o admin consegue ver a senha de um usuário.</p>
            </div>
            <div class="tw-card">
                <h3>💾 Backup e Recuperação</h3>
                <p>O banco de dados deve ser exportado periodicamente via <strong>mysqldump</strong>. Em caso de falha, o arquivo SQL <code>database_migration.sql</code> permite reconstruir toda a estrutura e repovoar os dados essenciais.</p>
            </div>
        </div>

        <div class="tw-card">
            <h3>🔍 Monitoramento e Resposta a Incidentes</h3>
            <p>Em ambiente de produção, o sistema deve registrar logs de acesso do servidor Apache. Em caso de ataque ou vazamento: (1) desativar o acesso imediatamente, (2) identificar a vulnerabilidade, (3) corrigir e atualizar as senhas afetadas, (4) notificar os usuários conforme exige a LGPD.</p>
        </div>
    </div>

    <!-- ══ 6. MERCADO ══ -->
    <div class="tw-section" id="s-mercado">
        <div class="tw-section-header">
            <div class="tw-section-icon">📊</div>
            <div>
                <h2>6. Estudo de Mercado e Viabilidade</h2>
                <p>Análise do problema, concorrentes e diferencial competitivo do Scambus</p>
            </div>
        </div>

        <div class="tw-card">
            <h3>❗ Problema no Mercado</h3>
            <p>Muitas pessoas possuem habilidades valiosas — design, programação, culinária, mecânica — mas não conseguem contratar serviços que precisam porque não têm dinheiro disponível. Simultaneamente, essas mesmas pessoas poderiam trocar seus serviços com outras que estão na mesma situação. O Scambus resolve essa lacuna criando um mercado de permuta digital.</p>
        </div>

        <div class="tw-grid-3" style="margin-bottom:20px">
            <div class="tw-concorrente">
                <h4>🔵 GetNinjas</h4>
                <p class="pro">✅ Grande base de usuários</p>
                <p class="pro">✅ Interface profissional</p>
                <p class="con">❌ Requer pagamento em dinheiro</p>
                <p class="con">❌ Cobra taxa do prestador</p>
                <p class="con">❌ Não permite troca de serviços</p>
            </div>
            <div class="tw-concorrente">
                <h4>🟠 OLX Serviços</h4>
                <p class="pro">✅ Alta visibilidade</p>
                <p class="pro">✅ Gratuito para anunciar</p>
                <p class="con">❌ Foco em venda, não troca</p>
                <p class="con">❌ Sem sistema de confiança</p>
                <p class="con">❌ Sem chat integrado</p>
            </div>
            <div class="tw-concorrente">
                <h4>🟢 Workana</h4>
                <p class="pro">✅ Escrow de pagamento</p>
                <p class="pro">✅ Sistema de avaliações</p>
                <p class="con">❌ Exclusivamente monetário</p>
                <p class="con">❌ Focado em empresas</p>
                <p class="con">❌ Taxas elevadas</p>
            </div>
        </div>

        <div class="tw-card">
            <h3>⭐ Diferencial do Scambus</h3>
            <div class="tw-grid-2" style="margin-top:8px">
                <div>
                    <p>✅ <strong>Única plataforma focada exclusivamente em escambo</strong> de serviços no Brasil</p><br>
                    <p>✅ <strong>Sistema de Scoins</strong> que cria incentivo para completar trocas</p><br>
                    <p>✅ <strong>Chat integrado</strong> sem precisar sair da plataforma</p>
                </div>
                <div>
                    <p>✅ <strong>Sistema de reputação</strong> com níveis (Bronze/Prata/Ouro)</p><br>
                    <p>✅ <strong>Comunidade social</strong> integrada para engajamento</p><br>
                    <p>✅ <strong>Confirmação dupla</strong> que protege ambas as partes</p>
                </div>
            </div>
        </div>

        <div class="tw-grid-2">
            <div class="tw-card">
                <h3>✅ Viabilidade do Projeto</h3>
                <p>O sistema é <strong>tecnicamente viável</strong> e já está implementado e funcionando em ambiente local. Foi desenvolvido com tecnologias amplamente dominadas pela equipe (PHP + MySQL), sem dependência de APIs pagas ou serviços externos.</p><br>
                <p><strong>Desafios superados:</strong> arquitetura MVC própria, sistema de chat sem WebSocket, transações ACID no banco e controle de sessão por tipo de usuário.</p>
            </div>
            <div class="tw-card">
                <h3>🚀 Possibilidades Futuras</h3>
                <ul>
                    <li>Aplicativo mobile (React Native)</li>
                    <li>Geolocalização para serviços próximos</li>
                    <li>Transferência de Scoins entre usuários</li>
                    <li>Plano premium com destaque de serviços</li>
                    <li>API pública para integração com outras plataformas</li>
                    <li>Sistema de disputa para trocas problemáticas</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- ══ 7. ARQUITETURA ══ -->
    <div class="tw-section" id="s-arquitetura">
        <div class="tw-section-header">
            <div class="tw-section-icon">🏗️</div>
            <div>
                <h2>7. Arquitetura do Sistema</h2>
                <p>Padrão MVC customizado, componentes e tecnologias utilizadas</p>
            </div>
        </div>

        <div class="tw-highlight">
            <h4>Arquitetura Escolhida: MVC (Model-View-Controller)</h4>
            <p>O Scambus foi construído sobre uma arquitetura MVC <strong>completamente customizada</strong>, sem frameworks externos. Isso significa controle total do código, maior aprendizado e sem dependências de terceiros.</p>
        </div>

        <div class="tw-grid-2">
            <div class="tw-card">
                <h3>📁 Fluxo de Requisição</h3>
                <div class="tw-timeline" style="margin-top:12px">
                    <div class="tw-timeline-item">
                        <div class="tw-timeline-dot"></div>
                        <h4>1. public/index.php</h4>
                        <p>Único ponto de entrada. Inicializa a sessão e chama o Roteador.</p>
                    </div>
                    <div class="tw-timeline-item">
                        <div class="tw-timeline-dot"></div>
                        <h4>2. nucleo/Roteador.php</h4>
                        <p>Analisa o parâmetro <code>?url=</code> e instancia o Controlador correto.</p>
                    </div>
                    <div class="tw-timeline-item">
                        <div class="tw-timeline-dot"></div>
                        <h4>3. Controlador</h4>
                        <p>Verifica sessão, chama os Modelos necessários e carrega a View.</p>
                    </div>
                    <div class="tw-timeline-item">
                        <div class="tw-timeline-dot"></div>
                        <h4>4. Model (PDO + MySQL)</h4>
                        <p>Executa queries com Prepared Statements e retorna os dados.</p>
                    </div>
                    <div class="tw-timeline-item">
                        <div class="tw-timeline-dot" style="background:var(--gold)"></div>
                        <h4>5. View → HTML</h4>
                        <p>Renderiza o HTML final com os dados recebidos do controlador.</p>
                    </div>
                </div>
            </div>

            <div>
                <div class="tw-card">
                    <h3>🛠️ Tecnologias Utilizadas</h3>
                    <table class="tw-table" style="margin-top:8px">
                        <thead><tr><th>Camada</th><th>Tecnologia</th></tr></thead>
                        <tbody>
                            <tr><td><strong>Linguagem Backend</strong></td><td>PHP 8</td></tr>
                            <tr><td><strong>Banco de Dados</strong></td><td>MySQL (PDO)</td></tr>
                            <tr><td><strong>Frontend</strong></td><td>HTML5 + CSS3 + JavaScript Vanilla</td></tr>
                            <tr><td><strong>Comunicação assíncrona</strong></td><td>AJAX (fetch API)</td></tr>
                            <tr><td><strong>Servidor</strong></td><td>Apache (XAMPP)</td></tr>
                            <tr><td><strong>Controle de rotas</strong></td><td>mod_rewrite (.htaccess)</td></tr>
                            <tr><td><strong>Criptografia</strong></td><td>bcrypt (password_hash)</td></tr>
                            <tr><td><strong>Upload de arquivos</strong></td><td>PHP move_uploaded_file()</td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="tw-card" style="margin-top:16px">
                    <h3>🗄️ Banco de Dados — 8 Tabelas</h3>
                    <p style="font-size:13px;color:#475569">usuarios · servicos · trocas · mensagens · avaliacoes · notificacoes · transacoes_scoin · favoritos</p>
                    <p style="font-size:13px;color:#475569;margin-top:8px">Todas com <strong>foreign keys</strong>, relações 1:N e transações ACID para operações críticas.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- ══ 8. PLANEJAMENTO ══ -->
    <div class="tw-section" id="s-planejamento">
        <div class="tw-section-header">
            <div class="tw-section-icon">📅</div>
            <div>
                <h2>8. Planejamento do Projeto</h2>
                <p>Ciclo de vida, cronograma, etapas de desenvolvimento e metodologia</p>
            </div>
        </div>

        <div class="tw-card">
            <h3>🔄 Ciclo de Vida do Sistema</h3>
            <div class="tw-grid-2" style="margin-top:12px">
                <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:16px">
                    <strong style="color:var(--navy);font-size:13px">1. Concepção</strong>
                    <p style="font-size:13px;color:#475569;margin-top:6px">Identificação do problema do escambo digital, levantamento de requisitos com base em plataformas similares e definição do escopo mínimo viável.</p>
                </div>
                <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:16px">
                    <strong style="color:var(--navy);font-size:13px">2. Desenvolvimento</strong>
                    <p style="font-size:13px;color:#475569;margin-top:6px">Construção iterativa: banco de dados → MVC base → autenticação → serviços → trocas → chat → avaliações → admin → comunidade.</p>
                </div>
                <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:16px">
                    <strong style="color:var(--navy);font-size:13px">3. Implementação</strong>
                    <p style="font-size:13px;color:#475569;margin-top:6px">Hospedagem em servidor Apache local (XAMPP) com mod_rewrite. Em produção: servidor Linux com Apache, PHP 8 e MySQL.</p>
                </div>
                <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:16px">
                    <strong style="color:var(--navy);font-size:13px">4. Operação & Evolução</strong>
                    <p style="font-size:13px;color:#475569;margin-top:6px">Monitoramento de logs, backup periódico do banco, correções de bugs reportados e adição de novas funcionalidades em sprints.</p>
                </div>
            </div>
        </div>

        <div class="tw-card">
            <h3>📆 Cronograma de Desenvolvimento</h3>
            <div class="tw-timeline" style="margin-top:16px">
                <div class="tw-timeline-item">
                    <div class="tw-timeline-dot"></div>
                    <span class="tw-badge tw-badge-green">Concluído</span>
                    <h4>Etapa 1 — Base e Autenticação (Semana 1–2)</h4>
                    <p>Estrutura MVC, banco de dados, cadastro e login de usuários com controle de sessão.</p>
                </div>
                <div class="tw-timeline-item">
                    <div class="tw-timeline-dot"></div>
                    <span class="tw-badge tw-badge-green">Concluído</span>
                    <h4>Etapa 2 — Serviços e Explorar (Semana 3–4)</h4>
                    <p>CRUD de serviços com upload de fotos, marketplace com filtros, página de detalhes.</p>
                </div>
                <div class="tw-timeline-item">
                    <div class="tw-timeline-dot"></div>
                    <span class="tw-badge tw-badge-green">Concluído</span>
                    <h4>Etapa 3 — Sistema de Trocas (Semana 5–6)</h4>
                    <p>Proposta, aceite, chat AJAX, confirmação dupla, crédito de Scoins e avaliações.</p>
                </div>
                <div class="tw-timeline-item">
                    <div class="tw-timeline-dot"></div>
                    <span class="tw-badge tw-badge-green">Concluído</span>
                    <h4>Etapa 4 — Admin e Notificações (Semana 7)</h4>
                    <p>Painel administrativo, gestão de usuários, notificações em tempo real.</p>
                </div>
                <div class="tw-timeline-item">
                    <div class="tw-timeline-dot" style="background:var(--gold)"></div>
                    <span class="tw-badge tw-badge-green">Concluído</span>
                    <h4>Etapa 5 — Comunidade e Documentação (Semana 8)</h4>
                    <p>Feed social, carteira de Scoins, documentação técnica e este trabalho acadêmico.</p>
                </div>
            </div>
        </div>

        <div class="tw-card">
            <h3>⚡ Metodologia: Desenvolvimento Ágil (Scrum adaptado)</h3>
            <p>O projeto seguiu uma metodologia ágil com sprints semanais, priorizando entregas funcionais a cada ciclo. Cada sprint tinha um conjunto de funcionalidades definido (backlog), que era desenvolvido, testado e integrado antes de iniciar o próximo.</p>
        </div>
    </div>

    <!-- ══ 10. TESTES ══ -->
    <div class="tw-section" id="s-testes">
        <div class="tw-section-header">
            <div class="tw-section-icon">🧪</div>
            <div>
                <h2>10. Testes e Qualidade</h2>
                <p>Tipos de testes realizados e como a qualidade do sistema foi validada</p>
            </div>
        </div>

        <div class="tw-grid-2">
            <div class="tw-card">
                <h3>🔬 Teste Unitário</h3>
                <p>Verificação isolada de funções críticas do sistema:</p>
                <ul style="margin-top:8px">
                    <li>Verificação do <code>password_verify()</code> na autenticação</li>
                    <li>Cálculo correto de nível (Bronze/Prata/Ouro)</li>
                    <li>Validação da média de avaliações com <code>AVG()</code></li>
                    <li>Conversão e sanitização de inputs</li>
                </ul>
            </div>
            <div class="tw-card">
                <h3>🔗 Teste de Integração</h3>
                <p>Verificação do funcionamento conjunto dos componentes:</p>
                <ul style="margin-top:8px">
                    <li>Fluxo completo de troca: proposta → chat → confirmação → Scoins</li>
                    <li>Cascade DELETE ao excluir usuário (serviços, trocas, avaliações)</li>
                    <li>Notificação criada corretamente ao aceitar troca</li>
                    <li>Saldo atualizado após crédito de Scoins</li>
                </ul>
            </div>
            <div class="tw-card">
                <h3>⚙️ Teste Funcional</h3>
                <p>Validação de que cada funcionalidade atende ao requisito:</p>
                <ul style="margin-top:8px">
                    <li>Cadastro e login com credenciais válidas e inválidas</li>
                    <li>Criação de serviço com e sem foto</li>
                    <li>Bloqueio de usuário impedindo acesso</li>
                    <li>Chat recebendo mensagens sem recarregar a página</li>
                </ul>
            </div>
            <div class="tw-card">
                <h3>🚀 Teste de Performance</h3>
                <p>Avaliação de velocidade e estabilidade:</p>
                <ul style="margin-top:8px">
                    <li>Carregamento do marketplace com múltiplos serviços</li>
                    <li>Resposta do AJAX do chat em menos de 500ms</li>
                    <li>Consultas SQL com múltiplos JOINs no dashboard</li>
                    <li>Upload de imagens com validação de tipo e tamanho</li>
                </ul>
            </div>
        </div>

        <div class="tw-card">
            <h3>✅ Validação Antes da Entrega</h3>
            <p>O sistema foi validado com usuários de teste reais: foram criadas contas distintas, propostas trocas entre elas, confirmadas e avaliadas, verificando o crédito correto de Scoins e o histórico de transações. Todos os fluxos principais foram percorridos sem erros.</p>
        </div>
    </div>

    <!-- ══ 11. MANUTENÇÃO ══ -->
    <div class="tw-section" id="s-manutencao">
        <div class="tw-section-header">
            <div class="tw-section-icon">🔄</div>
            <div>
                <h2>11. Manutenção do Sistema</h2>
                <p>Tipos de manutenção previstas e como cada uma seria realizada</p>
            </div>
        </div>

        <div class="tw-grid-3">
            <div class="tw-manut-card corretiva">
                <h3>🔴 Manutenção Corretiva</h3>
                <p><strong>Situação:</strong> Um usuário reporta que ao finalizar uma troca, os Scoins não foram creditados corretamente na carteira do parceiro.</p>
                <br>
                <p><strong>Resolução:</strong> Verificar os logs do servidor Apache para identificar o erro, analisar a função <code>excluir()</code> no Model Usuario e a transação no banco. Corrigir o bug, testar com dados reais e publicar a correção.</p>
            </div>
            <div class="tw-manut-card preventiva">
                <h3>🟡 Manutenção Preventiva</h3>
                <p><strong>Ação:</strong> Implementar backup automático diário do banco de dados MySQL usando <code>mysqldump</code> via cron job no servidor.</p>
                <br>
                <p><strong>Objetivo:</strong> Evitar perda total de dados em caso de falha do servidor, corrompimento do banco ou ataque. O backup é armazenado em pasta separada com data no nome do arquivo.</p>
            </div>
            <div class="tw-manut-card evolutiva">
                <h3>🟢 Manutenção Evolutiva</h3>
                <p><strong>Nova funcionalidade:</strong> Adicionar sistema de <strong>busca por geolocalização</strong>, permitindo que usuários filtrem serviços por proximidade geográfica.</p>
                <br>
                <p><strong>Implementação:</strong> Adicionar colunas de latitude/longitude na tabela de usuários, integrar API de geolocalização do navegador e criar filtro no Model Servico.</p>
            </div>
        </div>

        <div class="tw-card" style="margin-top:20px">
            <h3>🔄 Processo de Atualização</h3>
            <p>Atualizações seguem o ciclo: <strong>identificar necessidade → desenvolver em ambiente de testes → validar → publicar em produção → monitorar</strong>. Mudanças no banco de dados são feitas via migrations SQL versionadas (como o arquivo <code>database_migration.sql</code> já presente no projeto).</p>
        </div>
    </div>

    <!-- ══ 12. PROTOTIPAGEM ══ -->
    <div class="tw-section" id="s-prototipo">
        <div class="tw-section-header">
            <div class="tw-section-icon">📱</div>
            <div>
                <h2>12. Prototipagem e Interface</h2>
                <p>Telas desenvolvidas, fluxo de navegação e uso de IA no desenvolvimento</p>
            </div>
        </div>

        <div class="tw-card">
            <h3>🖥️ Telas Desenvolvidas</h3>
            <table class="tw-table" style="margin-top:8px">
                <thead><tr><th>Tela</th><th>URL</th><th>Função</th></tr></thead>
                <tbody>
                    <tr><td><strong>Início</strong></td><td><code>?url=home</code></td><td>Landing page com apresentação da plataforma e acesso ao sistema</td></tr>
                    <tr><td><strong>Cadastro</strong></td><td><code>?url=autenticacao/cadastro</code></td><td>Formulário de criação de conta com validação</td></tr>
                    <tr><td><strong>Login</strong></td><td><code>?url=autenticacao/login</code></td><td>Autenticação com e-mail e senha</td></tr>
                    <tr><td><strong>Dashboard</strong></td><td><code>?url=usuario/dashboard</code></td><td>Painel do usuário com saldo, trocas, serviços e avaliação</td></tr>
                    <tr><td><strong>Explorar</strong></td><td><code>?url=servico/listar</code></td><td>Marketplace com cards de serviços e filtro por categoria</td></tr>
                    <tr><td><strong>Ver Serviço</strong></td><td><code>?url=servico/ver/ID</code></td><td>Página detalhada com galeria, criador e botão de propor troca</td></tr>
                    <tr><td><strong>Chat</strong></td><td><code>?url=troca/chat/ID</code></td><td>Mensagens em tempo real entre usuários da troca</td></tr>
                    <tr><td><strong>Comunidade</strong></td><td><code>?url=comunidade/index</code></td><td>Feed social com posts, curtidas e comentários</td></tr>
                    <tr><td><strong>Admin</strong></td><td><code>?url=admin/dashboard</code></td><td>Painel administrativo com estatísticas e gestão</td></tr>
                </tbody>
            </table>
        </div>

        <div class="tw-card">
            <h3>🤖 Uso de Inteligência Artificial no Desenvolvimento</h3>
            <p>O sistema utilizou <strong>Claude (Anthropic)</strong> como ferramenta de IA durante o desenvolvimento para:</p>
            <div class="tw-grid-2" style="margin-top:12px">
                <ul>
                    <li>Geração de código PHP para modelos e controladores</li>
                    <li>Criação de queries SQL complexas com JOINs</li>
                    <li>Design de interfaces CSS com animações</li>
                </ul>
                <ul>
                    <li>Geração dos diagramas UML em código Mermaid</li>
                    <li>Depuração de erros e sugestões de correção</li>
                    <li>Criação desta documentação acadêmica</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- ══ 13. IMPLANTAÇÃO ══ -->
    <div class="tw-section" id="s-implantacao">
        <div class="tw-section-header">
            <div class="tw-section-icon">🚀</div>
            <div>
                <h2>13. Implantação e Treinamento</h2>
                <p>Como o sistema é disponibilizado e como os usuários aprendem a usar</p>
            </div>
        </div>

        <div class="tw-grid-2">
            <div class="tw-card">
                <h3>🖥️ Implantação Atual (Desenvolvimento)</h3>
                <ul>
                    <li><strong>Servidor:</strong> Apache via XAMPP</li>
                    <li><strong>Banco:</strong> MySQL local</li>
                    <li><strong>Acesso Local:</strong> <code>localhost/scambus/public/</code></li>
                    <li><strong>Acesso Produção:</strong> <code><?= APP_URL ?></code></li>
                    <li><strong>Requisitos:</strong> PHP 8+, MySQL 5.7+, mod_rewrite</li>
                    <li><strong>Setup:</strong> Importar <code>database_migration.sql</code> e configurar <code>configuracao/banco.php</code></li>
                </ul>
            </div>
            <div class="tw-card">
                <h3>☁️ Implantação em Produção (Planejada)</h3>
                <ul>
                    <li><strong>Servidor:</strong> VPS Linux com Apache + PHP 8</li>
                    <li><strong>Banco:</strong> MySQL em servidor dedicado</li>
                    <li><strong>HTTPS:</strong> Certificado SSL via Let's Encrypt</li>
                    <li><strong>Domínio:</strong> scambus.com.br</li>
                    <li><strong>CI/CD:</strong> Deploy via Git com hooks no servidor</li>
                </ul>
            </div>
        </div>

        <div class="tw-card">
            <h3>📚 Treinamento e Onboarding do Usuário</h3>
            <p>O Scambus foi projetado com foco em <strong>UX intuitiva</strong>, reduzindo ao máximo a necessidade de treinamento formal. Os principais recursos de apoio são: página de Ajuda (<code>/institucional/ajuda</code>), tooltips nas funcionalidades principais, e fluxo guiado no primeiro acesso.</p>
        </div>
    </div>

    <!-- ══ 14. RISCOS ══ -->
    <div class="tw-section" id="s-riscos">
        <div class="tw-section-header">
            <div class="tw-section-icon">⚠️</div>
            <div>
                <h2>14. Gestão de Riscos</h2>
                <p>Principais riscos identificados, impacto e estratégias de mitigação</p>
            </div>
        </div>

        <div class="tw-card" style="padding:0;overflow:hidden">
            <table class="tw-table">
                <thead>
                    <tr><th>Risco</th><th>Probabilidade</th><th>Impacto</th><th>Mitigação</th></tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Usuário não finaliza a troca após receber o serviço</strong></td>
                        <td><span class="tw-badge tw-badge-yellow">Médio</span></td>
                        <td><span class="tw-badge tw-badge-red">Alto</span></td>
                        <td>Confirmação dupla obrigatória + sistema de avaliação pós-troca + notificações de lembrete</td>
                    </tr>
                    <tr>
                        <td><strong>Vazamento de dados de usuários</strong></td>
                        <td><span class="tw-badge tw-badge-green">Baixo</span></td>
                        <td><span class="tw-badge tw-badge-red">Alto</span></td>
                        <td>PDO Prepared Statements + bcrypt + sanitização de inputs + HTTPS em produção</td>
                    </tr>
                    <tr>
                        <td><strong>Falha no servidor / perda de dados</strong></td>
                        <td><span class="tw-badge tw-badge-green">Baixo</span></td>
                        <td><span class="tw-badge tw-badge-red">Crítico</span></td>
                        <td>Backup diário automatizado via mysqldump + migration SQL versionada no repositório</td>
                    </tr>
                    <tr>
                        <td><strong>Usuários mal-intencionados / spam</strong></td>
                        <td><span class="tw-badge tw-badge-yellow">Médio</span></td>
                        <td><span class="tw-badge tw-badge-yellow">Médio</span></td>
                        <td>Painel admin com bloqueio imediato de contas + sistema de denúncia (roadmap)</td>
                    </tr>
                    <tr>
                        <td><strong>Baixa adoção da plataforma</strong></td>
                        <td><span class="tw-badge tw-badge-yellow">Médio</span></td>
                        <td><span class="tw-badge tw-badge-yellow">Médio</span></td>
                        <td>Comunidade integrada + sistema de gamificação (Scoins e níveis) para engajar usuários</td>
                    </tr>
                    <tr>
                        <td><strong>Upload de arquivos maliciosos</strong></td>
                        <td><span class="tw-badge tw-badge-green">Baixo</span></td>
                        <td><span class="tw-badge tw-badge-yellow">Médio</span></td>
                        <td>Validação de tipo MIME, extensão e tamanho máximo antes de aceitar o arquivo</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="tw-card" style="margin-top:20px">
            <h3>🏆 Considerações Finais</h3>
            <p>O <strong>Scambus</strong> demonstra que é possível construir uma plataforma completa de economia colaborativa aplicando os princípios da Engenharia de Sistemas: levantamento de requisitos, arquitetura bem definida, segurança desde o design, conformidade com LGPD, testes e planejamento de manutenção.</p>
            <br>
            <p>O sistema está funcional com <strong>13 funcionalidades implementadas</strong>, arquitetura MVC própria, banco de dados relacional com 8 tabelas, segurança por camadas e documentação técnica completa com diagramas UML. É um projeto academicamente sólido e tecnicamente robusto para a área de Engenharia de Sistemas.</p>
        </div>
    </div>

</main>
</div>

<script>
function showSection(id, btn) {
    document.querySelectorAll('.tw-section').forEach(s => s.classList.remove('active'));
    document.querySelectorAll('.tw-nav-item').forEach(b => b.classList.remove('active'));
    document.getElementById(id).classList.add('active');
    btn.classList.add('active');
    window.scrollTo({ top: 0, behavior: 'smooth' });
}
</script>

</body>
</html>