<?php
require_once __DIR__ . '/../../config/database.php';
class Estatistica
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function registrar(
        $partida_id,
        $jogador_id,
        $gols = null,
        $assistencias = null,
        $passes_completos = null,
        $finalizacoes = null,
        $faltas_cometidas = null,
        $cartoes_amarelos = null,
        $cartoes_vermelhos = null,
        $minutos_jogados = null,
        $substituicoes = null,
        $defesas = null,
        $gols_sofridos = null,
        $penaltis_defendidos = null,
        $clean_sheets = null
    ) {
        $query = "INSERT INTO estatisticas_partida (
                      partida_id, jogador_id, gols, assistencias, passes_completos, 
                      finalizacoes, faltas_cometidas, cartoes_amarelos, cartoes_vermelhos, 
                      minutos_jogados, substituicoes, defesas, gols_sofridos, penaltis_defendidos, clean_sheets
                  ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param(
            "i" . str_repeat("i", 14),
            $partida_id,
            $jogador_id,
            $gols,
            $assistencias,
            $passes_completos,
            $finalizacoes,
            $faltas_cometidas,
            $cartoes_amarelos,
            $cartoes_vermelhos,
            $minutos_jogados,
            $substituicoes,
            $defesas,
            $gols_sofridos,
            $penaltis_defendidos,
            $clean_sheets
        );

        return $stmt->execute();
    }

    public function listarPorJogador($jogador_id)
    {
        $query = "SELECT 
                    SUM(e.gols) AS gols,
                    SUM(e.assistencias) AS assistencias,
                    SUM(e.passes_completos) AS passes_completos,
                    SUM(e.finalizacoes) AS finalizacoes,
                    SUM(e.faltas_cometidas) AS faltas_cometidas,
                    SUM(e.cartoes_amarelos) AS cartoes_amarelos,
                    SUM(e.cartoes_vermelhos) AS cartoes_vermelhos,
                    SUM(e.minutos_jogados) AS minutos_jogados,
                    SUM(e.defesas) AS defesas,
                    SUM(e.gols_sofridos) AS gols_sofridos,
                    SUM(e.penaltis_defendidos) AS penaltis_defendidos,
                    SUM(e.clean_sheets) AS clean_sheets
                  FROM estatisticas_partida e
                  WHERE e.jogador_id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $jogador_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return [$result->fetch_assoc()];
    }

    public function historicoPartidas($jogador_id)
    {
        $fatorMaximo = 15; // 🔥 Definido aqui no topo da função

        $query = "SELECT 
                p.data,
                p.placar_casa,
                p.placar_fora,
                tc.nome AS time_casa,
                tf.nome AS time_fora,
                j.time_id AS time_jogador,
                CASE 
                    WHEN j.time_id = p.time_casa THEN tf.nome
                    ELSE tc.nome
                END AS adversario,
                SUM(e.gols) AS gols,
                SUM(e.assistencias) AS assistencias,
                SUM(e.passes_completos) AS passes_completos,
                SUM(e.finalizacoes) AS finalizacoes,
                SUM(e.faltas_cometidas) AS faltas_cometidas,
                SUM(e.cartoes_amarelos) AS cartoes_amarelos,
                SUM(e.cartoes_vermelhos) AS cartoes_vermelhos,
                SUM(e.defesas) AS defesas,
                SUM(e.gols_sofridos) AS gols_sofridos,
                SUM(e.penaltis_defendidos) AS penaltis_defendidos,
                SUM(e.clean_sheets) AS clean_sheets
            FROM estatisticas_partida e
            JOIN partidas p ON e.partida_id = p.id
            JOIN jogadores j ON e.jogador_id = j.id
            JOIN times tc ON p.time_casa = tc.id
            JOIN times tf ON p.time_fora = tf.id
            WHERE e.jogador_id = ?
            GROUP BY p.id
            ORDER BY p.data DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $jogador_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $partidas = [];
        while ($row = $result->fetch_assoc()) {
            if ($row['time_jogador'] == $row['time_casa']) {
                $row['resultado'] = "{$row['time_casa']} {$row['placar_casa']} x {$row['placar_fora']} {$row['time_fora']}";
            } else {
                $row['resultado'] = "{$row['time_fora']} {$row['placar_fora']} x {$row['placar_casa']} {$row['time_casa']}";
            }

            $notaBruta =
                ($row['gols'] * 6) +
                ($row['assistencias'] * 4) +
                ($row['finalizacoes'] * 2.5) +
                ($row['passes_completos'] * 0.2) -
                ($row['faltas_cometidas'] * 0.2) -
                ($row['cartoes_amarelos'] * 1.5) -
                ($row['cartoes_vermelhos'] * 3);

            $nota = min(10, ($notaBruta / $fatorMaximo) * 10);
            $nota = max(0, round($nota, 1)); // Nunca negativa

            $row['nota'] = $nota;
            $partidas[] = $row;
        }


        return $partidas;
    }

    public function calcularNotaMediaPorEstatistica($jogador_id)
    {
        // Busca todas as partidas do jogador
        $query = "SELECT 
                p.id AS partida_id,
                SUM(e.gols) AS gols,
                SUM(e.assistencias) AS assistencias,
                SUM(e.passes_completos) AS passes_completos,
                SUM(e.finalizacoes) AS finalizacoes,
                SUM(e.faltas_cometidas) AS faltas_cometidas,
                SUM(e.cartoes_amarelos) AS cartoes_amarelos,
                SUM(e.cartoes_vermelhos) AS cartoes_vermelhos
            FROM estatisticas_partida e
            JOIN partidas p ON e.partida_id = p.id
            WHERE e.jogador_id = ?
            GROUP BY p.id";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $jogador_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $totalNota = 0;
        $totalPartidas = 0;

        $fatorMaximo = 15;

        while ($row = $result->fetch_assoc()) {
            // Calcula nota da partida
            $notaBruta =
                ($row['gols'] * 6) +
                ($row['assistencias'] * 4) +
                ($row['finalizacoes'] * 2.5) +
                ($row['passes_completos'] * 0.2) -
                ($row['faltas_cometidas'] * 0.2) -
                ($row['cartoes_amarelos'] * 1.5) -
                ($row['cartoes_vermelhos'] * 3);

            $nota = min(10, ($notaBruta / $fatorMaximo) * 10);
            $nota = max(0, round($nota, 1)); // Nunca negativa

            $totalNota += $nota;
            $totalPartidas++;
        }

        if ($totalPartidas === 0) {
            return null;
        }

        $media = $totalNota / $totalPartidas;
        return round($media, 1);
    }




    public function listarTodos()
    {
        $query = "SELECT 
                    e.partida_id,
                    j.nome AS jogador_nome,
                    e.gols,
                    e.assistencias,
                    e.passes_completos,
                    e.finalizacoes,
                    e.faltas_cometidas,
                    e.cartoes_amarelos,
                    e.cartoes_vermelhos,
                    e.minutos_jogados,
                    e.substituicoes
                  FROM estatisticas_partida e
                  JOIN jogadores j ON e.jogador_id = j.id";

        $result = $this->conn->query($query);

        $dados = [];
        while ($row = $result->fetch_assoc()) {
            $dados[] = $row;
        }

        return $dados;
    }
