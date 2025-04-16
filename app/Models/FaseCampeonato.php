<?php 
class FaseCampeonato {
    private $conn;
    public function __construct($db) {
        $this->conn = $db;
    }

    public function criar($campeonato_id, $nome, $ordem) {
        $query = "INSERT INTO fases_campeonato (campeonato_id, nome, ordem) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("isi", $campeonato_id, $nome, $ordem);
        return $stmt->execute();
    }

    public function listarPorCampeonato($campeonato_id) {
        $query = "SELECT * FROM fases_campeonato WHERE campeonato_id = ? ORDER BY ordem ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $campeonato_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>