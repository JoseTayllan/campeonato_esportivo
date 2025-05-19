<?php
require_once __DIR__ . '/../../config/database.php';
header('Content-Type: application/json');

// Verificar se foi passado um parâmetro de modalidade
$modalidade = isset($_GET['modalidade']) ? $_GET['modalidade'] : null;

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

// Adicionar filtro de modalidade se necessário
if ($modalidade) {
    $modalidade = $conn->real_escape_string($modalidade);
    $sql .= " AND c.modalidade = '$modalidade'";
}

$sql .= " ORDER BY p.data, p.horario";

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

    // Eventos da partida, incluindo nome e id do jogador
    $stmt = $conn->prepare("
        SELECT ep.jogador_id, ep.tipo_evento, ep.minuto, ep.descricao, j.nome AS nome_jogador
        FROM eventos_partida ep
        LEFT JOIN jogadores j ON ep.jogador_id = j.id
        WHERE ep.partida_id = ?
        ORDER BY ep.minuto ASC
    ");
    $stmt->bind_param("i", $p['id']);
    $stmt->execute();
    $eventos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    $p['eventos'] = $eventos;
    $partidas[] = $p;
}

echo json_encode($partidas);
