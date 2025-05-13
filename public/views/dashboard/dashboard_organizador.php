<?php
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

$organizador_id = $_SESSION['usuario_id'];

// CAMPEONATOS
$stmtTotal = $conn->prepare("
    SELECT COUNT(*) AS total FROM campeonatos 
    WHERE criado_por = (
        SELECT criado_por FROM usuarios WHERE id = ?
    )
");
$stmtTotal->bind_param("i", $organizador_id);
$stmtTotal->execute();
$resTotal = $stmtTotal->get_result();
$totalCampeonatos = ($resTotal->fetch_assoc())['total'] ?? 0;

// TIMES
$stmtTimes = $conn->prepare("
    SELECT COUNT(*) AS total 
    FROM times 
    WHERE id IN (
        SELECT time_id FROM times_campeonatos 
        WHERE campeonato_id IN (
            SELECT id FROM campeonatos 
            WHERE criado_por = (
                SELECT criado_por FROM usuarios WHERE id = ?
            )
        )
    )
");
$stmtTimes->bind_param("i", $organizador_id);
$stmtTimes->execute();
$resTimes = $stmtTimes->get_result();
$totalTimes = ($resTimes->fetch_assoc())['total'] ?? 0;

// JOGADORES
$stmtJogadores = $conn->prepare("
    SELECT COUNT(*) AS total 
    FROM jogadores 
    WHERE time_id IN (
        SELECT id FROM times 
        WHERE id IN (
            SELECT time_id FROM times_campeonatos 
            WHERE campeonato_id IN (
                SELECT id FROM campeonatos 
                WHERE criado_por = (
                    SELECT criado_por FROM usuarios WHERE id = ?
                )
            )
        )
    )
");
$stmtJogadores->bind_param("i", $organizador_id);
$stmtJogadores->execute();
$resJogadores = $stmtJogadores->get_result();
$totalJogadores = ($resJogadores->fetch_assoc())['total'] ?? 0;
?>

<?php include_once __DIR__ . '/../../includes/admin_org.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel do Organizador</title>
    <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
    @media (max-width: 768px) {
        table th, table td {
            font-size: 0.85rem;
            white-space: nowrap;
        }
        .table {
            font-size: 0.9rem;
        }
    }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

<div class="container mt-4">
    <h2 class="text-center mb-4">Painel do Organizador</h2>

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

    <div class="row mt-5">
        <div class="col-md-12">
            <h4 class="mb-3">Campeonatos Registrados</h4>
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>Nome</th>
                            <th>Temporada</th>
                            <th>Formato</th>
                            <th>Criado em</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
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
                            echo "<tr><td colspan='5'>Nenhum campeonato encontrado.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="mt-auto">
    <?php include '../cabecalho/footer.php'; ?>
</div>

<script src="../../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
