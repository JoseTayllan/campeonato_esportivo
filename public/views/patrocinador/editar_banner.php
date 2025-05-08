<?php
session_start();
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../app/middleware/verifica_sessao.php';
require_once __DIR__ . '/../../includes/assinatura_patrocinador_sec.php';

$usuario_id = $_SESSION['usuario_id'];
$stmt = $conn->prepare("SELECT id, logo FROM patrocinadores WHERE usuario_id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$res = $stmt->get_result();
$patrocinador = $res->fetch_assoc();

if (!$patrocinador) {
    echo "<div class='container py-5'><div class='alert alert-danger'>Empresa não encontrada.</div></div>";
    exit;
}
?>

<div class="container py-5">
    <div class="card p-4 shadow">
        <h4 class="mb-4">Alterar Banner de Divulgação</h4>
        <?php if (!empty($patrocinador['logo'])): ?>
            <div class="mb-3">
                <strong>Banner atual:</strong><br>
                <img src="/<?= $patrocinador['logo'] ?>" class="img-fluid rounded" style="max-height: 160px;">
            </div>
        <?php endif; ?>

        <form action="/routes/patrocinador/atualizar_banner.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="atualizar_banner" value="1">
            <div class="mb-3">
                <label>Nova Imagem</label>
                <input type="file" name="logo" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Atualizar Banner</button>
        </form>
    </div>
</div>
