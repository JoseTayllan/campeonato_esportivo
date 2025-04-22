<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/controllers/loginController.php';
require_once __DIR__ . '/../app/helpers/redirecionar_usuario.php'; // integração

$loginController = new LoginController($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    $usuario = $loginController->autenticar($email, $senha);

    if ($usuario) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_tipo'] = $usuario['tipo'];
        $_SESSION['usuario'] = $usuario; // necessário para o middleware de assinatura

        // 🔁 Redirecionamento centralizado
        redirecionarUsuario($usuario);

    } else {
        $_SESSION['mensagem_erro'] = "Credenciais inválidas.";
        header("Location: ../public/views/login/login.php");
    }
    exit();
} else {
    $_SESSION['mensagem_erro'] = "Requisição inválida.";
    header("Location: ../public/views/login/login.php");
    exit();
}
