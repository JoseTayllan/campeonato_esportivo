<?php 
class Rodada {
    private $conn;
    public function __construct($db) {
        $this->conn = $db;
    }

    public function criar($fase_id, $numero, $tipo, $descricao) {
        $query = "INSERT INTO rodadas (fase_id, numero, tipo, descricao) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $fase_id, PDO::PARAM_INT);
    $stmt->bindValue(2, $numero, PDO::PARAM_INT);
    $stmt->bindValue(3, $tipo, PDO::PARAM_STR);
    $stmt->bindValue(4, $descricao, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function listarPorFase($fase_id) {
        $query = "SELECT * FROM rodadas WHERE fase_id = ? ORDER BY numero ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $fase_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->get_result()->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>