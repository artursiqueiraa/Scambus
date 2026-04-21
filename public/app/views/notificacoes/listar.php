<main class="w-full" style="background: var(--color-bg-base); min-height: 80vh; padding: 4rem 0;">
    <div class="container" style="max-width: 800px;">
        <h2 class="hero__title" style="font-size: 2.5rem; margin-bottom: 2rem; text-align: left;">🔔 Minhas Notificações</h2>

        <div id="lista-notificacoes" style="display: flex; flex-direction: column; gap: 1rem;">
            <?php if(!empty($notificacoes)): ?>
                <?php foreach($notificacoes as $n): ?>
                    <?php if($n['lida'] == 0): // Apenas as não lidas somem ao clicar ?>
                        <div class="glass-panel notif-item" data-id="<?= $n['id'] ?>" style="background: white; padding: 1.5rem; display: flex; justify-content: space-between; align-items: center; gap: 1.5rem; border-left: 4px solid var(--color-primary);">
                            <div style="display: flex; align-items: center; gap: 1.25rem;">
                                <div style="width: 44px; height: 44px; background: var(--color-primary-light); color: var(--color-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0;">🔄</div>
                                <div style="color: var(--color-text-title); font-size: 1.05rem; font-weight: 600;">
                                    <?= htmlspecialchars($n['mensagem']) ?>
                                    <div style="font-size: 0.75rem; color: var(--color-text-muted); margin-top: 4px; font-weight: 400;">
                                        <?= date('d/m H:i', strtotime($n['data_criacao'])) ?>
                                    </div>
                                </div>
                            </div>
                            <a href="?url=notificacao/abrir/<?= $n['id'] ?>" class="btn btn--primary" style="white-space: nowrap;">Abrir</a>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div id="no-notif" style="display: <?= empty($notificacoes) ? 'block' : 'none' ?>;">
            <div class="glass-panel" style="background: white; padding: 4rem; text-align: center;">
                <h3 style="font-size: 1.5rem; color: var(--color-text-title); margin-bottom: 1rem;">😴 Nenhuma notificação ativa</h3>
                <p style="color: var(--color-text-body);">Quando alguém interagir com você, um recado aparecerá aqui em tempo real.</p>
            </div>
        </div>
    </div>
</main>

<script>
    // Armazena IDs já renderizados para não duplicar
    let idsProcessados = Array.from(document.querySelectorAll('.notif-item')).map(el => el.dataset.id);

    async function buscarNotificacoes() {
        try {
            const response = await fetch('?url=notificacao/api_listar');
            const data = await response.json();
            
            const container = document.getElementById('lista-notificacoes');
            const noNotif = document.getElementById('no-notif');
            
            let novas = 0;
            
            // Filtra apenas as não lidas da resposta
            const naoLidas = data.filter(n => n.lida == 0);

            if (naoLidas.length === 0 && idsProcessados.length === 0) {
                noNotif.style.display = 'block';
                return;
            }

            naoLidas.forEach(n => {
                if (!idsProcessados.includes(n.id.toString())) {
                    novas++;
                    idsProcessados.push(n.id.toString());
                    
                    const html = `
                        <div class="glass-panel notif-item" data-id="${n.id}" style="background: white; padding: 1.5rem; display: flex; justify-content: space-between; align-items: center; gap: 1.5rem; border-left: 4px solid var(--color-primary); animation: slideIn 0.3s ease-out;">
                            <div style="display: flex; align-items: center; gap: 1.25rem;">
                                <div style="width: 44px; height: 44px; background: var(--color-primary-light); color: var(--color-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0;">🔄</div>
                                <div style="color: var(--color-text-title); font-size: 1.05rem; font-weight: 600;">
                                    ${n.mensagem}
                                    <div style="font-size: 0.75rem; color: var(--color-text-muted); margin-top: 4px; font-weight: 400;">
                                        Agora mesmo
                                    </div>
                                </div>
                            </div>
                            <a href="?url=notificacao/abrir/${n.id}" class="btn btn--primary" style="white-space: nowrap;">Abrir</a>
                        </div>
                    `;
                    container.insertAdjacentHTML('afterbegin', html);
                }
            });

            if (naoLidas.length > 0) {
                noNotif.style.display = 'none';
            } else if (container.children.length === 0) {
                noNotif.style.display = 'block';
            }

        } catch (error) {
            console.error("Erro ao buscar notificações:", error);
        }
    }

    // Estilo para animação de entrada
    const style = document.createElement('style');
    style.innerHTML = `
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
    `;
    document.head.appendChild(style);

    // Inicia o polling a cada 5 segundos
    setInterval(buscarNotificacoes, 5000);
</script>