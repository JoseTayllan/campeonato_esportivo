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
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Estrutura do Campeonato</title>
    <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet">
<style>
.partida {
  display: grid;
  position: relative;
  z-index: 1;
  width: 100%;
  max-width: none;
  max-width: 800px;
  background-color: #fff;
  border-radius: 12px;
  box-shadow: 0 1px 4px rgba(0,0,0,0.1);
  align-items: stretch;
  display: grid;
  grid-template-columns: 1fr auto 1fr;
  align-items: center;
  justify-content: center;
  gap: 12px;
  padding: 16px;
  width: 100%;
  box-sizing: border-box;
  margin: 0 auto;
  
}

.time-box {
  overflow: hidden;
  height: 100%;
  justify-content: flex-start;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  flex: 1 1 0;
  gap: 4px;
  height: 100%;
  min-height: 100px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  text-align: center;
  min-width: 100px;
  padding: 4px;
}

.time-box img {
  width: 60px;
  height: auto;
  margin-bottom: 6px;
}

.nome-time {
  padding: 0 8px;
  box-sizing: border-box;
  max-width: 90%;
  overflow-wrap: break-word;
  word-break: break-word;
  margin-top: 8px;
  display: inline-block;
  vertical-align: top;
  margin-top: auto;
  margin-bottom: 0;
  min-height: 24px;
  margin-top: 6px;
  font-size: 0.9rem;
  font-weight: 600;
  text-align: center;
  white-space: normal;
  word-break: break-word;
  max-width: 100%;
  line-height: 1.2;
}

.placar-box {
  font-size: 2rem;
  font-weight: bold;
  color: #007bff;
  white-space: nowrap;
  text-align: center;
}

.titulo-tabela {
  font-size: 1.8rem;
  white-space: nowrap;
  text-align: center;
}

@media (max-width: 576px) {
  .partida {
    grid-template-columns: 1fr auto 1fr;
    padding: 16px;
    display: grid;
    }

  .time-box img {
    width: 60px;
  }

  .nome-time {
    font-size: 0.8rem;
  }

  .placar-box {
    font-size: 1.6rem;
  }

  .titulo-tabela {
    font-size: 1.4rem;
  }
}

@media (max-width: 768px) {
  table {
    width: 100% !important;
    table-layout: auto !important;
  }

  table th,
  table td {
    font-size: 0.85rem !important;
    padding: 0.4rem !important;
    word-break: break-word !important;
  }

  footer {
    width: 100%;
  }
}
</style>


</head>
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
                                <li class="list-group-item px-0">
                                    <strong>Rodada <?= $rodada['numero'] ?>:</strong> <?= htmlspecialchars($rodada['tipo']) ?>
                                    <?php if (!empty($rodada['descricao'])): ?> - <?= htmlspecialchars($rodada['descricao']) ?><?php endif; ?>

                                    <?php if (!empty($rodada['partidas'])): ?>
                                        <ul class="mt-3">
                                            <?php foreach ($rodada['partidas'] as $partida): ?>
                                                <li class="list-group-item p-2">
                                                    <div class="partida">
                                                        <div class="time-box" >
                                                            <?php if (!empty($partida['escudo_time_casa'])): ?>
                                                                <img src="/campeonato_esportivo/<?= $partida['escudo_time_casa'] ?>" alt="Escudo <?= $partida['time_casa'] ?>">
                                                            <?php endif; ?>
                                                            <div class="nome-time"><?= htmlspecialchars($partida['time_casa']) ?></div>
                                                        </div>

                                                        <div class="placar-box">
                                                            <?php if ($partida['status'] === 'finalizada'): ?>
                                                                <?= $partida['placar_casa'] ?> <span class="mx-2">x</span> <?= $partida['placar_fora'] ?>
                                                            <?php else: ?>
                                                                <span class="mx-2">x</span>
                                                            <?php endif; ?>
                                                        </div>

                                                        <div class="time-box">
                                                            <?php if (!empty($partida['escudo_time_fora'])): ?>
                                                                <img src="/campeonato_esportivo/<?= $partida['escudo_time_fora'] ?>" alt="Escudo <?= $partida['time_fora'] ?>">
                                                            <?php endif; ?>
                                                            <div class="nome-time"><?= htmlspecialchars($partida['time_fora']) ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="small text-muted mt-2 text-center">
                                                        <?= $partida['data'] ?> às <?= substr($partida['horario'], 0, 5) ?> — <em><?= htmlspecialchars($partida['local']) ?></em>
                                                    </div>

                                                    <?php if (!empty($partida['link_transmissao'])): ?>
                                                        <div class="text-center mt-2">
                                                            <a href="/campeonato_esportivo/routes/public/assistir.php?id=<?= $partida['partida_id'] ?>" target="_blank" class="btn btn-sm btn-outline-danger">
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
        <h4 class="text-success mt-4 text-center titulo-tabela">🏆 Tabela de Classificação</h4>
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
<div class="mt-auto">
    <?php include __DIR__ . '/../cabecalho/footer.php'; ?>
</div>
<script src="../../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
