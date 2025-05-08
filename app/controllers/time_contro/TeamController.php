<?php

require_once __DIR__ . '/../../Models/time/Time.php'; // mantém Team

class TeamController {
    private $teamModel;
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->teamModel = new Team($conn);
    }

    public function criarTime($nome, $escudo, $cidade, $estadio, $admin_id = null) {
        if (!$admin_id) {
            $admin_id = $_SESSION['usuario_id'] ?? null;
        }

        if ($admin_id && $this->teamModel->criar($nome, $escudo, $cidade, $estadio, $admin_id)) {
            return json_encode(["mensagem" => "Time criado com sucesso!"]);
        } else {
            return json_encode(["erro" => "Erro ao criar time."]);
        }
    }

    public function editarTime($id, $nome, $cidade, $escudo = null) {
        return $this->teamModel->editar($id, $nome, $cidade, $escudo);
    }

    public function listarJogadoresDoMeuTime($time_id) {
        return $this->teamModel->listarJogadores($time_id);
    }

    public function adicionarJogador($nome, $posicao, $idade, $nacionalidade, $time_id, $imagem = null) {
        return $this->teamModel->inserirJogador($nome, $posicao, $idade, $nacionalidade, $time_id, $imagem);
    }

    public function editarJogador($id, $nome, $posicao, $idade, $nacionalidade, $imagem = null) {
        return $this->teamModel->atualizarJogador($id, $nome, $posicao, $idade, $nacionalidade, $imagem);
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

    public function listarMeusTimes($usuario_id = null) {
        if (!$usuario_id) {
            $usuario_id = $_SESSION['usuario_id'] ?? null;
        }
        return $this->teamModel->listarPorUsuario($usuario_id);
    }

    public function buscarPatrocinadoresDoTime($time_id) {
        $sql = "SELECT p.nome_empresa, p.logo
                FROM patrocinadores p
                INNER JOIN patrocinador_time pt ON p.id = pt.patrocinador_id
                WHERE pt.time_id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $time_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
