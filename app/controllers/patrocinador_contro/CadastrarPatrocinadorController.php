<?php
require_once __DIR__ . '/../../Models/patrocinador/Patrocinador.php';

class CadastrarPatrocinadorController {
    private $model;

    public function __construct($conn) {
        $this->model = new Patrocinador($conn);
    }

    public function criar($nome, $contrato, $telefone, $logo, $usuario_id) {
        return $this->model->criar($nome, $contrato, $telefone, $logo, $usuario_id);
    }
    
    public function verificarExistente($usuario_id) {
        return $this->model->buscarPorUsuarioId($usuario_id);
    }
}
