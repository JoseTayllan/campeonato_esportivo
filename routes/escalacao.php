
<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/controllers/escalacaoController.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $partida_id = $_POST['partida_id'] ?? null;
    $jogadores = $_POST['escalacao'] ?? [];
    $capitao_id = $_POST['capitao'] ?? null;

    if (!$partida_id || empty($jogadores)) {
        $_SESSION['mensagem_erro'] = "Dados incompletos.";
        header("Location: agenda_time.php");
        exit;
    }

    $dados_formatados = [];

    foreach ($jogadores as $item) {
        if (!isset($item['jogador_id'])) continue;


        $jogador_id = (int)$item['jogador_id'];

        $dados_formatados[] = [
            'partida_id' => (int)$partida_id,
            'jogador_id' => $jogador_id,
            'titular' => isset($item['titular']) ? 1 : 0,
            'capitao' => ($capitao_id == $jogador_id) ? 1 : 0 // ✅ Correção definitiva
        ];
    }

    $controller = new EscalacaoController($conn);
    $controller->salvarEscalacao($dados_formatados);

    $_SESSION['mensagem_sucesso'] = "Escalação salva com sucesso!";
    header("Location: agenda_time.php");
    exit;
}
