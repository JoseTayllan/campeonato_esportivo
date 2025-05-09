<?php
require_once __DIR__ . '/../../app/controllers/time_contro/TeamController.php';

$controller = new TeamController($conn);
$codigo = $_GET['codigo'] ?? '';

$time = $controller->buscarTimePublico($codigo);

if (!$time) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Time não encontrado.</div></div>";
    exit;
}

$jogadores = $controller->listarElencoPublico($time['id']);
$patrocinadores = $controller->buscarPatrocinadoresDoTime($time['id']);

require_once __DIR__ . '/../../public/views/time/perfil_time.php';
