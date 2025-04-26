<?php
class Campeonato {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Cria um novo campeonato
    public function criar($nome, $descricao, $temporada, $formato, $modalidade, $criado_por) {
        $query = "INSERT INTO campeonatos (nome, descricao, temporada, formato, modalidade, criado_por) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssssi", $nome, $descricao, $temporada, $formato, $modalidade, $criado_por);
        
        if ($stmt->execute()) {
            $campeonato_id = $this->conn->insert_id;
    
            // Inserir fases padrão automaticamente
            $fases = ['Fase de Grupos', 'Oitavas de Final', 'Quartas de Final', 'Semifinal', 'Final', 'Pontos Corridos'];
            foreach ($fases as $fase) {
                $fstmt = $this->conn->prepare("INSERT INTO fases_campeonato (campeonato_id, nome) VALUES (?, ?)");
                $fstmt->bind_param("is", $campeonato_id, $fase);
                $fstmt->execute();
            }
    
            return $campeonato_id;
        }
    
        return false;
    }
    
    

    // Atualiza dados do campeonato
    public function atualizar($id, $nome, $descricao, $temporada, $formato, $modalidade, $status) {
        $sql = "UPDATE campeonatos 
                SET nome = ?, descricao = ?, temporada = ?, formato = ?, modalidade = ?, status = ?
                WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssisssi", $nome, $descricao, $temporada, $formato, $modalidade, $status, $id);
        return $stmt->execute();
    }
    

    // Buscar campeonato por ID
    public function buscarPorId($id) {
        $query = "SELECT * FROM campeonatos WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Associar múltiplos times ao campeonato
    public function associarTimes($campeonato_id, $times = []) {
        $query = "INSERT INTO times_campeonatos (time_id, campeonato_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        foreach ($times as $time_id) {
            $stmt->bind_param("ii", $time_id, $campeonato_id);
            $stmt->execute();
        }
    }

    // Listar times já associados a um campeonato
    public function listarTimesPorCampeonato($campeonato_id) {
        $query = "SELECT t.* FROM times t
                  INNER JOIN times_campeonatos tc ON t.id = tc.time_id
                  WHERE tc.campeonato_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $campeonato_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function buscarTimesDoCampeonato($campeonato_id) {
        return $this->listarTimesPorCampeonato($campeonato_id);
    }

    public function buscarTimesDisponiveis($campeonato_id) {
        $query = "SELECT id, nome FROM times 
                  WHERE id NOT IN (
                      SELECT time_id FROM times_campeonatos WHERE campeonato_id = ?
                  )";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $campeonato_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function vincularTime($campeonato_id, $time_id) {
        $query = "INSERT INTO times_campeonatos (campeonato_id, time_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $campeonato_id, $time_id);
        return $stmt->execute();
    }

    public function removerTime($time_id, $campeonato_id) {
        $query = "DELETE FROM times_campeonatos WHERE time_id = ? AND campeonato_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $time_id, $campeonato_id);
        return $stmt->execute();
    }

    public function desvincularTime($campeonato_id, $time_id) {
        return $this->removerTime($time_id, $campeonato_id);
    }

    // 🔹 NOVO: Listar rodadas do campeonato
    public function listarRodadas($campeonato_id) {
        $query = "SELECT r.id, r.numero, r.tipo, r.descricao, r.data, r.hora
                  FROM rodadas r
                  JOIN fases_campeonato f ON f.id = r.fase_id
                  WHERE f.campeonato_id = ?
                  ORDER BY r.numero ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $campeonato_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // 🔹 NOVO: Adicionar nova rodada
    public function adicionarRodada($fase_id, $numero, $tipo, $descricao, $data, $hora) {
        $query = "INSERT INTO rodadas (fase_id, numero, tipo, descricao, data, hora)
                  VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iissss", $fase_id, $numero, $tipo, $descricao, $data, $hora);
        return $stmt->execute();
    }
    

    // 🔹 NOVO: Excluir rodada
    public function excluirRodada($rodada_id) {
        $query = "DELETE FROM rodadas WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $rodada_id);
        return $stmt->execute();
    }
    public function listarPartidasPorRodada($rodada_id) {
        $query = "SELECT p.id, p.data, p.horario, p.local,
                         p.time_casa AS id_time_casa,
                         p.time_fora AS id_time_fora,
                         t1.nome AS time_casa,
                         t2.nome AS time_fora
                  FROM partidas p
                  JOIN times t1 ON t1.id = p.time_casa
                  JOIN times t2 ON t2.id = p.time_fora
                  WHERE p.rodada_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $rodada_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    
    public function cadastrarPartida($rodada_id, $time_casa, $time_fora, $data, $horario, $local) {
        // Buscar fase_id e campeonato_id com base na rodada_id
        $query = "SELECT r.fase_id, f.campeonato_id
                  FROM rodadas r
                  JOIN fases_campeonato f ON f.id = r.fase_id
                  WHERE r.id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $rodada_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
    
        $fase_id = $result['fase_id'] ?? null;
        $campeonato_id = $result['campeonato_id'] ?? null;
    
        // Agora inserir a partida com os dados completos
        $query = "INSERT INTO partidas (rodada_id, fase_id, campeonato_id, time_casa, time_fora, data, horario, local, status)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'nao_iniciada')";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iiisssss", $rodada_id, $fase_id, $campeonato_id, $time_casa, $time_fora, $data, $horario, $local);
        return $stmt->execute();
    }
    
    
public function atualizarPartida($partida_id, $time_casa, $time_fora, $data, $horario, $local) {
    $query = "UPDATE partidas 
              SET time_casa = ?, time_fora = ?, data = ?, horario = ?, local = ?
              WHERE id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("iisssi", $time_casa, $time_fora, $data, $horario, $local, $partida_id);
    return $stmt->execute();
}

public function excluirPartida($partida_id) {
    $query = "DELETE FROM partidas WHERE id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("i", $partida_id);
    return $stmt->execute();
}

public function listarPartidasPorFase($campeonato_id, $fase_nome) {
    $query = "SELECT 
                p.id,
                p.fase_id,
                p.time_casa AS id_time_casa,
                p.time_fora AS id_time_fora,
                p.data,
                p.horario,
                p.local,
                t1.nome AS nome_time_casa,
                t2.nome AS nome_time_fora
              FROM partidas p
              JOIN times t1 ON t1.id = p.time_casa
              JOIN times t2 ON t2.id = p.time_fora
              JOIN rodadas r ON r.id = p.rodada_id
              JOIN fases_campeonato f ON f.id = r.fase_id
              WHERE f.campeonato_id = ? AND f.nome = ?
              ORDER BY r.numero ASC";

    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("is", $campeonato_id, $fase_nome);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}



public function listarFasesDoCampeonato($campeonato_id) {
    $query = "SELECT id, nome FROM fases_campeonato WHERE campeonato_id = ? ORDER BY ordem ASC";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("i", $campeonato_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

public function listarRodadasPorFase($fase_id) {
    $query = "SELECT id, numero, tipo, descricao FROM rodadas WHERE fase_id = ? ORDER BY numero ASC";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("i", $fase_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

public function listarTimesClassificacao($campeonato_id) {
    $query = "SELECT t.id, t.nome FROM times t
              JOIN times_campeonatos tc ON tc.time_id = t.id
              WHERE tc.campeonato_id = ?
              ORDER BY t.nome ASC";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("i", $campeonato_id);
    $stmt->execute();
    $times = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    $classificacao = [];

    foreach ($times as $time) {
        $timeId = $time['id'];
        $sql = "SELECT * FROM partidas 
                WHERE campeonato_id = ? 
                AND (time_casa = ? OR time_fora = ?)";
        $stmt2 = $this->conn->prepare($sql);
        $stmt2->bind_param("iii", $campeonato_id, $timeId, $timeId);
        $stmt2->execute();
        $result = $stmt2->get_result();

        $jogos = $vitorias = $empates = $derrotas = $gols_pro = $gols_contra = 0;

        while ($p = $result->fetch_assoc()) {
            $jogos++;
            $is_casa = $p['time_casa'] == $timeId;
            $gp = $is_casa ? $p['placar_casa'] : $p['placar_fora'];
            $gc = $is_casa ? $p['placar_fora'] : $p['placar_casa'];

            $gols_pro += $gp;
            $gols_contra += $gc;

            if ($gp > $gc) $vitorias++;
            elseif ($gp == $gc) $empates++;
            else $derrotas++;
        }

        $saldo = $gols_pro - $gols_contra;
        $pontos = $vitorias * 3 + $empates;

        $classificacao[] = [
            'nome' => $time['nome'],
            'jogos' => $jogos,
            'vitorias' => $vitorias,
            'empates' => $empates,
            'derrotas' => $derrotas,
            'gols_pro' => $gols_pro,
            'gols_contra' => $gols_contra,
            'saldo' => $saldo,
            'pontos' => $pontos,
        ];
    }

    return $classificacao;
}

public function listarPorUsuario($usuario_id) {
    $query = "SELECT * FROM campeonatos WHERE criado_por = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}


}
?>
