<?php require_once __DIR__ . '/../cabecalho/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">🏆 Ranking Geral</h2>

    <!-- Artilheiros -->
    <h4>🔝 Artilheiros</h4>
    <table class="table table-striped">
        <thead><tr><th>Jogador</th><th>Time</th><th>Gols</th></tr></thead>
        <tbody>
            <?php foreach ($dados['artilheiros'] as $a): ?>
                <tr>
                    <td><?= htmlspecialchars($a['nome']) ?></td>
                    <td><?= htmlspecialchars($a['time']) ?></td>
                    <td><?= $a['gols'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Cartões -->
    <h4>🟨🟥 Jogadores com mais Cartões</h4>
    <table class="table table-striped">
        <thead><tr><th>Jogador</th><th>Time</th><th>Amarelos</th><th>Vermelhos</th></tr></thead>
        <tbody>
            <?php foreach ($dados['cartoes'] as $c): ?>
                <tr>
                    <td><?= htmlspecialchars($c['nome']) ?></td>
                    <td><?= htmlspecialchars($c['time']) ?></td>
                    <td><?= $c['amarelos'] ?></td>
                    <td><?= $c['vermelhos'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Times com mais vitórias -->
    <h4>🏅 Times com Mais Vitórias</h4>
    <table class="table table-striped">
        <thead><tr><th>Time</th><th>Vitórias</th></tr></thead>
        <tbody>
            <?php foreach ($dados['vitorias'] as $t): ?>
                <tr>
                    <td><?= htmlspecialchars($t['nome']) ?></td>
                    <td><?= $t['vitorias'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../cabecalho/footer.php'; ?>
