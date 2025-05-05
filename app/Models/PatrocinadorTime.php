<?php
class PatrocinadorTime {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function vincular($patrocinador_id, $time_id, $data_inicio, $data_fim) {
        $sql = "INSERT INTO patrocinador_time (patrocinador_id, time_id, data_inicio, data_fim) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iiss", $patrocinador_id, $time_id, $data_inicio, $data_fim);
        return $stmt->execute();
    }

    public function listarPorTime($time_id) {
        $sql = "SELECT p.nome_empresa, pt.data_inicio, pt.data_fim 
                FROM patrocinadores p
                JOIN patrocinador_time pt ON p.id = pt.patrocinador_id
                WHERE pt.time_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $time_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function desvincular($patrocinador_id, $time_id) {
        $sql = "DELETE FROM patrocinador_time WHERE patrocinador_id = ? AND time_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $patrocinador_id, $time_id);
        return $stmt->execute();
    }
}
?>
