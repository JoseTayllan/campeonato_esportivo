<?php
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../app/controllers/FaseRodadaController.php';
require_once __DIR__ . '/../../includes/index_sec.php';

$controller = new FaseRodadaController($conn);

$campeonatoSelecionado = $_GET['campeonato_id'] ?? null;
$dados = [];

if ($campeonatoSelecionado) {
    $dados = $controller->carregarDados((int)$campeonatoSelecionado);
} else {
    $dados['campeonatos'] = $controller->carregarDados(0)['campeonatos'];
}
?>
<style>
@media (max-width: 768px) {
  table {
    width: 100% !important;
    max-width: 100% !important;
    table-layout: auto !important;
  }

  table th,
  table td {
    font-size: 0.85rem !important;
    padding: 0.4rem !important;
    word-break: break-word !important;
  }
}
</style>
<body class="d-flex flex-column min-vh-100">
<div class="container mt-4">

    <!-- Botão de Voltar -->
    <a href="/campeonato_esportivo/routes/public/campeonato_publico.php?id=<?= (int)$campeonatoSelecionado ?>"
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
    <div class="d-flex justify-content-between align-items-center text-center flex-wrap">

        <!-- Time Casa -->
        <div class="d-flex flex-column align-items-center w-25">
            <?php if (!empty($partida['escudo_time_casa'])): ?>
                <img src="/campeonato_esportivo/<?= $partida['escudo_time_casa'] ?>" alt="Escudo <?= $partida['time_casa'] ?>" width="48">
            <?php endif; ?>
            <small class="fw-bold"><?= htmlspecialchars($partida['time_casa']) ?></small>
        </div>

        <!-- Placar -->
        <div class="fw-bold fs-4 text-primary w-25">
            <?= is_numeric($partida['placar_casa']) ? $partida['placar_casa'] : '-' ?>
            <span class="mx-2">x</span>
            <?= is_numeric($partida['placar_fora']) ? $partida['placar_fora'] : '-' ?>
        </div>

        <!-- Time Fora -->
        <div class="d-flex flex-column align-items-center w-25">
            <?php if (!empty($partida['escudo_time_fora'])): ?>
                <img src="/campeonato_esportivo/<?= $partida['escudo_time_fora'] ?>" alt="Escudo <?= $partida['time_fora'] ?>" width="48">
            <?php endif; ?>
            <small class="fw-bold"><?= htmlspecialchars($partida['time_fora']) ?></small>
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
        <?php
        usort($dados['classificacao'], function($a, $b) {
            return $b['pontos'] <=> $a['pontos']
                ?: $b['saldo'] <=> $a['saldo']
                ?: $b['gols_pro'] <=> $a['gols_pro'];
        });
        ?>
        <hr>
        <h4 class="text-success mt-4" style="font-size: 2rem;">🏆 Tabela de Classificação</h4>
        <div class="mb-5">
            <table class="table table-striped table-bordered text-center w-100" style="font-size: 1rem;">
                <thead class="table-dark text-nowrap">
                    <tr>
                        <th>Time</th>
                        <th>J</th>
                        <th>V</th>
                        <th>E</th>
                        <th>D</th>
                        <th>GP</th>
                        <th>GC</th>
                        <th>SG</th>
                        <th>Pts</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dados['classificacao'] as $time): ?>
                        <tr>
                            <td class="d-flex align-items-center gap-2">
                                <?php if (!empty($time['escudo'])): ?>
                                    <img src="/campeonato_esportivo/<?= $time['escudo'] ?>" alt="Escudo" width="28">
                                <?php endif; ?>
                                <span><?= htmlspecialchars($time['nome']) ?></span>
                            </td>
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

<div class="mt-auto">
    <?php include __DIR__ . '/../cabecalho/footer.php'; ?>
</div>

<script src="../../../assets/js/bootstrap.bundle.min.js"></script>
