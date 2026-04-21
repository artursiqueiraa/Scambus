<?php
/* 
|--------------------------------------------------------------------------
| VISTA DE APRESENTAÇÃO ESTRUTURADA (16 PONTOS)
|--------------------------------------------------------------------------
| Esta página foi reorganizada para atender aos requisitos de Engenharia de Sistemas.
| Não modifica a lógica do banco de dados ou controladores.
*/
?>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
/* CSS do Projeto (Neo-Telematic Glassmorphism) */
.project-presentation {
    font-family: 'Inter', sans-serif;
    color: #e2e8f0;
    line-height: 1.6;
    background-color: #0f1115;
    background-image: 
        radial-gradient(at 0% 0%, hsla(253,16%,7%,1) 0, transparent 50%), 
        radial-gradient(at 50% 0%, hsla(225,39%,30%,0.1) 0, transparent 50%), 
        radial-gradient(at 100% 0%, hsla(339,49%,30%,0.05) 0, transparent 50%);
    background-attachment: fixed;
    margin: 0; padding: 0;
    overflow-x: hidden;
}

.hero-header {
    min-height: 45vh;
    display: flex; flex-direction: column; justify-content: center; align-items: center;
    text-align: center; padding: 4rem 2rem; position: relative;
    border-bottom: 1px solid rgba(255,255,255,0.05);
}

.hero-subtitle {
    font-family: 'Outfit', sans-serif; color: #00ffaa; font-weight: 600;
    letter-spacing: 4px; text-transform: uppercase; margin-bottom: 1rem;
    padding: 5px 15px; background: rgba(0, 255, 170, 0.1);
    border-radius: 50px; border: 1px solid rgba(0, 255, 170, 0.2);
}

