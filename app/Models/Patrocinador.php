<?php
class Patrocinador {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function criar($nome, $contrato, $valor, $logo) {
        $sql = "INSERT INTO patrocinadores (nome_empresa, contrato, valor_investido, logo) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $nome, PDO::PARAM_STR);
    $stmt->bindValue(2, $contrato, PDO::PARAM_STR);
    $stmt->bindValue(3, $valor, PDO::PARAM_STR);
    $stmt->bindValue(4, $logo, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function listar() {
        $sql = "SELECT * FROM patrocinadores";
        $result = $this->conn->query($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    
}
?>
