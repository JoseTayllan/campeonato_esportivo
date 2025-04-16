<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../Models/Rodada.php';

class RodadaController {
    private $rodadaModel;

    public function __construct($conn) {
        $this->rodadaModel = new Rodada($conn);
    }

    // Criar nova rodada
    public function criarRodada($fase_id, $numero, $tipo, $descricao) {
        if (empty($fase_id) || empty($numero) || empty($tipo)) {
            return "Preencha todos os campos obrigatórios.";
        }

        if ($this->rodadaModel->criar($fase_id, $numero, $tipo, $descricao)) {
            return "Rodada criada com sucesso!";
        } else {
            return "Erro ao criar a rodada.";
        }
    }

    // Listar rodadas por fase
    public function listarRodadas($fase_id) {
        if (empty($fase_id)) {
            return [];
        }

        return $this->rodadaModel->listarPorFase($fase_id);
    }
}