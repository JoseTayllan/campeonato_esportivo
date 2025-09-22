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
        // 🔹 Dados básicos
        $_SESSION['usuario_id']        = $usuario['id'];
        $_SESSION['usuario_nome']      = $usuario['nome'];
        $_SESSION['usuario_tipo']      = $usuario['tipo'];
        $_SESSION['usuario_assinatura']= $usuario['tipo_assinatura'] ?? null;
        $_SESSION['usuario_criado_por']= $usuario['criado_por'] ?? null;
        $_SESSION['usuario']           = $usuario;

        // 🔹 Se for jogador de Ping-Pong → buscar id na tabela jogadores
        if (
            strtolower($usuario['tipo']) === 'jogador' && 
            strtolower($usuario['tipo_assinatura'] ?? '') === 'pingpong'
        ) {
            $stmt = $conn->prepare("
                SELECT id 
                FROM jogadores 
                WHERE usuario_id = ? 
                AND modalidade = 'Ping-Pong'
            ");
            $stmt->bind_param("i", $usuario['id']);
            $stmt->execute();
            $res = $stmt->get_result()->fetch_assoc();

            if ($res && isset($res['id'])) {
                $_SESSION['jogador_id'] = $res['id'];
            }
        }

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
