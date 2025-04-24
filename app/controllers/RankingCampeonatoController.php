<?php

require_once __DIR__ . '/../models/RankingPorCampeonato.php';

class RankingCampeonatoController {
    private $model;

    public function __construct($db) {
        $this->model = new RankingPorCampeonato($db);
    }

    public function dadosPorCampeonato($campeonato_id) {
        return [
            'artilheiros' => $this->model->artilheiros($campeonato_id),
            'cartoes' => $this->model->cartoes($campeonato_id),
            'vitorias' => $this->model->timesComMaisVitorias($campeonato_id)
        ];
    }
}
