<?php 
// app/controllers/CampeonatoPublicoController.php

class CampeonatoPublicoController
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function detalhesDoCampeonato($id)
    {
        // Info do campeonato
        $stmt = $this->conn->prepare("SELECT * FROM campeonatos WHERE id = ?");
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        $campeonato = $stmt->get_result()->fetch(PDO::FETCH_ASSOC);

        if (!$campeonato) return null;

        // Times participantes (agora com o campo codigo_publico incluso)
        $stmt = $this->conn->prepare("
            SELECT t.id, t.nome, t.escudo, t.codigo_publico
            FROM times t
            JOIN times_campeonatos tc ON tc.time_id = t.id
            WHERE tc.campeonato_id = ?
        ");
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        $times = $stmt->get_result()->fetchAll(PDO::FETCH_ASSOC);

        // Rodadas e partidas
        $stmt = $this->conn->prepare("SELECT r.id AS rodada_id, r.numero, r.tipo, r.descricao,
        p.id AS partida_id, p.data, p.horario, p.local,
        tc.nome AS time_casa, tc.escudo AS escudo_time_casa,
        tf.nome AS time_fora, tf.escudo AS escudo_time_fora,
        p.placar_casa, p.placar_fora
        FROM rodadas r
        LEFT JOIN partidas p ON p.rodada_id = r.id
        LEFT JOIN times tc ON p.time_casa = tc.id
        LEFT JOIN times tf ON p.time_fora = tf.id
        WHERE r.fase_id IN (
            SELECT id FROM fases_campeonato WHERE campeonato_id = ?
        )
        ORDER BY r.numero ASC, p.data ASC
    ");
    
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        $partidas = $stmt->get_result()->fetchAll(PDO::FETCH_ASSOC);

        return [
            'campeonato' => $campeonato,
            'times' => $times,
            'partidas' => $partidas
        ];
    }
}
?>