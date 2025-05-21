<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/controllers/sumula/SumulaPartidaController.php';

$controller = new SumulaPartidaController($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->salvarSumula($_POST);
    $_SESSION['mensagem_sucesso'] = "Partida finalizada com sucesso pela súmula.";
    header("Location: ./aovivo/gerenciar_partidas.php?campeonato_id=" . $_POST['campeonato_id']);
    exit;
} else {
    echo "Método inválido.";
    exit;
}
?>
