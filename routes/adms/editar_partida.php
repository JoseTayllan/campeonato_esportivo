<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/Models/Campeonato.php';

$partida_id = $_POST['partida_id'] ?? null;
$campeonato_id = $_POST['campeonato_id'] ?? null;
$time_casa = $_POST['time_casa'] ?? null;
$time_fora = $_POST['time_fora'] ?? null;
$data = $_POST['data'] ?? null;
$horario = $_POST['horario'] ?? null;
$local = $_POST['local'] ?? '';
$fase_id = $_POST['fase_id'] ?? null;

if (!$partida_id || !$campeonato_id || !$time_casa || !$time_fora || !$data || !$horario) {
    $_SESSION['mensagem_erro'] = "⚠️ Preencha todos os campos obrigatórios para atualizar a partida.";
    header("Location: campeonato_editar_rodadas.php?id=$campeonato_id");
    exit;
}

$model = new Campeonato($conn);

// Recupera o rodada_id da partida para manter a associação
$query = "SELECT rodada_id FROM partidas WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $partida_id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();
$rodada_id = $result['rodada_id'] ?? null;

if (!$rodada_id) {
    $_SESSION['mensagem_erro'] = "Erro ao localizar a rodada da partida.";
    header("Location: campeonato_editar_rodadas.php?id=$campeonato_id");
    exit;
}

if ($fase_id) {
    $queryUpdate = "UPDATE partidas SET fase_id = ?, time_casa = ?, time_fora = ?, data = ?, horario = ?, local = ? WHERE id = ?";
    $stmtUpdate = $conn->prepare($queryUpdate);
    $stmtUpdate->bind_param("iiisssi", $fase_id, $time_casa, $time_fora, $data, $horario, $local, $partida_id);
} else {
    $queryUpdate = "UPDATE partidas SET time_casa = ?, time_fora = ?, data = ?, horario = ?, local = ? WHERE id = ?";
    $stmtUpdate = $conn->prepare($queryUpdate);
    $stmtUpdate->bind_param("iisssi", $time_casa, $time_fora, $data, $horario, $local, $partida_id);
}

if ($stmtUpdate->execute()) {
    $_SESSION['mensagem_sucesso'] = "✅ Partida atualizada com sucesso!";
} else {
    $_SESSION['mensagem_erro'] = "Erro ao atualizar a partida.";
}

header("Location: campeonato_editar_rodadas.php?id=$campeonato_id");
exit;
