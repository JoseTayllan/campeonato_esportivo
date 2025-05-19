CREATE DATABASE  IF NOT EXISTS `projeto_php` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `projeto_php`;
-- MySQL dump 10.13  Distrib 8.0.36
--
-- Host: localhost    Database: projeto_php
-- ------------------------------------------------------
-- Server version	8.2.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `avaliacoes`
--

DROP TABLE IF EXISTS `avaliacoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `avaliacoes` (
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
  KEY `olheiro_id` (`olheiro_id`),
  CONSTRAINT `avaliacoes_chk_1` CHECK ((`forca` between 0 and 10)),
  CONSTRAINT `avaliacoes_chk_2` CHECK ((`velocidade` between 0 and 10)),
  CONSTRAINT `avaliacoes_chk_3` CHECK ((`drible` between 0 and 10)),
  CONSTRAINT `avaliacoes_chk_4` CHECK ((`finalizacao` between 0 and 10))
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `campeonatos`
--

DROP TABLE IF EXISTS `campeonatos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `campeonatos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `descricao` text,
  `temporada` year NOT NULL,
  `formato` enum('Pontos Corridos','Mata-Mata','Fase de Grupos') NOT NULL,
  `criado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modalidade` enum('Futebol','Futsal','Queimada','Natação','Vôlei','1x1','2x2') DEFAULT 'Futebol',
  `criado_por` int NOT NULL,
  `status` varchar(20) DEFAULT 'ativo',
  `qr_code_localizacao` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `escalacoes`
--

DROP TABLE IF EXISTS `escalacoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `escalacoes` (
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
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `estatisticas_partida`
--

DROP TABLE IF EXISTS `estatisticas_partida`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estatisticas_partida` (
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
  `pontos` int DEFAULT '0',
  `sets_vencidos` int DEFAULT '0',
  `bloqueios` int DEFAULT '0',
  `saques_diretos` int DEFAULT '0',
  `tempo` decimal(10,2) DEFAULT NULL,
  `eliminacoes` int DEFAULT '0',
  `eliminado` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_partida` (`partida_id`),
  KEY `idx_jogador` (`jogador_id`)
) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `eventos_partida`
--

