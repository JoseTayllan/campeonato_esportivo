<?php
session_start();
$restrito_para = ['Administrador', 'Organizador'];
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/models/Campeonato.php';

$model = new Campeonato($conn); 
$campeonatoModel = new Campeonato($conn);

$id = $_GET['id'] ?? null;

if (!$id) {
    $_SESSION['mensagem_erro'] = "Campeonato não especificado.";
    header("Location: campeonatos_listar.php");
    exit;
}

$campeonato = $campeonatoModel->buscarPorId($id);

include __DIR__ . '/../public/views/campeonatos/editar_campeonato.php';
