<?php if (!isset($elenco)) { die('Acesso direto não permitido.'); } ?>
<?php include_once __DIR__ . '/../../includes/olheiro_sec.php'; ?>
<link href="../../../assets/css/bootstrap.min.css" rel="stylesheet">

<?php if (!isset($elenco)) { die('Acesso direto não permitido.'); } ?>

<div class="container mt-4">
    <h2 class="mb-4">Avaliar Jogador</h2>

    <form method="POST">
        <div class="mb-3">
            <label for="jogador_id" class="form-label">Jogador</label>
            <select name="jogador_id" id="jogador_id" class="form-control" required>
                <option value="">Selecione um jogador</option>
                <?php foreach ($elenco as $jogador): ?>
                    <option value="<?= $jogador['id'] ?>"><?= $jogador['nome'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <?php foreach (['forca','velocidade','drible','finalizacao'] as $campo): ?>
            <div class="mb-3">
                <label class="form-label"><?= ucfirst($campo) ?></label>
                <input type="number" name="<?= $campo ?>" class="form-control" min="0" max="10" required>
            </div>
        <?php endforeach; ?>

        <div class="mb-3">
            <label class="form-label">Nota Geral</label>
            <input type="number" step="0.1" name="nota_geral" class="form-control" min="0" max="10" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Observações</label>
            <textarea name="observacoes" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Salvar Avaliação</button>
    </form>
</div>

<?php include __DIR__ . '../../cabecalho/footer.php'; ?>
<script src="../../../assets/js/bootstrap.bundle.min.js"></script>
