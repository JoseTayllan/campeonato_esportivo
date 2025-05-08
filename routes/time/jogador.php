<?php

require_once __DIR__ . '/../../app/controllers/time_contro/TeamController.php';

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
        $imagem = null;

        // Verifica se uma nova imagem foi enviada
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
            $imagem_nome = uniqid() . "." . $ext;
            $destino = __DIR__ . '/../../public/img/jogadores/' . $imagem_nome;

            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $destino)) {
                $imagem = $imagem_nome;
            }
        }

        if ($controller->editarJogador($id, $nome, $posicao, $idade, $nacionalidade, $imagem)) {
            $_SESSION['mensagem_sucesso'] = "Jogador editado com sucesso!";
        } else {
            $_SESSION['mensagem_erro'] = "Erro ao editar jogador.";
        }

        header("Location: /campeonato_esportivo/routes/time/dashboard_time.php");
        exit();
    }

    // ✅ Adicionar jogador com upload de imagem
    $nome = $_POST['nome'] ?? '';
    $posicao = $_POST['posicao'] ?? '';
    $idade = $_POST['idade'] ?? 0;
    $nacionalidade = $_POST['nacionalidade'] ?? '';
    $time_id = $_POST['time_id'] ?? '';
    $imagem = null;

    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
        $imagem_nome = uniqid() . "." . $ext;
        $destino = __DIR__ . '/../../public/img/jogadores/' . $imagem_nome;

        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $destino)) {
            $imagem = $imagem_nome;
        }
    }

    if ($controller->adicionarJogador($nome, $posicao, $idade, $nacionalidade, $time_id, $imagem)) {
        $_SESSION['mensagem_sucesso'] = "Jogador adicionado com sucesso!";
    } else {
        $_SESSION['mensagem_erro'] = "Erro ao adicionar jogador.";
    }

    header("Location: /campeonato_esportivo/routes/time/dashboard_time.php");
    exit();
}