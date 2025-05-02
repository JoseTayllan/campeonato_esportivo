CREATE DATABASE  IF NOT EXISTS `campeonato_esportivo` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `campeonato_esportivo`;
-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: localhost    Database: campeonato_esportivo
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `avaliacoes`
--

LOCK TABLES `avaliacoes` WRITE;
/*!40000 ALTER TABLE `avaliacoes` DISABLE KEYS */;
/*!40000 ALTER TABLE `avaliacoes` ENABLE KEYS */;
UNLOCK TABLES;

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
  `modalidade` varchar(20) DEFAULT 'Futebol',
  `criado_por` int NOT NULL,
  `status` varchar(20) DEFAULT 'ativo',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `campeonatos`
--

LOCK TABLES `campeonatos` WRITE;
/*!40000 ALTER TABLE `campeonatos` DISABLE KEYS */;
/*!40000 ALTER TABLE `campeonatos` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=MyISAM AUTO_INCREMENT=175 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `escalacoes`
--

LOCK TABLES `escalacoes` WRITE;
/*!40000 ALTER TABLE `escalacoes` DISABLE KEYS */;
/*!40000 ALTER TABLE `escalacoes` ENABLE KEYS */;
UNLOCK TABLES;

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
  PRIMARY KEY (`id`),
  KEY `idx_partida` (`partida_id`),
  KEY `idx_jogador` (`jogador_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estatisticas_partida`
--

LOCK TABLES `estatisticas_partida` WRITE;
/*!40000 ALTER TABLE `estatisticas_partida` DISABLE KEYS */;
/*!40000 ALTER TABLE `estatisticas_partida` ENABLE KEYS */;
UNLOCK TABLES;

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
  `tipo_evento` enum('gol','cartao_amarelo','cartao_vermelho','substituicao','posse_bola','finalizacao','outro') NOT NULL,
  `minuto` varchar(10) DEFAULT NULL,
  `descricao` text,
  `criado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `partida_id` (`partida_id`),
  KEY `jogador_id` (`jogador_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eventos_partida`
--

LOCK TABLES `eventos_partida` WRITE;
/*!40000 ALTER TABLE `eventos_partida` DISABLE KEYS */;
/*!40000 ALTER TABLE `eventos_partida` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fases_campeonato`
--

LOCK TABLES `fases_campeonato` WRITE;
/*!40000 ALTER TABLE `fases_campeonato` DISABLE KEYS */;
/*!40000 ALTER TABLE `fases_campeonato` ENABLE KEYS */;
UNLOCK TABLES;

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
  `posicao` enum('Goleiro','Zagueiro','Lateral','Meia','Atacante') NOT NULL,
  `time_id` int DEFAULT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `time_id` (`time_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jogadores`
--

LOCK TABLES `jogadores` WRITE;
/*!40000 ALTER TABLE `jogadores` DISABLE KEYS */;
/*!40000 ALTER TABLE `jogadores` ENABLE KEYS */;
UNLOCK TABLES;

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
  PRIMARY KEY (`id`),
  KEY `campeonato_id` (`campeonato_id`),
  KEY `time_casa` (`time_casa`),
  KEY `time_fora` (`time_fora`),
  KEY `fk_rodada_id` (`rodada_id`),
  KEY `fk_partidas_fase` (`fase_id`),
  CONSTRAINT `fk_partidas_fase` FOREIGN KEY (`fase_id`) REFERENCES `fases_campeonato` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_rodada_id` FOREIGN KEY (`rodada_id`) REFERENCES `rodadas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `partidas`
--

LOCK TABLES `partidas` WRITE;
/*!40000 ALTER TABLE `partidas` DISABLE KEYS */;
/*!40000 ALTER TABLE `partidas` ENABLE KEYS */;
UNLOCK TABLES;

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
  PRIMARY KEY (`id`),
  KEY `patrocinador_id` (`patrocinador_id`),
  KEY `time_id` (`time_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patrocinador_time`
--

LOCK TABLES `patrocinador_time` WRITE;
/*!40000 ALTER TABLE `patrocinador_time` DISABLE KEYS */;
/*!40000 ALTER TABLE `patrocinador_time` ENABLE KEYS */;
UNLOCK TABLES;

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
  `valor_investido` decimal(10,2) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patrocinadores`
--

LOCK TABLES `patrocinadores` WRITE;
/*!40000 ALTER TABLE `patrocinadores` DISABLE KEYS */;
/*!40000 ALTER TABLE `patrocinadores` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rodadas`
--

LOCK TABLES `rodadas` WRITE;
/*!40000 ALTER TABLE `rodadas` DISABLE KEYS */;
/*!40000 ALTER TABLE `rodadas` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `substituicoes`
--

LOCK TABLES `substituicoes` WRITE;
/*!40000 ALTER TABLE `substituicoes` DISABLE KEYS */;
/*!40000 ALTER TABLE `substituicoes` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `atualizar_minutos_apos_substituicao` AFTER INSERT ON `substituicoes` FOR EACH ROW BEGIN
    -- Atualiza minutos jogados para quem saiu (assumindo que saiu no minuto exato da substituição)
    UPDATE estatisticas_partida
    SET minutos_jogados = NEW.minuto_substituicao
    WHERE jogador_id = NEW.jogador_saiu AND partida_id = NEW.partida_id;

    -- Atualiza minutos jogados para quem entrou (assumindo que jogou o restante da partida)
    UPDATE estatisticas_partida
    SET minutos_jogados = 90 - NEW.minuto_substituicao
    WHERE jogador_id = NEW.jogador_entrou AND partida_id = NEW.partida_id;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

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
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo_publico` (`codigo_publico`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `times`
--

LOCK TABLES `times` WRITE;
/*!40000 ALTER TABLE `times` DISABLE KEYS */;
/*!40000 ALTER TABLE `times` ENABLE KEYS */;
UNLOCK TABLES;

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
  PRIMARY KEY (`id`),
  KEY `time_id` (`time_id`),
  KEY `campeonato_id` (`campeonato_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `times_campeonatos`
--

LOCK TABLES `times_campeonatos` WRITE;
/*!40000 ALTER TABLE `times_campeonatos` DISABLE KEYS */;
/*!40000 ALTER TABLE `times_campeonatos` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-29 19:10:11

SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE `avaliacoes`;
TRUNCATE TABLE `campeonatos`;
TRUNCATE TABLE `escalacoes`;
TRUNCATE TABLE `estatisticas_partida`;
TRUNCATE TABLE `eventos_partida`;
TRUNCATE TABLE `fases_campeonato`;
TRUNCATE TABLE `jogadores`;
TRUNCATE TABLE `partidas`;
TRUNCATE TABLE `patrocinador_time`;
TRUNCATE TABLE `patrocinadores`;
TRUNCATE TABLE `rodadas`;
TRUNCATE TABLE `substituicoes`;
TRUNCATE TABLE `times`;
TRUNCATE TABLE `times_campeonatos`;
TRUNCATE TABLE `usuarios`;
SET FOREIGN_KEY_CHECKS = 1;