<?php 
session_start();
require_once __DIR__ . '/../../config/database.php';

$partida_id = $_POST['partida_id'] ?? null;
$status = $_POST['status'] ?? null;
$acrescimos = $_POST['acrescimos'] ?? null;

if (!$partida_id) {
    http_response_code(400);
    exit('Requisição inválida');
}

// Atualizar apenas acréscimos se enviados sozinhos
if ($acrescimos !== null && $status === null) {
    $acrescimos = (int)$acrescimos;
    $stmt = $conn->prepare("UPDATE partidas SET acrescimos = ? WHERE id = ?");
    $stmt->bindValue(1, $acrescimos, PDO::PARAM_INT);
    $stmt->bindValue(2, $partida_id, PDO::PARAM_INT);
    $stmt->execute();
    exit('Acréscimo registrado');
}

// Buscar dados atuais da partida
$stmt = $conn->prepare("SELECT inicio_partida, tempo_acumulado FROM partidas WHERE id = ?");
$stmt->bindValue(1, $partida_id, PDO::PARAM_INT);
$stmt->execute();
$res = $stmt->get_result()->fetch(PDO::FETCH_ASSOC);

if (!$res) {
    http_response_code(404);
    exit('Partida não encontrada');
}

$agora = date('Y-m-d H:i:s');

if ($status === 'pausado') {
    if ($res['inicio_partida']) {
        $inicio = strtotime($res['inicio_partida']);
        $decorridos = floor((time() - $inicio) / 60);
        $novoTempo = $res['tempo_acumulado'] + $decorridos;

        $stmt = $conn->prepare("UPDATE partidas SET tempo_acumulado = ?, inicio_partida = NULL, cronometro_status = 'pausado' WHERE id = ?");
        $stmt->bindValue(1, $novoTempo, PDO::PARAM_INT);
    $stmt->bindValue(2, $partida_id, PDO::PARAM_INT);
        $stmt->execute();
    }
    exit('Pausado');

} elseif ($status === 'rodando') {
    $stmt = $conn->prepare("UPDATE partidas SET inicio_partida = ?, cronometro_status = 'rodando' WHERE id = ?");
    $stmt->bindValue(1, $agora, PDO::PARAM_STR);
    $stmt->bindValue(2, $partida_id, PDO::PARAM_INT);
    $stmt->execute();
    exit('Retomado');
}

http_response_code(400);
echo 'Status desconhecido';
