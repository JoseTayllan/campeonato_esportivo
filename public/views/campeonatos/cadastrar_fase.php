<?php 
session_start();
$restrito_para = ['Administrador', 'Organizador'];
require_once __DIR__ . '/../../../app/middleware/verifica_sessao.php';
require_once __DIR__ . '/../../../config/database.php';
?>

<?php include '../cabecalho/header.php'; ?>
<?php include '../cabecalho/tabela.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Cadastro de Fase</title>
    <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">
    <h2 class="mb-4">Cadastrar Nova Fase</h2>

    <?php include '../partials/mensagens.php'; ?>

    <form action="../../../routes/fase_campeonato.php" method="POST">
        <!-- Selecionar Campeonato -->
        <div class="mb-3">
            <label for="campeonato_id" class="form-label">Campeonato</label>
            <select class="form-control" name="campeonato_id" required>
                <option value="">Selecione o campeonato</option>
                <?php
                $query = "SELECT id, nome FROM campeonatos ORDER BY nome";
                $result = $conn->query($query);
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['nome']}</option>";
                }
                ?>
            </select>
            <div class="form-text">Escolha o campeonato ao qual esta fase pertencerá.</div>
        </div>

        <!-- Tipo de Fase -->
        <div class="mb-3">
            <label for="nome" class="form-label">Tipo de Fase</label>
            <select class="form-control" name="nome" required>
                <option value="">Selecione o tipo de fase</option>
                <option value="Fase de Grupos">Fase de Grupos</option>
                <option value="Oitavas de Final">Oitavas de Final</option>
                <option value="Quartas de Final">Quartas de Final</option>
                <option value="Semifinal">Semifinal</option>
                <option value="Final">Final</option>
            </select>
            <div class="form-text">
                Informe a fase que está sendo adicionada ao campeonato.
            </div>
        </div>

        <!-- Ordem de Execução -->
        <div class="mb-3">
            <label for="ordem" class="form-label">Ordem de Execução</label>
            <input type="number" class="form-control" name="ordem" placeholder="Ex: 1 para Fase de Grupos" required>
            <div class="form-text">
                Defina a ordem que essa fase ocorrerá no campeonato. Por exemplo:
                <ul class="mt-1 mb-0">
                    <li><strong>1</strong> → Fase de Grupos</li>
                    <li><strong>2</strong> → Oitavas de Final</li>
                    <li><strong>3</strong> → Quartas de Final</li>
                    <li><strong>4</strong> → Semifinal</li>
                    <li><strong>5</strong> → Final</li>
                </ul>
                <span class="text-danger">
                    ✅ <strong>Importante:</strong> O campo "Tipo de Fase" define o nome da etapa, e a "Ordem de Execução" determina a sequência que será seguida pelo sistema.
                </span>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Cadastrar Fase</button>
    </form>
</div>

<?php include '../cabecalho/footer.php'; ?>
<script src="../../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
