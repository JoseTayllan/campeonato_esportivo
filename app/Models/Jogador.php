<?php 
class Player {
    private $conn;
    
    public function __construct($db) {
        $this->conn = $db;
    }

    public function criar($nome, $idade, $nacionalidade, $posicao,  $imagem = null) {
        $query = "INSERT INTO jogadores (nome, idade, nacionalidade, posicao,  imagem) 
                  VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sissis", $nome, $idade, $nacionalidade, $posicao, $imagem);
        return $stmt->execute();
    }


   public function listarPorTimeEUsuario($time_id, $usuario_id) {
    $query = "
        SELECT j.* 
        FROM jogador_time jt
        INNER JOIN jogadores j ON jt.jogador_id = j.id
        INNER JOIN times t ON jt.time_id = t.id
        WHERE jt.time_id = ? AND t.admin_id = ? AND jt.status = 'ativo'
    ";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("ii", $time_id, $usuario_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
public static function buscarPorDados($conn, $nome, $idade, $nacionalidade) {
    $sql = "SELECT * FROM jogadores WHERE nome = ? AND idade = ? AND nacionalidade = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sis", $nome, $idade, $nacionalidade);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}


   public static function cadastrar($conn, $nome, $idade, $nacionalidade, $posicao, $cpf = null, $data_nascimento = null, $imagem = null) {
    $sql = "INSERT INTO jogadores (nome, idade, nacionalidade, posicao, cpf, data_nascimento, imagem) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisssss", $nome, $idade, $nacionalidade, $posicao, $cpf, $data_nascimento, $imagem);
    $stmt->execute();
    return $stmt->insert_id;
}

public function buscarPorId($id) {
    $sql = "SELECT * FROM jogadores WHERE id = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}



}
?>
