<?php

class RankingPorCampeonato {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function artilheiros($campeonato_id) {
        $sql = "
            SELECT j.nome, t.nome AS time, COUNT(*) AS gols
            FROM estatisticas_partida ep
            JOIN jogadores j ON ep.jogador_id = j.id
            JOIN times t ON j.time_id = t.id
            JOIN partidas p ON ep.partida_id = p.id
            WHERE ep.gols > 0 AND p.campeonato_id = ?
            GROUP BY ep.jogador_id
            ORDER BY gols DESC
            LIMIT 10
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $campeonato_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function cartoes($campeonato_id) {
        $sql = "
            SELECT j.nome, t.nome AS time,
                   SUM(ep.cartoes_amarelos) AS amarelos,
                   SUM(ep.cartoes_vermelhos) AS vermelhos
            FROM estatisticas_partida ep
            JOIN jogadores j ON ep.jogador_id = j.id
            JOIN times t ON j.time_id = t.id
            JOIN partidas p ON ep.partida_id = p.id
            WHERE p.campeonato_id = ?
            GROUP BY ep.jogador_id
            ORDER BY amarelos DESC, vermelhos DESC
            LIMIT 10
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $campeonato_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function timesComMaisVitorias($campeonato_id) {
        $sql = "
            SELECT t.nome, tc.vitorias
            FROM times_campeonatos tc
            JOIN times t ON tc.time_id = t.id
            WHERE tc.campeonato_id = ?
            ORDER BY tc.vitorias DESC
            LIMIT 10
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $campeonato_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
