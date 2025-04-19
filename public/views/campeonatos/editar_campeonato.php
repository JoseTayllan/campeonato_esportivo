<?php include __DIR__ . '/../cabecalho/header.php'; ?>

<div class="container mt-4">
    <h2>Editar Campeonato</h2>

    <form action="/campeonato_esportivo/routes/campeonatos_atualizar.php" method="POST">
        <input type="hidden" name="id" value="<?= $campeonato['id'] ?>">

        <div class="mb-3">
            <label>Nome</label>
            <input type="text" name="nome" class="form-control" value="<?= $campeonato['nome'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Descrição</label>
            <textarea name="descricao" class="form-control"><?= $campeonato['descricao'] ?></textarea>
        </div>

        <div class="mb-3">
            <label>Temporada</label>
            <input type="text" name="temporada" class="form-control" value="<?= $campeonato['temporada'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Formato</label>
            <select name="formato" class="form-select">
                <option <?= $campeonato['formato'] == 'Pontos Corridos' ? 'selected' : '' ?>>Pontos Corridos</option>
                <option <?= $campeonato['formato'] == 'Mata-Mata' ? 'selected' : '' ?>>Mata-Mata</option>
                <option <?= $campeonato['formato'] == 'Fase de Grupos' ? 'selected' : '' ?>>Fase de Grupos</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Modalidade</label>
            <select name="modalidade" class="form-select">
                <option <?= $campeonato['modalidade'] == 'Futebol' ? 'selected' : '' ?>>Futebol</option>
                <option <?= $campeonato['modalidade'] == 'Futsal' ? 'selected' : '' ?>>Futsal</option>
                <option <?= $campeonato['modalidade'] == '1x1' ? 'selected' : '' ?>>1x1</option>
                <option <?= $campeonato['modalidade'] == '2x2' ? 'selected' : '' ?>>2x2</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    </form>

    <!-- Times vinculados -->
    <hr class="my-4">
    <h4>Times do Campeonato</h4>

    <ul class="list-group mb-3">
        <?php foreach ($model->listarTimesPorCampeonato($campeonato['id']) as $time): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <?= htmlspecialchars($time['nome']) ?>
                <a href="/campeonato_esportivo/routes/remover_time.php?campeonato_id=<?= $campeonato['id'] ?>&time_id=<?= $time['id'] ?>" class="btn btn-sm btn-danger">Remover</a>
            </li>
        <?php endforeach; ?>
    </ul>

    <!-- Adicionar time -->
    <form method="POST" action="/campeonato_esportivo/routes/adicionar_time.php" class="d-flex align-items-center gap-2 mb-5">
        <input type="hidden" name="campeonato_id" value="<?= $campeonato['id'] ?>">
        <select name="time_id" class="form-select w-auto" required>
            <?php foreach ($model->buscarTimesDisponiveis($campeonato['id']) as $time): ?>
                <option value="<?= $time['id'] ?>"><?= htmlspecialchars($time['nome']) ?></option>
            <?php endforeach; ?>
        </select>
        <button class="btn btn-primary">Vincular Time</button>
    </form>



    <!-- Rodadas -->
    <hr class="my-4">
    <h4>Rodadas do Campeonato</h4>

    <ul class="list-group mb-3">
        <?php foreach ($model->listarRodadas($campeonato['id']) as $rodada): ?>
            <li class="list-group-item">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Rodada <?= $rodada['numero'] ?></strong> - <?= htmlspecialchars($rodada['tipo']) ?><br>
                        <?= htmlspecialchars($rodada['descricao']) ?>
                    </div>
                    <a href="/campeonato_esportivo/routes/excluir_rodada.php?id=<?= $rodada['id'] ?>&campeonato_id=<?= $campeonato['id'] ?>" class="btn btn-sm btn-danger">Excluir</a>
                </div>

                <!-- Lista de jogos da rodada -->
                <?php $partidas = $model->listarPartidasPorRodada($rodada['id']); ?>
                <?php if ($partidas): ?>
                    <ul class="mt-2">
                        <?php foreach ($partidas as $jogo): ?>
                            <li>
                                <form method="POST" action="/campeonato_esportivo/routes/editar_partida.php" class="row g-2 align-items-center">
                                    <input type="hidden" name="partida_id" value="<?= $jogo['id'] ?>">
                                    <input type="hidden" name="campeonato_id" value="<?= $campeonato['id'] ?>">

                                    <div class="col-md-3">
                                        <label>Fase</label>
                                        <select name="fase_id" class="form-select" required>
                                            <?php foreach ($model->listarFasesDoCampeonato($campeonato['id']) as $fase): ?>
                                                <option value="<?= $fase['id'] ?>"><?= htmlspecialchars($fase['nome']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>


                                    <div class="col-md-2">
                                        <select name="time_casa" class="form-select" required>
                                            <option value="">Time da Casa</option>
                                            <?php foreach ($model->listarTimesPorCampeonato($campeonato['id']) as $time): ?>
                                                <option value="<?= $time['id'] ?>" <?= $jogo['id_time_casa'] == $time['id'] ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($time['nome']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <select name="time_fora" class="form-select" required>
                                            <option value="">Time Visitante</option>
                                            <?php foreach ($model->listarTimesPorCampeonato($campeonato['id']) as $time): ?>
                                                <option value="<?= $time['id'] ?>" <?= $jogo['id_time_fora'] == $time['id'] ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($time['nome']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <input type="date" name="data" value="<?= $jogo['data'] ?>" class="form-control" required>
                                    </div>

                                    <div class="col-md-2">
                                        <input type="time" name="horario" value="<?= $jogo['horario'] ?>" class="form-control" required>
                                    </div>

                                    <div class="col-md-2">
                                        <input type="text" name="local" value="<?= htmlspecialchars($jogo['local'] ?? '') ?>" class="form-control" placeholder="Local" required>
                                    </div>



                                    <div class="col-md-2 d-flex gap-2">
                                        <button class="btn btn-sm btn-success w-100">Salvar</button>
                                        <a href="/campeonato_esportivo/routes/excluir_partida.php?id=<?= $jogo['id'] ?>&campeonato_id=<?= $campeonato['id'] ?>" class="btn btn-sm btn-outline-danger">X</a>
                                    </div>

                                </form>
                            </li>

                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted small mt-2">Nenhum jogo cadastrado ainda.</p>
                <?php endif; ?>

                <!-- Formulário para adicionar nova partida -->
                <form method="POST" action="/campeonato_esportivo/routes/adicionar_partida.php" class="row g-2 mt-2">
                    <input type="hidden" name="rodada_id" value="<?= $rodada['id'] ?>">
                    <input type="hidden" name="campeonato_id" value="<?= $campeonato['id'] ?>">

                    <div class="col-md-3">
                        <select name="time_casa" class="form-select" required>
                            <option value="">Time da Casa</option>
                            <?php foreach ($model->listarTimesPorCampeonato($campeonato['id']) as $time): ?>
                                <option value="<?= $time['id'] ?>"><?= htmlspecialchars($time['nome']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select name="time_fora" class="form-select" required>
                            <option value="">Time Visitante</option>
                            <?php foreach ($model->listarTimesPorCampeonato($campeonato['id']) as $time): ?>
                                <option value="<?= $time['id'] ?>"><?= htmlspecialchars($time['nome']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <input type="date" name="data" class="form-control" required>
                    </div>

                    <div class="col-md-2">
                        <input type="time" name="horario" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="local" class="form-control" placeholder="Local" required>
                    </div>


                    <div class="col-md-2">
                        <button class="btn btn-sm btn-primary w-100">+ Jogo</button>
                    </div>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>


    <h5>Nova Rodada</h5>
    <form method="POST" action="/campeonato_esportivo/routes/adicionar_rodada.php" class="row g-3">
        <input type="hidden" name="campeonato_id" value="<?= $campeonato['id'] ?>">

        <div class="col-md-2">
            <label>Nº</label>
            <input type="number" name="numero" class="form-control" required>
        </div>

        <div class="col-md-2">
            <label>Tipo</label>
            <select name="tipo" class="form-select" required>
                <option value="Ida">Ida</option>
                <option value="Volta">Volta</option>
            </select>
        </div>

        <div class="col-md-3">
            <label>Fase</label>
            <select name="fase_id" class="form-select" required>
                <?php foreach ($model->listarFasesDoCampeonato($campeonato['id']) as $fase): ?>
                    <option value="<?= $fase['id'] ?>"><?= htmlspecialchars($fase['nome']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>


        <div class="col-md-3">
            <label>Descrição</label>
            <input type="text" name="descricao" class="form-control">
        </div>

        <div class="col-md-1">
            <label>Data</label>
            <input type="date" name="data" class="form-control" required>
        </div>

        <div class="col-md-1">
            <label>Hora</label>
            <input type="time" name="hora" class="form-control" required>
        </div>

        <div class="col-12">
            <button class="btn btn-success">Adicionar Rodada</button>
        </div>
    </form>


</div>

<?php include __DIR__ . '/../cabecalho/footer.php'; ?>