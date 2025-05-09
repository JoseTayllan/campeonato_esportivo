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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/campeonato_esportivo/public/assets/css/global.css" rel="stylesheet">
    <link href="/campeonato_esportivo/public/assets/css/index.css" rel="stylesheet">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg shadow-sm">
        <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="/campeonato_esportivo/public/">
                <img src="/campeonato_esportivo/assets/img/logo_raiz.png" alt="Raiz de Craque" class="logo-navbar me-2">
                <span class="fw-bold text-creme">Raiz de Craque</span>
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

                    <?php
                    $tipo_assinatura = $_SESSION['usuario']['tipo_assinatura'] ?? null;
                    $tipo_usuario = $_SESSION['usuario']['tipo'] ?? null;

                    if ($tipo_assinatura === 'completo' && $tipo_usuario === 'Olheiro') {
                        $link = '/campeonato_esportivo/public/views/avaliacao/visualizar_avaliacoes.php';
                    } elseif ($tipo_assinatura === 'completo' && $tipo_usuario === 'Administrador') {
                        $link = '/campeonato_esportivo/routes/admin_visual/dashboard_administrador.php';
                    } elseif ($tipo_assinatura === 'time') {
                        $link = '/campeonato_esportivo/public/views/dashboard/dashboard_time.php';
                    }elseif ($tipo_assinatura === 'completo' && $tipo_usuario === 'Patrocinador') {
                        $link = '/campeonato_esportivo/routes/patrocinador/patrocinador_dashboard.php';
                    } else {
                        $link = null;
                    }
                    ?>

                    <?php if ($link): ?>
                        <a href="<?= $link ?>" class="btn btn-outline-warning btn-sm me-2">
                            <i class="bi bi-arrow-left-circle me-1"></i> Painel
                        </a>
                    <?php endif; ?>

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
