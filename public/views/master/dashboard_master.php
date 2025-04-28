<?php
$restrito_para = ['Master']; // Agora restrito para tipo 'Master'
require_once __DIR__ . '/../../../app/middleware/verifica_sessao.php';
require_once __DIR__ . '/../../../config/database.php';

// Coletar informações para os cards
$queryCampeonatos = "SELECT COUNT(*) AS total FROM campeonatos";
$queryTimes = "SELECT COUNT(*) AS total FROM times";
$queryJogadores = "SELECT COUNT(*) AS total FROM jogadores";
$queryUsuarios = "SELECT COUNT(*) AS total FROM usuarios";

$resultCampeonatos = $conn->query($queryCampeonatos);
$resultTimes = $conn->query($queryTimes);
$resultJogadores = $conn->query($queryJogadores);
$resultUsuarios = $conn->query($queryUsuarios);

$totalCampeonatos = ($resultCampeonatos->fetch_assoc())['total'] ?? 0;
$totalTimes = ($resultTimes->fetch_assoc())['total'] ?? 0;
$totalJogadores = ($resultJogadores->fetch_assoc())['total'] ?? 0;
$totalUsuarios = ($resultUsuarios->fetch_assoc())['total'] ?? 0;

include '../cabecalho/header.php';
?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Painel Equipe Master</h2>

    <div class="row text-center">
        <div class="col-md-3 mb-4">
            <div class="card text-white bg-dark border-0 shadow-sm p-4">
                <h3 class="fw-bold mb-1"><?= $totalCampeonatos ?></h3>
                <p class="mb-0"><i class="bi bi-flag-fill me-1"></i>Campeonatos</p>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-white bg-dark border-0 shadow-sm p-4">
                <h3 class="fw-bold mb-1"><?= $totalTimes ?></h3>
                <p class="mb-0"><i class="bi bi-people-fill me-1"></i>Times</p>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-white bg-dark border-0 shadow-sm p-4">
                <h3 class="fw-bold mb-1"><?= $totalJogadores ?></h3>
                <p class="mb-0"><i class="bi bi-person-fill me-1"></i>Jogadores</p>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-white bg-dark border-0 shadow-sm p-4">
                <h3 class="fw-bold mb-1"><?= $totalUsuarios ?></h3>
                <p class="mb-0"><i class="bi bi-people me-1"></i>Usuários Cadastrados</p>
            </div>
        </div>
    </div>

    <div class="row text-center mb-5">
        <div class="col-md-4 mb-3">
            <a href="/campeonato_esportivo/routes/placar_publico.php" class="btn btn-dark w-100 py-2">
                📢 Ver Placar Ao Vivo
            </a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="/campeonato_esportivo/routes/ranking.php" class="btn btn-dark w-100 py-2">
                🏆 Ver Ranking Geral
            </a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="/campeonato_esportivo/public/views/master/usuarios.php" class="btn btn-dark w-100 py-2">
                👤 Gerenciar Usuários
            </a>
        </div>
    </div>

    <!-- Tabela de campeonatos cadastrados -->
    <div class="row mt-5">
        <div class="col-md-12">
            <h4 class="mb-3">Todos os Campeonatos</h4>
            <div class="table-responsive">
                <table class="table table-striped table-bordered text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Temporada</th>
                            <th>Formato</th>
                            <th>Data de Criação</th>
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
                                </tr>";
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

<?php include '../cabecalho/footer.php'; ?>
<script src="../../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
