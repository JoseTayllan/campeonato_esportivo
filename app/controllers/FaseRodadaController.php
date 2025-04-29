<?php

// Controller: app/controllers/FaseRodadaController.php
require_once __DIR__ . '/../Models/FaseRodadaModel.php';

class FaseRodadaController {
    private $model;

    public function __construct($conn) {
        $this->model = new FaseRodadaModel($conn);
    }

    public function carregarDados($campeonato_id) {
        return [
            'fases' => $this->model->buscarFasesERodadas($campeonato_id),
            'classificacao' => $this->model->classificacaoTimes($campeonato_id),
            'campeonatos' => $this->model->listarCampeonatos()
        ];
    }
}
