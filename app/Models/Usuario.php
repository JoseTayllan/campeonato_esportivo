<?php 
class User {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Verifica se o e-mail já está cadastrado
    public function emailExiste($email) {
        $query = "SELECT id FROM usuarios WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    // Cria o usuário apenas se o e-mail não existir
    public function criar($nome, $email, $senha, $tipo) {
        if ($this->emailExiste($email)) {
            return "E-mail já cadastrado.";
        }

        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $query = "INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssss", $nome, $email, $senhaHash, $tipo);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return "Erro ao inserir no banco de dados: " . $stmt->error;
        }
    }
}
?>