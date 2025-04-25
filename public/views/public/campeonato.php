<?php require_once __DIR__ . '/../cabecalho/header.php'; ?>

<?php $base_url = '/campeonato_esportivo/public/img/times/'; ?>

<div class="container mt-4">
    <h2><?= htmlspecialchars($dados['campeonato']['nome']) ?></h2>
    <a href="/campeonato_esportivo/routes/ranking_campeonato.php?campeonato_id=<?= $dados['campeonato']['id'] ?>" 
   class="btn btn-outline-primary btn-sm mb-3">
   🥇 Ver Ranking do Campeonato
</a>

    <p>
        Temporada: <?= htmlspecialchars($dados['campeonato']['temporada']) ?> | 
        Formato: <?= htmlspecialchars($dados['campeonato']['formato']) ?>
    </p>

    <h4>Times Participantes</h4>
<div class="row">
    <?php foreach ($dados['times'] as $time): ?>
        <div class="col-md-3 text-center mb-3">
        <img src="/campeonato_esportivo/public/<?= $time['escudo'] ?>" width="50" class="mb-2"><br>
            <?= htmlspecialchars($time['nome']) ?><br>
            <?php if (!empty($time['codigo_publico'])): ?>
                <a href="/campeonato_esportivo/public/views/time/perfil_time.php?codigo=<?= urlencode($time['codigo_publico']) ?>" class="btn btn-sm btn-outline-secondary mt-1">
                    Ver Perfil
                </a>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>

    
    <h4 class="mt-4">Rodadas e Partidas</h4>
    <?php if (empty($dados['partidas'])): ?>
        <p class="text-muted">Nenhuma partida cadastrada ainda.</p>
    <?php else: ?>
        <ul class="list-group">
            <?php 
            $rodadaAtual = null;
            foreach ($dados['partidas'] as $p): 
                if ($rodadaAtual !== $p['rodada_id']): 
                    $rodadaAtual = $p['rodada_id'];
            ?>
                <li class="list-group-item active">
                    Rodada <?= $p['numero'] ?> — <?= htmlspecialchars($p['tipo']) ?> | <?= htmlspecialchars($p['descricao']) ?>
                </li>
            <?php endif; ?>
            <li class="list-group-item">
                <?= $p['data'] ? date('d/m/Y', strtotime($p['data'])) : '--/--/----' ?> - 
                <?= $p['horario'] ? substr($p['horario'], 0, 5) : '--:--' ?> —
                <?= $p['time_casa'] ?? '-' ?> <strong><?= $p['placar_casa'] ?? '-' ?> x <?= $p['placar_fora'] ?? '-' ?></strong> <?= $p['time_fora'] ?? '-' ?>
                <span class="text-muted">(<?= $p['local'] ?? 'Local indefinido' ?>)</span>
            </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../cabecalho/footer.php'; ?>
