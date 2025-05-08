<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/controllers/UserController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if (!$nome || !$email || !$senha) {
        $_SESSION['mensagem_erro'] = "Preencha todos os campos.";
        header('Location: /public/views/master/cadastro_master.php');
        exit;
    }

    $usuarioController = new UsuarioController($conn);

    // Criar usuário tipo Master
    $resultado = $usuarioController->criarUsuario($nome, $email, $senha, 'Master');

    $_SESSION['mensagem_sucesso'] = $resultado;
    header('Location: /public/views/login/login.php');
    exit;
} else {
    $_SESSION['mensagem_erro'] = "Requisição inválida.";
    header('Location: /public/views/login/login.php');
    exit;
}
?>
