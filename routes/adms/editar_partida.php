<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/models/Campeonato.php';

$partida_id = $_POST['partida_id'] ?? null;
$campeonato_id = $_POST['campeonato_id'] ?? null;
$time_casa = $_POST['time_casa'] ?? null;
$time_fora = $_POST['time_fora'] ?? null;
$data = $_POST['data'] ?? null;
$horario = $_POST['horario'] ?? null;
$local = $_POST['local'] ?? '';
$fase_id = $_POST['fase_id'] ?? null;

$model = new Campeonato($conn);

// Recupera o rodada_id da partida para manter a associação
$query = "SELECT rodada_id FROM partidas WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $partida_id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();
$rodada_id = $result['rodada_id'] ?? null;

// Atualiza partida com ou sem fase, mantendo compatibilidade
if ($rodada_id && $partida_id && $time_casa && $time_fora && $data && $horario) {
    if ($fase_id) {
        $queryUpdate = "UPDATE partidas SET fase_id = ?, time_casa = ?, time_fora = ?, data = ?, horario = ?, local = ? WHERE id = ?";
        $stmtUpdate = $conn->prepare($queryUpdate);
        $stmtUpdate->bind_param("iiisssi", $fase_id, $time_casa, $time_fora, $data, $horario, $local, $partida_id);
    } else {
        $queryUpdate = "UPDATE partidas SET time_casa = ?, time_fora = ?, data = ?, horario = ?, local = ? WHERE id = ?";
        $stmtUpdate = $conn->prepare($queryUpdate);
        $stmtUpdate->bind_param("iisssi", $time_casa, $time_fora, $data, $horario, $local, $partida_id);
    }

    $stmtUpdate->execute();
}

header("Location: campeonato_editar.php?id=$campeonato_id");
exit;
