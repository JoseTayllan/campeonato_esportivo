<?php
require_once '../../config/database.php';
require_once '../../app/controllers/JogadorPublicoController.php';

$id = $_GET['id'] ?? null;

if ($id) {
    JogadorPublicoController::exibir($conn, $id);
} else {
    echo "Jogador não encontrado.";
}
