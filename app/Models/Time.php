<?php 
class Time {
    private $conn;
    public function __construct($db) {
        $this->conn = $db;
    }
    public function criar($nome, $escudo, $cidade, $estadio) {
        $query = "INSERT INTO times (nome, escudo, cidade, estadio) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssss", $nome, $escudo, $cidade, $estadio);
        return $stmt->execute();
    }
}?>