<?php

require_once __DIR__ . '/../../app/controllers/finalizar_campeonato/DashboardCampeaoController.php';

$controller = new DashboardCampeaoController();

$campeonato_id = (int) ($_GET['campeonato_id'] ?? 0);

if ($campeonato_id <= 0) {
    die("Campeonato inválido.");
}

// Dados do campeonato
$dadosCampeonato = $controller->dadosCampeonato($campeonato_id);
if (!$dadosCampeonato) {
    die("Campeonato não encontrado.");
}

// Verifica se existe campeão definido
if (empty($dadosCampeonato['campeao_id'])) {
    die("Campeão não definido para este campeonato.");
}

// Dados do time campeão
$timeCampeao = $controller->dadosTimeCampeao($dadosCampeonato['campeao_id']);

// Estatísticas do time campeão
$estatisticasTime = $controller->estatisticasTime($campeonato_id, $dadosCampeonato['campeao_id']);

// Artilheiros do campeonato
$artilheiros = $controller->artilheiros($campeonato_id);

// Carrega a view
require_once __DIR__ . '/../../public/views/campeonatos/dashboard_campeao.php';
