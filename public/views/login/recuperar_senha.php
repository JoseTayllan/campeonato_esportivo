<?php
session_start();
require_once __DIR__ . '/../../../config/database.php';
include __DIR__ . '/../../includes/index_login.php';

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['nova_senha'];
    $confirmar = $_POST['confirmar_senha'];

    // Verifica se o e-mail existe
    $verifica = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $verifica->bind_param("s", $email);
    $verifica->execute();
    $resultado = $verifica->get_result();

    if ($resultado->num_rows === 0) {
        $mensagem = "E-mail não encontrado no sistema.";
    } elseif ($senha !== $confirmar) {
        $mensagem = "As senhas não coincidem.";
    } elseif (strlen($senha) < 6 || !preg_match('/[A-Za-z]/', $senha) || !preg_match('/[0-9]/', $senha)) {
        $mensagem = "A senha deve conter pelo menos 6 caracteres, incluindo letras e números.";
    } else {
        $nova_senha = password_hash($senha, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE usuarios SET senha = ? WHERE email = ?");
        $stmt->bind_param("ss", $nova_senha, $email);

        if ($stmt->execute()) {
            $mensagem = "Senha atualizada com sucesso!";
        } else {
            $mensagem = "Erro ao atualizar a senha.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Senha</title>
    <link href="/campeonato_esportivo/assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container { max-width: 500px; }
        .senha-ajuda { font-size: 0.85rem; color: #666; }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">



<div class="container mt-5 mb-4">
    <h2 class="mb-4 text-center">Recuperar Senha</h2>

    <?php if ($mensagem): ?>
        <div class="alert alert-info"><?= $mensagem ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label>E-mail da conta:</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Nova senha:</label>
            <input type="password" name="nova_senha" id="nova_senha" class="form-control" required oninput="verificarForcaSenha()">
            <div class="senha-ajuda">Mínimo 6 caracteres, com letras e números.</div>
            <div class="progress mt-2">
                <div id="barra-forca" class="progress-bar" role="progressbar" style="width: 0%"></div>
            </div>
            <small id="forca-texto" class="text-muted"></small>
        </div>

        <div class="mb-3">
            <label>Confirmar nova senha:</label>
            <input type="password" name="confirmar_senha" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Atualizar Senha</button>
    </form>
</div>

<div class="mt-auto">
    <?php include __DIR__ . '/../cabecalho/footer.php'; ?>
</div>

<script src="/campeonato_esportivo/assets/js/bootstrap.bundle.min.js"></script>

<script>
function verificarForcaSenha() {
    const senha = document.getElementById('nova_senha').value;
    const barra = document.getElementById('barra-forca');
    const texto = document.getElementById('forca-texto');

    let forca = 0;
    if (senha.length >= 6) forca += 1;
    if (/[A-Z]/.test(senha)) forca += 1;
    if (/[a-z]/.test(senha)) forca += 1;
    if (/[0-9]/.test(senha)) forca += 1;
    if (/[^A-Za-z0-9]/.test(senha)) forca += 1;

    const cores = ['bg-danger', 'bg-warning', 'bg-success']; 
    barra.classList.remove(...cores);

    if (forca <= 2) {
        barra.classList.add('bg-danger');
        barra.style.width = '33%';
        texto.innerText = 'Senha fraca';
    } else if (forca <= 4) {
        barra.classList.add('bg-warning');
        barra.style.width = '66%';
        texto.innerText = 'Senha média';
    } else {
        barra.classList.add('bg-success');
        barra.style.width = '100%';
        texto.innerText = 'Senha forte';
    }
}
</script>

</body>
</html>
