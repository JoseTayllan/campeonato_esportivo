
CREATE DATABASE IF NOT EXISTS `championship_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `championship_db`;

CREATE TABLE IF NOT EXISTS `avaliacoes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `jogador_id` int NOT NULL,
  `olheiro_id` int NOT NULL,
  `forca` int DEFAULT NULL,
  `velocidade` int DEFAULT NULL,
  `drible` int DEFAULT NULL,
  `finalizacao` int DEFAULT NULL,
  `nota_geral` float DEFAULT NULL,
  `observacoes` text,
  `criado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `jogador_id` (`jogador_id`),
  KEY `olheiro_id` (`olheiro_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `campeonatos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `descricao` text,
  `temporada` year NOT NULL,
  `formato` enum('Pontos Corridos','Mata-Mata','Fase de Grupos') NOT NULL,
  `criado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modalidade` varchar(20) DEFAULT 'Futebol',
  `criado_por` int NOT NULL,
  `status` varchar(20) DEFAULT 'ativo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `escalacoes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `partida_id` int NOT NULL,
  `jogador_id` int NOT NULL,
  `titular` tinyint(1) DEFAULT '1',
  `posicao` varchar(50) DEFAULT NULL,
  `capitao` tinyint(1) DEFAULT '0',
  `substituido` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `partida_id` (`partida_id`),
  KEY `jogador_id` (`jogador_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `estatisticas_partida` (
  `id` int NOT NULL AUTO_INCREMENT,
  `partida_id` int NOT NULL,
  `jogador_id` int NOT NULL,
  `gols` int DEFAULT NULL,
  `assistencias` int DEFAULT NULL,
  `passes_completos` int DEFAULT NULL,
  `finalizacoes` int DEFAULT NULL,
  `faltas_cometidas` int DEFAULT NULL,
  `cartoes_amarelos` int DEFAULT NULL,
  `cartoes_vermelhos` int DEFAULT NULL,
  `minutos_jogados` int DEFAULT NULL,
  `substituicoes` int DEFAULT NULL,
  `defesas` int DEFAULT '0',
  `gols_sofridos` int DEFAULT '0',
  `penaltis_defendidos` int DEFAULT '0',
  `clean_sheets` int DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_partida` (`partida_id`),
  KEY `idx_jogador` (`jogador_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `eventos_partida` (
  `id` int NOT NULL AUTO_INCREMENT,
  `partida_id` int NOT NULL,
  `jogador_id` int DEFAULT NULL,
  `time_id` int DEFAULT NULL,
  `tipo_evento` enum('gol','cartao_amarelo','cartao_vermelho','substituicao','posse_bola','finalizacao','outro') NOT NULL,
  `minuto` int DEFAULT NULL,
  `descricao` text,
  `criado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `partida_id` (`partida_id`),
  KEY `jogador_id` (`jogador_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE IF NOT EXISTS `fases_campeonato` (
  `id` int NOT NULL AUTO_INCREMENT,
  `campeonato_id` int NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `ordem` int DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `campeonato_id` (`campeonato_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE IF NOT EXISTS `jogadores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `idade` int NOT NULL,
  `nacionalidade` varchar(50) DEFAULT NULL,
  `posicao` enum('Goleiro','Zagueiro','Lateral','Meia','Atacante') NOT NULL,
  `time_id` int DEFAULT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `time_id` (`time_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `rodadas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `ordem` int DEFAULT '1',
  `campeonato_id` int NOT NULL,
  `tipo` enum('Ida','Volta') DEFAULT 'Ida',
  `descricao` varchar(100) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `campeonato_id` (`campeonato_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `partidas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fase_id` int DEFAULT NULL,
  `campeonato_id` int NOT NULL,
  `data` date DEFAULT NULL,
  `horario` time DEFAULT NULL,
  `local` varchar(100) DEFAULT NULL,
  `time_casa` int NOT NULL,
  `time_fora` int NOT NULL,
  `placar_casa` int DEFAULT '0',
  `placar_fora` int DEFAULT '0',
  `rodada_id` int DEFAULT NULL,
  `status` enum('nao_iniciada','em_andamento','finalizada') DEFAULT 'nao_iniciada',
  `inicio_partida` datetime DEFAULT NULL,
  `cronometro_status` varchar(20) DEFAULT 'rodando',
  `acrescimos` int DEFAULT '0',
  `tempo_acumulado` int DEFAULT '0',
  `tempo_atual` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `campeonato_id` (`campeonato_id`),
  KEY `time_casa` (`time_casa`),
  KEY `time_fora` (`time_fora`),
  KEY `fk_rodada_id` (`rodada_id`),
  KEY `fk_partidas_fase` (`fase_id`),
  CONSTRAINT `fk_partidas_fase` FOREIGN KEY (`fase_id`) REFERENCES `fases_campeonato` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_rodada_id` FOREIGN KEY (`rodada_id`) REFERENCES `rodadas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `patrocinador_time` (
  `id` int NOT NULL AUTO_INCREMENT,
  `patrocinador_id` int NOT NULL,
  `time_id` int NOT NULL,
  `data_inicio` date DEFAULT NULL,
  `data_fim` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `patrocinador_id` (`patrocinador_id`),
  KEY `time_id` (`time_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `patrocinadores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome_empresa` varchar(100) NOT NULL,
  `contrato` text,
  `valor_investido` decimal(10,2) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `substituicoes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `partida_id` int NOT NULL,
  `jogador_id` int NOT NULL,
  `minuto_substituicao` int DEFAULT NULL,
  `jogador_entrou` tinyint(1) DEFAULT '0',
  `jogador_saiu` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `partida_id` (`partida_id`),
  KEY `jogador_id` (`jogador_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `times` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `escudo` varchar(255) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `estadio` varchar(100) DEFAULT NULL,
  `admin_id` int DEFAULT NULL,
  `codigo_publico` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo_publico` (`codigo_publico`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE IF NOT EXISTS `times_campeonatos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `time_id` int NOT NULL,
  `campeonato_id` int NOT NULL,
  `pontos` int DEFAULT '0',
  `vitorias` int DEFAULT '0',
  `empates` int DEFAULT '0',
  `derrotas` int DEFAULT '0',
  `jogos` int DEFAULT '0',
  `gols_pro` int DEFAULT '0',
  `gols_contra` int DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `time_id` (`time_id`),
  KEY `campeonato_id` (`campeonato_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `tipo` enum('Administrador','Organizador','Treinador','Jogador','Olheiro','Patrocinador','Master') NOT NULL,
  `criado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `criado_por` int DEFAULT NULL,
  `tipo_assinatura` enum('time','organizador','completo','master') DEFAULT 'completo',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
