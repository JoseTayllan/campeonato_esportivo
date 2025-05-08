<?php

class AgendaTimeController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function buscarPartidasDoMeuTime($admin_id) {
        // Busca o ID do time vinculado ao usuário logado
        $stmt = $this->conn->prepare("SELECT id FROM times WHERE admin_id = ?");
        $stmt->bindValue(1, $admin_id, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->get_result();
        $time = $res->fetch(PDO::FETCH_ASSOC);

        if (!$time) return [];

        $time_id = $time['id'];

        // Busca partidas em que o time participa
        $sql = "SELECT p.id, p.data, p.horario, p.local, 
                       p.placar_casa, p.placar_fora, p.status,
                       t1.nome AS nome_casa, t1.escudo AS logo_casa, 
                       t2.nome AS nome_fora, t2.escudo AS logo_fora 
                FROM partidas p
                JOIN times t1 ON p.time_casa = t1.id
                JOIN times t2 ON p.time_fora = t2.id
                WHERE p.time_casa = ? OR p.time_fora = ?
                ORDER BY p.data ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $time_id, PDO::PARAM_INT);
    $stmt->bindValue(2, $time_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->get_result();
    }
}
