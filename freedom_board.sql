-- MySQL dump 10.13  Distrib 9.6.0, for macos26.2 (arm64)
--
-- Host: localhost    Database: freedom_board
-- ------------------------------------------------------
-- Server version	9.6.0

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

-- Table structure for table `users`

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

-- Dumping data for table `users`

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'alice','$2y$10$5k6hQx7vC8KJb2yT8fZPqO5o8wzvYqzJQf5hJQ2hY1j8cQq1XyQyG'),(2,'bob','$2y$10$7l8Qm9eFJ3GvP8Qn7aT9kOTf1xY4Qb2vP5Q1xYqJc9g8R6Zc2WQ1S'),(3,'charlie','$2y$10$9sJm3Hn5gY7bV1kT8D0xQd9uA7Zk2sW3bP4hFq8vN1pR5aC8FQz6'),(4,'diana','$2y$10$4hF8nK1Pq7YvT5mX0sR3aB7dC9eF2gH6JkL8ZxQ1WcV5M9T2Y1X'),(5,'eve','$2y$10$3aT7Hq8R9sW0xY1Z2F3J4K5L6M7N8P9Q1R2S3T4U5V6W7X8Y9Z'),(6,'Rolf','$2y$10$3aT7Hq8R9sW0xY1Z2F3J4K5L6M7N8P9Q1R2S3T4U5V6W7X8Y9Y');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

-- Table structure for table `posts`

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `content` text NOT NULL,
  `parent_id` int DEFAULT NULL,
  `time_posted` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_user_id` (`user_id`),
  CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
/* ) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci; */
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

-- Dumping data for table `posts`

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,1,'Welcome to the Freedom Board! Feel free to share your thoughts.',NULL,'2026-03-12 14:24:08'),(2,2,'Thanks Alice! Glad to be here.',1,'2026-03-12 14:24:22'),(3,3,'Same here! Looking forward to good discussions.',2,'2026-03-12 14:24:57'),(4,4,'What topics do people usually discuss here?',NULL,'2026-03-12 14:25:10'),(5,1,'Anything really — tech, life, or random thoughts.',4,'2026-03-12 14:25:18'),(6,5,'Hello everyone! First time posting here.',NULL,'2026-03-12 14:25:28'),(7,2,'Welcome Eve!',6,'2026-03-12 14:25:35'),(8,3,'Nice to meet you Eve!',6,'2026-03-12 14:25:42'),(9,4,'Has anyone tried learning Laravel recently?',NULL,'2026-03-12 14:25:53'),(10,1,'Yes! I am currently building a small project with it.',9,'2026-03-12 14:26:00');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-03-12 22:39:43
