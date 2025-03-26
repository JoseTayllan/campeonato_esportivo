<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../Models/Substituicao.php';

class SubstituicaoController {
    private $substituicaoModel;

    public function __construct($conn) {
        $this->substituicaoModel = new Substituicao($conn);
    }

    public function registrarSubstituicao($dados) {
        if ($this->substituicaoModel->registrarSubstituicao(
            $dados['partida_id'], 
            $dados['jogador_saiu'] ?? null, 
            $dados['jogador_entrou'] ?? null, 
            $dados['minuto_substituicao'] ?? null
        )) {
            return json_encode(["mensagem" => "Substituição registrada com sucesso!"]);
        } else {
            return json_encode(["erro" => "Erro ao registrar substituição."]);
        }
    }
}
?>