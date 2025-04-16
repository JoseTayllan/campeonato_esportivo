
<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../Models/FaseCampeonato.php';

class FaseController {
    private $faseModel;

    public function __construct($conn) {
        $this->faseModel = new FaseCampeonato($conn);
    }

    // Criar nova fase
    public function criarFase($campeonato_id, $nome, $ordem) {
        if (empty($campeonato_id) || empty($nome) || empty($ordem)) {
            return "Todos os campos são obrigatórios.";
        }

        if ($this->faseModel->criar($campeonato_id, $nome, $ordem)) {
            return "Fase criada com sucesso!";
        } else {
            return "Erro ao criar a fase.";
        }
    }

    // Listar fases por campeonato
    public function listarFases($campeonato_id) {
        if (empty($campeonato_id)) {
            return [];
        }

        return $this->faseModel->listarPorCampeonato($campeonato_id);
    }
}
