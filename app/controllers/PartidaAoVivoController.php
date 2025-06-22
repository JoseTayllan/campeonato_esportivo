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
        SELECT j.id, j.nome, j.posicao, jt.time_id, t.nome AS time_nome
        FROM jogador_time jt
        JOIN jogadores j ON jt.jogador_id = j.id
        JOIN times t ON jt.time_id = t.id
        WHERE jt.status = 'ativo' AND jt.time_id IN (?, ?)
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
    // Finaliza a partida
    $stmt = $this->conn->prepare("UPDATE partidas SET status = 'finalizada' WHERE id = ?");
    $stmt->bind_param("i", $partida_id);
    $stmt->execute();
    $stmt->close();

    // Estatísticas dos eventos registrados
    $eventos = $this->conn->query("
        SELECT jogador_id, tipo_evento, COUNT(*) as total
        FROM eventos_partida
        WHERE partida_id = $partida_id AND jogador_id IS NOT NULL
        GROUP BY jogador_id, tipo_evento
    ");

    $estatisticas = [];

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
            if (!isset($estatisticas[$jogador_id])) $estatisticas[$jogador_id] = [];
            $estatisticas[$jogador_id][$campo] = $qtd;
        }
    }

    // Buscar dados da partida
    $res = $this->conn->query("SELECT * FROM partidas WHERE id = $partida_id")->fetch_assoc();
    $t1 = $res['time_casa'];
    $t2 = $res['time_fora'];
    $g1 = (int)$res['placar_casa'];
    $g2 = (int)$res['placar_fora'];
    $campeonato_id = $res['campeonato_id'];

    // Buscar time_id real dos jogadores ativos no momento da partida
    $timesJogadores = [];
    $stmt = $this->conn->prepare("
        SELECT jogador_id, time_id 
        FROM jogador_time 
        WHERE status = 'ativo' AND time_id IN (?, ?)
    ");
    $stmt->bind_param("ii", $t1, $t2);
    $stmt->execute();
    $resTime = $stmt->get_result();
    while ($row = $resTime->fetch_assoc()) {
        $timesJogadores[$row['jogador_id']] = $row['time_id'];
    }

    // Salvar estatísticas por jogador
    foreach ($estatisticas as $jogador_id => $dados) {
        $campos = array_keys($dados);
        $valores = array_values($dados);

        $setSql = implode(", ", array_map(fn($c) => "$c = VALUES($c)", $campos));
        $placeholders = implode(", ", array_fill(0, count($campos), "?"));
        $tipos = str_repeat("i", count($valores) + 2); // partida_id + jogador_id + campos

        $sql = "INSERT INTO estatisticas_partida (partida_id, jogador_id, " . implode(",", $campos) . ")
                VALUES (?, ?, $placeholders)
                ON DUPLICATE KEY UPDATE $setSql";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($tipos, ...array_merge([$partida_id, $jogador_id], $valores));
        $stmt->execute();
    }

    // Atualiza classificação
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

    // Identifica os goleiros titulares
    $goleiros = [];

    // Goleiro do time da casa
    $stmt1 = $this->conn->prepare("
        SELECT j.id 
        FROM jogadores j 
        JOIN jogador_time jt ON jt.jogador_id = j.id 
        WHERE jt.time_id = ? AND j.posicao = 'Goleiro' AND jt.status = 'ativo' 
        LIMIT 1
    ");
    $stmt1->bind_param("i", $t1);
    $stmt1->execute();
    $res1 = $stmt1->get_result()->fetch_assoc();
    if ($res1) $goleiros[] = ['id' => $res1['id'], 'gols_sofridos' => $g2];
    $stmt1->close();

    // Goleiro do time visitante
    $stmt2 = $this->conn->prepare("
        SELECT j.id 
        FROM jogadores j 
        JOIN jogador_time jt ON jt.jogador_id = j.id 
        WHERE jt.time_id = ? AND j.posicao = 'Goleiro' AND jt.status = 'ativo' 
        LIMIT 1
    ");
    $stmt2->bind_param("i", $t2);
    $stmt2->execute();
    $res2 = $stmt2->get_result()->fetch_assoc();
    if ($res2) $goleiros[] = ['id' => $res2['id'], 'gols_sofridos' => $g1];
    $stmt2->close();

    // Registrar estatísticas dos goleiros (gols sofridos + clean sheet)
    foreach ($goleiros as $g) {
        $clean_sheet = ($g['gols_sofridos'] == 0) ? 1 : 0;
        $this->conn->query("
            INSERT INTO estatisticas_partida (partida_id, jogador_id, gols_sofridos, clean_sheets)
            VALUES ($partida_id, {$g['id']}, {$g['gols_sofridos']}, $clean_sheet)
            ON DUPLICATE KEY UPDATE 
                gols_sofridos = VALUES(gols_sofridos), 
                clean_sheets = VALUES(clean_sheets)
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

    public function salvarLinkTransmissao($partida_id, $link)
    {
        $stmt = $this->conn->prepare("UPDATE partidas SET link_transmissao = ? WHERE id = ?");
        $stmt->bind_param("si", $link, $partida_id);
        $stmt->execute();
        $stmt->close();
    }
}
