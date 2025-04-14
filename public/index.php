<?php 
session_start();
include 'views/cabecalho/header_index.php'; 
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


<!-- Linha de botões diretamente abaixo do header -->
<div class="container-fluid p-0">
    <div class="d-flex overflow-auto flex-nowrap">
        <table class="table table-borderless table-sm text-center mb-0">
            <tbody>
                <tr class="d-flex">
                    <td class="p-2 flex-shrink-0"><a href="views/cadastro/cadastro_usuario.php" class="btn btn-secondary btn-lg">Cadastro de Usuário</a></td>
                    <td class="p-2 flex-shrink-0"><a href="views/cadastro/cadastro_campeonato.php" class="btn btn-secondary btn-lg">Cadastro de Campeonato</a></td>
                    <td class="p-2 flex-shrink-0"><a href="views/cadastro/cadastro_time.php" class="btn btn-secondary btn-lg">Cadastro de Time</a></td>
                    <td class="p-2 flex-shrink-0"><a href="views/cadastro/cadastro_jogador.php" class="btn btn-secondary btn-lg">Cadastro de Jogador</a></td>
                    <td class="p-2 flex-shrink-0"><a href="views/login/login.php" class="btn btn-secondary btn-lg">Login</a></td>
                    <td class="p-2 flex-shrink-0"><a href="views/avaliacao/avaliar_jogador.php" class="btn btn-secondary btn-lg">Avaliar Jogador</a></td>
                    <td class="p-2 flex-shrink-0"><a href="views/avaliacao/visualizar_avaliacoes.php" class="btn btn-secondary btn-lg">Visualizar Avaliações</a></td>
                    <td class="p-2 flex-shrink-0"><a href="views/estatistica/cadastrar_estatistica_jogador.php" class="btn btn-secondary btn-lg">Cadastro Estatística Por Partida de Jogador</a></td>
                    <td class="p-2 flex-shrink-0"><a href="views/estatistica/vizualizar_estatistica_jogador.php" class="btn btn-secondary btn-lg">Estatística do Jogador</a></td>
                    <td class="p-2 flex-shrink-0"><a href="views/substituicao/cadastrar_substituicao.php" class="btn btn-secondary btn-lg">Cadastrar Substituição</a></td>
                    <td class="p-2 flex-shrink-0"><a href="views/substituicao/listar_substituicOES.php" class="btn btn-secondary btn-lg">Visualizar Substituição</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class="container text-center">
    <h1 class="mb-4">Sistema de Gerenciamento de Campeonatos</h1>

    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-3 mb-4">
            <a href="views/cadastro/cadastro_usuario.php" class="text-decoration-none">
                <div class="card card-custom text-center p-4 bg-primary text-white">
                    <h4>Cadastro de Usuário</h4>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-lg-3 mb-4">
            <a href="views/cadastro/cadastro_campeonato.php" class="text-decoration-none">
                <div class="card card-custom text-center p-4 bg-success text-white">
                    <h4>Cadastro de Campeonato</h4>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-lg-3 mb-4">
            <a href="views/cadastro/cadastro_time.php" class="text-decoration-none">
                <div class="card card-custom text-center p-4 bg-warning text-dark">
                    <h4>Cadastro de Time</h4>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-lg-3 mb-4">
            <a href="views/cadastro/cadastro_jogador.php" class="text-decoration-none">
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
