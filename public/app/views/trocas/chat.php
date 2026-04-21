<main class="w-full" style="background: var(--color-bg-base); min-height: 80vh; padding: 3rem 0;">
    <div class="container" style="max-width: 900px;">
        
        <div class="glass-panel" style="background: white; padding: 0; display: flex; flex-direction: column; height: 75vh; overflow: hidden; border-top: 4px solid var(--color-primary);">
            
            <!-- HEADER -->
            <div style="padding: 1.5rem; border-bottom: 1px solid var(--color-border); background: var(--color-primary-light); color: var(--color-primary); font-weight: 700; font-family: 'Outfit'; font-size: 1.25rem; display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <span style="font-size: 1.5rem;">💬</span> Chat da troca
                </div>
                <!-- AÇÕES HEADER -->
                <div style="display: flex; gap: 0.75rem;">
                    <?php 
                        $status_clean = strtolower(trim($troca['status']));
                        $eh_destino = ($troca['usuario_destino_id'] == $_SESSION['usuario_id']);
                    ?>

                    <!-- Se estiver Pendente, o DESTINO pode Confirmar/Aceitar -->
                    <?php if($status_clean == "pendente" && $eh_destino): ?>
                        <a href="?url=troca/aceitar/<?= $troca_id ?>" class="btn btn--accent" style="padding: 0.5rem 1rem; font-size: 0.85rem; border-radius: var(--radius-pill);">✔ Confirmar Proposta</a>
                    <?php endif; ?>

                    <!-- Se estiver Aceito/Em Andamento, ambos podem Confirmar Finalização -->
                    <?php if($status_clean == "aceito" || $status_clean == "em_andamento"): ?>
                        <a href="?url=troca/confirmar/<?= $troca_id ?>" class="btn btn--accent" style="padding: 0.5rem 1rem; font-size: 0.85rem; border-radius: var(--radius-pill);">✔ Confirmar Entrega</a>
                    <?php endif; ?>
                    
                    <?php if($status_clean == "finalizada"): ?>
                        <a href="?url=troca/avaliar/<?= $troca['id'] ?>" class="btn btn--primary" style="padding: 0.5rem 1rem; font-size: 0.85rem; border-radius: var(--radius-pill);">⭐ Avaliar</a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- MENSAGENS -->
            <div id="chat-box" style="flex: 1; padding: 2rem; overflow-y: auto; background: var(--color-bg-base); display: flex; flex-direction: column; gap: 1rem;">
                <!-- JS WILL RENDER HERE -->
            </div>

            <!-- INPUT -->
            <form id="form-chat" style="padding: 1.5rem; border-top: 1px solid var(--color-border); background: white; display: flex; gap: 1rem; align-items: center;">
                <?= Seguranca::csrfCampo() ?>
                <input type="hidden" name="troca_id" value="<?= $troca_id ?>">
                <input type="text" name="mensagem" id="mensagem" required class="input-glass" placeholder="Escreva uma mensagem..." style="flex: 1; border: 1px solid var(--color-border); background: var(--color-bg-base); border-radius: var(--radius-pill); padding: 0.75rem 1.5rem;">
                <button type="submit" class="btn btn--primary" style="padding: 0.75rem 2rem; border-radius: var(--radius-pill);">Enviar</button>
            </form>

        </div>

    </div>
</main>

<script>
function renderMensagens(data){
    let chat = document.getElementById("chat-box");
    chat.innerHTML = "";

    data.forEach(msg => {
        let me = msg.remetente_id == <?= $_SESSION['usuario_id'] ?>;
        let foto = msg.foto ? msg.foto : 'default.png';
        let align = me ? 'flex-end' : 'flex-start';
        let bgColor = me ? 'var(--color-primary-light)' : 'white';
        let textColor = me ? 'var(--color-primary)' : 'var(--color-text-body)';
        let border = me ? 'none' : '1px solid var(--color-border)';

        let div = `
        <div style="display:flex;align-items:flex-end;justify-content:${align};">
            ${!me ? `<img src="<?= BASE_URL ?>/uploads/perfis/${foto}" style="width:40px;height:40px;border-radius:50%;object-fit:cover;margin-right:10px;border:2px solid white;box-shadow:var(--shadow-sm);">` : ""}

            <div style="max-width:70%;padding:1rem;border-radius:16px;background:${bgColor};color:${textColor};border:${border};box-shadow:var(--shadow-sm);">
                <div style="font-size:0.75rem;font-weight:700;margin-bottom:0.25rem;text-transform:uppercase;letter-spacing:0.5px;">
                    ${me ? 'Você' : msg.nome}
                </div>
                <div style="font-size:0.95rem;line-height:1.4;">${msg.mensagem}</div>
            </div>

            ${me ? `<img src="<?= BASE_URL ?>/uploads/perfis/${foto}" style="width:40px;height:40px;border-radius:50%;object-fit:cover;margin-left:10px;border:2px solid white;box-shadow:var(--shadow-sm);">` : ""}
        </div>
        `;

        chat.innerHTML += div;
    });

    chat.scrollTop = chat.scrollHeight;
}

function carregarMensagens() {
    fetch("?url=troca/buscarMensagens&troca_id=<?= $troca_id ?>")
    .then(res => res.json())
    .then(data => renderMensagens(data));
}

setInterval(carregarMensagens, 2000);

document.getElementById("form-chat").addEventListener("submit", function(e){
    e.preventDefault();
    let formData = new FormData(this);
    fetch("?url=troca/enviarMensagem", {
        method: "POST",
        body: formData
    })
    .then(() => {
        document.getElementById("mensagem").value = "";
        carregarMensagens();
    });
});

carregarMensagens();
</script>