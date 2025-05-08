<?php
session_start();

require_once __DIR__ . '/../../app/middleware/verifica_sessao.php';
require_once __DIR__ . '/../../app/middleware/verifica_assinatura.php';
require_once __DIR__ . '/../../app/controllers/time_contro/TeamController.php';

permite_acesso(['time', 'completo']);

$controller = new TeamController($conn);
$admin_id = $_SESSION['usuario_id'];

// Busca o time do admin logado
$stmt = $conn->prepare("SELECT id FROM times WHERE admin_id = ?");
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
$time = $result->fetch_assoc();

// Proteção extra
if (!$time || !isset($time['id'])) {
    die("Time não encontrado ou acesso não autorizado.");
}

// Define a variável que a view usará
$time_id = $time['id'];

// Renderiza a view com segurança
require_once __DIR__ . '/../../public/views/time/adicionar_jogador.php';
