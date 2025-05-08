<?php include_once __DIR__ . '/../../includes/admin_sec.php'; ?>
<link href="../../../assets/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <h2 class="mb-4 text-center">Cadastro de Campeonato</h2>

    <?php if (!empty($_SESSION['mensagem_sucesso'])): ?>
        <div class="alert alert-success"><?= $_SESSION['mensagem_sucesso']; unset($_SESSION['mensagem_sucesso']); ?></div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['mensagem_erro'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['mensagem_erro']; unset($_SESSION['mensagem_erro']); ?></div>
    <?php endif; ?>

    <form method="POST" action="../../../routes/adms/championships.php">
        <div class="mb-3">
            <label class="form-label">Nome do Campeonato</label>
            <input type="text" name="nome" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descrição</label>
            <textarea name="descricao" class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Temporada</label>
            <input type="number" name="temporada" class="form-control" value="<?= date('Y') ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Formato</label>
            <select name="formato" class="form-control" required>
                <option value="Pontos Corridos">Pontos Corridos</option>
                <option value="Mata-Mata">Mata-Mata</option>
                <option value="Fase de Grupos">Fase de Grupos</option>
            </select>
        </div>

        <div class="mb-3">
                <label class="form-label">Regulamento</label>
                <textarea class="form-control" name="regulamento" required></textarea>
            </div>


      
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Cadastrar Campeonato</button>
        </div>
    </form>
</div>


<div class="mt-auto">
<div class="mt-5"></div>
<?php include __DIR__ . '../../cabecalho/footer.php'; ?>
<script src="../../../assets/js/bootstrap.bundle.min.js"></script>

         
        