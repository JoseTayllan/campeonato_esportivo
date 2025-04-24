<?php
require_once __DIR__ . '/../Models/Patrocinador.php';
require_once __DIR__ . '/../Models/PatrocinadorTime.php';

class PatrocinadorController {
    private $conn;
    private $patrocinadorModel;
    private $patrocinadorTimeModel;

    public function __construct($db) {
        $this->conn = $db;
        $this->patrocinadorModel = new Patrocinador($db);
        $this->patrocinadorTimeModel = new PatrocinadorTime($db);
    }

    public function obterTimesPatrocinados($patrocinador_id) {
        $sql = "SELECT t.id, t.nome, t.cidade, t.estadio
                FROM times t
                INNER JOIN patrocinador_time pt ON t.id = pt.time_id
                WHERE pt.patrocinador_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $patrocinador_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function obterDesempenhoTime($time_id) {
        // Jogos que o time participou
        $sql = "
            SELECT 
                p.id,
                p.placar_casa, p.placar_fora,
                p.time_casa, p.time_fora
            FROM partidas p
            WHERE p.time_casa = ? OR p.time_fora = ?
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $time_id, $time_id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $jogos = 0;
        $vitorias = 0;
        $empates = 0;
        $derrotas = 0;
        $gols_pro = 0;
        $gols_contra = 0;
    
        while ($row = $result->fetch_assoc()) {
            $jogos++;
    
            if ($row['time_casa'] == $time_id) {
                $gols_pro += $row['placar_casa'];
                $gols_contra += $row['placar_fora'];
    
                if ($row['placar_casa'] > $row['placar_fora']) $vitorias++;
                elseif ($row['placar_casa'] == $row['placar_fora']) $empates++;
                else $derrotas++;
            } else {
                $gols_pro += $row['placar_fora'];
                $gols_contra += $row['placar_casa'];
    
                if ($row['placar_fora'] > $row['placar_casa']) $vitorias++;
                elseif ($row['placar_fora'] == $row['placar_casa']) $empates++;
                else $derrotas++;
            }
        }
    
        $pontos = ($vitorias * 3) + ($empates);
        $pontos_disputados = $jogos * 3;
        $aproveitamento = $pontos_disputados > 0 ? round(($pontos / $pontos_disputados) * 100, 2) : 0;
        $saldo = $gols_pro - $gols_contra;
        $media_gols = $jogos > 0 ? round($gols_pro / $jogos, 2) : 0;
    
        return [
            'jogos' => $jogos,
            'vitorias' => $vitorias,
            'empates' => $empates,
            'derrotas' => $derrotas,
            'gols_pro' => $gols_pro,
            'gols_contra' => $gols_contra,
            'saldo' => $saldo,
            'media_gols' => $media_gols,
            'aproveitamento' => $aproveitamento
        ];
    }

    
    
}
