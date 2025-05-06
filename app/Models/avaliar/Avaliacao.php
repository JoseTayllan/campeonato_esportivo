<?php
require_once __DIR__ . '/../../../config/database.php';

class Avaliacao {
    public static function listarAvaliacoes($filtros = []) {
        global $conn;
        $where = [];

        if (!empty($filtros['jogador'])) {
            $jogador = $conn->real_escape_string($filtros['jogador']);
            $where[] = "j.nome LIKE '%$jogador%'";
        }

        if (!empty($filtros['olheiro'])) {
            $olheiro = $conn->real_escape_string($filtros['olheiro']);
            $where[] = "u.id = '$olheiro'";
        }

        $whereSQL = $where ? "WHERE " . implode(" AND ", $where) : "";

        $sql = "
            SELECT a.forca, a.velocidade, a.drible, a.finalizacao, a.nota_geral, a.observacoes,
                   j.nome AS jogador_nome, u.nome AS olheiro_nome
            FROM avaliacoes a
            JOIN jogadores j ON a.jogador_id = j.id
            JOIN usuarios u ON a.olheiro_id = u.id
            $whereSQL
            ORDER BY a.nota_geral DESC
        ";

        return $conn->query($sql);
    }

    public static function listarJogadores() {
        global $conn;
        return $conn->query("SELECT id, nome FROM jogadores ORDER BY nome ASC");
    }

    public static function listarOlheiros() {
        global $conn;
        return $conn->query("SELECT id, nome FROM usuarios WHERE tipo = 'Olheiro'");
    }
}
