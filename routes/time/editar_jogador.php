<?php
session_start();

require_once __DIR__ . '/../../app/middleware/verifica_sessao.php';
require_once __DIR__ . '/../../app/middleware/verifica_assinatura.php';
require_once __DIR__ . '/../../app/controllers/time_contro/TeamController.php';

permite_acesso(['time', 'completo']);

$controller = new TeamController($conn);
$jogador_id = $_GET['id'] ?? null;

if (!$jogador_id) {
    $_SESSION['mensagem_erro'] = "ID do jogador não informado.";
    header("Location: dashboard_time.php");
    exit();
}

$jogador = $controller->buscarJogador($jogador_id);

if (!$jogador) {
    $_SESSION['mensagem_erro'] = "Jogador não encontrado.";
    header("Location: dashboard_time.php");
    exit();
}

// envia para a view somente a variável $jogador
require_once __DIR__ . '/../../public/views/time/editar_jogador.php';
