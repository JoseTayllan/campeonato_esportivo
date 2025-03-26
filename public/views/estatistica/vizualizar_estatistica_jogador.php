<?php 
session_start();
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
</head>
<body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class="container mt-4">
    <h2 class="mb-4">Estatísticas dos Jogadores</h2>

    <?php include '../partials/mensagens.php'; ?>

    <!-- Botões de Exportação -->
    <div class="d-flex justify-content-end mb-3">
        <a href="../../../routes/exportar_dados.php?tipo=csv&dados=estatisticas" class="btn btn-success me-2">📂 Exportar CSV</a>
        <a href="../../../routes/exportar_dados.php?tipo=pdf&dados=estatisticas" class="btn btn-danger">📄 Exportar PDF</a>
    </div>

    <!-- Tabela Responsiva -->
    <div class="table-responsive">
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
                $query = "SELECT e.partida_id, p.data AS data_partida, j.nome AS jogador_nome, 
                                 e.gols, e.assistencias, e.passes_completos, e.finalizacoes, 
                                 e.faltas_cometidas, e.cartoes_amarelos, e.cartoes_vermelhos, 
                                 e.minutos_jogados, e.substituicoes
                          FROM estatisticas_partida e
                          JOIN partidas p ON e.partida_id = p.id
                          JOIN jogadores j ON e.jogador_id = j.id
                          ORDER BY p.data DESC";

                $result = $conn->query($query);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td class='text-nowrap'>Partida #{$row['partida_id']} - " . date('d/m/Y', strtotime($row['data_partida'])) . "</td>
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

<?php include '../cabecalho/footer.php'; ?>

<script src="../../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
