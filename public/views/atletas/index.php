<?php include __DIR__ . '../../../includes/index_sec.php'; ?>

<div class="container mt-4 container-campeonato">
    <div class="container">
        <h1 class="mb-4">Lista de Atletas</h1>

        <form method="get" class="row g-2 mb-4 bg-white p-3 rounded shadow-sm">
            <div class="col-md-3">
                <input type="text" name="nome" class="form-control" placeholder="Nome" value="<?= htmlspecialchars($_GET['nome'] ?? '') ?>">
            </div>
            <div class="col-md-2">
                <select name="posicao" class="form-select">
                    <option value="">Posição</option>
                    <option value="Goleiro">Goleiro</option>
                    <option value="Zagueiro">Zagueiro</option>
                    <option value="Lateral">Lateral</option>
                    <option value="Meia">Meia</option>
                    <option value="Atacante">Atacante</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="text" name="nacionalidade" class="form-control" placeholder="Nacionalidade" value="<?= htmlspecialchars($_GET['nacionalidade'] ?? '') ?>">
            </div>
            <div class="col-md-2">
                <input type="number" name="idade" class="form-control" placeholder="Idade" value="<?= htmlspecialchars($_GET['idade'] ?? '') ?>">
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary w-100">Buscar</button>
            </div>
        </form>

        <div class="row">
            <?php foreach ($jogadores as $jogador): ?>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($jogador['nome'] ?? '') ?></h5>
                            <p class="card-text mb-1"><strong>Posição:</strong> <?= htmlspecialchars($jogador['posicao'] ?? '') ?></p>
                            <p class="card-text mb-1"><strong>Nacionalidade:</strong> <?= htmlspecialchars($jogador['nacionalidade'] ?? '') ?></p>
                            <p class="card-text mb-2"><strong>Idade:</strong> <?= htmlspecialchars((string)($jogador['idade'] ?? '')) ?></p>
                            <a href="/campeonato_esportivo/routes/atletas/show.php?id=<?= urlencode($jogador['id'] ?? '') ?>" class="btn btn-sm btn-outline-primary">Ver detalhes</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="mt-auto">
    <div class="mt-5"></div>
    <?php require_once __DIR__ . '/../cabecalho/footer.php'; ?>
    <script src="/campeonato_esportivo/assets/js/bootstrap.bundle.min.js"></script>
</div>
