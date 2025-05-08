<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/controllers/UsuariosController.php';

if (!isset($_SESSION['usuario_tipo']) || $_SESSION['usuario_tipo'] !== 'master') {
    header("Location: /public/index.php");
    exit;
}

$controller = new UsuarioController($conn);
$usuarios = $controller->listarTodos();

require_once __DIR__ . '/../../public/views/master/usuarios.php';
