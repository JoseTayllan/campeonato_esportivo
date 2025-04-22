<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro - Time Essencial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="card p-4 shadow">
        <h2>Cadastro - Time Essencial</h2>

        <?php if (isset($_GET['erro'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_GET['erro']) ?></div>
        <?php endif; ?>

        <form action="../../../routes/registrar/registrar_usuario.php" method="POST">
            <input type="hidden" name="tipo" value="Administrador">
            <input type="hidden" name="tipo_assinatura" value="time">

            <div class="mb-3">
                <label>Nome</label>
                <input type="text" name="nome" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Senha</label>
                <input type="password" name="senha" class="form-control" required>
            </div>

            <button class="btn btn-success">Cadastrar</button>
            <a href="../login/login.php" class="btn btn-secondary">Voltar</a>
        </form>
    </div>
</div>

</body>
</html>
