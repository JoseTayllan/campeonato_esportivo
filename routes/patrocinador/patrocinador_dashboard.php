<?php
session_start();


require_once __DIR__ . '/../../app/controllers/patrocinador_contro/PatrocinadorController.php';
require_once __DIR__ . '/../../app/middleware/verifica_sessao.php';

$controller = new PatrocinadorController($conn);

// 🚫 Verifica se patrocinador está cadastrado
$patrocinador = $controller->buscarPorUsuario($_SESSION['usuario_id']);
if (!$patrocinador) {
    require_once __DIR__ . '/../../public/includes/assinatura_patrocinador.php';
    echo '<div class="container py-5">';
    echo '<div class="alert alert-warning text-center shadow mb-4">';
    echo '<h5>Você ainda não cadastrou sua empresa patrocinadora.</h5>';
    echo '<p>Para acessar suas funcionalidades, é necessário cadastrar sua empresa abaixo:</p>';
    echo '<a href="/campeonato_esportivo/routes/patrocinador/cadastrar_patrocinador.php" class="btn btn-primary mt-3">';
    echo '<i class="bi bi-building-add me-1"></i> Cadastrar Agora';
    echo '</a>';
    echo '</div></div>';
    exit;
}

// ✅ Desvincular time (POST)
if (isset($_POST['desvincular_time'], $_POST['time_id'])) {
    $controller->desvincularTime($patrocinador['id'], (int)$_POST['time_id']);
    header("Location: patrocinador_dashboard.php");
    exit;
}

// ✅ Buscar times e estatísticas
$dados_dashboard = [];
$times = $controller->obterTimesPatrocinados($patrocinador['id']);

foreach ($times as $time) {
    $dados_dashboard[] = [
        'time' => $time,
        'estatisticas' => $controller->calcularEstatisticas($time['id']),
        'logo' => $time['logo'] ?? null,
        'valor_investido' => $time['valor_investido'] ?? 0
    ];
}

// ✅ Envia para a view
require_once __DIR__ . '/../../public/views/patrocinador/dashboard.php';
