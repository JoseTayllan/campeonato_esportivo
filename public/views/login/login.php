<?php 
session_start();
require_once __DIR__ . '/../../../config/database.php';
include '../cabecalho/header.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom, #0d0d0d, #f8f9fa);
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
                <h4><i class="bi bi-shield-lock-fill me-2"></i>Acesso ao Sistema</h4>
            </div>
            <div class="card-body bg-white">
                
                <?php include '../partials/mensagens.php'; ?>

                <form action="../../../routes/login.php" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" name="email" required placeholder="Digite seu e-mail">
                    </div>

                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" class="form-control" name="senha" required placeholder="Digite sua senha">
                    </div>

                    <button type="submit" class="btn btn-dark w-100">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Entrar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../cabecalho/footer.php'; ?>
<script src="../../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
