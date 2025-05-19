<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/controllers/PlacarPublicoController.php';

// Recuperar modalidade da URL
$modalidade = isset($_GET['modalidade']) ? $_GET['modalidade'] : null;

$controller = new PlacarPublicoController($conn);
$partidas = $controller->listarPartidasEmAndamento($modalidade);

// Definir título baseado na modalidade
$tituloModalidade = "Placares Ao Vivo";
if ($modalidade) {
    $tituloModalidade = "Placares de " . ucfirst($modalidade) . " Ao Vivo";
}

// Passar o título e a modalidade para a view
$viewData = [
    'partidas' => $partidas,
    'titulo' => $tituloModalidade,
    'modalidade' => $modalidade
];

require_once __DIR__ . '/../../public/views/public/placar_ao_vivo.php';
