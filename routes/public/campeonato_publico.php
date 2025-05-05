<?php
// routes/campeonato_publico.php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/controllers/CampeonatoPublicoController.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "Campeonato não encontrado.";
    exit;
}

$controller = new CampeonatoPublicoController($conn);
$dados = $controller->detalhesDoCampeonato((int) $id);

require_once __DIR__ . '/../../public/views/public/campeonato.php';
