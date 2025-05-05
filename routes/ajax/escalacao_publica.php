<?php
require_once __DIR__ . '/../../config/database.php';
header('Content-Type: application/json');

$partida_id = $_GET['partida_id'] ?? null;
$time_id = $_GET['time_id'] ?? null;

if (!$partida_id || !$time_id) {
    echo json_encode(['erro' => 'Parâmetros inválidos']);
    exit;
}

// Busca jogadores escalados (se existirem)
$sql = "
    SELECT j.nome, j.posicao, j.imagem, j.time_id,
           e.titular
    FROM escalacoes e
    JOIN jogadores j ON e.jogador_id = j.id
    WHERE e.partida_id = ? AND j.time_id = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $partida_id, $time_id);
$stmt->execute();
$res = $stmt->get_result();

$titulares = [];
$reservas = [];

while ($row = $res->fetch_assoc()) {
    $caminhoImagem = __DIR__ . '/../../public/img/jogadores/' . $row['imagem'];
    $imagemFinal = (!empty($row['imagem']) && file_exists($caminhoImagem)) ? $row['imagem'] : 'perfil_padrao.png';

    $jogador = [
        'nome' => $row['nome'],
        'posicao' => $row['posicao'],
        'imagem' => $imagemFinal
    ];

    if ((int)$row['titular'] === 1) {
        $titulares[] = $jogador;
    } else {
        $reservas[] = $jogador;
    }
}

// Busca nome e escudo do time SEM DEPENDER de jogadores escalados
$infoTime = $conn->prepare("SELECT nome, escudo FROM times WHERE id = ?");
$infoTime->bind_param("i", $time_id);
$infoTime->execute();
$info = $infoTime->get_result()->fetch_assoc();

$escudo_time = '';
$time_nome = $info['nome'] ?? '';

if (!empty($info['escudo'])) {
    $escudoLimpo = basename($info['escudo']);
    $caminhoEscudo = __DIR__ . '/../../public/img/times/' . $escudoLimpo;
    if (file_exists($caminhoEscudo)) {
        $escudo_time = $escudoLimpo;
    }
}

echo json_encode([
    'time_nome' => $time_nome,
    'escudo' => $escudo_time,
    'titulares' => $titulares,
    'reservas' => $reservas
]);
