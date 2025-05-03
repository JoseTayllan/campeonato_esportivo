<?php
// Proteger contra acesso direto
if (!isset($_SERVER['HTTP_REFERER']) || empty($_SERVER['HTTP_REFERER'])) {
    echo "<div style='text-align:center; padding:20px; font-family:sans-serif;'>
            <h2 style='color:red;'>Erro: Acesso direto não permitido!</h2>
            <p>Utilize o sistema normalmente para acessar esta página.</p>
          </div>";
    exit();
} 
session_start();
$restrito_para = ['Organizador'];
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
<?php include '../cabecalho/tabela.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Painel do Organizador</title>
    <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">

<div class="container mt-4">
    <h2 class="text-center mb-4">Painel do Organizador</h2>

    <!-- Cartões com totais (tom único escuro) -->
<div class="row text-center">
    <div class="col-md-4 mb-4">
        <div class="card text-white border-0 shadow-sm p-4" style="background-color: #343a40;">
            <h3 class="fw-bold mb-1"><?= $totalCampeonatos ?></h3>
            <p class="mb-0"><i class="bi bi-flag-fill me-1"></i>Campeonatos Cadastrados</p>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card text-white border-0 shadow-sm p-4" style="background-color: #343a40;">
            <h3 class="fw-bold mb-1"><?= $totalTimes ?></h3>
            <p class="mb-0"><i class="bi bi-people-fill me-1"></i>Times Registrados</p>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card text-white border-0 shadow-sm p-4" style="background-color: #343a40;">
            <h3 class="fw-bold mb-1"><?= $totalJogadores ?></h3>
            <p class="mb-0"><i class="bi bi-person-fill me-1"></i>Jogadores Ativos</p>
        </div>
    </div>
</div>

<!-- Ações rápidas (mesma paleta escura) -->
<div class="row text-center mb-5">
   
    <div class="col-md-4 mb-3">
        <a href="../campeonatos/visualizar_fases_rodadas.php" class="btn btn-dark w-100 py-2">
            <i class="bi bi-diagram-3 me-1"></i> Fases e Rodadas
        </a>
    </div>
</div>


    <!-- Tabela de campeonatos -->
    <div class="row mt-5">
        <div class="col-md-12">
            <h4 class="mb-3">Campeonatos Registrados</h4>
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
                        $organizador_id = $_SESSION['usuario_id'];

                        $stmt = $conn->prepare("
                            SELECT * FROM campeonatos 
                            WHERE criado_por = (
                                SELECT criado_por FROM usuarios WHERE id = ?
                            )
                            ORDER BY criado_em DESC
                        ");
                        $stmt->bind_param("i", $organizador_id);
                        $stmt->execute();
                        $listar = $stmt->get_result();
                        if ($listar->num_rows > 0) {
                            while ($c = $listar->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $c['id'] ?></td>
                                    <td><?= htmlspecialchars($c['nome']) ?></td>
                                    <td><?= htmlspecialchars($c['temporada']) ?></td>
                                    <td><?= htmlspecialchars($c['formato']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($c['criado_em'])) ?></td>
                                    <td>
                                        <a href="/campeonato_esportivo/routes/adms/campeonato_editar.php?id=<?= $c['id'] ?>" class="btn btn-sm btn-primary">Editar</a>
                                    </td>
                                </tr>
                                <?php
                                
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

<!-- Rodapé fixado ao final -->
<div class="mt-auto">
    <?php include '../cabecalho/footer.php'; ?>
</div>

<script src="../../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
