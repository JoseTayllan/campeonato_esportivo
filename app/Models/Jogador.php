<?php 
class  Player {
    private $conn;
    public function __construct($db) {
        $this->conn = $db;
    }
    public function criar($nome, $idade, $nacionalidade, $posicao, $time_id) {
        $query = "INSERT INTO jogadores (nome, idade, nacionalidade, posicao, time_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sissi", $nome, $idade, $nacionalidade, $posicao, $time_id);
        return $stmt->execute();
    }
}
?>