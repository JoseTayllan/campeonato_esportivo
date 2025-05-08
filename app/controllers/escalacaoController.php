<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../Models/Escalacao.php';

class EscalacaoController {
    private $model;

    public function __construct($conn) {
        $this->model = new Escalacao($conn);
    }

    public function salvarEscalacao($dados) {
        return $this->model->salvar($dados);
    }
    
    public function buscarEscalacaoDaPartida($partida_id) {
        return $this->model->buscarEscalacaoPorPartida($partida_id);
    }

    public function obterJogadoresTime($time_id) {
        return $this->model->buscarJogadoresDoTime($time_id);
    }

    public function buscarPartidasDoTime($time_id) {
        // Apenas se for usar isso em agenda_time.php
        $stmt = $this->model->getConn()->prepare("
            SELECT p.* FROM partidas p
            INNER JOIN jogadores j ON j.time_id = ? 
            WHERE p.id IN (
                SELECT partida_id FROM escalacoes WHERE jogador_id = j.id
            )
        ");
        $stmt->bindValue(1, $time_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->get_result()->fetchAll(PDO::FETCH_ASSOC);
    }

}
