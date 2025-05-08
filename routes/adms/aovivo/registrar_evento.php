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
        $stmt->bindValue(1, $partida_id, PDO::PARAM_INT);
    $stmt->bindValue(2, $jogador_id, PDO::PARAM_INT);
    $stmt->bindValue(3, $time_id, PDO::PARAM_INT);
    $stmt->bindValue(4, $tipo_evento, PDO::PARAM_STR);
    $stmt->bindValue(5, $minuto, PDO::PARAM_STR);
    $stmt->bindValue(6, $descricao, PDO::PARAM_STR);
        $stmt->execute();

        // 2. Se for GOL, atualizar o placar
        if ($tipo_evento === 'gol') {
            $stmt = $conn->prepare("SELECT time_casa, time_fora FROM partidas WHERE id = ?");
            $stmt->bindValue(1, $partida_id, PDO::PARAM_INT);
            $stmt->execute();
            $res = $stmt->get_result()->fetch(PDO::FETCH_ASSOC);

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
            $stmt->bindValue(1, $partida_id, PDO::PARAM_INT);
    $stmt->bindValue(2, $jogador_id, PDO::PARAM_INT);
            $stmt->execute();
        } elseif ($tipo_evento === 'penalti_defendido') {
            $stmt = $conn->prepare("UPDATE estatisticas_partida SET penaltis_defendidos = penaltis_defendidos + 1 WHERE partida_id = ? AND jogador_id = ?");
            $stmt->bindValue(1, $partida_id, PDO::PARAM_INT);
    $stmt->bindValue(2, $jogador_id, PDO::PARAM_INT);
            $stmt->execute();
        }
    }

    // Redireciona de volta
    header("Location: partida_ao_vivo.php?id=" . $partida_id);
    exit;
}

http_response_code(405); // Método não permitido
echo "Método inválido.";
