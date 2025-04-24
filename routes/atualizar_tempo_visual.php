<?php
require_once __DIR__ . '/../config/database.php';

$partida_id = $_POST['partida_id'] ?? null;
$tempo_atual = $_POST['tempo_atual'] ?? null;

if ($partida_id && $tempo_atual) {
    $stmt = $conn->prepare("UPDATE partidas SET tempo_atual = ? WHERE id = ?");
    $stmt->bind_param("si", $tempo_atual, $partida_id);
    $stmt->execute();
}

// Corrigido para o caminho real da view
header("Location: /campeonato_esportivo/routes/partida_ao_vivo.php?id=$partida_id");

exit;
