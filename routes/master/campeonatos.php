<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/controllers/CampeonatosController.php';

if (!isset($_SESSION['usuario_tipo']) || $_SESSION['usuario_tipo'] !== 'master') {
    header("Location: /campeonato_esportivo/public/index.php");
    exit;
}

$controller = new ChampionshipController($conn);
$campeonatos = $controller->listarTodos();

require_once __DIR__ . '/../../public/views/master/campeonatos.php';
