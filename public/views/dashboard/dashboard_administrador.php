<?php 
$restrito_para = ['Administrador'];
require_once __DIR__ . '/../../../app/middleware/verifica_sessao.php';
require_once __DIR__ . '/../../../config/database.php';

$queryCampeonatos = "SELECT COUNT(*) AS total FROM campeonatos";
$queryTimes = "SELECT COUNT(*) AS total FROM times";
$queryJogadores = "SELECT COUNT(*) AS total FROM jogadores";

$resultCampeonatos = $conn->query($queryCampeonatos);
$resultTimes = $conn->query($queryTimes);
$resultJogadores = $conn->query($queryJogadores);

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
    <title>Dashboard - Sistema de Campeonatos</title>
    <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-4">
    <h2 class="text-center mb-4">Painel Administrativo</h2>

    <!-- Cartões de estatísticas -->
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

    <!-- Acesso rápido -->
    <div class="row text-center">
        <div class="col-md-4 mb-3">
            <a href="../campeonatos/cadastrar_fase.php" class="btn btn-outline-primary w-100">Cadastrar Fase</a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="../campeonatos/cadastrar_rodada.php" class="btn btn-outline-success w-100">Cadastrar Rodada</a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="../campeonatos/visualizar_fases_rodadas.php" class="btn btn-outline-secondary w-100">Visualizar Fases e Rodadas</a>
        </div>
    </div>

    <!-- Tabela de campeonatos -->
    <div class="row mt-5">
        <div class="col-md-12">
            <h4 class="mb-3">Lista de Campeonatos</h4>
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Temporada</th>
                            <th>Formato</th>
                            <th>Criado em</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $listar = $conn->query("SELECT * FROM campeonatos ORDER BY criado_em DESC");
                        if ($listar->num_rows > 0) {
                            while ($c = $listar->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$c['id']}</td>
                                        <td>{$c['nome']}</td>
                                        <td>{$c['temporada']}</td>
                                        <td>{$c['formato']}</td>
                                        <td>" . date('d/m/Y', strtotime($c['criado_em'])) . "</td>
                                        <td><span class='badge bg-secondary'>Em Desenvolvimento</span></td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>Nenhum campeonato encontrado.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?php include '../cabecalho/footer.php'; ?>
<script src="../../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
