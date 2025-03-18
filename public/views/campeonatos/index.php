<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Campeonatos</title>
    <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
    </style>
</head>
<body>

    <?php include '../cabecalho/header.php'; ?>
    <?php include '../cabecalho/tabela_administrativa.php'; ?>
    <div class="container">
        <h2 class="mb-4">Campeonatos Cadastrados</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Temporada</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Copa Nacional</td>
                    <td>2024</td>
                    <td>
                        <button class="btn btn-secondary btn-sm" disabled>Detalhes (Em Desenvolvimento)</button>
                        <button class="btn btn-secondary btn-sm" disabled>Editar (Em Desenvolvimento)</button>
                        <button class="btn btn-secondary btn-sm" disabled>Excluir (Em Desenvolvimento)</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="alert alert-info mt-4">
            ⚠️ As funcionalidades de edição, exclusão e detalhes dos campeonatos estão em desenvolvimento.
        </div>
    </div>
    <?php include '../cabecalho/footer.php'; ?>
    <script src="../../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
