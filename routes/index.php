<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/controllers/IndexPublicoController.php';

$controller = new IndexPublicoController($conn);
$campeonatosPorEsporte = $controller->listarCampeonatosPorEsporte();

require_once __DIR__ . '/../public/index.php';
