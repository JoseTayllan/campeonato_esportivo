<?php include_once __DIR__ . '/../../includes/header_olheiro.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">Exportação de Avaliações do Jogador</h2>

    <div class="card mb-4">
        <div class="card-header">📥 Selecione um Jogador para Exportar Todas as Avaliações</div>
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <label for="selecionar_jogador" class="form-label">Jogador</label>
                    <select id="selecionar_jogador" class="form-control">
                        <option value="">Selecione um jogador</option>
                        <?php foreach ($dados['jogadores'] as $jogador): ?>
                            <option value="<?= $jogador['id'] ?>"><?= $jogador['nome'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 d-flex justify-content-end align-items-center">
                    <a id="exportar_csv" href="#" class="btn btn-success me-2 disabled">📂 Exportar CSV</a>
                    <a id="exportar_pdf" href="#" class="btn btn-danger disabled">📄 Exportar PDF</a>
                </div>
            </div>
        </div>
    </div>

    <h2 class="mb-4">Avaliações dos Jogadores</h2>

    <div class="d-flex justify-content-end mb-3">
        <a href="/campeonato_esportivo/routes/avaliacao/avaliar_jogador.php" class="btn btn-primary">
            <i class="bi bi-pencil-square"></i> Avaliar Jogador
        </a>

    </div>

    <form method="GET" class="mb-3">
        <div class="row">
            <div class="col-md-6 mb-2">
                <input type="text" name="jogador" class="form-control" placeholder="Filtrar por jogador"
                    value="<?= isset($_GET['jogador']) ? htmlspecialchars($_GET['jogador']) : '' ?>">
            </div>
            <div class="col-md-4 mb-2">
                <select name="olheiro" class="form-control">
                    <option value="">Todos os Olheiros</option>
                    <?php foreach ($dados['olheiros'] as $olheiro): ?>
                        <?php $selected = (isset($_GET['olheiro']) && $_GET['olheiro'] == $olheiro['id']) ? 'selected' : ''; ?>
                        <option value="<?= $olheiro['id'] ?>" <?= $selected ?>><?= $olheiro['nome'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">🔍 Filtrar</button>
            </div>
        </div>
    </form>

    <div class="content">
        <div class="table-responsive">
            <div class="alert alert-warning text-center d-block d-md-none" role="alert">
                📢 Arraste para o lado para visualizar toda a tabela!
            </div>

            <table class="table table-striped table-bordered text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Jogador</th>
                        <th>Olheiro</th>
                        <th>Força</th>
                        <th>Velocidade</th>
                        <th>Drible</th>
                        <th>Finalização</th>
                        <th>Nota Geral</th>
                        <th>Observações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($dados['avaliacoes']->num_rows > 0): ?>
                        <?php while ($row = $dados['avaliacoes']->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['jogador_nome'] ?></td>
                                <td><?= $row['olheiro_nome'] ?></td>
                                <td><?= $row['forca'] ?></td>
                                <td><?= $row['velocidade'] ?></td>
                                <td><?= $row['drible'] ?></td>
                                <td><?= $row['finalizacao'] ?></td>
                                <td><?= $row['nota_geral'] ?></td>
                                <td><?= $row['observacoes'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center p-4">Nenhuma avaliação encontrada.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



<script>
    document.getElementById("selecionar_jogador").addEventListener("change", function() {
        let jogadorId = this.value;
        if (jogadorId) {
            document.getElementById("exportar_csv").classList.remove("disabled");
            document.getElementById("exportar_pdf").classList.remove("disabled");
            document.getElementById("exportar_csv").href = "/campeonato_esportivo/routes/avaliacao/exportar_dados.php?tipo=csv&jogador_id=" + jogadorId;
            document.getElementById("exportar_pdf").href = "/campeonato_esportivo/routes/avaliacao/exportar_dados.php?tipo=pdf&jogador_id=" + jogadorId;
        } else {
            document.getElementById("exportar_csv").classList.add("disabled");
            document.getElementById("exportar_pdf").classList.add("disabled");
            document.getElementById("exportar_csv").href = "#";
            document.getElementById("exportar_pdf").href = "#";
        }
    });
</script>