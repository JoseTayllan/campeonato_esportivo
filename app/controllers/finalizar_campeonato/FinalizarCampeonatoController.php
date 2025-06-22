<?php

require_once __DIR__ . '/../../Models/Campeonato.php';
require_once __DIR__ . '/../../Models/Estatistica.php';

class FinalizarCampeonatoController
{
    public function listarCampeonatosAtivos()
    {
        global $conn;
        $campeonato = new Campeonato($conn);
        return $campeonato->listarCampeonatosAtivos();
    }

    public function listarTimesPorCampeonato($campeonato_id)
    {
        global $conn;
        $campeonato = new Campeonato($conn);
        return $campeonato->listarTimesPorCampeonato($campeonato_id);
    }

   public function finalizar($campeonato_id, $campeao_id)
{
    global $conn;

    // 🔹 Upload do banner do elenco
    if (!empty($_FILES['elenco']['name'])) {
        $nomeArquivo = 'elenco_' . time() . '_' . basename($_FILES['elenco']['name']);
        $destinoDir = __DIR__ . '/../../../public/img/elencos/';
        if (!is_dir($destinoDir)) mkdir($destinoDir, 0755, true);
        $destino = $destinoDir . $nomeArquivo;

        if (move_uploaded_file($_FILES['elenco']['tmp_name'], $destino)) {
            $elenco = 'img/elencos/' . $nomeArquivo;
            $stmtTime = $conn->prepare("UPDATE times SET elenco = ? WHERE id = ?");
            $stmtTime->bind_param("si", $elenco, $campeao_id);
            $stmtTime->execute();
        }
    }

    // 🔹 Atualiza campeonato como finalizado
    $stmt = $conn->prepare("UPDATE campeonatos SET campeao_id = ?, status_finalizado = 1 WHERE id = ?");
    $stmt->bind_param("ii", $campeao_id, $campeonato_id);
    $stmt->execute();

    // 🔹 Estatísticas do time campeão
    $estatistica = new Estatistica($conn);
    $dadosTime = $estatistica->estatisticasTimePorCampeonato($campeonato_id, $campeao_id);

    $vitorias     = $dadosTime['vitorias']     ?? 0;
    $empates      = $dadosTime['empates']      ?? 0;
    $derrotas     = $dadosTime['derrotas']     ?? 0;
    $gols_pro     = $dadosTime['gols_pro']     ?? 0;
    $gols_contra  = $dadosTime['gols_contra']  ?? 0;
    $saldo        = $gols_pro - $gols_contra;

    $stmtHist = $conn->prepare("
        INSERT INTO historico_campeonatos 
        (campeonato_id, time_id, vitorias, empates, derrotas, gols_pro, gols_contra, saldo)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmtHist->bind_param("iiiiiiii", $campeonato_id, $campeao_id, $vitorias, $empates, $derrotas, $gols_pro, $gols_contra, $saldo);
    $stmtHist->execute();

    // 🔹 Artilheiro (corrigido com JOIN limpo por jogador ativo e time único)
    $sql = "
        SELECT ep.jogador_id, jt.time_id, SUM(ep.gols) AS total_gols
        FROM estatisticas_partida ep
        JOIN partidas p ON ep.partida_id = p.id
        JOIN (
            SELECT jogador_id, MAX(time_id) AS time_id
            FROM jogador_time
            WHERE status = 'ativo'
            GROUP BY jogador_id
        ) jt ON jt.jogador_id = ep.jogador_id
        WHERE p.campeonato_id = ? AND ep.gols > 0
        GROUP BY ep.jogador_id
        ORDER BY total_gols DESC
        LIMIT 1
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $campeonato_id);
    $stmt->execute();
    $art = $stmt->get_result()->fetch_assoc();

    if ($art && $art['total_gols'] > 0) {
        $jogador_id = $art['jogador_id'];
        $time_id    = $art['time_id'];
        $gols       = $art['total_gols'];

        $stmtArt = $conn->prepare("
            INSERT INTO historico_artilheiros (campeonato_id, jogador_id, time_id, gols)
            VALUES (?, ?, ?, ?)
        ");
        $stmtArt->bind_param("iiii", $campeonato_id, $jogador_id, $time_id, $gols);
        $stmtArt->execute();
    }

    // 🔹 Goleiro menos vazado (posição, time e campeonato corretos)
    $sql = "SELECT 
                ep.jogador_id, 
                jt.time_id, 
                SUM(ep.gols_sofridos) AS total_sofridos
            FROM estatisticas_partida ep
            JOIN partidas p ON ep.partida_id = p.id
            JOIN jogador_time jt ON jt.jogador_id = ep.jogador_id AND jt.status = 'ativo'
            JOIN jogadores j ON j.id = ep.jogador_id
            WHERE p.campeonato_id = ? AND j.posicao = 'Goleiro' AND jt.time_id = ?
            GROUP BY ep.jogador_id, jt.time_id
            ORDER BY total_sofridos ASC
            LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $campeonato_id, $campeao_id);
    $stmt->execute();
    $g = $stmt->get_result()->fetch_assoc();

    if ($g && isset($g['jogador_id']) && isset($g['time_id'])) {
        $g_jogador_id = $g['jogador_id'];
        $g_time_id    = $g['time_id'];
        $g_sofridos   = $g['total_sofridos'];

        $stmtGol = $conn->prepare("
            INSERT INTO historico_goleiros (jogador_id, campeonato_id, time_id, gols_sofridos)
            VALUES (?, ?, ?, ?)
        ");
        $stmtGol->bind_param("iiii", $g_jogador_id, $campeonato_id, $g_time_id, $g_sofridos);
        $stmtGol->execute();
    }

    return true;
}

}
