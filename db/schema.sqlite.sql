-- championship_db SQLite schema
-- Converted from MySQL to SQLite

-- Avaliacoes table
CREATE TABLE IF NOT EXISTS "avaliacoes" (
  "id" INTEGER PRIMARY KEY AUTOINCREMENT,
  "jogador_id" INTEGER NOT NULL,
  "olheiro_id" INTEGER NOT NULL,
  "forca" INTEGER DEFAULT NULL,
  "velocidade" INTEGER DEFAULT NULL,
  "drible" INTEGER DEFAULT NULL,
  "finalizacao" INTEGER DEFAULT NULL,
  "nota_geral" REAL DEFAULT NULL,
  "observacoes" TEXT DEFAULT NULL,
  "criado_em" TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE INDEX idx_avaliacoes_jogador ON avaliacoes(jogador_id);
CREATE INDEX idx_avaliacoes_olheiro ON avaliacoes(olheiro_id);

-- Campeonatos table
CREATE TABLE IF NOT EXISTS "campeonatos" (
  "id" INTEGER PRIMARY KEY AUTOINCREMENT,
  "nome" TEXT NOT NULL,
  "descricao" TEXT DEFAULT NULL,
  "temporada" INTEGER NOT NULL, -- Using INTEGER instead of YEAR
  "formato" TEXT NOT NULL CHECK(formato IN ('Pontos Corridos','Mata-Mata','Fase de Grupos')),
  "criado_em" TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  "modalidade" TEXT DEFAULT 'Futebol',
  "criado_por" INTEGER NOT NULL,
  "status" TEXT DEFAULT 'ativo'
);

-- Escalacoes table
CREATE TABLE IF NOT EXISTS "escalacoes" (
  "id" INTEGER PRIMARY KEY AUTOINCREMENT,
  "partida_id" INTEGER NOT NULL,
  "jogador_id" INTEGER NOT NULL,
  "titular" INTEGER DEFAULT 1, -- Using INTEGER for BOOLEAN (0/1)
  "posicao" TEXT DEFAULT NULL,
  "capitao" INTEGER DEFAULT 0,
  "substituido" INTEGER DEFAULT 0
);
CREATE INDEX idx_escalacoes_partida ON escalacoes(partida_id);
CREATE INDEX idx_escalacoes_jogador ON escalacoes(jogador_id);

-- Estatisticas_partida table
CREATE TABLE IF NOT EXISTS "estatisticas_partida" (
  "id" INTEGER PRIMARY KEY AUTOINCREMENT,
  "partida_id" INTEGER NOT NULL,
  "jogador_id" INTEGER NOT NULL,
  "gols" INTEGER DEFAULT NULL,
  "assistencias" INTEGER DEFAULT NULL,
  "passes_completos" INTEGER DEFAULT NULL,
  "finalizacoes" INTEGER DEFAULT NULL,
  "faltas_cometidas" INTEGER DEFAULT NULL,
  "cartoes_amarelos" INTEGER DEFAULT NULL,
  "cartoes_vermelhos" INTEGER DEFAULT NULL,
  "minutos_jogados" INTEGER DEFAULT NULL,
  "substituicoes" INTEGER DEFAULT NULL,
  "defesas" INTEGER DEFAULT 0,
  "gols_sofridos" INTEGER DEFAULT 0,
  "penaltis_defendidos" INTEGER DEFAULT 0,
  "clean_sheets" INTEGER DEFAULT 0
);
CREATE INDEX idx_partida ON estatisticas_partida(partida_id);
CREATE INDEX idx_jogador ON estatisticas_partida(jogador_id);

-- Eventos_partida table
CREATE TABLE IF NOT EXISTS "eventos_partida" (
  "id" INTEGER PRIMARY KEY AUTOINCREMENT,
  "partida_id" INTEGER NOT NULL,
  "jogador_id" INTEGER DEFAULT NULL,
  "time_id" INTEGER DEFAULT NULL,
  "tipo_evento" TEXT NOT NULL CHECK(tipo_evento IN ('gol','cartao_amarelo','cartao_vermelho','substituicao','posse_bola','finalizacao','outro')),
  "minuto" INTEGER DEFAULT NULL,
  "descricao" TEXT DEFAULT NULL,
  "criado_em" TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE INDEX idx_eventos_partida ON eventos_partida(partida_id);
CREATE INDEX idx_eventos_jogador ON eventos_partida(jogador_id);

-- Fases_campeonato table
CREATE TABLE IF NOT EXISTS "fases_campeonato" (
  "id" INTEGER PRIMARY KEY AUTOINCREMENT,
  "campeonato_id" INTEGER NOT NULL,
  "nome" TEXT DEFAULT NULL,
  "ordem" INTEGER DEFAULT 1
);
CREATE INDEX idx_fases_campeonato ON fases_campeonato(campeonato_id);

-- Jogadores table
CREATE TABLE IF NOT EXISTS "jogadores" (
  "id" INTEGER PRIMARY KEY AUTOINCREMENT,
  "nome" TEXT NOT NULL,
  "idade" INTEGER NOT NULL,
  "nacionalidade" TEXT DEFAULT NULL,
  "posicao" TEXT NOT NULL CHECK(posicao IN ('Goleiro','Zagueiro','Lateral','Meia','Atacante')),
  "time_id" INTEGER DEFAULT NULL,
  "imagem" TEXT DEFAULT NULL
);
CREATE INDEX idx_jogadores_time ON jogadores(time_id);

-- Rodadas table
CREATE TABLE IF NOT EXISTS "rodadas" (
  "id" INTEGER PRIMARY KEY AUTOINCREMENT,
  "nome" TEXT NOT NULL,
  "ordem" INTEGER DEFAULT 1,
  "campeonato_id" INTEGER NOT NULL,
  "tipo" TEXT DEFAULT 'Ida' CHECK(tipo IN ('Ida','Volta')),
  "descricao" TEXT DEFAULT NULL,
  "data" DATE DEFAULT NULL,
  "hora" TIME DEFAULT NULL
);
CREATE INDEX idx_rodadas_campeonato ON rodadas(campeonato_id);

-- Partidas table
CREATE TABLE IF NOT EXISTS "partidas" (
  "id" INTEGER PRIMARY KEY AUTOINCREMENT,
  "fase_id" INTEGER DEFAULT NULL,
  "campeonato_id" INTEGER NOT NULL,
  "data" DATE DEFAULT NULL,
  "horario" TIME DEFAULT NULL,
  "local" TEXT DEFAULT NULL,
  "time_casa" INTEGER NOT NULL,
  "time_fora" INTEGER NOT NULL,
  "placar_casa" INTEGER DEFAULT 0,
  "placar_fora" INTEGER DEFAULT 0,
  "rodada_id" INTEGER DEFAULT NULL,
  "status" TEXT DEFAULT 'nao_iniciada' CHECK(status IN ('nao_iniciada','em_andamento','finalizada')),
  "inicio_partida" DATETIME DEFAULT NULL,
  "cronometro_status" TEXT DEFAULT 'rodando',
  "acrescimos" INTEGER DEFAULT 0,
  "tempo_acumulado" INTEGER DEFAULT 0,
  "tempo_atual" TEXT DEFAULT NULL,
  FOREIGN KEY(fase_id) REFERENCES fases_campeonato(id) ON DELETE SET NULL ON UPDATE CASCADE,
  FOREIGN KEY(rodada_id) REFERENCES rodadas(id) ON DELETE CASCADE ON UPDATE CASCADE
);
CREATE INDEX idx_partidas_campeonato ON partidas(campeonato_id);
CREATE INDEX idx_partidas_timecasa ON partidas(time_casa);
CREATE INDEX idx_partidas_timefora ON partidas(time_fora);
CREATE INDEX idx_partidas_rodada ON partidas(rodada_id);
CREATE INDEX idx_partidas_fase ON partidas(fase_id);

-- Patrocinador_time table
CREATE TABLE IF NOT EXISTS "patrocinador_time" (
  "id" INTEGER PRIMARY KEY AUTOINCREMENT,
  "patrocinador_id" INTEGER NOT NULL,
  "time_id" INTEGER NOT NULL,
  "data_inicio" DATE DEFAULT NULL,
  "data_fim" DATE DEFAULT NULL
);
CREATE INDEX idx_patrocinador_time_patrocinador ON patrocinador_time(patrocinador_id);
CREATE INDEX idx_patrocinador_time_time ON patrocinador_time(time_id);

-- Patrocinadores table
CREATE TABLE IF NOT EXISTS "patrocinadores" (
  "id" INTEGER PRIMARY KEY AUTOINCREMENT,
  "nome_empresa" TEXT NOT NULL,
  "contrato" TEXT DEFAULT NULL,
  "valor_investido" NUMERIC(10,2) DEFAULT NULL,
  "logo" TEXT DEFAULT NULL
);

-- Substituicoes table
CREATE TABLE IF NOT EXISTS "substituicoes" (
  "id" INTEGER PRIMARY KEY AUTOINCREMENT,
  "partida_id" INTEGER NOT NULL,
  "jogador_id" INTEGER NOT NULL,
  "minuto_substituicao" INTEGER DEFAULT NULL,
  "jogador_entrou" INTEGER DEFAULT 0,
  "jogador_saiu" INTEGER DEFAULT 0
);
CREATE INDEX idx_substituicoes_partida ON substituicoes(partida_id);
CREATE INDEX idx_substituicoes_jogador ON substituicoes(jogador_id);

-- Times table
CREATE TABLE IF NOT EXISTS "times" (
  "id" INTEGER PRIMARY KEY AUTOINCREMENT,
  "nome" TEXT NOT NULL,
  "escudo" TEXT DEFAULT NULL,
  "cidade" TEXT DEFAULT NULL,
  "estadio" TEXT DEFAULT NULL,
  "admin_id" INTEGER DEFAULT NULL,
  "codigo_publico" TEXT DEFAULT NULL UNIQUE
);

-- Times_campeonatos table
CREATE TABLE IF NOT EXISTS "times_campeonatos" (
  "id" INTEGER PRIMARY KEY AUTOINCREMENT,
  "time_id" INTEGER NOT NULL,
  "campeonato_id" INTEGER NOT NULL,
  "pontos" INTEGER DEFAULT 0,
  "vitorias" INTEGER DEFAULT 0,
  "empates" INTEGER DEFAULT 0,
  "derrotas" INTEGER DEFAULT 0,
  "jogos" INTEGER DEFAULT 0,
  "gols_pro" INTEGER DEFAULT 0,
  "gols_contra" INTEGER DEFAULT 0
);
CREATE INDEX idx_times_campeonatos_time ON times_campeonatos(time_id);
CREATE INDEX idx_times_campeonatos_campeonato ON times_campeonatos(campeonato_id);

-- Usuarios table
CREATE TABLE IF NOT EXISTS "usuarios" (
  "id" INTEGER PRIMARY KEY AUTOINCREMENT,
  "nome" TEXT NOT NULL,
  "email" TEXT NOT NULL UNIQUE,
  "senha" TEXT NOT NULL,
  "tipo" TEXT NOT NULL CHECK(tipo IN ('Administrador','Organizador','Treinador','Jogador','Olheiro','Patrocinador','Master')),
  "criado_em" TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  "criado_por" INTEGER DEFAULT NULL,
  "tipo_assinatura" TEXT DEFAULT 'completo' CHECK(tipo_assinatura IN ('time','organizador','completo','master'))
); 