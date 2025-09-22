<?php 
require_once __DIR__ . '/../../app/controllers/finalizar_campeonato/DashboardCampeaoController.php';

$controller = new DashboardCampeaoController();

$campeonato_id = (int) ($_GET['campeonato_id'] ?? 0);

if ($campeonato_id <= 0) {
    die("Campeonato inválido.");
}

$dadosCampeonato = $controller->dadosCampeonato($campeonato_id);
if (!$dadosCampeonato) {
    die("Campeonato não encontrado.");
}

if (empty($dadosCampeonato['campeao_id'])) {
    die("Campeão não definido para este campeonato.");
}

$timeCampeao = $controller->dadosTimeCampeao($dadosCampeonato['campeao_id']);
$estatisticasTime = $controller->estatisticasTime($campeonato_id, $dadosCampeonato['campeao_id']);
$artilheiros = $controller->artilheiros($campeonato_id);

// ✅ Define o melhor goleiro
$melhorGoleiro = $controller->melhorGoleiro($campeonato_id);

require_once __DIR__ . '/../../public/views/campeonatos/dashboard_campeao.php';
?>