<?php
session_start();

require_once __DIR__ . '/../../app/middleware/verifica_sessao.php';
require_once __DIR__ . '/../../app/middleware/verifica_assinatura.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/controllers/time_contro/JogadorTimeController.php';

permite_acesso(['time', 'completo']);

$controller = new JogadorTimeController($conn);
$admin_id = $_SESSION['usuario_id'];

// 🔥 Buscar o time do admin logado
$stmt = $conn->prepare("SELECT id FROM times WHERE admin_id = ?");
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$res = $stmt->get_result();
$time = $res->fetch_assoc();

if (!$time) {
    die("Time não encontrado.");
}

$time_id = $time['id'];
$jogador_id = $_GET['jogador_id'] ?? '';

if (empty($jogador_id)) {
    die("Jogador inválido.");
}

// 🔥 Remover vínculo
if ($controller->desvincular($jogador_id, $time_id)) {
    $_SESSION['mensagem_sucesso'] = "Jogador removido do time com sucesso!";
} else {
    $_SESSION['mensagem_erro'] = "Erro ao remover jogador do time.";
}

header("Location: dashboard_time.php");
exit();
?>
