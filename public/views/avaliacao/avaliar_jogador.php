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
    <title>Avaliação de Jogador</title>
    <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class="container mt-4">
    <h2 class="mb-4">Avaliação de Jogador</h2>

    <?php include '../partials/mensagens.php'; ?>

    <form action="../../../routes/avaliacoes.php" method="POST">
        <div class="mb-3">
            <label for="jogador_id" class="form-label">Jogador</label>
            <select class="form-control" name="jogador_id" required>
                <option value="">Selecione um jogador</option>
                <?php
                $query = "SELECT id, nome FROM jogadores";
                $result = $conn->query($query);
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['nome']}</option>";
                }
                ?>
            </select>
        </div>

        <!-- Novo Campo: Selecionar Olheiro -->
        <div class="mb-3">
            <label for="olheiro_id" class="form-label">Olheiro Responsável</label>
            <select class="form-control" name="olheiro_id" required>
                <option value="">Selecione um olheiro</option>
                <?php
                $queryOlheiros = "SELECT id, nome FROM usuarios WHERE tipo = 'Olheiro'";
                $resultOlheiros = $conn->query($queryOlheiros);
                while ($row = $resultOlheiros->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['nome']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="forca" class="form-label">Força (0 a 10) - Opcional</label>
            <input type="number" class="form-control" name="forca" min="0" max="10">
        </div>

        <div class="mb-3">
            <label for="velocidade" class="form-label">Velocidade (0 a 10) - Opcional</label>
            <input type="number" class="form-control" name="velocidade" min="0" max="10">
        </div>

        <div class="mb-3">
            <label for="drible" class="form-label">Drible (0 a 10) - Opcional</label>
            <input type="number" class="form-control" name="drible" min="0" max="10">
        </div>

        <div class="mb-3">
            <label for="finalizacao" class="form-label">Finalização (0 a 10) - Opcional</label>
            <input type="number" class="form-control" name="finalizacao" min="0" max="10">
        </div>

        <div class="mb-3">
            <label for="nota_geral" class="form-label">Nota Geral (0 a 10) - Opcional</label>
            <input type="number" class="form-control" name="nota_geral" min="0" max="10" step="0.1">
        </div>

        <div class="mb-3">
            <label for="observacoes" class="form-label">Observações</label>
            <textarea class="form-control" name="observacoes" placeholder="Observações sobre o jogador..." required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Avaliação</button>
    </form>
</div>

<?php include '../cabecalho/footer.php'; ?>
<script src="../../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
