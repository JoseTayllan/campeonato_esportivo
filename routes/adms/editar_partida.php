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
$stmt->bindValue(1, $partida_id, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->get_result()->fetch(PDO::FETCH_ASSOC);
$rodada_id = $result['rodada_id'] ?? null;

// Atualiza partida com ou sem fase, mantendo compatibilidade
if ($rodada_id && $partida_id && $time_casa && $time_fora && $data && $horario) {
    if ($fase_id) {
        $queryUpdate = "UPDATE partidas SET fase_id = ?, time_casa = ?, time_fora = ?, data = ?, horario = ?, local = ? WHERE id = ?";
        $stmtUpdate = $conn->prepare($queryUpdate);
        $stmtUpdate->bindValue(1, $fase_id, PDO::PARAM_INT);
    $stmt->bindValue(2, $time_casa, PDO::PARAM_INT);
    $stmt->bindValue(3, $time_fora, PDO::PARAM_INT);
    $stmt->bindValue(4, $data, PDO::PARAM_STR);
    $stmt->bindValue(5, $horario, PDO::PARAM_STR);
    $stmt->bindValue(6, $local, PDO::PARAM_STR);
    $stmt->bindValue(7, $partida_id, PDO::PARAM_INT);
    } else {
        $queryUpdate = "UPDATE partidas SET time_casa = ?, time_fora = ?, data = ?, horario = ?, local = ? WHERE id = ?";
        $stmtUpdate = $conn->prepare($queryUpdate);
        $stmtUpdate->bindValue(1, $time_casa, PDO::PARAM_INT);
    $stmt->bindValue(2, $time_fora, PDO::PARAM_INT);
    $stmt->bindValue(3, $data, PDO::PARAM_STR);
    $stmt->bindValue(4, $horario, PDO::PARAM_STR);
    $stmt->bindValue(5, $local, PDO::PARAM_STR);
    $stmt->bindValue(6, $partida_id, PDO::PARAM_INT);
    }

    $stmtUpdate->execute();
}

header("Location: campeonato_editar.php?id=$campeonato_id");
exit;
