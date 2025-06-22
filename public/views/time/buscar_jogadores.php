<?php if (!isset($time_id)) { die('Acesso direto não permitido.'); } ?>
<?php require_once __DIR__ . '/../../includes/assinatura_sec.php'; ?>
<!DOCTYPE html>

<div class="container py-4">
    <div class="card p-4 shadow">
        <h2>Buscar Jogadores no Sistema</h2>

        <?php if ($jogadores->num_rows === 0): ?>
            <div class="alert alert-info">Nenhum jogador disponível para vincular.</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle text-nowrap">
                    <thead>
                        <tr>
                            <th>Imagem</th>
                            <th>Nome</th>
                            <th>Posição</th>
                            <th>Idade</th>
                            <th>Nacionalidade</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($jogador = $jogadores->fetch_assoc()): ?>
                            <tr>
                                <td style="width: 60px;">
                                    <?php
                                        $imgPath = '/campeonato_esportivo/public/img/jogadores/' . $jogador['imagem'];
                                        $defaultImg = '/campeonato_esportivo/public/img/perfil_padrao/perfil_padrao.png';
                                    ?>
                                    <img src="<?= !empty($jogador['imagem']) && file_exists($_SERVER['DOCUMENT_ROOT'] . $imgPath) ? $imgPath : $defaultImg ?>"
                                         class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                </td>
                                <td><?= htmlspecialchars($jogador['nome']) ?></td>
                                <td><?= htmlspecialchars($jogador['posicao']) ?></td>
                                <td><?= htmlspecialchars($jogador['idade']) ?></td>
                                <td><?= htmlspecialchars($jogador['nacionalidade']) ?></td>
                                <td>
                                    <a href="vincular_jogador.php?jogador_id=<?= $jogador['id'] ?>"
                                       class="btn btn-sm btn-primary">
                                       Vincular
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <a href="dashboard_time.php" class="btn btn-secondary mt-3">Voltar para Dashboard</a>
    </div>
</div>

<?php require_once __DIR__ . '/../cabecalho/footer.php'; ?>
