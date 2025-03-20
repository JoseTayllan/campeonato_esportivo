<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/controllers/UserController.php';

session_start(); // Iniciar sessão para armazenar mensagens

$usuarioController = new UsuarioController($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nome'], $_POST['email'], $_POST['senha'], $_POST['tipo'])) {
        $resultado = $usuarioController->criarUsuario($_POST['nome'], $_POST['email'], $_POST['senha'], $_POST['tipo']);
        
        if (strpos($resultado, 'sucesso') !== false) {
            $_SESSION['mensagem_sucesso'] = "Usuário cadastrado com sucesso!";
        } else {
            $_SESSION['mensagem_erro'] = "Erro ao cadastrar usuário: " . $resultado;
        }
    } else {
        $_SESSION['mensagem_erro'] = "Parâmetros ausentes.";
    }
    header("Location: ../public/views/cadastro/cadastro_usuario.php");
    exit();
} else {
    $_SESSION['mensagem_erro'] = "Método inválido.";
    header("Location: ../public/views/cadastro/cadastro_usuario.php");
    exit();
}
?>
