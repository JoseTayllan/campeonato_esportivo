<?php
session_start();

require_once __DIR__ . '/../../app/controllers/time_contro/escalacaoController.php';
require_once __DIR__ . '/../../app/middleware/verifica_time_logado.php';

// Redirecionamento POST separado (para escalacao.php)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header("Location: escalacao.php");
    exit;
}

// GET: carregar a tela
$partida_id = $_GET['partida_id'] ?? null;
$time_id = $_SESSION['time_id'] ?? null;

if (!$partida_id || !$time_id) {
    echo "<div class='alert alert-danger'>Partida ou time não definidos corretamente.</div>";
    exit;
}

$controller = new EscalacaoController($conn);
$jogadores = $controller->obterJogadoresTime($time_id);
$escalacao_existente = $controller->buscarEscalacaoDaPartida($partida_id);

// Envia para a view
require_once __DIR__ . '/../../public/views/time/definir_escalacao.php';
