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

// Recupera fase_id a partir da rodada
$stmt = $conn->prepare("
    SELECT r.fase_id, f.campeonato_id
    FROM rodadas r
    JOIN fases_campeonato f ON f.id = r.fase_id
    WHERE r.id = ?
");
$stmt->bind_param("i", $rodada_id);
$stmt->execute();
$res = $stmt->get_result()->fetch_assoc();

$fase_id = $res['fase_id'] ?? null;
$campeonato_id = $res['campeonato_id'] ?? $campeonato_id;

// Inserção com os dados corretos
$stmt = $conn->prepare("
    INSERT INTO partidas (fase_id, campeonato_id, rodada_id, time_casa, time_fora, data, horario, local, status)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'nao_iniciada')
");
$stmt->bind_param("iiiissss", $fase_id, $campeonato_id, $rodada_id, $time_casa, $time_fora, $data, $horario, $local);
$stmt->execute();

header("Location: campeonato_editar.php?id=$campeonato_id");
exit;
