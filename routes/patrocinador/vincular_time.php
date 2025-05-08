<?php
session_start();

require_once __DIR__ . '/../../app/middleware/verifica_sessao.php';
require_once __DIR__ . '/../../app/controllers/patrocinador_contro/VincularTimeController.php';

$controller = new VincularTimeController($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ✅ Inclui o ano do contrato junto com o restante dos dados
    $controller->vincular($_SESSION['usuario_id'], $_POST);
    $_SESSION['mensagem_sucesso'] = "Time vinculado com sucesso!";
    header("Location: patrocinador_dashboard.php");
    exit;
}

$times_disponiveis = $controller->buscarTimesDisponiveis($_SESSION['usuario_id']);
require_once __DIR__ . '/../../public/views/patrocinador/vincular_time.php';
