<?php
class Campeonato {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function criar($nome, $descricao, $temporada, $formato, $modalidade, $criado_por) {
        $query = "INSERT INTO campeonatos (nome, descricao, temporada, formato, modalidade, criado_por) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $nome, PDO::PARAM_STR);
    $stmt->bindValue(2, $descricao, PDO::PARAM_STR);
    $stmt->bindValue(3, $temporada, PDO::PARAM_STR);
    $stmt->bindValue(4, $formato, PDO::PARAM_STR);
    $stmt->bindValue(5, $modalidade, PDO::PARAM_STR);
    $stmt->bindValue(6, $criado_por, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $campeonato_id = $this->conn->insert_id;

            $fases = ['Fase de Grupos', 'Oitavas de Final', 'Quartas de Final', 'Semifinal', 'Final', 'Pontos Corridos'];
            foreach ($fases as $fase) {
                $fstmt = $this->conn->prepare("INSERT INTO fases_campeonato (campeonato_id, nome) VALUES (?, ?)");
                $fstmt->bindValue(1, $campeonato_id, PDO::PARAM_INT);
    $stmt->bindValue(2, $fase, PDO::PARAM_STR);
                $fstmt->execute();
            }

            return $campeonato_id;
        }

        return false;
    }

    public function atualizar($id, $nome, $descricao, $temporada, $formato, $modalidade, $status) {
        $sql = "UPDATE campeonatos SET nome = ?, descricao = ?, temporada = ?, formato = ?, modalidade = ?, status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $nome, PDO::PARAM_STR);
    $stmt->bindValue(2, $descricao, PDO::PARAM_STR);
    $stmt->bindValue(3, $temporada, PDO::PARAM_INT);
    $stmt->bindValue(4, $formato, PDO::PARAM_STR);
    $stmt->bindValue(5, $modalidade, PDO::PARAM_STR);
    $stmt->bindValue(6, $status, PDO::PARAM_STR);
    $stmt->bindValue(7, $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function buscarPorId($id) {
        $query = "SELECT * FROM campeonatos WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->get_result()->fetch(PDO::FETCH_ASSOC);
    }

    public function associarTimes($campeonato_id, $times = []) {
        $query = "INSERT INTO times_campeonatos (time_id, campeonato_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        foreach ($times as $time_id) {
            $stmt->bindValue(1, $time_id, PDO::PARAM_INT);
    $stmt->bindValue(2, $campeonato_id, PDO::PARAM_INT);
            $stmt->execute();
        }
        return true;
    }

    public function vincularTime($campeonato_id, $time_id) {
        return $this->associarTimes($campeonato_id, [$time_id]);
    }

    public function listarTimesPorCampeonato($campeonato_id) {
        $query = "SELECT t.* FROM times t INNER JOIN times_campeonatos tc ON t.id = tc.time_id WHERE tc.campeonato_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $campeonato_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->get_result()->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarTimesDoCampeonato($campeonato_id) {
        return $this->listarTimesPorCampeonato($campeonato_id);
    }

    public function buscarTimesDisponiveis($campeonato_id) {
        $query = "SELECT id, nome FROM times WHERE id NOT IN (SELECT time_id FROM times_campeonatos WHERE campeonato_id = ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $campeonato_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->get_result()->fetchAll(PDO::FETCH_ASSOC);
    }

    public function removerTime($time_id, $campeonato_id) {
        $query = "DELETE FROM times_campeonatos WHERE time_id = ? AND campeonato_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $time_id, PDO::PARAM_INT);
    $stmt->bindValue(2, $campeonato_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function desvincularTime($campeonato_id, $time_id) {
        return $this->removerTime($time_id, $campeonato_id);
    }

    public function listarRodadas($campeonato_id) {
        $query = "SELECT r.id, r.numero, r.tipo, r.descricao, r.data, r.hora FROM rodadas r JOIN fases_campeonato f ON f.id = r.fase_id WHERE f.campeonato_id = ? ORDER BY r.numero ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $campeonato_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->get_result()->fetchAll(PDO::FETCH_ASSOC);
    }

    public function adicionarRodada($fase_id, $numero, $tipo, $descricao, $data, $hora) {
        $query = "INSERT INTO rodadas (fase_id, numero, tipo, descricao, data, hora) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $fase_id, PDO::PARAM_INT);
    $stmt->bindValue(2, $numero, PDO::PARAM_INT);
    $stmt->bindValue(3, $tipo, PDO::PARAM_STR);
    $stmt->bindValue(4, $descricao, PDO::PARAM_STR);
    $stmt->bindValue(5, $data, PDO::PARAM_STR);
    $stmt->bindValue(6, $hora, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function excluirRodada($rodada_id) {
        $query = "DELETE FROM rodadas WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $rodada_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function listarPartidasPorRodada($rodada_id) {
        $query = "SELECT p.id, p.data, p.horario, p.local, p.time_casa AS id_time_casa, p.time_fora AS id_time_fora, t1.nome AS time_casa, t2.nome AS time_fora FROM partidas p JOIN times t1 ON t1.id = p.time_casa JOIN times t2 ON t2.id = p.time_fora WHERE p.rodada_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $rodada_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->get_result()->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cadastrarPartida($rodada_id, $time_casa, $time_fora, $data, $horario, $local) {
        $query = "SELECT r.fase_id, f.campeonato_id FROM rodadas r JOIN fases_campeonato f ON f.id = r.fase_id WHERE r.id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $rodada_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->get_result()->fetch(PDO::FETCH_ASSOC);

        $fase_id = $result['fase_id'] ?? null;
        $campeonato_id = $result['campeonato_id'] ?? null;

        $query = "INSERT INTO partidas (rodada_id, fase_id, campeonato_id, time_casa, time_fora, data, horario, local, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'nao_iniciada')";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $rodada_id, PDO::PARAM_INT);
    $stmt->bindValue(2, $fase_id, PDO::PARAM_INT);
    $stmt->bindValue(3, $campeonato_id, PDO::PARAM_INT);
    $stmt->bindValue(4, $time_casa, PDO::PARAM_STR);
    $stmt->bindValue(5, $time_fora, PDO::PARAM_STR);
    $stmt->bindValue(6, $data, PDO::PARAM_STR);
    $stmt->bindValue(7, $horario, PDO::PARAM_STR);
    $stmt->bindValue(8, $local, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function atualizarPartida($partida_id, $time_casa, $time_fora, $data, $horario, $local) {
        $query = "UPDATE partidas SET time_casa = ?, time_fora = ?, data = ?, horario = ?, local = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $time_casa, PDO::PARAM_INT);
    $stmt->bindValue(2, $time_fora, PDO::PARAM_INT);
    $stmt->bindValue(3, $data, PDO::PARAM_STR);
    $stmt->bindValue(4, $horario, PDO::PARAM_STR);
    $stmt->bindValue(5, $local, PDO::PARAM_STR);
    $stmt->bindValue(6, $partida_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function excluirPartida($partida_id) {
        $query = "DELETE FROM partidas WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $partida_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function listarPartidasPorFase($campeonato_id, $fase_nome) {
        $query = "SELECT p.id, p.fase_id, p.time_casa AS id_time_casa, p.time_fora AS id_time_fora, p.data, p.horario, p.local, t1.nome AS nome_time_casa, t2.nome AS nome_time_fora FROM partidas p JOIN times t1 ON t1.id = p.time_casa JOIN times t2 ON t2.id = p.time_fora JOIN rodadas r ON r.id = p.rodada_id JOIN fases_campeonato f ON f.id = r.fase_id WHERE f.campeonato_id = ? AND f.nome = ? ORDER BY r.numero ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $campeonato_id, PDO::PARAM_INT);
    $stmt->bindValue(2, $fase_nome, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->get_result()->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarFasesDoCampeonato($campeonato_id) {
        $query = "SELECT id, nome FROM fases_campeonato WHERE campeonato_id = ? ORDER BY ordem ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $campeonato_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->get_result()->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarRodadasPorFase($fase_id) {
        $query = "SELECT id, numero, tipo, descricao FROM rodadas WHERE fase_id = ? ORDER BY numero ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $fase_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->get_result()->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarTimesClassificacao($campeonato_id) {
        $query = "SELECT t.id, t.nome FROM times t JOIN times_campeonatos tc ON tc.time_id = t.id WHERE tc.campeonato_id = ? ORDER BY t.nome ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $campeonato_id, PDO::PARAM_INT);
        $stmt->execute();
        $times = $stmt->get_result()->fetchAll(PDO::FETCH_ASSOC);

        $classificacao = [];

        foreach ($times as $time) {
            $timeId = $time['id'];
            $sql = "SELECT * FROM partidas WHERE campeonato_id = ? AND (time_casa = ? OR time_fora = ?)";
            $stmt2 = $this->conn->prepare($sql);
            $stmt2->bindValue(1, $campeonato_id, PDO::PARAM_INT);
    $stmt->bindValue(2, $timeId, PDO::PARAM_INT);
    $stmt->bindValue(3, $timeId, PDO::PARAM_INT);
            $stmt2->execute();
            $result = $stmt2->get_result();

            $jogos = $vitorias = $empates = $derrotas = $gols_pro = $gols_contra = 0;

            while ($p = $result->fetch(PDO::FETCH_ASSOC)) {
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
        $stmt->bindValue(1, $usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->get_result()->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarTodos() {
        $sql = "SELECT * FROM campeonatos ORDER BY nome ASC";
        $result = $this->conn->query($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}