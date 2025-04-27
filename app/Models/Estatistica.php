<?php
class Estatistica {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function registrar($partida_id, $jogador_id, $gols = null, $assistencias = null, $passes_completos = null, 
                              $finalizacoes = null, $faltas_cometidas = null, $cartoes_amarelos = null, 
                              $cartoes_vermelhos = null, $minutos_jogados = null, $substituicoes = null,
                              $defesas = null, $gols_sofridos = null, $penaltis_defendidos = null, $clean_sheets = null) {
        $query = "INSERT INTO estatisticas_partida (
                      partida_id, jogador_id, gols, assistencias, passes_completos, 
                      finalizacoes, faltas_cometidas, cartoes_amarelos, cartoes_vermelhos, 
                      minutos_jogados, substituicoes, defesas, gols_sofridos, penaltis_defendidos, clean_sheets
                  ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i" . str_repeat("i", 14),
                          $partida_id, $jogador_id, 
                          $gols, $assistencias, $passes_completos, 
                          $finalizacoes, $faltas_cometidas, 
                          $cartoes_amarelos, $cartoes_vermelhos, 
                          $minutos_jogados, $substituicoes,
                          $defesas, $gols_sofridos,
                          $penaltis_defendidos, $clean_sheets);
        
        return $stmt->execute();
    }

    public function listarPorJogador($jogador_id) {
        $query = "SELECT 
                    SUM(e.gols) AS gols,
                    SUM(e.assistencias) AS assistencias,
                    SUM(e.passes_completos) AS passes_completos,
                    SUM(e.finalizacoes) AS finalizacoes,
                    SUM(e.faltas_cometidas) AS faltas_cometidas,
                    SUM(e.cartoes_amarelos) AS cartoes_amarelos,
                    SUM(e.cartoes_vermelhos) AS cartoes_vermelhos,
                    SUM(e.minutos_jogados) AS minutos_jogados,
                    SUM(e.defesas) AS defesas,
                    SUM(e.gols_sofridos) AS gols_sofridos,
                    SUM(e.penaltis_defendidos) AS penaltis_defendidos,
                    SUM(e.clean_sheets) AS clean_sheets
                  FROM estatisticas_partida e
                  WHERE e.jogador_id = ?";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $jogador_id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        return [$result->fetch_assoc()];
    }

    public function historicoPartidas($jogador_id) {
        $query = "SELECT 
                    p.data,
                    p.placar_casa,
                    p.placar_fora,
                    tc.nome AS time_casa,
                    tf.nome AS time_fora,
                    j.time_id AS time_jogador,
                    CASE 
                        WHEN j.time_id = p.time_casa THEN tf.nome
                        ELSE tc.nome
                    END AS adversario,
                    e.gols, e.assistencias, e.passes_completos, e.finalizacoes,
                    e.faltas_cometidas, e.cartoes_amarelos, e.cartoes_vermelhos,
                    e.defesas, e.gols_sofridos, e.penaltis_defendidos, e.clean_sheets,
                    ((e.gols * 1.5) + (e.assistencias * 1.0) + (e.passes_completos * 0.05) +
                     (e.finalizacoes * 0.1) - (e.faltas_cometidas * 0.1) - 
                     (e.cartoes_amarelos * 0.5) - (e.cartoes_vermelhos * 1.0)) AS nota
                FROM estatisticas_partida e
                JOIN partidas p ON e.partida_id = p.id
                JOIN jogadores j ON e.jogador_id = j.id
                JOIN times tc ON p.time_casa = tc.id
                JOIN times tf ON p.time_fora = tf.id
                WHERE e.jogador_id = ?
                ORDER BY p.data DESC";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $jogador_id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $partidas = [];
        while ($row = $result->fetch_assoc()) {
            if ($row['time_jogador'] == $row['time_casa']) {
                $row['resultado'] = "{$row['time_casa']} {$row['placar_casa']} x {$row['placar_fora']} {$row['time_fora']}";
            } else {
                $row['resultado'] = "{$row['time_fora']} {$row['placar_fora']} x {$row['placar_casa']} {$row['time_casa']}";
            }
            $partidas[] = $row;
        }
    
        return $partidas;
    }

    public function calcularNotaMediaPorEstatistica($jogador_id) {
        $sql = "SELECT gols, assistencias, passes_completos, finalizacoes, 
                       faltas_cometidas, cartoes_amarelos, cartoes_vermelhos
                FROM estatisticas_partida 
                WHERE jogador_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $jogador_id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $total = 0;
        $quantidade = 0;
    
        while ($row = $result->fetch_assoc()) {
            $nota = 
                ($row['gols'] * 1.5) +
                ($row['assistencias'] * 1.0) +
                ($row['passes_completos'] * 0.05) +
                ($row['finalizacoes'] * 0.1) -
                ($row['faltas_cometidas'] * 0.1) -
                ($row['cartoes_amarelos'] * 0.5) -
                ($row['cartoes_vermelhos'] * 1.0);
            $total += $nota;
            $quantidade++;
        }
    
        return $quantidade > 0 ? round($total / $quantidade, 1) : null;
    }
}
?>