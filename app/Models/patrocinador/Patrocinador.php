<?php
require_once __DIR__ . '/../../../config/database.php';
class Patrocinador {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function criar($nome, $contrato, $telefone, $logo, $usuario_id) {
        $sql = "INSERT INTO patrocinadores (nome_empresa, contrato, telefone, logo, usuario_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssi", $nome, $contrato, $telefone, $logo, $usuario_id);
        return $stmt->execute();
    }

    public function listar() {
        $sql = "SELECT * FROM patrocinadores";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function buscarPorUsuarioId($usuario_id) {
        $stmt = $this->conn->prepare("SELECT id FROM patrocinadores WHERE usuario_id = ?");
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    public function atualizarLogoPorUsuario($usuario_id, $logo_path) {
        $sql = "UPDATE patrocinadores SET logo = ? WHERE usuario_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $logo_path, $usuario_id);
        return $stmt->execute();
    }
    
}
?>
