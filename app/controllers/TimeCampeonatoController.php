<?php 
// app/controllers/TimeCampeonatoController.php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../Models/TimeCampeonato.php';
$controller = new TimeCampeonato($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';
    $time_id = $_POST['time_id'] ?? null;
    $campeonato_id = $_POST['campeonato_id'] ?? null;

    if ($acao === 'adicionar') {
        $controller->adicionar($time_id, $campeonato_id);
        header("Location: ../views/campeonatos/times.php?id=$campeonato_id");
    } elseif ($acao === 'remover') {
        $controller->remover($time_id, $campeonato_id);
        header("Location: ../views/campeonatos/times.php?id=$campeonato_id");
    }
}?>