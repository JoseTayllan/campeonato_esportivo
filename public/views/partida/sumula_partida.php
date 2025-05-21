<?php include __DIR__ . '/../../includes/admin_sec.php'; ?>
<link rel="stylesheet" href="/campeonato_esportivo/public/assets/css/sumula.css">

<div class="container mt-4 container-campeonato">
    <h2>Súmula da Partida</h2>
    <h4>
        <?= htmlspecialchars($dados['partida']['nome_casa']) ?>
        x
        <?= htmlspecialchars($dados['partida']['nome_fora']) ?>
    </h4>

    <form method="POST" action="/campeonato_esportivo/routes/adms/finalizar_partida_sumula.php">
        <input type="hidden" name="partida_id" value="<?= $dados['partida']['id'] ?>">
        <input type="hidden" name="campeonato_id" value="<?= $dados['partida']['campeonato_id'] ?>">

        <!-- 🔥 Placar -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label><strong>Placar Time Casa</strong></label>
                <input type="number" name="placar_casa" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label><strong>Placar Time Visitante</strong></label>
                <input type="number" name="placar_fora" class="form-control" required>
            </div>
        </div>

        <hr>

        <!-- 🔥 Tabela por time -->
        <?php
        $time_casa = $dados['partida']['time_casa'];
        $time_fora = $dados['partida']['time_fora'];

        $jogadores_casa = array_filter($dados['jogadores'], fn($j) => $j['time_id'] == $time_casa);
        $jogadores_fora = array_filter($dados['jogadores'], fn($j) => $j['time_id'] == $time_fora);

        function tabelaTime($jogadores, $nome_time) {
        ?>
            <h5 class="mt-4"><?= htmlspecialchars($nome_time) ?></h5>
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead class="text-center">
                        <tr>
                            <th>Jogador</th>
                            <th>Gols</th>
                            <th>Assistências</th>
                            <th>Amarelos</th>
                            <th>Vermelhos</th>
                            <th>Defesas</th>
                            <th>Pênaltis Defendidos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($jogadores as $j): ?>
                        <tr class="<?= ($j['posicao'] === 'Goleiro') ? 'goleiro' : '' ?>">
                            <td class="nome-jogador">
                                <?= htmlspecialchars($j['nome']) ?> - <?= htmlspecialchars($j['posicao']) ?>
                            </td>
                            <td><input type="number" name="gols[<?= $j['id'] ?>]" value="0" min="0" class="form-control form-control-sm"></td>
                            <td><input type="number" name="assistencias[<?= $j['id'] ?>]" value="0" min="0" class="form-control form-control-sm"></td>
                            <td><input type="number" name="amarelos[<?= $j['id'] ?>]" value="0" min="0" class="form-control form-control-sm"></td>
                            <td><input type="number" name="vermelhos[<?= $j['id'] ?>]" value="0" min="0" class="form-control form-control-sm"></td>

                            <?php if ($j['posicao'] === 'Goleiro'): ?>
                                <td><input type="number" name="defesas[<?= $j['id'] ?>]" value="0" min="0" class="form-control form-control-sm"></td>
                                <td><input type="number" name="penaltis_defendidos[<?= $j['id'] ?>]" value="0" min="0" class="form-control form-control-sm"></td>
                            <?php else: ?>
                                <td class="text-muted">-</td>
                                <td class="text-muted">-</td>
                            <?php endif; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>

        <?php
        tabelaTime($jogadores_casa, $dados['partida']['nome_casa']);
        tabelaTime($jogadores_fora, $dados['partida']['nome_fora']);
        ?>

        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-success">✅ Finalizar Partida</button>
            <a href="../aovivo/gerenciar_partidas.php?campeonato_id=<?= $dados['partida']['campeonato_id'] ?>" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
