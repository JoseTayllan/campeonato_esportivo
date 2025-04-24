<?php

class Ranking {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function artilheiros() {
        $sql = "
            SELECT j.nome, t.nome AS time, COUNT(*) AS gols
            FROM estatisticas_partida ep
            JOIN jogadores j ON ep.jogador_id = j.id
            JOIN times t ON j.time_id = t.id
            WHERE ep.gols > 0
            GROUP BY ep.jogador_id
            ORDER BY gols DESC
            LIMIT 10
        ";
        return $this->conn->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function cartoes() {
        $sql = "
            SELECT j.nome, t.nome AS time,
                   SUM(ep.cartoes_amarelos) AS amarelos,
                   SUM(ep.cartoes_vermelhos) AS vermelhos
            FROM estatisticas_partida ep
            JOIN jogadores j ON ep.jogador_id = j.id
            JOIN times t ON j.time_id = t.id
            GROUP BY ep.jogador_id
            ORDER BY amarelos DESC, vermelhos DESC
            LIMIT 10
        ";
        return $this->conn->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function timesComMaisVitorias() {
        $sql = "
            SELECT t.nome, tc.vitorias
            FROM times_campeonatos tc
            JOIN times t ON tc.time_id = t.id
            ORDER BY tc.vitorias DESC
            LIMIT 10
        ";
        return $this->conn->query($sql)->fetch_all(MYSQLI_ASSOC);
    }
}
