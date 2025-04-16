<?php
// app/models/TimeCampeonato.php
class TimeCampeonato {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function adicionar($time_id, $campeonato_id) {
        $query = "INSERT INTO times_campeonatos (time_id, campeonato_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $time_id, $campeonato_id);
        return $stmt->execute();
    }

    public function remover($time_id, $campeonato_id) {
        $query = "DELETE FROM times_campeonatos WHERE time_id = ? AND campeonato_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $time_id, $campeonato_id);
        return $stmt->execute();
    }

    public function listarPorCampeonato($campeonato_id) {
        $query = "SELECT t.* FROM times t
                  INNER JOIN times_campeonatos tc ON t.id = tc.time_id
                  WHERE tc.campeonato_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $campeonato_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>