<?php
session_start();
require_once __DIR__ . '/../../app/controllers/time_contro/agenda_time.php';
require_once __DIR__ . '/../../app/middleware/verifica_sessao.php';
require_once __DIR__ . '/../../app/middleware/verifica_assinatura.php';

permite_acesso(['time', 'completo']);

$controller = new AgendaTime($conn);
$partidas = $controller->buscarPartidasDoMeuTime($_SESSION['usuario_id']);

require_once __DIR__ . '/../../public/views/time/agenda.php';
