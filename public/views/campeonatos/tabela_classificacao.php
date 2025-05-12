<?php
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../includes/index_sec.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Tabela de Classificação</title>
    <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media (max-width: 768px) {
            table {
                width: 100% !important;
                max-width: 100% !important;
                table-layout: auto !important;
            }

            table th,
            table td {
                font-size: 0.85rem !important;
                padding: 0.4rem !important;
                word-break: break-word !important;
            }
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

<main class="flex-grow-1">
    <div class="container mt-4">
        <h2 class="mb-4 text-center">Tabelas de Classificação por Campeonato</h2>

        <?php
        $campeonatos = $conn->query("SELECT id, nome, temporada FROM campeonatos ORDER BY temporada DESC");

        while ($camp = $campeonatos->fetch_assoc()) {
            echo "<h4 class='mt-5 mb-3 text-primary'>🏆 {$camp['nome']} - Temporada {$camp['temporada']}</h4>";
            echo "<div class='mb-4'>
                    <table class='table table-striped table-bordered text-center w-100'>
                        <thead class='table-dark text-nowrap'>
                            <tr>
                                <th>Time</th>
                                <th>J</th>
                                <th>V</th>
                                <th>E</th>
                                <th>D</th>
                                <th>GP</th>
                                <th>GC</th>
                                <th>SG</th>
                                <th>Pts</th>
                            </tr>
                        </thead>
                        <tbody>";

            $sqlTimes = "SELECT t.id, t.nome, t.escudo FROM times t
                         JOIN times_campeonatos tc ON tc.time_id = t.id
                         WHERE tc.campeonato_id = {$camp['id']}
                         ORDER BY t.nome ASC";
            $res = $conn->query($sqlTimes);

            while ($time = $res->fetch_assoc()) {
                $timeId = $time['id'];

                $partidas = "SELECT * FROM partidas 
                             WHERE campeonato_id = {$camp['id']} AND (time_casa = $timeId OR time_fora = $timeId)";
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
                        <td class='d-flex align-items-center gap-2'>";
                if (!empty($time['escudo'])) {
                    echo "<img src='/campeonato_esportivo/{$time['escudo']}' width='32' class='me-2'>";
                }
                echo "<span>{$time['nome']}</span></td>
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

            echo "      </tbody>
                    </table>
                  </div>";
        }
        ?>
    </div>
</main>

<?php include '../cabecalho/footer.php'; ?>
<script src="../../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
