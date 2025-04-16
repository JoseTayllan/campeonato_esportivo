<?php 
class Rodada {
    private $conn;
    public function __construct($db) {
        $this->conn = $db;
    }

    public function criar($fase_id, $numero, $tipo, $descricao) {
        $query = "INSERT INTO rodadas (fase_id, numero, tipo, descricao) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iiss", $fase_id, $numero, $tipo, $descricao);
        return $stmt->execute();
    }

    public function listarPorFase($fase_id) {
        $query = "SELECT * FROM rodadas WHERE fase_id = ? ORDER BY numero ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $fase_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>