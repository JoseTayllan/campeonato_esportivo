<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../Models/Jogador.php';

class PlayerController {
    private $playerModel;

    public function __construct($conn) {
        $this->playerModel = new Player($conn);
    }

    public function criarJogador($nome, $idade, $nacionalidade, $posicao, $time_id, $imagem = null) {
        if ($this->playerModel->criar($nome, $idade, $nacionalidade, $posicao, $time_id, $imagem)) {
            return json_encode(["mensagem" => "Jogador criado com sucesso!"]);
        } else {
            return json_encode(["erro" => "Erro ao criar jogador."]);
        }
    }
}
?>