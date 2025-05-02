
<?php 
// Proteger contra acesso direto
if (!isset($_SERVER['HTTP_REFERER']) || empty($_SERVER['HTTP_REFERER'])) {
    echo "<div style='text-align:center; padding:20px; font-family:sans-serif;'>
            <h2 style='color:red;'>Erro: Acesso direto não permitido!</h2>
            <p>Utilize o sistema normalmente para acessar esta página.</p>
          </div>";
    exit();
}
require_once __DIR__ . '../../../includes/admin_sec.php'; ?>  



<div class="container mt-4 mb-5">
    <h2 class="mb-4">Gerenciar Partidas</h2>

    <div class="row g-4">
        <?php foreach ($partidas as $p): ?>
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title mb-2">
                            <?= $p['nome_casa'] ?> <span class="text-muted">x</span> <?= $p['nome_fora'] ?>
                        </h5>
                        <p class="mb-1"><strong>Data:</strong> <?= date('d/m/Y', strtotime($p['data'])) ?> às <?= $p['horario'] ?></p>
                        <p class="mb-2"><strong>Status:</strong> <span class="text-capitalize"><?= $p['status'] ?></span></p>

                        <form method="post" class="d-flex gap-2 flex-wrap align-items-center">
                            <input type="hidden" name="partida_id" value="<?= $p['id'] ?>">

                            <?php if ($p['status'] === 'nao_iniciada'): ?>
                                <input type="hidden" name="status" value="em_andamento">
                                <button class="btn btn-warning btn-sm">Iniciar</button>

                            <?php elseif ($p['status'] === 'em_andamento'): ?>
                                <a href="partida_ao_vivo.php?id=<?= $p['id'] ?>" class="btn btn-info btn-sm">Ir para ao vivo</a>
                                <input type="hidden" name="status" value="finalizada">
                                <button class="btn btn-success btn-sm">Finalizar</button>

                            <?php else: ?>
                                <span class="text-muted">Partida Finalizada</span>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="mt-auto">
<div class="mt-5"></div>
<?php require_once __DIR__ . '/../cabecalho/footer.php'; ?>
<script src="../../../assets/js/bootstrap.bundle.min.js"></script>
</div>

