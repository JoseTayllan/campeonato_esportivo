<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


require_once __DIR__ . '/../../Models/time/AgendaTime.php';

$controller = new AgendaTime($conn);
$admin_id = $_SESSION['usuario_id'] ?? null;

$partidas = [];
if ($admin_id) {
    $result = $controller->buscarPartidasDoMeuTime($admin_id);
    $partidas = $result->fetch_all(MYSQLI_ASSOC);
}


