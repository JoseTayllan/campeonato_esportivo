<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/controllers/StatisticsController.php';

session_start(); // Iniciar sessão para mensagens

$statisticsController = new StatisticsController($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['partida_id'], $_POST['jogador_id'])) {

        // Tratando todos os campos, inclusive novos campos de goleiro
        $dados = [
            'partida_id' => (int) $_POST['partida_id'],
            'jogador_id' => (int) $_POST['jogador_id'],
            'gols' => (int) ($_POST['gols'] ?? 0),
            'assistencias' => (int) ($_POST['assistencias'] ?? 0),
            'passes_completos' => (int) ($_POST['passes_completos'] ?? 0),
            'finalizacoes' => (int) ($_POST['finalizacoes'] ?? 0),
            'faltas_cometidas' => (int) ($_POST['faltas_cometidas'] ?? 0),
            'cartoes_amarelos' => (int) ($_POST['cartoes_amarelos'] ?? 0),
            'cartoes_vermelhos' => (int) ($_POST['cartoes_vermelhos'] ?? 0),
            'minutos_jogados' => (int) ($_POST['minutos_jogados'] ?? 0),
            'substituicoes' => (int) ($_POST['substituicoes'] ?? 0),
            'defesas' => (int) ($_POST['defesas'] ?? 0),
            'penaltis_defendidos' => (int) ($_POST['penaltis_defendidos'] ?? 0),
            'gols_sofridos' => (int) ($_POST['gols_sofridos'] ?? 0),
            'clean_sheets' => (int) ($_POST['clean_sheets'] ?? 0),
        ];

        $resultado = $statisticsController->registrarEstatistica($dados);

        if (strpos($resultado, 'sucesso') !== false) {
            $_SESSION['mensagem_sucesso'] = "Estatística registrada com sucesso!";
        } else {
            $_SESSION['mensagem_erro'] = "Erro ao registrar estatística: " . $resultado;
        }
    } else {
        $_SESSION['mensagem_erro'] = "Parâmetros ausentes.";
    }
    header("Location: ../public/views/estatistica/cadastrar_estatistica_jogador.php");
    exit();
} else {
    $_SESSION['mensagem_erro'] = "Método inválido.";
    header("Location: ../public/views/estatistica/cadastrar_estatistica_jogador.php");
    exit();
}
?>