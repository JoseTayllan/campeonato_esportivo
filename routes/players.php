<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/controllers/PlayerController.php';

session_start(); // Iniciar sessão para mensagens

$jogadorController = new PlayerController($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nome'], $_POST['idade'], $_POST['nacionalidade'], $_POST['posicao'], $_POST['time_id'])) {
        $resultado = $jogadorController->criarJogador(
            $_POST['nome'],
            $_POST['idade'],
            $_POST['nacionalidade'],
            $_POST['posicao'],
            $_POST['time_id']
        );

        if (strpos($resultado, 'sucesso') !== false) {
            $_SESSION['mensagem_sucesso'] = "Jogador cadastrado com sucesso!";
        } else {
            $_SESSION['mensagem_erro'] = "Erro ao cadastrar jogador: " . $resultado;
        }
    } else {
        $_SESSION['mensagem_erro'] = "Parâmetros ausentes.";
    }
    header("Location: ../public/views/cadastro/cadastro_jogador.php"); // Caminho corrigido
    exit();
} else {
    $_SESSION['mensagem_erro'] = "Método inválido.";
    header("Location: ../public/views/cadastro/cadastro_jogador.php"); // Caminho corrigido
    exit();
}
?>
