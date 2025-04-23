<?php

class GerenciarPartidasController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function listarPartidas() {
        $query = "
            SELECT p.*, 
                   t1.nome AS nome_casa, 
                   t2.nome AS nome_fora 
            FROM partidas p
            JOIN times t1 ON p.time_casa = t1.id
            JOIN times t2 ON p.time_fora = t2.id
            ORDER BY p.data DESC, p.horario DESC
        ";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function alterarStatus($partida_id, $status) {
        $stmt = $this->conn->prepare("UPDATE partidas SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $partida_id);
        $stmt->execute();
    }
}
