<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/Models/Campeonato.php';

$rodada_id = $_GET['id'] ?? null;
$campeonato_id = $_GET['campeonato_id'] ?? null;

if (!$rodada_id || !$campeonato_id) {
    $_SESSION['mensagem_erro'] = "ID da rodada ou do campeonato não informado.";
    header("Location: campeonato_editar_rodadas.php?id=$campeonato_id");
    exit;
}

$model = new Campeonato($conn);
$removido = $model->excluirRodada($rodada_id);

if ($removido) {
    $_SESSION['mensagem_sucesso'] = "✅ Rodada excluída com sucesso!";
} else {
    $_SESSION['mensagem_erro'] = "Erro ao excluir a rodada.";
}

header("Location: campeonato_editar_rodadas.php?id=$campeonato_id");
exit;
