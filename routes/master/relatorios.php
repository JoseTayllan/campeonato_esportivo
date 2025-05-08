<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

if (!isset($_SESSION['usuario_tipo']) || $_SESSION['usuario_tipo'] !== 'master') {
    header("Location: /public/index.php");
    exit;
}

// Aqui você carrega view de relatórios (iremos montar ainda)
require_once __DIR__ . '/../../public/views/master/relatorios.php';
