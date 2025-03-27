<?php
class Estatistica {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function registrar($partida_id, $jogador_id, $gols = null, $assistencias = null, $passes_completos = null, 
                              $finalizacoes = null, $faltas_cometidas = null, $cartoes_amarelos = null, 
                              $cartoes_vermelhos = null, $minutos_jogados = null, $substituicoes = null) {
        $query = "INSERT INTO estatisticas_partida (partida_id, jogador_id, gols, assistencias, passes_completos, 
                                                     finalizacoes, faltas_cometidas, cartoes_amarelos, cartoes_vermelhos, 
                                                     minutos_jogados, substituicoes) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i" . str_repeat("i", 10), 
                          $partida_id, $jogador_id, 
                          $gols, $assistencias, $passes_completos, 
                          $finalizacoes, $faltas_cometidas, 
                          $cartoes_amarelos, $cartoes_vermelhos, 
                          $minutos_jogados, $substituicoes);
        
        return $stmt->execute();
    }

    public function listarTodos() {
        $query = "SELECT e.*, j.nome AS jogador_nome 
                  FROM estatisticas_partida e
                  JOIN jogadores j ON e.jogador_id = j.id";

        $result = $this->conn->query($query);

        $estatisticas = [];
        while ($row = $result->fetch_assoc()) {
            $estatisticas[] = $row;
        }

        return $estatisticas;
    }

    public function listarPorJogador($jogador_id) {
        $query = "SELECT e.*, j.nome AS jogador_nome 
                  FROM estatisticas_partida e
                  JOIN jogadores j ON e.jogador_id = j.id
                  WHERE e.jogador_id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $jogador_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $estatisticas = [];
        while ($row = $result->fetch_assoc()) {
            $estatisticas[] = $row;
        }

        return $estatisticas;
    }
}
?>