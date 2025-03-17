<?php 
session_start();
?>
<?php include 'cabecalho/header.php'; ?>
<?php include 'cabecalho/tabela.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Time</title>
    <link href="../../assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<!-- Link do Bootstrap JS (caso necessário) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <div class="container mt-4">
        <h2 class="mb-4">Cadastro de Time</h2>
        
        <?php include 'partials/mensagens.php'; ?>

        <form action="../controllers/TimeController.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome do Time</label>
                <input type="text" class="form-control" name="nome" required>
            </div>
            <div class="mb-3">
                <label for="escudo" class="form-label">Escudo do Time</label>
                <input type="file" class="form-control" name="escudo">
            </div>
            <div class="mb-3">
                <label for="cidade" class="form-label">Cidade</label>
                <input type="text" class="form-control" name="cidade" required>
            </div>
            <div class="mb-3">
                <label for="estadio" class="form-label">Estádio</label>
                <input type="text" class="form-control" name="estadio">
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>
    <?php include 'cabecalho/footer.php'; ?>
    <script src="../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
