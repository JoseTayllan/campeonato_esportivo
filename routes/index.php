<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/controllers/IndexPublicoController.php';

$controller = new IndexPublicoController($conn);
$campeonatosAtivos = $controller->listarCampeonatosPorEsporte($modalidade);
$campeonatosFinalizados = $controller->listarCampeonatosFinalizados($modalidade);


require_once __DIR__ . '/../public/index.php';
