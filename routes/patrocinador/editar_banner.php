<?php
session_start();
require_once __DIR__ . '/../../app/middleware/verifica_sessao.php';
require_once __DIR__ . '/../../app/controllers/patrocinador_contro/EditarBannerController.php';

$controller = new EditarBannerController($conn);
$patrocinador = $controller->buscarPorUsuario($_SESSION['usuario_id']);

if (!$patrocinador) {
    echo "<div class='container py-5'><div class='alert alert-danger'>Empresa não encontrada.</div></div>";
    exit;
}

require_once __DIR__ . '/../../public/views/patrocinador/editar_banner.php';
