<?php include __DIR__ . '../../../includes/index_sec.php'; ?>

<div class="container mt-4 container-campeonato">
    <h2><?= htmlspecialchars($dados['campeonato']['nome']) ?></h2>

    <a href="/campeonato_esportivo/routes/public/ranking_campeonato.php?campeonato_id=<?= $dados['campeonato']['id'] ?>" 
       class="btn btn-outline-primary btn-sm mb-3">
       🥇 Ver Ranking do Campeonato
    </a>
    <a href="/campeonato_esportivo/public/views/campeonatos/visualizar_fases_rodadas.php?campeonato_id=<?= $dados['campeonato']['id'] ?>"
   class="btn btn-outline-success btn-sm mb-3 ms-2">
    📋 Ver Estrutura do Campeonato
</a>


    <p>
        Temporada: <?= htmlspecialchars($dados['campeonato']['temporada']) ?> |
        Formato: <?= htmlspecialchars($dados['campeonato']['formato']) ?> |
        Modalidade: <?= htmlspecialchars($dados['campeonato']['modalidade']) ?>
    </p>

    <hr>

    <h4>📜 Sobre o Campeonato</h4>
    <p style="text-align: justify;">
        <?= nl2br(htmlspecialchars($dados['campeonato']['descricao'] ?? 'Nenhuma descrição cadastrada ainda.')) ?>
    </p>

    <h4 class="mt-5">👥 Times Participantes</h4>

    <?php if (empty($dados['times'])): ?>
        <p class="text-muted">Nenhum time participante cadastrado ainda.</p>
    <?php else: ?>
        <div class="row row-cols-2 row-cols-md-4 row-cols-lg-5 g-3">
            <?php foreach ($dados['times'] as $time): ?>
                <div class="col text-center">
                    <div class="border rounded p-2 h-100 bg-light">
                        <img src="/campeonato_esportivo/public/<?= $time['escudo'] ?? 'img/perfil_padrao/perfil_padrao.png' ?>" 
                             alt="Escudo <?= $time['nome'] ?>" width="60" class="mb-2">
                        <div class="fw-semibold"><?= htmlspecialchars($time['nome']) ?></div>
                        <?php if (!empty($time['codigo_publico'])): ?>
                            <a href="/campeonato_esportivo/public/views/time/perfil_time.php?codigo=<?= urlencode($time['codigo_publico']) ?>" 
                               class="btn btn-sm btn-outline-secondary mt-2">
                                Ver Perfil
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>


<div class="mt-auto">
<div class="mt-5"></div>
<?php require_once __DIR__ . '/../cabecalho/footer.php'; ?>
<script src="../../../assets/js/bootstrap.bundle.min.js"></script>
</div>