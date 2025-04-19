<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/models/Campeonato.php';

$model = new Campeonato($conn);
$model->desvincularTime($_GET['campeonato_id'], $_GET['time_id']);

header("Location: campeonato_editar.php?id=" . $_GET['campeonato_id']);
exit;

