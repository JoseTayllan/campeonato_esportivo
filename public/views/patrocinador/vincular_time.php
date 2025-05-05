<?php
session_start();
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../app/middleware/verifica_sessao.php';
require_once __DIR__ . '/../../includes/assinatura_patrocinador_sec.php';

// Buscar ID da empresa vinculada ao usuário logado
$usuario_id = $_SESSION['usuario_id'];
$stmt = $conn->prepare("SELECT id FROM patrocinadores WHERE usuario_id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$res = $stmt->get_result();
$patrocinador = $res->fetch_assoc();

if (!$patrocinador) {
    echo "<div class='container py-5'><div class='alert alert-danger'>Erro: Empresa não encontrada.</div></div>";
    exit;
}

$patrocinador_id = $patrocinador['id'];

// Buscar times que ainda não foram vinculados
$sql = "
    SELECT t.id, t.nome, t.cidade
    FROM times t
    WHERE t.id NOT IN (
        SELECT time_id FROM patrocinador_time WHERE patrocinador_id = ?
    )
    ORDER BY t.nome
";

$stmt2 = $conn->prepare($sql);
$stmt2->bind_param("i", $patrocinador_id);
$stmt2->execute();
$result = $stmt2->get_result();

?>

<div class="container py-5">
    <div class="card p-4 shadow">
        <h4 class="mb-4">Vincular a um Novo Time</h4>

        <?php if ($result->num_rows === 0): ?>
            <div class="alert alert-info">Nenhum time disponível para vínculo.</div>
        <?php else: ?>
            <form method="POST" action="/campeonato_esportivo/routes/patrocinador/patrocinador_dashboard.php">
                <input type="hidden" name="vincular_time" value="1">
                <div class="mb-3">
                    <label>Escolha um Time:</label>
                    <select name="time_id" class="form-select" required>
                        <option value="">-- Selecione --</option>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <option value="<?= $row['id'] ?>">
                                <?= htmlspecialchars($row['nome']) ?> (<?= htmlspecialchars($row['cidade']) ?>)
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Vincular Time</button>
            </form>
        <?php endif; ?>
    </div>
</div>
