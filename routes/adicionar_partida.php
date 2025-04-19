<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/models/Campeonato.php';

$rodada_id = $_POST['rodada_id'] ?? null;
$campeonato_id = $_POST['campeonato_id'] ?? null;
$time_casa = $_POST['time_casa'] ?? null;
$time_fora = $_POST['time_fora'] ?? null;
$data = $_POST['data'] ?? null;
$horario = $_POST['horario'] ?? null;
$local = $_POST['local'] ?? '';

if (!$rodada_id || !$time_casa || !$time_fora || !$data || !$horario) {
    $_SESSION['mensagem_erro'] = "Dados obrigatórios ausentes.";
    header("Location: campeonato_editar.php?id=$campeonato_id");
    exit;
}

$model = new Campeonato($conn);
$model->cadastrarPartida($rodada_id, $time_casa, $time_fora, $data, $horario, $local);

header("Location: campeonato_editar.php?id=$campeonato_id");
exit;
