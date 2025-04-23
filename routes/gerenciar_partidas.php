<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/controllers/GerenciarPartidasController.php';

$controller = new GerenciarPartidasController($conn);

// Atualizar status da partida (iniciar)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['partida_id'], $_POST['status'])) {
    $controller->alterarStatus($_POST['partida_id'], $_POST['status']);
    header("Location: gerenciar_partidas.php?sucesso=1");
    exit;
}

// Buscar todas as partidas
$partidas = $controller->listarPartidas();

// Exibir view
require_once __DIR__ . '/../public/views/partida/gerenciar.php';
