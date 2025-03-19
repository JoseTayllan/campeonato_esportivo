<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/controllers/PlayerController.php';

// Criar instância do controlador
$jogadorController = new PlayerController($conn);

// Verificar a requisição
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nome'], $_POST['idade'], $_POST['nacionalidade'], $_POST['posicao'],$_POST['time_id'])) {
        echo $jogadorController->criarJogador($_POST['nome'], $_POST['idade'], $_POST['nacionalidade'], $_POST['posicao'],$_POST['time_id']);
    } else {
        echo json_encode(["erro" => "Parâmetros ausentes."]);
    }
} else {
    echo json_encode(["erro" => "Método inválido."]);
}
?>