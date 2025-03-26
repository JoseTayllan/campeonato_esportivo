<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../Models/Avaliacao.php';

class AvaliacaoController {
    private $avaliacaoModel;

    public function __construct($conn) {
        $this->avaliacaoModel = new Avaliacao($conn);
    }

    public function criarAvaliacao($dados) {
        if ($this->avaliacaoModel->criar(
            $dados['jogador_id'], 
            $dados['olheiro_id'], 
            $dados['forca'] ?? null, 
            $dados['velocidade'] ?? null, 
            $dados['drible'] ?? null, 
            $dados['finalizacao'] ?? null, 
            $dados['nota_geral'] ?? null, 
            $dados['observacoes'] ?? null
        )) {
            return json_encode(["mensagem" => "Avaliação registrada com sucesso!"]);
        } else {
            return json_encode(["erro" => "Erro ao registrar avaliação."]);
        }
    }
}
?>