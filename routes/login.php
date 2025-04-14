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

       // Verifica tipo corretamente com base no valor vindo do banco
       $tipo = strtolower(trim($usuario['tipo']));

       if ($tipo === 'administrador') {
           header("Location: ../public/views/dashboard/dashboard_administrador.php");
       } else {
           header("Location: ../public/index.php");
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