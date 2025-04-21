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
                    <a href="/campeonato_esportivo/routes/campeonato_editar.php?id=<?= $camp['id'] ?>" class="btn btn-sm btn-primary">Editar</a>

                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <div class="alert alert-warning">Você ainda não criou nenhum campeonato.</div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../cabecalho/footer.php'; ?>
