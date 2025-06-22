<?php
session_start();

require_once __DIR__ . '/../../app/middleware/verifica_sessao.php';
require_once __DIR__ . '/../../app/middleware/verifica_assinatura.php';
require_once __DIR__ . '/../../app/controllers/time_contro/TeamController.php';

permite_acesso(['time', 'completo']);

$admin_id = $_SESSION['usuario_id'];
$controller = new TeamController($conn);

// 🔥 Buscar dados do time do admin
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

// 🔥 Buscar jogadores usando a nova estrutura de vínculo
$jogadores = $controller->listarJogadoresDoMeuTime($time['id'], $admin_id);

// 🔥 Buscar patrocinadores
$patrocinadores = $controller->buscarPatrocinadoresDoTime($time['id']);

// 🔥 Enviar dados para a view
$dados = [
    'time' => $time,
    'jogadores' => $jogadores,
    'patrocinadores' => $patrocinadores,
];

require_once __DIR__ . '/../../public/views/time/dashboard_time.php';
?>
