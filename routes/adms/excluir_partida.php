<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/models/Campeonato.php';

$partida_id = $_GET['id'] ?? null;
$campeonato_id = $_GET['campeonato_id'] ?? null;

if ($partida_id && $campeonato_id) {
    $model = new Campeonato($conn);
    $model->excluirPartida($partida_id);
}

header("Location: campeonato_editar.php?id=$campeonato_id");
exit;
