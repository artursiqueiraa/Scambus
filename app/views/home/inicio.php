<?php
/*
|------------------------------------------------------------------
| INICIO.PHP - LANDING PAGE SCAMBUS (VANILLA CSS REDESIGN)
|------------------------------------------------------------------
*/
?>

<main class="w-full">

    <!-- HERO SECTION -->
    <section class="hero">
        <div class="container hero__content">
            
            <div class="hero__text-col">
                <h1 class="hero__title">
                    Troque <span class="hero__highlight">habilidades</span>,<br>
                    não dinheiro.
                </h1>
                
                <p class="hero__subtitle">
                    Uma plataforma colaborativa e premium onde pessoas apoiam a comunidade trocando serviços em vez de gastar recursos.
                </p>

                <form method="GET" action="?url=servico/buscar" class="search-box" style="margin: 0; width: 100%;">
                    <input type="hidden" name="url" value="servico/buscar">
                    <input 
                        type="text" 
                        name="q" 
                        placeholder="Pesquise o que você precisa..." 
                    />
                    <button type="submit" class="btn btn--accent">Buscar</button>
                </form>

                <div class="flex items-center gap-sm mt-md" style="flex-wrap: wrap;">
                    <?php
                    $categorias = [
                        1 => "💻 Tecnologia",
                        2 => "🎓 Educação",
                        3 => "🏠 Casa",
                        4 => "🔧 Serviços"
                    ];
                    foreach($categorias as $id => $nome):
                    ?>
                        <a href="?url=servico/categoria/<?= $id ?>" class="glass-panel" style="padding: 0.4rem 0.8rem; font-size: 0.85rem; font-weight: 500;">
                            <?= $nome ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="hero__visual-col hidden-on-mobile">
                <div class="floating-card floating-card--1">
                    <div style="font-size: 2rem;">👨‍💻</div>
                    <div>
                        <div style="font-weight: 700; color: var(--color-text-title);">Design UI/UX</div>
                        <div style="font-size: 0.8rem; color: var(--color-text-muted);">Oferecido por Matheus</div>
                    </div>
                </div>
                
                <div class="floating-card floating-card--2">
                    <div style="font-size: 2rem;">🎸</div>
                    <div>
                        <div style="font-weight: 700; color: var(--color-text-title);">Aulas de Violão</div>
                        <div style="font-size: 0.8rem; color: var(--color-text-muted);">Oferecido por Lucas</div>
                    </div>
                </div>

                <div class="floating-card floating-card--3">
                    <div style="font-size: 2rem;">🔧</div>
                    <div>
                        <div style="font-weight: 700; color: var(--color-text-title);">Consertos Gerais</div>
                        <div style="font-size: 0.8rem; color: var(--color-text-muted);">Oferecido por João</div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- ESTATÍSTICAS -->
    <section class="stats">
        <div class="container grid grid-cols-3">
            <div class="stats__item">
                <div class="stats__number" id="trocas">0</div>
                <div class="stats__label">Trocas realizadas</div>
            </div>
            
            <div class="stats__item">
                <div class="stats__number" id="usuarios">0</div>
                <div class="stats__label">Usuários ativos</div>
            </div>
            
            <div class="stats__item">
                <div class="stats__number" id="avaliacoes">0</div>
                <div class="stats__label">Avaliações positivas</div>
            </div>
        </div>
    </section>

    <!-- COMO FUNCIONA -->
    <section class="features">
        <div class="container">
            <h2 class="section-title">Como funciona a plataforma</h2>
            
            <div class="grid grid-cols-3 gap-xl">
                <?php
                $passos = [
                    ["👤", "Cadastre-se", "Crie sua conta gratuitamente em segundos e junte-se a uma rede incrível."],
                    ["🛠", "Ofereça habilidades", "Publique o que você ama fazer e esteja disponível para a comunidade."],
                    ["🤝", "Conecte e Troque", "Encontre serviços, combine os detalhes via chat e realize trocas justas."]
                ];
                
                foreach($passos as $p):
                ?>
                <div class="feature-card glass-panel">
                    <div class="feature-card__icon"><?= $p[0] ?></div>
                    <h3 class="feature-card__title"><?= $p[1] ?></h3>
                    <p style="color: var(--color-text-body);"><?= $p[2] ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- SERVIÇOS RECENTES -->
    <section class="services-section">
        <div class="container">
            <h2 class="section-title">Serviços Disponíveis</h2>
            
            <?php if(!empty($servicos)): ?>
                <div class="grid grid-cols-3 gap-xl">
                    
                    <?php foreach(array_slice($servicos, 0, 6) as $servico): ?>
                        <div class="service-card glass-panel">
                            <?php if(!empty($servico['caminho_foto'])): ?>
                                <img src="<?= BASE_URL ?>/uploads/servicos/<?= htmlspecialchars($servico['caminho_foto']) ?>" class="service-card__image" alt="Imagem do Serviço">
                            <?php else: ?>
                                <div class="service-card__image" style="background: var(--color-border); display: flex; align-items: center; justify-content: center; font-size: 2rem; color: white;">📸</div>
                            <?php endif; ?>
                            
                            <div class="service-card__content">
                                <h3 class="service-card__title"><?= htmlspecialchars($servico['titulo']) ?></h3>
                                
                                <div class="service-card__meta">
                                    <span class="badge badge--primary"><?= htmlspecialchars($servico['categoria'] ?? 'Geral') ?></span>
                                    <span style="color: #FBBF24; font-size: 0.9rem; font-weight: 600;">⭐ <?= $servico['avaliacao_media'] ? round($servico['avaliacao_media'], 1) : "Novo" ?></span>
                                </div>
                                
                                <div class="service-card__desc">
                                    <strong>Oferece:</strong> <?= htmlspecialchars($servico['descricao_oferece']) ?>
                                </div>
                                <div class="service-card__desc">
                                    <strong>Aceita:</strong> <?= htmlspecialchars($servico['descricao_aceita']) ?>
                                </div>
                                
                                <div class="service-card__footer">
                                    <div style="font-size: 0.85rem; color: var(--color-text-muted);">
                                        Por: <strong><?= htmlspecialchars($servico['nome']) ?></strong>
                                    </div>
                                    <a href="?url=servico/ver/<?= $servico['id'] ?>" class="btn btn--primary" style="padding: 0.5rem 1rem; font-size: 0.85rem;">Detalhes</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="text-center mt-lg">
                    <a href="?url=servico/listar" class="btn btn--outline" style="padding: 1rem 2.5rem; font-size: 1.1rem;">Ver todos os serviços</a>
                </div>
            <?php endif; ?>
        </div>
    </section>

</main>

<script>
function animarNumero(id, final) {
    let el = document.getElementById(id);
    if (!el) return;
    
    let atual = 0;
    let incremento = final / 50; 
    
    let timer = setInterval(() => {
        atual += incremento;
        if (atual >= final) {
            atual = final;
            clearInterval(timer);
        }
        el.innerText = Math.floor(atual);
    }, 30);
}

document.addEventListener("DOMContentLoaded", () => {
    animarNumero("trocas", 10000);
    animarNumero("usuarios", 2500);
    animarNumero("avaliacoes", 98);
});
</script>