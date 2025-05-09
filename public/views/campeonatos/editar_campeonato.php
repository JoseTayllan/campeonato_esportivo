<?php 
// Proteger contra acesso direto
if (!isset($_SERVER['HTTP_REFERER']) || empty($_SERVER['HTTP_REFERER'])) {
    echo "<div style='text-align:center; padding:20px; font-family:sans-serif;'>
            <h2 style='color:red;'>Erro: Acesso direto não permitido!</h2>
            <p>Utilize o sistema normalmente para acessar esta página.</p>
          </div>";
    exit();
} 
include __DIR__ . '../../../includes/admin_sec.php';?>   
<link rel="stylesheet" href="/campeonato_esportivo/public/assets/css/admin.css">


<div class="container mt-4 container-campeonato">
    <h2>Editar Campeonato</h2>

    <form action="/campeonato_esportivo/routes/adms/campeonatos_atualizar.php" method="POST">
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
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select">
                <option value="ativo" <?= $campeonato['status'] === 'ativo' ? 'selected' : '' ?>>Ativo</option>
                <option value="inativo" <?= $campeonato['status'] === 'inativo' ? 'selected' : '' ?>>Inativo</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    </form>

    <!-- Times vinculados -->
    <hr class="section-box">
    <h4>Times do Campeonato</h4>

    <ul class="list-group mb-3">
        <?php foreach ($model->listarTimesPorCampeonato($campeonato['id']) as $time): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <?= htmlspecialchars($time['nome']) ?>
                <a href="/campeonato_esportivo/routes/adms/remover_time.php?campeonato_id=<?= $campeonato['id'] ?>&time_id=<?= $time['id'] ?>" class="btn btn-sm btn-danger">Remover</a>
            </li>

        <?php endforeach; ?>
    </ul>


    <!-- Adicionar time -->
    <form method="POST" action="/campeonato_esportivo/routes/adms/adicionar_time.php" class="d-flex align-items-center gap-2 mb-5">
        <input type="hidden" name="campeonato_id" value="<?= $campeonato['id'] ?>">
        <select name="time_id" class="form-select w-auto" required>
            <?php foreach ($model->buscarTimesDisponiveis($campeonato['id']) as $time): ?>
                <option value="<?= $time['id'] ?>"><?= htmlspecialchars($time['nome']) ?></option>
            <?php endforeach; ?>
        </select>
        <button class="btn btn-primary">Vincular Time</button>

    </form>
        <!-- Formulário: Adicionar time via código público -->
        <form method="POST" action="/campeonato_esportivo/routes/adms/adicionar_time_codigo.php" class="d-flex align-items-center gap-2 mb-5">
            <input type="hidden" name="campeonato_id" value="<?= $campeonato['id'] ?>">
            <input type="text" name="codigo_publico" class="form-control w-auto" placeholder="Código do time (ex: T-0001)" required>
            <button class="btn btn-secondary">Vincular pelo Código</button>
        </form>




    <!-- Rodadas -->
    <hr class="section-box">
    <h4>Rodadas do Campeonato</h4>

    <div class="row gy-4">
    <?php foreach ($model->listarRodadas($campeonato['id']) as $rodada): ?>
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Rodada <?= $rodada['numero'] ?></strong> - <?= htmlspecialchars($rodada['tipo']) ?><br>
                        <small class="text-muted"><?= htmlspecialchars($rodada['descricao']) ?></small>
                    </div>
                    <a href="/campeonato_esportivo/routes/adms/excluir_rodada.php?id=<?= $rodada['id'] ?>&campeonato_id=<?= $campeonato['id'] ?>" class="btn btn-sm btn-outline-danger">Excluir</a>
                </div>

                <div class="card-body">
                    <?php $partidas = $model->listarPartidasPorRodada($rodada['id']); ?>
                    <?php if ($partidas): ?>
                        <?php foreach ($partidas as $jogo): ?>
                            <form method="POST" action="/campeonato_esportivo/routes/adms/editar_partida.php" class="row g-2 align-items-end mb-3">
                                <input type="hidden" name="partida_id" value="<?= $jogo['id'] ?>">
                                <input type="hidden" name="campeonato_id" value="<?= $campeonato['id'] ?>">

                                <div class="col-md-2">
                                    <label class="form-label">Fase</label>
                                    <select name="fase_id" class="form-select form-select-sm" required>
                                        <?php foreach ($model->listarFasesDoCampeonato($campeonato['id']) as $fase): ?>
                                            <option value="<?= $fase['id'] ?>" <?= ($jogo['fase_id'] ?? '') == $fase['id'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($fase['nome']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label">Casa</label>
                                    <select name="time_casa" class="form-select form-select-sm" required>
                                        <option value="">Selecione</option>
                                        <?php foreach ($model->listarTimesPorCampeonato($campeonato['id']) as $time): ?>
                                            <option value="<?= $time['id'] ?>" <?= $jogo['id_time_casa'] == $time['id'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($time['nome']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label">Visitante</label>
                                    <select name="time_fora" class="form-select form-select-sm" required>
                                        <option value="">Selecione</option>
                                        <?php foreach ($model->listarTimesPorCampeonato($campeonato['id']) as $time): ?>
                                            <option value="<?= $time['id'] ?>" <?= $jogo['id_time_fora'] == $time['id'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($time['nome']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label">Data</label>
                                    <input type="date" name="data" value="<?= $jogo['data'] ?>" class="form-control form-control-sm" required>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label">Hora</label>
                                    <input type="time" name="horario" value="<?= $jogo['horario'] ?>" class="form-control form-control-sm" required>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label">Local</label>
                                    <input type="text" name="local" value="<?= htmlspecialchars($jogo['local'] ?? '') ?>" class="form-control form-control-sm" placeholder="Local" required>
                                </div>

                                <div class="col-md-2 d-flex gap-2 mt-2">
                                    <button class="btn btn-sm btn-success w-100">Salvar</button>
                                    <a href="/campeonato_esportivo/routes/adms/excluir_partida.php?id=<?= $jogo['id'] ?>&campeonato_id=<?= $campeonato['id'] ?>" class="btn btn-sm btn-outline-danger">X</a>
                                </div>
                            </form>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted small">Nenhum jogo cadastrado.</p>
                    <?php endif; ?>

                    <!-- Novo jogo -->
                    <form method="POST" action="/campeonato_esportivo/routes/adms/adicionar_partida.php" class="row g-2 align-items-end">
                        <input type="hidden" name="rodada_id" value="<?= $rodada['id'] ?>">
                        <input type="hidden" name="campeonato_id" value="<?= $campeonato['id'] ?>">

                        <div class="col-md-2">
                            <label class="form-label">Casa</label>
                            <select name="time_casa" class="form-select form-select-sm" required>
                                <option value="">Time da Casa</option>
                                <?php foreach ($model->listarTimesPorCampeonato($campeonato['id']) as $time): ?>
                                    <option value="<?= $time['id'] ?>"><?= htmlspecialchars($time['nome']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Visitante</label>
                            <select name="time_fora" class="form-select form-select-sm" required>
                                <option value="">Time Visitante</option>
                                <?php foreach ($model->listarTimesPorCampeonato($campeonato['id']) as $time): ?>
                                    <option value="<?= $time['id'] ?>"><?= htmlspecialchars($time['nome']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Data</label>
                            <input type="date" name="data" class="form-control form-control-sm" required>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Hora</label>
                            <input type="time" name="horario" class="form-control form-control-sm" required>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Local</label>
                            <input type="text" name="local" class="form-control form-control-sm" required>
                        </div>

                        <div class="col-md-2 d-flex align-items-end">
                            <button class="btn btn-sm btn-primary w-100">+ Jogo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

    </form>

<?php include __DIR__ . '/../cabecalho/footer.php'; ?>