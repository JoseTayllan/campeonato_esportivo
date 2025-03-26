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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `campeonatos`
--

LOCK TABLES `campeonatos` WRITE;
/*!40000 ALTER TABLE `campeonatos` DISABLE KEYS */;
INSERT INTO `campeonatos` VALUES (1,'Copa Regional','Torneio de futebol amador',2025,'Pontos Corridos','2025-03-17 13:32:34');
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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jogadores`
--

LOCK TABLES `jogadores` WRITE;
/*!40000 ALTER TABLE `jogadores` DISABLE KEYS */;
INSERT INTO `jogadores` VALUES (1,'Carlos Mendes',22,'Brasil','Atacante',1),(2,'Neymar',29,'Brasil','Atacante',2);
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
  `campeonato_id` int NOT NULL,
  `data` date NOT NULL,
  `horario` time NOT NULL,
  `local` varchar(100) DEFAULT NULL,
  `time_casa` int NOT NULL,
  `time_fora` int NOT NULL,
  `placar_casa` int DEFAULT '0',
  `placar_fora` int DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `campeonato_id` (`campeonato_id`),
  KEY `time_casa` (`time_casa`),
  KEY `time_fora` (`time_fora`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `partidas`
--

LOCK TABLES `partidas` WRITE;
/*!40000 ALTER TABLE `partidas` DISABLE KEYS */;
INSERT INTO `partidas` VALUES (1,1,'2025-03-27','15:00:00','Estádio Municipal',1,2,0,0),(2,1,'2025-03-27','15:00:00','Estádio Municipal',1,2,0,0),(3,1,'2025-03-27','15:00:00','Estádio Municipal',1,2,0,0);
/*!40000 ALTER TABLE `partidas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patrocinios`
--

DROP TABLE IF EXISTS `patrocinios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `patrocinios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome_empresa` varchar(100) NOT NULL,
  `contrato_valor` decimal(10,2) NOT NULL,
  `time_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `time_id` (`time_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patrocinios`
--

LOCK TABLES `patrocinios` WRITE;
/*!40000 ALTER TABLE `patrocinios` DISABLE KEYS */;
/*!40000 ALTER TABLE `patrocinios` ENABLE KEYS */;
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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `times`
--

LOCK TABLES `times` WRITE;
/*!40000 ALTER TABLE `times` DISABLE KEYS */;
INSERT INTO `times` VALUES (1,'FC Estrela','escudo.png','São Paulo','Estádio Municipal'),(2,'RealVAr','escudio.png','São paulo','Estadio');
/*!40000 ALTER TABLE `times` ENABLE KEYS */;
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'João Silva','joao@email.com','$2y$10$gOaKEfzUoO1v7kxjrIYFN.NK9D4pUi/tkvRAvREb2kCT9WXTLfLq2','Organizador','2025-03-17 13:32:34'),(2,'Ana Souza','ana@email.com','$2y$10$QOmwrwFnB6WcBtn1hnenG.hs6VaTkozTWDLBzzgxfE0MGGkw.LH.S','Jogador','2025-03-18 22:00:19'),(3,'BIBI','B@email.com','$2y$10$SfHZtf93RaCGk8bi/mUw0ektdiQHl/6aHtudzW2F02/yCKKrNh5Eq','Jogador','2025-03-18 22:01:17'),(4,'Carlos Silva\n','carlos@email.com','$2y$10$ToPOqxJ0x1rlE6v/0oYsyeOLirViS3XgW4c5AdrcDWeoQcKXAaj6e','Jogador','2025-03-18 22:31:05');
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

-- Dump completed on 2025-03-26 10:04:36
