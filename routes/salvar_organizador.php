<?php
session_start();
require_once __DIR__ . '/../config/database.php';

$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
$tipo = 'Organizador';
$criado_por = $_SESSION['usuario_id'];

// Verifica se o e-mail já está cadastrado
$verifica = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
$verifica->bind_param("s", $email);
$verifica->execute();
$verifica->store_result();

if ($verifica->num_rows > 0) {
    $_SESSION['mensagem_erro'] = "Já existe um organizador cadastrado com este e-mail. Por favor, use outro e-mail.";
    header("Location: /campeonato_esportivo/routes/adms/cadastro_organizador.php");
    exit;
}
$verifica->close();

// Insere novo organizador
$stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha, tipo, criado_por) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssssi", $nome, $email, $senha, $tipo, $criado_por);

if ($stmt->execute()) {
    $_SESSION['mensagem_sucesso'] = "Organizador cadastrado com sucesso!";
} else {
    $_SESSION['mensagem_erro'] = "Erro ao cadastrar organizador.";
}

header("Location: /campeonato_esportivo/routes/adms/cadastro_organizador.php");
exit;
