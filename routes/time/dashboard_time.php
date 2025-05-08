<?php
session_start();
require_once __DIR__ . '/../../app/middleware/verifica_sessao.php';
require_once __DIR__ . '/../../app/middleware/verifica_assinatura.php';
require_once __DIR__ . '/../../app/controllers/time_contro/TeamController.php';

permite_acesso(['time', 'completo']);

$admin_id = $_SESSION['usuario_id'];
$controller = new TeamController($conn);

// Busca dados do time
$stmt = $conn->prepare("SELECT * FROM times WHERE admin_id = ?");
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$resultado = $stmt->get_result();
$time = $resultado->fetch_assoc();

if (!$time) {
    $dados = ['precisa_cadastrar' => true];
    require_once __DIR__ . '/../../public/views/time/dashboard_time.php';
    exit;
}

$jogadores = $controller->listarJogadoresDoMeuTime($time['id']);
$patrocinadores = $controller->buscarPatrocinadoresDoTime($time['id']);

$dados = [
    'time' => $time,
    'jogadores' => $jogadores,
    'patrocinadores' => $patrocinadores,
];

require_once __DIR__ . '/../../public/views/time/dashboard_time.php';
