<?php
// app/models/Campeonato.php

class Campeonato {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Cria um novo campeonato
    public function criar($nome, $descricao, $temporada, $formato) {
        $query = "INSERT INTO campeonatos (nome, descricao, temporada, formato) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssis", $nome, $descricao, $temporada, $formato);
        if ($stmt->execute()) {
            return $this->conn->insert_id; // Retorna o ID do campeonato criado
        }
        return false;
    }

    // Associa um ou mais times a um campeonato
    public function associarTimes($campeonato_id, $times = []) {
        $query = "INSERT INTO times_campeonatos (time_id, campeonato_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        foreach ($times as $time_id) {
            $stmt->bind_param("ii", $time_id, $campeonato_id);
            $stmt->execute();
        }
    }

    // Remove um time de um campeonato
    public function removerTime($time_id, $campeonato_id) {
        $query = "DELETE FROM times_campeonatos WHERE time_id = ? AND campeonato_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $time_id, $campeonato_id);
        return $stmt->execute();
    }

    // Lista times associados a um campeonato
    public function listarTimesPorCampeonato($campeonato_id) {
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
