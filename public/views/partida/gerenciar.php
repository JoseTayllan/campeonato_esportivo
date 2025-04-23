<?require_once __DIR__ . '/../../cabecalho/header.php';
 ?>

<div class="container mt-4">
    <h2>Gerenciar Partidas</h2>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Data</th>
                <th>Times</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($partidas as $p): ?>
                <tr>
                    <td><?= date('d/m/Y', strtotime($p['data'])) ?> <?= $p['horario'] ?></td>
                    <td><?= $p['nome_casa'] ?> x <?= $p['nome_fora'] ?></td>
                    <td><?= ucfirst($p['status']) ?></td>
                    <td>
                        <form method="post" class="d-inline">
                            <input type="hidden" name="partida_id" value="<?= $p['id'] ?>">
                            <?php if ($p['status'] === 'nao_iniciada'): ?>
                                <input type="hidden" name="status" value="em_andamento">
                                <button class="btn btn-warning btn-sm">Iniciar</button>
                            <?php elseif ($p['status'] === 'em_andamento'): ?>
                                <a href="partida_ao_vivo.php?id=<?= $p['id'] ?>" class="btn btn-info btn-sm">Ir para ao vivo</a>
                                <input type="hidden" name="status" value="finalizada">
                                <button class="btn btn-success btn-sm">Finalizar</button>
                            <?php else: ?>
                                <span class="text-muted">Finalizada</span>
                            <?php endif; ?>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?require_once __DIR__ . '/../cabecalho/footer.php'; ?>
