-- MySQL dump 10.13  Distrib 8.2.0, for Linux (x86_64)
--
-- Host: localhost    Database: LiveChat
-- ------------------------------------------------------
-- Server version	8.2.0

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
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `sender` bigint NOT NULL,
  `receiver` bigint NOT NULL,
  `message` text NOT NULL,
  `files` text,
  `date` datetime NOT NULL,
  `seen` datetime DEFAULT NULL,
  `received` datetime DEFAULT NULL,
  `deleted_sender` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_receiver` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `sender` (`sender`),
  KEY `receiver` (`receiver`),
  KEY `date` (`date`,`deleted_sender`,`deleted_receiver`),
  KEY `seen` (`seen`),
  CONSTRAINT `receiver-user` FOREIGN KEY (`receiver`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `sender-user` FOREIGN KEY (`sender`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `userID` bigint NOT NULL,
  `userName` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(64) NOT NULL,
  `image` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `createdAt` datetime NOT NULL,
  `online` int DEFAULT NULL,
  `gender` enum('male','female') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`),
  KEY `userName` (`userName`),
  KEY `email` (`email`),
  KEY `createdAt` (`createdAt`),
  KEY `online` (`online`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,1784876893826717,'chathura','cc@gmail.com','111','ui/images/user1.jpg','2023-12-10 06:54:11',NULL,'male'),(2,1784876924563059,'hima','jj','111k',NULL,'2023-12-10 06:54:40',NULL,'female'),(3,1784877035723461,'emily','emily@gmail.com','111',NULL,'2023-12-10 06:56:26',NULL,'female'),(4,1785181186615298,'chathura226','nhv@gmail.com','12345678',NULL,'2023-12-13 15:30:47',NULL,'male'),(5,1785330596582574,'mary','mary@yahoo.com','password123','uploads/1702774504_1701703835-Screenshot from 2023-11-26 19-32-20.png','2023-12-15 07:05:36',NULL,'female'),(6,1785330631135612,'john','john@yahoo.com','password','uploads/1702807725_test.png','2023-12-15 07:06:09',NULL,'male');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-12-17 12:00:10
