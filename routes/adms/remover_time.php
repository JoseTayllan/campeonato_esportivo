<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/Models/Campeonato.php';

$campeonato_id = $_GET['campeonato_id'] ?? null;
$time_id = $_GET['time_id'] ?? null;

if (!$campeonato_id || !$time_id) {
    $_SESSION['mensagem_erro'] = "ID do time ou campeonato não informado.";
    header("Location: campeonato_editar.php?id=$campeonato_id");
    exit;
}

$model = new Campeonato($conn);

if ($model->desvincularTime($campeonato_id, $time_id)) {
    $_SESSION['mensagem_sucesso'] = "✅ Time removido com sucesso!";
} else {
    $_SESSION['mensagem_erro'] = "Erro ao remover o time.";
}

header("Location: campeonato_editar.php?id=$campeonato_id");
exit;
