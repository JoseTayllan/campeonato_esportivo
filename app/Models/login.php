<?php
class Usuario {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function buscarPorEmail($email) {
        $query = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}