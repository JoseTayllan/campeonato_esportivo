
<?php require_once __DIR__ . '/../../includes/assinatura_patrocinador_sec.php'; ?>

<div class="container py-5">
    <div class="card p-4 shadow">
        <h4 class="mb-4">Alterar Banner de Divulgação</h4>
        <?php if (!empty($patrocinador['logo'])): ?>
            <div class="mb-3">
                <strong>Banner atual:</strong><br>
                <img src="/campeonato_esportivo/<?= $patrocinador['logo'] ?>" class="img-fluid rounded" style="max-height: 160px;">
            </div>
        <?php endif; ?>

        <form action="/campeonato_esportivo/routes/patrocinador/atualizar_banner.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="atualizar_banner" value="1">
            <div class="mb-3">
                <label>Nova Imagem</label>
                <input type="file" name="logo" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Atualizar Banner</button>
        </form>
    </div>
</div>
