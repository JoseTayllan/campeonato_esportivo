<?php

class PartidaFinalizacaoController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function finalizarPartida($partida_id) {
        // Marcar a partida como finalizada
        $stmt = $this->conn->prepare("UPDATE partidas SET status = 'finalizada' WHERE id = ?");
        $stmt->bind_param("i", $partida_id);
        $stmt->execute();
    
        // Buscar os eventos da partida
        $eventos = $this->buscarEventos($partida_id);
    
        // Consolidar estatísticas por jogador
        $estatisticas = [];
    
        foreach ($eventos as $e) {
            $j = $e['jogador_id'];
            if (!isset($estatisticas[$j])) {
                $estatisticas[$j] = [
                    'gols' => 0,
                    'finalizacoes' => 0,
                    'cartoes_amarelos' => 0,
                    'cartoes_vermelhos' => 0
                ];
            }
    
            switch ($e['tipo_evento']) {
                case 'gol':
                    $estatisticas[$j]['gols']++;
                    break;
                case 'finalizacao':
                    $estatisticas[$j]['finalizacoes']++;
                    break;
                case 'cartao_amarelo':
                    $estatisticas[$j]['cartoes_amarelos']++;
                    break;
                case 'cartao_vermelho':
                    $estatisticas[$j]['cartoes_vermelhos']++;
                    break;
            }
        }
    
        // Inserir estatísticas por jogador
        foreach ($estatisticas as $jogador_id => $stats) {
            $stmt = $this->conn->prepare("
                INSERT INTO estatisticas_partida (partida_id, jogador_id, gols, finalizacoes, cartoes_amarelos, cartoes_vermelhos)
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            $stmt->bind_param(
                "iiiiii",
                $partida_id,
                $jogador_id,
                $stats['gols'],
                $stats['finalizacoes'],
                $stats['cartoes_amarelos'],
                $stats['cartoes_vermelhos']
            );
            $stmt->execute();
        }
    
        // Atualizar classificação dos times
        $this->atualizarClassificacao($partida_id);
    }
    

    private function buscarEventos($partida_id) {
        $stmt = $this->conn->prepare("SELECT * FROM eventos_partida WHERE partida_id = ?");
        $stmt->bind_param("i", $partida_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    private function atualizarClassificacao($partida_id) {
        $stmt = $this->conn->prepare("SELECT * FROM partidas WHERE id = ?");
        $stmt->bind_param("i", $partida_id);
        $stmt->execute();
        $p = $stmt->get_result()->fetch_assoc();

        $casa = $p['time_casa'];
        $fora = $p['time_fora'];
        $gols_casa = (int)$p['placar_casa'];
        $gols_fora = (int)$p['placar_fora'];
        $campeonato_id = (int)$p['campeonato_id'];

        $vitorias_casa = 0;
        $vitorias_fora = 0;
        $empates = 0;
        $derrotas_casa = 0;
        $derrotas_fora = 0;
        $pontos_casa = 0;
        $pontos_fora = 0;

        if ($gols_casa > $gols_fora) {
            $pontos_casa = 3; $vitorias_casa = 1; $derrotas_fora = 1;
        } elseif ($gols_fora > $gols_casa) {
            $pontos_fora = 3; $vitorias_fora = 1; $derrotas_casa = 1;
        } else {
            $pontos_casa = 1; $pontos_fora = 1; $empates = 1;
        }

        // Garante existência dos registros
        $this->criarSeNaoExistir($casa, $campeonato_id);
        $this->criarSeNaoExistir($fora, $campeonato_id);

        // Atualiza casa
        $this->registrarPontuacao($casa, $campeonato_id, $pontos_casa, $vitorias_casa, $empates, $derrotas_casa, $gols_casa, $gols_fora);

        // Atualiza fora
        $this->registrarPontuacao($fora, $campeonato_id, $pontos_fora, $vitorias_fora, $empates, $derrotas_fora, $gols_fora, $gols_casa);
    }

    private function criarSeNaoExistir($time_id, $campeonato_id) {
        $this->conn->query("
            INSERT INTO times_campeonatos (time_id, campeonato_id)
            SELECT $time_id, $campeonato_id
            FROM DUAL
            WHERE NOT EXISTS (
                SELECT 1 FROM times_campeonatos
                WHERE time_id = $time_id AND campeonato_id = $campeonato_id
            )
        ");
    }

    private function registrarPontuacao($time_id, $campeonato_id, $pontos, $vitorias, $empates, $derrotas, $gols_pro, $gols_contra) {
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
