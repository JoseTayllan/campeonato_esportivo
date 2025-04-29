<?php 
class Player {
    private $conn;
    
    public function __construct($db) {
        $this->conn = $db;
    }

    public function criar($nome, $idade, $nacionalidade, $posicao, $time_id, $imagem = null) {
        $query = "INSERT INTO jogadores (nome, idade, nacionalidade, posicao, time_id, imagem) 
                  VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sissis", $nome, $idade, $nacionalidade, $posicao, $time_id, $imagem);
        return $stmt->execute();
    }

    public function buscarPorId($id) {
        $query = "SELECT j.*, t.escudo FROM jogadores j LEFT JOIN times t ON j.time_id = t.id WHERE j.id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function listarPorTimeEUsuario($time_id, $usuario_id) {
        $query = "
            SELECT jogadores.* 
            FROM jogadores
            INNER JOIN times ON jogadores.time_id = times.id
            WHERE jogadores.time_id = ? AND times.admin_id = ?
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $time_id, $usuario_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>
