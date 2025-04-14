<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../Models/login.php';

class LoginController {
    private $usuarioModel;

    public function __construct($conn) {
        $this->usuarioModel = new Usuario($conn);
    }

    public function autenticar($email, $senha) {
        $usuario = $this->usuarioModel->buscarPorEmail($email);
    
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            return $usuario;
        }
        return false;
    }
}