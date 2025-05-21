<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/controllers/sumula/SumulaPartidaController.php';

$controller = new SumulaPartidaController($conn);

$partida_id = $_GET['partida_id'] ?? null;
if (!$partida_id) {
    echo "Partida não informada.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->salvarSumula($_POST);
    $_SESSION['mensagem_sucesso'] = "Súmula salva e partida finalizada.";
    header("Location: ../aovivo/gerenciar_partidas.php?campeonato_id=" . $_POST['campeonato_id']);
    exit;
}

$dados = $controller->carregarDados($partida_id);
include __DIR__ . '/../../public/views/partida/sumula_partida.php';
