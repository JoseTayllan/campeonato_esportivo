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
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Área do Patrocinador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
        }

        .card {
            border-radius: 16px;
            transition: 0.3s;
        }

        .card:hover {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transform: scale(1.01);
        }

        .card-header {
            font-weight: bold;
            font-size: 1.3rem;
        }

        .alert-warning {
            background-color: #fff8e1;
            border: 1px dashed #ffca28;
        }

        .list-unstyled li {
            margin-bottom: 0.75rem;
        }

        .page-title {
            font-weight: 600;
        }

        .container-custom {
            max-width: 900px;
            margin: 0 auto;
        }
    </style>
</head>
<body>

<div class="container my-5 container-custom">
    <div class="text-center mb-5">
        <h2 class="text-dark page-title">
            <i class="bi bi-briefcase-fill me-2"></i>Área do Patrocinador
        </h2>
        <p class="text-muted">Acompanhe o desempenho dos seus times patrocinados</p>
    </div>

    <?php if (empty($dados_dashboard)): ?>
        <div class="alert alert-info text-center">Nenhum time patrocinado encontrado.</div>
    <?php else: ?>
        <?php foreach ($dados_dashboard as $info): ?>
            <div class="card mb-5 shadow">
                <div class="card-header bg-primary text-white text-center">
                    <?= $info['time']['nome'] ?>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Cidade:</strong> <?= $info['time']['cidade'] ?> <br>
                       <strong>Estádio:</strong> <?= $info['time']['estadio'] ?></p>

                    <hr class="my-3">
                    <h6 class="text-success">📊 Estatísticas e resultados</h6>
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

                     <!-- Banner real ou placeholder -->
                    <?php if (!empty($info['logo'])): ?>
                        <div class="text-center mt-4">
                            <img src="<?= $info['logo'] ?>" class="img-fluid rounded shadow-sm" style="max-height: 120px;" alt="Banner do Patrocinador">
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
