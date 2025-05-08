<?php

class IndexPublicoController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function listarCampeonatosPorEsporte() {
        $sql = "
            SELECT id, nome, descricao, temporada, formato
            FROM campeonatos
            WHERE status = 'ativo'
            ORDER BY nome
        ";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
