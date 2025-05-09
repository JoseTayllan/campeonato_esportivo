<?php include __DIR__ . '../../../includes/index_sec.php'; ?>
<link rel="stylesheet" href="/campeonato_esportivo/public/assets/css/ranking.css">


<div class="container mt-4 container-campeonato">
    <h2 class="mb-4">📊 Ranking do Campeonato</h2>

    <!-- Artilheiros -->
    <h4>🔝 Artilheiros</h4>
    <table class="table table-striped">
        <thead><tr><th>Jogador</th><th>Time</th><th>Gols</th></tr></thead>
        <tbody>
            <?php foreach ($dados['artilheiros'] as $a): ?>
                <tr>
                    <td data-label="Jogador"><?= htmlspecialchars($a['nome']) ?></td>
                    <td data-label="Time"><?= htmlspecialchars($a['time']) ?></td>
                    <td data-label="Gols"><?= $a['gols'] ?></td>
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
                    <td data-label="Jogador"><?= htmlspecialchars($c['nome']) ?></td>
                    <td data-label="Time"><?= htmlspecialchars($c['time']) ?></td>
                    <td data-label="Amarelos"><?= $c['amarelos'] ?? 0 ?></td>
                    <td data-label="Vermelhos"><?= $c['vermelhos'] ?? 0 ?></td>
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
                    <td data-label="Time"><?= htmlspecialchars($t['nome']) ?></td>
                    <td data-label="Vitórias"><?= $t['vitorias'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Goleiros Destaque -->
    <h4>🧤 Goleiros em Destaque</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Goleiro</th>
                <th>Time</th>
                <th>Defesas</th>
                <th>Gols Sofridos</th>
                <th>Pênaltis Defendidos</th>
                <th>Clean Sheets</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dados['goleiros'] as $g): ?>
                <tr>
                    <td data-label="Goleiro"><?= htmlspecialchars($g['nome']) ?></td>
                    <td data-label="Time"><?= htmlspecialchars($g['time']) ?></td>
                    <td data-label="Defesas"><?= $g['total_defesas'] ?? 0 ?></td>
                    <td data-label="Gols Sofridos"><?= $g['total_gols_sofridos'] ?? 0 ?></td>
                    <td data-label="Pênaltis Defendidos"><?= $g['total_penaltis_defendidos'] ?? 0 ?></td>
                    <td data-label="Clean Sheets"><?= $g['total_clean_sheets'] ?? 0 ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="mt-auto">
    <div class="mt-5"></div>
    <?php require_once __DIR__ . '/../cabecalho/footer.php'; ?>
    <script src="/campeonato_esportivo/assets/js/bootstrap.bundle.min.js"></script>
</div>
