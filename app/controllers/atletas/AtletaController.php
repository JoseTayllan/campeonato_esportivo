<?php
class AtletaController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function listar($filtros = []) {
        $sql = "SELECT * FROM jogadores WHERE 1=1";

        if (!empty($filtros['nome'])) {
            $nome = mysqli_real_escape_string($this->conn, $filtros['nome']);
            $sql .= " AND nome LIKE '%$nome%'";
        }

        if (!empty($filtros['posicao'])) {
            $posicao = mysqli_real_escape_string($this->conn, $filtros['posicao']);
            $sql .= " AND posicao = '$posicao'";
        }

        if (!empty($filtros['nacionalidade'])) {
            $nacionalidade = mysqli_real_escape_string($this->conn, $filtros['nacionalidade']);
            $sql .= " AND nacionalidade LIKE '%$nacionalidade%'";
        }

        if (!empty($filtros['idade'])) {
            $idade = (int)$filtros['idade'];
            $sql .= " AND idade = $idade";
        }

        $sql .= " ORDER BY nome";

        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function detalhar($id) {
        $id = (int)$id;

        $res = mysqli_query($this->conn, "SELECT * FROM jogadores WHERE id = $id");
        if (!$res) {
            die("Erro ao buscar jogador: " . mysqli_error($this->conn));
        }

        $jogador = mysqli_fetch_assoc($res);
        if (!$jogador) {
            return null;
        }

        // Times do jogador
        $times = mysqli_query($this->conn, "
            SELECT t.nome, jt.data_entrada, jt.data_saida
            FROM jogador_time jt
            JOIN times t ON t.id = jt.time_id
            WHERE jt.jogador_id = $id
        ");

        // Campeonatos que participou (sem estatísticas)
        $campeonatos = mysqli_query($this->conn, "
            SELECT DISTINCT c.nome, c.temporada
            FROM jogadores_times_campeonatos jtc
            JOIN campeonatos c ON c.id = jtc.campeonato_id
            WHERE jtc.jogador_id = $id
        ");

        // Gols totais
        $gols = mysqli_fetch_assoc(mysqli_query($this->conn, "
            SELECT SUM(gols) AS total 
            FROM estatisticas_partida 
            WHERE jogador_id = $id
        "))['total'] ?? 0;

        // Cartões totais
        $cartoes = mysqli_fetch_assoc(mysqli_query($this->conn, "
            SELECT 
                SUM(tipo_evento = 'cartao_amarelo') AS amarelos,
                SUM(tipo_evento = 'cartao_vermelho') AS vermelhos
            FROM eventos_partida
            WHERE jogador_id = $id
        "));

        // Campeonatos disputados com estatísticas
        $campeonatosDisputados = mysqli_query($this->conn, "
            SELECT 
                c.id AS campeonato_id,
                c.nome AS campeonato_nome,
                c.temporada,
                COUNT(DISTINCT p.id) AS jogos,
                COALESCE(SUM(e.gols), 0) AS gols,
                COALESCE(SUM(e.cartoes_amarelos), 0) AS amarelos,
                COALESCE(SUM(e.cartoes_vermelhos), 0) AS vermelhos
            FROM estatisticas_partida e
            JOIN partidas p    ON e.partida_id = p.id
            JOIN campeonatos c ON p.campeonato_id = c.id
            WHERE e.jogador_id = $id
            GROUP BY c.id, c.nome, c.temporada
            ORDER BY c.temporada DESC
        ");

        return [
            'jogador' => $jogador,
            'times' => $times,
            'campeonatos' => $campeonatos,
            'gols' => $gols,
            'cartoes' => $cartoes,
            'campeonatosDisputados' => $campeonatosDisputados
        ];
    }
}
?>
