<?php

require_once __DIR__ . '/../models/Ranking.php';

class RankingController {
    private $model;

    public function __construct($conn) {
        $this->model = new Ranking($conn);
    }

    public function dadosDoRanking() {
        return [
            'artilheiros' => $this->model->artilheiros(),
            'cartoes' => $this->model->cartoes(),
            'vitorias' => $this->model->timesComMaisVitorias()
        ];
    }
}
