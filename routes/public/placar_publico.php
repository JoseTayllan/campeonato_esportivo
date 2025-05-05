<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/controllers/PlacarPublicoController.php';

$controller = new PlacarPublicoController($conn);
$partidas = $controller->listarPartidasEmAndamento();

require_once __DIR__ . '/../../public/views/public/placar_ao_vivo.php';
