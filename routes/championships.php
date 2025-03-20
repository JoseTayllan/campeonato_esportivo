<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/controllers/ChampionshipController.php';

session_start(); // Iniciar sessão para mensagens

$campeonatoController = new ChampionshipController($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nome'], $_POST['descricao'], $_POST['temporada'], $_POST['formato'])) {
        $formato = $_POST['formato'];

        // Verificar se o formato é válido
        $formatos_validos = ['Pontos Corridos', 'Mata-Mata', 'Fase de Grupos'];
        if (!in_array($formato, $formatos_validos)) {
            $_SESSION['mensagem_erro'] = "Formato inválido: " . htmlspecialchars($formato);
            header("Location: ../public/views/cadastro/cadastro_campeonato.php");
            exit();
        }

        // Criar campeonato
        $resultado = $campeonatoController->criarCampeonato(
            $_POST['nome'],
            $_POST['descricao'],
            $_POST['temporada'],
            $formato
        );

        if (strpos($resultado, 'sucesso') !== false) {
            $_SESSION['mensagem_sucesso'] = "Campeonato cadastrado com sucesso!";
        } else {
            $_SESSION['mensagem_erro'] = "Erro ao cadastrar campeonato: " . $resultado;
        }
    } else {
        $_SESSION['mensagem_erro'] = "Parâmetros ausentes.";
    }
    header("Location: ../public/views/cadastro/cadastro_campeonato.php");
    exit();
} else {
    $_SESSION['mensagem_erro'] = "Método inválido.";
    header("Location: ../public/views/cadastro/cadastro_campeonato.php");
    exit();
}
?>
