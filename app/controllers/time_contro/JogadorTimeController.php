<?php

require_once __DIR__ . '/../../Models/time/JogadorTime.php';

class JogadorTimeController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function vincular($jogador_id, $time_id) {
        // 🔄 Desativa vínculos anteriores
        $stmt = $this->conn->prepare("UPDATE jogador_time SET status = 'inativo' WHERE jogador_id = ?");
        $stmt->bind_param("i", $jogador_id);
        $stmt->execute();

        // 🔗 Cria novo vínculo ativo
        $stmt = $this->conn->prepare("INSERT INTO jogador_time (jogador_id, time_id, status) VALUES (?, ?, 'ativo')");
        $stmt->bind_param("ii", $jogador_id, $time_id);
        return $stmt->execute();
    }

    public function desvincular($jogador_id, $time_id) {
        return JogadorTime::desvincular($this->conn, $jogador_id, $time_id);
    }

    public function listarPorTimeEUsuario($time_id, $usuario_id) {
        return JogadorTime::listarPorTimeEUsuario($this->conn, $time_id, $usuario_id);
    }

    public function listarPorTime($time_id) {
        return JogadorTime::listarPorTime($this->conn, $time_id);
    }

}
