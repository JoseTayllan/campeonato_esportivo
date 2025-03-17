<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Jogador</title>
    <link href="../../assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2 class="mb-4">Cadastro de Jogador</h2>
        
        <?php include 'partials/mensagens.php'; ?>

        <form action="../controllers/JogadorController.php" method="POST">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome do Jogador</label>
                <input type="text" class="form-control" name="nome" required>
            </div>
            <div class="mb-3">
                <label for="idade" class="form-label">Idade</label>
                <input type="number" class="form-control" name="idade" required>
            </div>
            <div class="mb-3">
                <label for="nacionalidade" class="form-label">Nacionalidade</label>
                <input type="text" class="form-control" name="nacionalidade">
            </div>
            <div class="mb-3">
                <label for="posicao" class="form-label">Posição</label>
                <select class="form-control" name="posicao" required>
                    <option value="goleiro">Goleiro</option>
                    <option value="zagueiro">Zagueiro</option>
                    <option value="lateral">Lateral</option>
                    <option value="meia">Meia</option>
                    <option value="atacante">Atacante</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="contrato_inicio" class="form-label">Início do Contrato</label>
                <input type="date" class="form-control" name="contrato_inicio">
            </div>
            <div class="mb-3">
                <label for="contrato_fim" class="form-label">Fim do Contrato</label>
                <input type="date" class="form-control" name="contrato_fim">
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>
    <script src="../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
