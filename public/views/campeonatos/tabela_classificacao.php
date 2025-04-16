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
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Tabela de Classificação</title>
    <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h2 class="mb-4 text-center">Tabelas de Classificação por Campeonato</h2>

    <?php
    $campeonatos = $conn->query("SELECT id, nome, temporada FROM campeonatos ORDER BY temporada DESC");

    while ($camp = $campeonatos->fetch_assoc()) {
        echo "<h4 class='mt-5 mb-3 text-primary'>🏆 {$camp['nome']} - Temporada {$camp['temporada']}</h4>";
        echo "<div class='table-responsive'>
                <table class='table table-striped table-bordered text-center'>
                    <thead class='table-dark'>
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
                    <tbody>";

        $sqlTimes = "SELECT t.id, t.nome FROM times t
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

        echo "      </tbody>
                </table>
              </div>";
    }
    ?>
</div>

<?php include '../cabecalho/footer.php'; ?>
<script src="../../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
