<?php 
session_start();
?>
<?php include 'cabecalho/header.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Campeonato</title>
    <link href="../../assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2 class="mb-4">Cadastro de Campeonato</h2>
        
        <?php include 'partials/mensagens.php'; ?>

        <form action="../controllers/CampeonatoController.php" method="POST">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome do Campeonato</label>
                <input type="text" class="form-control" name="nome" required>
            </div>
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea class="form-control" name="descricao" required></textarea>
            </div>
            <div class="mb-3">
                <label for="temporada" class="form-label">Temporada</label>
                <input type="number" class="form-control" name="temporada" required>
            </div>
            <div class="mb-3">
                <label for="formato" class="form-label">Formato</label>
                <select class="form-control" name="formato" required>
                    <option value="pontos_corridos">Pontos Corridos</option>
                    <option value="mata_mata">Mata-Mata</option>
                    <option value="grupos_mata_mata">Grupos + Mata-Mata</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="regulamento" class="form-label">Regulamento</label>
                <textarea class="form-control" name="regulamento" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>
    <script src="../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
