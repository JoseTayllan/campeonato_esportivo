-- Esquema simplificado do banco de dados somente para testes
-- Contém apenas as tabelas necessárias para os testes funcionarem

-- Tabela de campeonatos
CREATE TABLE campeonatos (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  nome VARCHAR(100) NOT NULL,
  descricao TEXT,
  temporada VARCHAR(4) NOT NULL,
  formato VARCHAR(50) NOT NULL,
  modalidade VARCHAR(20) DEFAULT 'Futebol',
  criado_por INTEGER NOT NULL,
  status VARCHAR(20) DEFAULT 'ativo',
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  qr_code_localizacao VARCHAR(255) DEFAULT NULL
);

-- Tabela de fases do campeonato
CREATE TABLE fases_campeonato (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  campeonato_id INTEGER NOT NULL,
  nome VARCHAR(50) NOT NULL,
  ordem INTEGER DEFAULT 1,
  FOREIGN KEY (campeonato_id) REFERENCES campeonatos(id)
);

-- Tabela de times
CREATE TABLE times (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  nome VARCHAR(100) NOT NULL,
  escudo VARCHAR(255) DEFAULT NULL,
  cidade VARCHAR(100) DEFAULT NULL,
  codigo_publico VARCHAR(10) DEFAULT NULL,
  data_fundacao DATE DEFAULT NULL,
  responsavel VARCHAR(100) DEFAULT NULL,
  telefone VARCHAR(20) DEFAULT NULL,
  email VARCHAR(100) DEFAULT NULL,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de relacionamento times_campeonatos
CREATE TABLE times_campeonatos (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  time_id INTEGER NOT NULL,
  campeonato_id INTEGER NOT NULL,
  FOREIGN KEY (time_id) REFERENCES times(id),
  FOREIGN KEY (campeonato_id) REFERENCES campeonatos(id)
);

-- Tabela de rodadas
CREATE TABLE rodadas (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  fase_id INTEGER NOT NULL,
  numero INTEGER NOT NULL,
  tipo VARCHAR(50) DEFAULT NULL,
  descricao TEXT,
  data DATE DEFAULT NULL,
  hora TIME DEFAULT NULL,
  FOREIGN KEY (fase_id) REFERENCES fases_campeonato(id)
);

-- Tabela de partidas
CREATE TABLE partidas (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  rodada_id INTEGER NOT NULL,
  fase_id INTEGER DEFAULT NULL,
  campeonato_id INTEGER NOT NULL,
  data DATE DEFAULT NULL,
  horario TIME DEFAULT NULL,
  local VARCHAR(100) DEFAULT NULL,
  time_casa INTEGER NOT NULL,
  time_fora INTEGER NOT NULL,
  placar_casa INTEGER DEFAULT 0,
  placar_fora INTEGER DEFAULT 0,
  status VARCHAR(20) DEFAULT 'nao_iniciada',
  FOREIGN KEY (rodada_id) REFERENCES rodadas(id),
  FOREIGN KEY (fase_id) REFERENCES fases_campeonato(id),
  FOREIGN KEY (campeonato_id) REFERENCES campeonatos(id),
  FOREIGN KEY (time_casa) REFERENCES times(id),
  FOREIGN KEY (time_fora) REFERENCES times(id)
); 