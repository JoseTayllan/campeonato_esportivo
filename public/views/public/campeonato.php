<?php include __DIR__ . '../../../includes/index_sec.php'; ?>

<div class="container mt-4 container-campeonato">
    <!-- Banner do Campeonato -->
    <?php if (!empty($dados['campeonato']['banner'])): ?>
        <div class="text-center mb-4">
            <img src="/campeonato_esportivo/<?= htmlspecialchars($dados['campeonato']['banner']) ?>"
                alt="Banner do Campeonato" class="img-fluid rounded"
                style="max-height: 300px; width: 100%; object-fit: contain; background-color: #fff;">
        </div>
    <?php endif; ?>

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

    <?php if (!empty($dados['campeonato']['premiacao'])): ?>
        <h4 class="mt-5">🏆 Premiação</h4>
        <div class="alert alert-warning">
            <?php
            $linhas = explode("\n", $dados['campeonato']['premiacao']);
            foreach ($linhas as $linha):
                $linha = trim($linha);

                // Verifica se a linha é apenas número (ignorando espaços e pontos)
                if (preg_match('/^\d+$/', str_replace(['.', ',', 'R$', ' '], '', $linha))) {
                    $numero = preg_replace('/[^\d]/', '', $linha);
                    $linhaFormatada = 'R$ ' . number_format($numero, 2, ',', '.');
                } else {
                    // Se tiver texto + número, formata os números dentro da frase
                    $linhaFormatada = preg_replace_callback('/\d{3,}/', function ($match) {
                        return 'R$ ' . number_format($match[0], 2, ',', '.');
                    }, $linha);
                }
            ?>
                <div><?= htmlspecialchars($linhaFormatada) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>



    <?php if (!empty($dados['campeonato']['qr_code_localizacao'])): ?>
        <div class="card mt-4 mb-4" style="border-left: 5px solid #198754;">
            <div class="card-body d-flex flex-column flex-md-row align-items-center justify-content-between">
                <div>
                    <h6 class="text-success fw-bold mb-2">📍 Localização do Evento</h6>
                    <p class="mb-1">Escaneie o QR Code para visualizar o local do campeonato ou <a href="https://maps.google.com/?q=-16.709370,-49.250027" target="_blank">clique aqui</a>.</p>
                </div>
                <div class="text-center">
                    <img src="/campeonato_esportivo/<?= htmlspecialchars($dados['campeonato']['qr_code_localizacao']) ?>" style="max-width: 120px;">
                    <div class="small text-muted">QR Code</div>
                </div>
            </div>
        </div>
    <?php endif; ?>


    <h4 class="mt-5">👥 Times Participantes</h4>

    <?php if (empty($dados['times'])): ?>
        <p class="text-muted">Nenhum time participante cadastrado ainda.</p>
    <?php else: ?>
        <div class="row row-cols-2 row-cols-md-4 row-cols-lg-5 g-3">
            <?php foreach ($dados['times'] as $time): ?>
                <div class="col text-center">
                    <div class="border rounded p-2 h-100 bg-light">
                        <img src="/campeonato_esportivo/<?= $time['escudo'] ?? 'img/perfil_padrao/perfil_padrao.png' ?>"
                            alt="Escudo <?= $time['nome'] ?>" width="60" class="mb-2">
                        <div class="fw-semibold"><?= htmlspecialchars($time['nome']) ?></div>
                        <?php if (!empty($time['codigo_publico'])): ?>
                            <a href="/campeonato_esportivo/routes/time/perfil_time.php?codigo=<?= urlencode($time['codigo_publico']) ?>"
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