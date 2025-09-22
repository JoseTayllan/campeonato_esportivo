<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/controllers/atletas/AtletaController.php';

$controller = new AtletaController($conn);

$id = $_GET['id'] ?? 0;
$dados = $controller->detalhar($id);

require_once __DIR__ . '/../../public/views/atletas/show.php';
