<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link href="../../assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2 class="mb-4">Cadastro de Usuário</h2>
        
        <?php include 'partials/mensagens.php'; ?>

        <form action="../controllers/UsuarioController.php" method="POST">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome Completo</label>
                <input type="text" class="form-control" name="nome" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" class="form-control" name="senha" required>
            </div>
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo de Usuário</label>
                <select class="form-control" name="tipo" required>
                    <option value="admin">Administrador</option>
                    <option value="organizador">Organizador</option>
                    <option value="tecnico">Técnico</option>
                    <option value="jogador">Jogador</option>
                    <option value="olheiro">Olheiro</option>
                    <option value="patrocinador">Patrocinador</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>
    <script src="../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
