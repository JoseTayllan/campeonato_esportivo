<?php
require_once __DIR__ . '/../Models/Jogador.php';
require_once __DIR__ . '/../Models/Estatistica.php';

class JogadorPublicoController {
    public static function exibir($conn, $id) {
        $jogadorModel = new Player($conn);
        $estatisticasModel = new Estatistica($conn);

        $jogador = $jogadorModel->buscarPorId($id);
        if (!$jogador) {
            echo "Jogador não encontrado.";
            return;
        }

        $estatisticas = $estatisticasModel->listarPorJogador($id);
        $historico = $estatisticasModel->historicoPartidas($id);
        $notaMediaEstatistica = $estatisticasModel->calcularNotaMediaPorEstatistica($id);

        include __DIR__ . '/../../public/views/public/jogador.php';
    }
}
