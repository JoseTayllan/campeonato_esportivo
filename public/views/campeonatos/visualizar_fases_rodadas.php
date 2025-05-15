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
.partida {
    display: grid;
    grid-template-columns: 1fr auto 1fr;
    align-items: center;
    gap: 10px;
    padding: 12px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.1);
    width: 100%;
    max-width: 100%;
    text-align: center;
}

.time-box {
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: 70px;
}

.time-box img {
    width: 60px;
    height: auto;
}

.nome-time {
    margin-top: 4px;
    font-size: 0.9rem;
    font-weight: 500;
    word-break: break-word;
}

.placar-box {
    font-size: 2rem;
    font-weight: bold;
    color: #007bff;
    white-space: nowrap;
}

/* Responsivo para telas menores */
@media (max-width: 576px) {
    .time-box img {
        width: 45px;
    }

    .placar-box {
        font-size: 1.5rem;
    }

    .nome-time {
        font-size: 0.8rem;
    }

    .partida {
        grid-template-columns: 1fr auto 1fr;
        gap: 6px;
    }
}
</style>

<body class="d-flex flex-column min-vh-100">
<div class="container mt-4">

    <a href="/campeonato_esportivo/routes/public/campeonato_publico.php?id=<?= (int)$campeonatoSelecionado ?>" class="btn btn-outline-secondary btn-sm mb-4">
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
                                                    <div class="partida">

                                                        <!-- Time Casa -->
                                                        <div class="time-box">
                                                            <?php if (!empty($partida['escudo_time_casa'])): ?>
                                                                <img src="/campeonato_esportivo/<?= $partida['escudo_time_casa'] ?>" alt="Escudo <?= $partida['time_casa'] ?>">
                                                            <?php endif; ?>
                                                            <small class="fw-bold"><?= htmlspecialchars($partida['time_casa']) ?></small>
                                                        </div>

                                                        <!-- Placar -->
                                                        <div class="placar-box">
                                                            <?= is_numeric($partida['placar_casa']) ? $partida['placar_casa'] : '-' ?>
                                                            <span class="mx-2">x</span>
                                                            <?= is_numeric($partida['placar_fora']) ? $partida['placar_fora'] : '-' ?>
                                                        </div>

                                                        <!-- Time Fora -->
                                                        <div class="time-box">
                                                            <?php if (!empty($partida['escudo_time_fora'])): ?>
                                                                <img src="/campeonato_esportivo/<?= $partida['escudo_time_fora'] ?>" alt="Escudo <?= $partida['time_fora'] ?>">
                                                            <?php endif; ?>
                                                            <small class="fw-bold"><?= htmlspecialchars($partida['time_fora']) ?></small>
                                                        </div>

                                                    </div>

                                                    <div class="small text-muted mt-2 text-center">
                                                        <?= $partida['data'] ?> às <?= substr($partida['horario'], 0, 5) ?> —
                                                        <em><?= htmlspecialchars($partida['local']) ?></em>
                                                    </div>

                                                    <?php if (!empty($partida['link_transmissao'])): ?>
                                                        <div class="text-center mt-2">
                                                            <a href="/campeonato_esportivo/routes/public/assistir.php?id=<?= $partida['partida_id'] ?>"
                                                                target="_blank"
                                                                class="btn btn-sm btn-outline-danger">
                                                                ▶️ Assistir Gravação
                                                            </a>
                                                        </div>
                                                    <?php endif; ?>

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
        usort($dados['classificacao'], function ($a, $b) {
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
