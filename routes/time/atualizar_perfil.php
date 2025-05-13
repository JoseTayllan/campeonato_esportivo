<?php
session_start();

require_once __DIR__ . '/../../app/controllers/UserController.php';

$usuario_id = $_SESSION['usuario']['id'] ?? null;
$nome = $_POST['nome'] ?? '';
$novo_email = $_POST['email'] ?? '';
$nova_senha = $_POST['nova_senha'] ?? '';
$confirmar_senha = $_POST['confirmar_senha'] ?? '';

if (empty($usuario_id) || empty($novo_email)) {
    $_SESSION['mensagem_erro'] = "Dados incompletos.";
    header("Location: /campeonato_esportivo/public/views/time/perfil.php");
    exit;
}

if (!empty($nova_senha) && $nova_senha !== $confirmar_senha) {
    $_SESSION['mensagem_erro'] = "As senhas não coincidem.";
    header("Location: /campeonato_esportivo/public/views/time/perfil.php");
    exit;
}

$controller = new UsuarioController($conn);
$sucesso = $controller->atualizarPerfil($usuario_id, $nome, $novo_email, $nova_senha ?: null);

if ($sucesso) {
    $_SESSION['usuario']['email'] = $novo_email;
    $_SESSION['usuario']['nome'] = $nome;
    $_SESSION['mensagem_sucesso'] = "Perfil atualizado com sucesso.";
} else {
    $_SESSION['mensagem_erro'] = "Erro ao atualizar perfil.";
}

header("Location: /campeonato_esportivo/public/views/time/perfil.php");
exit;
