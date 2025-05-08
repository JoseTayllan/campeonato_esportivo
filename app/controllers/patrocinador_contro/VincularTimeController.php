<?php
require_once __DIR__ . '/../../Models/patrocinador/PatrocinadorTime.php';

class VincularTimeController {
    private $conn;
    private $model;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->model = new PatrocinadorTime($conn);
    }

    public function buscarTimesDisponiveis($usuario_id) {
        $stmt = $this->conn->prepare("SELECT id FROM patrocinadores WHERE usuario_id = ?");
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $patro = $res->fetch_assoc();

        if (!isset($patro['id'])) {
            return []; // erro seguro
        }

        $patro_id = $patro['id'];

        $sql = "
            SELECT t.id, t.nome, t.cidade
            FROM times t
            WHERE t.id NOT IN (
                SELECT time_id FROM patrocinador_time WHERE patrocinador_id = ?
            )
            ORDER BY t.nome
        ";
        $stmt2 = $this->conn->prepare($sql);
        $stmt2->bind_param("i", $patro_id);
        $stmt2->execute();
        $result = $stmt2->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function vincular($usuario_id, $post) {
        $time_id = $post['time_id'];
        $valor = $post['valor_investido'];
        $ano = $post['ano_contrato'];
    
        $stmt = $this->conn->prepare("SELECT id FROM patrocinadores WHERE usuario_id = ?");
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $patro = $res->fetch_assoc();
    
        if (!$patro) return false;
    
        $data_inicio = date('Y-m-d');
        $data_fim = "$ano-12-31";
    
        return $this->model->vincular($patro['id'], $time_id, $data_inicio, $data_fim, $valor);
    }
    
}
