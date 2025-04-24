<?php
// Proteção contra acesso direto
if (!isset($campeonatos)) {
    die('Acesso direto não permitido.');
}
?>

<?php include __DIR__ . '/../cabecalho/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">Meus Campeonatos</h2>

    <?php if (!empty($campeonatos)): ?>
        <ul class="list-group">
        <?php foreach ($campeonatos as $camp): ?>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <div>
            <strong><?= htmlspecialchars($camp['nome']) ?></strong><br>
            Temporada: <?= htmlspecialchars($camp['temporada']) ?> — <?= htmlspecialchars($camp['formato']) ?>
        </div>
        <div class="d-flex gap-2">
        <a href="/campeonato_esportivo/routes/ranking_campeonato.php?campeonato_id=<?= $camp['id'] ?>" class="btn btn-outline-secondary btn-sm">
    🏆 Ranking
</a>

            <a href="/campeonato_esportivo/routes/campeonato_editar.php?id=<?= $camp['id'] ?>" class="btn btn-primary btn-sm">
                Editar
            </a>
        </div>
    </li>
<?php endforeach; ?>

        </ul>
    <?php else: ?>
        <div class="alert alert-warning">Você ainda não criou nenhum campeonato.</div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../cabecalho/footer.php'; ?>
