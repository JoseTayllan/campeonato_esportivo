<?php
class EstatisticasTime {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obterResumoEstatistico($time_id) {
        $sql = "
            SELECT 
                COUNT(*) AS total_jogos,
                SUM(CASE WHEN (p.gols_time_casa > p.gols_time_visitante AND p.time_casa_id = :time_id)
                          OR (p.gols_time_visitante > p.gols_time_casa AND p.time_visitante_id = :time_id) THEN 1 ELSE 0 END) AS vitorias,
                SUM(CASE WHEN p.gols_time_casa = p.gols_time_visitante THEN 1 ELSE 0 END) AS empates,
                SUM(CASE WHEN (p.gols_time_casa < p.gols_time_visitante AND p.time_casa_id = :time_id)
                          OR (p.gols_time_visitante < p.gols_time_casa AND p.time_visitante_id = :time_id) THEN 1 ELSE 0 END) AS derrotas,
                SUM(CASE WHEN p.time_casa_id = :time_id THEN p.gols_time_casa
                         WHEN p.time_visitante_id = :time_id THEN p.gols_time_visitante ELSE 0 END) AS gols_marcados,
                SUM(CASE WHEN p.time_casa_id = :time_id THEN p.gols_time_visitante
                         WHEN p.time_visitante_id = :time_id THEN p.gols_time_casa ELSE 0 END) AS gols_sofridos
            FROM partidas p
            WHERE p.time_casa_id = :time_id OR p.time_visitante_id = :time_id
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':time_id', $time_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obterMelhorJogador($time_id) {
        $sql = "
            SELECT j.nome, ROUND(AVG(a.nota), 2) AS media
            FROM avaliacoes a
            INNER JOIN jogadores j ON a.jogador_id = j.id
            WHERE j.time_id = :time_id
            GROUP BY j.id
            ORDER BY media DESC
            LIMIT 1
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':time_id', $time_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
