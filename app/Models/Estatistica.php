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
}
?>