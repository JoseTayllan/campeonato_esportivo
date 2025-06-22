<?php

require_once __DIR__ . '/../../Models/time/Time.php'; // mantém Team
require_once __DIR__ . '/../../Models/Jogador.php';
require_once __DIR__ . '/../../Models/time/JogadorTime.php';

class TeamController
{
    private $teamModel;
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->teamModel = new Team($conn);
    }

    // -------------------- TIME --------------------
    public function criarTime($nome, $escudo, $cidade, $estadio, $admin_id = null)
    {
        if (!$admin_id) {
            $admin_id = $_SESSION['usuario_id'] ?? null;
        }

        if ($admin_id && $this->teamModel->criar($nome, $escudo, $cidade, $estadio, $admin_id)) {
            return json_encode(["mensagem" => "Time criado com sucesso!"]);
        } else {
            return json_encode(["erro" => "Erro ao criar time."]);
        }
    }

    public function editarTime($id, $nome, $cidade, $escudo = null)
    {
        return $this->teamModel->editar($id, $nome, $cidade, $escudo);
    }

    public function listarMeusTimes($usuario_id = null)
    {
        if (!$usuario_id) {
            $usuario_id = $_SESSION['usuario_id'] ?? null;
        }
        return $this->teamModel->listarPorUsuario($usuario_id);
    }

    public function buscarTimePublico($codigo)
    {
        return $this->teamModel->buscarPorCodigoPublico($codigo);
    }

    public function buscarPatrocinadoresDoTime($time_id)
    {
        $sql = "SELECT p.nome_empresa, p.logo
                FROM patrocinadores p
                INNER JOIN patrocinador_time pt ON p.id = pt.patrocinador_id
                WHERE pt.time_id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $time_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // -------------------- JOGADORES --------------------
    public function adicionarJogador($nome, $posicao, $idade, $nacionalidade, $cpf, $data_nascimento, $time_id, $imagem = null)
    {
        $jogador = Player::buscarPorDados($this->conn, $nome, $idade, $nacionalidade);

        if (!$jogador) {
            $jogador_id = Player::cadastrar($this->conn, $nome, $idade, $nacionalidade, $posicao, $cpf, $data_nascimento, $imagem);
        } else {
            $jogador_id = $jogador['id'];
        }

        return JogadorTime::vincular($this->conn, $jogador_id, $time_id);
    }



    public function listarJogadoresDoMeuTime($time_id, $usuario_id)
    {
        require_once __DIR__ . '/../../Models/time/JogadorTime.php';
        return JogadorTime::listarPorTimeEUsuario($this->conn, $time_id, $usuario_id);
    }


    public function buscarJogador($id)
    {
        $player = new Player($this->conn);
        return $player->buscarPorId($id);
    }

    public function editarJogador($id, $nome, $posicao, $idade, $nacionalidade, $cpf = null, $data_nascimento = null, $imagem = null)
    {
        // 🔥 Buscar os dados atuais do jogador
        $jogador = $this->buscarJogador($id);

        if (!$jogador) {
            return false;
        }

        // 🔥 Se algum campo não foi enviado, usa o valor atual
        $imagem = (!empty($imagem)) ? $imagem : $jogador['imagem'];
        $cpf = (!empty($cpf)) ? $cpf : $jogador['cpf'];
        $data_nascimento = (!empty($data_nascimento)) ? $data_nascimento : $jogador['data_nascimento'];

        // 🔥 Executar o UPDATE
        $sql = "UPDATE jogadores 
            SET nome = ?, posicao = ?, idade = ?, nacionalidade = ?, cpf = ?, data_nascimento = ?, imagem = ?
            WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssissssi", $nome, $posicao, $idade, $nacionalidade, $cpf, $data_nascimento, $imagem, $id);
        return $stmt->execute();
    }




    public function excluirJogadorDoTime($jogador_id, $time_id)
    {
        return JogadorTime::desvincular($this->conn, $jogador_id, $time_id);
    }

    public function listarElencoPublico($time_id)
    {
        return JogadorTime::listarPorTime($this->conn, $time_id);
    }
  // Conquistas do jogador
public function listarConquistasJogador($jogador_id) {
    $resultados = [
        'artilheiro' => [],
        'goleiro' => [],
        'campeao' => []
    ];

    // 🔍 Recupera posição do jogador
    $stmt = $this->conn->prepare("SELECT posicao FROM jogadores WHERE id = ?");
    $stmt->bind_param("i", $jogador_id);
    $stmt->execute();
    $posicao = $stmt->get_result()->fetch_assoc()['posicao'] ?? null;

    // 🔹 Artilharia (somente se não for goleiro e tiver gols)
    if ($posicao !== 'Goleiro') {
        $sql = "SELECT c.nome AS campeonato, t.nome AS time, ha.gols
                FROM historico_artilheiros ha
                JOIN campeonatos c ON ha.campeonato_id = c.id
                JOIN times t ON ha.time_id = t.id
                WHERE ha.jogador_id = ? AND ha.gols > 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $jogador_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $resultados['artilheiro'] = $res->fetch_all(MYSQLI_ASSOC);
    }

    // 🔹 Goleiro menos vazado (somente se for goleiro)
    if ($posicao === 'Goleiro') {
        $sql = "SELECT c.nome AS campeonato, t.nome AS time, hg.gols_sofridos
                FROM historico_goleiros hg
                JOIN campeonatos c ON hg.campeonato_id = c.id
                JOIN times t ON hg.time_id = t.id
                WHERE hg.jogador_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $jogador_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $resultados['goleiro'] = $res->fetch_all(MYSQLI_ASSOC);
    }

    // 🔹 Campeonatos vencidos (sempre)
    $sql = "SELECT c.nome AS campeonato, t.nome AS time
            FROM historico_campeonatos hc
            JOIN campeonatos c ON c.id = hc.campeonato_id
            JOIN times t ON t.id = hc.time_id
            JOIN jogador_time jt ON jt.time_id = hc.time_id
            WHERE jt.jogador_id = ? AND jt.status = 'ativo'";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $jogador_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $resultados['campeao'] = $res->fetch_all(MYSQLI_ASSOC);

    return $resultados;
}




}
