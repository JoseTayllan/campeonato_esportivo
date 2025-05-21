<?php

class PlacarPublicoController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function listarPartidasEmAndamento($modalidade = null) {
        $sql = "
        SELECT 
            p.*, 
            p.link_transmissao,
            p.tempo_atual,
            tc.nome AS nome_casa, tc.escudo AS escudo_casa,
            tf.nome AS nome_fora, tf.escudo AS escudo_fora,
            c.modalidade
        FROM partidas p
        JOIN times tc ON p.time_casa = tc.id
        JOIN times tf ON p.time_fora = tf.id
        JOIN campeonatos c ON p.campeonato_id = c.id
        WHERE p.status = 'em_andamento'
        ";
        
        if ($modalidade) {
            $modalidade = $this->conn->real_escape_string($modalidade);
            $sql .= " AND c.modalidade = '$modalidade'";
        }
        
        $sql .= " ORDER BY p.data, p.horario";

        return $this->conn->query($sql)->fetch_all(MYSQLI_ASSOC);
    }
}
