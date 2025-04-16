<?php
session_start();
require_once '../config/database.php';
require_once '../app/controllers/ChampionshipController.php';

$controller = new ChampionshipController($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Cadastro de campeonato
    if (isset($_POST['nome'], $_POST['descricao'], $_POST['temporada'], $_POST['formato'])) {
        $formato = $_POST['formato'];
        $formatos_validos = ['Pontos Corridos', 'Mata-Mata', 'Fase de Grupos'];

        if (!in_array($formato, $formatos_validos)) {
            $_SESSION['mensagem_erro'] = "Formato inválido: " . htmlspecialchars($formato);
            header("Location: ../public/views/cadastro/cadastro_campeonato.php");
            exit();
        }

        $times = $_POST['times'] ?? []; // array de times selecionados (caso exista no form)

        $resultado = $controller->criarCampeonato(
            $_POST['nome'],
            $_POST['descricao'],
            $_POST['temporada'],
            $formato,
            $times
        );

        if (strpos($resultado, 'sucesso') !== false) {
            $_SESSION['mensagem_sucesso'] = "Campeonato cadastrado com sucesso!";
        } else {
            $_SESSION['mensagem_erro'] = "Erro ao cadastrar campeonato: " . $resultado;
        }

        header("Location: ../public/views/cadastro/cadastro_campeonato.php");
        exit();
    }

    // Associação ou remoção de times
    if (isset($_POST['acao'], $_POST['time_id'], $_POST['campeonato_id'])) {
        $acao = $_POST['acao'];
        $time_id = intval($_POST['time_id']);
        $campeonato_id = intval($_POST['campeonato_id']);

        if ($acao === 'adicionar') {
            $controller->adicionarTime($time_id, $campeonato_id);
            $_SESSION['mensagem_sucesso'] = "Time adicionado com sucesso!";
        } elseif ($acao === 'remover') {
            $controller->removerTime($time_id, $campeonato_id);
            $_SESSION['mensagem_sucesso'] = "Time removido com sucesso!";
        } else {
            $_SESSION['mensagem_erro'] = "Ação inválida.";
        }

        header("Location: ../public/views/campeonatos/times.php?id=$campeonato_id");
        exit();
    }

    $_SESSION['mensagem_erro'] = "Requisição malformada.";
    header("Location: ../public/views/cadastro/cadastro_campeonato.php");
    exit();

} else {
    $_SESSION['mensagem_erro'] = "Método inválido.";
    header("Location: ../public/views/cadastro/cadastro_campeonato.php");
    exit();
}
