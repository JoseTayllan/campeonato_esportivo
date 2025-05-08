<?php
session_start();

require_once __DIR__ . '/../../app/middleware/verifica_sessao.php';
require_once __DIR__ . '/../../app/controllers/patrocinador_contro/AtualizarBannerController.php';

$controller = new AtualizarBannerController($conn);

if (isset($_POST['atualizar_banner'])) {
    $controller->atualizarLogo($_SESSION['usuario_id'], $_FILES['logo']);
}

header("Location: patrocinador_dashboard.php");
exit;
