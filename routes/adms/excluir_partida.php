<?php 
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/Models/Campeonato.php';

$partida_id = $_GET['id'] ?? null;
$campeonato_id = $_GET['campeonato_id'] ?? null;

if (!$partida_id || !$campeonato_id) {
    $_SESSION['mensagem_erro'] = "ID da partida ou do campeonato não informado.";
    header("Location: campeonato_editar_rodadas.php?id=$campeonato_id");
    exit;
}

$model = new Campeonato($conn);
$removido = $model->excluirPartida($partida_id);

if ($removido) {
    $_SESSION['mensagem_sucesso'] = "✅ Partida removida com sucesso!";
} else {
    $_SESSION['mensagem_erro'] = "Erro ao remover a partida.";
}

header("Location: campeonato_editar_rodadas.php?id=$campeonato_id");
exit;
