<?php 
class Usuario {
    private $conn;
    public function __construct($db) {
        $this->conn = $db;
    }
    public function criar($nome, $email, $senha, $tipo) {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $query = "INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssss", $nome, $email, $senhaHash, $tipo);
        return $stmt->execute();
    }
}

?>