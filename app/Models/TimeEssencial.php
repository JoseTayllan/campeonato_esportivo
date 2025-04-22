<?php 
class TimeEssencial {
    private $conn;
    private $admin_id;

    public function __construct($db, $admin_id) {
        $this->conn = $db;
        $this->admin_id = $admin_id;
    }

    public function getMeuTime() {
        $sql = "SELECT * FROM times WHERE admin_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$this->admin_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function criarTime($nome, $cidade, $escudo) {
        $sql = "INSERT INTO times (nome, cidade, escudo, admin_id, codigo_publico) VALUES (?, ?, ?, ?, ?)";
        $codigo = 'T-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$nome, $cidade, $escudo, $this->admin_id, $codigo]);
    }
    public function getJogadoresDoTime($time_id) {
        $sql = "SELECT * FROM jogadores WHERE time_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$time_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function atualizarTime($id, $nome, $cidade, $escudo = null) {
        if ($escudo) {
            $sql = "UPDATE times SET nome = ?, cidade = ?, escudo = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$nome, $cidade, $escudo, $id]);
        } else {
            $sql = "UPDATE times SET nome = ?, cidade = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$nome, $cidade, $id]);
        }
    }
    
}?>