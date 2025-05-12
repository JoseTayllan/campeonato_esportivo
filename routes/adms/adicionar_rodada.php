<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/Models/Campeonato.php';

$campeonato_id = $_POST['campeonato_id'] ?? null;
$fase_id = $_POST['fase_id'] ?? null; // 🔹 novo campo vindo do formulário
$numero = $_POST['numero'] ?? null;
$tipo = $_POST['tipo'] ?? '';
$descricao = $_POST['descricao'] ?? '';
$data = $_POST['data'] ?? null;
$hora = $_POST['hora'] ?? null;

$model = new Campeonato($conn);

// agora não buscamos a primeira fase — usamos a fase selecionada manualmente
if ($fase_id) {
    $model->adicionarRodada($fase_id, $numero, $tipo, $descricao, $data, $hora);
}

header("Location: campeonato_editar.php?id=$campeonato_id");
exit;
