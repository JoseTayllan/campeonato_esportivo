<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/controllers/RankingCampeonatoController.php';

$campeonato_id = $_GET['campeonato_id'] ?? null;

if (!$campeonato_id) {
    echo "ID do campeonato não informado.";
    exit;
}

$controller = new RankingCampeonatoController($conn);
$dados = $controller->dadosPorCampeonato((int)$campeonato_id);

require_once __DIR__ . '/../public/views/public/ranking_campeonato.php';
 