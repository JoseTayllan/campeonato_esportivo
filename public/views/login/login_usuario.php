<?php 
session_start();
?>
<?php include '../cabecalho/header.php'; ?>
<?php include '../cabecalho/tabela.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Campeonatos</title>
    <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .login-container h3 {
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h3>Login</h3>

        <?php include '../partials/mensagens.php'; ?>

        <form action="../../../controllers/LoginController.php" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" class="form-control" id="senha" name="senha" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </form>

        <div class="text-center mt-3">
            <a href="../cadastro/cadastro_usuario.php">Criar uma conta</a>
        </div>
    </div>
    <?php include '../cabecalho/footer.php'; ?>
    <script src="../../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
