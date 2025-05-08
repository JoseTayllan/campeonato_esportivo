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
    public function listarArtes()
    {
        $dir     = __DIR__ . '/../../public/assets/img/artes';
        $arquivos = glob($dir . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE) ?: [];
        // retornar apenas o nome do arquivo para usar na view
        return array_map('basename', $arquivos);
    }
    
}
