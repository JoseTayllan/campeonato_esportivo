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
        $stmt->bindValue(1, $nome, PDO::PARAM_STR);
    $stmt->bindValue(2, $idade, PDO::PARAM_INT);
    $stmt->bindValue(3, $nacionalidade, PDO::PARAM_STR);
    $stmt->bindValue(4, $posicao, PDO::PARAM_STR);
    $stmt->bindValue(5, $time_id, PDO::PARAM_INT);
    $stmt->bindValue(6, $imagem, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function buscarPorId($id) {
        $query = "SELECT j.*, t.escudo FROM jogadores j LEFT JOIN times t ON j.time_id = t.id WHERE j.id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public function listarPorTimeEUsuario($time_id, $usuario_id) {
        $query = "
            SELECT jogadores.* 
            FROM jogadores
            INNER JOIN times ON jogadores.time_id = times.id
            WHERE jogadores.time_id = ? AND times.admin_id = ?
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $time_id, PDO::PARAM_INT);
    $stmt->bindValue(2, $usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->get_result()->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
