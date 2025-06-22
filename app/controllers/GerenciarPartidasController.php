<?php

class GerenciarPartidasController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

   public function listarPartidas() {
    $usuario_id = $_SESSION['usuario_id'] ?? 0;
    $tipo = $_SESSION['usuario']['tipo'] ?? '';

    $query = "
        SELECT 
            p.*, 
            t1.nome AS nome_casa, 
            t2.nome AS nome_fora,
            c.nome AS campeonato_nome,
            c.id AS campeonato_id
        FROM partidas p
        JOIN rodadas r ON p.rodada_id = r.id
        JOIN fases_campeonato f ON r.fase_id = f.id
        JOIN campeonatos c ON f.campeonato_id = c.id
        JOIN times t1 ON p.time_casa = t1.id
        JOIN times t2 ON p.time_fora = t2.id
        WHERE 
    ";

    if ($tipo === 'Administrador') {
        $query .= "c.criado_por = ?";
    } elseif ($tipo === 'Organizador') {
        $query .= "c.criado_por = (SELECT criado_por FROM usuarios WHERE id = ?)";
    } else {
        return [];
    }

    $query .= " ORDER BY c.id DESC, p.data DESC, p.horario DESC";

    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
    public function alterarStatus($partida_id, $status) {
        if ($status === 'em_andamento') {
           date_default_timezone_set('America/Sao_Paulo'); // garante timezone correto no NOW()
           $stmt = $this->conn->prepare("UPDATE partidas SET status = ?, inicio_partida = NOW(), cronometro_status = 'rodando' WHERE id = ?");
        } else {
           $stmt = $this->conn->prepare("UPDATE partidas SET status = ? WHERE id = ?");
        }
        $stmt->bind_param("si", $status, $partida_id);
        $stmt->execute();
    }
    
}
