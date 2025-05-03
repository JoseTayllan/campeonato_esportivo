<?php
session_start();
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../app/controllers/PartidaAoVivoController.php';



$partida_id = $_GET['id'] ?? null;

if (!$partida_id) {
    die('ID da partida não informado.');
}

$controller = new PartidaAoVivoController($conn);
$controller->finalizarPartida($partida_id);

// Redireciona de volta ao painel de gerenciamento com feedback
header("Location: gerenciar_partidas.php?sucesso=1");
exit;
