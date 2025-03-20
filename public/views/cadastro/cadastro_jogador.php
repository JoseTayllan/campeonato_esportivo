<?php 
session_start();
require_once __DIR__ . '/../../../config/database.php'; // Conexão com o banco
?>

<?php include '../cabecalho/header.php'; ?>
<?php include '../cabecalho/tabela.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Jogador</title>
    <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Link do Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class="container mt-4">
    <h2 class="mb-4">Cadastro de Jogador</h2>

    <?php include '../partials/mensagens.php'; ?>

    <form action="../../../routes/players.php" method="POST">
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
                <option value="Goleiro">Goleiro</option>
                <option value="Zagueiro">Zagueiro</option>
                <option value="Lateral">Lateral</option>
                <option value="Meia">Meia</option>
                <option value="Atacante">Atacante</option>
            </select>
        </div>

        <!-- Seleção de Times -->
        <div class="mb-3">
            <label for="time_id" class="form-label">Time</label>
            <select class="form-control" name="time_id" required>
                <option value="">Selecione um time</option>
                <?php
                $query = "SELECT id, nome FROM times";
                $result = $conn->query($query);
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['nome']}</option>";
                }
                ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>
</div>

<?php include '../cabecalho/footer.php'; ?>
<script src="../../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
