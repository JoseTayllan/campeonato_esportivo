<?php
require_once __DIR__ . '/database.php';

// Create usuarios table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS usuarios (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome TEXT NOT NULL,
    email TEXT UNIQUE NOT NULL,
    senha TEXT NOT NULL,
    tipo TEXT NOT NULL DEFAULT 'Usuario',
    tipo_assinatura TEXT DEFAULT 'completo',
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

try {
    $conn->exec($sql);
    echo "Tabela usuarios criada ou já existente.\n";
} catch (PDOException $e) {
    echo "Erro ao criar tabela usuarios: " . $e->getMessage() . "\n";
}

// Create times table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS times (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome TEXT NOT NULL,
    escudo TEXT,
    data_fundacao TEXT,
    cor_primaria TEXT,
    cor_secundaria TEXT,
    usuario_id INTEGER,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
)";

try {
    $conn->exec($sql);
    echo "Tabela times criada ou já existente.\n";
} catch (PDOException $e) {
    echo "Erro ao criar tabela times: " . $e->getMessage() . "\n";
}

// Create jogadores table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS jogadores (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome TEXT NOT NULL,
    data_nascimento TEXT,
    posicao TEXT,
    numero TEXT,
    time_id INTEGER,
    FOREIGN KEY (time_id) REFERENCES times(id)
)";

try {
    $conn->exec($sql);
    echo "Tabela jogadores criada ou já existente.\n";
} catch (PDOException $e) {
    echo "Erro ao criar tabela jogadores: " . $e->getMessage() . "\n";
}

// Create campeonatos table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS campeonatos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome TEXT NOT NULL,
    data_inicio TEXT,
    data_fim TEXT,
    status TEXT DEFAULT 'pendente',
    organizador_id INTEGER,
    FOREIGN KEY (organizador_id) REFERENCES usuarios(id)
)";

try {
    $conn->exec($sql);
    echo "Tabela campeonatos criada ou já existente.\n";
} catch (PDOException $e) {
    echo "Erro ao criar tabela campeonatos: " . $e->getMessage() . "\n";
}

// Create times_campeonatos table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS times_campeonatos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    time_id INTEGER,
    campeonato_id INTEGER,
    pontos INTEGER DEFAULT 0,
    vitorias INTEGER DEFAULT 0,
    empates INTEGER DEFAULT 0,
    derrotas INTEGER DEFAULT 0,
    gols_pro INTEGER DEFAULT 0,
    gols_contra INTEGER DEFAULT 0,
    FOREIGN KEY (time_id) REFERENCES times(id),
    FOREIGN KEY (campeonato_id) REFERENCES campeonatos(id)
)";

try {
    $conn->exec($sql);
    echo "Tabela times_campeonatos criada ou já existente.\n";
} catch (PDOException $e) {
    echo "Erro ao criar tabela times_campeonatos: " . $e->getMessage() . "\n";
}

// Create partidas table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS partidas (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    campeonato_id INTEGER,
    time_casa INTEGER,
    time_fora INTEGER,
    gols_casa INTEGER DEFAULT 0,
    gols_fora INTEGER DEFAULT 0,
    data TEXT,
    horario TEXT,
    status TEXT DEFAULT 'agendada',
    tempo_atual TEXT DEFAULT '00:00',
    FOREIGN KEY (campeonato_id) REFERENCES campeonatos(id),
    FOREIGN KEY (time_casa) REFERENCES times(id),
    FOREIGN KEY (time_fora) REFERENCES times(id)
)";

try {
    $conn->exec($sql);
    echo "Tabela partidas criada ou já existente.\n";
} catch (PDOException $e) {
    echo "Erro ao criar tabela partidas: " . $e->getMessage() . "\n";
}

// Create estatisticas_partida table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS estatisticas_partida (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    partida_id INTEGER,
    jogador_id INTEGER,
    gols INTEGER DEFAULT 0,
    assistencias INTEGER DEFAULT 0,
    cartoes_amarelos INTEGER DEFAULT 0,
    cartoes_vermelhos INTEGER DEFAULT 0,
    FOREIGN KEY (partida_id) REFERENCES partidas(id),
    FOREIGN KEY (jogador_id) REFERENCES jogadores(id)
)";

try {
    $conn->exec($sql);
    echo "Tabela estatisticas_partida criada ou já existente.\n";
} catch (PDOException $e) {
    echo "Erro ao criar tabela estatisticas_partida: " . $e->getMessage() . "\n";
}

echo "Inicialização do banco de dados concluída.\n";
?> 