<?php
// Proteger contra acesso direto
if (!isset($_SERVER['HTTP_REFERER']) || empty($_SERVER['HTTP_REFERER'])) {
    echo "<div style='text-align:center; padding:20px; font-family:sans-serif;'>
            <h2 style='color:red;'>Erro: Acesso direto não permitido!</h2>
            <p>Utilize o sistema normalmente para acessar esta página.</p>
          </div>";
    exit();
}
?>

<?php require_once __DIR__ . '/../../includes/assinatura_patrocinador.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Área do Patrocinador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .valor-investido {
            text-align: right;
            margin-top: -10px;
            margin-bottom: 10px;
        }
        .valor-investido .badge {
            font-size: 1rem;
            padding: 8px 12px;
        }
    </style>
</head>
<body>

<div class="container my-5">
    <div class="text-center mb-4">
        <h2 class="text-dark fw-semibold">
            <i class="bi bi-briefcase-fill me-2"></i>Área do Patrocinador
        </h2>
        <p class="text-muted">Acompanhe o desempenho dos seus times patrocinados</p>
    </div>

    <?php if (empty($dados_dashboard)): ?>
        <div class="alert alert-info text-center">Nenhum time patrocinado encontrado.</div>
    <?php else: ?>
        <?php foreach ($dados_dashboard as $info): ?>
            <div class="card mb-5 shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <?= $info['time']['nome'] ?>
                </div>
                <div class="card-body">
                    <p><strong>Cidade:</strong> <?= $info['time']['cidade'] ?><br>
                       <strong>Estádio:</strong> <?= $info['time']['estadio'] ?></p>

                    <?php if (!empty($info['time']['valor_investido'])): ?>
                        <div class="valor-investido">
                            <span class="badge bg-success">
                                Investido: R$ <?= number_format($info['time']['valor_investido'], 2, ',', '.') ?>
                            </span>
                        </div>
                    <?php endif; ?>

                    <!-- 🔴 Formulário de Desvincular -->
                    <form method="POST" action="/campeonato_esportivo/routes/patrocinador/patrocinador_dashboard.php" class="text-end mt-3">
                        <input type="hidden" name="desvincular_time" value="1">
                        <input type="hidden" name="time_id" value="<?= $info['time']['id'] ?>">
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                             Desvincular Time
                        </button>
                    </form>

                    <hr>
                    <h6 class="text-success">📊 Estatísticas</h6>
                    <ul class="list-unstyled">
                        <li><strong>Jogos:</strong> <?= $info['estatisticas']['jogos'] ?? 0 ?></li>
                        <li><strong>Vitórias:</strong> <?= $info['estatisticas']['vitorias'] ?? 0 ?></li>
                        <li><strong>Empates:</strong> <?= $info['estatisticas']['empates'] ?? 0 ?></li>
                        <li><strong>Derrotas:</strong> <?= $info['estatisticas']['derrotas'] ?? 0 ?></li>
                        <li><strong>Gols Pró:</strong> <?= $info['estatisticas']['gols_pro'] ?? 0 ?></li>
                        <li><strong>Gols Sofridos:</strong> <?= $info['estatisticas']['gols_contra'] ?? 0 ?></li>
                        <li><strong>Saldo de Gols:</strong> <?= $info['estatisticas']['saldo'] ?? 0 ?></li>
                        <li><strong>Média de Gols:</strong> <?= $info['estatisticas']['media_gols'] ?? 0 ?></li>
                        <li><strong>Aproveitamento:</strong> <?= $info['estatisticas']['aproveitamento'] ?? 0 ?>%</li>
                    </ul>

                    <?php if (!empty($info['logo'])): ?>
                        <div class="text-center mt-4">
                            <h6 class="text-secondary mb-2">Banner do Patrocinador</h6>
                            <img src="/campeonato_esportivo/<?= $info['logo'] ?>"
                                 class="img-fluid rounded shadow-sm"
                                 style="max-width: 150%; height: auto; max-height: 150px; object-fit: contain;"
                                 alt="Banner do Patrocinador">
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning text-center mt-4">
                            🖼️ <strong>Banner de Divulgação</strong><br>
                            <small>Espaço reservado para sua marca ou anúncio.</small>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

</body>
</html>
