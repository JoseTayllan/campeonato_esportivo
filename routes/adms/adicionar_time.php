<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/models/Campeonato.php';

$model = new Campeonato($conn);
$model->vincularTime($_POST['campeonato_id'], $_POST['time_id']);

// Redireciona de volta para a tela de edição do campeonato
header("Location: /campeonato_editar.php?id=" . $_POST['campeonato_id']);
exit;
