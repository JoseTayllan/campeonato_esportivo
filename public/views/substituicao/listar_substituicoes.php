<?php
session_start();
require_once __DIR__ . '/../../../app/middleware/verifica_sessao.php';
require_once __DIR__ . '/../../../config/database.php';

$query = "SELECT s.id, s.minuto_substituicao, 
                 j1.nome AS jogador_saiu, j2.nome AS jogador_entrou,
                 p.id AS partida_id, p.data, p.local
          FROM substituicoes s
          JOIN jogadores j1 ON s.jogador_saiu = j1.id
          JOIN jogadores j2 ON s.jogador_entrou = j2.id
          JOIN partidas p ON s.partida_id = p.id
          ORDER BY p.data DESC, s.minuto_substituicao ASC";

$result = $conn->query($query);
?>

<?php include '../cabecalho/header.php'; ?>
<?php include '../cabecalho/tabela.php'; ?>
<body class="d-flex flex-column min-vh-100">
<div class="container mt-4">
    <h2 class="mb-4">Substituições Registradas</h2>

    <?php include '../partials/mensagens.php'; ?>

    <div class="table-responsive">
        <table class="table table-striped table-bordered text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Partida</th>
                    <th>Data</th>
                    <th>Local</th>
                    <th>Minuto</th>
                    <th>Jogador que Saiu</th>
                    <th>Jogador que Entrou</th>
                    <th>Ações</th>

                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td>#<?= $row['partida_id'] ?></td>
                    <td><?= date('d/m/Y', strtotime($row['data'])) ?></td>
                    <td><?= htmlspecialchars($row['local']) ?></td>
                    <td><?= $row['minuto_substituicao'] ?>'</td>
                    <td><?= htmlspecialchars($row['jogador_saiu']) ?></td>
                    <td><?= htmlspecialchars($row['jogador_entrou']) ?></td>

                    <td>
                        <a href="editar_substituicao.php?id=<?= $row['id'] ?>"
                            class="btn btn-sm btn-warning me-1">✏️</a>
                        <a href="../../../routes/substituicao_delete.php?id=<?= $row['id'] ?>"
                            class="btn btn-sm btn-danger"
                            onclick="return confirm('Tem certeza que deseja excluir esta substituição?')">🗑️</a>
                    </td>


                </tr>
                <?php endwhile; ?>
                <?php else: ?>
                <tr>
                    <td colspan="6">Nenhuma substituição registrada.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- Footer com margem automática no topo para colar no final -->
<div class="mt-auto">
    <?php include '../cabecalho/footer.php'; ?>
</div>