<?php
// Proteger contra acesso direto
if (!isset($_SERVER['HTTP_REFERER']) || empty($_SERVER['HTTP_REFERER'])) {
    echo "<div style='text-align:center; padding:20px; font-family:sans-serif;'>
            <h2 style='color:red;'>Erro: Acesso direto não permitido!</h2>
            <p>Utilize o sistema normalmente para acessar esta página.</p>
          </div>";
    exit();
}

$restrito_para = ['Administrador'];
require_once __DIR__ . '/../../../app/middleware/verifica_sessao.php';
require_once __DIR__ . '/../../../config/database.php';

// ID do administrador
$usuario_id = $_SESSION['usuario_id'] ?? null;
if (!$usuario_id) {
    echo "<div style='text-align:center; padding:20px; font-family:sans-serif;'>
            <h2 style='color:red;'>Erro: Sessão inválida!</h2>
            <p>Faça login novamente.</p>
          </div>";
    exit();
}

// Total de campeonatos criados pelo admin
$stmt = $conn->prepare("SELECT id FROM campeonatos WHERE criado_por = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$campeonatos_result = $stmt->get_result();
$campeonato_ids = [];
while ($row = $campeonatos_result->fetch_assoc()) {
    $campeonato_ids[] = $row['id'];
}
$totalCampeonatos = count($campeonato_ids);

// Total de times vinculados aos campeonatos criados por este admin
$totalTimes = 0;
$totalJogadores = 0;

if ($totalCampeonatos > 0) {
    $placeholders = implode(',', array_fill(0, count($campeonato_ids), '?'));

    // Buscar times vinculados a esses campeonatos
    $types = str_repeat('i', count($campeonato_ids));
    $sqlTimes = "SELECT COUNT(DISTINCT tc.time_id) AS total FROM times_campeonatos tc
                 JOIN campeonatos c ON c.id = tc.campeonato_id
                 WHERE c.criado_por = ?";
    $stmtTimes = $conn->prepare($sqlTimes);
    $stmtTimes->bind_param("i", $usuario_id);
    $stmtTimes->execute();
    $resultTimes = $stmtTimes->get_result();
    $totalTimes = $resultTimes->fetch_assoc()['total'] ?? 0;

    // Buscar jogadores vinculados aos times desses campeonatos
    $sqlJogadores = "
        SELECT COUNT(DISTINCT j.id) AS total
        FROM jogadores j
        JOIN times t ON j.time_id = t.id
        JOIN times_campeonatos tc ON tc.time_id = t.id
        JOIN campeonatos c ON c.id = tc.campeonato_id
        WHERE c.criado_por = ?
    ";
    $stmtJogadores = $conn->prepare($sqlJogadores);
    $stmtJogadores->bind_param("i", $usuario_id);
    $stmtJogadores->execute();
    $resultJogadores = $stmtJogadores->get_result();
    $totalJogadores = $resultJogadores->fetch_assoc()['total'] ?? 0;
}
?>

<?php include_once '../../includes/admin_header.php'; ?>


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
            <div class="card text-white border-0 shadow-sm p-4" style="background-color: #343a40;">
                <h3 class="fw-bold mb-1"><?= $totalCampeonatos ?></h3>
                <p class="mb-0"><i class="bi bi-flag-fill me-1"></i>Campeonatos Cadastrados</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card text-white border-0 shadow-sm p-4" style="background-color: #343a40;">
                <h3 class="fw-bold mb-1"><?= $totalTimes ?></h3>
                <p class="mb-0"><i class="bi bi-people-fill me-1"></i>Times Vinculados</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card text-white border-0 shadow-sm p-4" style="background-color: #343a40;">
                <h3 class="fw-bold mb-1"><?= $totalJogadores ?></h3>
                <p class="mb-0"><i class="bi bi-person-fill me-1"></i>Jogadores Ativos</p>
            </div>
        </div>
    </div>

    <!-- Acesso rápido -->
    <div class="row text-center mb-5">
        <div class="col-md-4 mb-3">
            <a href="../cadastro/cadastro_campeonato.php" class="btn btn-dark w-100 py-2">
                <i class="bi bi-plus-circle me-1"></i> Cadastrar Campeonato
            </a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="/campeonato_esportivo/routes/adms/meus_campeonatos.php" class="btn btn-outline-primary w-100 py-2">
                <i class="bi bi-trophy-fill me-1"></i> Meus Campeonatos
            </a>
        </div>
        <div class="col-md-6 mb-3">
            <a href="/campeonato_esportivo/routes/adms/cadastro_organizador.php" class="btn btn-outline-primary w-100 py-2">
                ➕ Cadastrar Novo Organizador
            </a>
        </div>
        <div class="col-md-6 mb-3">
            <a href="../../../routes/adms/aovivo/gerenciar_partidas.php" class="btn btn-outline-primary w-100 py-2">
                ⚙️ Gerenciar Partidas
            </a>
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
                        $listar = $conn->prepare("SELECT * FROM campeonatos WHERE criado_por = ? ORDER BY criado_em DESC");
                        $listar->bind_param("i", $usuario_id);
                        $listar->execute();
                        $result = $listar->get_result();

                        if ($result->num_rows > 0) {
                            while ($c = $result->fetch_assoc()) {
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
