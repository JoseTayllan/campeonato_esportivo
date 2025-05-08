<?php

class FaseRodadaModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function listarCampeonatos()
    {
        $sql = "SELECT id, nome FROM campeonatos ORDER BY nome ASC";
        $result = $this->conn->query($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarFasesERodadas($campeonato_id) {
        $fases = [];
    
        $query = "SELECT id, nome, ordem FROM fases_campeonato WHERE campeonato_id = ? ORDER BY ordem ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $campeonato_id, PDO::PARAM_INT);
        $stmt->execute();
        $resultFases = $stmt->get_result();
    
        while ($fase = $resultFases->fetch(PDO::FETCH_ASSOC)) {
            $fase['rodadas'] = [];
    
            $queryRodadas = "SELECT id, numero, tipo, descricao FROM rodadas WHERE fase_id = ? ORDER BY numero ASC";
            $stmtRodada = $this->conn->prepare($queryRodadas);
            $stmtRodada->bindValue(1, $fase['id'], PDO::PARAM_INT);
            $stmtRodada->execute();
            $resultRodadas = $stmtRodada->get_result();
    
            while ($rodada = $resultRodadas->fetch(PDO::FETCH_ASSOC)) {
                $rodada['partidas'] = [];
    
                $queryPartidas = "
                    SELECT 
                        t1.nome AS time_casa,
                        t1.escudo AS escudo_time_casa,
                        t2.nome AS time_fora,
                        t2.escudo AS escudo_time_fora,
                        p.data,
                        p.horario,
                        p.local,
                        p.placar_casa,
                        p.placar_fora,
                        p.status
                    FROM partidas p
                    JOIN times t1 ON t1.id = p.time_casa
                    JOIN times t2 ON t2.id = p.time_fora
                    WHERE p.rodada_id = ?
                    ORDER BY p.data, p.horario
                ";
                $stmtPartida = $this->conn->prepare($queryPartidas);
                $stmtPartida->bindValue(1, $rodada['id'], PDO::PARAM_INT);
                $stmtPartida->execute();
                $resultPartidas = $stmtPartida->get_result();
    
                while ($partida = $resultPartidas->fetch(PDO::FETCH_ASSOC)) {
                    $rodada['partidas'][] = $partida;
                }
    
                // Só adiciona a rodada se tiver partidas
                if (count($rodada['partidas']) > 0) {
                    $fase['rodadas'][] = $rodada;
                }
            }
    
            // Só adiciona a fase se tiver rodadas
            if (count($fase['rodadas']) > 0) {
                $fases[] = $fase;
            }
        }
    
        return $fases;
    }
    


    public function classificacaoTimes($campeonato_id)
    {
        $sql = "SELECT t.id, t.nome
                FROM times t
                JOIN times_campeonatos tc ON tc.time_id = t.id
                WHERE tc.campeonato_id = ?
                ORDER BY t.nome ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $campeonato_id, PDO::PARAM_INT);
        $stmt->execute();
        $times = $stmt->get_result()->fetchAll(PDO::FETCH_ASSOC);

        foreach ($times as &$time) {
            $sqlPartidas = "SELECT * FROM partidas 
                            WHERE campeonato_id = ? 
                            AND status = 'finalizada'
                            AND (time_casa = ? OR time_fora = ?)";
            $stmt2 = $this->conn->prepare($sqlPartidas);
            $stmt2->bindValue(1, $campeonato_id, PDO::PARAM_INT);
    $stmt->bindValue(2, $time['id'], PDO::PARAM_INT);
    $stmt->bindValue(3, $time['id'], PDO::PARAM_INT);
            $stmt2->execute();
            $partidas = $stmt2->get_result()->fetchAll(PDO::FETCH_ASSOC);

            $time['jogos'] = $time['vitorias'] = $time['empates'] = $time['derrotas'] = $time['gols_pro'] = $time['gols_contra'] = 0;

            foreach ($partidas as $p) {
                $is_casa = ($p['time_casa'] == $time['id']);
                $gp = $is_casa ? $p['placar_casa'] : $p['placar_fora'];
                $gc = $is_casa ? $p['placar_fora'] : $p['placar_casa'];

                $time['gols_pro'] += $gp;
                $time['gols_contra'] += $gc;

                if ($gp > $gc) $time['vitorias']++;
                elseif ($gp == $gc) $time['empates']++;
                else $time['derrotas']++;

                $time['jogos']++;
            }

            $time['saldo'] = $time['gols_pro'] - $time['gols_contra'];
            $time['pontos'] = ($time['vitorias'] * 3) + ($time['empates']);
        }

        return $times;
    }
}
