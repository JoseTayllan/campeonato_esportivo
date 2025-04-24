<?php
class Patrocinador {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function criar($nome, $contrato, $valor, $logo) {
        $sql = "INSERT INTO patrocinadores (nome_empresa, contrato, valor_investido, logo) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssds", $nome, $contrato, $valor, $logo);
        return $stmt->execute();
    }

    public function listar() {
        $sql = "SELECT * FROM patrocinadores";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    
}
?>
