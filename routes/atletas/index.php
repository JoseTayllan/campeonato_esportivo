<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/controllers/atletas/AtletaController.php';

$controller = new AtletaController($conn);

$filtros = [
    'nome' => $_GET['nome'] ?? null,
    'posicao' => $_GET['posicao'] ?? null,
    'nacionalidade' => $_GET['nacionalidade'] ?? null,
    'idade' => $_GET['idade'] ?? null
];

$jogadores = $controller->listar($filtros);

require_once __DIR__ . '/../../public/views/atletas/index.php';
