<?php

class JogadorTime {

    public static function vincular($conn, $jogador_id, $time_id) {
        $sql = "INSERT INTO jogador_time (jogador_id, time_id, data_entrada, status) 
                VALUES (?, ?, NOW(), 'ativo')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $jogador_id, $time_id);
        return $stmt->execute();
    }

    public static function desvincular($conn, $jogador_id, $time_id) {
        $sql = "UPDATE jogador_time 
                SET status = 'inativo', data_saida = NOW() 
                WHERE jogador_id = ? AND time_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $jogador_id, $time_id);
        return $stmt->execute();
    }

   public static function listarPorTimeEUsuario($conn, $time_id, $usuario_id) {
    $sql = "SELECT j.* 
            FROM jogador_time jt
            INNER JOIN jogadores j ON jt.jogador_id = j.id
            INNER JOIN times t ON jt.time_id = t.id
            WHERE jt.time_id = ? AND t.admin_id = ? AND jt.status = 'ativo'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $time_id, $usuario_id);
    $stmt->execute();
    return $stmt->get_result(); // 🔥 IMPORTANTE → retorna objeto
}


    public static function listarPorTime($conn, $time_id) {
        $sql = "SELECT j.* 
                FROM jogador_time jt
                INNER JOIN jogadores j ON jt.jogador_id = j.id
                WHERE jt.time_id = ? AND jt.status = 'ativo'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $time_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    } 

}
?>
