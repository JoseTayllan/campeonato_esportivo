<?php
class Substituicao {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function registrarSubstituicao($partida_id, $jogador_saiu = null, $jogador_entrou = null, $minuto_substituicao = null) {
        // Se nenhum jogador saiu ou entrou, não há substituição
        if ($jogador_saiu === null || $jogador_entrou === null) {
            return true; // Não faz nada, mas também não dá erro
        }

        // Inserir substituição na tabela
        $query = "INSERT INTO substituicoes (partida_id, jogador_saiu, jogador_entrou, minuto_substituicao) 
                  VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iiii", $partida_id, $jogador_saiu, $jogador_entrou, $minuto_substituicao);
        return $stmt->execute();
    }
}
?>
