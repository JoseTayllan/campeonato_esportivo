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
    <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background-color: #f8f9fa;
    }

    .navbar {
        background-color: #343a40 !important;
    }

    .navbar-brand,
    .nav-link {
        color: #ffffff !important;
    }

    .nav-link:hover {
        color: #d1d1d1 !important;
    }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="../../index.php">🏠 Início</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <?php if (isset($_SESSION['usuario_nome'])): ?>
                <span class="navbar-text text-white me-3 fw-bold">
                    Olá, <?= htmlspecialchars($_SESSION['usuario_nome']) ?>
                </span>
                <!-- 🔔 AVISO PARA O DEV 2: implementar lógica de logout em routes/logout.php -->
                <a href="../../../routes/logout.php" class="btn btn-sm btn-outline-light">Sair</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>