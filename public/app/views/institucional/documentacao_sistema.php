<?php
/* 
|--------------------------------------------------------------------------
| DOCUMENTAÇÃO UNIFICADA DO SISTEMA SCAMBUS
|--------------------------------------------------------------------------
| Desenvolvida por Antigravity (Sênior Engineer)
| Layout: Dashboard Moderno (Neo-Telematic)
*/
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentação do Sistema | Scambus</title>
    
    <!-- FONTS -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- MERMAID JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mermaid/10.9.0/mermaid.min.js"></script>
    <script>
    mermaid.initialize({
        startOnLoad: false,
        theme: 'dark',
        securityLevel: 'loose',
        flowchart: { useMaxWidth: true, htmlLabels: true, curve: 'basis' },
        sequence: { useMaxWidth: true, showSequenceNumbers: false },
        er: { useMaxWidth: true }
    });
    window.addEventListener('load', function() {
        mermaid.run({ querySelector: '.mermaid' });
    });
    </script>

    <style>
        :root {
            --sidebar-width: 280px;
            --color-bg: #0a0c10;
            --color-surface: #12141c;
            --color-border: rgba(255,255,255,0.08);
            --color-accent: #00ffaa;
            --color-accent-hover: #00cc88;
            --color-text-muted: #94a3b8;
            --color-text: #e2e8f0;
            --font-main: 'Plus Jakarta Sans', sans-serif;
            --font-display: 'Outfit', sans-serif;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            background: var(--color-bg); 
            color: var(--color-text); 
            font-family: var(--font-main);
            overflow-x: hidden;
            display: flex;
            min-height: 100vh;
        }

        /* SCROLLBAR */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--color-accent); }

        /* SIDEBAR */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--color-surface);
            border-right: 1px solid var(--color-border);
            position: fixed;
            left: 0; top: 0;
            display: flex;
            flex-direction: column;
            z-index: 100;
        }

        .sidebar-brand {
            padding: 2.5rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid var(--color-border);
        }

        .sidebar-brand .logo {
            width: 32px; height: 32px;
            background: var(--color-accent);
            border-radius: 6px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; color: #000; font-family: var(--font-display);
        }

        .sidebar-brand .title { font-size: 1.1rem; font-weight: 800; letter-spacing: -0.5px; font-family: var(--font-display); }

        .sidebar-menu {
            flex: 1;
            overflow-y: auto;
            padding: 1.5rem 0.75rem;
        }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.85rem 1rem;
            color: var(--color-text-muted);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            margin-bottom: 4px;
        }

        .menu-link i { font-size: 1.1rem; width: 24px; text-align: center; }

        .menu-link:hover {
            color: #fff;
            background: rgba(255,255,255,0.03);
            transform: translateX(4px);
        }

        .menu-link.active {
            color: #fff;
            background: rgba(0, 255, 170, 0.1);
            border: 1px solid rgba(0, 255, 170, 0.2);
        }

        .menu-link.active i { color: var(--color-accent); }

        /* MAIN CONTENT */
        .main-content {
            margin-left: var(--sidebar-width);
            flex: 1;
            padding: 3rem 4rem;
            max-width: 1200px;
        }

        header.content-header {
            margin-bottom: 4rem;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .header-title h1 { font-family: var(--font-display); font-size: 2.5rem; font-weight: 800; margin-bottom: 0.5rem; }
        .header-title p { color: var(--color-text-muted); font-size: 1rem; }

        .btn-back {
            background: rgba(255,255,255,0.05);
            border: 1px solid var(--color-border);
            color: #fff;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            display: flex; align-items: center; gap: 8px;
            transition: all 0.2s;
        }
        .btn-back:hover { background: rgba(255,255,255,0.1); }

        /* SECTIONS */
        .doc-section {
            display: none;
            animation: fadeIn 0.4s ease forwards;
        }
        .doc-section.active { display: block; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 12px;
            font-family: var(--font-display);
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--color-border);
        }
        .section-title i { color: var(--color-accent); }

        .content-card {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: 14px;
            padding: 2.5rem;
            margin-bottom: 2rem;
        }

        .content-card h3 { font-family: var(--font-display); font-size: 1.25rem; margin-bottom: 1.25rem; color: #fff; display: flex; align-items: center; gap: 8px; }
        .content-card p { color: var(--color-text-muted); line-height: 1.7; margin-bottom: 1.5rem; }

        .highlight-box {
            background: rgba(0, 255, 170, 0.03);
            border-left: 3px solid var(--color-accent);
            padding: 1.5rem;
            border-radius: 0 10px 10px 0;
            margin-bottom: 1.5rem;
        }

        /* GRID */
        .data-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem; }
        .data-item { background: rgba(255,255,255,0.02); padding: 1.5rem; border-radius: 10px; border: 1px solid var(--color-border); transition: all 0.2s; }
        .data-item:hover { border-color: var(--color-accent); transform: translateY(-3px); }
        .data-item h4 { font-size: 0.9rem; color: #fff; margin-bottom: 0.5rem; }
        .data-item p { font-size: 0.85rem; color: var(--color-text-muted); margin: 0; }

        /* TABLE */
        .modern-table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        .modern-table th { text-align: left; padding: 1rem; color: var(--color-accent); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; border-bottom: 2px solid var(--color-border); }
        .modern-table td { padding: 1.25rem 1rem; border-bottom: 1px solid var(--color-border); font-size: 0.9rem; }

        /* DIAGRAMAS */
        .diagram-container { background: #fff; border-radius: 12px; padding: 2rem; margin-top: 1rem; display: flex; justify-content: center; border: 1px solid var(--color-border); overflow-x: auto; }
        .diagram-container svg { max-width: 100%; height: auto; }

        .code-toggle { margin-top: 1.5rem; }
        .code-toggle-btn { background: transparent; border: 1px solid var(--color-border); color: var(--color-text-muted); padding: 0.6rem 1rem; border-radius: 6px; font-size: 0.8rem; cursor: pointer; transition: all 0.2s; }
        .code-toggle-btn:hover { color: #fff; background: rgba(255,255,255,0.05); }
        .code-block { display: none; margin-top: 1rem; background: #000; padding: 1rem; border-radius: 8px; border: 1px solid var(--color-border); }
        .code-block pre { font-family: 'JetBrains Mono', monospace; font-size: 0.8rem; color: var(--color-accent); overflow-x: auto; white-space: pre; }
        .code-block.active { display: block; }

        /* RESPONSIVE */
        @media (max-width: 1024px) {
            .sidebar { width: 80px; }
            .sidebar-brand .title, .menu-link span { display: none; }
            .sidebar-brand { justify-content: center; padding: 2rem 0.5rem; }
            .main-content { margin-left: 80px; padding: 2rem; }
            .header-title h1 { font-size: 2rem; }
        }

        @media (max-width: 768px) {
            .sidebar { display: none; }
            .main-content { margin-left: 0; padding: 1.5rem; }
            .data-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="logo">S</div>
            <div class="title">SCAMBUS</div>
        </div>
        
        <nav class="sidebar-menu">
            <a href="#visao" class="menu-link active" onclick="showSection('visao', this)"><i class="fas fa-home"></i> <span>Visão Geral</span></a>
            <a href="#requisitos" class="menu-link" onclick="showSection('requisitos', this)"><i class="fas fa-list-check"></i> <span>Requisitos do Sistema</span></a>
            <a href="#arquitetura" class="menu-link" onclick="showSection('arquitetura', this)"><i class="fas fa-sitemap"></i> <span>Arquitetura</span></a>
            <a href="#planejamento" class="menu-link" onclick="showSection('planejamento', this)"><i class="fas fa-calendar-alt"></i> <span>Planejamento</span></a>
            <a href="#testes" class="menu-link" onclick="showSection('testes', this)"><i class="fas fa-vial"></i> <span>Testes</span></a>
            <a href="#seguranca" class="menu-link" onclick="showSection('seguranca', this)"><i class="fas fa-shield-halved"></i> <span>Segurança</span></a>
            <a href="#lgpd" class="menu-link" onclick="showSection('lgpd', this)"><i class="fas fa-gavel"></i> <span>LGPD</span></a>
            <a href="#mercado" class="menu-link" onclick="showSection('mercado', this)"><i class="fas fa-chart-line"></i> <span>Estudo de Mercado</span></a>
            <a href="#manutencao" class="menu-link" onclick="showSection('manutencao', this)"><i class="fas fa-wrench"></i> <span>Manutenção</span></a>
            <a href="#prototipagem" class="menu-link" onclick="showSection('prototipagem', this)"><i class="fas fa-palette"></i> <span>Prototipagem</span></a>
            <a href="#diagramas" class="menu-link" onclick="showSection('diagramas', this)"><i class="fas fa-project-diagram"></i> <span>Diagramas</span></a>
            <a href="#implantacao" class="menu-link" onclick="showSection('implantacao', this)"><i class="fas fa-cloud-arrow-up"></i> <span>Implantação</span></a>
            <a href="#riscos" class="menu-link" onclick="showSection('riscos', this)"><i class="fas fa-triangle-exclamation"></i> <span>Riscos</span></a>
            <a href="#conclusao" class="menu-link" onclick="showSection('conclusao', this)"><i class="fas fa-flag-checkered"></i> <span>Considerações Finais</span></a>
        </nav>
    </aside>

    <!-- CONTENT -->
    <main class="main-content">
        <header class="content-header">
            <div class="header-title">
                <h1>Documentação do Sistema</h1>
                <p>Engenharia de Sistemas e Documentação Técnica Detalhada</p>
            </div>
            <a href="javascript:history.back()" class="btn-back"><i class="fas fa-arrow-left"></i> Voltar</a>
        </header>

        <!-- 1. VISÃO GERAL -->
        <section id="visao" class="doc-section active">
            <h2 class="section-title"><i class="fas fa-home"></i> Visão Geral</h2>
            <div class="content-card">
                <h3>O que é o Scambus?</h3>
                <p>O <strong>Scambus</strong> é uma plataforma de economia colaborativa focada na permuta de competências profissionais. O sistema resolve o problema da falta de liquidez financeira de novos talentos e estudantes, permitindo que troquem tempo e conhecimento por serviços de outros membros.</p>
                <div class="highlight-box">
                    <strong>Proposta de Valor:</strong> Transformar capital intelectual ocioso em poder de aquisição real dentro de uma rede de confiança auditável via <strong>Scoins</strong>.
                </div>
                <div class="data-grid">
                    <div class="data-item">
                        <h4>Gamificação Econômica</h4>
                        <p>Uso da moeda virtual Scoins para equilibrar as transações e recompensar o engajamento.</p>
                    </div>
                    <div class="data-item">
                        <h4>Escrow Financeiro</h4>
                        <p>Garantia de que o crédito só é liberado após a confirmação mútua de ambas as partes.</p>
                    </div>
                    <div class="data-item">
                        <h4>Reputação Progressiva</h4>
                        <p>Sistema de níveis que reflete a qualidade e confiança do prestador na comunidade.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- 2. REQUISITOS -->
        <section id="requisitos" class="doc-section">
            <h2 class="section-title"><i class="fas fa-list-check"></i> Requisitos do Sistema</h2>
            <div class="content-card">
                <h3>Requisitos Funcionais (RF)</h3>
                <p>Mapeamento das funcionalidades principais que garantem a operação da plataforma.</p>
                <table class="modern-table">
                    <thead><tr><th>Cód.</th><th>Descrição</th><th>Prioridade</th></tr></thead>
                    <tbody>
                        <tr><td><strong>RF01</strong></td><td>Gerenciamento de Smart Wallet (Carteira Scoins)</td><td>Crítica</td></tr>
                        <tr><td><strong>RF02</strong></td><td>Publicação e Edição de Anúncios de Habilidades</td><td>Alta</td></tr>
                        <tr><td><strong>RF03</strong></td><td>Motor de Transação via Escrow (Saldo Retido)</td><td>Crítica</td></tr>
                        <tr><td><strong>RF04</strong></td><td>Chat Real-time para negociação de escopo</td><td>Média</td></tr>
                        <tr><td><strong>RF05</strong></td><td>Feed da Comunidade com interações sociais</td><td>Média</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="content-card">
                <h3>Requisitos Não Funcionais (RNF)</h3>
                <p>Atributos de qualidade e performance do sistema.</p>
                <div class="data-grid">
                    <div class="data-item">
                        <h4>Segurança (Capa 07)</h4>
                        <p>Hash unilateral BCRYPT para senhas e tokens CSRF em todos os formulários.</p>
                    </div>
                    <div class="data-item">
                        <h4>Performance</h4>
                        <p>Tempo de resposta de consultas ao banco otimizado via Prepared Statements (PDO).</p>
                    </div>
                    <div class="data-item">
                        <h4>Responsividade</h4>
                        <p>Interface adaptável a dispositivos móveis (Mobile-First approach).</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- 3. ARQUITETURA -->
        <section id="arquitetura" class="doc-section">
            <h2 class="section-title"><i class="fas fa-sitemap"></i> Arquitetura do Sistema</h2>
            <div class="content-card">
                <h3>Padrão MVC (Model-View-Controller)</h3>
                <p>O sistema foi construído sem frameworks externos, utilizando uma arquitetura MVC customizada para garantir controle total sobre a lógica e performance.</p>
                <div class="highlight-box">
                    <strong>Estrutura:</strong> O Roteador analisa as requisições HTTP, despacha para o Controlador responsável, que interage com o Modelo (Banco de Dados) e renderiza a Visão (Interface) para o usuário.
                </div>
                <div class="data-grid">
                    <div class="data-item">
                        <h4>Backend</h4>
                        <p>PHP 8.2+ Orientado a Objetos puro.</p>
                    </div>
                    <div class="data-item">
                        <h4>Banco de Dados</h4>
                        <p>MariaDB/MySQL com integridade referencial rigorosa.</p>
                    </div>
                    <div class="data-item">
                        <h4>Frontend</h4>
                        <p>Vanilla CSS3 e JS Moderno (ES6+).</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- 4. PLANEJAMENTO -->
        <section id="planejamento" class="doc-section">
            <h2 class="section-title"><i class="fas fa-calendar-alt"></i> Planejamento do Projeto</h2>
            <div class="content-card">
                <h3>Metodologia Ágil (SCRUM)</h3>
                <p>O desenvolvimento foi dividido em Sprints semanais, focando em "Product Increments" testáveis.</p>
                <div class="data-grid">
                    <div class="data-item">
                        <h4>Sprint 01: Core</h4>
                        <p>Arquitetura, Banco de Dados e Sistema de Autenticação.</p>
                    </div>
                    <div class="data-item">
                        <h4>Sprint 02: Trocas</h4>
                        <p>Implementação do Chat, Escrow e Carteira Digital.</p>
                    </div>
                    <div class="data-item">
                        <h4>Sprint 03: Social</h4>
                        <p>Comunidade, Feed e Refinamento de UX/UI.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- 5. TESTES -->
        <section id="testes" class="doc-section">
            <h2 class="section-title"><i class="fas fa-vial"></i> Testes e Qualidade</h2>
            <div class="content-card">
                <h3>Estratégia de Validação</h3>
                <p>Foram aplicados testes de unidade na lógica contábil das Scoins e testes de integração no fluxo de troca.</p>
                <ul style="color: var(--color-text-muted); padding-left: 1.5rem; line-height: 2;">
                    <li><strong>Testes Funcionais:</strong> Validação de cada RF via interface.</li>
                    <li><strong>Testes de Segurança:</strong> Ataques simulados de SQLi e XSS.</li>
                    <li><strong>Stress Testing:</strong> Verificação da concorrência em transações de saldo.</li>
                </ul>
            </div>
        </section>

        <!-- 6. SEGURANÇA -->
        <section id="seguranca" class="doc-section">
            <h2 class="section-title"><i class="fas fa-shield-halved"></i> Segurança e Integridade</h2>
            <div class="content-card">
                <h3>Camadas de Defesa</h3>
                <p>A proteção de dados é o pilar central da engenharia do Scambus.</p>
                <table class="modern-table">
                    <thead><tr><th>Camada</th><th>Método de Defesa</th></tr></thead>
                    <tbody>
                        <tr><td><strong>Autenticação</strong></td><td>Password Hashing BCRYPT (Unilateral)</td></tr>
                        <tr><td><strong>Banco de Dados</strong></td><td>PDO Prepared Statements (Anti-SQLi)</td></tr>
                        <tr><td><strong>Formulários</strong></td><td>Tokens Únicos por Sessão (Anti-CSRF)</td></tr>
                        <tr><td><strong>XSS</strong></td><td>Sanitização de saídas via htmlspecialchars()</td></tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- 7. LGPD -->
        <section id="lgpd" class="doc-section">
            <h2 class="section-title"><i class="fas fa-gavel"></i> LGPD (Proteção de Dados)</h2>
            <div class="content-card">
                <h3>Conformidade e Transparência</h3>
                <p>O sistema foi projetado sob os princípios de "Privacy by Design", coletando apenas o estritamente necessário para a funcionalidade.</p>
                <div class="data-item">
                    <h4>Direitos do Usuário</h4>
                    <p>O Scambus permite ao usuário exportar seu histórico ou solicitar a deleção integral de seus dados (Direito ao Esquecimento), com exclusão em cascata no banco de dados.</p>
                </div>
            </div>
        </section>

        <!-- 8. MERCADO -->
        <section id="mercado" class="doc-section">
            <h2 class="section-title"><i class="fas fa-chart-line"></i> Estudo de Mercado</h2>
            <div class="content-card">
                <h3>Oportunidade na Gig Economy</h3>
                <p>O crescimento do trabalho freelancer e a alta inflação criam o cenário perfeito para moedas de troca intelectual.</p>
                <div class="highlight-box">
                    <strong>Diferencial:</strong> Diferente de plataformas como Upwork, o Scambus tem custo real ZERO reais, operando puramente em economia de permuta.
                </div>
            </div>
        </section>

        <!-- 9. MANUTENÇÃO -->
        <section id="manutencao" class="doc-section">
            <h2 class="section-title"><i class="fas fa-wrench"></i> Manutenção do Sistema</h2>
            <div class="content-card">
                <h3>Tipos de Manutenção Previstos</h3>
                <div class="data-grid">
                    <div class="data-item">
                        <h4>Corretiva</h4>
                        <p>Patching semanal de bugs identificados nos logs de erro.</p>
                    </div>
                    <div class="data-item">
                        <h4>Preventiva</h4>
                        <p>Auditorias mensais na integridade das transações do banco.</p>
                    </div>
                    <div class="data-item">
                        <h4>Evolutiva</h4>
                        <p>Novos módulos de ranking e integração com APIs de geolocalização.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- 10. PROTOTIPAGEM -->
        <section id="prototipagem" class="doc-section">
            <h2 class="section-title"><i class="fas fa-palette"></i> Prototipagem e Design</h2>
            <div class="content-card">
                <h3>Design System Neo-Telematic</h3>
                <p>Focado em uma estética de alta tecnologia, utilizando o modo escuro como padrão para reduzir a fadiga visual e destacar elementos de ação em verde ácido.</p>
                <div class="highlight-box">
                    <strong>Conceito UX:</strong> Fluxos simplificados e feedback visual em cada transação para garantir que o usuário sinta segurança ao "pagar" em Scoins.
                </div>
            </div>
        </section>

        <!-- 11. DIAGRAMAS (PONTO CRÍTICO) -->
        <section id="diagramas" class="doc-section">
            <h2 class="section-title"><i class="fas fa-project-diagram"></i> Diagramas do Sistema</h2>
            <p style="margin-bottom: 2rem; color: var(--color-text-muted);">Abaixo estão os diagramas UML e fluxogramas que definem a inteligência estrutural do sistema.</p>

            <!-- FLUXO GERAL -->
            <div class="content-card">
                <h3><i class="fas fa-wave-square"></i> Fluxo Geral da Jornada</h3>
                <div class="diagram-container">
                    <div class="mermaid">
flowchart TD
    START(["Acessa o Scambus"])
    START --> AUTH{"Esta logado?"}
    AUTH -- Nao --> LOGIN["Tela de Login"]
    LOGIN --> NOVO{"Tem conta?"}
    NOVO -- Nao --> CAD["Cadastro"]
    CAD --> LOGIN
    NOVO -- Sim --> FORM["Preenche credenciais"]
    FORM --> VALIDA{"Credenciais validas?"}
    VALIDA -- Nao --> ERRO["Exibe erro"]
    ERRO --> LOGIN
    VALIDA -- Sim --> TIPO
    AUTH -- Sim --> TIPO{"Tipo?"}
    TIPO -- Admin --> ADMIN["Painel Admin"]
    TIPO -- Usuario --> DASH["Dashboard"]
    DASH --> ACA{"Acao"}
    ACA --> CRIAR["Criar Servico"]
    ACA --> EXPLOR["Explorar Servicos"]
    EXPLOR --> VER["Ver Servico"]
    VER --> PROP["Propor Troca"]
    PROP --> CHAT["Chat"]
    CHAT --> REAL["Servico Realizado"]
    REAL --> CONF["Ambos Confirmam"]
    CONF --> FIN["Troca FINALIZADA"]
    FIN --> SC["+Scoins"]
    FIN --> AV["Avaliacao Mutua"]
    AV --> REP["Reputacao Atualizada"]
                    </div>
                </div>
                <div class="code-toggle">
                    <button class="code-toggle-btn" onclick="toggleCode('code-fluxo')">Ver código Mermaid</button>
                    <div id="code-fluxo" class="code-block"><pre>flowchart TD ...</pre></div>
                </div>
            </div>

            <!-- CLASSES -->
            <div class="content-card">
                <h3><i class="fas fa-box"></i> Diagrama de Classes</h3>
                <div class="diagram-container">
                    <div class="mermaid">
classDiagram
    class Usuario {
        +int id
        +string nome
        +string email
        +float saldo_scoins
        +buscarPorEmail(email)
        +criar(dados)
        +bloquear(id)
    }
    class Servico {
        +int id
        +int usuario_id
        +string titulo
        +string status
        +criar(dados)
        +listar()
    }
    class Troca {
        +int id
        +int usuario_origem_id
        +int servico_id
        +string status
        +propor()
        +confirmar(id)
    }
    Usuario "1" --> "0..*" Servico : cria
    Usuario "1" --> "0..*" Troca : participa
    Servico "1" --> "0..*" Troca : origina
                    </div>
                </div>
                <div class="code-toggle">
                    <button class="code-toggle-btn" onclick="toggleCode('code-classes')">Ver código Mermaid</button>
                    <div id="code-classes" class="code-block"><pre>classDiagram ...</pre></div>
                </div>
            </div>

            <!-- DIAGRAMAS (PONTOS REINFORÇADOS) -->
            <div class="content-card">
                <h3><i class="fas fa-database"></i> Diagrama ER (Entidade-Relacionamento)</h3>
                <div class="diagram-container">
                    <div class="mermaid">
erDiagram
    USUARIOS ||--o{ SERVICOS : cria
    USUARIOS ||--o{ TROCAS : participa
    SERVICOS ||--o{ TROCAS : origina
    TROCAS ||--o{ MENSAGENS : contem
    TROCAS ||--o{ AVALIACOES : gera
    USUARIOS {
        int id PK
        string nome
        float saldo_scoins
    }
    SERVICOS {
        int id PK
        int usuario_id FK
        string titulo
    }
    TROCAS {
        int id PK
        string status
    }
                    </div>
                </div>
            </div>

            <div class="content-card">
                <h3><i class="fas fa-exchange-alt"></i> Diagrama de Sequência (Fluxo de Troca)</h3>
                <div class="diagram-container">
                    <div class="mermaid">
sequenceDiagram
    actor UA as Usuário A
    actor UB as Usuário B
    participant C as ControladorTroca
    participant MT as Model Troca
    participant MS as Model Scoin
    
    UA->>C: Propor Troca
    C->>MT: Criar Registro (Pendente)
    C-->>UB: Notificar Proposta
    UB->>C: Aceitar Proposta
    C->>MT: Status = ACEITA
    Note over UA,UB: Chat & Execução
    UA->>C: Confirmar Conclusão
    UB->>C: Confirmar Conclusão
    C->>MS: Transferir Scoins
    C->>MT: Status = FINALIZADA
                    </div>
                </div>
            </div>

        <!-- 12. IMPLANTAÇÃO -->
        <section id="implantacao" class="doc-section">
            <h2 class="section-title"><i class="fas fa-rocket"></i> Implantação e Deploy</h2>
            <div class="content-card">
                <h3>Guia de Implantação</h3>
                <div class="highlight-box">
                    <strong>Ambiente:</strong> Servidor com suporte a PHP 8.1+ e MySQL/MariaDB.
                </div>
                <p>1. Upload dos arquivos para a pasta raiz web.<br>2. Importação do script SQL para o banco de dados.<br>3. Configuração do arquivo `configuracao/banco.php` com as credenciais do host.</p>
            </div>
        </section>

        <!-- 13. RISCOS -->
        <section id="riscos" class="doc-section">
            <h2 class="section-title"><i class="fas fa-triangle-exclamation"></i> Gestão de Riscos</h2>
            <div class="content-card">
                <h3>Riscos Técnicos e Humanos</h3>
                <div class="data-grid">
                    <div class="data-item">
                        <h4>Risco de Fraude</h4>
                        <p>Usuários tentarem duplicar saldo via ataques de concorrência. (Mitigação: Transações Bancárias Atômicas).</p>
                    </div>
                    <div class="data-item">
                        <h4>Risco de Abandono</h4>
                        <p>Falta de anúncios novos que desestimulam a troca. (Mitigação: Notificações push de novos serviços).</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- 14. CONSIDERAÇÕES FINAIS -->
        <section id="conclusao" class="doc-section">
            <h2 class="section-title"><i class="fas fa-flag-checkered"></i> Considerações Finais</h2>
            <div class="content-card">
                <p>O Scambus representa a aplicação real de conceitos complexos de engenharia de software em um problema social latente. Sua estrutura modular e segura permite que o sistema escale organicamente, servindo como modelo para outras plataformas de economia comunitária.</p>
                <div class="highlight-box" style="text-align: center; border: none;">
                    <strong>FIM DA DOCUMENTAÇÃO - PROJETO SCAMBUS 🚀</strong>
                </div>
            </div>
        </section>
    </main>

    <script>
        function showSection(id, element) {
            // Update Menu
            document.querySelectorAll('.menu-link').forEach(link => link.classList.remove('active'));
            element.classList.add('active');

            // Update Sections
            document.querySelectorAll('.doc-section').forEach(section => section.classList.remove('active'));
            document.getElementById(id).classList.add('active');

            // Scroll to top of content
            window.scrollTo(0, 0);
        }

        function toggleCode(id) {
            document.getElementById(id).classList.toggle('active');
        }
    </script>
</body>
</html>
