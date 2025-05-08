<?php

class PlacarPublicoController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function listarPartidasEmAndamento() {
        $sql = "
            SELECT 
                p.*, 
                p.tempo_atual,
                tc.nome AS nome_casa, tc.escudo AS escudo_casa,
                tf.nome AS nome_fora, tf.escudo AS escudo_fora
            FROM partidas p
            JOIN times tc ON p.time_casa = tc.id
            JOIN times tf ON p.time_fora = tf.id
            WHERE p.status = 'em_andamento'
            ORDER BY p.data, p.horario
        ";

        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
