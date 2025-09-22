<?php
session_start();

require_once __DIR__ . '/../config/database.php';

require_once __DIR__ . '/../app/controllers/IndexPublicoController.php';
$modalidade = $_GET['modalidade'] ?? null;

if ($modalidade) {
    // normalizar valores amigáveis da URL
    $map = [
        "pingpong" => "Ping-Pong",
        "futebol" => "Futebol",
        "basquete" => "Basquete",
        // pode expandir depois
    ];
    $modalidade = $map[strtolower($modalidade)] ?? $modalidade;
}


// Instanciar controller
$controller = new IndexPublicoController($conn);

// Carregar campeonatos
$campeonatosAtivos = $controller->listarCampeonatosPorEsporte($modalidade);
$campeonatosFinalizados = $controller->listarCampeonatosFinalizados($modalidade);

// Definir título
$tituloModalidade = $modalidade ? "Campeonatos de " . ucfirst($modalidade) : "Campeonatos Esportivos";

include_once __DIR__ . '/includes/header_index.php';
?>

<div class="container mt-4">
    <link rel="stylesheet" href="/campeonato_esportivo/public/assets/css/global.css">

    <!-- 🔥 Carrossel -->
    <div id="carrossel-artes" class="carousel slide mb-4" data-bs-ride="carousel" data-bs-interval="4000">
        <div class="carousel-inner rounded shadow-sm">
            <div class="carousel-item active">
                <img src="/campeonato_esportivo/assets/img/carrosselW.webp" class="d-block w-100" alt="Arte 1">
            </div>
            <div class="carousel-item">
                <img src="/campeonato_esportivo/assets/img/ArteFPMs.png" class="d-block w-100" alt="Arte 2">
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

    <h2 class="mb-4 text-verde"><?= $tituloModalidade ?></h2>

    <div class="mb-4 d-flex flex-wrap gap-2">
        <a href="/campeonato_esportivo/routes/public/placar_publico.php<?= $modalidade ? "?modalidade=$modalidade" : "" ?>"
            class="btn btn-outline-success">📻 Ver Placar Ao Vivo</a>

        <a href="/campeonato_esportivo/routes/login.php" class="btn btn-outline-dark">🔐 Acessar Sistema</a>

        <?php
        $tipo = $_SESSION['usuario']['tipo_assinatura'] ?? null;
        if ($tipo === 'admin' || $tipo === 'completo') {
            $link = '/campeonato_esportivo/routes/admin_visual/dashboard_administrador.php';
        } elseif ($tipo === 'time') {
            $link = '/campeonato_esportivo/routes/time/dashboard_time.php';
        } elseif ($tipo === 'olheiro') {
            $link = '/campeonato_esportivo/public/views/dashboard/dashboard_olheiro.php';
        } else {
            $link = null;
        }
        if ($link):
        ?>
            <a href="<?= $link ?>" class="btn btn-outline-warning">👤 Voltar ao Painel</a>
        <?php endif; ?>

        <?php if ($modalidade): ?>
            <a href="/campeonato_esportivo/public/" class="btn btn-outline-primary">🔙 Todos os Esportes</a>
        <?php endif; ?>
    </div>

    <!-- 🟢 Campeonatos em Andamento -->
    <h4 class="text-success mt-4">Campeonatos em Andamento</h4>
    <?php if (empty($campeonatosAtivos)): ?>
        <div class="alert alert-info">Nenhum campeonato em andamento.</div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($campeonatosAtivos as $camp): ?>
                <div class="col-md-4">
                    <div class="card mb-3 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($camp['nome']) ?></h5>
                            <p class="card-text">
                                Temporada: <?= htmlspecialchars($camp['temporada']) ?><br>
                                Formato: <?= htmlspecialchars($camp['formato']) ?><br>
                                Modalidade: <?= htmlspecialchars($camp['modalidade']) ?>
                            </p>

                            <?php if ($modalidade === "Ping-Pong"): ?>
                                <a href="/ping-pong/index.php?r=campeonato_publico&id=<?= $camp['id'] ?>"
                                    class="btn btn-sm btn-outline-primary">Ver Campeonato</a>
                            <?php else: ?>
                                <a href="/campeonato_esportivo/routes/public/campeonato_publico.php?id=<?= $camp['id'] ?>"
                                    class="btn btn-sm btn-outline-primary">Ver Campeonato</a>
                            <?php endif; ?>



                            <?php if ($modalidade === "Ping-Pong"): ?>
                                <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario']['tipo'] === 'Jogador'): ?>
                                    <!-- Jogador logado → pode se inscrever -->
                                    <a href="/ping-pong/index.php?r=inscricao_show&campeonato=<?= $camp['id'] ?>"
                                        class="btn btn-sm btn-success">Participar</a>

                                <?php else: ?>
                                    <!-- Visitante → pede cadastro -->
                                    <a href="/ping-pong/index.php?r=jogadores_cadastro"
                                        class="btn btn-sm btn-warning">Cadastrar-se</a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- 🔴 Campeonatos Finalizados -->
    <?php if (!empty($campeonatosFinalizados)): ?>
        <h4 class="text-danger mt-5">🏆 Campeonatos Finalizados</h4>
        <div class="row">
            <?php foreach ($campeonatosFinalizados as $camp): ?>
                <div class="col-md-4">
                    <div class="card mb-3 shadow-sm border-danger">
                        <div class="card-body">
                            <h5 class="card-title text-danger"><?= htmlspecialchars($camp['nome']) ?></h5>
                            <p class="card-text">
                                Temporada: <?= htmlspecialchars($camp['temporada']) ?><br>
                                Formato: <?= htmlspecialchars($camp['formato']) ?><br>
                                Modalidade: <?= htmlspecialchars($camp['modalidade']) ?>
                            </p>
                            <a href="/campeonato_esportivo/routes/public/dashboard_campeao.php?campeonato_id=<?= $camp['id'] ?>"
                                class="btn btn-sm btn-outline-danger">🏆 Ver Campeão</a>
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