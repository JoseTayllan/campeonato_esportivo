<?php
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
        $stmtDelete->bindValue(1, $partida_id, PDO::PARAM_INT);
        $stmtDelete->execute();

        foreach ($dados as $jogador) {
            $jogador_id = (int)$jogador['jogador_id'];
            $titular = (isset($jogador['titular']) && $jogador['titular'] == 1) ? 1 : 0;
            $capitao = isset($jogador['capitao']) && $jogador['capitao'] == 1 ? 1 : 0;

            $stmt = $this->conn->prepare("INSERT INTO escalacoes (partida_id, jogador_id, titular, capitao) VALUES (?, ?, ?, ?)");
            if (!$stmt) continue;

            $stmt->bindValue(1, $partida_id, PDO::PARAM_INT);
    $stmt->bindValue(2, $jogador_id, PDO::PARAM_INT);
    $stmt->bindValue(3, $titular, PDO::PARAM_INT);
    $stmt->bindValue(4, $capitao, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->close();
        }

        return true;
    }
    public function buscarJogadoresDoTime($time_id) {
        $stmt = $this->conn->prepare("SELECT * FROM jogadores WHERE time_id = ?");
        $stmt->bindValue(1, $time_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->get_result()->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarEscalacaoPorPartida($partida_id) {
        $stmt = $this->conn->prepare("SELECT * FROM escalacoes WHERE partida_id = ?");
        $stmt->bindValue(1, $partida_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->get_result();

        $escalacao = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $escalacao[$row['jogador_id']] = $row;
        }
        return $escalacao;
    }
}