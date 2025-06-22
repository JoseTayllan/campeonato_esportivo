<?php include_once __DIR__ . '/../../includes/admin_header.php'; ?>

<style>
    /* 🔥 Tamanho da logo controlado */
    .escudo-time {
        max-width: 140px;
        max-height: 140px;
        object-fit: contain;
    }
</style>

<main class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-success text-white">
            🏆 Dashboard do Campeão — <?= htmlspecialchars($timeCampeao['nome']) ?>
        </div>
        <div class="card-body">

            <div class="row">
                <!-- Escudo do Time -->
                <div class="col-md-3">
                    <div class="card mb-3">
                        <div class="card-body text-center">
                            <img src="/campeonato_esportivo/<?= $timeCampeao['escudo'] ?? 'assets/img/perfil_padrao/perfil_padrao.png' ?>"
                                alt="Escudo <?= htmlspecialchars($timeCampeao['nome']) ?>"
                                class="img-fluid mb-3 escudo-time">
                            <h4 class="card-title"><?= htmlspecialchars($timeCampeao['nome']) ?></h4>
                            <p><strong>Estádio:</strong> <?= htmlspecialchars($timeCampeao['estadio'] ?? 'Não informado') ?><br>
                                <strong>Cidade:</strong> <?= htmlspecialchars($timeCampeao['cidade'] ?? 'Não informado') ?>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Estatísticas do Time -->
                <div class="col-md-9">
                    <div class="card mb-3">
                        <div class="card-header bg-primary text-white">
                            📊 Estatísticas do Time Campeão
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col">
                                    <h6>Vitórias</h6>
                                    <p><?= $estatisticasTime['vitorias'] ?? 0 ?></p>
                                </div>
                                <div class="col">
                                    <h6>Empates</h6>
                                    <p><?= $estatisticasTime['empates'] ?? 0 ?></p>
                                </div>
                                <div class="col">
                                    <h6>Derrotas</h6>
                                    <p><?= $estatisticasTime['derrotas'] ?? 0 ?></p>
                                </div>
                                <div class="col">
                                    <h6>Gols Pró</h6>
                                    <p><?= $estatisticasTime['gols_pro'] ?? 0 ?></p>
                                </div>
                                <div class="col">
                                    <h6>Gols Contra</h6>
                                    <p><?= $estatisticasTime['gols_contra'] ?? 0 ?></p>
                                </div>
                                <div class="col">
                                    <h6>Saldo</h6>
                                    <p><?= ($estatisticasTime['gols_pro'] ?? 0) - ($estatisticasTime['gols_contra'] ?? 0) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Artilheiros -->
            <div class="card mb-3">
                <div class="card-header bg-danger text-white">
                    🥅 Artilheiros do Campeonato
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Jogador</th>
                                <th>Time</th>
                                <th>Gols</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($artilheiros as $artilheiro) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($artilheiro['nome']) ?></td>
                                    <td><?= htmlspecialchars($artilheiro['time']) ?></td>
                                    <td><?= $artilheiro['gols'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Banner ou Imagem do Elenco -->
            <div class="card">
                <div class="card-header bg-dark text-white">
                    🖼️ Foto do Elenco Campeão
                </div>
                <div class="card-body text-center">
                    <img src="/campeonato_esportivo/public/<?= $timeCampeao['elenco'] ?? 'assets/img/padrao.png' ?>"
                        class="img-fluid"
                        alt="Elenco do <?= htmlspecialchars($timeCampeao['nome']) ?>">
                </div>
            </div>

        </div>
    </div>
</main>

<?php include __DIR__ . '/../cabecalho/footer.php'; ?>