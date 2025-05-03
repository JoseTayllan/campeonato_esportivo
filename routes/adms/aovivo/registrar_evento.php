<?php
session_start();
require_once __DIR__ . '/../../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $partida_id   = $_POST['partida_id'] ?? null;
    $tipo_evento  = $_POST['tipo_evento'] ?? null;
    $minuto       = $_POST['minuto'] ?? null;
    $descricao    = $_POST['descricao'] ?? null;
    $jogador_id   = $_POST['jogador_id'] ?? null;
    $time_id      = $_POST['time_id'] ?? null;

    if (!$minuto || !is_numeric($minuto)) {
        $_SESSION['mensagem_erro'] = "Erro: minuto inválido.";
        header("Location: partida_ao_vivo.php?id=" . $partida_id);
        exit;
    }

    if ($partida_id && $tipo_evento && $minuto && $time_id) {
        // 1. Inserir o evento
        $stmt = $conn->prepare("INSERT INTO eventos_partida (partida_id, jogador_id, time_id, tipo_evento, minuto, descricao) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iiisss", $partida_id, $jogador_id, $time_id, $tipo_evento, $minuto, $descricao);
        $stmt->execute();

        // 2. Se for GOL, atualizar o placar
        if ($tipo_evento === 'gol') {
            $stmt = $conn->prepare("SELECT time_casa, time_fora FROM partidas WHERE id = ?");
            $stmt->bind_param("i", $partida_id);
            $stmt->execute();
            $res = $stmt->get_result()->fetch_assoc();

            if ($res) {
                if ($res['time_casa'] == $time_id) {
                    $conn->query("UPDATE partidas SET placar_casa = placar_casa + 1 WHERE id = $partida_id");
                } elseif ($res['time_fora'] == $time_id) {
                    $conn->query("UPDATE partidas SET placar_fora = placar_fora + 1 WHERE id = $partida_id");
                }
            }
        }

        // 3. Se for defesa ou penalti_defendido, atualizar estatísticas do goleiro
        if ($tipo_evento === 'defesa') {
            $stmt = $conn->prepare("UPDATE estatisticas_partida SET defesas = defesas + 1 WHERE partida_id = ? AND jogador_id = ?");
            $stmt->bind_param("ii", $partida_id, $jogador_id);
            $stmt->execute();
        } elseif ($tipo_evento === 'penalti_defendido') {
            $stmt = $conn->prepare("UPDATE estatisticas_partida SET penaltis_defendidos = penaltis_defendidos + 1 WHERE partida_id = ? AND jogador_id = ?");
            $stmt->bind_param("ii", $partida_id, $jogador_id);
            $stmt->execute();
        }
    }

    // Redireciona de volta
    header("Location: partida_ao_vivo.php?id=" . $partida_id);
    exit;
}

http_response_code(405); // Método não permitido
echo "Método inválido.";
