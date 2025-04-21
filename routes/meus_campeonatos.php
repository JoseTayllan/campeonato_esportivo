<?php
session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/controllers/ChampionshipController.php';

$usuario_id = $_SESSION['usuario_id'] ?? null;

if (!$usuario_id) {
    $_SESSION['mensagem_erro'] = "Sessão expirada.";
    header("Location: ../public/views/login/login.php");
    exit;
}

$controller = new ChampionshipController($conn);
$campeonatos = $controller->listarMeusCampeonatos($usuario_id);

// ⚠️ ROTA INCLUI A VIEW CORRETAMENTE
include __DIR__ . '/../public/views/campeonatos/meus_campeonatos.php';
