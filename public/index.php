<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/controllers/IndexPublicoController.php';

$controller = new IndexPublicoController($conn);
$campeonatosPorEsporte = $controller->listarCampeonatosPorEsporte();

include_once __DIR__ . '/includes/header_index.php';
?>

<div class="container mt-4">
    <!-- Carrossel de imagens -->
    <div id="carrossel-artes" class="carousel slide mb-4" data-bs-ride="carousel" data-bs-interval="4000">
        <div class="carousel-inner rounded shadow-sm">
            <div class="carousel-item active">
                <img src="/campeonato_esportivo/assets/img/prototipo.webp" class="d-block w-100" alt="Arte 1">
            </div>
            <div class="carousel-item">
                <img src="/campeonato_esportivo/assets/img/carrossel2.jpg" class="d-block w-100" alt="Arte 2">
            </div>
            <div class="carousel-item">
                <img src="/campeonato_esportivo/assets/img/carrossel3.jpg" class="d-block w-100" alt="Arte 3">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carrossel-artes" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carrossel-artes" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>

    <h2 class="mb-4 text-verde">Bem-vindo ao Sistema de Campeonatos Esportivos</h2>

    <div class="mb-4 d-flex flex-wrap gap-2">
        <a href="/campeonato_esportivo/routes/public/placar_publico.php" class="btn btn-outline-success">
            📻 Ver Placar Ao Vivo
        </a>
        <a href="/campeonato_esportivo/routes/login.php" class="btn btn-outline-dark">
            🔐 Acessar Sistema
        </a>
        <?php
        $tipo = $_SESSION['usuario']['tipo_assinatura'] ?? null;
        if ($tipo === 'admin' || $tipo === 'completo') {
            $link = '/campeonato_esportivo/routes/admin_visual/dashboard_administrador.php';
        } elseif ($tipo === 'time') {
            $link = '/campeonato_esportivo/public/views/dashboard/dashboard_time.php';
        } elseif ($tipo === 'olheiro') {
            $link = '/campeonato_esportivo/public/views/dashboard/dashboard_olheiro.php';
        } else {
            $link = null;
        }
        if ($link):
        ?>
        <a href="<?= $link ?>" class="btn btn-outline-warning">
            👤 Voltar ao Painel
        </a>
        <?php endif; ?>
    </div>

    <h4 class="text-verde mt-4">Campeonatos em Andamento</h4>
    <?php if (empty($campeonatosPorEsporte)): ?>
        <div class="alert alert-info">Nenhum campeonato em andamento.</div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($campeonatosPorEsporte as $camp): ?>
                <div class="col-md-4">
                    <div class="card mb-3 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($camp['nome']) ?></h5>
                            <p class="card-text">
                                Temporada: <?= htmlspecialchars($camp['temporada']) ?><br>
                                Formato: <?= htmlspecialchars($camp['formato']) ?>
                            </p>
                            <a href="/campeonato_esportivo/routes/public/campeonato_publico.php?id=<?= $camp['id'] ?>" class="btn btn-sm btn-outline-primary">
                                Ver Campeonato
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<div class="mt-auto mt-5">
    <?php include 'views/cabecalho/footer.php'; ?>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</div>
