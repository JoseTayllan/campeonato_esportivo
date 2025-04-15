<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/controllers/loginController.php';

$loginController = new LoginController($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    $usuario = $loginController->autenticar($email, $senha);

    if ($usuario) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_tipo'] = $usuario['tipo'];

        $tipo = strtolower(trim($usuario['tipo'])); // Garantir consistência

        // Redirecionamento baseado no tipo
        if ($tipo === 'administrador') {
            header("Location: ../public/views/dashboard/dashboard_administrador.php");
        } elseif ($tipo === 'organizador') {
            header("Location: ../public/views/dashboard/dashboard_organizador.php");// não tenho no momento
        } elseif ($tipo === 'treinador') {
            header("Location: ../public/views/dashboard/dashboard_treinador.php");// não tenho no momento
        } elseif ($tipo === 'jogador') {
            header("Location: ../public/views/dashboard/dashboard_jogador.php"); // não tenho no momento
        } elseif ($tipo === 'olheiro') {
            header("Location: ../public/views/avaliacao/visualizar_avaliacoes.php");
        } elseif ($tipo === 'patrocinador') {
            header("Location: ../public/views/dashboard/dashboard_patrocinador.php"); // não tenho no momento
        } else {
            // Tipo desconhecido
            $_SESSION['mensagem_erro'] = "Tipo de usuário não reconhecido.";
            header("Location: ../public/views/login/login.php");
        }
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
