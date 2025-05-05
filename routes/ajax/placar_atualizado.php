<?php
require_once __DIR__ . '/../../config/database.php';
header('Content-Type: application/json');

$sql = "
    SELECT 
        p.id, p.data, p.horario, p.local,
        p.placar_casa, p.placar_fora,
        p.time_casa, p.time_fora,
        p.inicio_partida, p.tempo_acumulado, p.acrescimos, p.cronometro_status,
        p.tempo_atual,
        t1.nome AS nome_casa, t1.escudo AS escudo_casa,
        t2.nome AS nome_fora, t2.escudo AS escudo_fora
    FROM partidas p
    JOIN times t1 ON p.time_casa = t1.id
    JOIN times t2 ON p.time_fora = t2.id
    WHERE p.status = 'em_andamento'
    ORDER BY p.data, p.horario
";

$res = $conn->query($sql);
$partidas = [];

while ($p = $res->fetch_assoc()) {
    // Ajusta e valida escudo da casa
    $escudoCasa = basename($p['escudo_casa']);
    $escudoCasaPath = __DIR__ . '/../../public/img/times/' . $escudoCasa;
    $p['escudo_casa'] = (!empty($escudoCasa) && file_exists($escudoCasaPath)) ? $escudoCasa : 'escudo_padrao.png';

    // Ajusta e valida escudo do visitante
    $escudoFora = basename($p['escudo_fora']);
    $escudoForaPath = __DIR__ . '/../../public/img/times/' . $escudoFora;
    $p['escudo_fora'] = (!empty($escudoFora) && file_exists($escudoForaPath)) ? $escudoFora : 'escudo_padrao.png';

    // Eventos da partida
    $stmt = $conn->prepare("SELECT tipo_evento, minuto, descricao FROM eventos_partida WHERE partida_id = ? ORDER BY minuto ASC");
    $stmt->bind_param("i", $p['id']);
    $stmt->execute();
    $eventos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    $p['eventos'] = $eventos;
    $partidas[] = $p;
}

echo json_encode($partidas);
