<?php
session_start();


require_once __DIR__ . '/../../app/controllers/time_contro/TeamController.php';
require_once __DIR__ . '/../../app/middleware/verifica_sessao.php';
require_once __DIR__ . '/../../app/middleware/verifica_assinatura.php';

permite_acesso(['time', 'completo']);

$controller = new TeamController($conn);
$id = $_GET['id'] ?? null;

if ($id && $controller->excluirJogador($id)) {
    $_SESSION['mensagem_sucesso'] = "Jogador excluído com sucesso!";
} else {
    $_SESSION['mensagem_erro'] = "Erro ao excluir jogador.";
}

header("Location: dashboard_time.php");
exit;
