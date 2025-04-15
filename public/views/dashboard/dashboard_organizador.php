<?php
session_start();
require_once __DIR__ . '/../../../app/middleware/verifica_sessao.php';
?>

<?php include '../cabecalho/header.php'; ?>
<?php include '../cabecalho/tabela.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel do Organizador</title>
    <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4 text-center">Painel do Organizador</h2>

    <div class="row justify-content-center">
        <div class="col-md-4 mb-3">
            <a href="../campeonatos/index.php" class="text-decoration-none">
                <div class="card text-white bg-primary p-4 text-center">
                    <h5 class="card-title">Gerenciar Campeonatos</h5>
                    <p class="card-text">Acesse todos os campeonatos cadastrados e organize seus torneios.</p>
                </div>
            </a>
        </div>

        <div class="col-md-4 mb-3">
            <a href="../cadastro/cadastro_time.php" class="text-decoration-none">
                <div class="card text-white bg-success p-4 text-center">
                    <h5 class="card-title">Cadastrar Times</h5>
                    <p class="card-text">Adicione novos times aos seus campeonatos.</p>
                </div>
            </a>
        </div>

        <div class="col-md-4 mb-3">
            <a href="../cadastro/cadastro_jogador.php" class="text-decoration-none">
                <div class="card text-white bg-danger p-4 text-center">
                    <h5 class="card-title">Cadastrar Jogadores</h5>
                    <p class="card-text">Inclua jogadores para formação dos times participantes.</p>
                </div>
            </a>
        </div>
    </div>
</div>

<?php include '../cabecalho/footer.php'; ?>
<script src="../../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
