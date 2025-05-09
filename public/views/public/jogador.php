<?php include __DIR__ . '../../../includes/index_sec.php'; ?>
<link rel="stylesheet" href="/campeonato_esportivo/public/assets/css/jogador.css">

<div class="pagina-jogador">
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
                <?php if (($jogador['posicao'] ?? '') === 'Goleiro'): ?>
                    <tr>
                        <td>Defesas:</td>
                        <td><strong><?= $estatisticas[0]['defesas'] ?? 0 ?></strong></td>
                        <td>Pênaltis Defendidos:</td>
                        <td><strong><?= $estatisticas[0]['penaltis_defendidos'] ?? 0 ?></strong></td>
                    </tr>
                    <tr>
                        <td>Gols Sofridos:</td>
                        <td><strong><?= $estatisticas[0]['gols_sofridos'] ?? 0 ?></strong></td>
                        <td>Partidas sem Sofrer Gols:</td>
                        <td><strong><?= $estatisticas[0]['clean_sheets'] ?? 0 ?></strong></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td>Gols:</td>
                        <td><strong><?= $estatisticas[0]['gols'] ?? 0 ?></strong></td>
                        <td>Assistências:</td>
                        <td><strong><?= $estatisticas[0]['assistencias'] ?? 0 ?></strong></td>
                    </tr>
                    <tr>
                        <td>Finalizações:</td>
                        <td><strong><?= $estatisticas[0]['finalizacoes'] ?? 0 ?></strong></td>
                        <td>Passes:</td>
                        <td><strong><?= $estatisticas[0]['passes_completos'] ?? 0 ?></strong></td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td>Cartões:</td>
                    <td><strong><?= $estatisticas[0]['cartoes_amarelos'] ?? 0 ?>A / <?= $estatisticas[0]['cartoes_vermelhos'] ?? 0 ?>V</strong></td>
                    <td>Minutos jogados:</td>
                    <td><strong><?= $estatisticas[0]['minutos_jogados'] ?? 0 ?></strong></td>
                </tr>
                <tr>
                    <td>Faltas:</td>
                    <td><strong><?= $estatisticas[0]['faltas_cometidas'] ?? 0 ?></strong></td>
                    <td>Nota média:</td>
                    <td><strong><?= isset($notaMediaEstatistica) ? number_format($notaMediaEstatistica, 1) : 'N/A' ?></strong></td>
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
                        <tr>
                            <td><?= date('d/m/Y', strtotime($partida['data'])) ?></td>
                            <td><?= htmlspecialchars($partida['adversario']) ?></td>
                            <td><?= htmlspecialchars($partida['resultado']) ?></td>
                            <td>
                                <?php if (($jogador['posicao'] ?? '') === 'Goleiro'): ?>
                                    Defesas: <?= $partida['defesas'] ?? 0 ?> / Gols Sofridos: <?= $partida['gols_sofridos'] ?? 0 ?>
                                <?php else: ?>
                                    <?= $partida['gols'] ?? 0 ?> G / <?= $partida['assistencias'] ?? 0 ?> A / <?= number_format($partida['nota'] ?? 0, 1) ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>
<div class="mt-auto">
<div class="mt-5"></div>
<?php require_once __DIR__ . '/../cabecalho/footer.php'; ?>
<script src="../../../assets/js/bootstrap.bundle.min.js"></script>
</div>