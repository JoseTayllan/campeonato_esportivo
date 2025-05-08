<?php 
class FaseCampeonato {
    private $conn;
    public function __construct($db) {
        $this->conn = $db;
    }

    public function criar($campeonato_id, $nome, $ordem) {
        $query = "INSERT INTO fases_campeonato (campeonato_id, nome, ordem) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $campeonato_id, PDO::PARAM_INT);
    $stmt->bindValue(2, $nome, PDO::PARAM_STR);
    $stmt->bindValue(3, $ordem, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function listarPorCampeonato($campeonato_id) {
        $query = "SELECT * FROM fases_campeonato WHERE campeonato_id = ? ORDER BY ordem ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $campeonato_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->get_result()->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>