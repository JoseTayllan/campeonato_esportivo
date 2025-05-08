<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/AgendaTimeController.php';

$controller = new AgendaTimeController($conn);
$admin_id = $_SESSION['usuario_id'] ?? null;

$partidas = [];
if ($admin_id) {
    $result = $controller->buscarPartidasDoMeuTime($admin_id);
    $partidas = $result->fetchAll(PDO::FETCH_ASSOC);
}
require_once __DIR__ . '/../../public/views/time/agenda.php';

