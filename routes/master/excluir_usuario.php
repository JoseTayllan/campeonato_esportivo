<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

if (!isset($_SESSION['usuario_tipo']) || $_SESSION['usuario_tipo'] !== 'Master') {
    $_SESSION['mensagem_erro'] = "Acesso restrito.";
    header("Location: /public/index.php");
    exit;
}

$id = $_GET['id'] ?? null;

if (!$id) {
    $_SESSION['mensagem_erro'] = "Usuário inválido.";
    header("Location: /public/views/master/usuarios.php");
    exit;
}

$stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$_SESSION['mensagem_sucesso'] = "Usuário excluído com sucesso!";
header("Location: /public/views/master/usuarios.php");
exit;
