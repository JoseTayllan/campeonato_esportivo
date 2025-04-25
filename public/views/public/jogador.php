<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Perfil do Jogador</title>
    <style>
        body {
            background-color: #fff;
            color: #111;
            font-family: 'Courier New', monospace;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }

        .bloco {
            border: 1px solid #ccc;
            padding: 20px;
            max-width: 800px;
            width: 100%;
            background-color: #f9f9f9;
            border-radius: 8px;
        }

        .linha {
            border-top: 1px solid #bbb;
            margin: 20px 0;
        }

        .titulo {
            font-weight: bold;
            color: #000;
        }

        .estatistica strong {
            color: #d00;
        }

        .tabela {
            width: 100%;
            border-collapse: collapse;
        }

        .tabela th, .tabela td {
            padding: 4px 8px;
            border-bottom: 1px solid #ccc;
            text-align: left;
        }

        .tabela th {
            color: #444;
        }

        .escudo {
            height: 40px;
            vertical-align: middle;
            margin-right: 8px;
        }

        .imagem-jogador {
            height: 40px;
            vertical-align: middle;
            border-radius: 4px;
            margin-left: 8px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="bloco">
        <!-- Topo -->
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <?php if (!empty($jogador['escudo'])): ?>
                <img src="/campeonato_esportivo/public/<?= $jogador['escudo'] ?>" class="escudo" alt="Escudo do time">
            <?php endif; ?>

            <div style="flex-grow: 1; text-align: center;">
                <div class="titulo"><?= htmlspecialchars($jogador['nome'] ?? '') ?></div>
                <div><?= htmlspecialchars($jogador['posicao'] ?? '') ?> • <?= htmlspecialchars($jogador['nacionalidade'] ?? '') ?></div>
            </div>

            <?php if (!empty($jogador['imagem'])): ?>
                <img src="/campeonato_esportivo/public/img/jogadores/<?= $jogador['imagem'] ?>" class="imagem-jogador" alt="Foto do jogador">
            <?php endif; ?>
        </div>

        <div class="linha"></div>

        <!-- Estatísticas -->
        <div class="titulo">Estatísticas (temporada atual)</div>
        <table class="tabela">
            <tr>
                <td>Gols:</td>
                <td><strong><?= $estatisticas[0]['gols'] ?? 0 ?></strong></td>
                <td>Assistências:</td>
                <td><strong><?= $estatisticas[0]['assistencias'] ?? 0 ?></strong></td>
            </tr>
            <tr>
                <td>Cartões:</td>
                <td><strong><?= $estatisticas[0]['cartoes_amarelos'] ?? 0 ?>A / <?= $estatisticas[0]['cartoes_vermelhos'] ?? 0 ?>V</strong></td>
                <td>Minutos jogados:</td>
                <td><strong><?= $estatisticas[0]['minutos_jogados'] ?? 0 ?></strong></td>
            </tr>
            <tr>
                <td>Finalizações:</td>
                <td><strong><?= $estatisticas[0]['finalizacoes'] ?? 0 ?></strong></td>
                <td>Passes:</td>
                <td><strong><?= $estatisticas[0]['passes_completos'] ?? 0 ?></strong></td>
            </tr>
            <tr>
                <td>Faltas:</td>
                <td><strong><?= $estatisticas[0]['faltas_cometidas'] ?? 0 ?></strong></td>
                <td>Nota média:</td>
                <td><strong><?= isset($notaMediaEstatistica) && $notaMediaEstatistica !== null ? number_format($notaMediaEstatistica, 1) : 'N/A' ?></strong></td>
            </tr>
        </table>

        <div class="linha"></div>

        <!-- Histórico -->
<div class="titulo">Histórico de Partidas</div>
<table class="tabela">
    <thead>
        <tr>
            <th>Data</th>
            <th>Adversário</th>
            <th>Placar</th>
            <th>Desempenho</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($historico as $partida): ?>
            <?php
                $nota_partida =
                    ($partida['gols'] ?? 0) * 1.5 +
                    ($partida['assistencias'] ?? 0) * 1.0 +
                    ($partida['passes_completos'] ?? 0) * 0.05 +
                    ($partida['finalizacoes'] ?? 0) * 0.1 -
                    ($partida['faltas_cometidas'] ?? 0) * 0.1 -
                    ($partida['cartoes_amarelos'] ?? 0) * 0.5 -
                    ($partida['cartoes_vermelhos'] ?? 0) * 1.0;
            ?>
            <tr>
                <td><?= date('d/m/Y', strtotime($partida['data'])) ?></td>
                <td><?= htmlspecialchars($partida['adversario']) ?></td>
                <td><?= htmlspecialchars($partida['resultado']) ?></td>
                <td><?= $partida['gols'] ?? 0 ?> G / <?= $partida['assistencias'] ?? 0 ?> A / <?= number_format($nota_partida, 1) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
    </div>
</div>
</body>
</html>
