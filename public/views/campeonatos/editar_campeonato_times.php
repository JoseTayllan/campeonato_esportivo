<?php require_once __DIR__ . '/../../includes/admin_sec.php'; ?>

<main class="flex-grow-1">
    <div class="container mt-4">
        <h2 class="text-dark">Times do Campeonato</h2>

        <!-- Bloco de mensagens -->
        <?php if (!empty($_SESSION['mensagem_sucesso'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['mensagem_sucesso']; unset($_SESSION['mensagem_sucesso']); ?>
            </div>
        <?php elseif (!empty($_SESSION['mensagem_erro'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['mensagem_erro']; unset($_SESSION['mensagem_erro']); ?>
            </div>
        <?php endif; ?>

        <ul class="list-group mb-3">
            <?php foreach ($model->listarTimesPorCampeonato($campeonato['id']) as $time): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?= htmlspecialchars($time['nome']) ?>
                    <a href="/campeonato_esportivo/routes/adms/remover_time.php?campeonato_id=<?= $campeonato['id'] ?>&time_id=<?= $time['id'] ?>" class="btn btn-sm btn-danger">
                        Remover
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>

        <!-- Vincular time existente -->
        <form method="POST" action="/campeonato_esportivo/routes/adms/adicionar_time.php" class="d-flex align-items-center gap-2 mb-3">
            <input type="hidden" name="campeonato_id" value="<?= $campeonato['id'] ?>">
            <select name="time_id" class="form-select w-auto" required>
                <?php foreach ($model->buscarTimesDisponiveis($campeonato['id']) as $time): ?>
                    <option value="<?= $time['id'] ?>"><?= htmlspecialchars($time['nome']) ?></option>
                <?php endforeach; ?>
            </select>
            <button class="btn btn-primary">Vincular Time</button>
        </form>

        <!-- Vincular via código -->
        <form method="POST" action="/campeonato_esportivo/routes/adms/adicionar_time_codigo.php" class="d-flex align-items-center gap-2">
            <input type="hidden" name="campeonato_id" value="<?= $campeonato['id'] ?>">
            <input type="text" name="codigo_publico" class="form-control w-auto" placeholder="Código do time (ex: T-0001)" required>
            <button class="btn btn-secondary">Vincular pelo Código</button>
        </form>
    </div>
</main>

<div class="mt-5">
    <?php include __DIR__ . '/../cabecalho/footer.php'; ?>
    <script src="/campeonato_esportivo/assets/js/bootstrap.bundle.min.js"></script>
</div>

</body>
