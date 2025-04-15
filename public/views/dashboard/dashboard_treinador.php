<?php
session_start();
require_once __DIR__ . '/../../../app/middleware/verifica_sessao.php';
?>

<?php include '../cabecalho/header.php'; ?>
<?php include '../cabecalho/tabela_treinador.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel do Treinador</title>
    <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Painel do Treinador</h2>

    <div class="row">
        <!-- Gerenciar Jogadores -->
        <div class="col-md-4 mb-4">
            <a href="../cadastro/cadastro_jogador.php" class="text-decoration-none">
                <div class="card card-custom text-center p-4 bg-primary text-white">
                    <h5>Gerenciar Jogadores</h5>
                </div>
            </a>
        </div>

        <!-- Acompanhar Estatísticas -->
        <div class="col-md-4 mb-4">
            <a href="../estatistica/vizualizar_estatistica_jogador.php" class="text-decoration-none">
                <div class="card card-custom text-center p-4 bg-success text-white">
                    <h5>Estatísticas dos Jogadores</h5>
                </div>
            </a>
        </div>

        <!-- Avaliações dos Jogadores -->
        <div class="col-md-4 mb-4">
            <a href="../avaliacao/visualizar_avaliacoes.php" class="text-decoration-none">
                <div class="card card-custom text-center p-4 bg-warning text-dark">
                    <h5>Avaliações dos Jogadores</h5>
                </div>
            </a>
        </div>
    </div>
</div>

<?php include '../cabecalho/footer.php'; ?>
<script src="../../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
