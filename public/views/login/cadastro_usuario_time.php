<?php require_once __DIR__ . '/../../includes/index_login.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro - Time Essencial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
<body class="d-flex flex-column min-vh-100 bg-light">

<main class="flex-grow-1">
    <div class="container py-5">
        <div class="card p-4 shadow mx-auto" style="max-width: 500px;">
            <h4 class="mb-4 text-center"><i class="bi bi-people-fill me-2"></i>Cadastro - Time Essencial</h4>

            <?php if (isset($_GET['erro'])): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($_GET['erro']) ?></div>
            <?php endif; ?>

            <form action="../../../routes/registrar/registrar_usuario.php" method="POST">       
                <input type="hidden" name="tipo" value="Administrador">
                <input type="hidden" name="tipo_assinatura" value="time">

                <div class="mb-3">
                    <label class="form-label">Nome</label>
                    <input type="text" name="nome" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Senha</label>
                    <input type="password" name="senha" class="form-control" required>
                </div>

                <button class="btn btn-dark w-100 mb-2">Cadastrar</button>
                <a href="../login/login.php" class="btn btn-outline-dark w-100">Voltar</a>
            </form>
        </div>
    </div>
</main>

<?php include '../cabecalho/footer.php'; ?>
<script src="/campeonato_esportivo/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
