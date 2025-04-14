<?php 
session_start();
require_once __DIR__ . '/../../../app/middleware/verifica_sessao.php';
require_once __DIR__ . '/../../../config/database.php'; // Conexão com o banco

// Consultas para obter os dados reais do banco
$queryCampeonatos = "SELECT COUNT(*) AS total FROM campeonatos";
$queryTimes = "SELECT COUNT(*) AS total FROM times";
$queryJogadores = "SELECT COUNT(*) AS total FROM jogadores";

// Executa as consultas
$resultCampeonatos = $conn->query($queryCampeonatos);
$resultTimes = $conn->query($queryTimes);
$resultJogadores = $conn->query($queryJogadores);

// Obtém os resultados
$totalCampeonatos = ($resultCampeonatos->fetch_assoc())['total'] ?? 0;
$totalTimes = ($resultTimes->fetch_assoc())['total'] ?? 0;
$totalJogadores = ($resultJogadores->fetch_assoc())['total'] ?? 0;
?>

<?php include '../cabecalho/header.php'; ?>
<?php include '../cabecalho/tabela_administrativa.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistema de Campeonatos</title>
    <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-4">
        <h2 class="text-center">Painel Administrativo</h2>

        <!-- Estatísticas do Sistema -->
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="card bg-primary text-white p-4">
                    <h3><?= $totalCampeonatos ?></h3>
                    <p>Campeonatos Cadastrados</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card bg-success text-white p-4">
                    <h3><?= $totalTimes ?></h3>
                    <p>Times Registrados</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card bg-warning text-dark p-4">
                    <h3><?= $totalJogadores ?></h3>
                    <p>Jogadores Ativos</p>
                </div>
            </div>
        </div>

        <!-- Acesso Rápido -->
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <a href="../campeonatos/index.php" class="btn btn-info w-100 p-3">Gerenciar Campeonatos</a>
            </div>
            <div class="col-md-4 mb-4">
                <a href="../cadastro/cadastro_time.php" class="btn btn-secondary w-100 p-3">Gerenciar Times</a>
            </div>
            <div class="col-md-4 mb-4">
                <a href="../cadastro/cadastro_jogador.php" class="btn btn-danger w-100 p-3">Gerenciar Jogadores</a>
            </div>
        </div>

        <!-- Espaço para Gráficos e Estatísticas Futuras -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card p-4">
                    <h4>Gráficos e Estatísticas (Em Desenvolvimento)</h4>
                    <p>Aqui serão adicionados gráficos sobre campeonatos, desempenho dos times e estatísticas dos
                        jogadores.</p>
                </div>
            </div>
        </div>



    </div>
    <div class="row mt-4">

        <?php include '../cabecalho/footer.php'; ?>
        <script src="../../../assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>