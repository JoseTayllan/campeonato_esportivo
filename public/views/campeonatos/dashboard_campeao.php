<?php include_once __DIR__ . '/../../includes/admin_header.php'; ?>

<style>
    .escudo-time {
        max-width: 120px;
        object-fit: contain;
    }
</style>

<main class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-success text-white fw-bold fs-5 d-flex align-items-center">
            🏆 <span class="ms-2">Dashboard do Campeão — <?= htmlspecialchars($timeCampeao['nome']) ?></span>
        </div>

        <div class="card-body">

            <div class="row">
                <!-- Escudo + Informações -->
                <div class="col-md-3">
                    <div class="card mb-3 shadow-sm text-center">
                        <div class="card-body">
                            <img src="/campeonato_esportivo/<?= $timeCampeao['escudo'] ?? 'public/assets/img/perfil_padrao/perfil_padrao.png' ?>"
                                alt="Escudo <?= htmlspecialchars($timeCampeao['nome']) ?>"
                                class="escudo-time mb-3 rounded-circle border">
                            <h4 class="card-title"><?= htmlspecialchars($timeCampeao['nome']) ?></h4>
                            <p class="mb-1"><strong>Estádio:</strong><br> <?= htmlspecialchars($timeCampeao['estadio'] ?? 'Não informado') ?></p>
                            <p><strong>Cidade:</strong><br> <?= htmlspecialchars($timeCampeao['cidade'] ?? 'Não informado') ?></p>
                        </div>
                    </div>
                </div>

                <!-- Estatísticas -->
                <div class="col-md-9">
                    <div class="card mb-3 shadow-sm">
                        <div class="card-header bg-primary text-white fw-semibold">
                            📊 Estatísticas do Time Campeão
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <?php
                                $estat = [
                                    ['label' => 'Vitórias', 'valor' => $estatisticasTime['vitorias'] ?? 0, 'class' => 'success'],
                                    ['label' => 'Empates', 'valor' => $estatisticasTime['empates'] ?? 0, 'class' => 'secondary'],
                                    ['label' => 'Derrotas', 'valor' => $estatisticasTime['derrotas'] ?? 0, 'class' => 'danger'],
                                    ['label' => 'Gols Pró', 'valor' => $estatisticasTime['gols_pro'] ?? 0, 'class' => 'primary'],
                                    ['label' => 'Gols Contra', 'valor' => $estatisticasTime['gols_contra'] ?? 0, 'class' => 'warning'],
                                    ['label' => 'Saldo', 'valor' => ($estatisticasTime['gols_pro'] ?? 0) - ($estatisticasTime['gols_contra'] ?? 0), 'class' => 'dark']
                                ];
                                foreach ($estat as $e): ?>
                                    <div class="col-sm-6 col-md-4 col-lg-2 mb-3">
                                        <div class="border rounded p-2 bg-light">
                                            <h6 class="text-<?= $e['class'] ?>"><?= $e['label'] ?></h6>
                                            <p class="fw-bold fs-5"><?= $e['valor'] ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-md-6 mb-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-warning fw-semibold">🥇 Artilheiro do Campeonato</div>
                        <div class="card-body">
                            <img src="/campeonato_esportivo/public/img/jogadores/<?= $artilheiros[0]['imagem'] ?? 'perfil_padrao.png' ?>"
                                class="rounded-circle mb-2 border"
                                style="max-width: 100px; height: 100px; object-fit: cover;">
                            <h5 class="mb-0"><?= htmlspecialchars($artilheiros[0]['nome']) ?></h5>
                            <small class="text-muted"><?= htmlspecialchars($artilheiros[0]['time']) ?></small>
                            <p class="mt-2 mb-0"><strong><?= $artilheiros[0]['gols'] ?></strong> gols</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-info text-white fw-semibold">🧤 Melhor Goleiro</div>
                        <div class="card-body">
                            <img src="/campeonato_esportivo/public/img/jogadores/<?= $melhorGoleiro['imagem'] ?? 'perfil_padrao.png' ?>"
                                class="rounded-circle mb-2 border"
                                style="max-width: 100px; height: 100px; object-fit: cover;">
                            <h5 class="mb-0"><?= htmlspecialchars($melhorGoleiro['nome']) ?></h5>
                            <small class="text-muted"><?= htmlspecialchars($melhorGoleiro['time']) ?></small>
                            <p class="mt-2 mb-0"><strong><?= $melhorGoleiro['defesas'] ?? '?' ?></strong> defesas</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Artilheiros -->
            <div class="card mb-3 shadow-sm">
                <div class="card-header bg-danger text-white fw-semibold">
                    🥅 Artilheiros do Campeonato
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>Jogador</th>
                                    <th>Time</th>
                                    <th>Gols</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($artilheiros as $artilheiro): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($artilheiro['nome']) ?></td>
                                        <td><?= htmlspecialchars($artilheiro['time']) ?></td>
                                        <td><strong><?= $artilheiro['gols'] ?></strong></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Elenco Campeão -->
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white fw-semibold">
                    🖼️ Foto do Elenco Campeão
                </div>
                <div class="card-body text-center">
                    <img src="/campeonato_esportivo/public/<?= $timeCampeao['elenco'] ?? 'assets/img/padrao.png' ?>"
                        class="img-fluid rounded shadow-sm"
                        alt="Elenco do <?= htmlspecialchars($timeCampeao['nome']) ?>">
                </div>
            </div>

        </div>
    </div>
</main>

<?php include __DIR__ . '/../cabecalho/footer.php'; ?>
