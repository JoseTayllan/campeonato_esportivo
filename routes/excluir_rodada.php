<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/models/Campeonato.php';

$rodada_id = $_GET['id'] ?? null;
$campeonato_id = $_GET['campeonato_id'] ?? null;

$model = new Campeonato($conn);
if ($rodada_id) {
    $model->excluirRodada($rodada_id);
}

header("Location: campeonato_editar.php?id=$campeonato_id");
exit;
