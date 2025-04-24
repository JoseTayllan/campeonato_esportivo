<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/controllers/PatrocinadorController.php';
require_once __DIR__ . '/../app/middleware/verifica_sessao.php';

// ✅ Restringe acesso ao tipo patrocinador
$restrito_para = ['patrocinador'];

$controller = new PatrocinadorController($conn);
$patrocinador_id = $_SESSION['usuario_id'];

$times = $controller->obterTimesPatrocinados($patrocinador_id);

$dados_dashboard = [];
foreach ($times as $time) {
    $estatisticas = $controller->obterDesempenhoTime($time['id']);
    $dados_dashboard[] = [
        'time' => $time,
        'estatisticas' => $estatisticas
    ];
}

require_once __DIR__ . '/../public/views/patrocinador/dashboard.php';
