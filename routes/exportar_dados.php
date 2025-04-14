<?php
session_start();
require_once __DIR__ . '/../app/controllers/ExportAvaliacaoController.php';

$exportController = new ExportAvaliacaoController();

if (isset($_GET['tipo']) && (isset($_GET['dados']) || isset($_GET['jogador_id']))) {
    $tipo = $_GET['tipo'];
    $dados = $_GET['dados'] ?? null;

    $exportController = new ExportAvaliacaoController();

    if ($dados === 'avaliacoes') {
        if ($tipo === 'csv') {
            $exportController->exportarCSV();
        } elseif ($tipo === 'pdf') {
            $exportController->exportarPDF();
        } else {
            die('Erro: Tipo inválido!');
        }
    }

    elseif ($dados === 'estatisticas') {
        if ($tipo === 'pdf') {
            $exportController->exportarEstatisticasPDF();
        } elseif ($tipo === 'csv') {
            $exportController->exportarEstatisticasCSV(); // opcional
        } else {
            die('Erro: Tipo inválido!');
        }
    }

    elseif (isset($_GET['jogador_id'])) {
        if ($tipo === 'pdf') {
            $exportController->exportarPDF();
        } elseif ($tipo === 'csv') {
            $exportController->exportarCSV();
        } else {
            die('Erro: Tipo inválido!');
        }
    }

    else {
        die('Erro: Dados inválidos!');
    }
} else {
    die('Erro: Parâmetros ausentes!');
}
