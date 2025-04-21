<?php

class Fase {
    private $conn;

    public function __construct($pdo) {
        $this->conn = $pdo;
    }

    public function listarFasesDoCampeonato($campeonato_id) {
        $sql = "SELECT * FROM fases_campeonato WHERE campeonato_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $campeonato_id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
    

    public function listarFasesGlobais() {
        $sql = "SELECT id, nome FROM fases_campeonato WHERE campeonato_id = 0 ORDER BY ordem";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
    public function criarFaseNoCampeonato($campeonato_id, $nome, $ordem) {
        $stmt = $this->conn->prepare("INSERT INTO fases_campeonato (campeonato_id, nome, ordem) VALUES (?, ?, ?)");
        $stmt->bind_param("isi", $campeonato_id, $nome, $ordem);
        return $stmt->execute();
    }
    
    
}
