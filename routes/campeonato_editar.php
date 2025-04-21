<?php 
session_start();
$restrito_para = ['Administrador', 'Organizador'];
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/models/Campeonato.php';
require_once __DIR__ . '/../app/models/Fase.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    $_SESSION['mensagem_erro'] = "Campeonato não especificado.";
    header("Location: campeonatos_listar.php");
    exit;
}

$model = new Campeonato($conn); 
$campeonatoModel = new Campeonato($conn);
$faseModel = new Fase($conn);

// Verifica se o campeonato já tem fases
$fasesExistentes = $faseModel->listarFasesDoCampeonato($id);
if (count($fasesExistentes) === 0) {
    $globais = $faseModel->listarFasesGlobais();
    foreach ($globais as $fase) {
        $faseModel->criarFaseNoCampeonato($id, $fase['nome'], $fase['ordem']);
    }
}

$campeonato = $campeonatoModel->buscarPorId($id);

include __DIR__ . '/../public/views/campeonatos/editar_campeonato.php';
?>