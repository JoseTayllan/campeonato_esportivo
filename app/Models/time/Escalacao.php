<?php
require_once __DIR__ . '/../../../config/database.php';

class Escalacao {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getConn() {
        return $this->conn;
    }

    public function salvar($dados) {
        if (empty($dados)) return false;

        $partida_id = (int)$dados[0]['partida_id'];

        $stmtDelete = $this->conn->prepare("DELETE FROM escalacoes WHERE partida_id = ?");
        $stmtDelete->bind_param("i", $partida_id);
        $stmtDelete->execute();

        foreach ($dados as $jogador) {
            $jogador_id = (int)$jogador['jogador_id'];
            $titular = (isset($jogador['titular']) && $jogador['titular'] == 1) ? 1 : 0;
            $capitao = isset($jogador['capitao']) && $jogador['capitao'] == 1 ? 1 : 0;

            $stmt = $this->conn->prepare("INSERT INTO escalacoes (partida_id, jogador_id, titular, capitao) VALUES (?, ?, ?, ?)");
            if (!$stmt) continue;

            $stmt->bind_param("iiii", $partida_id, $jogador_id, $titular, $capitao);
            $stmt->execute();
            $stmt->close();
        }

        return true;
    }
    public function buscarJogadoresDoTime($time_id) {
        $stmt = $this->conn->prepare("SELECT * FROM jogadores WHERE time_id = ?");
        $stmt->bind_param("i", $time_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function buscarEscalacaoPorPartida($partida_id) {
        $stmt = $this->conn->prepare("SELECT * FROM escalacoes WHERE partida_id = ?");
        $stmt->bind_param("i", $partida_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $escalacao = [];
        while ($row = $result->fetch_assoc()) {
            $escalacao[$row['jogador_id']] = $row;
        }
        return $escalacao;
    }
}