DROP TABLE IF EXISTS `eventos_partida`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `eventos_partida` (
  `id` int NOT NULL AUTO_INCREMENT,
  `partida_id` int NOT NULL,
  `jogador_id` int DEFAULT NULL,
  `time_id` int DEFAULT NULL,
  `tipo_evento` enum('gol','cartao_amarelo','cartao_vermelho','substituicao','posse_bola','finalizacao','outro','defesa','penalti_defendido','ponto','set','eliminacao','chegada','bloco','saque') DEFAULT NULL,
  `minuto` varchar(10) DEFAULT NULL,
  `descricao` text,
  `criado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `valor` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `partida_id` (`partida_id`),
  KEY `jogador_id` (`jogador_id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `fases_campeonato`
--

DROP TABLE IF EXISTS `fases_campeonato`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fases_campeonato` (
  `id` int NOT NULL AUTO_INCREMENT,
  `campeonato_id` int NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `ordem` int DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `campeonato_id` (`campeonato_id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jogadores`
--

DROP TABLE IF EXISTS `jogadores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jogadores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `idade` int NOT NULL,
  `nacionalidade` varchar(50) DEFAULT NULL,
  `posicao` varchar(50) NOT NULL,
  `time_id` int DEFAULT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `modalidade` enum('Futebol','Futsal','Queimada','Natação','Vôlei','1x1','2x2') DEFAULT 'Futebol',
  PRIMARY KEY (`id`),
  KEY `time_id` (`time_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `partidas`
--

DROP TABLE IF EXISTS `partidas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `partidas` (
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
  `link_transmissao` text,
  `sets_casa` int DEFAULT '0',
  `sets_fora` int DEFAULT '0',
  `modalidade` enum('Futebol','Futsal','Queimada','Natação','Vôlei','1x1','2x2') DEFAULT 'Futebol',
  PRIMARY KEY (`id`),
  KEY `campeonato_id` (`campeonato_id`),
  KEY `time_casa` (`time_casa`),
  KEY `time_fora` (`time_fora`),
  KEY `fk_rodada_id` (`rodada_id`),
  KEY `fk_partidas_fase` (`fase_id`),
  CONSTRAINT `fk_partidas_fase` FOREIGN KEY (`fase_id`) REFERENCES `fases_campeonato` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_rodada_id` FOREIGN KEY (`rodada_id`) REFERENCES `rodadas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `patrocinador_time`
--

DROP TABLE IF EXISTS `patrocinador_time`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `patrocinador_time` (
  `id` int NOT NULL AUTO_INCREMENT,
  `patrocinador_id` int NOT NULL,
  `time_id` int NOT NULL,
  `data_inicio` date DEFAULT NULL,
  `data_fim` date DEFAULT NULL,
  `valor_investido` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `patrocinador_id` (`patrocinador_id`),
  KEY `time_id` (`time_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `patrocinadores`
--

DROP TABLE IF EXISTS `patrocinadores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `patrocinadores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome_empresa` varchar(100) NOT NULL,
  `contrato` text,
  `telefone` varchar(11) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `usuario_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rodadas`
--

DROP TABLE IF EXISTS `rodadas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rodadas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fase_id` int NOT NULL,
  `numero` int NOT NULL,
  `tipo` enum('Ida','Volta') DEFAULT 'Ida',
  `descricao` varchar(100) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fase_id` (`fase_id`),
  CONSTRAINT `fk_fase_id` FOREIGN KEY (`fase_id`) REFERENCES `fases_campeonato` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `substituicoes`
--

DROP TABLE IF EXISTS `substituicoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `substituicoes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `partida_id` int NOT NULL,
  `jogador_saiu` int DEFAULT NULL,
  `jogador_entrou` int DEFAULT NULL,
  `minuto_substituicao` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `partida_id` (`partida_id`),
  KEY `jogador_saiu` (`jogador_saiu`),
  KEY `jogador_entrou` (`jogador_entrou`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `times`
--

DROP TABLE IF EXISTS `times`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `times` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `escudo` varchar(255) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `estadio` varchar(100) DEFAULT NULL,
  `admin_id` int DEFAULT NULL,
  `codigo_publico` varchar(10) DEFAULT NULL,
  `modalidade` enum('Futebol','Futsal','Queimada','Natação','Vôlei','1x1','2x2') DEFAULT 'Futebol',
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo_publico` (`codigo_publico`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `times_campeonatos`
--

DROP TABLE IF EXISTS `times_campeonatos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `times_campeonatos` (
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
  `sets_pro` int DEFAULT '0',
  `sets_contra` int DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `time_id` (`time_id`),
  KEY `campeonato_id` (`campeonato_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
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
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `provas_natacao`
--

DROP TABLE IF EXISTS `provas_natacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `provas_natacao` (
  `id` int NOT NULL AUTO_INCREMENT,
  `campeonato_id` int NOT NULL,
  `nome` varchar(100) NOT NULL,
  `distancia` int NOT NULL,
  `estilo` enum('Livre','Costas','Peito','Borboleta','Medley') NOT NULL,
  `data` date DEFAULT NULL,
  `horario` time DEFAULT NULL,
  `local` varchar(100) DEFAULT NULL,
  `status` enum('nao_iniciada','em_andamento','finalizada') DEFAULT 'nao_iniciada',
  PRIMARY KEY (`id`),
  KEY `campeonato_id` (`campeonato_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `resultados_natacao`
--

DROP TABLE IF EXISTS `resultados_natacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `resultados_natacao` (
  `id` int NOT NULL AUTO_INCREMENT,
  `prova_id` int NOT NULL,
  `jogador_id` int NOT NULL,
  `tempo` decimal(10,2) NOT NULL,
  `posicao` int DEFAULT NULL,
  `raia` int DEFAULT NULL,
  `desqualificado` tinyint(1) DEFAULT '0',
  `motivo_desqualificacao` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `prova_id` (`prova_id`),
  KEY `jogador_id` (`jogador_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sets_volei`
--

DROP TABLE IF EXISTS `sets_volei`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sets_volei` (
  `id` int NOT NULL AUTO_INCREMENT,
  `partida_id` int NOT NULL,
  `numero_set` int NOT NULL,
  `pontos_casa` int DEFAULT '0',
  `pontos_fora` int DEFAULT '0',
  `vencedor` int DEFAULT NULL,
  `duracao` int DEFAULT NULL COMMENT 'Duração em segundos',
  PRIMARY KEY (`id`),
  KEY `partida_id` (`partida_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `estatisticas_queimada`
--

DROP TABLE IF EXISTS `estatisticas_queimada`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estatisticas_queimada` (
  `id` int NOT NULL AUTO_INCREMENT,
  `partida_id` int NOT NULL,
  `jogador_id` int NOT NULL,
  `eliminacoes` int DEFAULT '0',
  `eliminado` tinyint(1) DEFAULT '0',
  `tempo_sobrevivencia` int DEFAULT NULL COMMENT 'Tempo em segundos',
  `capitao` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `partida_id` (`partida_id`),
  KEY `jogador_id` (`jogador_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

-- Inserindo dados de exemplo para todas as modalidades
INSERT INTO `campeonatos` (`nome`, `descricao`, `temporada`, `formato`, `modalidade`, `criado_por`, `status`)
VALUES 
('Campeonato de Futebol 2025', 'Campeonato oficial de futebol', 2025, 'Mata-Mata', 'Futebol', 29, 'ativo'),
('Copa de Futsal Municipal', 'Torneio de futsal da cidade', 2025, 'Pontos Corridos', 'Futsal', 29, 'ativo'),
('Torneio de Queimada Escolar', 'Competição entre escolas', 2025, 'Fase de Grupos', 'Queimada', 29, 'ativo'),
('Competição de Natação 2025', 'Provas de natação oficiais', 2025, 'Pontos Corridos', 'Natação', 29, 'ativo'),
('Copa de Vôlei Regional', 'Torneio regional de vôlei', 2025, 'Mata-Mata', 'Vôlei', 29, 'ativo'),
('Campeonato de Duelos 1x1', 'Duelos individuais', 2025, 'Mata-Mata', '1x1', 29, 'ativo'),
('Torneio de Duplas 2x2', 'Competição em duplas', 2025, 'Fase de Grupos', '2x2', 29, 'ativo');

-- Inserindo times para diferentes modalidades
INSERT INTO `times` (`nome`, `cidade`, `admin_id`, `codigo_publico`, `modalidade`)
VALUES
('Estrelas do Futsal', 'Senador Canedo', 29, 'T-FUTSAL1', 'Futsal'),
('Águas Rápidas', 'Senador Canedo', 29, 'T-NATA01', 'Natação'),
('Vôlei Campeão', 'Senador Canedo', 29, 'T-VOLEI1', 'Vôlei'),
('Queimada Show', 'Senador Canedo', 29, 'T-QUEIM1', 'Queimada'),
('Campeões de Dupla', 'Senador Canedo', 29, 'T-DUPLA1', '2x2'),
('Duelistas', 'Senador Canedo', 29, 'T-DUELO1', '1x1');

-- Inserindo jogadores para diferentes modalidades
INSERT INTO `jogadores` (`nome`, `idade`, `nacionalidade`, `posicao`, `time_id`, `modalidade`)
VALUES
('Carlos Silva', 22, 'Brasileiro', 'Pivô', 5, 'Futsal'),
('Marina Santos', 19, 'Brasileira', 'Nado Livre', 6, 'Natação'),
('Bruno Alves', 25, 'Brasileiro', 'Levantador', 7, 'Vôlei'),
('Juliana Costa', 18, 'Brasileira', 'Defesa', 8, 'Queimada'),
('Ricardo Gomes', 24, 'Brasileiro', 'Atacante', 9, '2x2'),
('Fernanda Lima', 21, 'Brasileira', 'Duelista', 10, '1x1');

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */; 