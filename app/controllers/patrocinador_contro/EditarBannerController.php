<?php
require_once __DIR__ . '/../../Models/patrocinador/Patrocinador.php';

class EditarBannerController {
    private $model;

    public function __construct($conn) {
        $this->model = new Patrocinador($conn);
    }

    public function buscarPorUsuario($usuario_id) {
        return $this->model->buscarPorUsuarioId($usuario_id);
    }
}
