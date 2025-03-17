-- Criar banco de dados
CREATE DATABASE IF NOT EXISTS campeonato_esportivo;
USE campeonato_esportivo;

-- Tabela de usuários (administrador, organizador, técnico, jogador, olheiro, patrocinador)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    tipo ENUM('admin', 'organizador', 'tecnico', 'jogador', 'olheiro', 'patrocinador') NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de campeonatos
CREATE TABLE championships (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    temporada YEAR NOT NULL,
    formato ENUM('pontos_corridos', 'mata_mata', 'grupos_mata_mata') NOT NULL,
    regulamento TEXT,
    criado_por INT,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (criado_por) REFERENCES users(id) ON DELETE SET NULL
);

-- Tabela de times
CREATE TABLE teams (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    escudo VARCHAR(255), -- URL da imagem do escudo
    cidade VARCHAR(100),
    estadio VARCHAR(100),
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de jogadores
CREATE TABLE players (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    idade INT NOT NULL,
    nacionalidade VARCHAR(50),
    posicao ENUM('goleiro', 'zagueiro', 'lateral', 'meia', 'atacante') NOT NULL,
    contrato_inicio DATE,
    contrato_fim DATE,
    time_id INT,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (time_id) REFERENCES teams(id) ON DELETE SET NULL
);

-- Tabela de partidas
CREATE TABLE matches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    campeonato_id INT NOT NULL,
    time_casa INT NOT NULL,
    time_fora INT NOT NULL,
    data DATE NOT NULL,
    horario TIME NOT NULL,
    estadio VARCHAR(100),
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (campeonato_id) REFERENCES championships(id) ON DELETE CASCADE,
    FOREIGN KEY (time_casa) REFERENCES teams(id) ON DELETE CASCADE,
    FOREIGN KEY (time_fora) REFERENCES teams(id) ON DELETE CASCADE
);

-- Tabela de estatísticas das partidas
CREATE TABLE match_statistics (
    id INT AUTO_INCREMENT PRIMARY KEY,
    match_id INT NOT NULL,
    team_id INT NOT NULL,
    posse_bola DECIMAL(5,2), -- Percentual
    finalizacoes INT,
    chutes_no_gol INT,
    faltas INT,
    passes_completos INT,
    passes_errados INT,
    escanteios INT,
    impedimentos INT,
    FOREIGN KEY (match_id) REFERENCES matches(id) ON DELETE CASCADE,
    FOREIGN KEY (team_id) REFERENCES teams(id) ON DELETE CASCADE
);

-- Tabela de avaliação de jogadores
CREATE TABLE player_evaluations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    jogador_id INT NOT NULL,
    olheiro_id INT NOT NULL,
    forca DECIMAL(3,1),
    velocidade DECIMAL(3,1),
    drible DECIMAL(3,1),
    finalizacao DECIMAL(3,1),
    nota_geral DECIMAL(3,1) GENERATED ALWAYS AS (
        (forca + velocidade + drible + finalizacao) / 4
    ) STORED,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (jogador_id) REFERENCES players(id) ON DELETE CASCADE,
    FOREIGN KEY (olheiro_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Tabela de patrocínios
CREATE TABLE sponsorships (
    id INT AUTO_INCREMENT PRIMARY KEY,
    empresa VARCHAR(100) NOT NULL,
    contrato_valor DECIMAL(10,2),
    time_id INT,
    campeonato_id INT,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (time_id) REFERENCES teams(id) ON DELETE SET NULL,
    FOREIGN KEY (campeonato_id) REFERENCES championships(id) ON DELETE SET NULL
);
