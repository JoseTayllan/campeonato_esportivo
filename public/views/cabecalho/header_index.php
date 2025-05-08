<?php
session_start()
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
    <link href="/campeonato_esportivo/public/assets/css/index.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="/campeonato_esportivo/public/index.php">
            <i class="bi bi-house-door-fill me-2"></i> Início
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <?php if (isset($_SESSION['usuario']['nome'])): ?>
                <span class="navbar-text me-3 fw-semibold text-white">
                    <i class="bi bi-person-circle me-1"></i>Olá, <?= htmlspecialchars($_SESSION['usuario']['nome']) ?>
                </span>
                <a href="/campeonato_esportivo/routes/logout.php" class="btn btn-outline-light btn-sm">
                    <i class="bi bi-box-arrow-right me-1"></i> Sair
                </a>
            <?php else: ?>
                <a href="/campeonato_esportivo/public/views/login/login.php" class="btn btn-outline-light btn-sm">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Entrar
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<!-- Menu horizontal com botão de painel por tipo -->
<div class="container-fluid bg-dark py-2 border-bottom shadow-sm">
    <div class="d-flex flex-row flex-nowrap justify-content-center overflow-auto px-3">
        <?php
            $tipo = $_SESSION['usuario']['tipo_assinatura'] ?? null;
            $link = null;

            if ($tipo === 'admin' || $tipo === 'completo') {
                $link = '/campeonato_esportivo/routes/admin_visual/dashboard_administrador.php';
            } elseif ($tipo === 'time') {
                $link = '/campeonato_esportivo/public/views/dashboard/dashboard_time.php';
            }
        ?>
        <?php if ($link): ?>
            <a href="<?= $link ?>" class="nav-link text-white px-4 border-end border-light">
                <i class="bi bi-arrow-left me-2"></i>Voltar ao Painel
            </a>
        <?php endif; ?>

        <a href="/campeonato_esportivo/public/views/campeonatos/visualizar_fases_rodadas.php" class="nav-link text-white px-4 border-end border-light">
            <i class="bi bi-calendar3 me-2"></i>Fases e Rodadas
        </a>
        <a href="/campeonato_esportivo/public/views/campeonatos/tabela_classificacao.php" class="nav-link text-white px-4">
            <i class="bi bi-trophy me-2"></i>Classificação
        </a>
    </div>
</div>