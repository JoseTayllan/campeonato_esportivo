<?php 
class User {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Verifica se o e-mail já está cadastrado
   
    public function emailExiste($email) {
        $sql = "SELECT id FROM usuarios WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    public function criarUsuario($nome, $email, $senha_hash, $tipo, $tipo_assinatura) {
        $sql = "INSERT INTO usuarios (nome, email, senha, tipo, tipo_assinatura) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssss", $nome, $email, $senha_hash, $tipo, $tipo_assinatura);
        return $stmt->execute();
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
    public function listarTodos() {
        $sql = "SELECT * FROM usuarios ORDER BY nome ASC";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

 
}
?>