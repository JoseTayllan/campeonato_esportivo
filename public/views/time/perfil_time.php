<?php include __DIR__ . '../../../includes/index_sec.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($time['nome']) ?> - Perfil do Time</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="card shadow mb-4">
        <div class="card-body">
            <h2><?= htmlspecialchars($time['nome']) ?></h2>
            <p><strong>Cidade:</strong> <?= htmlspecialchars($time['cidade']) ?></p>
            <p><strong>Estádio:</strong> <?= htmlspecialchars($time['estadio']) ?></p>
            <?php if (!empty($time['escudo'])): ?>
                <img src="/campeonato_esportivo/public/<?= $time['escudo'] ?>" width="120" alt="Escudo do time">

            <?php endif; ?>
        </div>
    </div>

    <h4>Elenco</h4>
    <table class="table table-bordered align-middle text-center">
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
        <?php foreach ($jogadores as $j): ?>
            <tr>
                <td>
                    <?php if (!empty($j['imagem'])): ?>
                        <img src="/campeonato_esportivo/public/img/jogadores/<?= $j['imagem'] ?>" alt="Imagem do jogador" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                    <?php else: ?>
                        <img src="/campeonato_esportivo/public/img/perfil_padrao/perfil_padrao.png" alt="Imagem padrão" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($j['nome']) ?></td>
                <td><?= htmlspecialchars($j['posicao']) ?></td>
                <td><?= (int) $j['idade'] ?></td>
                <td><?= htmlspecialchars($j['nacionalidade']) ?></td>
                <td>
                    <a href="/campeonato_esportivo/routes/public/jogador.php?id=<?= $j['id'] ?>" class="btn btn-primary btn-sm">Ver Perfil</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php if (!empty($patrocinadores)): ?>
    <div class="card shadow mt-5">
        <div class="card-body">
            <h4 class="mb-4">Patrocinadores</h4>
            <div class="d-flex flex-wrap gap-3 justify-content-start">
                <?php foreach ($patrocinadores as $p): ?>
                    <div class="bg-white border rounded shadow-sm p-2 d-flex align-items-center justify-content-center" style="width: 140px; height: 100px;">
                        <?php if (!empty($p['logo'])): ?>
                            <img src="/campeonato_esportivo/<?= $p['logo'] ?>" alt="<?= htmlspecialchars($p['nome_empresa']) ?>" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        <?php else: ?>
                            <small class="text-muted">Sem logo</small>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

</div>
</body>
</html>
<div class="mt-auto">
<div class="mt-5"></div>
<?php require_once __DIR__ . '/../cabecalho/footer.php'; ?>
<script src="../../../assets/js/bootstrap.bundle.min.js"></script>
</div>