<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Campeonatos</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .card-custom {
            transition: 0.3s;
            border-radius: 10px;
            cursor: pointer;
        }
        .card-custom:hover {
            transform: scale(1.05);
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>

    <div class="container text-center">
        <h1 class="mb-4">Sistema de Gerenciamento de Campeonatos</h1>

        <div class="row justify-content-center">
            <!-- Card de Cadastro de Usuário -->
            <div class="col-md-6 col-lg-3 mb-4">
                <a href="views/cadastro_usuario.php" class="text-decoration-none">
                    <div class="card card-custom text-center p-4 bg-primary text-white">
                        <h4>Cadastro de Usuário</h4>
                    </div>
                </a>
            </div>

            <!-- Card de Cadastro de Campeonato -->
            <div class="col-md-6 col-lg-3 mb-4">
                <a href="views/cadastro_campeonato.php" class="text-decoration-none">
                    <div class="card card-custom text-center p-4 bg-success text-white">
                        <h4>Cadastro de Campeonato</h4>
                    </div>
                </a>
            </div>

            <!-- Card de Cadastro de Time -->
            <div class="col-md-6 col-lg-3 mb-4">
                <a href="views/cadastro_time.php" class="text-decoration-none">
                    <div class="card card-custom text-center p-4 bg-warning text-dark">
                        <h4>Cadastro de Time</h4>
                    </div>
                </a>
            </div>

            <!-- Card de Cadastro de Jogador -->
            <div class="col-md-6 col-lg-3 mb-4">
                <a href="views/cadastro_jogador.php" class="text-decoration-none">
                    <div class="card card-custom text-center p-4 bg-danger text-white">
                        <h4>Cadastro de Jogador</h4>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <?php include 'views/cabecalho/footer.php'; ?>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
