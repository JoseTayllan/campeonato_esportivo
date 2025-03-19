<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/controllers/ChampionshipController.php';

// Criar instância do controlador
$campeonatoController = new ChampionshipController($conn);

// Verificar a requisição
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nome'], $_POST['descricao'], $_POST['temporada'])) {
        echo $campeonatoController->criarCampeonato($_POST['nome'], $_POST['descricao'], $_POST['temporada'],$_POST['formato']);
    } else {
        echo json_encode(["erro" => "Parâmetros ausentes."]);
    }
} else {
    echo json_encode(["erro" => "Método inválido."]);
}
?>