<?php
session_start();
$restrito_para = ['Administrador', 'Organizador'];
require_once __DIR__ . '/../../../app/middleware/verifica_sessao.php';
require_once __DIR__ . '/../../../config/database.php';

$campeonato_id = $_GET['campeonato_id'] ?? '';
?>

<?php include '../cabecalho/header.php'; ?>
<?php 
$tipo_usuario = strtolower(trim($_SESSION['usuario_tipo']));
if ($tipo_usuario === 'administrador') {
    include '../cabecalho/tabela_administrativa.php';
} else {
    include '../cabecalho/tabela.php';
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Rodadas</title>
    <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h2 class="mb-4 text-center">Cadastro de Rodadas por Fase</h2>

    <div class="alert alert-info">
        📌 Primeiro selecione o campeonato para visualizar as fases e cadastrar rodadas.
    </div>

    <!-- Formulário de seleção de campeonato -->
    <form method="GET" class="mb-4">
        <label for="campeonato_id" class="form-label">Selecione um Campeonato</label>
        <select name="campeonato_id" class="form-control" onchange="this.form.submit()" required>
            <option value="">Escolha um campeonato</option>
            <?php
            $query = "SELECT id, nome FROM campeonatos ORDER BY nome ASC";
            $result = $conn->query($query);
            while ($row = $result->fetch_assoc()) {
                $selected = ($row['id'] == $campeonato_id) ? 'selected' : '';
                echo "<option value='{$row['id']}' $selected>{$row['nome']}</option>";
            }
            ?>
        </select>
    </form>

    <?php if (!empty($campeonato_id)): ?>
        <?php include '../partials/mensagens.php'; ?>

        <form action="../../../routes/rodadas.php" method="POST">
            <input type="hidden" name="campeonato_id" value="<?= htmlspecialchars($campeonato_id) ?>">

            <div class="mb-3">
                <label for="fase_id" class="form-label">Fase do Campeonato</label>
                <select name="fase_id" class="form-control" required>
                    <option value="">Selecione uma fase</option>
                    <?php
                    $queryFases = "SELECT id, nome FROM fases_campeonato WHERE campeonato_id = ? ORDER BY ordem ASC";
                    $stmt = $conn->prepare($queryFases);
                    $stmt->bind_param("i", $campeonato_id);
                    $stmt->execute();
                    $resultFases = $stmt->get_result();
                    while ($fase = $resultFases->fetch_assoc()) {
                        echo "<option value='{$fase['id']}'>{$fase['nome']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="numero" class="form-label">Número da Rodada</label>
                <input type="number" name="numero" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo da Rodada</label>
                <select name="tipo" class="form-control" required>
                    <option value="Ida">Ida</option>
                    <option value="Volta">Volta</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição (opcional)</label>
                <input type="text" name="descricao" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Cadastrar Rodada</button>
        </form>
    <?php endif; ?>
</div>

<?php include '../cabecalho/footer.php'; ?>
<script src="../../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
