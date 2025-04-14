<?php 
session_start();
require_once __DIR__ . '/../../../app/middleware/verifica_sessao.php';
require_once __DIR__ . '/../../../config/database.php'; // Conexão com o banco

// Consulta para buscar todos os campeonatos cadastrados
$queryCampeonatos = "SELECT nome, temporada, formato, criado_em FROM campeonatos ORDER BY criado_em DESC";
$resultCampeonatos = $conn->query($queryCampeonatos);
?>

<?php include '../cabecalho/header.php'; ?>
<?php include '../cabecalho/tabela_administrativa.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campeonatos Cadastrados</title>
    <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
    /* Garante que a tabela seja responsiva em telas pequenas */
    .table-responsive {
        overflow-x: auto;
        white-space: nowrap;
    }

    /* Estilização da mensagem para dispositivos móveis */
    .mobile-alert {
        display: none;
    }

    /* Exibir a mensagem apenas em telas menores que 768px (dispositivos móveis) */
    @media (max-width: 768px) {
        .mobile-alert {
            display: block;
            text-align: center;
            background-color: #ffcc00;
            color: #000;
            padding: 10px;
            font-weight: bold;
            border-radius: 5px;
            margin-bottom: 10px;
        }
    }
    </style>
</head>

<body>

    <div class="container mt-4">
        <h2 class="text-center">Campeonatos Cadastrados</h2>

        <!-- Mensagem para dispositivos móveis -->
        <div class="mobile-alert">
            📢 Arraste para o lado para visualizar toda a tabela!
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered mt-3">
                <thead class="table-dark text-center">
                    <tr>
                        <th>Nome</th>
                        <th>Temporada</th>
                        <th>Formato</th>
                        <th>Data de Criação</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php if ($resultCampeonatos->num_rows > 0): ?>
                    <?php while ($row = $resultCampeonatos->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nome']) ?></td>
                        <td><?= $row['temporada'] ?></td>
                        <td><?= $row['formato'] ?></td>
                        <td><?= date('d/m/Y', strtotime($row['criado_em'])) ?></td>
                        <td>
                            <button class="btn btn-secondary btn-sm" disabled>Detalhes (Em Desenvolvimento)</button>
                            <button class="btn btn-secondary btn-sm" disabled>Editar (Em Desenvolvimento)</button>
                            <button class="btn btn-secondary btn-sm" disabled>Excluir (Em Desenvolvimento)</button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Nenhum campeonato cadastrado.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Mensagem informativa -->
        <div class="alert alert-info text-center mt-3">
            ⚠ As funcionalidades de edição, exclusão e detalhes dos campeonatos estão em desenvolvimento.
        </div>

    </div>

    <?php include '../cabecalho/footer.php'; ?>
    <script src="../../../assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>