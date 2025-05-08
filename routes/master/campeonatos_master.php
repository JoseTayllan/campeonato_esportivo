<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/controllers/ChampionshipController.php';
require_once __DIR__ . '/../../app/controllers/UsuarioController.php';

$controllerCampeonatos = new ChampionshipController($conn);
$controllerUsuarios = new UsuarioController($conn);

$campeonatos = $controllerCampeonatos->listarTodos();
$usuarios = $controllerUsuarios->listarTodos();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Master</title>
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h2 class="mb-4">Painel da Equipe Master</h2>

    <div class="mb-5">
        <h4>Campeonatos</h4>
        <?php if (empty($campeonatos)): ?>
            <div class="alert alert-warning">Nenhum campeonato encontrado.</div>
        <?php else: ?>
            <ul class="list-group">
                <?php foreach ($campeonatos as $camp): ?>
                    <li class="list-group-item">
                        <?= htmlspecialchars($camp['nome']) ?> (<?= htmlspecialchars($camp['temporada']) ?>)
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

    <div class="mb-5">
        <h4>Usuários</h4>
        <?php if (empty($usuarios)): ?>
            <div class="alert alert-warning">Nenhum usuário encontrado.</div>
        <?php else: ?>
            <ul class="list-group">
                <?php foreach ($usuarios as $user): ?>
                    <li class="list-group-item">
                        <?= htmlspecialchars($user['nome']) ?> (<?= htmlspecialchars($user['tipo']) ?>)
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>

<script src="/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
