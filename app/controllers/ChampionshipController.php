<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../Models/Campeonato.php';

class ChampionshipController {
    private $campeonatoModel;

    public function __construct($conn) {
        $this->campeonatoModel = new Campeonato($conn);
    }

    public function criarCampeonato($nome, $descricao, $temporada, $formato, $criado_por, $times = []) {
        $campeonato_id = $this->campeonatoModel->criar($nome, $descricao, $temporada, $formato, $formato, $criado_por);
        
        if ($campeonato_id) {
            // Associa os times se fornecidos
            if (!empty($times)) {
                $this->campeonatoModel->associarTimes($campeonato_id, $times);
            }
            return json_encode(["mensagem" => "Campeonato criado e times associados com sucesso!"]);
        } else {
            return json_encode(["erro" => "Erro ao criar campeonato."]);
        }
    }
    
    public function adicionarTime($time_id, $campeonato_id) {
        return $this->campeonatoModel->associarTimes($campeonato_id, [$time_id]);
    }

    public function removerTime($time_id, $campeonato_id) {
        return $this->campeonatoModel->removerTime($time_id, $campeonato_id);
    }

    public function listarTimes($campeonato_id) {
        return $this->campeonatoModel->listarTimesPorCampeonato($campeonato_id);
    }
    public function listarMeusCampeonatos($usuario_id) {
        return $this->campeonatoModel->listarPorUsuario($usuario_id);
    }
    
    
}
?>
