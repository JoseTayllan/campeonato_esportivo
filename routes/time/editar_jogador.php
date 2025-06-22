<?php
session_start();

require_once __DIR__ . '/../../app/middleware/verifica_sessao.php';
require_once __DIR__ . '/../../app/middleware/verifica_assinatura.php';
require_once __DIR__ . '/../../config/database.php';

require_once __DIR__ . '/../../app/controllers/time_contro/TeamController.php';

permite_acesso(['time', 'completo']);

$controller = new TeamController($conn);

// 🔥 Pegar ID do jogador via GET
$jogador_id = $_GET['id'] ?? '';

if (empty($jogador_id)) {
    die("Jogador inválido.");
}

// 🔥 Buscar dados do jogador
$jogador = $controller->buscarJogador($jogador_id);

if (!$jogador) {
    die("Jogador não encontrado.");
}

require_once __DIR__ . '/../../public/views/time/editar_jogador.php';
?>
