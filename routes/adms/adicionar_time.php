<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/Models/Campeonato.php';

$campeonato_id = $_POST['campeonato_id'] ?? null;
$time_id = $_POST['time_id'] ?? null;

if (!$campeonato_id || !$time_id) {
    $_SESSION['mensagem_erro'] = "ID do time ou campeonato não informado.";
   header("Location: campeonato_editar_times.php?id=$campeonato_id");
    exit;
}

$model = new Campeonato($conn);

// Verifica duplicidade
$check = $conn->prepare("SELECT 1 FROM times_campeonatos WHERE time_id = ? AND campeonato_id = ?");
$check->bind_param("ii", $time_id, $campeonato_id);
$check->execute();
$res = $check->get_result();

if ($res->num_rows > 0) {
    $_SESSION['mensagem_erro'] = "❗ Este time já está vinculado a este campeonato.";
} else {
    if ($model->vincularTime($campeonato_id, $time_id)) {
        $_SESSION['mensagem_sucesso'] = "✅ Time vinculado com sucesso!";
    } else {
        $_SESSION['mensagem_erro'] = "Erro ao vincular o time.";
    }
}

header("Location: campeonato_editar_times.php?id=$campeonato_id");
exit;
