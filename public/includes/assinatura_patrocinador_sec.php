<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../config/database.php';

$mostrarCadastrarEmpresa = true;
if (isset($_SESSION['usuario_id'])) {
    $idUsuario = $_SESSION['usuario_id'];
    $stmt = $conn->prepare("SELECT id FROM patrocinadores WHERE usuario_id = ?");
    $stmt->bind_param("i", $idUsuario);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res && $res->num_rows > 0) {
        $mostrarCadastrarEmpresa = false;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Campeonatos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/campeonato_esportivo/public/assets/css/global.css" rel="stylesheet">
    <link href="/campeonato_esportivo/public/assets/css/admin.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg shadow-sm" style="background-color: var(--primary-color);">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="/campeonato_esportivo/public">
                <img src="/campeonato_esportivo/assets/img/logo_raiz.png" alt="Raiz de Craque" class="logo-navbar me-2">
                <span class="fw-bold text-creme">Raiz de Craque</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <?php if (isset($_SESSION['usuario_nome'])): ?>
                    <span class="navbar-text me-3 fw-semibold">
                        <i class="bi bi-person-circle me-1"></i>Olá, <?= htmlspecialchars($_SESSION['usuario_nome']) ?>
                    </span>
                    <?php
                    $tipo_assinatura = $_SESSION['usuario']['tipo_assinatura'] ?? null;
                    $tipo_usuario = $_SESSION['usuario']['tipo'] ?? null;

                    if ($tipo_assinatura === 'completo' && $tipo_usuario === 'Patrocinador') {
                        $link = '/campeonato_esportivo/routes/patrocinador/patrocinador_dashboard.php';
                    }
                    ?>

                    <?php if ($link): ?>
                        <a href="<?= $link ?>" class="btn btn-outline-warning btn-sm me-2">
                            <i class="bi bi-arrow-left-circle me-1"></i> Painel
                        </a>
                    <?php endif; ?>
                <a href="/campeonato_esportivo/routes/logout.php" class="btn btn-outline-light btn-sm">
                    <i class="bi bi-box-arrow-right me-1"></i>Sair
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<!-- Menu Horizontal -->
<div class="container-fluid py-2 border-bottom shadow-sm menu-container" style="background-color: var(--primary-color);">
    <div class="d-flex flex-row flex-nowrap menu-scroll px-2 gap-2">
    <?php if ($mostrarCadastrarEmpresa): ?>
            <a href="/campeonato_esportivo/routes/patrocinador/patrocinador_dashboard.php?acao=cadastrar" class="menu-link flex-shrink-0">
                <i class="bi bi-building-add me-2"></i> Cadastrar Empresa
            </a>
        <?php else: ?>
            <a href="/campeonato_esportivo/routes/patrocinador/vincular_time.php" class="menu-link flex-shrink-0">
                <i class="bi bi-link-45deg me-2"></i> Vincular a Outro Time
            </a>
            <a href="/campeonato_esportivo/routes/patrocinador/editar_banner.php" class="menu-link flex-shrink-0">
                <i class="bi bi-image me-2"></i> Atualizar Banner
            </a>
        <?php endif; ?>

    </div>
</div>
