<main class="w-full" style="background: var(--color-bg-base); min-height: 80vh; padding: 4rem 0; display: flex; align-items: center; justify-content: center;">
    <div class="glass-panel" style="background: white; width: 100%; max-width: 450px; padding: 3rem;">
        
        <div style="text-align: center; margin-bottom: 2rem;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">⭐</div>
            <h2 class="hero__title" style="font-size: 2rem; margin: 0; line-height: 1.2;">Avaliar usuário</h2>
            <p style="color: var(--color-text-muted); margin-top: 0.5rem; font-size: 0.95rem;">Compartilhe como foi a sua experiência com esta troca.</p>
        </div>

        <form method="POST" action="?url=troca/salvarAvaliacao" style="display: flex; flex-direction: column; gap: 1.5rem;">
            <?= Seguranca::csrfCampo() ?>
            <input type="hidden" name="troca_id" value="<?= $troca['id'] ?>">

            <?php
            $avaliado = ($_SESSION['usuario_id'] == $troca['usuario_origem_id'])
                ? $troca['usuario_destino_id']
                : $troca['usuario_origem_id'];
            ?>
            <input type="hidden" name="avaliado_id" value="<?= $avaliado ?>">

            <!-- ESTRELAS -->
            <div style="text-align: center;">
                <label style="font-weight: 700; color: var(--color-text-title); font-size: 1.1rem; display: block; margin-bottom: 0.5rem;">Qual a sua nota?</label>
                <div id="stars" style="font-size: 2.5rem; cursor: pointer; color: var(--color-accent); letter-spacing: 5px; transition: 0.2s;">
                    ⭐⭐⭐⭐⭐
                </div>
                <input type="hidden" name="nota" id="nota" value="5">
            </div>

            <!-- COMENTÁRIO -->
            <div>
                <label style="font-weight: 600; font-size: 0.9rem; color: var(--color-text-title); margin-bottom: 0.5rem; display: block;">Comentário</label>
                <textarea name="comentario" rows="4" placeholder="Detalhes do que aconteceu..." class="input-glass" style="border: 1px solid var(--color-border); background: var(--color-bg-base); width: 100%; border-radius: var(--radius-md); padding: 1rem; resize: none;"></textarea>
            </div>

            <button type="submit" class="btn btn--primary" style="padding: 1rem; font-size: 1.1rem; margin-top: 0.5rem;">
                Enviar avaliação
            </button>

        </form>

    </div>
</main>

<script>
let stars = document.getElementById("stars");
let notaInput = document.getElementById("nota");
let totalStars = 5;

stars.innerHTML = "★★★★★";

stars.addEventListener("mousemove", function(e){
    let width = stars.offsetWidth;
    let x = e.offsetX;
    let nota = Math.ceil((x / width) * totalStars);
    pintarEstrelas(nota);
});

stars.addEventListener("click", function(e){
    let width = stars.offsetWidth;
    let x = e.offsetX;
    let nota = Math.ceil((x / width) * totalStars);
    notaInput.value = nota;
});

stars.addEventListener("mouseleave", function(e) {
    let notaFixa = parseInt(notaInput.value);
    pintarEstrelas(notaFixa);
});

function pintarEstrelas(nota){
    let estrelas = "";
    for(let i=1; i<=totalStars; i++){
        estrelas += i <= nota ? "⭐" : "☆";
    }
    stars.innerHTML = estrelas;
}
</script>