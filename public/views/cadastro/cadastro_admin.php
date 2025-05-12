<?php 
session_start();
require_once __DIR__ . '/../../../config/database.php';
include __DIR__ . '../../../includes/index_login.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Administrador</title>
    <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom, rgb(13, 27, 175), #f8f9fa);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .login-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .card-login {
            border: none;
            border-radius: 12px;
            overflow: hidden;
        }

        .card-login .card-header {
            background-color: #1a1a1a;
        }

        .form-label {
            font-weight: 500;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="col-md-4">
        <div class="card card-login shadow-lg">
            <div class="card-header text-white text-center">
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

<?php include '../cabecalho/footer.php'; ?>
<script src="../../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
