<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/controllers/EvaluationController.php';

session_start(); // Iniciar sessão para mensagens

$evaluationController = new AvaliacaoController($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['jogador_id'], $_POST['olheiro_id'], $_POST['forca'], $_POST['velocidade'], $_POST['drible'], $_POST['finalizacao'], $_POST['nota_geral'], $_POST['observacoes'])) {
        $resultado = $evaluationController->criarAvaliacao($_POST);

        if (strpos($resultado, 'sucesso') !== false) {
            $_SESSION['mensagem_sucesso'] = "Avaliação registrada com sucesso!";
        } else {
            $_SESSION['mensagem_erro'] = "Erro ao registrar avaliação: " . $resultado;
        }
    } else {
        $_SESSION['mensagem_erro'] = "Parâmetros ausentes.";
    }
    header("Location: ../public/views/avaliacao/avaliar_jogador.php");
    exit();
} else {
    $_SESSION['mensagem_erro'] = "Método inválido.";
    header("Location: ../public/views/avaliacao/avaliar_jogador.php");
    exit();
}
?>