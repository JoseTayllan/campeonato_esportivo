<?php 
require_once __DIR__ . '/../../config/database.php';
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
   
    public function atualizarPerfil($id, $nome, $email, $senha = null) {
    if (!empty($senha)) {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "UPDATE usuarios SET nome = ?, email = ?, senha = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssi", $nome, $email, $senhaHash, $id);
    } else {
        $sql = "UPDATE usuarios SET nome = ?, email = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssi", $nome, $email, $id);
    }

    return $stmt->execute();
}

    public function buscarPorId($id) {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
 
}
?>