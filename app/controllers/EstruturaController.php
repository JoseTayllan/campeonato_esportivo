<?php
require_once __DIR__ . '/../models/Campeonato.php';

class EstruturaController {
    private $model;

    public function __construct($conn) {
        $this->model = new Campeonato($conn);
    }

    public function listarConfrontosPorFase($campeonato_id, $nome_fase) {
        return $this->model->listarPartidasPorFase($campeonato_id, $nome_fase);
    }
}
