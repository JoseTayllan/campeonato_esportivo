<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/Models/Usuario.php';

session_start();

$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';
$tipo = $_POST['tipo'] ?? 'Administrador';
$tipo_assinatura = $_POST['tipo_assinatura'] ?? 'completo';

if (empty($nome) || empty($email) || empty($senha)) {
    header("Location: ../../public/views/login/cadastro_usuario_time.php?erro=Preencha todos os campos");
    exit();
}

$userModel = new User($conn);

// Verificar se já existe
if ($userModel->emailExiste($email)) {
    header("Location: ../../public/views/login/cadastro_usuario_time.php?erro=E-mail já cadastrado");
    exit();
}

$hash = password_hash($senha, PASSWORD_DEFAULT);
$userModel->criarUsuario($nome, $email, $hash, $tipo, $tipo_assinatura);

// Login automático pós-cadastro
$_SESSION['usuario'] = [
    'id' => $conn->insert_id,
    'nome' => $nome,
    'tipo' => $tipo,
    'tipo_assinatura' => $tipo_assinatura
];

header("Location: ../../public/views/login/login.php");
exit();
?>
