<?php include_once __DIR__ . '/../../includes/admin_sec.php'; ?>
<link href="../../../assets/css/bootstrap.min.css" rel="stylesheet">
<div class="container mt-5">
    <h2 class="text-center mb-4">Cadastro de Time</h2>

    <?php if (!empty($_SESSION['mensagem_sucesso'])): ?>
        <div class="alert alert-success"><?= $_SESSION['mensagem_sucesso']; unset($_SESSION['mensagem_sucesso']); ?></div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['mensagem_erro'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['mensagem_erro']; unset($_SESSION['mensagem_erro']); ?></div>
    <?php endif; ?>

    <form method="POST" action="/campeonato_esportivo/routes/time/team.php" enctype="multipart/form-data">
    <div class="mb-3">
                <label for="nome" class="form-label">Nome do Time</label>
                <input type="text" class="form-control" name="nome" placeholder="Ex: Estrela FC" required>
            </div>

            <div class="mb-3">
                <label for="escudo" class="form-label">Escudo do Time</label>
                <input type="file" class="form-control" name="escudo">
                <small class="form-text text-muted">Formatos aceitos: JPG, PNG. Tamanho recomendado: 300x300px</small>
            </div>

            <div class="mb-3">
                <label for="cidade" class="form-label">Cidade</label>
                <input type="text" class="form-control" name="cidade" placeholder="Ex: Belo Horizonte" required>
            </div>

            <div class="mb-3">
                <label for="estadio" class="form-label">Estádio</label>
                <input type="text" class="form-control" name="estadio" placeholder="Ex: Arena Central">
            </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Cadastrar Time</button>
        </div>
    </form>
</div>


<div class="mt-auto">
<div class="mt-5"></div>
<?php include __DIR__ . '../../cabecalho/footer.php'; ?>
<script src="../../../assets/js/bootstrap.bundle.min.js"></script>



   