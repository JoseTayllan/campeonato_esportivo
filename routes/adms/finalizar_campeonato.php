<?php
require_once __DIR__ . '/../../app/controllers/finalizar_campeonato/FinalizarCampeonatoController.php';

$controller = new FinalizarCampeonatoController();

$mensagem = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $campeonato_id = (int) $_POST['campeonato_id'];
    $campeao_id = (int) $_POST['campeao_id'];

     if ($campeonato_id > 0 && $campeao_id > 0) {
        $controller->finalizar($campeonato_id, $campeao_id);
        $mensagem = "✅ Campeonato finalizado com sucesso!";
        // Limpa o GET para não carregar mais os times
        unset($_GET['campeonato_id']);
    } else {
        $mensagem = "❌ Dados inválidos para finalizar o campeonato.";
    }
}

// Carregar lista de campeonatos ativos
$campeonatos = $controller->listarCampeonatosAtivos();

// Carregar times se campeonato foi selecionado
$times = [];
if (isset($_GET['campeonato_id'])) {
    $times = $controller->listarTimesPorCampeonato((int) $_GET['campeonato_id']);
}

// Chama a view
require_once __DIR__ . '/../../public/views/campeonatos/finalizar_campeonato.php';
