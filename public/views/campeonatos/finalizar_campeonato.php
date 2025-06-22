<?php include_once __DIR__ . '/../../includes/admin_header.php'; ?>

<main class="container mt-5">
    <h2 class="mb-4" style="color: black;">Finalizar Campeonato</h2>

    <?php if (!empty($mensagem)): ?>
        <div class="alert alert-info"><?= htmlspecialchars($mensagem) ?></div>
    <?php endif; ?>

    <form method="GET" class="mb-4">
        <div class="mb-3">
            <label for="campeonato_id" class="form-label" style="color: black;">Selecione o Campeonato</label>
            <select name="campeonato_id" id="campeonato_id" class="form-select" onchange="this.form.submit()">
                <option value="">Selecione...</option>
                <?php foreach ($campeonatos as $camp) : ?>
                    <option value="<?= $camp['id'] ?>" <?= isset($_GET['campeonato_id']) && $_GET['campeonato_id'] == $camp['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($camp['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>

    <?php if (!empty($times)) : ?>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="campeonato_id" value="<?= htmlspecialchars($_GET['campeonato_id']) ?>">

            <div class="mb-3">
                <label for="campeao_id" class="form-label" style="color: black;">Selecione o Time Campeão</label>
                <select name="campeao_id" id="campeao_id" class="form-select" required onchange="mostrarUploadElenco()">
                    <option value="">Selecione...</option>
                    <?php foreach ($times as $time) : ?>
                        <option value="<?= $time['id'] ?>"><?= htmlspecialchars($time['nome']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Upload do banner elenco (inicialmente escondido) -->
            <div id="uploadElenco" class="mb-3" style="display: none;">
                <label for="elenco" class="form-label" style="color: black;">📸 Foto do Elenco do Time Campeão</label>
                <input type="file" name="elenco" id="elenco" class="form-control" accept="image/*">
            </div>

            <button type="submit" class="btn btn-success">Finalizar Campeonato</button>
        </form>
    <?php endif; ?>
</main>

<script>
function mostrarUploadElenco() {
    const select = document.getElementById('campeao_id');
    const upload = document.getElementById('uploadElenco');
    if (select.value !== '') {
        upload.style.display = 'block';
    } else {
        upload.style.display = 'none';
    }
}
</script>

<?php include __DIR__ . '/../cabecalho/footer.php'; ?>
