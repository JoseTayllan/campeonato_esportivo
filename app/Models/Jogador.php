<?php 
class  Player {
    private $conn;
    public function __construct($db) {
        $this->conn = $db;
    }
    public function criar($nome, $idade, $nacionalidade, $posicao, $time_id, $imagem = null) {
        $query = "INSERT INTO jogadores (nome, idade, nacionalidade, posicao, time_id, imagem) 
                  VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sissis", $nome, $idade, $nacionalidade, $posicao, $time_id, $imagem);
        return $stmt->execute();
    }

    // 🔽 NOVA FUNÇÃO: Buscar jogador pelo ID com escudo do time
    public function buscarPorId($id) {
        $query = "SELECT j.*, t.escudo 
                  FROM jogadores j 
                  LEFT JOIN times t ON j.time_id = t.id 
                  WHERE j.id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    
}
?>