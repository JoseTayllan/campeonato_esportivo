<?php
require_once __DIR__ . '/../../Models/avaliar/Avaliacao.php';

class VisualizarAvaliacoesController {
    public function getDadosParaVisualizacao($filtros) {
        return [
            'avaliacoes' => Avaliacao::listarAvaliacoes($filtros),
            'jogadores'  => Avaliacao::listarJogadores(),
            'olheiros'   => Avaliacao::listarOlheiros(),
        ];
    }
}
