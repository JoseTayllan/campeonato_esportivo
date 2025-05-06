<?php
require_once __DIR__ . '/../../Models/avaliar/Jogador.php';

class AvaliarJogadorController {
    public function listarJogadores() {
        return Jogador::buscarTodos();
    }

    public function avaliar($post, $olheiro_id) {
        if (!$olheiro_id || $olheiro_id <= 0) {
            throw new Exception("Olheiro não autenticado.");
        }

        $dados = [
            'jogador_id'   => (int) $post['jogador_id'],
            'olheiro_id'   => (int) $olheiro_id,
            'forca'        => (int) $post['forca'],
            'velocidade'   => (int) $post['velocidade'],
            'drible'       => (int) $post['drible'],
            'finalizacao'  => (int) $post['finalizacao'],
            'nota_geral'   => (float) $post['nota_geral'],
            'observacoes'  => $post['observacoes'] ?? null,
        ];

        Jogador::salvarAvaliacao($dados);
    }
}
