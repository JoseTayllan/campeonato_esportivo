<?php 
session_start();
require_once __DIR__ . '/../../../config/database.php'; // Conexão com o banco
?>

<?php include '../cabecalho/header.php'; ?>
<?php include '../cabecalho/tabela.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class="container mt-4">
    <h2 class="mb-4">Cadastro de Usuário</h2>

    <?php include '../partials/mensagens.php'; ?>

    <form action="../../../routes/users.php" method="POST">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome Completo</label>
            <input type="text" class="form-control" name="nome" placeholder="Ex: Ana Pereira" required>
        </div>
        
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control" name="email" placeholder="Ex: ana@email.com" required>
        </div>
        
        <div class="mb-3">
            <label for="senha" class="form-label">Senha</label>
            <input type="password" class="form-control" name="senha" placeholder="Crie uma senha segura" required>
            <small class="form-text text-muted">Digite a sua senha conforme sua preferência acima.</small>
        </div>
        
        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo de Usuário</label>
            <select class="form-control" name="tipo" required>
                <option value="">Selecione um tipo</option>
                <option value="Administrador">Administrador</option>
                <option value="Organizador">Organizador</option>
                <option value="Treinador">Treinador</option>
                <option value="Jogador">Jogador</option>
                <option value="Olheiro">Olheiro</option>
                <option value="Patrocinador">Patrocinador</option>
            </select>
            <small class="form-text text-muted">Ex: Organizador, Jogador, Olheiro...</small>
        </div>

        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>
</div>
<div class="row mt-4">
<?php include '../cabecalho/footer.php'; ?>
<script src="../../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
