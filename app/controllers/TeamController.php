<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../Models/Time.php'; // MANTÉM Team

class TeamController {
    private $teamModel;

    public function __construct($conn) {
        $this->teamModel = new Team($conn); // MANTÉM Team
    }
    public function criarTime($nome, $escudo, $cidade, $estadio) {
        $admin_id = $_SESSION['usuario_id'] ?? null;
        if ($admin_id && $this->teamModel->criar($nome, $escudo, $cidade, $estadio, $admin_id)) {
            return json_encode(["mensagem" => "Time criado com sucesso!"]);
        } else {
            return json_encode(["erro" => "Erro ao criar time."]);
        }
    }
    

    // ✅ Integração correta do método de edição
    public function editarTime($id, $nome, $cidade, $escudo = null) {
        return $this->teamModel->editar($id, $nome, $cidade, $escudo);
    }

    public function listarJogadoresDoMeuTime($time_id) {
        return $this->teamModel->listarJogadores($time_id);
    }
    public function adicionarJogador($nome, $posicao, $idade, $nacionalidade, $time_id) {
        return $this->teamModel->inserirJogador($nome, $posicao, $idade, $nacionalidade, $time_id);
    }
    
    

    public function editarJogador($id, $nome, $posicao, $idade, $nacionalidade) {
        return $this->teamModel->atualizarJogador($id, $nome, $posicao, $idade, $nacionalidade);
    }
    
    
    public function buscarJogador($id) {
        return $this->teamModel->buscarJogadorPorId($id);
    }
    
    
    public function excluirJogador($id) {
        return $this->teamModel->deletarJogador($id);
    }

    public function buscarTimePublico($codigo) {
        return $this->teamModel->buscarPorCodigoPublico($codigo);
    }
    
    public function listarElencoPublico($time_id) {
        return $this->teamModel->listarJogadoresDoTime($time_id);
    }
    
    
    
    
}
?>
 