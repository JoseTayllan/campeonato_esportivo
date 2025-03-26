<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/controllers/StatisticsController.php';

session_start(); // Iniciar sessão para mensagens

$statisticsController = new StatisticsController($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['partida_id'], $_POST['jogador_id'])) {
        $resultado = $statisticsController->registrarEstatistica($_POST);

        if (strpos($resultado, 'sucesso') !== false) {
            $_SESSION['mensagem_sucesso'] = "Estatística registrada com sucesso!";
        } else {
            $_SESSION['mensagem_erro'] = "Erro ao registrar estatística: " . $resultado;
        }
    } else {
        $_SESSION['mensagem_erro'] = "Parâmetros ausentes.";
    }
    header("Location: ../public/views/estatistica/cadastrar_estatistica_jogador.php");
    exit();
} else {
    $_SESSION['mensagem_erro'] = "Método inválido.";
    header("Location: ../public/views/estatistica/cadastrar_estatistica_jogador.php");
    exit();
}
?>