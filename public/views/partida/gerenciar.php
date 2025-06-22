<?php
if (!isset($_SERVER['HTTP_REFERER']) || empty($_SERVER['HTTP_REFERER'])) {
    echo "<div style='text-align:center; padding:20px; font-family:sans-serif;'>
            <h2 style='color:red;'>Erro: Acesso direto não permitido!</h2>
            <p>Utilize o sistema normalmente para acessar esta página.</p>
          </div>";
    exit();
}

require_once __DIR__ . '../../../includes/admin_sec.php';

// Agrupa as partidas por campeonato
$porCampeonato = [];
foreach ($partidas as $p) {
    $cid = $p['campeonato_id'];
    $porCampeonato[$cid]['nome'] = $p['campeonato_nome'] ?? "Campeonato #$cid";
    $porCampeonato[$cid]['partidas'][] = $p;
}
?>

<div class="container mt-4 mb-5">
    <h2 class="mb-4" style="color: #000;" >📋 Gerenciar Partidas por Campeonato</h2>

    <?php if (empty($partidas)): ?>
        <div class="alert alert-info text-center">Nenhuma partida cadastrada.</div>
    <?php endif; ?>

    <?php foreach ($porCampeonato as $id => $grupo): ?>
        <?php
        $ativas = array_filter($grupo['partidas'], fn($p) => $p['status'] !== 'finalizada');
        $finalizadas = array_filter($grupo['partidas'], fn($p) => $p['status'] === 'finalizada');
        ?>

        <h4 class="mt-5 text-dark"><?= htmlspecialchars($grupo['nome']) ?></h4>

        <?php if (!empty($ativas)): ?>
            <h6 class="text-primary mt-3" style="color: #000;">⚽ Partidas para Gerenciar</h6>
            <div class="row g-4">
                <?php foreach ($ativas as $p): ?>
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <h5 class="card-title mb-2">
                                    <?= htmlspecialchars($p['nome_casa']) ?> <span class="text-muted">x</span> <?= htmlspecialchars($p['nome_fora']) ?>
                                </h5>
                                <p><strong>Data:</strong> <?= date('d/m/Y', strtotime($p['data'])) ?> às <?= htmlspecialchars($p['horario']) ?></p>
                                <p><strong>Status:</strong> <?= htmlspecialchars($p['status']) ?></p>

                                <form method="post" class="d-flex gap-2 flex-wrap align-items-center">
                                    <input type="hidden" name="partida_id" value="<?= $p['id'] ?>">

                                    <?php if ($p['status'] === 'nao_iniciada'): ?>
                                        <input type="hidden" name="status" value="em_andamento">
                                        <button class="btn btn-warning btn-sm">Iniciar</button>
                                        <a href="/campeonato_esportivo/routes/adms/sumula_partida.php?partida_id=<?= $p['id'] ?>" class="btn btn-outline-primary btn-sm mt-2">
                                            📝 Preencher Súmula
                                        </a>
                                    <?php elseif ($p['status'] === 'em_andamento'): ?>
                                        <a href="partida_ao_vivo.php?id=<?= $p['id'] ?>" class="btn btn-info btn-sm">Ir para ao vivo</a>
                                        <input type="hidden" name="status" value="finalizada">
                                        <button class="btn btn-success btn-sm">Finalizar</button>
                                    <?php endif; ?>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($finalizadas)): ?>
            <h6 class="text-muted mt-4" style="color: #000;">✅ Partidas Finalizadas</h6>
            <div class="row g-4">
                <?php foreach ($finalizadas as $p): ?>
                    <div class="col-md-6">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h5 class="card-title mb-2">
                                    <?= htmlspecialchars($p['nome_casa']) ?> <span class="text-muted">x</span> <?= htmlspecialchars($p['nome_fora']) ?>
                                </h5>
                                <p><strong>Data:</strong> <?= date('d/m/Y', strtotime($p['data'])) ?> às <?= htmlspecialchars($p['horario']) ?></p>
                                <p><strong>Status:</strong> Finalizada</p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>

<div class="mt-auto">
    <div class="mt-5"></div>
    <?php require_once __DIR__ . '/../cabecalho/footer.php'; ?>
    <script src="../../../assets/js/bootstrap.bundle.min.js"></script>
</div>
