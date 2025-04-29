<?php
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../app/controllers/FaseRodadaController.php';
require_once __DIR__ . '/../cabecalho/header.php';

$controller = new FaseRodadaController($conn);

$campeonatoSelecionado = $_GET['campeonato_id'] ?? null;
$dados = [];

if ($campeonatoSelecionado) {
    $dados = $controller->carregarDados((int)$campeonatoSelecionado);
} else {
    $dados['campeonatos'] = $controller->carregarDados(0)['campeonatos'];
}
?>
<body class="d-flex flex-column min-vh-100">
<div class="container mt-4">

    <!-- Botão de Voltar -->
    <a href="/campeonato_esportivo/routes/campeonato_publico.php?id=<?= (int)$campeonatoSelecionado ?>"
       class="btn btn-outline-secondary btn-sm mb-4">
        🔙 Voltar para o Campeonato
    </a>

    <h2 class="mb-4 text-center">Estrutura do Campeonato</h2>

    <?php if (!empty($dados['fases'])): ?>
        <hr>
        <h4 class="text-primary mt-4">📋 Fases e Rodadas</h4>

        <?php foreach ($dados['fases'] as $fase): ?>
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <strong><?= htmlspecialchars($fase['nome']) ?> (Ordem <?= $fase['ordem'] ?>)</strong>
                </div>
                <div class="card-body">
                    <?php if (!empty($fase['rodadas'])): ?>
                        <ul class="list-group">
                            <?php foreach ($fase['rodadas'] as $rodada): ?>
                                <li class="list-group-item">
                                    <strong>Rodada <?= $rodada['numero'] ?>:</strong> <?= htmlspecialchars($rodada['tipo']) ?>
                                    <?php if (!empty($rodada['descricao'])): ?>
                                        - <?= htmlspecialchars($rodada['descricao']) ?>
                                    <?php endif; ?>

                                    <?php if (!empty($rodada['partidas'])): ?>
                                        <ul class="mt-3">
                                            <?php foreach ($rodada['partidas'] as $partida): ?>
                                                <li class="list-group-item">
                                                    <div class="d-flex justify-content-between align-items-center flex-wrap text-center">
                                                        <div class="d-flex align-items-center">
                                                            <?php if (!empty($partida['escudo_time_casa'])): ?>
                                                                <img src="/campeonato_esportivo/public/<?= $partida['escudo_time_casa'] ?>" alt="Escudo <?= $partida['time_casa'] ?>" width="40" class="me-2">
                                                            <?php endif; ?>
                                                            <strong><?= htmlspecialchars($partida['time_casa']) ?></strong>
                                                        </div>

                                                        <div class="fw-bold fs-4 text-primary">
                                                            <?= is_numeric($partida['placar_casa']) ? $partida['placar_casa'] : '-' ?>
                                                            <span class="mx-2">x</span>
                                                            <?= is_numeric($partida['placar_fora']) ? $partida['placar_fora'] : '-' ?>
                                                        </div>

                                                        <div class="d-flex align-items-center">
                                                            <strong><?= htmlspecialchars($partida['time_fora']) ?></strong>
                                                            <?php if (!empty($partida['escudo_time_fora'])): ?>
                                                                <img src="/campeonato_esportivo/public/<?= $partida['escudo_time_fora'] ?>" alt="Escudo <?= $partida['time_fora'] ?>" width="40" class="ms-2">
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>

                                                    <div class="small text-muted mt-2 text-center">
                                                        <?= $partida['data'] ?> às <?= substr($partida['horario'], 0, 5) ?> — 
                                                        <em><?= htmlspecialchars($partida['local']) ?></em>
                                                    </div>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php else: ?>
                                        <div class="text-muted ms-3">Nenhuma partida cadastrada nesta rodada.</div>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <div class="text-muted">Nenhuma rodada cadastrada nesta fase.</div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (!empty($dados['classificacao'])): ?>
        <hr>
        <h4 class="text-success mt-4">🏆 Tabela de Classificação</h4>
        <div class="table-responsive mb-5">
            <table class="table table-striped table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Time</th>
                        <th>Jogos</th>
                        <th>Vitórias</th>
                        <th>Empates</th>
                        <th>Derrotas</th>
                        <th>Gols Pró</th>
                        <th>Gols Contra</th>
                        <th>Saldo de Gols</th>
                        <th>Pontos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dados['classificacao'] as $time): ?>
                        <tr>
                            <td><?= htmlspecialchars($time['nome']) ?></td>
                            <td><?= $time['jogos'] ?></td>
                            <td><?= $time['vitorias'] ?></td>
                            <td><?= $time['empates'] ?></td>
                            <td><?= $time['derrotas'] ?></td>
                            <td><?= $time['gols_pro'] ?></td>
                            <td><?= $time['gols_contra'] ?></td>
                            <td><?= $time['saldo'] ?></td>
                            <td><?= $time['pontos'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

</div>
</body>
<!-- Footer com margem automática no topo para colar no final -->
<div class="mt-auto">

    <?php include __DIR__ . '/../cabecalho/footer.php'; ?>
</div>

<script src="../../../assets/js/bootstrap.bundle.min.js"></script>
