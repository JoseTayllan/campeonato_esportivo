<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../public/includes/header_trasmicao.php'; 
$id = $_GET['id'] ?? null;
if (!$id) exit('Partida não encontrada.');

$stmt = $conn->prepare("SELECT p.*, t1.nome AS nome_casa, t2.nome AS nome_fora,
                               t1.escudo AS escudo_casa, t2.escudo AS escudo_fora
                        FROM partidas p
                        JOIN times t1 ON p.time_casa = t1.id
                        JOIN times t2 ON p.time_fora = t2.id
                        WHERE p.id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$partida = $res->fetch_assoc();
$stmt->close();

if (!$partida || empty($partida['link_transmissao'])) exit('Transmissão indisponível.');

$partida['escudo_casa'] = basename(str_replace('public/img/times/', '', $partida['escudo_casa']));
$partida['escudo_fora'] = basename(str_replace('public/img/times/', '', $partida['escudo_fora']));
$embed = str_replace("watch?v=", "embed/", $partida['link_transmissao']);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Transmissão - <?= $partida['nome_casa'] ?> x <?= $partida['nome_fora'] ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            margin: 0;
            background: #000;
            color: #fff;
            font-family: sans-serif;
            text-align: center;
        }
        .video-container {
            display: flex;
            justify-content: center;
            margin: 0 auto;
            padding: 10px;
        }
        .video {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            width: 100%;
            max-width: 800px;
            overflow: hidden;
        }
        .video iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        .placar {
            padding: 10px;
            font-size: 1.3rem;
            background: #111;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }
        .placar img {
            width: 35px;
            height: 35px;
            object-fit: contain;
        }
        .tempo {
            font-size: 1rem;
            margin: 8px 0;
        }
    </style>
</head>
<body>
    <div class="placar" id="placar-container">
        <img src="/campeonato_esportivo/public/img/times/<?= $partida['escudo_casa'] ?>" alt="">
        <span><strong><?= $partida['nome_casa'] ?></strong></span>
        <span id="placar-texto"><?= $partida['placar_casa'] ?> x <?= $partida['placar_fora'] ?></span>
        <span><strong><?= $partida['nome_fora'] ?></strong></span>
        <img src="/campeonato_esportivo/public/img/times/<?= $partida['escudo_fora'] ?>" alt="">
    </div>
    <div class="tempo" id="tempo-jogo">--:--</div>

    <div class="video-container">
        <div class="video">
            <iframe src="<?= $embed ?>" frameborder="0" allowfullscreen></iframe>
        </div>
    </div>

    <script>
        function atualizarInfo() {
            fetch("/campeonato_esportivo/routes/ajax/placar_atualizado.php")
                .then(r => r.json())
                .then(lista => {
                    const partida = lista.find(p => p.id == <?= $id ?>);
                    if (!partida) return;

                    document.getElementById('placar-texto').innerText = `${partida.placar_casa} x ${partida.placar_fora}`;

                    let tempo = parseInt(partida.tempo_acumulado) || 0;
                    const acrescimos = parseInt(partida.acrescimos) || 0;

                    if (partida.cronometro_status === 'rodando' && partida.inicio_partida) {
                        const inicio = new Date(partida.inicio_partida).getTime();
                        const agora = Date.now();
                        const minutos = Math.floor((agora - inicio) / 60000);
                        tempo += minutos;
                    }

                    tempo += acrescimos;
                    document.getElementById('tempo-jogo').innerText = tempo.toString().padStart(2, '0') + ":00";
                });
        }

        atualizarInfo();
        setInterval(atualizarInfo, 10000);
    </script>
</body>
</html>

