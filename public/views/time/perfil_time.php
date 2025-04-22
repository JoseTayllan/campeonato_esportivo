<?php
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../app/controllers/TeamController.php';

$controller = new TeamController($conn);
$codigo = $_GET['codigo'] ?? '';

$time = $controller->buscarTimePublico($codigo);

if (!$time) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Time não encontrado.</div></div>";
    exit;
}

$jogadores = $controller->listarElencoPublico($time['id']);
?>

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
                <img src="../../<?= $time['escudo'] ?>" width="120" alt="Escudo do time">
            <?php endif; ?>
        </div>
    </div>

    <h4>Elenco</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Posição</th>
                <th>Idade</th>
                <th>Nacionalidade</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($j = $jogadores->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($j['nome']) ?></td>
                    <td><?= htmlspecialchars($j['posicao']) ?></td>
                    <td><?= (int) $j['idade'] ?></td>
                    <td><?= htmlspecialchars($j['nacionalidade']) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
