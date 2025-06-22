<?php

class SumulaPartidaController
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function carregarDados($partida_id)
{
    // 🟢 Carrega a partida
    $stmt = $this->conn->prepare("
        SELECT p.*, t1.nome AS nome_casa, t2.nome AS nome_fora
        FROM partidas p
        JOIN times t1 ON p.time_casa = t1.id
        JOIN times t2 ON p.time_fora = t2.id
        WHERE p.id = ?
    ");
    $stmt->bind_param("i", $partida_id);
    $stmt->execute();
    $partida = $stmt->get_result()->fetch_assoc();

    // 🟢 Agora carrega os jogadores da partida via jogador_time
    $stmt = $this->conn->prepare("
        SELECT j.id, j.nome, j.posicao, jt.time_id, t.nome AS time_nome
        FROM jogador_time jt
        INNER JOIN jogadores j ON jt.jogador_id = j.id
        INNER JOIN times t ON jt.time_id = t.id
        WHERE jt.time_id IN (?, ?) AND jt.status = 'ativo'
    ");
    $stmt->bind_param("ii", $partida['time_casa'], $partida['time_fora']);
    $stmt->execute();
    $jogadores = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    return ['partida' => $partida, 'jogadores' => $jogadores];
}

 public function salvarSumula($dados)
{
    $partida_id = $dados['partida_id'];
    $placar_casa = $dados['placar_casa'];
    $placar_fora = $dados['placar_fora'];

    // ✅ Atualiza placar e status da partida
    $stmt = $this->conn->prepare("
        UPDATE partidas 
        SET placar_casa = ?, placar_fora = ?, status = 'finalizada' 
        WHERE id = ?
    ");
    $stmt->bind_param("iii", $placar_casa, $placar_fora, $partida_id);
    $stmt->execute();

    // ✅ Registrar estatísticas dos jogadores de linha (corrigido com acumulação)
  $campos = [
    'gols',
    'assistencias',
    'amarelos' => 'cartoes_amarelos',
    'vermelhos' => 'cartoes_vermelhos',
    'defesas',
    'penaltis_defendidos'
];

$acumulados = [];

foreach ($campos as $key => $campoReal) {
    $inputName = is_numeric($key) ? $campoReal : $key;
    $campoDb = is_numeric($key) ? $campoReal : $campoReal;

    if (!empty($dados[$inputName])) {
        foreach ($dados[$inputName] as $jogador_id => $valor) {
            if (!isset($acumulados[$jogador_id])) $acumulados[$jogador_id] = [];
            $acumulados[$jogador_id][$campoDb] = (int)$valor;
        }
    }
}

// Salva de forma única e precisa por jogador
foreach ($acumulados as $jogador_id => $estatisticas) {
    foreach ($estatisticas as $campo => $valor) {
        $this->registrarEstatistica($partida_id, $jogador_id, $campo, $valor);
    }
}

    // ✅ 🧤 Calcula automaticamente os goleiros com base em jogador_time
    $partida = $this->carregarDados($partida_id);
    $time_casa = $partida['partida']['time_casa'];
    $time_fora = $partida['partida']['time_fora'];

    // 🟢 Goleiro time da casa
    $res = $this->conn->query("
        SELECT j.id 
        FROM jogadores j
        JOIN jogador_time jt ON jt.jogador_id = j.id
        WHERE jt.time_id = $time_casa AND j.posicao = 'Goleiro' AND jt.status = 'ativo'
        LIMIT 1
    ");
    if ($g = $res->fetch_assoc()) {
        $this->registrarEstatistica($partida_id, $g['id'], 'gols_sofridos', max(0, (int)$placar_fora));
        $clean = ($placar_fora == 0) ? 1 : 0;
        $this->registrarEstatistica($partida_id, $g['id'], 'clean_sheets', $clean);
    }

    // 🟢 Goleiro time visitante
    $res = $this->conn->query("
        SELECT j.id 
        FROM jogadores j
        JOIN jogador_time jt ON jt.jogador_id = j.id
        WHERE jt.time_id = $time_fora AND j.posicao = 'Goleiro' AND jt.status = 'ativo'
        LIMIT 1
    ");
    if ($g = $res->fetch_assoc()) {
        $this->registrarEstatistica($partida_id, $g['id'], 'gols_sofridos', max(0, (int)$placar_casa));
        $clean = ($placar_casa == 0) ? 1 : 0;
        $this->registrarEstatistica($partida_id, $g['id'], 'clean_sheets', $clean);
    }
}



private function registrarEstatistica($partida_id, $jogador_id, $campo, $valor)
{
    $campos_permitidos = [
        'gols', 'assistencias', 'cartoes_amarelos', 'cartoes_vermelhos',
        'defesas', 'penaltis_defendidos', 'gols_sofridos', 'clean_sheets'
    ];

    if (!in_array($campo, $campos_permitidos)) {
        return;
    }

    $valor = max(0, (int)$valor);

    $stmt = $this->conn->prepare("
        INSERT INTO estatisticas_partida (partida_id, jogador_id, $campo)
        VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE $campo = VALUES($campo)
    ");
    $stmt->bind_param("iii", $partida_id, $jogador_id, $valor);
    $stmt->execute();
}


}
