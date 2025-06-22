<?php
require_once __DIR__ . '/../../Models/Campeonato.php';
require_once __DIR__ . '/../../Models/Estatistica.php';

class DashboardCampeaoController {

    public function dadosCampeonato($campeonato_id) {
        global $conn;
        $campeonato = new Campeonato($conn);
        return $campeonato->buscarPorId($campeonato_id);
    }

    public function dadosTimeCampeao($time_id) {
        global $conn;
        $sql = "SELECT * FROM times WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $time_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function estatisticasTime($campeonato_id, $time_id) {
        global $conn;
        $estatistica = new Estatistica($conn);
        return $estatistica->estatisticasTimePorCampeonato($campeonato_id, $time_id);
    }

    public function artilheiros($campeonato_id, $limite = 5) {
        global $conn;
        $estatistica = new Estatistica($conn);
        return $estatistica->listarArtilheirosPorCampeonato($campeonato_id, $limite);
    }
}
