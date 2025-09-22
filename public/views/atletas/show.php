<?php
if (!$dados || !isset($dados['jogador'])) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Jogador não encontrado.</div></div>";
    echo '<div class="container"><a href="/campeonato_esportivo/routes/atletas/index.php" class="btn btn-secondary mt-2">← Voltar</a></div>';
    return;
}
?>
<?php include __DIR__ . '../../../includes/index_sec.php'; ?>

<div class="container mt-5">
    <div class="card shadow p-4">
        <div class="row align-items-center mb-4">
            <div class="col-md-8">
                <h2 class="fw-bold"><?= htmlspecialchars($dados['jogador']['nome'] ?? '') ?></h2>
                <p class="mb-1"><strong>Posição:</strong> <?= htmlspecialchars($dados['jogador']['posicao'] ?? '') ?></p>
                <p class="mb-1"><strong>Nacionalidade:</strong> <?= htmlspecialchars($dados['jogador']['nacionalidade'] ?? '') ?></p>
                <p><strong>Idade:</strong> <?= htmlspecialchars((string)($dados['jogador']['idade'] ?? '')) ?></p>
            </div>
            <div class="col-md-4 d-flex justify-content-center">
                <div style="max-width: 160px; height: 160px;">
                    <canvas id="graficoDesempenho"></canvas>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <h5>Times</h5>
                <ul class="list-group">
                    <?php while ($t = mysqli_fetch_assoc($dados['times'])): ?>
                        <li class="list-group-item">
                            <?= htmlspecialchars($t['nome'] ?? '') ?> 
                            (<?= htmlspecialchars($t['data_entrada'] ?? '') ?> até <?= htmlspecialchars($t['data_saida'] ?? 'hoje') ?>)
                        </li>
                    <?php endwhile; ?>
                </ul>
            </div>

            <div class="col-md-6 mb-3">
                <h5>Campeonatos</h5>
                <ul class="list-group">
                    <?php while ($c = mysqli_fetch_assoc($dados['campeonatos'])): ?>
                        <li class="list-group-item">
                            <?= htmlspecialchars($c['nome'] ?? '') ?> - <?= htmlspecialchars((string)($c['temporada'] ?? '')) ?>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </div>
        </div>

        <!-- ✅ Campeonatos Disputados com estatísticas -->
        <div class="row mt-4">
            <div class="col-md-12">
                <h5>Campeonatos Disputados</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm text-center">
                        <thead class="table-light">
                            <tr>
                                <th>Campeonato</th>
                                <th>Temporada</th>
                                <th>Jogos</th>
                                <th>Gols</th>
                                <th>Amarelos</th>
                                <th>Vermelhos</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($dados['campeonatosDisputados'] && mysqli_num_rows($dados['campeonatosDisputados']) > 0): ?>
                                <?php while ($c = mysqli_fetch_assoc($dados['campeonatosDisputados'])): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($c['campeonato_nome'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($c['temporada'] ?? '') ?></td>
                                        <td><?= (int)($c['jogos'] ?? 0) ?></td>
                                        <td><?= (int)($c['gols'] ?? 0) ?></td>
                                        <td><?= (int)($c['amarelos'] ?? 0) ?></td>
                                        <td><?= (int)($c['vermelhos'] ?? 0) ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="6">Nenhum campeonato encontrado.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <a href="/campeonato_esportivo/routes/atletas/index.php" class="btn btn-secondary mt-4">← Voltar</a>
    </div>
</div>

<div class="mt-5">
    <?php require_once __DIR__ . '/../cabecalho/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('graficoDesempenho');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Gols', 'Amarelos', 'Vermelhos'],
                datasets: [{
                    label: 'Desempenho',
                    data: [
                        <?= (int)($dados['gols'] ?? 0) ?>,
                        <?= (int)($dados['cartoes']['amarelos'] ?? 0) ?>,
                        <?= (int)($dados['cartoes']['vermelhos'] ?? 0) ?>
                    ],
                    backgroundColor: ['#198754', '#ffc107', '#dc3545'],
                    borderWidth: 1
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
</div>
