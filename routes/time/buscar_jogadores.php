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

// 🔥 Buscar jogadores que NÃO estão no time atual
$query = "SELECT * FROM jogadores 
          WHERE id NOT IN (
            SELECT jogador_id FROM jogador_time WHERE time_id = ? AND status = 'ativo'
          )";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $time_id);
$stmt->execute();
$jogadores = $stmt->get_result();

require_once __DIR__ . '/../../public/views/time/buscar_jogadores.php';
?>
