-- MySQL dump 10.13  Distrib 8.0.25, for Linux (x86_64)
--
-- Host: localhost    Database: voodoo
-- ------------------------------------------------------
-- Server version	8.0.25-0ubuntu0.20.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `api_ban`
--

DROP TABLE IF EXISTS `api_ban`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `api_ban` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL DEFAULT '0',
  `expires` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `api_ban`
--

LOCK TABLES `api_ban` WRITE;
/*!40000 ALTER TABLE `api_ban` DISABLE KEYS */;
/*!40000 ALTER TABLE `api_ban` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `api_users`
--

DROP TABLE IF EXISTS `api_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `api_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `api_key` varchar(45) DEFAULT NULL,
  `host` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `api_users`
--

LOCK TABLES `api_users` WRITE;
/*!40000 ALTER TABLE `api_users` DISABLE KEYS */;
INSERT INTO `api_users` VALUES (1,'test','localhost');
/*!40000 ALTER TABLE `api_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rooms`
--

DROP TABLE IF EXISTS `rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rooms` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(30) DEFAULT NULL,
  `topic` text,
  `bot` varchar(45) DEFAULT NULL,
  `allowed_users` int NOT NULL DEFAULT '0',
  `last_action` int NOT NULL DEFAULT '0',
  `password` varchar(64) DEFAULT NULL,
  `jail` int NOT NULL DEFAULT '0',
  `points` int NOT NULL DEFAULT '0',
  `created_at` int NOT NULL DEFAULT '0',
  `updated_at` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rooms`
--

LOCK TABLES `rooms` WRITE;
/*!40000 ALTER TABLE `rooms` DISABLE KEYS */;
INSERT INTO `rooms` VALUES (1,'Все',NULL,NULL,0,0,NULL,0,0,0,0),(2,'Сад',NULL,NULL,0,0,NULL,1,0,0,0);
/*!40000 ALTER TABLE `rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `session` varchar(64) DEFAULT NULL,
  `nick` varchar(30) DEFAULT NULL,
  `canon_nick` varchar(30) DEFAULT NULL,
  `html_nick` text,
  `sex` int NOT NULL DEFAULT '0',
  `last_action` int NOT NULL DEFAULT '0',
  `class` int NOT NULL DEFAULT '0',
  `city` varchar(100) DEFAULT NULL,
  `photo_url` text,
  `created_at` int NOT NULL DEFAULT '0',
  `updated_at` int NOT NULL DEFAULT '0',
  `b_day` int NOT NULL DEFAULT '1',
  `b_month` int NOT NULL DEFAULT '1',
  `b_year` int NOT NULL DEFAULT '1970',
  `points` int NOT NULL DEFAULT '0',
  `credits` int NOT NULL DEFAULT '0',
  `rewards` int NOT NULL DEFAULT '0',
  `damneds` int NOT NULL DEFAULT '0',
  `room` int NOT NULL DEFAULT '0',
  `status` int NOT NULL DEFAULT '0',
  `photo_rating` int NOT NULL DEFAULT '0',
  `first_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `about` text,
  `enter_phrase` text,
  `leave_phrase` text,
  `ip` varchar(15) DEFAULT '0.0.0.0',
  `online_time` int NOT NULL DEFAULT '0',
  `married_with` varchar(30) DEFAULT NULL,
  `referred_by` int NOT NULL DEFAULT '0',
  `invis` int NOT NULL DEFAULT '0',
  `filter` int NOT NULL DEFAULT '0',
  `silence` int NOT NULL DEFAULT '0',
  `silence_start` int NOT NULL DEFAULT '0',
  `bot` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,NULL,'SubZero','admin','<img src=\"http://localhost/uploads/txcqn.gif\" />',2,1621532372,1024,NULL,NULL,0,0,1,1,1970,0,0,0,0,1,0,0,NULL,NULL,NULL,NULL,NULL,NULL,'0.0.0.0',0,NULL,0,0,0,0,0,0),(2,NULL,'Дворецкий',NULL,'Дворецкий',0,1621532372,0,NULL,NULL,0,0,1,1,1970,0,0,0,0,1,0,0,NULL,NULL,NULL,NULL,NULL,NULL,'0.0.0.0',0,NULL,0,0,0,0,0,1),(3,NULL,'Снегурочка','id3','Снегурочка',1,1621532372,0,NULL,NULL,0,0,1,1,1970,0,0,0,0,1,0,0,NULL,NULL,NULL,NULL,NULL,NULL,'0.0.0.0',0,NULL,0,0,0,0,0,0),(4,NULL,'ШалуньЯ','id4','ШалуньЯ',1,1621532372,0,NULL,NULL,0,0,1,1,1970,0,0,0,0,1,0,0,NULL,NULL,NULL,NULL,NULL,NULL,'0.0.0.0',0,NULL,0,0,0,0,0,0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-05-20 22:48:37
