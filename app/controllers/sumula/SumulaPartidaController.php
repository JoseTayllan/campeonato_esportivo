<?php

class SumulaPartidaController
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function carregarDados($partida_id)
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
        $partida = $stmt->get_result()->fetch_assoc();

        $stmt = $this->conn->prepare("
    SELECT j.id, j.nome, j.posicao, j.time_id, t.nome AS time_nome
    FROM jogadores j
    JOIN times t ON j.time_id = t.id
    WHERE t.id IN (?, ?)
");


        $stmt->bind_param("ii", $partida['time_casa'], $partida['time_fora']);
        $stmt->execute();
        $jogadores = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        return ['partida' => $partida, 'jogadores' => $jogadores];
    }

    public function salvarSumula($dados)
    {
        $partida_id = $dados['partida_id'];
        $placar_casa = $dados['placar_casa'];
        $placar_fora = $dados['placar_fora'];

        // ✅ Atualiza placar e status da partida
        $stmt = $this->conn->prepare("
        UPDATE partidas 
        SET placar_casa = ?, placar_fora = ?, status = 'finalizada' 
        WHERE id = ?
    ");
        $stmt->bind_param("iii", $placar_casa, $placar_fora, $partida_id);
        $stmt->execute();

        // ✅ Registrar estatísticas dos jogadores de linha
        $campos = [
            'gols',
            'assistencias',
            'amarelos' => 'cartoes_amarelos',
            'vermelhos' => 'cartoes_vermelhos',
            'defesas',
            'penaltis_defendidos'
        ];

        foreach ($campos as $key => $campo) {
            $campo = is_numeric($key) ? $campo : $campo;
            $input = is_numeric($key) ? $campo : $key;

            if (!empty($dados[$input])) {
                foreach ($dados[$input] as $jogador_id => $valor) {
                    if ($valor >= 0) {
                        $this->registrarEstatistica($partida_id, $jogador_id, $campo, $valor);
                    }
                }
            }
        }

        // ✅ 🧤 Calcula automaticamente os goleiros
        $partida = $this->carregarDados($partida_id);
        $time_casa = $partida['partida']['time_casa'];
        $time_fora = $partida['partida']['time_fora'];

        // ➕ Goleiro time casa
        $res = $this->conn->query("
        SELECT id FROM jogadores 
        WHERE time_id = $time_casa AND posicao = 'Goleiro' LIMIT 1
    ");
        if ($g = $res->fetch_assoc()) {
            $this->registrarEstatistica($partida_id, $g['id'], 'gols_sofridos', $placar_fora);
            $clean = ($placar_fora == 0) ? 1 : 0;
            $this->registrarEstatistica($partida_id, $g['id'], 'clean_sheets', $clean);
        }

        // ➕ Goleiro time visitante
        $res = $this->conn->query("
        SELECT id FROM jogadores 
        WHERE time_id = $time_fora AND posicao = 'Goleiro' LIMIT 1
    ");
        if ($g = $res->fetch_assoc()) {
            $this->registrarEstatistica($partida_id, $g['id'], 'gols_sofridos', $placar_casa);
            $clean = ($placar_casa == 0) ? 1 : 0;
            $this->registrarEstatistica($partida_id, $g['id'], 'clean_sheets', $clean);
        }
    }


    private function registrarEstatistica($partida_id, $jogador_id, $campo, $valor)
    {
        $this->conn->query("
            INSERT INTO estatisticas_partida (partida_id, jogador_id, $campo)
            VALUES ($partida_id, $jogador_id, $valor)
            ON DUPLICATE KEY UPDATE $campo = COALESCE($campo, 0) + $valor
        ");
    }
}
