<?php
session_start();
$restrito_para = ['Olheiro'];
require_once __DIR__ . '/../../app/middleware/verifica_sessao.php';
require_once __DIR__ . '/../../app/controllers/avaliar_contro/AvaliarJogadorController.php';

$controller = new AvaliarJogadorController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->avaliar($_POST, $_SESSION['usuario_id'] ?? null);

    header("Location: visualizar_avaliacoes.php");
    exit;
}

$elenco = $controller->listarJogadores();

require_once __DIR__ . '/../../public/views/avaliacao/avaliar_jogador.php';
