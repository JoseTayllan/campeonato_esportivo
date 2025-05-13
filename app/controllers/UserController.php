<?php

require_once __DIR__ . '/../Models/Usuario.php';

class UsuarioController {
    private $usuarioModel;

    public function __construct($conn) {
        $this->usuarioModel = new User($conn);
    }

    public function criarUsuario($nome, $email, $senha, $tipo) {
        if ($this->usuarioModel->criar($nome, $email, $senha, $tipo)) {
            return "Usuário criado com sucesso!";
        } else {
            return "Erro ao criar usuário.";
        }
    }
    public function listarTodos() {
        return $this->usuarioModel->listarTodos();
    }

    public function atualizarPerfil($id, $nome, $email, $senha = null) {
        return $this->usuarioModel->atualizarPerfil($id, $nome, $email, $senha);
    }

    public function buscarUsuarioPorId($id) {
        return $this->usuarioModel->buscarPorId($id);
    }
    
}
?>