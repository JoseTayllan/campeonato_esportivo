<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/controllers/TeamController.php';

session_start();

$controller = new TeamController($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ✅ Editar jogador
    if (isset($_POST['editar_jogador'])) {
        $id = $_POST['jogador_id'] ?? '';
        $nome = $_POST['nome'] ?? '';
        $posicao = $_POST['posicao'] ?? '';
        $idade = $_POST['idade'] ?? 0;
        $nacionalidade = $_POST['nacionalidade'] ?? '';

        if ($controller->editarJogador($id, $nome, $posicao, $idade, $nacionalidade)) {
            $_SESSION['mensagem_sucesso'] = "Jogador editado com sucesso!";
        } else {
            $_SESSION['mensagem_erro'] = "Erro ao editar jogador.";
        }

        header("Location: ../public/views/time/dashboard_time.php");
        exit();
    }

    // ✅ Adicionar jogador
    $nome = $_POST['nome'] ?? '';
    $posicao = $_POST['posicao'] ?? '';
    $idade = $_POST['idade'] ?? 0;
    $nacionalidade = $_POST['nacionalidade'] ?? '';
    $time_id = $_POST['time_id'] ?? '';

    if ($controller->adicionarJogador($nome, $posicao, $idade, $nacionalidade, $time_id)) {
        $_SESSION['mensagem_sucesso'] = "Jogador adicionado com sucesso!";
    } else {
        $_SESSION['mensagem_erro'] = "Erro ao adicionar jogador.";
    }

    header("Location: ../public/views/time/dashboard_time.php");
    exit();
}
