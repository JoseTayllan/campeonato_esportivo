<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/controllers/ExportController.php';

session_start();

$exportController = new ExportController($conn);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $tipo = $_GET['tipo'] ?? null;
    $jogadorId = isset($_GET['jogador_id']) ? intval($_GET['jogador_id']) : null;

    if ($tipo === 'csv') {
        $exportController->exportarCSV();
    } elseif ($tipo === 'pdf') {
        $exportController->exportarPDF($jogadorId);
    } else {
        $_SESSION['mensagem_erro'] = "Tipo de exportação inválido.";
        header("Location: ../public/views/estatisticas/vizualizar_estatistica_jogador.php");
        exit();
    }
} else {
    $_SESSION['mensagem_erro'] = "Método inválido.";
    header("Location: ../public/views/estatisticas/vizualizar_estatistica_jogador.php");
    exit();
}