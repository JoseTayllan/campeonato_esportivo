<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área do Time</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/campeonato_esportivo/public/assets/css/global.css" rel="stylesheet">
    <link href="/campeonato_esportivo/public/assets/css/admin.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg shadow-sm">
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
                <a href="/campeonato_esportivo/public/views/login/login.php" class="btn btn-outline-light btn-sm">
                    <i class="bi bi-box-arrow-right me-1"></i>Sair
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<!-- Menu Horizontal Secundário -->
<div class="container-fluid py-2 border-bottom shadow-sm menu-container">
    <div class="d-flex flex-row flex-nowrap justify-content-center menu-scroll px-2 gap-2">
    <a href="/campeonato_esportivo/routes/time/agenda_time.php" class="menu-link flex-shrink-0">
            <i class="bi bi-calendar-event-fill me-2"></i> Ver Agenda de Jogos
        </a>
        <a href="/campeonato_esportivo/routes/time/dashboard_time.php" class="menu-link flex-shrink-0">
            <i class="bi bi-house-door-fill me-2"></i> Painel do Time
        </a>
    </div>
</div>

