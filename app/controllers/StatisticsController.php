<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../Models/Estatistica.php';

class StatisticsController {
    private $estatisticaModel;

    public function __construct($conn) {
        $this->estatisticaModel = new Estatistica($conn);
    }

    public function registrarEstatistica($dados) {
        if ($this->estatisticaModel->registrar(
            $dados['partida_id'], 
            $dados['jogador_id'], 
            $dados['gols'] ?? null, 
            $dados['assistencias'] ?? null, 
            $dados['passes_completos'] ?? null, 
            $dados['finalizacoes'] ?? null, 
            $dados['faltas_cometidas'] ?? null, 
            $dados['cartoes_amarelos'] ?? null, 
            $dados['cartoes_vermelhos'] ?? null, 
            $dados['minutos_jogados'] ?? null, 
            $dados['substituicoes'] ?? null,
            $dados['defesas'] ?? null,
            $dados['gols_sofridos'] ?? null,
            $dados['penaltis_defendidos'] ?? null,
            $dados['clean_sheets'] ?? null
        )) {
            return json_encode(["mensagem" => "Estatística registrada com sucesso!"]);
        } else {
            return json_encode(["erro" => "Erro ao registrar estatística."]);
        }
    }
}
?>