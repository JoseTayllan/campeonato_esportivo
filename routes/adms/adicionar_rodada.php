<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/Models/Campeonato.php';

$campeonato_id = $_POST['campeonato_id'] ?? null;
$fase_id = $_POST['fase_id'] ?? null;
$numero = $_POST['numero'] ?? null;
$tipo = $_POST['tipo'] ?? '';
$descricao = $_POST['descricao'] ?? '';
$data = $_POST['data'] ?? null;
$hora = $_POST['hora'] ?? null;

$model = new Campeonato($conn);

if (!$campeonato_id || !$fase_id || !$numero || !$tipo || !$data || !$hora) {
    $_SESSION['mensagem_erro'] = "⚠️ Preencha todos os campos obrigatórios para adicionar a rodada.";
    header("Location: campeonato_editar.php?id=$campeonato_id");
    exit;
}

$adicionada = $model->adicionarRodada($fase_id, $numero, $tipo, $descricao, $data, $hora);

if ($adicionada) {
    $_SESSION['mensagem_sucesso'] = "✅ Rodada adicionada com sucesso!";
} else {
    $_SESSION['mensagem_erro'] = "Erro ao adicionar a rodada.";
}

header("Location: campeonato_editar.php?id=$campeonato_id");
exit;
