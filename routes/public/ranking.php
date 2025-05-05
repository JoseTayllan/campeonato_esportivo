<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/controllers/RankingController.php';

$controller = new RankingController($conn);
$dados = $controller->dadosDoRanking();

require_once __DIR__ . '/../../public/views/public/ranking.php';
 