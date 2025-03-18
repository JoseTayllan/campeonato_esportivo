<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistema de Campeonatos</title>
    <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .dashboard-container {
            max-width: 1100px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .dashboard-title {
            text-align: center;
            margin-bottom: 20px;
        }
        .card-summary {
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            color: white;
        }
        .card-summary h3 {
            font-size: 24px;
            margin-bottom: 5px;
        }
        .card-summary p {
            font-size: 16px;
        }
    </style>
</head>
<body>

    <?php include '../cabecalho/header.php'; ?>
    <?php include '../cabecalho/tabela_administrativa.php'; ?>

    <div class="container dashboard-container">
        <h2 class="dashboard-title">Painel Administrativo</h2>

        <!-- Estatísticas do Sistema -->
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card-summary bg-primary">
                    <h3>12</h3>
                    <p>Campeonatos Cadastrados</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card-summary bg-success">
                    <h3>24</h3>
                    <p>Times Registrados</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card-summary bg-warning text-dark">
                    <h3>132</h3>
                    <p>Jogadores Ativos</p>
                </div>
            </div>
        </div>

        <!-- Acesso Rápido -->
        <div class="row">
            <div class="col-md-6 col-lg-4 mb-4">
                <a href="../campeonatos/index.php" class="text-decoration-none">
                    <div class="card card-custom text-center p-4 bg-info text-white">
                        <h4>Gerenciar Campeonatos</h4>
                    </div>
                </a>
            </div>

            <div class="col-md-6 col-lg-4 mb-4">
                <a href="../cadastro/cadastro_time.php" class="text-decoration-none">
                    <div class="card card-custom text-center p-4 bg-secondary text-white">
                        <h4>Gerenciar Times</h4>
                    </div>
                </a>
            </div>

            <div class="col-md-6 col-lg-4 mb-4">
                <a href="../cadastro/cadastro_jogador.php" class="text-decoration-none">
                    <div class="card card-custom text-center p-4 bg-danger text-white">
                        <h4>Gerenciar Jogadores</h4>
                    </div>
                </a>
            </div>
        </div>

        <!-- Espaço para Gráficos e Estatísticas Futuras -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card p-4">
                    <h4>Gráficos e Estatísticas (Em Desenvolvimento)</h4>
                    <p>Aqui serão adicionados gráficos sobre campeonatos, desempenho dos times e estatísticas dos jogadores.</p>
                </div>
            </div>
        </div>

    </div>
    <?php include '../cabecalho/footer.php'; ?>
    <script src="../../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
