<?php 
class Championship {
    private $conn;
    public function __construct($db) {
        $this->conn = $db;
    }
    public function criar($nome, $descricao, $temporada, $formato) {
        $query = "INSERT INTO campeonatos (nome, descricao, temporada, formato) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssis", $nome, $descricao, $temporada, $formato);
        return $stmt->execute();
    }
}
?>