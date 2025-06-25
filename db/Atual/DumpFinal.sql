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
  `qr_code_localizacao` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `campeonatos`
--

LOCK TABLES `campeonatos` WRITE;
/*!40000 ALTER TABLE `campeonatos` DISABLE KEYS */;
INSERT INTO `campeonatos` VALUES (9,'Teste','asdasd',2025,'Mata-Mata','2025-05-09 20:18:58','Futebol',29,'ativo',NULL),(10,'Fruitibolas','Fruitibol',2025,'Pontos Corridos','2025-05-13 12:19:01','Futebol',37,'ativo',NULL);
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
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `escalacoes`
--

LOCK TABLES `escalacoes` WRITE;
/*!40000 ALTER TABLE `escalacoes` DISABLE KEYS */;
INSERT INTO `escalacoes` VALUES (9,8,8,1,NULL,0,0),(10,8,9,1,NULL,1,0);
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
) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estatisticas_partida`
--

LOCK TABLES `estatisticas_partida` WRITE;
/*!40000 ALTER TABLE `estatisticas_partida` DISABLE KEYS */;
INSERT INTO `estatisticas_partida` VALUES (41,8,6,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,0),(42,8,8,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,0,0,0,0),(43,8,6,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,0,0,0,0),(44,8,7,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,1,0),(45,8,7,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,1),(46,8,9,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,0,0),(47,9,7,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,1,0),(48,9,7,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,2,0,0,0),(49,9,8,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,0,0,0,0),(50,9,9,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,1),(51,9,7,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,1),(52,9,7,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,1,0),(53,9,7,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,2,0,0,0),(54,9,8,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,0,0,0,0),(55,9,9,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,1),(56,9,7,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,1),(57,9,7,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,1,0),(58,9,7,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,2,0,0,0),(59,9,8,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,0,0,0,0),(60,9,9,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,1),(61,9,7,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,1);
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
  `tipo_evento` enum('gol','cartao_amarelo','cartao_vermelho','substituicao','posse_bola','finalizacao','outro','defesa','penalti_defendido') DEFAULT NULL,
  `minuto` varchar(10) DEFAULT NULL,
  `descricao` text,
  `criado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `partida_id` (`partida_id`),
  KEY `jogador_id` (`jogador_id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eventos_partida`
--

LOCK TABLES `eventos_partida` WRITE;
/*!40000 ALTER TABLE `eventos_partida` DISABLE KEYS */;
INSERT INTO `eventos_partida` VALUES (14,8,6,5,'gol','26','Gol de cabeça, subiu dois metros de altura','2025-05-12 16:17:31'),(15,8,8,6,'cartao_amarelo','00','pegou nas bolas do amigo','2025-05-12 16:58:02'),(16,8,6,5,'cartao_vermelho','01','Imprusdencia carrinho na area','2025-05-12 16:58:40'),(17,8,7,5,'penalti_defendido','01','Buscou no cantinho','2025-05-12 16:58:56'),(18,9,7,5,'penalti_defendido','00','ddd','2025-05-13 18:48:36'),(19,9,7,5,'defesa','00','','2025-05-13 18:48:42'),(20,9,7,5,'defesa','00','ddd','2025-05-13 18:48:48'),(21,9,8,6,'cartao_vermelho','00','sasa','2025-05-13 18:49:04'),(22,10,6,5,'gol','11','Goll','2025-05-14 14:18:25');
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
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fases_campeonato`
--

LOCK TABLES `fases_campeonato` WRITE;
/*!40000 ALTER TABLE `fases_campeonato` DISABLE KEYS */;
INSERT INTO `fases_campeonato` VALUES (49,9,'Fase de Grupos',1),(50,9,'Oitavas de Final',1),(51,9,'Quartas de Final',1),(52,9,'Semifinal',1),(53,9,'Final',1),(54,9,'Pontos Corridos',1),(55,10,'Fase de Grupos',1),(56,10,'Oitavas de Final',1),(57,10,'Quartas de Final',1),(58,10,'Semifinal',1),(59,10,'Final',1),(60,10,'Pontos Corridos',1);
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
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jogadores`
--

LOCK TABLES `jogadores` WRITE;
/*!40000 ALTER TABLE `jogadores` DISABLE KEYS */;
INSERT INTO `jogadores` VALUES (6,'Messi',20,'Brasileiro','Atacante',5,'68226aee72835.jpg'),(7,'Neuer',21,'Brasileiro','Goleiro',5,'68226af47ce57.jpg'),(8,'Robinho Pedala nelas',21,'Brasileiro','Atacante',6,'682217d8ab925.jpg'),(9,'Bruno samudio ',23,'Brasileiro','Goleiro',6,'682217e99b199.jpg'),(10,'Messi',21,'Brasileiro','Atacante',7,'68238a329a619.jpg'),(11,'Neuer',21,'Brasileiro','Goleiro',7,'682391cc7138f.jpg');
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
  `link_transmissao` text,
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
-- Dumping data for table `partidas`
--

LOCK TABLES `partidas` WRITE;
/*!40000 ALTER TABLE `partidas` DISABLE KEYS */;
INSERT INTO `partidas` VALUES (9,50,9,'2025-05-13','16:47:00','Casa da vovó',6,5,0,0,4,'finalizada','2025-05-13 19:51:37','rodando',0,191,NULL,NULL),(11,50,9,'2025-05-11','17:34:00','Casa da vovó',5,6,0,0,4,'em_andamento',NULL,'pausado',0,1,NULL,'https://www.youtube.com/watch?v=jfKfPfyJRdk'),(12,50,9,'2025-05-16','15:37:00','Casa da vovó',6,5,0,0,4,'em_andamento',NULL,'pausado',0,0,NULL,NULL),(13,50,9,'2025-04-30','15:02:00','Casa da vovó',5,6,0,0,4,'nao_iniciada',NULL,'rodando',0,0,NULL,NULL);
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
  `valor_investido` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `patrocinador_id` (`patrocinador_id`),
  KEY `time_id` (`time_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
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
  `telefone` varchar(11) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `usuario_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rodadas`
--

LOCK TABLES `rodadas` WRITE;
/*!40000 ALTER TABLE `rodadas` DISABLE KEYS */;
INSERT INTO `rodadas` VALUES (4,50,1,'Ida','Abertura','2025-05-09','17:28:00'),(5,53,1,'Ida','Abertura','2025-05-14','15:05:00');
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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `times`
--

LOCK TABLES `times` WRITE;
/*!40000 ALTER TABLE `times` DISABLE KEYS */;
INSERT INTO `times` VALUES (5,'Jota','public/img/times/escudo_68226ad85ca95.png','Senador Canedo','Arena canedo',34,'T-9418'),(6,'Cortinas','public/img/times/escudo_682217c54e18a.jpg','Senador Canedo','Arena canedo',32,'T-4023'),(7,'Maratonistas','public/img/times/escudo_68238a0dcea56.png','Senador Canedo','Arena canedo',42,'T-0509');
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
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `times_campeonatos`
--

LOCK TABLES `times_campeonatos` WRITE;
/*!40000 ALTER TABLE `times_campeonatos` DISABLE KEYS */;
INSERT INTO `times_campeonatos` VALUES (12,5,9,0,0,0,0,0,0,0),(9,6,9,3,0,3,1,4,0,1);
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
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (29,'JOSE TAYLLAN PINTO ALMEIDA','admin@example.com','$2y$10$JBUf4Mi4Xsyb.MR2rBoj5.3iHDI1WtWALZ58bKAaixvx2SqvwZA9e','Administrador','2025-05-09 20:18:33',NULL,'completo'),(30,'Palmeieras','Pal@example.com','$2y$10$/qlZtr7dkRmc7w.y.LlTjuxDR7evgtBAqBY6bfbUFJZIUmnUyawbu','Administrador','2025-05-12 15:30:30',NULL,'time'),(31,'Jota','J@example.com','$2y$10$O7dDBdQ7wberc71B7dXnmOlTTenGhXquPgEf.HlBP8d4a.VYh1LYa','Administrador','2025-05-12 15:33:05',NULL,'time'),(32,'Cortinas','C@example.com','$2y$10$cqK5d1eK/Kv7FlmOeKdhKO2h3/Vlm7QLPfFMRpq7CtdHys55jrYbO','Administrador','2025-05-12 15:35:40',NULL,'time'),(33,'flamengo','F@example.com','$2y$10$nSdV/qEeHktWnl/DfvmIQ.JzgFWZg8NdKz906273JJTn1pc8ykwru','Administrador','2025-05-12 15:37:01',NULL,'time'),(34,'Pipi','P@example.com','$2y$10$sfacFLUhVB5KIFyP3uv5XuUqcyciYcBuCyuf3SdNgRyrYWs/GMYXW','Administrador','2025-05-12 15:38:17',NULL,'time'),(35,'testeLock','T@example.com','$2y$10$4SL13ra1x7xGecM0ZTScR.XMCR1l75sM00JiifgGiDFpLymaDNw.S','Administrador','2025-05-12 15:39:27',NULL,'time'),(36,'teste','r@example.com','$2y$10$9vJJYrmLUaQye1Ualvg9Z.X7IomhZ6UilTFTlsIltccKd6lumE2mK','Organizador','2025-05-12 23:53:48',29,'completo'),(37,'Divergente','d@example.com','$2y$10$KkFiMA3hlMurtA9jO4n9aOdPFaRSvaGPhFvjYeUrIxhoEXcSHy7XC','Administrador','2025-05-13 12:18:26',NULL,'completo'),(38,'l','l@example.com','$2y$10$4d2Av4ivC8iSV.TwdH1Vj.0r4DAeKlFc5tDq1chWjJEYqr5DRnm8S','Organizador','2025-05-13 13:06:26',37,'completo'),(39,'Ronaldinho','ronaldo@example.com','$2y$10$xXDMwk2HWZT36XCJQYCHvOH9IjHI8fxhPiGXyvHRaDyC7vuhPSwrm','Olheiro','2025-05-13 17:41:28',NULL,'completo'),(40,'Marcio','marcio@example.com','$2y$10$c8Y103xSk7o/VmZPXT9uiOcIQ6KMbylbNwr/Nq8n6CLvXYVGaorpq','Administrador','2025-05-13 17:44:49',NULL,'time'),(41,'Jota','ccc@example.com','$2y$10$0sSLY0kO.6JxGKD1EGCkReADzXnXnW2v/QwAZY0YCJtJV36jqc1Cm','Administrador','2025-05-13 17:47:43',NULL,'time'),(42,'mimi','mimi@example.com','$2y$10$8oOYCXP/8koRmJU3h.4Qhe6pPD8CoKQMnD3SlgbqYuayF02a1QYMq','Administrador','2025-05-13 17:52:13',NULL,'time');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'campeonato_esportivo'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-19 10:41:48
