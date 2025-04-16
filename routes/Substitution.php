<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/controllers/SubstitutionController.php';

session_start(); // Iniciar sessão para mensagens

$substitutionController = new SubstitutionController($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['partida_id'], $_POST['jogador_saiu'], $_POST['jogador_entrou'], $_POST['minuto_substituicao'])) {
        $resultado = $substitutionController->registrarSubstituicao($_POST);

        if (strpos($resultado, 'sucesso') !== false) {
            $_SESSION['mensagem_sucesso'] = "Substituição registrada com sucesso!";
            echo json_encode(["mensagem" => "Substituição registrada com sucesso!"]); // 🔹 ADICIONADO
        } else {
            $_SESSION['mensagem_erro'] = "Erro ao registrar substituição: " . $resultado;
        }
    } else {
        $_SESSION['mensagem_erro'] = "Parâmetros ausentes.";
    }
    header("Location: ../public/views/substituicao/cadastro_substituicao.php");
    exit();
} else {
    $_SESSION['mensagem_erro'] = "Método inválido.";
    header("Location: ../public/views/substituicao/cadastro_substituicao.php");
    exit();
}
?>