<?php
$base_url = '/campeonato_esportivo/public/';

?>

<div class="container mt-4">
    <h2>Agenda de Jogos</h2>

    <?php if (empty($partidas)): ?>
        <div class="alert alert-info">Nenhuma partida encontrada para seu time.</div>
        <a href="../../dashboard/dashboard_time.php" class="btn btn-primary">Voltar ao Painel</a>
    <?php else: ?>
        <div class="row">
            <?php
                $hoje = date('Y-m-d');
                $proximos = [];
                $passados = [];

                foreach ($partidas as $p) {
                    if ($p['data'] >= $hoje) {
                        $proximos[] = $p;
                    } else {
                        $passados[] = $p;
                    }
                }
            ?>

            <div class="col-md-6">
                <h4>Próximos Jogos</h4>
                <?php foreach ($proximos as $jogo): ?>
                    <div class="card mb-3">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <strong><?= date('d/m/Y', strtotime($jogo['data'])) ?></strong> às <?= substr($jogo['horario'], 0, 5) ?><br>
                                <img src="<?= $base_url . $jogo['logo_casa'] ?>" alt="Escudo Casa" width="30" class="me-2">
                                <?= $jogo['nome_casa'] ?> x <?= $jogo['nome_fora'] ?>
                                <img src="<?= $base_url . $jogo['logo_fora'] ?>" alt="Escudo Fora" width="30" class="ms-2">
                                <br><small>Local: <?= $jogo['local'] ?></small>
                            </div>
                            <div>
                                <a href="/campeonato_esportivo/public/views/time/definir_escalacao.php?partida_id=<?= $jogo['id'] ?>" class="btn btn-primary">
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
                    <div class="card mb-3">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <strong><?= date('d/m/Y', strtotime($jogo['data'])) ?></strong> às <?= substr($jogo['horario'], 0, 5) ?><br>
                                <img src="<?= $base_url . $jogo['logo_casa'] ?>" alt="Escudo Casa" width="30" class="me-2">
                                <?= $jogo['nome_casa'] ?> x <?= $jogo['nome_fora'] ?>
                                <img src="<?= $base_url . $jogo['logo_fora'] ?>" alt="Escudo Fora" width="30" class="ms-2">
                                <br><small>Local: <?= $jogo['local'] ?></small>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>
