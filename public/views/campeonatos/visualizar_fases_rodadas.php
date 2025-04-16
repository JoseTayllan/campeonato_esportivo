<?php
session_start();
$restrito_para = ['Administrador', 'Organizador'];
require_once __DIR__ . '/../../../app/middleware/verifica_sessao.php';
require_once __DIR__ . '/../../../config/database.php';
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
    <title>Visualizar Fases e Rodadas</title>
    <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h2 class="mb-4 text-center">Fases e Rodadas do Campeonato</h2>

    <!-- Formulário de seleção de campeonato -->
    <form method="GET" class="mb-4">
        <label for="campeonato_id" class="form-label">Selecione um Campeonato</label>
        <select name="campeonato_id" class="form-control" onchange="this.form.submit()" required>
            <option value="">Escolha um campeonato</option>
            <?php
            $campeonatoSelecionado = $_GET['campeonato_id'] ?? '';
            $query = "SELECT id, nome FROM campeonatos ORDER BY nome ASC";
            $result = $conn->query($query);
            while ($row = $result->fetch_assoc()) {
                $selected = ($row['id'] == $campeonatoSelecionado) ? 'selected' : '';
                echo "<option value='{$row['id']}' $selected>{$row['nome']}</option>";
            }
            ?>
        </select>
    </form>

    <?php if (!empty($campeonatoSelecionado)): ?>
        <?php
        // Buscar fases
        $queryFases = "SELECT id, nome, ordem FROM fases_campeonato WHERE campeonato_id = ? ORDER BY ordem ASC";
        $stmtFase = $conn->prepare($queryFases);
        $stmtFase->bind_param("i", $campeonatoSelecionado);
        $stmtFase->execute();
        $resultFases = $stmtFase->get_result();

        if ($resultFases->num_rows > 0):
            while ($fase = $resultFases->fetch_assoc()):
                ?>
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                        <strong><?= htmlspecialchars($fase['nome']) ?> (Ordem <?= $fase['ordem'] ?>)</strong>
                    </div>
                    <div class="card-body">
                        <?php
                        $queryRodadas = "SELECT numero, tipo, descricao FROM rodadas WHERE fase_id = ? ORDER BY numero ASC";
                        $stmtRodada = $conn->prepare($queryRodadas);
                        $stmtRodada->bind_param("i", $fase['id']);
                        $stmtRodada->execute();
                        $resultRodadas = $stmtRodada->get_result();

                        if ($resultRodadas->num_rows > 0): ?>
                            <ul class="list-group">
                                <?php while ($rodada = $resultRodadas->fetch_assoc()): ?>
                                    <li class="list-group-item">
                                        <strong>Rodada <?= $rodada['numero'] ?>:</strong>
                                        <?= htmlspecialchars($rodada['tipo']) ?>
                                        <?php if (!empty($rodada['descricao'])): ?>
                                            - <?= htmlspecialchars($rodada['descricao']) ?>
                                        <?php endif; ?>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        <?php else: ?>
                            <div class="text-muted">Nenhuma rodada cadastrada nesta fase.</div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile;
        else: ?>
            <div class="alert alert-warning">Nenhuma fase encontrada para este campeonato.</div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php include '../cabecalho/footer.php'; ?>
<script src="../../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
