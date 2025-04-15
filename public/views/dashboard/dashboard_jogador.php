<?php
session_start();
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../app/middleware/verifica_sessao.php';
include '../cabecalho/header.php';
include '../cabecalho/tabela_jogador.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard do Jogador</title>
    <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4 mb-5">
    <h2 class="mb-4">Painel do Jogador</h2>

    <!-- Dropdown de seleção de jogador -->
    <form method="GET" class="mb-4">
        <div class="input-group">
            <select class="form-select" name="jogador" required>
                <option value="">🔍 Selecione seu nome</option>
                <?php
                $query = "SELECT nome FROM jogadores ORDER BY nome ASC";
                $res = $conn->query($query);
                while ($row = $res->fetch_assoc()) {
                    $selected = (isset($_GET['jogador']) && $_GET['jogador'] == $row['nome']) ? 'selected' : '';
                    echo "<option value='{$row['nome']}' $selected>{$row['nome']}</option>";
                }
                ?>
            </select>
            <button class="btn btn-primary">Buscar</button>
        </div>
    </form>

    <!-- Cards de funcionalidades -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card text-center shadow">
                <div class="card-body">
                    <h5 class="card-title">📊 Avaliações</h5>
                    <p class="card-text">Visualize suas avaliações feitas pelos olheiros.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-center shadow">
                <div class="card-body">
                    <h5 class="card-title">📈 Estatísticas</h5>
                    <p class="card-text">Consulte seu desempenho por partida.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-center shadow">
                <div class="card-body">
                    <h5 class="card-title">📅 Próximas Partidas</h5>
                    <p class="card-text">Veja as datas dos próximos jogos do seu time.</p>
                </div>
            </div>
        </div>
    </div>

    <?php if (!empty($_GET['jogador'])): ?>
        <?php $nome = $conn->real_escape_string($_GET['jogador']); ?>

        <!-- Avaliações -->
        <h4 class="mt-4">Suas Avaliações</h4>
        <div class="table-responsive mb-4">
            <table class="table table-striped table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Olheiro</th>
                        <th>Força</th>
                        <th>Velocidade</th>
                        <th>Drible</th>
                        <th>Finalização</th>
                        <th>Nota Geral</th>
                        <th>Observações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT u.nome AS olheiro, a.forca, a.velocidade, a.drible, a.finalizacao, a.nota_geral, a.observacoes
                              FROM avaliacoes a
                              JOIN jogadores j ON a.jogador_id = j.id
                              JOIN usuarios u ON a.olheiro_id = u.id
                              WHERE j.nome LIKE '%$nome%'
                              ORDER BY a.nota_geral DESC";
                    $res = $conn->query($query);
                    if ($res->num_rows > 0) {
                        while ($r = $res->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$r['olheiro']}</td>
                                    <td>{$r['forca']}</td>
                                    <td>{$r['velocidade']}</td>
                                    <td>{$r['drible']}</td>
                                    <td>{$r['finalizacao']}</td>
                                    <td>{$r['nota_geral']}</td>
                                    <td>{$r['observacoes']}</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>Nenhuma avaliação encontrada.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Estatísticas -->
        <h4>Suas Estatísticas por Partida</h4>
        <div class="table-responsive mb-4">
            <table class="table table-striped table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Partida</th>
                        <th>Gols</th>
                        <th>Assistências</th>
                        <th>Passes</th>
                        <th>Finalizações</th>
                        <th>Faltas</th>
                        <th>Amarelos</th>
                        <th>Vermelhos</th>
                        <th>Minutos</th>
                        <th>Substituições</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT e.partida_id, e.gols, e.assistencias, e.passes_completos, e.finalizacoes,
                                     e.faltas_cometidas, e.cartoes_amarelos, e.cartoes_vermelhos,
                                     e.minutos_jogados, e.substituicoes
                              FROM estatisticas_partida e
                              JOIN jogadores j ON e.jogador_id = j.id
                              WHERE j.nome LIKE '%$nome%'
                              ORDER BY e.partida_id DESC";
                    $res = $conn->query($query);
                    if ($res->num_rows > 0) {
                        while ($r = $res->fetch_assoc()) {
                            echo "<tr>
                                    <td>#{$r['partida_id']}</td>
                                    <td>{$r['gols']}</td>
                                    <td>{$r['assistencias']}</td>
                                    <td>{$r['passes_completos']}</td>
                                    <td>{$r['finalizacoes']}</td>
                                    <td>{$r['faltas_cometidas']}</td>
                                    <td>{$r['cartoes_amarelos']}</td>
                                    <td>{$r['cartoes_vermelhos']}</td>
                                    <td>{$r['minutos_jogados']}</td>
                                    <td>{$r['substituicoes']}</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='10'>Nenhuma estatística encontrada.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include '../cabecalho/footer.php'; ?>
<script src="../../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
