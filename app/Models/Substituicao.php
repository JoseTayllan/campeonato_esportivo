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
        $stmt->bindValue(1, $partida_id, PDO::PARAM_INT);
    $stmt->bindValue(2, $jogador_saiu, PDO::PARAM_INT);
    $stmt->bindValue(3, $jogador_entrou, PDO::PARAM_INT);
    $stmt->bindValue(4, $minuto_substituicao, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
