<?php 
session_start();
require_once __DIR__ . '/../../../config/database.php';
include '../cabecalho/header.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Administrador</title>
    <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100 bg-light">

<main class="flex-grow-1">
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header text-center bg-dark text-white">
                    <h4><i class="bi bi-person-plus-fill me-2"></i>Cadastro de Administrador</h4>
                </div>
                <div class="card-body bg-white">
                    <?php include '../partials/mensagens.php'; ?>

                    <form action="../../../routes/users.php" method="POST">
                        <input type="hidden" name="tipo" value="Administrador">

                        <div class="mb-3">
                            <label class="form-label">Nome Completo</label>
                            <input type="text" name="nome" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">E-mail</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Senha</label>
                            <input type="password" name="senha" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-dark w-100 mb-2">Cadastrar</button>
                        <a href="../login/login.php" class="btn btn-outline-dark w-100">Já tem conta? Login</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</main>

<?php include '../cabecalho/footer.php'; ?>
<script src="../../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
