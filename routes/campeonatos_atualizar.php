<?php
session_start();
$restrito_para = ['Administrador', 'Organizador'];
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/models/Campeonato.php';

$model = new Campeonato($conn);

$id = $_POST['id'];
$nome = $_POST['nome'];
$descricao = $_POST['descricao'];
$temporada = $_POST['temporada'];
$formato = $_POST['formato'];
$modalidade = $_POST['modalidade'];

if ($model->atualizar($id, $nome, $descricao, $temporada, $formato, $modalidade)) {
    $_SESSION['mensagem_sucesso'] = "Campeonato atualizado com sucesso!";
} else {
    $_SESSION['mensagem_erro'] = "Erro ao atualizar o campeonato.";
}

header("Location: campeonato_editar.php?id=" . $id);
exit;
