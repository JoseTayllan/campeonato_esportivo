<?php 
class Team {
    private $conn;
    
    public function __construct($db) {
        $this->conn = $db;
    }

    public function criar($nome, $escudo, $cidade, $estadio, $admin_id) {
        $codigo_publico = 'T-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

        do {
            $verifica = $this->conn->prepare("SELECT id FROM times WHERE codigo_publico = ?");
            $verifica->bindValue(1, $codigo_publico, PDO::PARAM_STR);
            $verifica->execute();
            $resultado = $verifica->get_result();
            $existe = $resultado->num_rows > 0;
            if ($existe) {
                $codigo_publico = 'T-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            }
        } while ($existe);

        $sql = "INSERT INTO times (nome, escudo, cidade, estadio, admin_id, codigo_publico)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $nome, PDO::PARAM_STR);
    $stmt->bindValue(2, $escudo, PDO::PARAM_STR);
    $stmt->bindValue(3, $cidade, PDO::PARAM_STR);
    $stmt->bindValue(4, $estadio, PDO::PARAM_STR);
    $stmt->bindValue(5, $admin_id, PDO::PARAM_STR);
    $stmt->bindValue(6, $codigo_publico, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function editar($id, $nome, $cidade, $escudo = null) {
        try {
            if ($escudo) {
                $sql = "UPDATE times SET nome = ?, cidade = ?, escudo = ? WHERE id = ?";
                $stmt = $this->conn->prepare($sql);
                return $stmt->execute([$nome, $cidade, $escudo, $id]);
            } else {
                $sql = "UPDATE times SET nome = ?, cidade = ? WHERE id = ?";
                $stmt = $this->conn->prepare($sql);
                return $stmt->execute([$nome, $cidade, $id]);
            }
        } catch (PDOException $e) {
            return false;
        }
    }

    public function listarJogadores($time_id) {
        $sql = "SELECT * FROM jogadores WHERE time_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $time_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function inserirJogador($nome, $posicao, $idade, $nacionalidade, $time_id, $imagem = null) {
        $sql = "INSERT INTO jogadores (nome, posicao, idade, nacionalidade, time_id, imagem) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $nome, PDO::PARAM_STR);
    $stmt->bindValue(2, $posicao, PDO::PARAM_STR);
    $stmt->bindValue(3, $idade, PDO::PARAM_INT);
    $stmt->bindValue(4, $nacionalidade, PDO::PARAM_STR);
    $stmt->bindValue(5, $time_id, PDO::PARAM_INT);
    $stmt->bindValue(6, $imagem, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function atualizarJogador($id, $nome, $posicao, $idade, $nacionalidade, $imagem = null) {
        if ($imagem) {
            $sql = "UPDATE jogadores SET nome = ?, posicao = ?, idade = ?, nacionalidade = ?, imagem = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(1, $nome, PDO::PARAM_STR);
    $stmt->bindValue(2, $posicao, PDO::PARAM_STR);
    $stmt->bindValue(3, $idade, PDO::PARAM_INT);
    $stmt->bindValue(4, $nacionalidade, PDO::PARAM_STR);
    $stmt->bindValue(5, $imagem, PDO::PARAM_STR);
    $stmt->bindValue(6, $id, PDO::PARAM_INT);
        } else {
            $sql = "UPDATE jogadores SET nome = ?, posicao = ?, idade = ?, nacionalidade = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(1, $nome, PDO::PARAM_STR);
    $stmt->bindValue(2, $posicao, PDO::PARAM_STR);
    $stmt->bindValue(3, $idade, PDO::PARAM_INT);
    $stmt->bindValue(4, $nacionalidade, PDO::PARAM_STR);
    $stmt->bindValue(5, $id, PDO::PARAM_INT);
        }
    
        return $stmt->execute();
    }

    public function buscarJogadorPorId($id) {
        $sql = "SELECT * FROM jogadores WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->get_result()->fetch(PDO::FETCH_ASSOC);
    }

    public function deletarJogador($id) {
        $sql = "DELETE FROM jogadores WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function buscarPorCodigoPublico($codigo) {
        $sql = "SELECT * FROM times WHERE codigo_publico = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $codigo, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->get_result()->fetch(PDO::FETCH_ASSOC);
    }

    public function listarJogadoresDoTime($time_id) {
        $sql = "SELECT * FROM jogadores WHERE time_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $time_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->get_result();
    }

    // 🔥 NOVA FUNÇÃO adicionada (sem alterar o que você já tinha):
    public function listarPorUsuario($usuario_id) {
        $sql = "SELECT * FROM times WHERE admin_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->get_result()->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
