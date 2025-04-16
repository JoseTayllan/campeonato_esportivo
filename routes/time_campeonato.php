<?php
session_start();
require_once '../config/database.php';
require_once '../app/models/TimeCampeonato.php';

$controller = new TimeCampeonato($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';
    $time_id = $_POST['time_id'] ?? null;
    $campeonato_id = $_POST['campeonato_id'] ?? null;

    if ($acao === 'adicionar' && $time_id && $campeonato_id) {
        $controller->adicionar($time_id, $campeonato_id);
    } elseif ($acao === 'remover' && $time_id && $campeonato_id) {
        $controller->remover($time_id, $campeonato_id);
    }

    header("Location: ../public/views/campeonatos/times.php?id=$campeonato_id");
    exit;
} else {
    echo "Requisição inválida.";
}
