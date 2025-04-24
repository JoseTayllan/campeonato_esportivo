<?php 

include 'views/cabecalho/header_index.php'; 
?>

<div class="container mt-4">
    <h2 class="mb-4">Bem-vindo ao Sistema de Campeonatos Esportivos</h2>

    <div class="mb-4">
        <a href="/campeonato_esportivo/routes/placar_publico.php" class="btn btn-outline-success me-2">
            📻 Ver Placar Ao Vivo
        </a>
        <a href="/campeonato_esportivo/routes/ranking.php" class="btn btn-outline-primary me-2">
            🥇 Ver Ranking Geral
        </a>
        <a href="/campeonato_esportivo/routes/login.php" class="btn btn-outline-dark">
            🔐 Acessar Sistema
        </a>
    </div>

    <h4>Campeonatos em Andamento</h4>
    <h4>Campeonatos em Andamento</h4>
<?php if (empty($campeonatosPorEsporte)): ?>
    <div class="alert alert-info">Nenhum campeonato em andamento.</div>
<?php else: ?>
    <div class="row">
        <?php foreach ($campeonatosPorEsporte as $camp): ?>
            <div class="col-md-4">
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($camp['nome']) ?></h5>
                        <p class="card-text">
                            Temporada: <?= htmlspecialchars($camp['temporada']) ?><br>
                            Formato: <?= htmlspecialchars($camp['formato']) ?>
                        </p>
                        <a href="#" class="btn btn-sm btn-outline-primary">Ver Campeonato</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

</div>



<?php include 'views/cabecalho/footer.php'; ?>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
