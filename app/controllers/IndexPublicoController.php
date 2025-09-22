<?php

class IndexPublicoController
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    } 

    // 🔥 Campeonatos em andamento
    public function listarCampeonatosPorEsporte($modalidade = null)
    {
        $sql = "
            SELECT id, nome, descricao, temporada, formato, modalidade
            FROM campeonatos
            WHERE status = 'ativo' AND status_finalizado = 0
        ";

        if ($modalidade) {
            $modalidade = $this->conn->real_escape_string($modalidade);
            $sql .= " AND modalidade = '$modalidade'";
        }

        $sql .= " ORDER BY nome";

        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // 🔥 Campeonatos finalizados
    public function listarCampeonatosFinalizados($modalidade = null)
    {
        $sql = "
            SELECT id, nome, descricao, temporada, formato, modalidade
            FROM campeonatos
            WHERE status = 'ativo' AND status_finalizado = 1
        ";

        if ($modalidade) {
            $modalidade = $this->conn->real_escape_string($modalidade);
            $sql .= " AND modalidade = '$modalidade'";
        }

        $sql .= " ORDER BY nome";

        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

   

    // 🔥 Artes do carrossel
    public function listarArtes()
    {
        $dir = __DIR__ . '/../../public/assets/img/artes';
        $arquivos = glob($dir . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE) ?: [];
        return array_map('basename', $arquivos);
    }
}
