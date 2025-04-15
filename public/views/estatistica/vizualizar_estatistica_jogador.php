<?php 
session_start();
$restrito_para = ['Administrador', 'Organizador', 'Treinador', 'Jogador', 'Olheiro'];
require_once __DIR__ . '/../../../app/middleware/verifica_sessao.php';
require_once __DIR__ . '/../../../config/database.php'; // Conexão com o banco
?>

<?php include '../cabecalho/header.php'; ?>
<?php include '../cabecalho/tabela.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estatísticas dos Jogadores</title>
    <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <div class="container mt-4">
        <h2 class="mb-4">Exportação de Estatísticas do Jogador</h2>

        <?php include '../partials/mensagens.php'; ?>

        <!-- Filtro para Exportação -->
        <div class="card mb-4">
            <div class="card-header">Selecione um Jogador para Exportar Todos os Dados</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <label for="selecionar_jogador" class="form-label">Jogador</label>
                        <select class="form-control" id="selecionar_jogador">
                            <option value="">Selecione um jogador</option>
                            <?php
                        $queryJogadores = "SELECT id, nome FROM jogadores ORDER BY nome ASC";
                        $resultJogadores = $conn->query($queryJogadores);
                        while ($row = $resultJogadores->fetch_assoc()) {
                            echo "<option value='{$row['id']}'>{$row['nome']}</option>";
                        }
                        ?>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <a id="exportar_csv" href="#" class="btn btn-success me-2 disabled">📂 Exportar CSV</a>
                        <a id="exportar_pdf" href="#" class="btn btn-danger disabled">📄 Exportar PDF</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estatísticas dos Jogadores por Partida -->
        <h2 class="mb-4">Estatísticas dos Jogadores por Partida</h2>

        <!-- Filtros da Tabela -->
        <form method="GET" class="mb-4">
            <div class="row g-3">
                <!-- Filtro por Partida -->
                <div class="col-md-6">
                    <label for="partida_id" class="form-label">Filtrar por Partida</label>
                    <select class="form-control" name="partida_id">
                        <option value="">Todas as Partidas</option>
                        <?php
                    $queryPartidas = "SELECT DISTINCT partida_id FROM estatisticas_partida ORDER BY partida_id DESC";
                    $resultPartidas = $conn->query($queryPartidas);
                    while ($row = $resultPartidas->fetch_assoc()) {
                        $selected = (isset($_GET['partida_id']) && $_GET['partida_id'] == $row['partida_id']) ? "selected" : "";
                        echo "<option value='{$row['partida_id']}' $selected>Partida #{$row['partida_id']}</option>";
                    }
                    ?>
                    </select>
                </div>

                <!-- Filtro por Nome do Jogador -->
                <div class="col-md-6">
                    <label for="jogador_nome" class="form-label">Filtrar por Nome do Jogador</label>
                    <input type="text" class="form-control" name="jogador_nome" placeholder="Digite o nome do jogador"
                        value="<?= isset($_GET['jogador_nome']) ? htmlspecialchars($_GET['jogador_nome']) : '' ?>">
                </div>

                <!-- Botão de Filtrar -->
                <div class="col-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">🔍 Filtrar</button>
                </div>
            </div>
        </form>

        <div class="content">
            <div class="table-responsive">
                <!-- Mensagem de aviso para mobile -->
                <div class="alert alert-warning text-center d-block d-md-none" role="alert">
                    📢 Arraste para o lado para visualizar toda a tabela!
                </div>

                <table class="table table-striped table-bordered text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-nowrap">Partida</th>
                            <th class="text-nowrap">Jogador</th>
                            <th class="text-nowrap">Gols</th>
                            <th class="text-nowrap">Assistências</th>
                            <th class="text-nowrap">Passes Completos</th>
                            <th class="text-nowrap">Finalizações</th>
                            <th class="text-nowrap">Faltas Cometidas</th>
                            <th class="text-nowrap">Cartões Amarelos</th>
                            <th class="text-nowrap">Cartões Vermelhos</th>
                            <th class="text-nowrap">Minutos Jogados</th>
                            <th class="text-nowrap">Substituições</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                    $query = "SELECT e.partida_id, j.id AS jogador_id, j.nome AS jogador_nome, e.gols, e.assistencias, 
                                     e.passes_completos, e.finalizacoes, e.faltas_cometidas, 
                                     e.cartoes_amarelos, e.cartoes_vermelhos, e.minutos_jogados, e.substituicoes
                              FROM estatisticas_partida e
                              JOIN jogadores j ON e.jogador_id = j.id
                              WHERE 1";

                    // Adiciona filtros se forem preenchidos
                    if (!empty($_GET['partida_id'])) {
                        $query .= " AND e.partida_id = " . intval($_GET['partida_id']);
                    }
                    if (!empty($_GET['jogador_nome'])) {
                        $jogadorNome = $conn->real_escape_string($_GET['jogador_nome']);
                        $query .= " AND j.nome LIKE '%$jogadorNome%'";
                    }

                    $query .= " ORDER BY e.partida_id DESC";

                    $result = $conn->query($query);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td class='text-nowrap'>Partida #{$row['partida_id']}</td>
                                    <td class='text-nowrap'>{$row['jogador_nome']}</td>
                                    <td class='text-nowrap'>{$row['gols']}</td>
                                    <td class='text-nowrap'>{$row['assistencias']}</td>
                                    <td class='text-nowrap'>{$row['passes_completos']}</td>
                                    <td class='text-nowrap'>{$row['finalizacoes']}</td>
                                    <td class='text-nowrap'>{$row['faltas_cometidas']}</td>
                                    <td class='text-nowrap'>{$row['cartoes_amarelos']}</td>
                                    <td class='text-nowrap'>{$row['cartoes_vermelhos']}</td>
                                    <td class='text-nowrap'>{$row['minutos_jogados']}</td>
                                    <td class='text-nowrap'>{$row['substituicoes']}</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='11' class='text-center p-4'>Nenhuma estatística registrada.</td></tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php include '../cabecalho/footer.php'; ?>

    <script>
    $(document).ready(function() {
        $("#selecionar_jogador").on("change", function() {
            var jogadorId = $(this).val();
            if (jogadorId) {
                $("#exportar_csv").removeClass("disabled").attr("href",
                    "../../../routes/export.php?tipo=csv&jogador_id=" + jogadorId);
                $("#exportar_pdf").removeClass("disabled").attr("href",
                    "../../../routes/export.php?tipo=pdf&jogador_id=" + jogadorId);
            } else {
                $("#exportar_csv, #exportar_pdf").addClass("disabled").attr("href", "#");
            }
        });
    });
    </script>

</body>

</html>