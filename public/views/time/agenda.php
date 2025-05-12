<?php if (!isset($partidas)) { die('Acesso direto não permitido.'); } ?>
<?php include_once __DIR__ . '/../../includes/assinatura_sec.php'; ?>

<body>
<main>
<div class="container mt-4 text-verde">
    <h2>Agenda de Jogos</h2>

    <?php if (empty($partidas)): ?>
        <div class="alert alert-info">Nenhuma partida encontrada para seu time.</div>
        <a href="/campeonato_esportivo/routes/time/dashboard_time.php" class="btn btn-primary">Voltar ao Painel</a>
    <?php else: ?>
        <div class="row">
            <?php
            $hoje = date('Y-m-d');
            $proximos = [];
            $passados = [];

            foreach ($partidas as $p) {
                if ($p['status'] === 'finalizada') {
                    $passados[] = $p;
                } else {
                    $proximos[] = $p;
                }
            }

            function formatarLogo($logo) {
                return (!empty($logo) && str_starts_with($logo, 'public/'))
                    ? '/campeonato_esportivo/' . ltrim($logo, '/')
                    : null;
            }
            ?>

            <div class="col-md-6">
                <h4>Próximos Jogos</h4>
                <?php foreach ($proximos as $jogo): ?>
                    <?php
                    $logoCasaUrl = formatarLogo($jogo['logo_casa']);
                    $logoForaUrl = formatarLogo($jogo['logo_fora']);
                    ?>
                    <div class="card mb-3">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <strong><?= date('d/m/Y', strtotime($jogo['data'])) ?></strong> às <?= substr($jogo['horario'], 0, 5) ?><br>
                                <?php if ($logoCasaUrl): ?><img src="<?= $logoCasaUrl ?>" alt="Escudo Casa" width="30" class="me-2"><?php endif; ?>
                                <?= $jogo['nome_casa'] ?> x <?= $jogo['nome_fora'] ?>
                                <?php if ($logoForaUrl): ?><img src="<?= $logoForaUrl ?>" alt="Escudo Fora" width="30" class="ms-2"><?php endif; ?>
                                <br><small>Local: <?= $jogo['local'] ?></small><br>

                                <?php if ($jogo['status'] === 'finalizada'): ?>
                                    <span class="badge bg-success mt-2">Finalizado</span>
                                <?php elseif ($jogo['status'] === 'em_andamento'): ?>
                                    <span class="badge bg-warning text-dark mt-2">Em andamento</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary mt-2">Não iniciado</span>
                                <?php endif; ?>
                            </div>
                            <div>
                                <a href="/campeonato_esportivo/routes/time/definir_escalacao.php?partida_id=<?= $jogo['id'] ?>" class="btn btn-primary">
                                    Definir Escalação
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="col-md-6">
                <h4>Jogos Passados</h4>
                <?php foreach ($passados as $jogo): ?>
                    <?php
                    $logoCasaUrl = formatarLogo($jogo['logo_casa']);
                    $logoForaUrl = formatarLogo($jogo['logo_fora']);
                    ?>
                    <div class="card mb-3">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <strong><?= date('d/m/Y', strtotime($jogo['data'])) ?></strong> às <?= substr($jogo['horario'], 0, 5) ?><br>
                                <?php if ($logoCasaUrl): ?><img src="<?= $logoCasaUrl ?>" alt="Escudo Casa" width="30" class="me-2"><?php endif; ?>
                                <?= $jogo['nome_casa'] ?>
                                <strong class="mx-2">
                                    <?= isset($jogo['placar_casa'], $jogo['placar_fora']) ? $jogo['placar_casa'] . ' x ' . $jogo['placar_fora'] : 'x' ?>
                                </strong>
                                <?= $jogo['nome_fora'] ?>
                                <?php if ($logoForaUrl): ?><img src="<?= $logoForaUrl ?>" alt="Escudo Fora" width="30" class="ms-2"><?php endif; ?>
                                <br><small>Local: <?= $jogo['local'] ?></small><br>
                                <span class="badge bg-success mt-2">Finalizado</span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>
</main>
<?php include __DIR__ . '/../cabecalho/footer.php'; ?>
</body>
