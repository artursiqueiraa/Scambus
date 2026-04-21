<?php
/*
|--------------------------------------------------------------------------
| View: Avaliar Troca
|--------------------------------------------------------------------------
*/

// Definir quem está sendo avaliado
$avaliado_id = $_SESSION['usuario_id'] == $troca['usuario_origem_id'] 
    ? $troca['usuario_destino_id'] 
    : $troca['usuario_origem_id'];
?>

<style>
.avaliar-container {
    max-width: 600px;
    margin: 40px auto;
    background: #fff;
    padding: 30px;
    border-radius: 14px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}

.avaliar-container h2 {
    margin-bottom: 10px;
    color: #1f2937;
    font-size: 24px;
}

.info-troca {
    background: #f3f4f6;
    padding: 12px;
    border-radius: 8px;
    margin-bottom: 25px;
    border-left: 4px solid #2563eb;
    font-size: 14px;
    color: #666;
}

.form-group {
    margin-bottom: 25px;
}

.form-group label {
    display: block;
    font-weight: 600;
    margin-bottom: 10px;
    color: #374151;
    font-size: 15px;
}

.form-group input,
.form-group textarea,
.form-group select {
    width: 100%;
    padding: 12px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 14px;
    font-family: inherit;
    transition: 0.3s;
    box-sizing: border-box;
}

.form-group input:focus,
.form-group textarea:focus {
    border-color: #2563eb;
    outline: none;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

.form-group textarea {
    resize: none;
    height: 120px;
}

/* ✅ CORRIGIDO: Rating com estrutura correta */
.rating-stars {
    display: flex;
    gap: 8px;
    font-size: 36px;
    margin-top: 10px;
}

.rating-stars label {
    margin: 0;
    padding: 0;
    cursor: pointer;
    font-size: 36px;
    color: #d1d5db;
    transition: 0.2s;
    line-height: 1;
}

.rating-stars label:hover {
    color: #fbbf24;
    transform: scale(1.1);
}

.rating-stars input[type="radio"] {
    display: none;
}

.rating-stars input[type="radio"]:checked + label,
.rating-stars input[type="radio"]:checked + label ~ label {
    color: #fbbf24;
}

.botoes {
    display: flex;
    gap: 10px;
    margin-top: 30px;
}

.btn-submit {
    flex: 1;
    padding: 12px;
    background: #2563eb;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
}

.btn-submit:hover:not(:disabled) {
    background: #1e40af;
}

.btn-submit:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.btn-cancelar {
    flex: 1;
    padding: 12px;
    background: #6b7280;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-cancelar:hover {
    background: #4b5563;
}

.nota-selecionada {
    text-align: center;
    font-size: 14px;
    color: #6b7280;
    margin-top: 10px;
}
</style>

<div class="avaliar-container">

    <h2>⭐ Avaliar Troca #<?= htmlspecialchars($troca['id']) ?></h2>

    <div class="info-troca">
        <p><strong>Você está avaliando:</strong> <?= htmlspecialchars($troca['nome_destino']) ?></p>
        <p><strong>Status da troca:</strong> <span style="color: #10b981; font-weight: 600;">✅ FINALIZADA</span></p>
    </div>

    <!-- ✅ FORM CORRIGIDO -->
    <form method="POST" action="?url=troca/salvarAvaliacao" id="formAvaliacao">

        <input type="hidden" name="troca_id" value="<?= (int)$troca['id'] ?>">
        <input type="hidden" name="avaliado_id" value="<?= (int)$avaliado_id ?>">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">

        <!-- ⭐ NOTA - ESTRUTURA CORRIGIDA -->
        <div class="form-group">
            <label for="nota-label">Sua Avaliação (1 a 5 estrelas) ⭐</label>
            <div class="rating-stars" id="ratingStars">
                <input type="radio" id="nota1" name="nota" value="1" required>
                <label for="nota1" onclick="atualizarNota(1)">⭐</label>

                <input type="radio" id="nota2" name="nota" value="2">
                <label for="nota2" onclick="atualizarNota(2)">⭐</label>

                <input type="radio" id="nota3" name="nota" value="3">
                <label for="nota3" onclick="atualizarNota(3)">⭐</label>

                <input type="radio" id="nota4" name="nota" value="4">
                <label for="nota4" onclick="atualizarNota(4)">⭐</label>

                <input type="radio" id="nota5" name="nota" value="5">
                <label for="nota5" onclick="atualizarNota(5)">⭐</label>
            </div>
            <div class="nota-selecionada" id="notaSelecionada"></div>
        </div>

        <!-- 💬 COMENTÁRIO -->
        <div class="form-group">
            <label for="comentario">Comentário (opcional)</label>
            <textarea 
                id="comentario"
                name="comentario" 
                placeholder="Compartilhe sua experiência com essa troca... (máximo 500 caracteres)"
                maxlength="500"
            ></textarea>
        </div>

        <!-- 🔘 BOTÕES -->
        <div class="botoes">
            <button type="submit" class="btn-submit" id="btnEnviar">
                ✅ Enviar Avaliação
            </button>
            <a href="?url=troca/minhas" class="btn-cancelar">
                ✖️ Cancelar
            </a>
        </div>

    </form>

</div>

<script>
// ✅ Atualizar visual de estrelas
function atualizarNota(valor) {
    document.getElementById('nota' + valor).checked = true;
    document.getElementById('notaSelecionada').textContent = valor + ' estrela(s) selecionada(s)';
    atualizarVisualEstrelas(valor);
}

// ✅ Atualizar visual ao passar mouse
function atualizarVisualEstrelas(valor) {
    for (let i = 1; i <= 5; i++) {
        const label = document.querySelector('label[for="nota' + i + '"]');
        if (i <= valor) {
            label.style.color = '#fbbf24';
        } else {
            label.style.color = '#d1d5db';
        }
    }
}

// ✅ Hover das estrelas
document.querySelectorAll('.rating-stars label').forEach((label, index) => {
    label.addEventListener('mouseover', function() {
        atualizarVisualEstrelas(index + 1);
    });
});

document.getElementById('ratingStars').addEventListener('mouseleave', function() {
    const notaSelecionada = document.querySelector('input[name="nota"]:checked');
    if (notaSelecionada) {
        atualizarVisualEstrelas(notaSelecionada.value);
    } else {
        document.querySelectorAll('.rating-stars label').forEach(l => {
            l.style.color = '#d1d5db';
        });
    }
});

// ✅ Validar form antes de enviar
document.getElementById('formAvaliacao').addEventListener('submit', function(e) {
    const nota = document.querySelector('input[name="nota"]:checked');
    
    if (!nota) {
        e.preventDefault();
        alert('❌ Por favor, selecione uma nota (1 a 5 estrelas)');
        return false;
    }
    
    // Desabilitar botão para evitar envios duplicados
    document.getElementById('btnEnviar').disabled = true;
    document.getElementById('btnEnviar').textContent = '⏳ Enviando...';
    
    return true;
});
</script>