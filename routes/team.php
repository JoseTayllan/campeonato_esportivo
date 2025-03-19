<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/controllers/TeamController.php';

// Criar instância do controlador
$timeController = new TeamController($conn);

// Verificar a requisição
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nome'], $_POST['cidade'], $_POST['estadio'])) {
        echo $timeController->criarTime($_POST['nome'], $_POST['cidade'], $_POST['estadio'],$_POST['escudo']);
    } else {
        echo json_encode(["erro" => "Parâmetros ausentes."]);
    }
} else {
    echo json_encode(["erro" => "Método inválido."]);
}
?>