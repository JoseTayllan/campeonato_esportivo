<?php 
session_start();
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
    <title>Visualização de Avaliações</title>
    <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <div class="container mt-4">
        <h2 class="mb-4">Exportação de Avaliações do Jogador</h2>

        <!-- Seção de Exportação de Avaliações -->
        <div class="card mb-4">
            <div class="card-header">📥 Selecione um Jogador para Exportar Todas as Avaliações</div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <label for="selecionar_jogador" class="form-label">Jogador</label>
                        <select id="selecionar_jogador" class="form-control">
                            <option value="">Selecione um jogador</option>
                            <?php
                            $jogadorQuery = "SELECT id, nome FROM jogadores ORDER BY nome ASC";
                            $jogadorResult = $conn->query($jogadorQuery);
                            while ($jogador = $jogadorResult->fetch_assoc()) {
                                echo "<option value='{$jogador['id']}'>{$jogador['nome']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-6 d-flex justify-content-end align-items-center">
                        <a id="exportar_csv" href="#" class="btn btn-success me-2 disabled">📂 Exportar CSV</a>
                        <a id="exportar_pdf" href="#" class="btn btn-danger disabled">📄 Exportar PDF</a>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="mb-4">Avaliações dos Jogadores</h2>

        <!-- Botão de acesso à página de Avaliação -->
        <div class="d-flex justify-content-end mb-3">
            <a href="avaliar_jogador.php" class="btn btn-primary">
                <i class="bi bi-pencil-square"></i> Avaliar Jogador
            </a>
        </div>

        <!-- Filtros -->
        <form method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-6 mb-2">
                    <input type="text" name="jogador" class="form-control" placeholder="Filtrar por jogador"
                        value="<?= isset($_GET['jogador']) ? htmlspecialchars($_GET['jogador']) : '' ?>">
                </div>
                <div class="col-md-4 mb-2">
                    <select name="olheiro" class="form-control">
                        <option value="">Todos os Olheiros</option>
                        <?php
                        $olheiroQuery = "SELECT id, nome FROM usuarios WHERE tipo = 'Olheiro'";
                        $olheiroResult = $conn->query($olheiroQuery);
                        while ($olheiro = $olheiroResult->fetch_assoc()) {
                            $selected = (isset($_GET['olheiro']) && $_GET['olheiro'] == $olheiro['id']) ? 'selected' : '';
                            echo "<option value='{$olheiro['id']}' $selected>{$olheiro['nome']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">🔍 Filtrar</button>
                </div>
            </div>
        </form>

        <div class="content">
            <div class="table-responsive">
                <div class="alert alert-warning text-center d-block d-md-none" role="alert">
                    📢 Arraste para o lado para visualizar toda a tabela!
                </div>

                <table class="table table-striped table-bordered text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-nowrap">Jogador</th>
                            <th class="text-nowrap">Olheiro</th>
                            <th class="text-nowrap">Força</th>
                            <th class="text-nowrap">Velocidade</th>
                            <th class="text-nowrap">Drible</th>
                            <th class="text-nowrap">Finalização</th>
                            <th class="text-nowrap">Nota Geral</th>
                            <th class="text-nowrap">Observações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $whereClauses = [];
                        if (!empty($_GET['jogador'])) {
                            $jogador = $conn->real_escape_string($_GET['jogador']);
                            $whereClauses[] = "j.nome LIKE '%$jogador%'";
                        }
                        if (!empty($_GET['olheiro'])) {
                            $olheiro = $conn->real_escape_string($_GET['olheiro']);
                            $whereClauses[] = "u.id = '$olheiro'";
                        }

                        $whereSQL = !empty($whereClauses) ? "WHERE " . implode(" AND ", $whereClauses) : "";

                        $query = "SELECT a.forca, a.velocidade, a.drible, a.finalizacao, 
                                        a.nota_geral, a.observacoes, j.nome AS jogador_nome, 
                                        u.nome AS olheiro_nome
                                FROM avaliacoes a
                                JOIN jogadores j ON a.jogador_id = j.id
                                JOIN usuarios u ON a.olheiro_id = u.id
                                $whereSQL
                                ORDER BY a.nota_geral DESC";

                        $result = $conn->query($query);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td class='text-nowrap'>{$row['jogador_nome']}</td>
                                        <td class='text-nowrap'>{$row['olheiro_nome']}</td>
                                        <td class='text-nowrap'>{$row['forca']}</td>
                                        <td class='text-nowrap'>{$row['velocidade']}</td>
                                        <td class='text-nowrap'>{$row['drible']}</td>
                                        <td class='text-nowrap'>{$row['finalizacao']}</td>
                                        <td class='text-nowrap'>{$row['nota_geral']}</td>
                                        <td class='text-nowrap'>{$row['observacoes']}</td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8' class='text-center p-4'>Nenhuma avaliação encontrada.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php include '../cabecalho/footer.php'; ?>

    <script src="../../../assets/js/bootstrap.bundle.min.js"></script>
    <script>
    document.getElementById("selecionar_jogador").addEventListener("change", function() {
        let jogadorId = this.value;
        if (jogadorId) {
            document.getElementById("exportar_csv").classList.remove("disabled");
            document.getElementById("exportar_pdf").classList.remove("disabled");
            document.getElementById("exportar_csv").href =
                "../../../routes/exportar_dados.php?tipo=csv&jogador_id=" + jogadorId;
            document.getElementById("exportar_pdf").href =
                "../../../routes/exportar_dados.php?tipo=pdf&jogador_id=" + jogadorId;
        } else {
            document.getElementById("exportar_csv").classList.add("disabled");
            document.getElementById("exportar_pdf").classList.add("disabled");
            document.getElementById("exportar_csv").href = "#";
            document.getElementById("exportar_pdf").href = "#";
        }
    });
    </script>
</body>

</html>
