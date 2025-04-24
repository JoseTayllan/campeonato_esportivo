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
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
}
