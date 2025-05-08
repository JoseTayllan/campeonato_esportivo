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
        $stmt->bindValue(1, $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function criarUsuario($nome, $email, $senha_hash, $tipo, $tipo_assinatura) {
        $sql = "INSERT INTO usuarios (nome, email, senha, tipo, tipo_assinatura) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $nome, PDO::PARAM_STR);
        $stmt->bindValue(2, $email, PDO::PARAM_STR);
        $stmt->bindValue(3, $senha_hash, PDO::PARAM_STR);
        $stmt->bindValue(4, $tipo, PDO::PARAM_STR);
        $stmt->bindValue(5, $tipo_assinatura, PDO::PARAM_STR);
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
        $stmt->bindValue(1, $nome, PDO::PARAM_STR);
        $stmt->bindValue(2, $email, PDO::PARAM_STR);
        $stmt->bindValue(3, $senhaHash, PDO::PARAM_STR);
        $stmt->bindValue(4, $tipo, PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            return true;
        } else {
            $error = $stmt->errorInfo();
            return "Erro ao inserir no banco de dados: " . ($error[2] ?? "Desconhecido");
        }
    }
    
    public function listarTodos() {
        $sql = "SELECT * FROM usuarios ORDER BY nome ASC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>