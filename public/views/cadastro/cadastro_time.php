<?php 
session_start();
$restrito_para = ['Administrador', 'Organizador'];
require_once __DIR__ . '/../../../app/middleware/verifica_sessao.php';
require_once __DIR__ . '/../../../config/database.php'; // Conexão com o banco
?>

<?php include '../cabecalho/header.php'; ?>
<?php $tipo_usuario = strtolower(trim($_SESSION['usuario_tipo']));
if ($tipo_usuario === 'administrador') {
    include '../cabecalho/tabela_administrativa.php';
} else {
    include '../cabecalho/tabela.php';
} ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Time</title>
    <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <div class="container mt-4">
        <h2 class="mb-4">Cadastro de Time</h2>

        <?php include '../partials/mensagens.php'; ?>

        <form action="../../../routes/team.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome do Time</label>
                <input type="text" class="form-control" name="nome" placeholder="Ex: Estrela FC" required>
            </div>

            <div class="mb-3">
                <label for="escudo" class="form-label">Escudo do Time</label>
                <input type="file" class="form-control" name="escudo">
                <small class="form-text text-muted">Formatos aceitos: JPG, PNG. Tamanho recomendado: 300x300px</small>
            </div>

            <div class="mb-3">
                <label for="cidade" class="form-label">Cidade</label>
                <input type="text" class="form-control" name="cidade" placeholder="Ex: Belo Horizonte" required>
            </div>

            <div class="mb-3">
                <label for="estadio" class="form-label">Estádio</label>
                <input type="text" class="form-control" name="estadio" placeholder="Ex: Arena Central">
            </div>

            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>
    <div class="row mt-4">
        <?php include '../cabecalho/footer.php'; ?>
        <script src="../../../assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>