<?php require_once __DIR__ . '/../../includes/admin_sec.php'; ?>

<main class="flex-grow-1">
    <div class="container mt-4">
        <h2 class="text-dark">Rodadas do Campeonato</h2>

        <?php if (!empty($_SESSION['mensagem_sucesso'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['mensagem_sucesso'];
                unset($_SESSION['mensagem_sucesso']); ?>
            </div>
        <?php elseif (!empty($_SESSION['mensagem_erro'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['mensagem_erro'];
                unset($_SESSION['mensagem_erro']); ?>
            </div>
        <?php endif; ?>

      

            <?php foreach ($model->listarRodadas($campeonato['id']) as $rodada): ?>
                <div class="accordion mb-4" id="rodadasAccordion<?= $rodada['id'] ?>">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading<?= $rodada['id'] ?>">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse<?= $rodada['id'] ?>" aria-expanded="false"
                                aria-controls="collapse<?= $rodada['id'] ?>">
                                <strong>Rodada <?= $rodada['numero'] ?></strong> - <?= htmlspecialchars($rodada['tipo']) ?>
                                <br><small><?= htmlspecialchars($rodada['descricao']) ?></small>
                            </button>
                        </h2>

                        <div id="collapse<?= $rodada['id'] ?>" class="accordion-collapse collapse"
                            aria-labelledby="heading<?= $rodada['id'] ?>" data-bs-parent="#rodadasAccordion<?= $rodada['id'] ?>">
                            <div class="accordion-body">

                                <div class="d-flex justify-content-end mb-3">
                                    <a href="/campeonato_esportivo/routes/adms/excluir_rodada.php?id=<?= $rodada['id'] ?>&campeonato_id=<?= $campeonato['id'] ?>"
                                        class="btn btn-sm btn-outline-danger">Excluir</a>
                                </div>

                                <?php $partidas = $model->listarPartidasPorRodada($rodada['id']); ?>
                                <?php if ($partidas): ?>
                                    <?php foreach ($partidas as $jogo): ?>
                                        <form method="POST" action="/campeonato_esportivo/routes/adms/editar_partida.php" class="row g-2 mb-3">
                                            <input type="hidden" name="partida_id" value="<?= $jogo['id'] ?>">
                                            <input type="hidden" name="campeonato_id" value="<?= $campeonato['id'] ?>">

                                            <div class="col-md-2">
                                                <label class="form-label text-dark">Fase</label>
                                                <select name="fase_id" class="form-select form-select-sm" required>
                                                    <?php foreach ($model->listarFasesDoCampeonato($campeonato['id']) as $fase): ?>
                                                        <option value="<?= $fase['id'] ?>" <?= ($jogo['fase_id'] ?? '') == $fase['id'] ? 'selected' : '' ?>>
                                                            <?= htmlspecialchars($fase['nome']) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="col-md-2">
                                                <label class="form-label text-dark">Casa</label>
                                                <select name="time_casa" class="form-select form-select-sm" required>
                                                    <?php foreach ($model->listarTimesPorCampeonato($campeonato['id']) as $time): ?>
                                                        <option value="<?= $time['id'] ?>" <?= $jogo['id_time_casa'] == $time['id'] ? 'selected' : '' ?>>
                                                            <?= htmlspecialchars($time['nome']) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="col-md-2">
                                                <label class="form-label text-dark">Visitante</label>
                                                <select name="time_fora" class="form-select form-select-sm" required>
                                                    <?php foreach ($model->listarTimesPorCampeonato($campeonato['id']) as $time): ?>
                                                        <option value="<?= $time['id'] ?>" <?= $jogo['id_time_fora'] == $time['id'] ? 'selected' : '' ?>>
                                                            <?= htmlspecialchars($time['nome']) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="col-md-2">
                                                <label class="form-label text-dark">Data</label>
                                                <input type="date" name="data" value="<?= $jogo['data'] ?>" class="form-control form-control-sm" required>
                                            </div>

                                            <div class="col-md-2">
                                                <label class="form-label text-dark">Hora</label>
                                                <input type="time" name="horario" value="<?= $jogo['horario'] ?>" class="form-control form-control-sm" required>
                                            </div>

                                            <div class="col-md-2">
                                                <label class="form-label text-dark">Local</label>
                                                <input type="text" name="local" value="<?= htmlspecialchars($jogo['local'] ?? '') ?>" class="form-control form-control-sm" placeholder="Local" required>
                                            </div>

                                            <div class="col-md-2 d-flex gap-2">
                                                <button class="btn btn-sm btn-success w-100">Salvar</button>
                                                <a href="/campeonato_esportivo/routes/adms/excluir_partida.php?id=<?= $jogo['id'] ?>&campeonato_id=<?= $campeonato['id'] ?>"
                                                    class="btn btn-sm btn-outline-danger">X</a>
                                            </div>
                                        </form>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p class="text-muted">Nenhuma partida cadastrada.</p>
                                <?php endif; ?>

                                <!-- NOVA PARTIDA -->
                                <form method="POST" action="/campeonato_esportivo/routes/adms/adicionar_partida.php" class="row g-2 mt-3">
                                    <input type="hidden" name="rodada_id" value="<?= $rodada['id'] ?>">
                                    <input type="hidden" name="campeonato_id" value="<?= $campeonato['id'] ?>">

                                    <div class="col-md-2">
                                        <label class="form-label text-dark">Casa</label>
                                        <select name="time_casa" class="form-select form-select-sm" required>
                                            <?php foreach ($model->listarTimesPorCampeonato($campeonato['id']) as $time): ?>
                                                <option value="<?= $time['id'] ?>"><?= htmlspecialchars($time['nome']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label text-dark">Visitante</label>
                                        <select name="time_fora" class="form-select form-select-sm" required>
                                            <?php foreach ($model->listarTimesPorCampeonato($campeonato['id']) as $time): ?>
                                                <option value="<?= $time['id'] ?>"><?= htmlspecialchars($time['nome']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label text-dark">Data</label>
                                        <input type="date" name="data" class="form-control form-control-sm" required>
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label text-dark">Hora</label>
                                        <input type="time" name="horario" class="form-control form-control-sm" required>
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label text-dark">Local</label>
                                        <input type="text" name="local" class="form-control form-control-sm" required>
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label d-none d-md-block">&nbsp;</label>
                                        <button class="btn btn-sm btn-primary w-100">+ Jogo</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>


            

<!-- Nova Rodada -->
<h4 class="text-dark">Nova Rodada</h4>
<form method="POST" action="/campeonato_esportivo/routes/adms/adicionar_rodada.php" class="row g-3">
    <input type="hidden" name="campeonato_id" value="<?= $campeonato['id'] ?>">

    <div class="col-md-2">
        <label class="text-dark">Nº</label>
        <input type="number" name="numero" class="form-control" required>
    </div>

    <div class="col-md-2">
        <label class="text-dark">Tipo</label>
        <select name="tipo" class="form-select" required>
            <option value="Ida">Ida</option>
            <option value="Volta">Volta</option>
        </select>
    </div>

    <div class="col-md-3">
        <label class="text-dark">Fase</label>
        <select name="fase_id" class="form-select" required>
            <?php foreach ($model->listarFasesDoCampeonato($campeonato['id']) as $fase): ?>
                <option value="<?= $fase['id'] ?>"><?= htmlspecialchars($fase['nome']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md-3">
        <label class="text-dark">Descrição</label>
        <input type="text" name="descricao" class="form-control">
    </div>

    <div class="col-md-1">
        <label class="text-dark">Data</label>
        <input type="date" name="data" class="form-control" required>
    </div>

    <div class="col-md-1">
        <label class="text-dark">Hora</label>
        <input type="time" name="hora" class="form-control" required>
    </div>

    <div class="col-12">
        <button class="btn btn-success">Adicionar Rodada</button>
    </div>
</form>
</div>
</main>

<div class="mt-5">
    <?php include __DIR__ . '/../cabecalho/footer.php'; ?>
    <script src="/campeonato_esportivo/assets/js/bootstrap.bundle.min.js"></script>
</div>

</body>