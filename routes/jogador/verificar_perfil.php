<?php
session_start();

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/controllers/time_contro/TeamController.php';

$controller = new TeamController($conn);
$jogador_id = $_SESSION['usuario_id'] ?? null;

if (!$jogador_id) {
    header("Location: ../../public/views/login/login.php");
    exit;
}

$jogador = $controller->buscarJogador($jogador_id);

if (empty($jogador['cpf']) || empty($jogador['data_nascimento'])) {
    // Redireciona para completar dados (você pode criar essa rota depois)
    header("Location: /campeonato_esportivo/public/views/jogador/completar_perfil.php");
} else {
    header("Location: /campeonato_esportivo/routes/jogador/perfil.php");
}
exit;
