<?php
session_start();
$restrito_para = ['Olheiro','Administrador','Organizador','Treinador','Jogador'];
require_once __DIR__ . '/../../app/middleware/verifica_sessao.php';
require_once __DIR__ . '/../../app/controllers/avaliar_contro/VisualizarAvaliacoesController.php';

$controller = new VisualizarAvaliacoesController();
$dados = $controller->getDadosParaVisualizacao($_GET);

require_once __DIR__ . '/../../public/views/avaliacao/visualizar_avaliacoes.php';
