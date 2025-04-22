<?php 
class Team {
    private $conn;
    
    public function __construct($db) {
        $this->conn = $db;
    }

    public function criar($nome, $escudo, $cidade, $estadio, $admin_id) {
        // Geração única do código público
        $codigo_publico = 'T-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
    
        // Verificar se já existe (loop até encontrar um único)
        do {
            $verifica = $this->conn->prepare("SELECT id FROM times WHERE codigo_publico = ?");
            $verifica->bind_param("s", $codigo_publico);
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
        $stmt->bind_param("ssssss", $nome, $escudo, $cidade, $estadio, $admin_id, $codigo_publico);
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
        $stmt->bind_param("i", $time_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function inserirJogador($nome, $posicao, $idade, $nacionalidade, $time_id) {
        $sql = "INSERT INTO jogadores (nome, posicao, idade, nacionalidade, time_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssisi", $nome, $posicao, $idade, $nacionalidade, $time_id);
        return $stmt->execute();
    }
    
    
    public function atualizarJogador($id, $nome, $posicao, $idade, $nacionalidade) {
        $sql = "UPDATE jogadores SET nome = ?, posicao = ?, idade = ?, nacionalidade = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssisi", $nome, $posicao, $idade, $nacionalidade, $id);
        return $stmt->execute();
    }
    
    
    public function buscarJogadorPorId($id) {
        $sql = "SELECT * FROM jogadores WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    public function deletarJogador($id) {
        $sql = "DELETE FROM jogadores WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    public function buscarPorCodigoPublico($codigo) {
        $sql = "SELECT * FROM times WHERE codigo_publico = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $codigo);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    public function listarJogadoresDoTime($time_id) {
        $sql = "SELECT * FROM jogadores WHERE time_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $time_id);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    
    
    
    
}
?>
