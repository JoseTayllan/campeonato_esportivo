<?php
session_start();
$restrito_para = ['Administrador'];
require_once __DIR__ . '/../../app/middleware/verifica_sessao.php';
require_once __DIR__ . '/../../app/controllers/contro_adm/DashboardAdminController.php';

$controller = new DashboardAdminController();
$admin_id = $_SESSION['usuario_id'] ?? null;
$dados = $controller->carregarDashboard($admin_id);


require_once __DIR__ . '/../../public/views/dashboard/dashboard_administrador.php';
