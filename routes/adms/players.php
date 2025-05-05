<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/controllers/PlayerController.php';

session_start(); // Iniciar sessão para mensagens

$jogadorController = new PlayerController($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $imagem = null;
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
        $imagem_nome = uniqid() . '.' . $ext;
        $destino = __DIR__ . '/../../public/img/jogadores/' . $imagem_nome;

        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $destino)) {
            $imagem = $imagem_nome;
        }
    }

    if (isset($_POST['nome'], $_POST['idade'], $_POST['nacionalidade'], $_POST['posicao'], $_POST['time_id'])) {
        $resultado = $jogadorController->criarJogador(
            $_POST['nome'],
            $_POST['idade'],
            $_POST['nacionalidade'],
            $_POST['posicao'],
            $_POST['time_id'],
            $imagem // agora com imagem
        );

        if (strpos($resultado, 'sucesso') !== false) {
            $_SESSION['mensagem_sucesso'] = "Jogador cadastrado com sucesso!";
        } else {
            $_SESSION['mensagem_erro'] = "Erro ao cadastrar jogador: " . $resultado;
        }
    } else {
        $_SESSION['mensagem_erro'] = "Parâmetros ausentes.";
    }
    header("Location: ../../public/views/cadastro/cadastro_jogador.php"); // Caminho corrigido
    exit();
} else {
    $_SESSION['mensagem_erro'] = "Método inválido.";
    header("Location: ../../public/views/cadastro/cadastro_jogador.php"); // Caminho corrigido
    exit();
}
?>
