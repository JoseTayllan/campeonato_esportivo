<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/controllers/EstruturaController.php';




$campeonato_id = $_GET['id'] ?? 0;

$estruturaController = new EstruturaController($conn);

include __DIR__ . '/../../public/views/estrutura/estrutura_campeonato.php';
