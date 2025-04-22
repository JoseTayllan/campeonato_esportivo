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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `avaliacoes`
--

LOCK TABLES `avaliacoes` WRITE;
/*!40000 ALTER TABLE `avaliacoes` DISABLE KEYS */;
INSERT INTO `avaliacoes` VALUES (1,1,2,8,7,9,6,7,'Ótima performance!','2025-03-26 12:07:47'),(2,1,2,8,7,9,6,7.5,'Ótima performance!','2025-03-26 12:38:42'),(3,2,3,NULL,NULL,NULL,NULL,NULL,NULL,'2025-03-26 12:38:42');
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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `campeonatos`
--

LOCK TABLES `campeonatos` WRITE;
/*!40000 ALTER TABLE `campeonatos` DISABLE KEYS */;
INSERT INTO `campeonatos` VALUES (1,'Copa Regionall','Torneio de futebol amadorr',2025,'Mata-Mata','2025-03-17 13:32:34','1x1',5),(2,'Copa Pistão','Campeonato de Noias ',2025,'Mata-Mata','2025-04-19 16:37:57','Futebol',5);
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
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
  PRIMARY KEY (`id`),
  KEY `idx_partida` (`partida_id`),
  KEY `idx_jogador` (`jogador_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estatisticas_partida`
--

LOCK TABLES `estatisticas_partida` WRITE;
/*!40000 ALTER TABLE `estatisticas_partida` DISABLE KEYS */;
INSERT INTO `estatisticas_partida` VALUES (1,1,1,1,1,30,5,2,1,0,60,1),(2,2,1,0,0,10,2,1,0,0,60,0),(3,2,2,0,0,8,1,0,0,0,45,0),(4,3,1,0,0,10,2,1,0,0,60,0),(5,3,2,0,0,8,1,0,0,0,45,0),(6,3,3,0,0,0,0,0,0,0,30,0),(7,1,1,2,1,30,5,2,1,0,60,1),(8,1,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `estatisticas_partida` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fases_campeonato`
--

LOCK TABLES `fases_campeonato` WRITE;
/*!40000 ALTER TABLE `fases_campeonato` DISABLE KEYS */;
INSERT INTO `fases_campeonato` VALUES (1,0,'Pontos Corridos',1),(2,0,'Oitavas de Final',2),(3,0,'Quartas de Final',3),(4,0,'Semifinal',4),(5,0,'Final',5),(10,2,'Pontos Corridos',NULL),(11,2,'Oitavas de Final',NULL),(12,2,'Quartas de Final',NULL),(13,2,'Semifinal',NULL),(14,2,'Final',NULL),(15,1,'Pontos Corridos',NULL),(16,1,'Oitavas de Final',NULL),(17,1,'Quartas de Final',NULL),(18,1,'Semifinal',NULL),(19,1,'Final',NULL);
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
  PRIMARY KEY (`id`),
  KEY `time_id` (`time_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jogadores`
--

LOCK TABLES `jogadores` WRITE;
/*!40000 ALTER TABLE `jogadores` DISABLE KEYS */;
INSERT INTO `jogadores` VALUES (1,'Carlos Mendes',22,'Brasil','Atacante',1),(2,'Neymar',29,'Brasil','Atacante',2),(4,'Diogo Nogueira',0,NULL,'',0),(5,'Diogo Nogueira',0,NULL,'Atacante',0),(6,'Diogo Nogueira',21,'Paudarquensse','Atacante',1),(7,'teste',21,'Paudarquensse','Atacante',1),(8,'Montello',21,'Amador','Zagueiro',5),(9,'José neymar Messi de Cr7',20,'Jogador caro','Atacante',5);
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
  PRIMARY KEY (`id`),
  KEY `campeonato_id` (`campeonato_id`),
  KEY `time_casa` (`time_casa`),
  KEY `time_fora` (`time_fora`),
  KEY `fk_rodada_id` (`rodada_id`),
  KEY `fk_partidas_fase` (`fase_id`),
  CONSTRAINT `fk_partidas_fase` FOREIGN KEY (`fase_id`) REFERENCES `fases_campeonato` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_rodada_id` FOREIGN KEY (`rodada_id`) REFERENCES `rodadas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `partidas`
--

LOCK TABLES `partidas` WRITE;
/*!40000 ALTER TABLE `partidas` DISABLE KEYS */;
INSERT INTO `partidas` VALUES (1,NULL,1,'2025-03-27','15:00:00','Estádio Municipal',1,2,0,0,NULL),(2,NULL,1,'2025-03-27','15:00:00','Estádio Municipal',1,2,0,0,NULL),(3,NULL,1,'2025-03-27','15:00:00','Estádio Municipal',1,2,0,0,NULL),(23,10,0,'2025-04-22','22:59:00','Casa da mãe',2,1,0,0,22),(24,NULL,0,'2025-04-21','12:23:00','Casa da vô',1,2,0,0,23),(25,NULL,0,'2025-04-23','12:21:00','Casa da mae',2,1,0,0,24),(26,NULL,0,'2025-04-03','00:43:00','Casa da vovó',5,1,0,0,22);
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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patrocinador_time`
--

LOCK TABLES `patrocinador_time` WRITE;
/*!40000 ALTER TABLE `patrocinador_time` DISABLE KEYS */;
INSERT INTO `patrocinador_time` VALUES (1,1,1,'2024-01-01','2025-01-01');
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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patrocinadores`
--

LOCK TABLES `patrocinadores` WRITE;
/*!40000 ALTER TABLE `patrocinadores` DISABLE KEYS */;
INSERT INTO `patrocinadores` VALUES (1,'Nike','Contrato válido até 2025',150000.00,'nike_logo.png');
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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rodadas`
--

LOCK TABLES `rodadas` WRITE;
/*!40000 ALTER TABLE `rodadas` DISABLE KEYS */;
INSERT INTO `rodadas` VALUES (21,1,1,'Ida','Abertura','2025-04-20','11:45:00'),(22,10,1,'Ida','Abertura','2025-04-20','12:52:00'),(23,10,2,'Volta','Enceramento','2025-04-21','16:17:00'),(24,14,3,'Ida','Final','2025-04-23','16:17:00');
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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `substituicoes`
--

LOCK TABLES `substituicoes` WRITE;
/*!40000 ALTER TABLE `substituicoes` DISABLE KEYS */;
INSERT INTO `substituicoes` VALUES (1,1,3,5,60),(2,2,1,3,60),(3,3,1,3,60),(4,1,1,3,60);
/*!40000 ALTER TABLE `substituicoes` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `times`
--

LOCK TABLES `times` WRITE;
/*!40000 ALTER TABLE `times` DISABLE KEYS */;
INSERT INTO `times` VALUES (1,'FC Estrelas','img/times/escudo_68066b6690e53.jpeg','São Paulo','Estádio Municipal',7,NULL),(2,'RealVAr','escudio.png','São paulo','Estadio',NULL,NULL),(5,'Barcelama','img/times/escudo_6806922e03791.png','Senador Canedo','Arena canedo',9,'T-6729'),(6,'tralalelo Tralala','img/times/escudo_6806e5de0f0e8.jpg','Senador Canedo','Arena canedo',10,'T-4571');
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
  PRIMARY KEY (`id`),
  KEY `time_id` (`time_id`),
  KEY `campeonato_id` (`campeonato_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `times_campeonatos`
--

LOCK TABLES `times_campeonatos` WRITE;
/*!40000 ALTER TABLE `times_campeonatos` DISABLE KEYS */;
INSERT INTO `times_campeonatos` VALUES (14,2,2),(15,1,2),(11,2,1),(12,1,1),(17,5,2);
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
  `tipo` enum('Administrador','Organizador','Treinador','Jogador','Olheiro','Patrocinador') NOT NULL,
  `criado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `criado_por` int DEFAULT NULL,
  `tipo_assinatura` enum('time','organizador','completo') DEFAULT 'completo',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'João Silva','joao@email.com','$2y$10$gOaKEfzUoO1v7kxjrIYFN.NK9D4pUi/tkvRAvREb2kCT9WXTLfLq2','Organizador','2025-03-17 13:32:34',NULL,'completo'),(2,'Ana Souza','ana@email.com','$2y$10$QOmwrwFnB6WcBtn1hnenG.hs6VaTkozTWDLBzzgxfE0MGGkw.LH.S','Jogador','2025-03-18 22:00:19',NULL,'completo'),(3,'BIBI','B@email.com','$2y$10$SfHZtf93RaCGk8bi/mUw0ektdiQHl/6aHtudzW2F02/yCKKrNh5Eq','Jogador','2025-03-18 22:01:17',NULL,'completo'),(4,'Carlos Silva\n','carlos@email.com','$2y$10$ToPOqxJ0x1rlE6v/0oYsyeOLirViS3XgW4c5AdrcDWeoQcKXAaj6e','Jogador','2025-03-18 22:31:05',NULL,'completo'),(5,'Admin 00','admin@example.com','$2y$10$bJGBQM1Mg.2ipja6no3Hzu7wL5Q2aLhsngkKgy69d7UfWt119R3ZC','Administrador','2025-04-17 12:24:44',NULL,'completo'),(6,'Tecnico','tecnico@example.com','$2y$10$lgdGw.Pv9c8EsElp4rxubuTv4RE/BnD8L53nLnuSi31N.zk.H8Uhy','Treinador','2025-04-19 14:22:07',NULL,'completo'),(7,'Org','org@example.com','$2y$10$MFs4TuimmwC5UvQel8o7AuwI.643Od8ZI9z4UA1Ar7gR5nxCq6dKe','Organizador','2025-04-19 14:25:09',NULL,'time'),(8,'Teste organisador','Org00@example.com','$2y$10$2u5honvPqhy8iudB.zL1yuJN51sIbeHL5k.Z2GIYjHPt7H3kZ37DW','Organizador','2025-04-20 17:06:48',5,'completo'),(9,'TestePlanoTime','Time@example.com','$2y$10$cZZJNUrrV3huTqumO5yyi.F60klh5AY2etDKuY.b735tWy1ECdrKW','Administrador','2025-04-21 16:33:15',NULL,'time'),(10,'joao Tecnico','j@example.com','$2y$10$qX5t9mp87DRQBug5/OCCXOBrTgpd4xEIjzzKJWqln76bSNAdJZe2C','Administrador','2025-04-21 21:11:59',NULL,'time'),(11,'teste evasão','E@example.com','$2y$10$TqFC9bxxttaxzt3AnDYAq.cGVYjAMrEyFxmAd0HbP9fq8DPiXx/RC','Administrador','2025-04-22 00:35:16',NULL,'completo');
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

-- Dump completed on 2025-04-22  9:06:06
