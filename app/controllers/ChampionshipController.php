<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../Models/Campeonato.php';

class ChampionshipController {
    private $championshipModel;

    public function __construct($conn) {
        $this->championshipModel = new Championship($conn);
    }

    public function criarCampeonato($nome, $descricao, $temporada, $formato) {
        if ($this->championshipModel->criar($nome, $descricao, $temporada, $formato)) {
            return json_encode(["mensagem" => "Campeonato criado com sucesso!"]);
        } else {
            return json_encode(["erro" => "Erro ao criar campeonato."]);
        }
    }
}
?>