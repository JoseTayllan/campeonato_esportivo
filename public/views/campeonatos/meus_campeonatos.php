<?php
// Proteger contra acesso direto
if (!isset($_SERVER['HTTP_REFERER']) || empty($_SERVER['HTTP_REFERER'])) {
    echo "<div style='text-align:center; padding:20px; font-family:sans-serif;'>
            <h2 style='color:red;'>Erro: Acesso direto não permitido!</h2>
            <p>Utilize o sistema normalmente para acessar esta página.</p>
          </div>";
    exit();
} 
?>

<?php include __DIR__ . '/../cabecalho/header.php'; ?>
<body class="d-flex flex-column min-vh-100">
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
</body>
<!-- Footer com margem automática no topo para colar no final -->
<div class="mt-auto">
<?php include __DIR__ . '/../cabecalho/footer.php'; ?>
</div>
