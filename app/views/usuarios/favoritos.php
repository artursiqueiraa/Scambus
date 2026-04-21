<style>

/* CONTAINER */
.favoritos-container {
    max-width: 1100px;
    margin: 40px auto;
}

/* TÍTULO */
.titulo-favoritos {
    font-size: 26px;
    font-weight: bold;
    margin-bottom: 20px;
}

/* GRID */
.grid-favoritos {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 20px;
}

/* CARD */
.card-favorito {
    background: #fff;
    border-radius: 14px;
    overflow: hidden;
    border: 1px solid #eee;
    transition: 0.3s;
}

.card-favorito:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.08);
}

/* IMAGEM */
.card-favorito img {
    width: 100%;
    height: 160px;
    object-fit: cover;
}

/* SEM IMAGEM */
.sem-imagem {
    width: 100%;
    height: 160px;
    background: #f1f1f1;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #999;
}

/* CONTEÚDO */
.card-content {
    padding: 15px;
}

/* TÍTULO */
.card-content h3 {
    margin: 0 0 8px;
    font-size: 17px;
}

/* DESCRIÇÃO */
.card-content p {
    font-size: 13px;
    color: #666;
    height: 40px;
    overflow: hidden;
}

/* BOTÃO */
.btn-ver {
    display: inline-block;
    margin-top: 10px;
    background: #2563eb;
    color: #fff;
    padding: 8px 14px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 13px;
    transition: 0.3s;
}

.btn-ver:hover {
    background: #1e4ed8;
}

/* EMPTY */
.sem-favoritos {
    text-align: center;
    background: #fff;
    padding: 40px;
    border-radius: 14px;
    border: 1px solid #eee;
}

</style>


<div class="favoritos-container">

    <h2 class="titulo-favoritos">⭐ Meus serviços favoritos</h2>

    <?php if(!empty($favoritos)): ?>

    <div class="grid-favoritos">

        <?php foreach($favoritos as $servico): ?>

        <div class="card-favorito">

            <?php if(!empty($servico['caminho_foto'])): ?>

                <img src="<?= BASE_URL ?>/uploads/servicos/<?= $servico['caminho_foto'] ?>">

            <?php else: ?>

                <div class="sem-imagem">Sem imagem</div>

            <?php endif; ?>

            <div class="card-content">

                <h3><?= $servico['titulo'] ?></h3>

                <p><?= $servico['descricao_oferece'] ?></p>

                <a href="?url=servico/ver/<?= $servico['id'] ?>" class="btn-ver">
                    Ver serviço
                </a>

            </div>

        </div>

        <?php endforeach; ?>

    </div>

    <?php else: ?>

        <div class="sem-favoritos">

            <h3>😢 Nenhum favorito ainda</h3>
            <p>Explore serviços e favorite os que você gostar ⭐</p>

        </div>

    <?php endif; ?>

</div>