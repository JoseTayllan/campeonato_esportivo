<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/models/Campeonato.php';

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

// Recupera fase_id a partir da rodada
$stmt = $conn->prepare("
    SELECT r.fase_id, f.campeonato_id
    FROM rodadas r
    JOIN fases_campeonato f ON f.id = r.fase_id
    WHERE r.id = ?
");
$stmt->bindValue(1, $rodada_id, PDO::PARAM_INT);
$stmt->execute();
$res = $stmt->get_result()->fetch(PDO::FETCH_ASSOC);

$fase_id = $res['fase_id'] ?? null;
$campeonato_id = $res['campeonato_id'] ?? $campeonato_id;

// Inserção com os dados corretos
$stmt = $conn->prepare("
    INSERT INTO partidas (fase_id, campeonato_id, rodada_id, time_casa, time_fora, data, horario, local, status)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'nao_iniciada')
");
$stmt->bindValue(1, $fase_id, PDO::PARAM_INT);
    $stmt->bindValue(2, $campeonato_id, PDO::PARAM_INT);
    $stmt->bindValue(3, $rodada_id, PDO::PARAM_INT);
    $stmt->bindValue(4, $time_casa, PDO::PARAM_INT);
    $stmt->bindValue(5, $time_fora, PDO::PARAM_STR);
    $stmt->bindValue(6, $data, PDO::PARAM_STR);
    $stmt->bindValue(7, $horario, PDO::PARAM_STR);
    $stmt->bindValue(8, $local, PDO::PARAM_STR);
$stmt->execute();

header("Location: campeonato_editar.php?id=$campeonato_id");
exit;
