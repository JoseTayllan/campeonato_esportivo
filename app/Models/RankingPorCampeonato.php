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
                   SUM(IFNULL(ep.cartoes_amarelos, 0)) AS amarelos,
                   SUM(IFNULL(ep.cartoes_vermelhos, 0)) AS vermelhos
            FROM estatisticas_partida ep
            JOIN jogadores j ON ep.jogador_id = j.id
            JOIN times t ON j.time_id = t.id
            JOIN partidas p ON ep.partida_id = p.id
            WHERE p.campeonato_id = ?
              AND p.status = 'finalizada'
              AND (IFNULL(ep.cartoes_amarelos, 0) > 0 OR IFNULL(ep.cartoes_vermelhos, 0) > 0)
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
            SELECT t.nome, COUNT(*) AS vitorias
            FROM partidas p
            JOIN times t ON (
                (p.time_casa = t.id AND p.placar_casa > p.placar_fora) OR
                (p.time_fora = t.id AND p.placar_fora > p.placar_casa)
            )
            WHERE p.campeonato_id = ?
              AND p.status = 'finalizada'
            GROUP BY t.id
            ORDER BY vitorias DESC
            LIMIT 10
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $campeonato_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    public function goleiros($campeonato_id) {
        $sql = "
            SELECT j.nome, t.nome AS time,
                   SUM(ep.defesas) AS total_defesas,
                   SUM(ep.gols_sofridos) AS total_gols_sofridos,
                   SUM(ep.penaltis_defendidos) AS total_penaltis_defendidos,
                   SUM(ep.clean_sheets) AS total_clean_sheets
            FROM estatisticas_partida ep
            JOIN jogadores j ON ep.jogador_id = j.id
            JOIN times t ON j.time_id = t.id
            JOIN partidas p ON ep.partida_id = p.id
            WHERE p.campeonato_id = ?
              AND p.status = 'finalizada'
              AND (ep.defesas > 0 OR ep.penaltis_defendidos > 0 OR ep.clean_sheets > 0)
            GROUP BY ep.jogador_id
            ORDER BY total_defesas DESC, total_clean_sheets DESC
            LIMIT 10
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $campeonato_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    
}
