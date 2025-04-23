<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/controllers/PartidaAoVivoController.php';

$partida_id = $_GET['id'] ?? null;
if (!$partida_id) {
    die('ID da partida não fornecido.');
}

$controller = new PartidaAoVivoController($conn);

// buscar dados da partida
$partida = $controller->buscarDadosDaPartida($partida_id);

// buscar eventos ao vivo
$eventos = $controller->listarEventos($partida_id);

// buscar jogadores dos dois times
$jogadores = $controller->listarJogadoresDaPartida($partida['time_casa'], $partida['time_fora']);

require_once __DIR__ . '/../public/views/partida/jogo_ao_vivo.php';
