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
    <title>Gerenciamento de Campeonatos</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #343a40 !important;
        }
        .navbar-brand, .nav-link {
            color: #ffffff !important;
        }
        .nav-link:hover {
            color: #d1d1d1 !important;
        }
    </style>
</head>
<body>

<!-- Navbar (padrão escuro com ícones Bootstrap) -->
<nav class="navbar navbar-expand-lg bg-dark navbar-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <i class="bi bi-house-door-fill me-2"></i> Início
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <?php if (isset($_SESSION['usuario_nome'])): ?>
                <span class="navbar-text text-white me-3 fw-semibold">
                    <i class="bi bi-person-circle me-1"></i> Olá, <?= htmlspecialchars($_SESSION['usuario_nome']) ?>
                </span>
                <a href="../routes/logout.php" class="btn btn-outline-light btn-sm">
                    <i class="bi bi-box-arrow-right me-1"></i> Sair
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>


<!-- Bootstrap Icons (adicione isso no <head> se ainda não tiver) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<!-- Menu com ícones e separadores -->
<div class="container-fluid bg-dark py-2 border-bottom shadow-sm">
    <div class="d-flex flex-row flex-nowrap justify-content-center overflow-auto px-3">
        <a href="views/cadastro/cadastro_usuario.php" class="nav-link text-white px-4 border-end border-light">
            <i class="bi bi-person-plus me-2"></i>Cadastro de Usuário
        </a>
        <a href="views/login/login.php" class="nav-link text-white px-4 border-end border-light">
            <i class="bi bi-box-arrow-in-right me-2"></i>Login
        </a>
        <a href="views/campeonatos/visualizar_fases_rodadas.php" class="nav-link text-white px-4 border-end border-light">
            <i class="bi bi-calendar3 me-2"></i>Fases e Rodadas
        </a>
        <a href="views/campeonatos/tabela_classificacao.php" class="nav-link text-white px-4">
            <i class="bi bi-trophy me-2"></i>Classificação
        </a>
    </div>
</div>



<!-- Carrossel Rotativo com Degradê Suave -->
<div class="position-relative" style="height: 300px;">
    <!-- Fundo com Degradê -->
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(to bottom, #0d0d0d, #f8f9fa); z-index: 0;"></div>

    <!-- Carrossel com altura fixa para visual -->
    <div id="carouselBanner" class="carousel slide position-relative h-100" data-bs-ride="carousel" style="z-index: 1;">
        <div class="carousel-inner h-100">
            <div class="carousel-item active h-100">
                <div class="d-flex align-items-center justify-content-center h-100">
                    <h2 class="text-white">Banner 1 (exemplo)</h2>
                </div>
            </div>
            <div class="carousel-item h-100">
                <div class="d-flex align-items-center justify-content-center h-100">
                    <h2 class="text-white">Banner 2</h2>
                </div>
            </div>
            <div class="carousel-item h-100">
                <div class="d-flex align-items-center justify-content-center h-100">
                    <h2 class="text-white">Banner 3</h2>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselBanner" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselBanner" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</div>