public function listarArtilheirosPorCampeonato($campeonato_id, $limite = 5)
{
    $sql = "
        SELECT 
            j.id AS jogador_id,
            j.nome,
            t.id AS time_id,
            t.nome AS time,
            SUM(ep.gols) AS gols
        FROM estatisticas_partida ep
        JOIN partidas p ON ep.partida_id = p.id
        JOIN jogadores j ON j.id = ep.jogador_id
        JOIN jogador_time jt ON jt.jogador_id = j.id AND jt.status = 'ativo'
        JOIN times t ON t.id = jt.time_id
        WHERE p.campeonato_id = ?
        GROUP BY j.id, j.nome, t.id, t.nome
        ORDER BY gols DESC
        LIMIT ?
    ";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("ii", $campeonato_id, $limite);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}



    public function estatisticasTimePorCampeonato($campeonato_id, $time_id)
    {
        $query = "SELECT 
                SUM(CASE WHEN p.time_casa = ? THEN p.placar_casa ELSE p.placar_fora END) AS gols_pro,
                SUM(CASE WHEN p.time_casa = ? THEN p.placar_fora ELSE p.placar_casa END) AS gols_contra,
                SUM(CASE 
                    WHEN (p.time_casa = ? AND p.placar_casa > p.placar_fora) 
                      OR (p.time_fora = ? AND p.placar_fora > p.placar_casa) 
                    THEN 1 ELSE 0 END) AS vitorias,
                SUM(CASE WHEN p.placar_casa = p.placar_fora THEN 1 ELSE 0 END) AS empates,
                SUM(CASE 
                    WHEN (p.time_casa = ? AND p.placar_casa < p.placar_fora) 
                      OR (p.time_fora = ? AND p.placar_fora < p.placar_casa) 
                    THEN 1 ELSE 0 END) AS derrotas
            FROM partidas p
            WHERE p.campeonato_id = ? AND (p.time_casa = ? OR p.time_fora = ?)";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param(
            "iiiiiiiii",
            $time_id,
            $time_id,
            $time_id,
            $time_id,
            $time_id,
            $time_id,
            $campeonato_id,
            $time_id,
            $time_id
        );
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    public function listarGoleirosMenosVazados($campeonato_id, $limite = 1)
    {
        $query = "
        SELECT 
            j.id AS jogador_id,
            j.nome,
            j.time_id,
            t.nome AS time,
            SUM(e.gols_sofridos) AS gols_sofridos
        FROM estatisticas_partida e
        JOIN partidas p ON e.partida_id = p.id
        JOIN jogadores j ON j.id = e.jogador_id
        JOIN times t ON t.id = j.time_id
        WHERE p.campeonato_id = ? AND j.posicao = 'goleiro'
        GROUP BY j.id
        ORDER BY gols_sofridos ASC
        LIMIT ?
    ";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $campeonato_id, $limite);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
