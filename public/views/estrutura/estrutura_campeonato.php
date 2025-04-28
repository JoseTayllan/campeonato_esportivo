<?php 
// Proteger contra acesso direto
if (!isset($_SERVER['HTTP_REFERER']) || empty($_SERVER['HTTP_REFERER'])) {
    echo "<div style='text-align:center; padding:20px; font-family:sans-serif;'>
            <h2 style='color:red;'>Erro: Acesso direto não permitido!</h2>
            <p>Utilize o sistema normalmente para acessar esta página.</p>
          </div>";
    exit();
}
include __DIR__ . '/../cabecalho/header.php'; ?>

<div class="container mt-4">
    <h2>Chaveamento do Campeonato</h2>

    <?php
    $fases = ['Oitavas', 'Quartas', 'Semifinais', 'Final'];

    foreach ($fases as $fase):
        $confrontos = $estruturaController->listarConfrontosPorFase($campeonato_id, $fase);
    ?>
        <h4 class="mt-4"><?= $fase ?></h4>

        <?php if (!empty($confrontos)): ?>
            <ul class="list-group mb-3">
                <?php foreach ($confrontos as $jogo): ?>
                    <li class="list-group-item">
                        <strong><?= htmlspecialchars($jogo['time_casa']) ?></strong>
                        x
                        <strong><?= htmlspecialchars($jogo['time_fora']) ?></strong><br>
                        <small><?= $jogo['data'] ?> às <?= $jogo['horario'] ?></small><br>
                        <?php if (!is_null($jogo['placar_casa']) && !is_null($jogo['placar_fora'])): ?>
                            <span><?= $jogo['placar_casa'] ?> x <?= $jogo['placar_fora'] ?></span><br>
                        <?php endif; ?>
                        <?php if (!empty($jogo['local'])): ?>
                            <small><em><?= htmlspecialchars($jogo['local']) ?></em></small>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="text-muted">Nenhum confronto registrado para esta fase.</p>
        <?php endif; ?>
    <?php endforeach; ?>
</div>

<?php include __DIR__ . '/../cabecalho/footer.php'; ?>
