<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../Models/Time.php';

class TeamController {
    private $teamModel;

    public function __construct($conn) {
        $this->teamModel = new Team($conn);
    }

    public function criarTime($nome, $escudo, $cidade, $estadio) {
        if ($this->teamModel->criar($nome, $escudo, $cidade, $estadio)) {
            return json_encode(["mensagem" => "Time criado com sucesso!"]);
        } else {
            return json_encode(["erro" => "Erro ao criar time."]);
        }
    }
}
?>
