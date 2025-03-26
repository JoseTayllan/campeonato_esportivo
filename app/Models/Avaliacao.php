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
        $stmt->bind_param("iiiiiiss", $jogador_id, $olheiro_id, $forca, $velocidade, $drible, $finalizacao, $nota_geral, $observacoes);
        return $stmt->execute();
    }
}
?>
