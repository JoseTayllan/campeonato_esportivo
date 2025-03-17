-- Criar banco de dados
CREATE DATABASE IF NOT EXISTS campeonato_esportivo;
USE campeonato_esportivo;

-- Tabela de Usuários
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    tipo ENUM('Administrador', 'Organizador', 'Treinador', 'Jogador', 'Olheiro', 'Patrocinador') NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Campeonatos
CREATE TABLE campeonatos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    temporada YEAR NOT NULL,
    formato ENUM('Pontos Corridos', 'Mata-Mata', 'Fase de Grupos') NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Times
CREATE TABLE times (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    escudo VARCHAR(255),
    cidade VARCHAR(100),
    estadio VARCHAR(100)
);

-- Tabela de Jogadores
CREATE TABLE jogadores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    idade INT NOT NULL,
    nacionalidade VARCHAR(50),
    posicao ENUM('Goleiro', 'Zagueiro', 'Lateral', 'Meia', 'Atacante') NOT NULL,
    time_id INT,
    FOREIGN KEY (time_id) REFERENCES times(id) ON DELETE SET NULL
);

-- Tabela de Partidas
CREATE TABLE partidas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    campeonato_id INT NOT NULL,
    data DATE NOT NULL,
    horario TIME NOT NULL,
    local VARCHAR(100),
    time_casa INT NOT NULL,
    time_fora INT NOT NULL,
    placar_casa INT DEFAULT 0,
    placar_fora INT DEFAULT 0,
    FOREIGN KEY (campeonato_id) REFERENCES campeonatos(id) ON DELETE CASCADE,
    FOREIGN KEY (time_casa) REFERENCES times(id) ON DELETE CASCADE,
    FOREIGN KEY (time_fora) REFERENCES times(id) ON DELETE CASCADE
);

-- Tabela de Estatísticas da Partida
CREATE TABLE estatisticas_partida (
    id INT AUTO_INCREMENT PRIMARY KEY,
    partida_id INT NOT NULL,
    jogador_id INT NOT NULL,
    gols INT DEFAULT 0,
    assistencias INT DEFAULT 0,
    passes_completos INT DEFAULT 0,
    finalizacoes INT DEFAULT 0,
    faltas_cometidas INT DEFAULT 0,
    cartoes_amarelos INT DEFAULT 0,
    cartoes_vermelhos INT DEFAULT 0,
    minutos_jogados INT DEFAULT 0,
    FOREIGN KEY (partida_id) REFERENCES partidas(id) ON DELETE CASCADE,
    FOREIGN KEY (jogador_id) REFERENCES jogadores(id) ON DELETE CASCADE
);

-- Tabela de Avaliações dos Jogadores
CREATE TABLE avaliacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    jogador_id INT NOT NULL,
    olheiro_id INT NOT NULL,
    forca INT CHECK (forca BETWEEN 0 AND 10),
    velocidade INT CHECK (velocidade BETWEEN 0 AND 10),
    drible INT CHECK (drible BETWEEN 0 AND 10),
    finalizacao INT CHECK (finalizacao BETWEEN 0 AND 10),
    nota_geral FLOAT,
    observacoes TEXT,
    FOREIGN KEY (jogador_id) REFERENCES jogadores(id) ON DELETE CASCADE,
    FOREIGN KEY (olheiro_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Tabela de Patrocínios
CREATE TABLE patrocinios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_empresa VARCHAR(100) NOT NULL,
    contrato_valor DECIMAL(10,2) NOT NULL,
    time_id INT NOT NULL,
    FOREIGN KEY (time_id) REFERENCES times(id) ON DELETE CASCADE
);

-- Tabela de Escalações
CREATE TABLE escalacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    partida_id INT NOT NULL,
    jogador_id INT NOT NULL,
    titular BOOLEAN DEFAULT TRUE,
    posicao VARCHAR(50),
    capitao BOOLEAN DEFAULT FALSE,
    substituido BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (partida_id) REFERENCES partidas(id) ON DELETE CASCADE,
    FOREIGN KEY (jogador_id) REFERENCES jogadores(id) ON DELETE CASCADE
);

-- Índices para otimização
CREATE INDEX idx_partida ON estatisticas_partida (partida_id);
CREATE INDEX idx_jogador ON estatisticas_partida (jogador_id);
