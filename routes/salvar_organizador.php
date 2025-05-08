<?php
session_start();
require_once __DIR__ . '/../config/database.php';

$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
$tipo = 'Organizador';
$criado_por = $_SESSION['usuario_id'];

$stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha, tipo, criado_por) VALUES (?, ?, ?, ?, ?)");
$stmt->bindValue(1, $nome, PDO::PARAM_STR);
    $stmt->bindValue(2, $email, PDO::PARAM_STR);
    $stmt->bindValue(3, $senha, PDO::PARAM_STR);
    $stmt->bindValue(4, $tipo, PDO::PARAM_STR);
    $stmt->bindValue(5, $criado_por, PDO::PARAM_INT);

if ($stmt->execute()) {
    $_SESSION['mensagem_sucesso'] = "Organizador cadastrado com sucesso!";
    header("Location: /routes/adms/cadastro_organizador.php");
} else {
    $_SESSION['mensagem_erro'] = "Erro ao cadastrar organizador.";
    header("Location: /routes/adms/cadastro_organizador.php ");
}
exit;
