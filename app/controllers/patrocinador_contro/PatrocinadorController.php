<?php
require_once __DIR__ . '/../../Models/patrocinador/Patrocinador.php';
require_once __DIR__ . '/../../Models/patrocinador/PatrocinadorTime.php';

class PatrocinadorController {
    private $conn;
    private $patrocinadorModel;
    private $patrocinadorTimeModel;

    public function __construct($db) {
        $this->conn = $db;
        $this->patrocinadorModel = new Patrocinador($db);
        $this->patrocinadorTimeModel = new PatrocinadorTime($db);
    }

    public function buscarPorUsuario($usuario_id) {
        $stmt = $this->conn->prepare("SELECT id, nome_empresa, logo FROM patrocinadores WHERE usuario_id = ?");
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function obterTimesPatrocinados($patrocinador_id) {
        $sql = "
    SELECT 
        t.id, t.nome, t.cidade, t.estadio,
        pt.valor_investido, pt.data_fim AS validade_contrato,
        p.logo
    FROM times t
    INNER JOIN patrocinador_time pt ON t.id = pt.time_id
    INNER JOIN patrocinadores p ON pt.patrocinador_id = p.id
    WHERE pt.patrocinador_id = ?
";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $patrocinador_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function calcularEstatisticas($time_id) {
        $sql = "
            SELECT placar_casa, placar_fora, time_casa, time_fora
            FROM partidas
            WHERE time_casa = ? OR time_fora = ?
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $time_id, $time_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $jogos = $vitorias = $empates = $derrotas = $gols_pro = $gols_contra = 0;

        while ($jogo = $result->fetch_assoc()) {
            $jogos++;
            if ($jogo['time_casa'] == $time_id) {
                $gols_pro += $jogo['placar_casa'];
                $gols_contra += $jogo['placar_fora'];
                if ($jogo['placar_casa'] > $jogo['placar_fora']) $vitorias++;
                elseif ($jogo['placar_casa'] == $jogo['placar_fora']) $empates++;
                else $derrotas++;
            } else {
                $gols_pro += $jogo['placar_fora'];
                $gols_contra += $jogo['placar_casa'];
                if ($jogo['placar_fora'] > $jogo['placar_casa']) $vitorias++;
                elseif ($jogo['placar_fora'] == $jogo['placar_casa']) $empates++;
                else $derrotas++;
            }
        }

        $pontos = ($vitorias * 3) + $empates;
        $disputados = $jogos * 3;
        $aproveitamento = $disputados > 0 ? round(($pontos / $disputados) * 100, 2) : 0;

        return [
            'jogos' => $jogos,
            'vitorias' => $vitorias,
            'empates' => $empates,
            'derrotas' => $derrotas,
            'gols_pro' => $gols_pro,
            'gols_contra' => $gols_contra,
            'saldo' => $gols_pro - $gols_contra,
            'media_gols' => $jogos > 0 ? round($gols_pro / $jogos, 2) : 0,
            'aproveitamento' => $aproveitamento
        ];
    }

    public function desvincularTime($patrocinador_id, $time_id) {
        return $this->patrocinadorTimeModel->desvincular($patrocinador_id, $time_id);
    }
}
