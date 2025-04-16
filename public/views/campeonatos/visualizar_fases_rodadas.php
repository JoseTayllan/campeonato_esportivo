<?php
require_once __DIR__ . '/../../../config/database.php';
include '../cabecalho/header.php';

$tipo = strtolower($_SESSION['usuario_tipo'] ?? '');

switch ($tipo) {
    case 'administrador':
        include '../cabecalho/tabela_administrativa.php';
        break;
    case 'organizador':
        include '../cabecalho/tabela.php';
        break;
    case 'olheiro':
        include '../cabecalho/tabela_olheiro.php';
        break;
    case 'treinador':
        include '../cabecalho/tabela_treinador.php';
        break;
    case 'jogador':
        include '../cabecalho/tabela_jogador.php';
        break;
    case 'patrocinador':
        include '../cabecalho/tabela_patrocinador.php';
        break;
    default:
        include '../cabecalho/tabela_geral.php';
};
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Visualização Pública do Campeonato</title>
    <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">

<div class="container mt-4">
    <h2 class="mb-4 text-center">Estrutura do Campeonato</h2>

    <!-- Formulário de seleção de campeonato -->
    <form method="GET" class="mb-4">
        <label for="campeonato_id" class="form-label">Selecione um Campeonato</label>
        <select name="campeonato_id" class="form-control" onchange="this.form.submit()" required>
            <option value="">Escolha um campeonato</option>
            <?php
            $campeonatoSelecionado = $_GET['campeonato_id'] ?? '';
            $query = "SELECT id, nome FROM campeonatos ORDER BY nome ASC";
            $result = $conn->query($query);
            while ($row = $result->fetch_assoc()) {
                $selected = ($row['id'] == $campeonatoSelecionado) ? 'selected' : '';
                echo "<option value='{$row['id']}' $selected>{$row['nome']}</option>";
            }
            ?>
        </select>
    </form>

    <?php if (!empty($campeonatoSelecionado)): ?>
        <hr>
        <h4 class="text-primary mt-4">📋 Fases e Rodadas</h4>

        <?php
        $queryFases = "SELECT id, nome, ordem FROM fases_campeonato WHERE campeonato_id = ? ORDER BY ordem ASC";
        $stmtFase = $conn->prepare($queryFases);
        $stmtFase->bind_param("i", $campeonatoSelecionado);
        $stmtFase->execute();
        $resultFases = $stmtFase->get_result();

        if ($resultFases->num_rows > 0):
            while ($fase = $resultFases->fetch_assoc()):
        ?>
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <strong><?= htmlspecialchars($fase['nome']) ?> (Ordem <?= $fase['ordem'] ?>)</strong>
            </div>
            <div class="card-body">
                <?php
                $queryRodadas = "SELECT numero, tipo, descricao FROM rodadas WHERE fase_id = ? ORDER BY numero ASC";
                $stmtRodada = $conn->prepare($queryRodadas);
                $stmtRodada->bind_param("i", $fase['id']);
                $stmtRodada->execute();
                $resultRodadas = $stmtRodada->get_result();

                if ($resultRodadas->num_rows > 0): ?>
                    <ul class="list-group">
                        <?php while ($rodada = $resultRodadas->fetch_assoc()): ?>
                            <li class="list-group-item">
                                <strong>Rodada <?= $rodada['numero'] ?>:</strong>
                                <?= htmlspecialchars($rodada['tipo']) ?>
                                <?php if (!empty($rodada['descricao'])): ?>
                                    - <?= htmlspecialchars($rodada['descricao']) ?>
                                <?php endif; ?>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <div class="text-muted">Nenhuma rodada cadastrada nesta fase.</div>
                <?php endif; ?>
            </div>
        </div>
        <?php endwhile; else: ?>
            <div class="alert alert-warning">Nenhuma fase cadastrada neste campeonato.</div>
        <?php endif; ?>

        <!-- Classificação -->
        <hr>
        <h4 class="text-success mt-4">🏆 Tabela de Classificação</h4>

        <div class="table-responsive mb-5">
            <table class="table table-striped table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Time</th>
                        <th>Jogos</th>
                        <th>Vitórias</th>
                        <th>Empates</th>
                        <th>Derrotas</th>
                        <th>Gols Pró</th>
                        <th>Gols Contra</th>
                        <th>Saldo de Gols</th>
                        <th>Pontos</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $sqlTimes = "SELECT t.id, t.nome FROM times t
                             JOIN times_campeonatos tc ON tc.time_id = t.id
                             WHERE tc.campeonato_id = $campeonatoSelecionado
                             ORDER BY t.nome ASC";
                $res = $conn->query($sqlTimes);

                while ($time = $res->fetch_assoc()) {
                    $timeId = $time['id'];

                    $partidas = "SELECT * FROM partidas 
                                 WHERE campeonato_id = $campeonatoSelecionado
                                 AND (time_casa = $timeId OR time_fora = $timeId)";
                    $resultPartidas = $conn->query($partidas);

                    $jogos = $vitorias = $empates = $derrotas = $gols_pro = $gols_contra = 0;

                    while ($p = $resultPartidas->fetch_assoc()) {
                        $jogos++;
                        $is_casa = $p['time_casa'] == $timeId;
                        $gp = $is_casa ? $p['placar_casa'] : $p['placar_fora'];
                        $gc = $is_casa ? $p['placar_fora'] : $p['placar_casa'];

                        $gols_pro += $gp;
                        $gols_contra += $gc;

                        if ($gp > $gc) $vitorias++;
                        elseif ($gp == $gc) $empates++;
                        else $derrotas++;
                    }

                    $saldo = $gols_pro - $gols_contra;
                    $pontos = $vitorias * 3 + $empates;

                    echo "<tr>
                            <td>{$time['nome']}</td>
                            <td>{$jogos}</td>
                            <td>{$vitorias}</td>
                            <td>{$empates}</td>
                            <td>{$derrotas}</td>
                            <td>{$gols_pro}</td>
                            <td>{$gols_contra}</td>
                            <td>{$saldo}</td>
                            <td>{$pontos}</td>
                          </tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
<!-- Rodapé fixado ao final -->
<div class="mt-auto">
    <?php include '../cabecalho/footer.php'; ?>
</div>
<script src="../../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
