<?php

class PartidaAoVivoController
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function buscarDadosDaPartida($partida_id)
    {
        $stmt = $this->conn->prepare("
            SELECT p.*, t1.nome AS nome_casa, t2.nome AS nome_fora
            FROM partidas p
            JOIN times t1 ON p.time_casa = t1.id
            JOIN times t2 ON p.time_fora = t2.id
            WHERE p.id = ?
        ");
        $stmt->bind_param("i", $partida_id);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_assoc();
    }

    public function listarEventos($partida_id)
    {
        $stmt = $this->conn->prepare("
            SELECT * FROM eventos_partida
            WHERE partida_id = ?
            ORDER BY criado_em ASC
        ");
        $stmt->bind_param("i", $partida_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function listarJogadoresDaPartida($time_casa, $time_fora)
    {
        $stmt = $this->conn->prepare("
            SELECT j.id, j.nome, j.posicao, t.nome AS time_nome, t.id AS time_id
            FROM jogadores j
            JOIN times t ON j.time_id = t.id
            WHERE t.id IN (?, ?)
        ");
        $stmt->bind_param("ii", $time_casa, $time_fora);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }


    private function registrarResultadoTime($time_id, $pontos, $gols_pro, $gols_contra)
    {
        $this->conn->query("
            UPDATE times_campeonatos
            SET pontos = pontos + $pontos,
                gols_pro = gols_pro + $gols_pro,
                gols_contra = gols_contra + $gols_contra,
                jogos = jogos + 1
            WHERE time_id = $time_id
        ");
    }

    public function finalizarPartida($partida_id)
    {
        $stmt = $this->conn->prepare("UPDATE partidas SET status = 'finalizada' WHERE id = ?");
        $stmt->bind_param("i", $partida_id);
        $stmt->execute();
        $stmt->close();

        $eventos = $this->conn->query("
            SELECT jogador_id, tipo_evento, COUNT(*) as total
            FROM eventos_partida
            WHERE partida_id = $partida_id
            AND jogador_id IS NOT NULL
            GROUP BY jogador_id, tipo_evento
        ");

        while ($e = $eventos->fetch_assoc()) {
            $jogador_id = $e['jogador_id'];
            $tipo = $e['tipo_evento'];
            $qtd = (int)$e['total'];

            $campo = match ($tipo) {
                'gol' => 'gols',
                'cartao_amarelo' => 'cartoes_amarelos',
                'cartao_vermelho' => 'cartoes_vermelhos',
                'finalizacao' => 'finalizacoes',
                'defesa' => 'defesas',
                'penalti_defendido' => 'penaltis_defendidos',
                default => null
            };

            if ($campo) {
                $this->conn->query("
                    INSERT INTO estatisticas_partida (partida_id, jogador_id, $campo)
                    VALUES ($partida_id, $jogador_id, $qtd)
                    ON DUPLICATE KEY UPDATE $campo = $campo + $qtd
                ");
            }
        }

        $res = $this->conn->query("SELECT * FROM partidas WHERE id = $partida_id")->fetch_assoc();
        $t1 = $res['time_casa'];
        $t2 = $res['time_fora'];
        $g1 = (int)$res['placar_casa'];
        $g2 = (int)$res['placar_fora'];
        $campeonato_id = $res['campeonato_id'];

        if ($g1 > $g2) {
            $this->atualizarClassificacao($t1, $campeonato_id, 3, 1, 0, 0, $g1, $g2);
            $this->atualizarClassificacao($t2, $campeonato_id, 0, 0, 0, 1, $g2, $g1);
        } elseif ($g2 > $g1) {
            $this->atualizarClassificacao($t2, $campeonato_id, 3, 1, 0, 0, $g2, $g1);
            $this->atualizarClassificacao($t1, $campeonato_id, 0, 0, 0, 1, $g1, $g2);
        } else {
            $this->atualizarClassificacao($t1, $campeonato_id, 1, 0, 1, 0, $g1, $g2);
            $this->atualizarClassificacao($t2, $campeonato_id, 1, 0, 1, 0, $g2, $g1);
        }

        $goleiros = [];

        // Goleiro do time da casa
        $stmt1 = $this->conn->prepare("SELECT id FROM jogadores WHERE time_id = ? AND posicao = 'Goleiro' LIMIT 1");
        $stmt1->bind_param("i", $t1);
        $stmt1->execute();
        $res1 = $stmt1->get_result()->fetch_assoc();
        if ($res1) $goleiros[] = ['id' => $res1['id'], 'gols_sofridos' => $g2];
        $stmt1->close();

        // Goleiro do time visitante
        $stmt2 = $this->conn->prepare("SELECT id FROM jogadores WHERE time_id = ? AND posicao = 'Goleiro' LIMIT 1");
        $stmt2->bind_param("i", $t2);
        $stmt2->execute();
        $res2 = $stmt2->get_result()->fetch_assoc();
        if ($res2) $goleiros[] = ['id' => $res2['id'], 'gols_sofridos' => $g1];
        $stmt2->close();


 

        foreach ($goleiros as $g) {
            $clean_sheet = ($g['gols_sofridos'] == 0) ? 1 : 0;
            $this->conn->query("
                INSERT INTO estatisticas_partida (partida_id, jogador_id, gols_sofridos, clean_sheets)
                VALUES ($partida_id, {$g['id']}, {$g['gols_sofridos']}, $clean_sheet)
                ON DUPLICATE KEY UPDATE gols_sofridos = {$g['gols_sofridos']}, clean_sheets = $clean_sheet
            ");
        }
    }


    private function atualizarClassificacao($time_id, $campeonato_id, $pontos, $vitorias, $empates, $derrotas, $gols_pro, $gols_contra)
    {
        $this->conn->query("
            UPDATE times_campeonatos
            SET pontos = pontos + $pontos,
                vitorias = vitorias + $vitorias,
                empates = empates + $empates,
                derrotas = derrotas + $derrotas,
                jogos = jogos + 1,
                gols_pro = gols_pro + $gols_pro,
                gols_contra = gols_contra + $gols_contra
            WHERE time_id = $time_id AND campeonato_id = $campeonato_id
        ");
    }
}
