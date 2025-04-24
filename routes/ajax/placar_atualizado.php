<?php
require_once __DIR__ . '/../../config/database.php';

header('Content-Type: application/json');

$sql = "
    SELECT 
        p.id, p.data, p.horario, p.local,
        p.placar_casa, p.placar_fora,
        p.inicio_partida, p.tempo_acumulado, p.acrescimos, p.cronometro_status,
        p.tempo_atual,
        tc.nome AS nome_casa, tc.escudo AS escudo_casa,
        tf.nome AS nome_fora, tf.escudo AS escudo_fora
    FROM partidas p
    JOIN times tc ON p.time_casa = tc.id
    JOIN times tf ON p.time_fora = tf.id
    WHERE p.status = 'em_andamento'
    ORDER BY p.data, p.horario
";

$res = $conn->query($sql);
$partidas = [];

while ($p = $res->fetch_assoc()) {
    // Buscar eventos da partida
    $stmt = $conn->prepare("SELECT tipo_evento, minuto, descricao FROM eventos_partida WHERE partida_id = ? ORDER BY minuto ASC");
    $stmt->bind_param("i", $p['id']);
    $stmt->execute();
    $eventos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    $p['eventos'] = $eventos;
    $partidas[] = $p;
}

echo json_encode($partidas);
