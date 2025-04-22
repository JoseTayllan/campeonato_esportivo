<?php
require_once __DIR__ . '/../../config/database.php';

class EstatisticasTimeController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function calcularEstatisticas($time_id) {
        $dados = [
            'jogos' => 0,
            'vitorias' => 0,
            'empates' => 0,
            'derrotas' => 0,
            'gols_marcados' => 0,
            'gols_sofridos' => 0,
        ];
    
        $sql = "SELECT partida_id, gols_time_casa as gols FROM estatisticas_partida WHERE time_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $time_id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        while ($linha = $result->fetch_assoc()) {
            $partida_id = $linha['partida_id'];
            $gols_time = (int)$linha['gols'];
    
            // Buscar adversário da mesma partida
            $sql_adv = "SELECT gols_time_casa as gols FROM estatisticas_partida WHERE partida_id = ? AND time_id != ?";
            $stmt_adv = $this->conn->prepare($sql_adv);
            $stmt_adv->bind_param("ii", $partida_id, $time_id);
            $stmt_adv->execute();
            $res_adv = $stmt_adv->get_result();
            $adv = $res_adv->fetch_assoc();
    
            if (!$adv) continue;
    
            $gols_adv = (int)$adv['gols'];
    
            $dados['jogos']++;
            $dados['gols_marcados'] += $gols_time;
            $dados['gols_sofridos'] += $gols_adv;
    
            if ($gols_time > $gols_adv) $dados['vitorias']++;
            elseif ($gols_time < $gols_adv) $dados['derrotas']++;
            else $dados['empates']++;
        }
    
        return $dados;
    }
    

    public function melhorJogador($time_id) {
        $sql = "SELECT j.nome, AVG(a.nota) as media
                FROM avaliacoes a
                JOIN jogadores j ON a.jogador_id = j.id
                WHERE j.time_id = ?
                GROUP BY a.jogador_id
                ORDER BY media DESC
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $time_id);
        $stmt->execute();
        $res = $stmt->get_result();

        return $res->fetch_assoc();
    }
}
