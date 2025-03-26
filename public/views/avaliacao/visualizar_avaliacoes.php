<?php 
session_start();
require_once __DIR__ . '/../../../config/database.php'; // Conexão com o banco
?>

<?php include '../cabecalho/header.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualização de Avaliações</title>
    <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Ajustes para evitar espaços extras no footer */
        .content {
            min-height: 32vh; /* Garante que o conteúdo ocupe pelo menos 70% da tela */
            display: flex;
            flex-direction: column;
        }
        .content {
            flex-grow: 1;
        }
        footer {
            position: relative;
            bottom: 0;
            width: 100%;
            padding: 10px 0;
        }
    </style>
</head>
<body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class="container mt-4">
    <h2 class="mb-4">Avaliações dos Jogadores</h2>

    <?php include '../partials/mensagens.php'; ?>

    <div class="content">
        <div class="table-responsive">
            <!-- Mensagem de aviso para mobile -->
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
                    $query = "SELECT a.forca, a.velocidade, a.drible, a.finalizacao, 
                                     a.nota_geral, a.observacoes, j.nome AS jogador_nome, 
                                     u.nome AS olheiro_nome
                              FROM avaliacoes a
                              JOIN jogadores j ON a.jogador_id = j.id
                              JOIN usuarios u ON a.olheiro_id = u.id
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
                        echo "<tr><td colspan='8' class='text-center p-4'>Nenhuma avaliação registrada.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../cabecalho/footer.php'; ?>

<script src="../../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
