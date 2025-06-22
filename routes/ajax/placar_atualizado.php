<?php
require_once __DIR__ . '/../../config/database.php';
header('Content-Type: application/json');

// ⚠️ Evitar qualquer erro visível que quebre JSON
ini_set('display_errors', 0);
error_reporting(0);

// Verificar se foi passado um parâmetro de modalidade
$modalidade = $_GET['modalidade'] ?? null;

$sql = "
    SELECT 
        p.id, p.data, p.horario, p.local,
        p.placar_casa, p.placar_fora,
        p.time_casa, p.time_fora,
        p.inicio_partida, p.tempo_acumulado, p.acrescimos, p.cronometro_status,
        p.tempo_atual, p.link_transmissao,
        t1.nome AS nome_casa, t1.escudo AS escudo_casa,
        t2.nome AS nome_fora, t2.escudo AS escudo_fora,
        c.modalidade
    FROM partidas p
    JOIN times t1 ON p.time_casa = t1.id
    JOIN times t2 ON p.time_fora = t2.id
    JOIN campeonatos c ON p.campeonato_id = c.id
    WHERE p.status = 'em_andamento'
";

if ($modalidade) {
    $modalidade = $conn->real_escape_string($modalidade);
    $sql .= " AND c.modalidade = '$modalidade'";
}

$sql .= " ORDER BY p.data, p.horario";

$resultado = $conn->query($sql);
$partidas = [];

while ($p = $resultado->fetch_assoc()) {
    // Verificação e fallback dos escudos
    $escudoCasa = basename($p['escudo_casa']);
    $escudoCasaPath = __DIR__ . '/../../public/img/times/' . $escudoCasa;
    $p['escudo_casa'] = (file_exists($escudoCasaPath) && !empty($escudoCasa)) ? $escudoCasa : 'escudo_padrao.png';

    $escudoFora = basename($p['escudo_fora']);
    $escudoForaPath = __DIR__ . '/../../public/img/times/' . $escudoFora;
    $p['escudo_fora'] = (file_exists($escudoForaPath) && !empty($escudoFora)) ? $escudoFora : 'escudo_padrao.png';

    // Buscar eventos
    $stmt = $conn->prepare("
        SELECT ep.jogador_id, ep.tipo_evento, ep.minuto, ep.descricao, j.nome AS nome_jogador
        FROM eventos_partida ep
        LEFT JOIN jogadores j ON ep.jogador_id = j.id
        WHERE ep.partida_id = ?
        ORDER BY ep.minuto ASC
    ");

    if ($stmt) {
        $stmt->bind_param("i", $p['id']);
        $stmt->execute();
        $eventos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    } else {
        $eventos = [];
    }

    $p['eventos'] = $eventos;
    $partidas[] = $p;
}

echo json_encode($partidas);
