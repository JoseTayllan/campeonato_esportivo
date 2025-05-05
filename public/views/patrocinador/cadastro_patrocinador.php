<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../app/middleware/verifica_sessao.php';
require_once __DIR__ . '/../../includes/assinatura_patrocinador_sec.php';

// 🔐 Impede reenvio do cadastro se já tiver empresa
$usuario_id = $_SESSION['usuario_id'] ?? null;

if ($usuario_id) {
    $verifica = $conn->prepare("SELECT id FROM patrocinadores WHERE usuario_id = ?");
    $verifica->bind_param("i", $usuario_id);
    $verifica->execute();
    $res = $verifica->get_result();

    if ($res->num_rows > 0) {
        header("Location: /campeonato_esportivo/routes/patrocinador/patrocinador_dashboard.php");
        exit;
    }
}

// Buscar times disponíveis para vínculo
$times = [];
$result = $conn->query("SELECT id, nome FROM times ORDER BY nome ASC");
while ($row = $result->fetch_assoc()) {
    $times[] = $row;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Patrocinador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="card p-4 shadow">
        <h3 class="mb-4">Cadastrar Dados da Empresa Patrocinadora</h3>

        <form action="../../../routes/patrocinador/patrocinador_dashboard.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="criar_patrocinador" value="1">

            <div class="mb-3">
                <label>Nome da Empresa</label>
                <input type="text" name="nome_empresa" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Contrato</label>
                <input type="text" name="contrato" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Valor Investido</label>
                <input type="number" step="0.01" name="valor_investido" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Logo da Empresa (opcional)</label>
                <input type="file" name="logo" class="form-control">
            </div>

            <div class="mb-3">
                <label>Vincular a um Time</label>
                <select name="time_id" class="form-control">
                    <option value="">-- Nenhum --</option>
                    <?php foreach ($times as $time): ?>
                        <option value="<?= $time['id'] ?>"><?= htmlspecialchars($time['nome']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Cadastrar e Vincular</button>
        </form>
    </div>
</div>

</body>
</html>
