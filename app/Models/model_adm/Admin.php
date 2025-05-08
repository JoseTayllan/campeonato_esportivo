<?php
require_once __DIR__ . '/../../../config/database.php';

class Admin {
    public static function obterResumoPorUsuario($admin_id) {
        global $conn;
        $resumo = [
            'Campeonatos' => 0,
            'Times' => 0,
            'Jogadores' => 0
        ];

        // Campeonatos criados por esse admin
        $sql = "SELECT id FROM campeonatos WHERE criado_por = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $admin_id);
        $stmt->execute();
        $res = $stmt->get_result();

        $campeonato_ids = [];
        while ($row = $res->fetch_assoc()) {
            $campeonato_ids[] = $row['id'];
        }

        if (empty($campeonato_ids)) return $resumo;

        $in = implode(',', $campeonato_ids);

        $resumo['Campeonatos'] = count($campeonato_ids);

        // Contar times associados a esses campeonatos
        $q1 = $conn->query("SELECT COUNT(DISTINCT time_id) as total FROM times_campeonatos WHERE campeonato_id IN ($in)");
        $resumo['Times'] = $q1->fetch_assoc()['total'] ?? 0;

        // Contar jogadores dos times associados
        $q2 = $conn->query("SELECT COUNT(*) as total FROM jogadores WHERE time_id IN (
            SELECT DISTINCT time_id FROM times_campeonatos WHERE campeonato_id IN ($in)
        )");
        $resumo['Jogadores'] = $q2->fetch_assoc()['total'] ?? 0;

        return $resumo;
    }

    public static function listarCampeonatosPorUsuario($admin_id) {
        global $conn;
        $stmt = $conn->prepare("SELECT id, nome, temporada, formato, criado_em FROM campeonatos WHERE criado_por = ? ORDER BY id DESC");
        $stmt->bind_param("i", $admin_id);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_all(MYSQLI_ASSOC);
    }
}