.hero-title {
    font-family: 'Outfit', sans-serif; font-size: 4rem; font-weight: 800;
    color: #ffffff; line-height: 1.1; margin-bottom: 1.5rem;
    background: linear-gradient(to right, #fff, #a0aec0);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent;
}

.presentation-layout {
    display: flex; max-width: 1400px; margin: 0 auto;
    position: relative; padding: 2rem; gap: 3rem;
}

.nav-sidebar {
    width: 300px; flex-shrink: 0; position: sticky; top: 2rem;
    height: calc(100vh - 4rem); overflow-y: auto; padding-right: 1rem;
}

.nav-link {
    display: block; padding: 0.8rem 1rem; color: #a0aec0;
    text-decoration: none; font-family: 'Outfit', sans-serif;
    font-weight: 500; font-size: 1.05rem; border-radius: 8px;
    transition: all 0.3s ease; margin-bottom: 0.5rem;
    border-left: 3px solid transparent;
}

.nav-link:hover { background: rgba(255,255,255,0.05); color: #fff; border-left-color: #00ffaa; transform: translateX(5px); }
.nav-link i { width: 25px; color: rgba(0, 255, 170, 0.7); }

.content-area { flex-grow: 1; max-width: 900px; }

.glass-section {
    background: rgba(25, 28, 35, 0.6); backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 16px;
    padding: 3rem; margin-bottom: 3rem; box-shadow: 0 15px 35px rgba(0,0,0,0.2);
    transition: all 0.4s ease;
}

.glass-section:hover { border-color: rgba(0, 255, 170, 0.3); transform: translateY(-5px); }

.section-header { display: flex; align-items: center; margin-bottom: 2rem; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 1rem; }
.section-number { font-family: 'Outfit', sans-serif; font-size: 3rem; font-weight: 800; color: transparent; -webkit-text-stroke: 1px rgba(0, 255, 170, 0.4); margin-right: 1.5rem; }
.glass-section h2 { font-family: 'Outfit', sans-serif; font-size: 2rem; color: #fff; margin: 0; }
.glass-section h3 { font-size: 1.3rem; color: #00ffaa; margin-top: 2rem; margin-bottom: 1rem; display: flex; align-items: center; gap: 10px; }
.glass-section p { color: #cbd5e1; font-size: 1.1rem; margin-bottom: 1.5rem; }

.badges-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 1rem; }
.req-card { background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.05); padding: 1.5rem; border-radius: 8px; }
.req-badge { display: inline-block; background: #00ffaa; color: #000; font-weight: 800; padding: 4px 10px; border-radius: 4px; font-size: 0.85rem; margin-bottom: 10px; }

.modern-list { list-style: none; padding: 0; }
.modern-list li { position: relative; padding-left: 30px; margin-bottom: 1rem; color: #cbd5e1; }
.modern-list li::before { content: '\f054'; font-family: 'Font Awesome 6 Free'; font-weight: 900; position: absolute; left: 0; color: #00ffaa; font-size: 0.9rem; top: 4px; }

.img-placeholder {
    background: rgba(255,255,255,0.03); border: 2px dashed rgba(255,255,255,0.1);
    border-radius: 12px; padding: 5rem; text-align: center; color: #64748b; margin: 1.5rem 0;
}

.highlight-box { background: rgba(0, 255, 170, 0.05); border-left: 4px solid #00ffaa; padding: 1.5rem; border-radius: 0 8px 8px 0; margin-bottom: 1.5rem; }
</style>

<div class="project-presentation">
    <header class="hero-header">
        <div class="hero-subtitle"><i class="fas fa-microchip"></i> Engenharia de Sistemas</div>
        <h1 class="hero-title">Documentação Acadêmica<br>Projeto SCAMBUS</h1>
        <p style="color: #94a3b8; font-size: 1.2rem; max-width: 800px;">Uma análise técnica profunda sobre a maior plataforma de economia colaborativa para talentos liberais.</p>
    </header>

    <div class="presentation-layout">
        <aside class="nav-sidebar">
            <a href="#ideia" class="nav-link"><i class="fas fa-brain"></i> 1. Ideia do Sistema</a>
            <a href="#usuarios" class="nav-link"><i class="fas fa-users-viewfinder"></i> 2. Usuários</a>
            <a href="#funcionalidades" class="nav-link"><i class="fas fa-gears"></i> 3. Funcionalidades (RF)</a>
            <a href="#requisitos-nf" class="nav-link"><i class="fas fa-shield-halved"></i> 4. Req. Não Funcionais</a>
            <a href="#lgpd" class="nav-link"><i class="fas fa-lock"></i> 5. LGPD (Proteção)</a>
            <a href="#mercado" class="nav-link"><i class="fas fa-chart-line"></i> 6. Estudo de Mercado</a>
            <a href="#arquitetura" class="nav-link"><i class="fas fa-sitemap"></i> 7. Arquitetura</a>
            <a href="#planejamento" class="nav-link"><i class="fas fa-calendar-check"></i> 8. Planejamento</a>
            <a href="#trello" class="nav-link"><i class="fab fa-trello"></i> 9. Trello (Organização)</a>
            <a href="#qualidade" class="nav-link"><i class="fas fa-vial"></i> 10. Testes e Qualidade</a>
            <a href="#manutencao" class="nav-link"><i class="fas fa-wrench"></i> 11. Manutenção</a>
            <a href="#prototipagem" class="nav-link"><i class="fas fa-object-group"></i> 12. Prototipagem</a>
            <a href="#implantacao" class="nav-link"><i class="fas fa-rocket"></i> 13. Implantação</a>
            <a href="#riscos" class="nav-link"><i class="fas fa-triangle-exclamation"></i> 14. Gestão de Riscos</a>
            <a href="#diagramas" class="nav-link"><i class="fas fa-diagram-project"></i> 16. Diagramas UML</a>
        </aside>

        <main class="content-area">
            <!-- 1. IDEIA -->
            <section id="ideia" class="glass-section">
                <div class="section-header"><span class="section-number">01</span><h2>Ideia do Sistema</h2></div>
                <div class="highlight-box"><p><strong>Nome:</strong> Scambus (Economy Exchange System)</p></div>
                <p>O <strong>Scambus</strong> é uma solução tecnológica para o problema da falta de liquidez financeira entre freelancers e estudantes. Ele permite a troca direta de serviços sem o uso de dinheiro real, utilizando uma moeda virtual proprietária chamada <strong>SCoins</strong>.</p>
                <h3><i class="fas fa-bullseye"></i> Escopo Principal</h3>
                <p>Criar um ambiente seguro (Escrow) onde talentos individuais (código, design, consultoria) sejam valorizados e trocados de forma justa e rastreável.</p>
            </section>

            <!-- 2. USUÁRIOS -->
            <section id="usuarios" class="glass-section">
                <div class="section-header"><span class="section-number">02</span><h2>Usuários do Sistema</h2></div>
                <p><strong>Quem vai usar:</strong> Estudantes universitários em busca de portfólio e profissionais liberais com tempo ocioso que precisam de serviços complementares.</p>
                <p><strong>Como será utilizado:</strong> Através de um portal web responsivo, o usuário gerencia seus anúncios, interage em um chat em tempo real e controla sua carteira de SCoins.</p>
            </section>

            <!-- 3. FUNCIONALIDADES -->
            <section id="funcionalidades" class="glass-section">
                <div class="section-header"><span class="section-number">03</span><h2>Funcionalidades (Requisitos Funcionais)</h2></div>
                <div class="badges-grid">
                    <div class="req-card"><div class="req-badge">RF01</div><p class="req-text">Cadastro e Perfil Profissional detalhado.</p></div>
                    <div class="req-card"><div class="req-badge">RF02</div><p class="req-text">Publicação de Anúncios com valor em SCoins.</p></div>
                    <div class="req-card"><div class="req-badge">RF03</div><p class="req-text">Sistema de Carteira com Saldo Bloqueado (Escrow).</p></div>
                    <div class="req-card"><div class="req-badge">RF04</div><p class="req-text">Chat Interno para negociação direta.</p></div>
                    <div class="req-card"><div class="req-badge">RF05</div><p class="req-text">Comunidade/Feed para engajamento e visibilidade.</p></div>
                    <div class="req-card"><div class="req-badge">RF06</div><p class="req-text">Sistema de Avaliação e Ranking de confiança.</p></div>
                </div>
            </section>

            <!-- 4. REQUISITOS NÃO FUNCIONAIS -->
            <section id="requisitos-nf" class="glass-section">
                <div class="section-header"><span class="section-number">04</span><h2>Requisitos Não Funcionais</h2></div>
                <ul class="modern-list">
                    <li><strong>Segurança:</strong> Senhas protegidas por HASH BCRYPT e proteção sistemática contra CSRF e SQL Injection (PDO).</li>
                    <li><strong>Transacionabilidade:</strong> Garantia de integridade ACID no banco de dados para evitar perda de SCoins.</li>
                    <li><strong>Usabilidade:</strong> Interface intuitiva com tempo de carregamento otimizado.</li>
                    <li><strong>Aesthetics:</strong> Design "Neo-Telematic" premium focado em alta tecnologia.</li>
                </ul>
            </section>

            <!-- 5. LGPD -->
            <section id="lgpd" class="glass-section">
                <div class="section-header"><span class="section-number">05</span><h2>LGPD (Proteção de Dados)</h2></div>
                <p><strong>Coleta Mínima:</strong> Apenas dados essenciais (Nome, Email) são coletados para a prestação do serviço.</p>
                <p><strong>Segurança:</strong> Dados de transações são cifrados. O usuário possui total direito de exclusão e anonimização de sua conta conforme a lei brasileira.</p>
            </section>

            <!-- 6. MERCADO -->
            <section id="mercado" class="glass-section">
                <div class="section-header"><span class="section-number">06</span><h2>Estudo de Mercado</h2></div>
                <p><strong>Diferencial:</strong> Diferente de plataformas como Workana (que cobram 20% de taxa financeira), o Scambus permite a troca de valor intelectual puro, preenchendo a lacuna deixada pela falta de capital de giro em novos talentos.</p>
                <p><strong>Público:</strong> Hubs de inovação, Repúblicas estudantis e Coworkings.</p>
            </section>

            <!-- 7. ARQUITETURA -->
            <section id="arquitetura" class="glass-section">
                <div class="section-header"><span class="section-number">07</span><h2>Arquitetura do Sistema</h2></div>
                <p>O sistema segue o padrão <strong>MVC (Model-View-Controller)</strong> puro em PHP.</p>
                <div class="highlight-box">
                    <p><strong>Backend:</strong> PHP OO com Roteador dinâmico.</p>
                    <p><strong>Data:</strong> MySQL/MariaDB com relacionamentos íntegros.</p>
                    <p><strong>Design:</strong> Vanilla CSS com técnicas modernas de Glassmorphism.</p>
                </div>
            </section>

            <!-- 8. PLANEJAMENTO -->
            <section id="planejamento" class="glass-section">
                <div class="section-header"><span class="section-number">08</span><h2>Planejamento do Projeto</h2></div>
                <p><strong>Metodologia:</strong> SCRUM. Sprints curtas focadas em entregas funcionais e melhoria contínua baseada no feedback dos usuários.</p>
            </section>

            <!-- 9. TRELLO -->
            <section id="trello" class="glass-section">
                <div class="section-header"><span class="section-number">09</span><h2>Trello (Organização)</h2></div>
                <p>Quadro Kanban contendo as colunas: Backlog (Ideias), To Do (Planejado), Doing (Em código), Review (Testes) e Done (Produção).</p>
            </section>

            <!-- 10. QUALIDADE -->
            <section id="qualidade" class="glass-section">
                <div class="section-header"><span class="section-number">10</span><h2>Testes e Qualidade</h2></div>
                <p>Baterias de testes de unidade focadas na <strong>Carteira de SCoins</strong> para prevenir duplicidade de saldo, e testes funcionais simulando a jornada completa de uma troca entre dois perfis.</p>
            </section>

            <!-- 11. MANUTENÇÃO -->
            <section id="manutencao" class="glass-section">
                <div class="section-header"><span class="section-number">11</span><h2>Manutenção do Sistema</h2></div>
                <div class="badges-grid">
                    <div class="req-card"><strong>Corretiva:</strong> Correção de falhas de segurança.</div>
                    <div class="req-card"><strong>Preventiva:</strong> Backups e updates de DB.</div>
                    <div class="req-card"><strong>Evolutiva:</strong> Novos recursos para a Comunidade de trocas.</div>
                </div>
            </section>

            <!-- 12. PROTOTIPAGEM -->
            <section id="prototipagem" class="glass-section">
                <div class="section-header"><span class="section-number">12</span><h2>Prototipagem</h2></div>
                <p>O protótipo de alta fidelidade reflete uma interface futurista, focada em produtividade e agilidade de navegação, com transições suaves e feedback visual constante para o usuário.</p>
            </section>

            <!-- 13. IMPLANTAÇÃO -->
            <section id="implantacao" class="glass-section">
                <div class="section-header"><span class="section-number">13</span><h2>Implantação e Treinamento</h2></div>
                <p>Implantação via Cloud Hosting automatizado. O usuário aprende a usar o sistema através de guias contextuais no próprio Dashboard (Onboarding).</p>
            </section>

            <!-- 14. GESTÃO DE RISCOS -->
            <section id="riscos" class="glass-section">
                <div class="section-header"><span class="section-number">14</span><h2>Gestão de Riscos</h2></div>
                <ul class="modern-list">
                    <li><strong>Risco 1:</strong> Baixa liquidez de SCoins na rede. (Ação: Bônus de boas-vindas).</li>
                    <li><strong>Risco 2:</strong> Fraudes em trocas. (Ação: Sistema de Escrow obrigatório).</li>
                </ul>
            </section>

            <!-- 16. DIAGRAMAS -->
            <section id="diagramas" class="glass-section">
                <div class="section-header"><span class="section-number">16</span><h2>Diagramas UML</h2></div>
                <h3>Caso de Uso</h3>
                <div class="img-placeholder">
                    <i class="fas fa-image fa-3x"></i><br><br>
                    <strong>Diagrama de Caso de Uso</strong><br>
                    (Insira sua imagem aqui)
                </div>
                <h3>Classes</h3>
                <div class="img-placeholder">
                    <i class="fas fa-sitemap fa-3x"></i><br><br>
                    <strong>Diagrama de Classes</strong><br>
                    (Insira sua imagem aqui)
                </div>
            </section>

            <section class="glass-section" style="border-color: #00ffaa; background: rgba(0, 255, 170, 0.03);">
                <p style="text-align:center; font-weight: 800; font-size: 1.2rem; margin:0; color:#fff;">FIM DA APRESENTAÇÃO - SCAMBUS 🚀</p>
            </section>
        </main>
    </div>
</div>

<script>
window.addEventListener('scroll', () => {
    const sections = document.querySelectorAll('.glass-section');
    const navLinks = document.querySelectorAll('.nav-link');
    let current = '';

    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        if (pageYOffset >= sectionTop - 150) {
            current = section.getAttribute('id');
        }
    });

    navLinks.forEach(link => {
        link.style.color = '#a0aec0';
        link.style.borderLeftColor = 'transparent';
        if (link.getAttribute('href').includes(current)) {
            link.style.color = '#fff';
            link.style.borderLeftColor = '#00ffaa';
        }
    });
});
</script>
