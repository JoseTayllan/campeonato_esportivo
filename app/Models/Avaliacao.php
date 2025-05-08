<?php
class Avaliacao {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function criar($jogador_id, $olheiro_id, $forca = null, $velocidade = null, $drible = null, 
                          $finalizacao = null, $nota_geral = null, $observacoes = null) {
        $query = "INSERT INTO avaliacoes (jogador_id, olheiro_id, forca, velocidade, drible, finalizacao, nota_geral, observacoes) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $jogador_id, PDO::PARAM_INT);
    $stmt->bindValue(2, $olheiro_id, PDO::PARAM_INT);
    $stmt->bindValue(3, $forca, PDO::PARAM_INT);
    $stmt->bindValue(4, $velocidade, PDO::PARAM_INT);
    $stmt->bindValue(5, $drible, PDO::PARAM_INT);
    $stmt->bindValue(6, $finalizacao, PDO::PARAM_INT);
    $stmt->bindValue(7, $nota_geral, PDO::PARAM_STR);
    $stmt->bindValue(8, $observacoes, PDO::PARAM_STR);
        return $stmt->execute();
    }
}
?>
