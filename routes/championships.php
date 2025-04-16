<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/controllers/ChampionshipController.php';
require_once __DIR__ . '/../app/controllers/FaseController.php';
require_once __DIR__ . '/../app/controllers/RodadaController.php';

$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo === 'POST') {
    // Dados do campeonato
    $nome = $_POST['nome'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $temporada = $_POST['temporada'] ?? '';
    $formato = $_POST['formato'] ?? '';
    $times = $_POST['times'] ?? [];

    // Dados da fase
    $nome_fase = $_POST['fase_nome'] ?? '';
    $ordem_fase = $_POST['fase_ordem'] ?? 1;

    // Dados das rodadas (arrays vindos do formulário)
    $numeros = $_POST['rodada_numero'] ?? [];
    $tipos = $_POST['rodada_tipo'] ?? [];
    $descricoes = $_POST['rodada_desc'] ?? [];

    // Verificação mínima
    if (empty($nome) || empty($temporada) || empty($formato)) {
        $_SESSION['mensagem_erro'] = "Campos obrigatórios do campeonato estão faltando.";
        header('Location: ../public/views/cadastro/cadastro_campeonato.php');
        exit;
    }

    // Criar campeonato
    $championshipController = new ChampionshipController($conn);
    $response = json_decode($championshipController->criarCampeonato($nome, $descricao, $temporada, $formato, $times), true);

    if (!isset($response['erro'])) {
        $campeonato_id = $conn->insert_id;

        // Criar fase
        $faseController = new FaseController($conn);
        $fase_id = $faseController->criarFase($campeonato_id, $nome_fase, $ordem_fase);

        if ($fase_id) {
            // Criar rodadas
            $rodadaController = new RodadaController($conn);

            for ($i = 0; $i < count($numeros); $i++) {
                $numero = isset($numeros[$i]) ? intval($numeros[$i]) : 0;
                $tipo = isset($tipos[$i]) ? trim($tipos[$i]) : '';
                $descricao = isset($descricoes[$i]) ? trim($descricoes[$i]) : '';

                if ($descricao === null) {
                    $descricao = '';
                }

                if ($fase_id && $numero > 0 && !empty($tipo)) {
                    $rodadaController->criarRodada($fase_id, $numero, $tipo, $descricao);
                } else {
                    error_log("Rodada ignorada: dados inválidos -> fase_id=$fase_id, numero=$numero, tipo=$tipo");
                }
            }

            $_SESSION['mensagem_sucesso'] = "Campeonato, fase e rodadas criadas com sucesso!";
            header('Location: ../public/views/cadastro/cadastro_campeonato.php');
            exit;
        } else {
            $_SESSION['mensagem_erro'] = "Campeonato criado, mas erro ao criar a fase.";
        }
    } else {
        $_SESSION['mensagem_erro'] = "Erro ao criar campeonato.";
    }

    header('Location: ../public/views/cadastro/cadastro_campeonato.php');
    exit;
} else {
    http_response_code(405);
    echo "Método não permitido.";
}
