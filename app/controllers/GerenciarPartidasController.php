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
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function alterarStatus($partida_id, $status) {
        if ($status === 'em_andamento') {
            $stmt = $this->conn->prepare("UPDATE partidas SET status = ?, inicio_partida = NOW() WHERE id = ?");
        } else {
            $stmt = $this->conn->prepare("UPDATE partidas SET status = ? WHERE id = ?");
        }
        $stmt->bindValue(1, $status, PDO::PARAM_STR);
    $stmt->bindValue(2, $partida_id, PDO::PARAM_INT);
        $stmt->execute();
    }
    
}
