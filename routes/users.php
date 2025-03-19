<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/controllers/UserController.php';

// Criar instância do controlador
$usuarioController = new UsuarioController($conn);

// Verificar a requisição
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nome'], $_POST['email'], $_POST['senha'], $_POST['tipo'])) {
        echo $usuarioController->criarUsuario($_POST['nome'], $_POST['email'], $_POST['senha'], $_POST['tipo']);
    } else {
        echo json_encode(["erro" => "Parâmetros ausentes."]);
    }
} else {
    echo json_encode(["erro" => "Método inválido."]);
}
?>