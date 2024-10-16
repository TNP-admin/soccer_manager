-- MariaDB dump 10.19  Distrib 10.5.22-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: s_mane
-- ------------------------------------------------------
-- Server version	10.5.22-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `clubs`
--

DROP TABLE IF EXISTS `clubs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clubs` (
  `club_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `club_name` varchar(60) NOT NULL,
  `club_representative` bigint(20) unsigned DEFAULT NULL,
  `club_url` varchar(400) DEFAULT NULL,
  `city_association` int(10) unsigned NOT NULL,
  `prefecture_federation` int(10) unsigned NOT NULL,
  `club_status` int(10) unsigned NOT NULL,
  `clubs_created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `clubs_updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`club_id`),
  KEY `clubs_club_representative_foreign` (`club_representative`),
  CONSTRAINT `clubs_club_representative_foreign` FOREIGN KEY (`club_representative`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clubs`
--

LOCK TABLES `clubs` WRITE;
/*!40000 ALTER TABLE `clubs` DISABLE KEYS */;
INSERT INTO `clubs` VALUES (1,'所属なし',NULL,NULL,1302,131229,0,'2023-11-25 20:00:00',NULL),(2,'柴又kids',NULL,'https://www.instagram.com/shibamatakids/?hl=ja',1302,13122,0,'2023-11-25 20:00:00',NULL),(3,'TKフィッシャーズ',NULL,NULL,131229,1302,0,'2023-11-25 14:41:38',NULL),(4,'えどそら',NULL,NULL,131229,1302,0,'2023-11-25 14:42:26',NULL),(5,'本田',NULL,NULL,131229,1302,0,'2023-11-25 14:43:13',NULL),(6,'南綾瀬',NULL,NULL,131229,1302,0,'2023-11-25 15:12:00',NULL),(8,'綾南',NULL,NULL,131229,1302,0,'2023-11-25 15:49:41',NULL),(9,'ジェファFC',NULL,'https://jefafc.jimdofree.com/',131229,1302,0,'2023-11-29 09:20:34',NULL),(10,'ミズモFC',NULL,'https://www.mizumo-fc.com/',131229,1302,0,'2023-11-29 09:26:30',NULL),(11,'FC.EDO',NULL,'https://www.facebook.com/fcedo2004/?locale=ja_JP',131229,1302,0,'2023-11-29 09:29:29',NULL),(12,'金町FC',NULL,'https://kanamachisc.wixsite.com/kanamachisc',131229,1302,0,'2023-12-23 12:53:22',NULL),(13,'FC北野',NULL,'https://fckitano.jp/',131229,1302,0,'2023-12-23 12:54:33',NULL),(14,'葛飾フレンドリーSC',NULL,'https://www.friendly-club.com/',131229,1302,0,'2023-12-23 12:55:59',NULL),(15,'住吉FC',NULL,'https://sumiyoshi-fc.theblog.me/',131229,1302,0,'2023-12-23 12:57:59',NULL),(16,'ノッソFC',NULL,'https://nosso-fc.jimdofree.com/',131229,1302,0,'2023-12-23 12:58:50',NULL);
/*!40000 ALTER TABLE `clubs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fouls`
--

DROP TABLE IF EXISTS `fouls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fouls` (
  `foul_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `match_id` int(10) unsigned NOT NULL,
  `id` bigint(20) unsigned NOT NULL,
  `club_id` int(10) unsigned NOT NULL,
  `foul_cards` int(10) unsigned NOT NULL,
  `foul_time` time NOT NULL,
  `fouls_created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fouls_updated_at` timestamp NULL DEFAULT NULL,
  `foul_period` int(10) unsigned NOT NULL,
  PRIMARY KEY (`foul_id`),
  KEY `fouls_match_id_foreign` (`match_id`),
  KEY `fouls_id_foreign` (`id`),
  KEY `fouls_club_id_foreign` (`club_id`),
  CONSTRAINT `fouls_club_id_foreign` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`club_id`),
  CONSTRAINT `fouls_id_foreign` FOREIGN KEY (`id`) REFERENCES `users` (`id`),
  CONSTRAINT `fouls_match_id_foreign` FOREIGN KEY (`match_id`) REFERENCES `matches` (`match_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fouls`
--

LOCK TABLES `fouls` WRITE;
/*!40000 ALTER TABLE `fouls` DISABLE KEYS */;
INSERT INTO `fouls` VALUES (1,1,79,6,0,'00:06:13','2023-11-25 15:25:59',NULL,0),(2,3,12,2,0,'12:13:20','2023-11-25 16:52:47',NULL,0),(3,4,25,3,0,'00:10:20','2023-11-25 17:40:50',NULL,0);
/*!40000 ALTER TABLE `fouls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `matches`
--

DROP TABLE IF EXISTS `matches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `matches` (
  `match_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `match_name` varchar(60) DEFAULT NULL,
  `match_status` int(10) unsigned NOT NULL,
  `match_date` date NOT NULL,
  `schedule_start` time NOT NULL,
  `regulation_time` int(10) unsigned NOT NULL,
  `match_start` timestamp NULL DEFAULT NULL,
  `half` int(10) unsigned NOT NULL,
  `home` int(10) unsigned NOT NULL,
  `home_2` int(10) unsigned DEFAULT NULL,
  `home_3` int(10) unsigned DEFAULT NULL,
  `home_4` int(10) unsigned DEFAULT NULL,
  `home_5` int(10) unsigned DEFAULT NULL,
  `away` int(10) unsigned NOT NULL,
  `away_2` int(10) unsigned DEFAULT NULL,
  `away_3` int(10) unsigned DEFAULT NULL,
  `away_4` int(10) unsigned DEFAULT NULL,
  `away_5` int(10) unsigned DEFAULT NULL,
  `pitch_id` int(10) unsigned NOT NULL,
  `a_side` int(10) unsigned NOT NULL,
  `home_formation` int(10) unsigned NOT NULL,
  `away_formation` int(10) unsigned NOT NULL,
  `weather` int(11) DEFAULT NULL,
  `temperature` int(11) DEFAULT NULL,
  `humidity` int(11) DEFAULT NULL,
  `wind` varchar(60) DEFAULT NULL,
  `grass` int(11) DEFAULT NULL,
  `condition` varchar(60) DEFAULT NULL,
  `cancel` int(11) NOT NULL,
  `movie_url` varchar(400) DEFAULT NULL,
  `match_remarks` varchar(255) DEFAULT NULL,
  `confirm` int(10) unsigned NOT NULL,
  `home_confirm` int(10) unsigned NOT NULL,
  `away_confirm` int(10) unsigned NOT NULL,
  `matches_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `matches_updated_at` timestamp NULL DEFAULT NULL,
  `period_start` timestamp NULL DEFAULT NULL,
  `extra_time` int(10) unsigned NOT NULL,
  `pk` int(10) unsigned NOT NULL,
  PRIMARY KEY (`match_id`),
  KEY `matches_home_foreign` (`home`),
  KEY `matches_home_2_foreign` (`home_2`),
  KEY `matches_home_3_foreign` (`home_3`),
  KEY `matches_home_4_foreign` (`home_4`),
  KEY `matches_home_5_foreign` (`home_5`),
  KEY `matches_away_foreign` (`away`),
  KEY `matches_away_2_foreign` (`away_2`),
  KEY `matches_away_3_foreign` (`away_3`),
  KEY `matches_away_4_foreign` (`away_4`),
  KEY `matches_away_5_foreign` (`away_5`),
  KEY `matches_pitch_id_foreign` (`pitch_id`),
  CONSTRAINT `matches_away_2_foreign` FOREIGN KEY (`away_2`) REFERENCES `clubs` (`club_id`),
  CONSTRAINT `matches_away_3_foreign` FOREIGN KEY (`away_3`) REFERENCES `clubs` (`club_id`),
  CONSTRAINT `matches_away_4_foreign` FOREIGN KEY (`away_4`) REFERENCES `clubs` (`club_id`),
  CONSTRAINT `matches_away_5_foreign` FOREIGN KEY (`away_5`) REFERENCES `clubs` (`club_id`),
  CONSTRAINT `matches_away_foreign` FOREIGN KEY (`away`) REFERENCES `clubs` (`club_id`),
  CONSTRAINT `matches_home_2_foreign` FOREIGN KEY (`home_2`) REFERENCES `clubs` (`club_id`),
  CONSTRAINT `matches_home_3_foreign` FOREIGN KEY (`home_3`) REFERENCES `clubs` (`club_id`),
  CONSTRAINT `matches_home_4_foreign` FOREIGN KEY (`home_4`) REFERENCES `clubs` (`club_id`),
  CONSTRAINT `matches_home_5_foreign` FOREIGN KEY (`home_5`) REFERENCES `clubs` (`club_id`),
  CONSTRAINT `matches_home_foreign` FOREIGN KEY (`home`) REFERENCES `clubs` (`club_id`),
  CONSTRAINT `matches_pitch_id_foreign` FOREIGN KEY (`pitch_id`) REFERENCES `pitches` (`pitch_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `matches`
--

LOCK TABLES `matches` WRITE;
/*!40000 ALTER TABLE `matches` DISABLE KEYS */;
INSERT INTO `matches` VALUES (1,NULL,0,'2023-11-26','09:15:00',20,NULL,2,2,NULL,NULL,NULL,NULL,6,NULL,NULL,NULL,NULL,10,6,0,0,0,NULL,NULL,NULL,0,NULL,0,NULL,NULL,0,1,0,'2023-11-25 15:12:48','2023-11-25 15:29:56',NULL,0,0),(2,NULL,0,'2023-11-26','10:05:00',20,NULL,2,2,NULL,NULL,NULL,NULL,8,11,NULL,NULL,NULL,10,6,0,0,0,NULL,NULL,NULL,0,NULL,0,NULL,NULL,0,1,0,'2023-12-01 02:52:46','2023-11-25 16:22:33',NULL,0,0),(3,NULL,0,'2023-11-26','10:30:00',20,NULL,2,2,NULL,NULL,NULL,NULL,4,NULL,NULL,NULL,NULL,10,6,0,0,0,NULL,NULL,NULL,0,NULL,0,NULL,NULL,0,0,0,'2023-11-25 15:56:34','2023-11-25 16:49:27',NULL,0,0),(4,NULL,0,'2023-11-26','11:20:00',20,NULL,2,2,NULL,NULL,NULL,NULL,3,NULL,NULL,NULL,NULL,10,6,0,0,0,NULL,NULL,NULL,0,NULL,0,NULL,NULL,0,0,0,'2023-11-25 17:06:07','2023-11-25 17:42:48',NULL,0,0),(5,NULL,0,'2023-11-26','11:45:00',20,NULL,2,2,NULL,NULL,NULL,NULL,5,NULL,NULL,NULL,NULL,10,6,0,0,0,NULL,NULL,NULL,0,NULL,0,NULL,NULL,0,0,0,'2023-11-25 17:08:45','2023-11-25 18:09:06',NULL,0,0),(6,NULL,0,'2023-11-26','14:30:00',30,NULL,2,2,NULL,NULL,NULL,NULL,6,NULL,NULL,NULL,NULL,10,8,0,0,0,NULL,NULL,NULL,0,NULL,0,NULL,NULL,0,0,0,'2023-11-25 18:57:23','2023-11-25 20:27:52',NULL,0,0),(7,NULL,0,'2023-12-03','09:50:00',30,NULL,3,10,NULL,NULL,NULL,NULL,8,9,11,NULL,NULL,5,8,0,0,0,NULL,NULL,NULL,0,NULL,0,NULL,NULL,0,1,0,'2023-11-29 09:59:13','2023-12-07 02:16:34',NULL,0,0),(8,NULL,0,'2023-12-03','11:30:00',30,'2023-12-06 22:18:47',2,8,9,11,NULL,NULL,10,NULL,NULL,NULL,NULL,5,8,0,0,0,NULL,NULL,NULL,0,NULL,0,NULL,NULL,0,0,0,'2023-12-01 02:50:30','2023-12-06 22:18:47',NULL,0,0),(9,'決勝トーナメント第1節',0,'2023-12-24','09:00:00',30,NULL,2,12,NULL,NULL,NULL,NULL,5,NULL,NULL,NULL,NULL,5,8,0,0,0,NULL,NULL,NULL,0,NULL,0,NULL,NULL,0,1,0,'2023-12-23 14:29:45','2023-12-23 20:45:37',NULL,0,0),(10,'JSL決勝トーナメント第2節',0,'2023-12-24','09:50:00',30,NULL,2,13,NULL,NULL,NULL,NULL,14,NULL,NULL,NULL,NULL,5,8,0,0,0,NULL,NULL,NULL,0,NULL,0,NULL,NULL,0,1,0,'2023-12-23 14:31:22','2023-12-23 20:46:31',NULL,0,0),(11,'JSL決勝トーナメント第3節',0,'2023-12-24','10:40:00',30,NULL,2,15,NULL,NULL,NULL,NULL,16,NULL,NULL,NULL,NULL,5,8,0,0,0,NULL,NULL,NULL,0,NULL,0,NULL,NULL,0,1,0,'2023-12-23 14:32:20','2023-12-23 20:47:24',NULL,0,0),(12,'JSL決勝トーナメント第4節',0,'2023-12-24','11:30:00',30,NULL,2,2,NULL,NULL,NULL,NULL,10,NULL,NULL,NULL,NULL,5,8,0,0,0,NULL,NULL,NULL,0,NULL,0,NULL,NULL,0,1,0,'2023-12-23 14:35:08','2023-12-23 20:49:59',NULL,0,0);
/*!40000 ALTER TABLE `matches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `members` (
  `member_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `match_id` int(10) unsigned NOT NULL,
  `id` bigint(20) unsigned NOT NULL,
  `club_id` int(10) unsigned NOT NULL,
  `competition` int(10) unsigned NOT NULL,
  `member_remarks` varchar(400) DEFAULT NULL,
  `members_created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `members_updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`member_id`),
  KEY `members_match_id_foreign` (`match_id`),
  KEY `members_id_foreign` (`id`),
  KEY `members_club_id_foreign` (`club_id`),
  CONSTRAINT `members_club_id_foreign` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`club_id`),
  CONSTRAINT `members_id_foreign` FOREIGN KEY (`id`) REFERENCES `users` (`id`),
  CONSTRAINT `members_match_id_foreign` FOREIGN KEY (`match_id`) REFERENCES `matches` (`match_id`)
) ENGINE=InnoDB AUTO_INCREMENT=355 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `members`
--

LOCK TABLES `members` WRITE;
/*!40000 ALTER TABLE `members` DISABLE KEYS */;
INSERT INTO `members` VALUES (1,1,74,6,0,NULL,'2023-11-25 15:13:34',NULL),(2,1,75,6,0,NULL,'2023-11-25 15:13:34',NULL),(3,1,76,6,0,NULL,'2023-11-25 15:13:34',NULL),(4,1,77,6,0,NULL,'2023-11-25 15:13:34',NULL),(5,1,78,6,0,NULL,'2023-11-25 15:13:34',NULL),(6,1,79,6,0,NULL,'2023-11-25 15:13:34',NULL),(7,1,80,6,0,NULL,'2023-11-25 15:13:34',NULL),(8,1,7,2,0,NULL,'2023-11-25 15:19:32',NULL),(9,1,8,2,1,NULL,'2023-11-25 15:19:32',NULL),(10,1,9,2,0,NULL,'2023-11-25 15:19:32',NULL),(11,1,10,2,0,NULL,'2023-11-25 15:19:32',NULL),(12,1,11,2,0,NULL,'2023-11-25 15:19:32',NULL),(13,1,12,2,0,NULL,'2023-11-25 15:19:32',NULL),(14,1,13,2,0,NULL,'2023-11-25 15:19:32',NULL),(15,1,14,2,0,NULL,'2023-11-25 15:19:32',NULL),(16,1,15,2,0,NULL,'2023-11-25 15:19:32',NULL),(17,1,16,2,0,NULL,'2023-11-25 15:19:32',NULL),(18,1,17,2,0,NULL,'2023-11-25 15:19:32',NULL),(19,1,18,2,0,NULL,'2023-11-25 15:19:32',NULL),(20,1,19,2,1,NULL,'2023-11-26 00:19:37','2023-11-25 15:19:37'),(21,2,7,2,0,NULL,'2023-11-25 15:53:33',NULL),(22,2,8,2,1,NULL,'2023-11-25 15:53:33',NULL),(23,2,9,2,0,NULL,'2023-11-25 15:53:33',NULL),(24,2,10,2,0,NULL,'2023-11-25 15:53:33',NULL),(25,2,11,2,0,NULL,'2023-11-25 15:53:33',NULL),(26,2,12,2,0,NULL,'2023-11-25 15:53:33',NULL),(27,2,13,2,0,NULL,'2023-11-25 15:53:33',NULL),(28,2,14,2,0,NULL,'2023-11-25 15:53:33',NULL),(29,2,15,2,0,NULL,'2023-11-25 15:53:33',NULL),(30,2,16,2,0,NULL,'2023-11-25 15:53:33',NULL),(31,2,17,2,0,NULL,'2023-11-25 15:53:33',NULL),(32,2,18,2,0,NULL,'2023-11-25 15:53:33',NULL),(33,2,19,2,1,NULL,'2023-11-25 15:53:33',NULL),(34,2,93,8,0,NULL,'2023-11-25 15:55:15',NULL),(35,2,94,8,0,NULL,'2023-11-25 15:55:15',NULL),(36,2,95,8,0,NULL,'2023-11-25 15:55:15',NULL),(37,2,96,8,0,NULL,'2023-11-25 15:55:15',NULL),(38,2,97,8,0,NULL,'2023-11-25 15:55:15',NULL),(39,2,98,8,0,NULL,'2023-11-25 15:55:15',NULL),(40,2,99,8,0,NULL,'2023-11-25 15:55:15',NULL),(41,2,100,8,0,NULL,'2023-11-25 15:55:15',NULL),(42,2,101,8,0,NULL,'2023-11-25 15:55:15',NULL),(43,2,102,8,0,NULL,'2023-11-25 15:55:15',NULL),(44,3,7,2,0,NULL,'2023-11-25 16:35:29',NULL),(45,3,8,2,1,NULL,'2023-11-25 16:35:29',NULL),(46,3,9,2,0,NULL,'2023-11-25 16:35:29',NULL),(47,3,10,2,0,NULL,'2023-11-25 16:35:29',NULL),(48,3,11,2,0,NULL,'2023-11-25 16:35:29',NULL),(49,3,12,2,0,NULL,'2023-11-25 16:35:29',NULL),(50,3,13,2,0,NULL,'2023-11-25 16:35:29',NULL),(51,3,14,2,0,NULL,'2023-11-25 16:35:29',NULL),(52,3,15,2,0,NULL,'2023-11-25 16:35:29',NULL),(53,3,16,2,0,NULL,'2023-11-25 16:35:29',NULL),(54,3,17,2,0,NULL,'2023-11-25 16:35:29',NULL),(55,3,18,2,0,NULL,'2023-11-25 16:35:29',NULL),(56,3,19,2,1,NULL,'2023-11-25 16:35:29',NULL),(57,3,37,4,0,NULL,'2023-11-25 16:36:07',NULL),(58,3,38,4,0,NULL,'2023-11-25 16:36:07',NULL),(59,3,39,4,0,NULL,'2023-11-25 16:36:07',NULL),(60,3,40,4,0,NULL,'2023-11-25 16:36:07',NULL),(61,3,41,4,0,NULL,'2023-11-25 16:36:07',NULL),(62,3,42,4,0,NULL,'2023-11-25 16:36:07',NULL),(63,3,43,4,0,NULL,'2023-11-25 16:36:07',NULL),(64,3,44,4,0,NULL,'2023-11-25 16:36:07',NULL),(65,3,45,4,0,NULL,'2023-11-25 16:36:07',NULL),(66,3,46,4,0,NULL,'2023-11-25 16:36:07',NULL),(67,3,47,4,0,NULL,'2023-11-25 16:36:07',NULL),(68,3,48,4,0,NULL,'2023-11-25 16:36:07',NULL),(69,3,49,4,0,NULL,'2023-11-25 16:36:07',NULL),(70,3,50,4,0,NULL,'2023-11-25 16:36:07',NULL),(71,3,51,4,0,NULL,'2023-11-25 16:36:07',NULL),(72,4,21,3,0,NULL,'2023-11-25 17:07:32',NULL),(73,4,22,3,0,NULL,'2023-11-25 17:07:32',NULL),(74,4,23,3,0,NULL,'2023-11-25 17:07:32',NULL),(75,4,24,3,0,NULL,'2023-11-25 17:07:32',NULL),(76,4,25,3,0,NULL,'2023-11-25 17:07:32',NULL),(77,4,26,3,0,NULL,'2023-11-25 17:07:32',NULL),(78,4,27,3,0,NULL,'2023-11-25 17:07:32',NULL),(79,4,28,3,0,NULL,'2023-11-25 17:07:32',NULL),(80,4,29,3,0,NULL,'2023-11-25 17:07:32',NULL),(81,4,30,3,0,NULL,'2023-11-25 17:07:32',NULL),(82,4,31,3,0,NULL,'2023-11-25 17:07:32',NULL),(83,4,32,3,0,NULL,'2023-11-25 17:07:32',NULL),(84,4,33,3,0,NULL,'2023-11-25 17:07:32',NULL),(85,4,34,3,0,NULL,'2023-11-25 17:07:32',NULL),(86,4,35,3,0,NULL,'2023-11-25 17:07:32',NULL),(87,5,53,5,0,NULL,'2023-11-25 17:09:10',NULL),(88,5,54,5,0,NULL,'2023-11-25 17:09:10',NULL),(89,5,55,5,0,NULL,'2023-11-25 17:09:10',NULL),(90,5,56,5,0,NULL,'2023-11-25 17:09:10',NULL),(91,5,57,5,0,NULL,'2023-11-25 17:09:10',NULL),(92,5,58,5,0,NULL,'2023-11-25 17:09:10',NULL),(93,5,59,5,0,NULL,'2023-11-25 17:09:10',NULL),(94,5,60,5,0,NULL,'2023-11-25 17:09:10',NULL),(95,5,61,5,0,NULL,'2023-11-25 17:09:10',NULL),(96,5,62,5,0,NULL,'2023-11-25 17:09:10',NULL),(97,5,63,5,0,NULL,'2023-11-25 17:09:10',NULL),(98,5,64,5,0,NULL,'2023-11-25 17:09:10',NULL),(99,5,65,5,0,NULL,'2023-11-25 17:09:10',NULL),(100,5,66,5,0,NULL,'2023-11-25 17:09:10',NULL),(101,5,67,5,0,NULL,'2023-11-25 17:09:10',NULL),(102,5,68,5,0,NULL,'2023-11-25 17:09:10',NULL),(103,5,69,5,0,NULL,'2023-11-25 17:09:10',NULL),(104,5,70,5,0,NULL,'2023-11-25 17:09:10',NULL),(105,5,71,5,0,NULL,'2023-11-25 17:09:10',NULL),(106,5,72,5,0,NULL,'2023-11-25 17:09:10',NULL),(107,4,7,2,0,NULL,'2023-11-25 17:22:23',NULL),(108,4,8,2,1,NULL,'2023-11-25 17:22:23',NULL),(109,4,9,2,0,NULL,'2023-11-25 17:22:23',NULL),(110,4,10,2,0,NULL,'2023-11-25 17:22:23',NULL),(111,4,11,2,0,NULL,'2023-11-25 17:22:23',NULL),(112,4,12,2,0,NULL,'2023-11-25 17:22:23',NULL),(113,4,13,2,0,NULL,'2023-11-25 17:22:23',NULL),(114,4,14,2,0,NULL,'2023-11-25 17:22:23',NULL),(115,4,15,2,0,NULL,'2023-11-25 17:22:23',NULL),(116,4,16,2,0,NULL,'2023-11-25 17:22:23',NULL),(117,4,17,2,0,NULL,'2023-11-25 17:22:23',NULL),(118,4,18,2,0,NULL,'2023-11-25 17:22:23',NULL),(119,4,19,2,1,NULL,'2023-11-25 17:22:23',NULL),(120,5,7,2,0,NULL,'2023-11-25 17:54:03',NULL),(121,5,8,2,1,NULL,'2023-11-25 17:54:03',NULL),(122,5,9,2,0,NULL,'2023-11-25 17:54:03',NULL),(123,5,10,2,0,NULL,'2023-11-25 17:54:03',NULL),(124,5,11,2,0,NULL,'2023-11-25 17:54:03',NULL),(125,5,12,2,0,NULL,'2023-11-25 17:54:03',NULL),(126,5,13,2,0,NULL,'2023-11-25 17:54:03',NULL),(127,5,14,2,0,NULL,'2023-11-25 17:54:03',NULL),(128,5,15,2,0,NULL,'2023-11-25 17:54:03',NULL),(129,5,16,2,0,NULL,'2023-11-25 17:54:03',NULL),(130,5,17,2,0,NULL,'2023-11-25 17:54:03',NULL),(131,5,18,2,0,NULL,'2023-11-25 17:54:03',NULL),(132,5,19,2,1,NULL,'2023-11-26 02:54:09','2023-11-25 17:54:09'),(133,6,7,2,0,NULL,'2023-11-25 19:00:01',NULL),(134,6,8,2,1,NULL,'2023-11-25 19:00:01',NULL),(135,6,9,2,0,NULL,'2023-11-25 19:00:01',NULL),(136,6,10,2,0,NULL,'2023-11-25 19:00:01',NULL),(137,6,11,2,0,NULL,'2023-11-25 19:00:01',NULL),(138,6,12,2,0,NULL,'2023-11-25 19:00:01',NULL),(139,6,13,2,0,NULL,'2023-11-25 19:00:01',NULL),(140,6,14,2,1,NULL,'2023-11-25 19:00:01',NULL),(141,6,15,2,0,NULL,'2023-11-25 19:00:01',NULL),(142,6,16,2,0,NULL,'2023-11-25 19:00:01',NULL),(143,6,17,2,0,NULL,'2023-11-25 19:00:01',NULL),(144,6,18,2,0,NULL,'2023-11-25 19:00:01',NULL),(145,6,19,2,1,NULL,'2023-11-25 19:00:01',NULL),(146,7,115,10,0,NULL,'2023-12-02 07:31:03',NULL),(147,7,116,10,0,NULL,'2023-12-02 07:31:03',NULL),(148,7,117,10,0,NULL,'2023-12-02 07:31:03',NULL),(149,7,118,10,0,NULL,'2023-12-02 07:31:03',NULL),(150,7,119,10,0,NULL,'2023-12-02 07:31:03',NULL),(151,7,120,10,0,NULL,'2023-12-02 07:31:03',NULL),(152,7,121,10,0,NULL,'2023-12-02 07:31:03',NULL),(153,7,122,10,0,NULL,'2023-12-02 07:31:03',NULL),(154,7,123,10,0,NULL,'2023-12-02 07:31:03',NULL),(155,7,124,10,0,NULL,'2023-12-02 07:31:03',NULL),(156,7,93,8,1,NULL,'2023-12-02 08:26:46',NULL),(157,7,94,8,1,NULL,'2023-12-02 08:26:46',NULL),(158,7,95,8,0,NULL,'2023-12-02 08:26:46',NULL),(159,7,96,8,0,NULL,'2023-12-02 08:26:46',NULL),(160,7,97,8,0,NULL,'2023-12-02 08:26:46',NULL),(161,7,98,8,1,NULL,'2023-12-02 08:26:46',NULL),(162,7,99,8,1,NULL,'2023-12-02 08:26:46',NULL),(163,7,100,8,1,NULL,'2023-12-02 08:26:46',NULL),(164,7,101,8,1,NULL,'2023-12-02 08:26:46',NULL),(165,7,102,8,0,NULL,'2023-12-02 08:26:46',NULL),(166,7,104,8,1,NULL,'2023-12-02 08:26:46',NULL),(167,7,105,8,1,NULL,'2023-12-02 08:26:46',NULL),(168,7,106,8,1,NULL,'2023-12-02 08:26:46',NULL),(169,7,107,8,1,NULL,'2023-12-02 08:26:46',NULL),(170,7,108,8,0,NULL,'2023-12-02 08:26:46',NULL),(171,7,109,8,0,NULL,'2023-12-02 08:26:46',NULL),(172,7,110,8,1,NULL,'2023-12-02 08:26:46',NULL),(173,7,111,8,1,NULL,'2023-12-02 08:26:46',NULL),(174,7,112,8,1,NULL,'2023-12-02 08:26:46',NULL),(175,7,113,8,1,NULL,'2023-12-02 08:26:46',NULL),(176,7,126,8,0,NULL,'2023-12-02 08:26:46',NULL),(177,7,127,8,0,NULL,'2023-12-02 08:26:46',NULL),(178,7,128,8,0,NULL,'2023-12-02 08:26:46',NULL),(179,7,129,8,0,NULL,'2023-12-02 08:26:46',NULL),(180,7,130,8,1,NULL,'2023-12-02 08:26:46',NULL),(181,7,131,8,1,NULL,'2023-12-02 08:26:46',NULL),(182,7,132,8,1,NULL,'2023-12-02 08:26:46',NULL),(183,7,133,8,1,NULL,'2023-12-02 08:26:46',NULL),(184,8,93,8,1,NULL,'2023-12-02 16:51:10',NULL),(185,8,94,8,1,NULL,'2023-12-02 16:51:10',NULL),(186,8,95,8,0,NULL,'2023-12-02 16:51:10',NULL),(187,8,96,8,0,NULL,'2023-12-02 16:51:10',NULL),(188,8,97,8,0,NULL,'2023-12-02 16:51:10',NULL),(189,8,98,8,1,NULL,'2023-12-02 16:51:10',NULL),(190,8,99,8,1,NULL,'2023-12-02 16:51:10',NULL),(191,8,100,8,1,NULL,'2023-12-02 16:51:10',NULL),(192,8,101,8,1,NULL,'2023-12-02 16:51:10',NULL),(193,8,102,8,0,NULL,'2023-12-02 16:51:10',NULL),(194,8,104,8,1,NULL,'2023-12-02 16:51:10',NULL),(195,8,105,8,1,NULL,'2023-12-02 16:51:10',NULL),(196,8,106,8,1,NULL,'2023-12-02 16:51:10',NULL),(197,8,107,8,1,NULL,'2023-12-02 16:51:10',NULL),(198,8,108,8,0,NULL,'2023-12-02 16:51:10',NULL),(199,8,109,8,0,NULL,'2023-12-02 16:51:10',NULL),(200,8,110,8,1,NULL,'2023-12-02 16:51:10',NULL),(201,8,111,8,1,NULL,'2023-12-02 16:51:10',NULL),(202,8,112,8,1,NULL,'2023-12-02 16:51:10',NULL),(203,8,113,8,1,NULL,'2023-12-02 16:51:10',NULL),(204,8,126,8,0,NULL,'2023-12-02 16:51:10',NULL),(205,8,127,8,0,NULL,'2023-12-02 16:51:10',NULL),(206,8,128,8,0,NULL,'2023-12-02 16:51:10',NULL),(207,8,129,8,0,NULL,'2023-12-02 16:51:10',NULL),(208,8,130,8,1,NULL,'2023-12-02 16:51:10',NULL),(209,8,131,8,1,NULL,'2023-12-02 16:51:10',NULL),(210,8,132,8,1,NULL,'2023-12-02 16:51:10',NULL),(211,8,133,8,1,NULL,'2023-12-02 16:51:10',NULL),(212,8,115,10,0,NULL,'2023-12-02 17:53:44',NULL),(213,8,116,10,0,NULL,'2023-12-02 17:53:44',NULL),(214,8,117,10,0,NULL,'2023-12-02 17:53:44',NULL),(215,8,118,10,0,NULL,'2023-12-02 17:53:44',NULL),(216,8,119,10,0,NULL,'2023-12-02 17:53:44',NULL),(217,8,120,10,0,NULL,'2023-12-02 17:53:44',NULL),(218,8,121,10,0,NULL,'2023-12-02 17:53:44',NULL),(219,8,122,10,0,NULL,'2023-12-02 17:53:44',NULL),(220,8,123,10,0,NULL,'2023-12-02 17:53:44',NULL),(221,8,124,10,0,NULL,'2023-12-02 17:53:44',NULL),(222,9,135,12,0,NULL,'2023-12-23 20:45:02',NULL),(223,9,136,12,0,NULL,'2023-12-23 20:45:02',NULL),(224,9,137,12,0,NULL,'2023-12-23 20:45:02',NULL),(225,9,138,12,0,NULL,'2023-12-23 20:45:02',NULL),(226,9,139,12,0,NULL,'2023-12-23 20:45:02',NULL),(227,9,140,12,0,NULL,'2023-12-23 20:45:02',NULL),(228,9,141,12,0,NULL,'2023-12-23 20:45:02',NULL),(229,9,142,12,0,NULL,'2023-12-23 20:45:02',NULL),(230,9,143,12,0,NULL,'2023-12-23 20:45:02',NULL),(231,9,144,12,0,NULL,'2023-12-23 20:45:02',NULL),(232,9,145,12,0,NULL,'2023-12-23 20:45:02',NULL),(233,9,146,12,0,NULL,'2023-12-23 20:45:02',NULL),(234,9,147,12,0,NULL,'2023-12-23 20:45:02',NULL),(235,9,148,12,0,NULL,'2023-12-23 20:45:02',NULL),(236,9,149,12,0,NULL,'2023-12-23 20:45:02',NULL),(237,9,150,12,1,'Bチーム','2023-12-23 20:45:02',NULL),(238,9,151,12,1,'Bチーム','2023-12-23 20:45:02',NULL),(239,9,152,12,1,'Bチーム','2023-12-23 20:45:02',NULL),(240,9,153,12,1,'Bチーム','2023-12-23 20:45:02',NULL),(241,9,154,12,1,'Bチーム','2023-12-23 20:45:02',NULL),(242,9,155,12,1,'Bチーム','2023-12-23 20:45:02',NULL),(243,9,156,12,1,'Bチーム','2023-12-23 20:45:02',NULL),(244,9,157,12,1,'Bチーム','2023-12-23 20:45:02',NULL),(245,9,158,12,1,'Bチーム','2023-12-23 20:45:02',NULL),(246,9,159,12,1,'Bチーム','2023-12-23 20:45:02',NULL),(247,9,160,12,1,'Bチーム','2023-12-23 20:45:02',NULL),(248,9,161,12,1,'Bチーム','2023-12-23 20:45:02',NULL),(249,9,162,12,1,'Bチーム','2023-12-23 20:45:02',NULL),(250,9,163,12,1,'Bチーム','2023-12-23 20:45:02',NULL),(251,9,164,12,1,'Bチーム','2023-12-23 20:45:02',NULL),(252,9,53,5,0,NULL,'2023-12-23 20:45:37',NULL),(253,9,54,5,0,NULL,'2023-12-23 20:45:37',NULL),(254,9,55,5,0,NULL,'2023-12-23 20:45:37',NULL),(255,9,56,5,0,NULL,'2023-12-23 20:45:37',NULL),(256,9,57,5,0,NULL,'2023-12-23 20:45:37',NULL),(257,9,58,5,0,NULL,'2023-12-23 20:45:37',NULL),(258,9,59,5,0,NULL,'2023-12-23 20:45:37',NULL),(259,9,60,5,0,NULL,'2023-12-23 20:45:37',NULL),(260,9,61,5,0,NULL,'2023-12-23 20:45:37',NULL),(261,9,62,5,0,NULL,'2023-12-23 20:45:37',NULL),(262,9,63,5,0,NULL,'2023-12-23 20:45:37',NULL),(263,9,64,5,0,NULL,'2023-12-23 20:45:37',NULL),(264,9,65,5,0,NULL,'2023-12-23 20:45:37',NULL),(265,9,66,5,0,NULL,'2023-12-23 20:45:37',NULL),(266,9,67,5,0,NULL,'2023-12-23 20:45:37',NULL),(267,9,68,5,0,NULL,'2023-12-23 20:45:37',NULL),(268,9,69,5,0,NULL,'2023-12-23 20:45:37',NULL),(269,9,70,5,0,NULL,'2023-12-23 20:45:37',NULL),(270,9,71,5,0,NULL,'2023-12-23 20:45:37',NULL),(271,9,72,5,0,NULL,'2023-12-23 20:45:37',NULL),(272,10,166,13,0,NULL,'2023-12-23 20:46:07',NULL),(273,10,167,13,0,NULL,'2023-12-23 20:46:07',NULL),(274,10,168,13,0,NULL,'2023-12-23 20:46:07',NULL),(275,10,169,13,0,NULL,'2023-12-23 20:46:07',NULL),(276,10,170,13,0,NULL,'2023-12-23 20:46:07',NULL),(277,10,171,13,0,NULL,'2023-12-23 20:46:07',NULL),(278,10,172,13,0,NULL,'2023-12-23 20:46:07',NULL),(279,10,173,13,0,NULL,'2023-12-23 20:46:07',NULL),(280,10,174,13,0,NULL,'2023-12-23 20:46:07',NULL),(281,10,175,13,0,NULL,'2023-12-23 20:46:07',NULL),(282,10,176,13,0,NULL,'2023-12-23 20:46:07',NULL),(283,10,177,13,0,NULL,'2023-12-23 20:46:07',NULL),(284,10,178,13,0,NULL,'2023-12-23 20:46:07',NULL),(285,10,179,13,0,NULL,'2023-12-23 20:46:07',NULL),(286,10,180,13,0,NULL,'2023-12-23 20:46:07',NULL),(287,10,182,14,0,NULL,'2023-12-23 20:46:31',NULL),(288,10,183,14,0,NULL,'2023-12-23 20:46:31',NULL),(289,10,184,14,0,NULL,'2023-12-23 20:46:31',NULL),(290,10,185,14,0,NULL,'2023-12-23 20:46:31',NULL),(291,10,186,14,0,NULL,'2023-12-23 20:46:31',NULL),(292,10,187,14,0,NULL,'2023-12-23 20:46:31',NULL),(293,10,188,14,0,NULL,'2023-12-23 20:46:31',NULL),(294,10,189,14,0,NULL,'2023-12-23 20:46:31',NULL),(295,10,190,14,0,NULL,'2023-12-23 20:46:31',NULL),(296,10,191,14,0,NULL,'2023-12-23 20:46:31',NULL),(297,10,192,14,0,NULL,'2023-12-23 20:46:31',NULL),(298,10,193,14,0,NULL,'2023-12-23 20:46:31',NULL),(299,10,194,14,0,NULL,'2023-12-23 20:46:31',NULL),(300,10,195,14,0,NULL,'2023-12-23 20:46:31',NULL),(301,10,196,14,0,NULL,'2023-12-23 20:46:31',NULL),(302,11,198,15,0,NULL,'2023-12-23 20:46:56',NULL),(303,11,199,15,0,NULL,'2023-12-23 20:46:56',NULL),(304,11,200,15,0,NULL,'2023-12-23 20:46:56',NULL),(305,11,201,15,0,NULL,'2023-12-23 20:46:56',NULL),(306,11,202,15,0,NULL,'2023-12-23 20:46:56',NULL),(307,11,203,15,0,NULL,'2023-12-23 20:46:56',NULL),(308,11,204,15,0,NULL,'2023-12-23 20:46:56',NULL),(309,11,205,15,0,NULL,'2023-12-23 20:46:56',NULL),(310,11,206,15,0,NULL,'2023-12-23 20:46:56',NULL),(311,11,207,15,0,NULL,'2023-12-23 20:46:56',NULL),(312,11,208,15,0,NULL,'2023-12-23 20:46:56',NULL),(313,11,209,15,0,NULL,'2023-12-23 20:46:56',NULL),(314,11,210,15,0,NULL,'2023-12-23 20:46:56',NULL),(315,11,211,15,0,NULL,'2023-12-23 20:46:56',NULL),(316,11,212,15,0,NULL,'2023-12-23 20:46:56',NULL),(317,11,214,16,0,NULL,'2023-12-23 20:47:24',NULL),(318,11,215,16,0,NULL,'2023-12-23 20:47:24',NULL),(319,11,216,16,0,NULL,'2023-12-23 20:47:24',NULL),(320,11,217,16,0,NULL,'2023-12-23 20:47:24',NULL),(321,11,218,16,0,NULL,'2023-12-23 20:47:24',NULL),(322,11,219,16,0,NULL,'2023-12-23 20:47:24',NULL),(323,11,220,16,0,NULL,'2023-12-23 20:47:24',NULL),(324,11,221,16,0,NULL,'2023-12-23 20:47:24',NULL),(325,11,222,16,0,NULL,'2023-12-23 20:47:24',NULL),(326,11,223,16,0,NULL,'2023-12-23 20:47:24',NULL),(327,11,224,16,0,NULL,'2023-12-23 20:47:24',NULL),(328,11,225,16,0,NULL,'2023-12-23 20:47:24',NULL),(329,11,226,16,0,NULL,'2023-12-23 20:47:24',NULL),(330,11,227,16,0,NULL,'2023-12-23 20:47:24',NULL),(331,11,228,16,0,NULL,'2023-12-23 20:47:24',NULL),(332,12,7,2,0,NULL,'2023-12-23 20:48:54',NULL),(333,12,8,2,0,NULL,'2023-12-23 20:48:54',NULL),(334,12,9,2,0,NULL,'2023-12-23 20:48:54',NULL),(335,12,10,2,0,NULL,'2023-12-23 20:48:54',NULL),(336,12,11,2,0,NULL,'2023-12-23 20:48:54',NULL),(337,12,12,2,0,NULL,'2023-12-23 20:48:54',NULL),(338,12,13,2,0,NULL,'2023-12-23 20:48:54',NULL),(339,12,14,2,0,NULL,'2023-12-23 20:48:54',NULL),(340,12,15,2,0,NULL,'2023-12-23 20:48:54',NULL),(341,12,16,2,0,NULL,'2023-12-23 20:48:54',NULL),(342,12,17,2,0,NULL,'2023-12-23 20:48:54',NULL),(343,12,18,2,0,NULL,'2023-12-23 20:48:54',NULL),(344,12,19,2,0,NULL,'2023-12-23 20:48:54',NULL),(345,12,115,10,0,NULL,'2023-12-23 20:49:59',NULL),(346,12,116,10,0,NULL,'2023-12-23 20:49:59',NULL),(347,12,117,10,0,NULL,'2023-12-23 20:49:59',NULL),(348,12,118,10,0,NULL,'2023-12-23 20:49:59',NULL),(349,12,119,10,0,NULL,'2023-12-23 20:49:59',NULL),(350,12,120,10,0,NULL,'2023-12-23 20:49:59',NULL),(351,12,121,10,0,NULL,'2023-12-23 20:49:59',NULL),(352,12,122,10,0,NULL,'2023-12-23 20:49:59',NULL),(353,12,123,10,0,NULL,'2023-12-23 20:49:59',NULL),(354,12,124,10,0,NULL,'2023-12-23 20:49:59',NULL);
/*!40000 ALTER TABLE `members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2023_08_14_000000_create_clubs_table',1),(6,'2023_08_14_100000_create_pitches_table',1),(7,'2023_08_15_210513_create_matches_table',1),(8,'2023_08_15_230924_create_players_table',1),(9,'2023_11_14_210325_create_scores_table',1),(10,'2023_11_16_130001_create_members_table',1),(11,'2023_11_20_040115_create_fouls_table',1),(12,'2023_11_30_205537_change_regulation_time_to_matches_table',2),(13,'2023_12_13_205340_add_extra_pk_to_matches_table',3),(14,'2023_12_13_205606_add_score_period_to_scores_table',3),(15,'2023_12_13_205759_add_score_period_to_fouls_table',3),(16,'2023_12_19_072022_add_change_period_to_players_table',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pitches`
--

DROP TABLE IF EXISTS `pitches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pitches` (
  `pitch_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pitch_name` varchar(60) NOT NULL,
  `pitch_url` varchar(400) NOT NULL,
  `pitch_status` int(10) unsigned NOT NULL,
  `pitches_created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `pitches_updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`pitch_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pitches`
--

LOCK TABLES `pitches` WRITE;
/*!40000 ALTER TABLE `pitches` DISABLE KEYS */;
INSERT INTO `pitches` VALUES (1,'葛飾区立柴又小学校','https://school.katsushika.ed.jp/swas/index.php?id=shibamata_e&frame=frm5e182d839022c',0,'2023-11-17 06:00:00',NULL),(2,'葛飾区立東柴又小学校','https://www.mapion.co.jp/phonebook/M11006/13122/ILSP0000062811_ipclm/',0,'2023-11-17 06:00:00',NULL),(3,'葛飾区立金町小学校','https://school.katsushika.ed.jp/swas/index.php?id=kanamachi_e&frame=frm5e1c05ce6767e',0,'2023-11-17 06:00:00',NULL),(4,'柴又球技場','https://www.city.katsushika.lg.jp/institution/1030225/1000098/1006940/1006966.html',0,'2023-11-17 06:00:00',NULL),(5,'上千葉公園運動場','https://www.spo-katsushika.esforta.jp/info_shisetsu_004.html',0,'2023-11-17 06:00:00',NULL),(6,'東金町運動場多目的広場','https://www.spo-katsushika.esforta.jp/info_shisetsu_005.html',0,'2023-11-17 06:00:00',NULL),(7,'葛飾区立東綾瀬小学校','https://school.katsushika.ed.jp/swas/index.php?id=higashiayase_e&frame=frm5e1d1a1a6d259',0,'2023-11-17 06:00:00',NULL),(8,'葛飾区立北野小学校','https://school.katsushika.ed.jp/swas/index.php?id=kitano_e&frame=frm5e170458cb077',0,'2023-11-17 06:00:00',NULL),(9,'葛飾区立細田小学校','https://school.katsushika.ed.jp/swas/index.php?id=hosoda_e&frame=frm5e1969881f046',0,'2023-11-17 06:00:00',NULL),(10,'葛飾区立東水元小学校','https://www.google.com/maps/place/%E8%91%9B%E9%A3%BE%E5%8C%BA%E7%AB%8B%E6%9D%B1%E6%B0%B4%E5%85%83%E5%B0%8F%E5%AD%A6%E6%A0%A1/@35.790838,139.867579,15z/data=!4m6!3m5!1s0x6018854580f14743:0xcaaa5406c6cffa2a!8m2!3d35.790838!4d139.867579!16s%2Fg%2F1tj3331n?entry=ttu',0,'2023-11-24 06:00:00',NULL);
/*!40000 ALTER TABLE `pitches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `players`
--

DROP TABLE IF EXISTS `players`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `players` (
  `player_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `match_id` int(10) unsigned NOT NULL,
  `id` bigint(20) unsigned NOT NULL,
  `club_id` int(10) unsigned NOT NULL,
  `match_position` int(11) DEFAULT NULL,
  `on` time DEFAULT NULL,
  `off` time DEFAULT NULL,
  `player_remarks` varchar(400) DEFAULT NULL,
  `players_created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `players_updated_at` timestamp NULL DEFAULT NULL,
  `on_period` int(10) unsigned DEFAULT NULL,
  `off_period` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`player_id`),
  KEY `players_match_id_foreign` (`match_id`),
  KEY `players_id_foreign` (`id`),
  KEY `players_club_id_foreign` (`club_id`),
  CONSTRAINT `players_club_id_foreign` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`club_id`),
  CONSTRAINT `players_id_foreign` FOREIGN KEY (`id`) REFERENCES `users` (`id`),
  CONSTRAINT `players_match_id_foreign` FOREIGN KEY (`match_id`) REFERENCES `matches` (`match_id`)
) ENGINE=InnoDB AUTO_INCREMENT=172 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `players`
--

LOCK TABLES `players` WRITE;
/*!40000 ALTER TABLE `players` DISABLE KEYS */;
INSERT INTO `players` VALUES (1,1,74,6,1,'00:00:00',NULL,NULL,'2023-11-25 15:13:34',NULL,NULL,NULL),(2,1,75,6,2,'00:00:00',NULL,NULL,'2023-11-25 15:13:34',NULL,NULL,NULL),(3,1,76,6,3,'00:00:00',NULL,NULL,'2023-11-25 15:13:34',NULL,NULL,NULL),(4,1,77,6,4,'00:00:00',NULL,NULL,'2023-11-25 15:13:34',NULL,NULL,NULL),(5,1,78,6,5,'00:00:00',NULL,NULL,'2023-11-25 15:13:34',NULL,NULL,NULL),(6,1,79,6,6,'00:00:00',NULL,NULL,'2023-11-25 15:13:34',NULL,NULL,NULL),(7,1,9,2,1,'00:00:00','12:08:29',NULL,'2023-11-26 03:13:35','2023-11-25 18:13:35',NULL,NULL),(8,1,10,2,2,'00:00:00','12:08:19',NULL,'2023-11-26 03:13:25','2023-11-25 18:13:25',NULL,NULL),(9,1,11,2,3,'00:00:00','12:09:25',NULL,'2023-11-26 03:14:31','2023-11-25 18:14:31',NULL,NULL),(10,1,16,2,4,'00:00:00','00:13:09',NULL,'2023-11-26 01:22:15','2023-11-25 16:22:15',NULL,NULL),(11,1,17,2,5,'00:00:00','00:13:09',NULL,'2023-11-26 01:22:15','2023-11-25 16:22:15',NULL,NULL),(12,1,18,2,6,'00:00:00','00:13:09',NULL,'2023-11-26 01:22:15','2023-11-25 16:22:15',NULL,NULL),(13,1,7,2,2,'12:39:50','12:08:19',NULL,'2023-11-26 03:13:25','2023-11-25 18:13:25',NULL,NULL),(14,1,12,2,3,'12:39:50','12:08:19',NULL,'2023-11-26 03:13:25','2023-11-25 18:13:25',NULL,NULL),(15,1,13,2,4,'12:39:50',NULL,NULL,'2023-11-25 15:29:50',NULL,NULL,NULL),(16,1,14,2,5,'12:39:50',NULL,NULL,'2023-11-25 15:29:50',NULL,NULL,NULL),(17,1,15,2,6,'12:39:50',NULL,NULL,'2023-11-25 15:29:50',NULL,NULL,NULL),(18,2,12,2,2,'00:00:00','12:08:19',NULL,'2023-11-26 03:13:25','2023-11-25 18:13:25',NULL,NULL),(19,2,11,2,3,'00:00:00','12:09:25',NULL,'2023-11-26 03:14:31','2023-11-25 18:14:31',NULL,NULL),(20,2,15,2,1,'00:00:00',NULL,NULL,'2023-11-25 15:53:33',NULL,NULL,NULL),(21,2,16,2,4,'00:00:00','00:13:09',NULL,'2023-11-26 01:22:15','2023-11-25 16:22:15',NULL,NULL),(22,2,17,2,5,'00:00:00','00:13:09',NULL,'2023-11-26 01:22:15','2023-11-25 16:22:15',NULL,NULL),(23,2,18,2,6,'00:00:00','00:13:09',NULL,'2023-11-26 01:22:15','2023-11-25 16:22:15',NULL,NULL),(24,2,93,8,1,'00:00:00',NULL,NULL,'2023-11-25 15:55:15',NULL,NULL,NULL),(25,2,94,8,2,'00:00:00',NULL,NULL,'2023-11-25 15:55:15',NULL,NULL,NULL),(26,2,95,8,3,'00:00:00',NULL,NULL,'2023-11-25 15:55:15',NULL,NULL,NULL),(27,2,96,8,4,'00:00:00',NULL,NULL,'2023-11-25 15:55:15',NULL,NULL,NULL),(28,2,97,8,5,'00:00:00',NULL,NULL,'2023-11-25 15:55:15',NULL,NULL,NULL),(29,2,98,8,6,'00:00:00',NULL,NULL,'2023-11-25 15:55:15',NULL,NULL,NULL),(30,2,10,2,2,'00:13:09','12:08:19',NULL,'2023-11-26 03:13:25','2023-11-25 18:13:25',NULL,NULL),(31,2,9,2,3,'00:13:09','12:08:29',NULL,'2023-11-26 03:13:35','2023-11-25 18:13:35',NULL,NULL),(32,2,7,2,4,'00:13:09','12:08:19',NULL,'2023-11-26 03:13:25','2023-11-25 18:13:25',NULL,NULL),(33,2,13,2,5,'00:13:09',NULL,NULL,'2023-11-25 16:22:15',NULL,NULL,NULL),(34,2,14,2,6,'00:13:09',NULL,NULL,'2023-11-25 16:22:15',NULL,NULL,NULL),(35,3,9,2,4,'00:00:00','12:08:29',NULL,'2023-11-26 03:13:35','2023-11-25 18:13:35',NULL,NULL),(36,3,10,2,2,'00:00:00','12:08:19',NULL,'2023-11-26 03:13:25','2023-11-25 18:13:25',NULL,NULL),(37,3,12,2,3,'00:00:00','12:08:19',NULL,'2023-11-26 03:13:25','2023-11-25 18:13:25',NULL,NULL),(38,3,13,2,1,'00:00:00',NULL,NULL,'2023-11-25 16:35:29',NULL,NULL,NULL),(39,3,17,2,6,'00:00:00',NULL,NULL,'2023-11-25 16:35:29',NULL,NULL,NULL),(40,3,18,2,5,'00:00:00',NULL,NULL,'2023-11-25 16:35:29',NULL,NULL,NULL),(41,3,37,4,1,'00:00:00',NULL,NULL,'2023-11-25 16:36:07',NULL,NULL,NULL),(42,3,38,4,2,'00:00:00',NULL,NULL,'2023-11-25 16:36:07',NULL,NULL,NULL),(43,3,39,4,3,'00:00:00',NULL,NULL,'2023-11-25 16:36:07',NULL,NULL,NULL),(44,3,40,4,4,'00:00:00',NULL,NULL,'2023-11-25 16:36:07',NULL,NULL,NULL),(45,3,41,4,5,'00:00:00',NULL,NULL,'2023-11-25 16:36:07',NULL,NULL,NULL),(46,3,42,4,6,'00:00:00',NULL,NULL,'2023-11-25 16:36:07',NULL,NULL,NULL),(47,4,21,3,1,'00:00:00',NULL,NULL,'2023-11-25 17:07:32',NULL,NULL,NULL),(48,4,22,3,2,'00:00:00',NULL,NULL,'2023-11-25 17:07:32',NULL,NULL,NULL),(49,4,23,3,3,'00:00:00',NULL,NULL,'2023-11-25 17:07:32',NULL,NULL,NULL),(50,4,24,3,4,'00:00:00',NULL,NULL,'2023-11-25 17:07:32',NULL,NULL,NULL),(51,4,25,3,5,'00:00:00',NULL,NULL,'2023-11-25 17:07:32',NULL,NULL,NULL),(52,4,26,3,6,'00:00:00',NULL,NULL,'2023-11-25 17:07:32',NULL,NULL,NULL),(53,5,53,5,1,'00:00:00',NULL,NULL,'2023-11-25 17:09:10',NULL,NULL,NULL),(54,5,54,5,2,'00:00:00',NULL,NULL,'2023-11-25 17:09:10',NULL,NULL,NULL),(55,5,55,5,3,'00:00:00',NULL,NULL,'2023-11-25 17:09:10',NULL,NULL,NULL),(56,5,56,5,4,'00:00:00',NULL,NULL,'2023-11-25 17:09:10',NULL,NULL,NULL),(57,5,57,5,5,'00:00:00',NULL,NULL,'2023-11-25 17:09:10',NULL,NULL,NULL),(58,5,58,5,6,'00:00:00',NULL,NULL,'2023-11-25 17:09:10',NULL,NULL,NULL),(59,4,7,2,3,'00:00:00','12:08:19',NULL,'2023-11-26 03:13:25','2023-11-25 18:13:25',NULL,NULL),(60,4,9,2,1,'00:00:00','12:08:29',NULL,'2023-11-26 03:13:35','2023-11-25 18:13:35',NULL,NULL),(61,4,10,2,5,'00:00:00','12:08:19',NULL,'2023-11-26 03:13:25','2023-11-25 18:13:25',NULL,NULL),(62,4,11,2,2,'00:00:00','12:09:25',NULL,'2023-11-26 03:14:31','2023-11-25 18:14:31',NULL,NULL),(63,4,13,2,6,'00:00:00',NULL,NULL,'2023-11-25 17:22:23',NULL,NULL,NULL),(64,4,16,2,4,'00:00:00',NULL,NULL,'2023-11-25 17:22:23',NULL,NULL,NULL),(65,5,7,2,5,'00:00:00','12:08:19',NULL,'2023-11-26 03:13:25','2023-11-25 18:13:25',NULL,NULL),(66,5,9,2,6,'00:00:00','12:08:29',NULL,'2023-11-26 03:13:35','2023-11-25 18:13:35',NULL,NULL),(67,5,10,2,2,'00:00:00','12:08:19',NULL,'2023-11-26 03:13:25','2023-11-25 18:13:25',NULL,NULL),(68,5,11,2,3,'00:00:00','12:09:25',NULL,'2023-11-26 03:14:31','2023-11-25 18:14:31',NULL,NULL),(69,5,12,2,4,'00:00:00','12:08:19',NULL,'2023-11-26 03:13:25','2023-11-25 18:13:25',NULL,NULL),(70,5,15,2,1,'00:00:00',NULL,NULL,'2023-11-25 17:54:03',NULL,NULL,NULL),(71,5,13,2,2,'12:08:19',NULL,NULL,'2023-11-25 18:13:25',NULL,NULL,NULL),(72,5,17,2,4,'12:08:19',NULL,NULL,'2023-11-25 18:13:25',NULL,NULL,NULL),(73,5,18,2,5,'12:08:19',NULL,NULL,'2023-11-25 18:13:25',NULL,NULL,NULL),(74,5,12,2,6,'12:08:29',NULL,NULL,'2023-11-25 18:13:35',NULL,NULL,NULL),(75,5,10,2,3,'12:09:25',NULL,NULL,'2023-11-25 18:14:31',NULL,NULL,NULL),(76,6,7,2,2,'00:00:00',NULL,NULL,'2023-11-25 19:00:01',NULL,NULL,NULL),(77,6,9,2,1,'00:00:00',NULL,NULL,'2023-11-25 19:00:01',NULL,NULL,NULL),(78,6,10,2,3,'00:00:00',NULL,NULL,'2023-11-25 19:00:01',NULL,NULL,NULL),(79,6,11,2,4,'00:00:00',NULL,NULL,'2023-11-25 19:00:01',NULL,NULL,NULL),(80,6,12,2,5,'00:00:00',NULL,NULL,'2023-11-25 19:00:01',NULL,NULL,NULL),(81,6,13,2,6,'00:00:00',NULL,NULL,'2023-11-25 19:00:01',NULL,NULL,NULL),(82,6,15,2,7,'00:00:00',NULL,NULL,'2023-11-25 19:00:01',NULL,NULL,NULL),(83,6,18,2,8,'00:00:00',NULL,NULL,'2023-11-25 19:00:01',NULL,NULL,NULL),(84,7,115,10,1,'00:00:00',NULL,NULL,'2023-12-02 07:31:03',NULL,NULL,NULL),(85,7,117,10,2,'00:00:00',NULL,NULL,'2023-12-02 07:31:03',NULL,NULL,NULL),(86,7,118,10,3,'00:00:00',NULL,NULL,'2023-12-02 07:31:03',NULL,NULL,NULL),(87,7,119,10,4,'00:00:00',NULL,NULL,'2023-12-02 07:31:03',NULL,NULL,NULL),(88,7,120,10,5,'00:00:00',NULL,NULL,'2023-12-02 07:31:03',NULL,NULL,NULL),(89,7,121,10,6,'00:00:00',NULL,NULL,'2023-12-02 07:31:03',NULL,NULL,NULL),(90,7,122,10,7,'00:00:00',NULL,NULL,'2023-12-02 07:31:03',NULL,NULL,NULL),(91,7,123,10,8,'00:00:00',NULL,NULL,'2023-12-02 07:31:03',NULL,NULL,NULL),(92,7,95,8,1,'00:00:00',NULL,NULL,'2023-12-03 00:49:22',NULL,NULL,NULL),(93,7,96,8,2,'00:00:00',NULL,NULL,'2023-12-03 00:49:22',NULL,NULL,NULL),(94,7,97,8,3,'00:00:00',NULL,NULL,'2023-12-03 00:49:22',NULL,NULL,NULL),(95,7,102,8,4,'00:00:00',NULL,NULL,'2023-12-03 00:49:22',NULL,NULL,NULL),(96,7,108,8,5,'00:00:00',NULL,NULL,'2023-12-03 00:49:22',NULL,NULL,NULL),(97,7,109,8,6,'00:00:00',NULL,NULL,'2023-12-03 00:49:22',NULL,NULL,NULL),(98,7,126,8,7,'00:00:00',NULL,NULL,'2023-12-03 00:49:22',NULL,NULL,NULL),(99,7,127,8,8,'00:00:00',NULL,NULL,'2023-12-03 00:49:22',NULL,NULL,NULL),(100,8,95,8,1,'00:00:00',NULL,NULL,'2023-12-03 02:23:27',NULL,NULL,NULL),(101,8,96,8,2,'00:00:00',NULL,NULL,'2023-12-03 02:23:27',NULL,NULL,NULL),(102,8,97,8,3,'00:00:00',NULL,NULL,'2023-12-03 02:23:27',NULL,NULL,NULL),(103,8,102,8,4,'00:00:00',NULL,NULL,'2023-12-03 02:23:27',NULL,NULL,NULL),(104,8,108,8,5,'00:00:00',NULL,NULL,'2023-12-03 02:23:27',NULL,NULL,NULL),(105,8,109,8,6,'00:00:00',NULL,NULL,'2023-12-03 02:23:27',NULL,NULL,NULL),(106,8,126,8,7,'00:00:00',NULL,NULL,'2023-12-03 02:23:27',NULL,NULL,NULL),(107,8,127,8,8,'00:00:00',NULL,NULL,'2023-12-03 02:23:27',NULL,NULL,NULL),(108,8,115,10,1,'00:00:00',NULL,NULL,'2023-12-03 02:23:58',NULL,NULL,NULL),(109,8,116,10,2,'00:00:00',NULL,NULL,'2023-12-03 02:23:58',NULL,NULL,NULL),(110,8,117,10,3,'00:00:00',NULL,NULL,'2023-12-03 02:23:58',NULL,NULL,NULL),(111,8,118,10,4,'00:00:00',NULL,NULL,'2023-12-03 02:23:58',NULL,NULL,NULL),(112,8,119,10,5,'00:00:00',NULL,NULL,'2023-12-03 02:23:58',NULL,NULL,NULL),(113,8,120,10,6,'00:00:00',NULL,NULL,'2023-12-03 02:23:58',NULL,NULL,NULL),(114,8,121,10,7,'00:00:00',NULL,NULL,'2023-12-03 02:23:58',NULL,NULL,NULL),(115,8,122,10,8,'00:00:00',NULL,NULL,'2023-12-03 02:23:58',NULL,NULL,NULL),(116,9,135,12,1,'00:00:00',NULL,NULL,'2023-12-23 20:45:02',NULL,2,NULL),(117,9,136,12,2,'00:00:00',NULL,NULL,'2023-12-23 20:45:02',NULL,2,NULL),(118,9,137,12,3,'00:00:00',NULL,NULL,'2023-12-23 20:45:02',NULL,2,NULL),(119,9,138,12,4,'00:00:00',NULL,NULL,'2023-12-23 20:45:02',NULL,2,NULL),(120,9,139,12,5,'00:00:00',NULL,NULL,'2023-12-23 20:45:02',NULL,2,NULL),(121,9,140,12,6,'00:00:00',NULL,NULL,'2023-12-23 20:45:02',NULL,2,NULL),(122,9,144,12,7,'00:00:00',NULL,NULL,'2023-12-23 20:45:02',NULL,2,NULL),(123,9,145,12,8,'00:00:00',NULL,NULL,'2023-12-23 20:45:02',NULL,2,NULL),(124,9,53,5,1,'00:00:00',NULL,NULL,'2023-12-23 20:45:37',NULL,2,NULL),(125,9,54,5,2,'00:00:00',NULL,NULL,'2023-12-23 20:45:37',NULL,2,NULL),(126,9,55,5,3,'00:00:00',NULL,NULL,'2023-12-23 20:45:37',NULL,2,NULL),(127,9,56,5,4,'00:00:00',NULL,NULL,'2023-12-23 20:45:37',NULL,2,NULL),(128,9,57,5,5,'00:00:00',NULL,NULL,'2023-12-23 20:45:37',NULL,2,NULL),(129,9,58,5,6,'00:00:00',NULL,NULL,'2023-12-23 20:45:37',NULL,2,NULL),(130,9,59,5,7,'00:00:00',NULL,NULL,'2023-12-23 20:45:37',NULL,2,NULL),(131,9,60,5,8,'00:00:00',NULL,NULL,'2023-12-23 20:45:37',NULL,2,NULL),(132,10,166,13,1,'00:00:00',NULL,NULL,'2023-12-23 20:46:07',NULL,2,NULL),(133,10,167,13,2,'00:00:00',NULL,NULL,'2023-12-23 20:46:07',NULL,2,NULL),(134,10,168,13,3,'00:00:00',NULL,NULL,'2023-12-23 20:46:07',NULL,2,NULL),(135,10,169,13,4,'00:00:00',NULL,NULL,'2023-12-23 20:46:07',NULL,2,NULL),(136,10,170,13,5,'00:00:00',NULL,NULL,'2023-12-23 20:46:07',NULL,2,NULL),(137,10,171,13,6,'00:00:00',NULL,NULL,'2023-12-23 20:46:07',NULL,2,NULL),(138,10,172,13,7,'00:00:00',NULL,NULL,'2023-12-23 20:46:07',NULL,2,NULL),(139,10,173,13,8,'00:00:00',NULL,NULL,'2023-12-23 20:46:07',NULL,2,NULL),(140,10,182,14,1,'00:00:00',NULL,NULL,'2023-12-23 20:46:31',NULL,2,NULL),(141,10,183,14,2,'00:00:00',NULL,NULL,'2023-12-23 20:46:31',NULL,2,NULL),(142,10,184,14,3,'00:00:00',NULL,NULL,'2023-12-23 20:46:31',NULL,2,NULL),(143,10,185,14,4,'00:00:00',NULL,NULL,'2023-12-23 20:46:31',NULL,2,NULL),(144,10,186,14,5,'00:00:00',NULL,NULL,'2023-12-23 20:46:31',NULL,2,NULL),(145,10,187,14,6,'00:00:00',NULL,NULL,'2023-12-23 20:46:31',NULL,2,NULL),(146,10,188,14,7,'00:00:00',NULL,NULL,'2023-12-23 20:46:31',NULL,2,NULL),(147,10,189,14,8,'00:00:00',NULL,NULL,'2023-12-23 20:46:31',NULL,2,NULL),(148,11,198,15,1,'00:00:00',NULL,NULL,'2023-12-23 20:46:56',NULL,2,NULL),(149,11,199,15,2,'00:00:00',NULL,NULL,'2023-12-23 20:46:56',NULL,2,NULL),(150,11,200,15,3,'00:00:00',NULL,NULL,'2023-12-23 20:46:56',NULL,2,NULL),(151,11,201,15,4,'00:00:00',NULL,NULL,'2023-12-23 20:46:56',NULL,2,NULL),(152,11,202,15,5,'00:00:00',NULL,NULL,'2023-12-23 20:46:56',NULL,2,NULL),(153,11,203,15,6,'00:00:00',NULL,NULL,'2023-12-23 20:46:56',NULL,2,NULL),(154,11,204,15,7,'00:00:00',NULL,NULL,'2023-12-23 20:46:56',NULL,2,NULL),(155,11,205,15,8,'00:00:00',NULL,NULL,'2023-12-23 20:46:56',NULL,2,NULL),(156,11,214,16,1,'00:00:00',NULL,NULL,'2023-12-23 20:47:24',NULL,2,NULL),(157,11,215,16,2,'00:00:00',NULL,NULL,'2023-12-23 20:47:24',NULL,2,NULL),(158,11,216,16,3,'00:00:00',NULL,NULL,'2023-12-23 20:47:24',NULL,2,NULL),(159,11,217,16,4,'00:00:00',NULL,NULL,'2023-12-23 20:47:24',NULL,2,NULL),(160,11,218,16,5,'00:00:00',NULL,NULL,'2023-12-23 20:47:24',NULL,2,NULL),(161,11,219,16,6,'00:00:00',NULL,NULL,'2023-12-23 20:47:24',NULL,2,NULL),(162,11,220,16,7,'00:00:00',NULL,NULL,'2023-12-23 20:47:24',NULL,2,NULL),(163,11,221,16,8,'00:00:00',NULL,NULL,'2023-12-23 20:47:24',NULL,2,NULL),(164,12,115,10,1,'00:00:00',NULL,NULL,'2023-12-23 20:49:59',NULL,2,NULL),(165,12,116,10,2,'00:00:00',NULL,NULL,'2023-12-23 20:49:59',NULL,2,NULL),(166,12,117,10,3,'00:00:00',NULL,NULL,'2023-12-23 20:49:59',NULL,2,NULL),(167,12,118,10,4,'00:00:00',NULL,NULL,'2023-12-23 20:49:59',NULL,2,NULL),(168,12,119,10,5,'00:00:00',NULL,NULL,'2023-12-23 20:49:59',NULL,2,NULL),(169,12,120,10,6,'00:00:00',NULL,NULL,'2023-12-23 20:49:59',NULL,2,NULL),(170,12,121,10,7,'00:00:00',NULL,NULL,'2023-12-23 20:49:59',NULL,2,NULL),(171,12,122,10,8,'00:00:00',NULL,NULL,'2023-12-23 20:49:59',NULL,2,NULL);
/*!40000 ALTER TABLE `players` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scores`
--

DROP TABLE IF EXISTS `scores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scores` (
  `score_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `match_id` int(10) unsigned NOT NULL,
  `id` bigint(20) unsigned NOT NULL,
  `assist_id` bigint(20) unsigned DEFAULT NULL,
  `club_id` int(10) unsigned NOT NULL,
  `score_time` time NOT NULL,
  `owngoal` int(11) NOT NULL,
  `scores_created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `scores_updated_at` timestamp NULL DEFAULT NULL,
  `score_period` int(10) unsigned NOT NULL,
  PRIMARY KEY (`score_id`),
  KEY `scores_match_id_foreign` (`match_id`),
  KEY `scores_id_foreign` (`id`),
  KEY `scores_assist_id_foreign` (`assist_id`),
  KEY `scores_club_id_foreign` (`club_id`),
  CONSTRAINT `scores_assist_id_foreign` FOREIGN KEY (`assist_id`) REFERENCES `users` (`id`),
  CONSTRAINT `scores_club_id_foreign` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`club_id`),
  CONSTRAINT `scores_id_foreign` FOREIGN KEY (`id`) REFERENCES `users` (`id`),
  CONSTRAINT `scores_match_id_foreign` FOREIGN KEY (`match_id`) REFERENCES `matches` (`match_id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scores`
--

LOCK TABLES `scores` WRITE;
/*!40000 ALTER TABLE `scores` DISABLE KEYS */;
INSERT INTO `scores` VALUES (1,1,79,NULL,6,'00:06:18',0,'2023-11-25 15:26:04',NULL,0),(2,1,78,NULL,6,'12:37:38',0,'2023-11-25 15:27:38',NULL,0),(3,1,12,NULL,2,'12:12:41',0,'2023-11-25 15:32:37',NULL,0),(4,1,12,NULL,2,'12:15:43',0,'2023-11-25 15:35:39',NULL,0),(5,2,11,NULL,2,'00:00:31',0,'2023-11-25 16:09:37',NULL,0),(6,2,11,NULL,2,'00:00:35',0,'2023-11-25 16:09:41',NULL,0),(7,2,12,NULL,2,'00:01:23',0,'2023-11-29 18:37:56',NULL,0),(8,2,16,NULL,2,'00:05:05',0,'2023-11-25 16:14:11',NULL,0),(9,2,12,NULL,2,'00:11:31',0,'2023-11-25 16:20:37',NULL,0),(10,2,10,NULL,2,'12:11:33',0,'2023-11-25 16:24:06',NULL,0),(11,2,10,NULL,2,'12:13:43',0,'2023-11-25 16:26:16',NULL,0),(12,2,9,NULL,2,'12:19:53',0,'2023-11-25 16:32:26',NULL,0),(13,2,9,NULL,2,'12:20:19',0,'2023-11-25 16:32:52',NULL,0),(14,3,37,NULL,4,'00:04:47',0,'2023-11-25 16:41:42',NULL,0),(15,3,38,NULL,4,'00:05:57',0,'2023-11-25 16:42:52',NULL,0),(16,3,37,NULL,4,'00:07:05',0,'2023-11-25 16:44:00',NULL,0),(17,3,37,NULL,4,'00:07:39',0,'2023-11-25 16:44:34',NULL,0),(18,3,37,NULL,4,'12:13:36',0,'2023-11-25 16:53:03',NULL,0),(19,3,37,NULL,4,'12:14:42',0,'2023-11-25 16:54:09',NULL,0),(20,3,38,NULL,4,'12:18:52',0,'2023-11-25 16:58:19',NULL,0),(21,3,38,NULL,4,'12:19:28',0,'2023-11-25 16:58:55',NULL,0),(22,4,21,NULL,3,'00:00:13',0,'2023-11-25 17:30:43',NULL,0),(23,4,22,NULL,3,'00:08:07',0,'2023-11-25 17:38:37',NULL,0),(24,4,11,NULL,2,'00:09:45',0,'2023-11-25 17:40:15',NULL,0),(25,4,22,NULL,3,'00:10:35',0,'2023-11-25 17:41:05',NULL,0),(26,4,21,NULL,3,'12:12:13',0,'2023-11-25 17:45:01',NULL,0),(27,4,21,NULL,3,'12:13:40',0,'2023-11-25 17:46:28',NULL,0),(28,4,22,NULL,3,'12:18:30',0,'2023-11-25 17:51:18',NULL,0),(29,5,11,NULL,2,'00:02:06',0,'2023-11-25 17:59:13',NULL,0),(30,5,12,NULL,2,'00:05:56',0,'2023-11-25 18:03:03',NULL,0),(31,5,12,NULL,2,'00:08:23',0,'2023-11-25 18:05:30',NULL,0),(32,5,12,NULL,2,'12:09:20',0,'2023-11-25 18:14:26',NULL,0),(33,5,53,NULL,5,'12:13:11',0,'2023-11-25 18:18:17',NULL,0),(34,6,12,NULL,2,'00:01:48',0,'2023-11-25 20:10:55',NULL,0),(35,6,11,NULL,2,'00:08:17',0,'2023-11-25 20:17:24',NULL,0),(36,6,11,NULL,2,'00:11:50',0,'2023-11-25 20:20:57',NULL,0),(37,6,11,NULL,2,'12:23:19',0,'2023-11-25 20:36:11',NULL,0),(38,6,12,NULL,2,'12:26:03',0,'2023-11-25 20:38:55',NULL,0),(39,7,115,NULL,10,'00:10:02',0,'2023-12-03 01:00:03',NULL,0),(40,7,115,NULL,10,'00:12:29',0,'2023-12-03 01:02:30',NULL,0),(41,7,115,NULL,10,'00:17:39',0,'2023-12-03 01:13:58',NULL,0),(42,7,115,NULL,10,'00:18:44',0,'2023-12-03 01:15:03',NULL,0),(43,7,115,NULL,10,'00:21:15',0,'2023-12-03 01:17:34',NULL,0),(44,8,95,NULL,8,'00:09:09',0,'2023-12-03 02:38:57',NULL,0),(45,8,115,NULL,10,'00:14:31',0,'2023-12-03 02:44:19',NULL,0),(46,8,95,NULL,8,'00:15:02',0,'2023-12-03 02:44:50',NULL,0),(47,8,115,NULL,10,'00:15:57',0,'2023-12-03 02:51:56',NULL,0),(48,8,115,NULL,10,'00:18:27',0,'2023-12-03 02:54:26',NULL,0),(49,8,115,NULL,10,'00:19:57',0,'2023-12-03 02:55:56',NULL,0),(50,8,115,NULL,10,'00:21:28',0,'2023-12-03 02:57:27',NULL,0),(51,8,115,NULL,10,'00:23:26',0,'2023-12-03 02:59:25',NULL,0),(52,8,115,NULL,10,'00:24:10',0,'2023-12-03 03:00:09',NULL,0),(53,8,115,NULL,10,'00:24:45',0,'2023-12-03 03:00:44',NULL,0),(54,8,115,NULL,10,'00:28:34',0,'2023-12-03 03:04:33',NULL,0),(55,8,115,NULL,10,'00:29:30',0,'2023-12-03 03:05:29',NULL,0);
/*!40000 ALTER TABLE `scores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nickname` varchar(60) DEFAULT NULL,
  `sex` int(11) NOT NULL,
  `birth` date NOT NULL,
  `club_id` int(10) unsigned NOT NULL,
  `category` int(11) NOT NULL,
  `entrance_year` int(11) NOT NULL,
  `number` int(11) DEFAULT NULL,
  `position` int(11) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `user_auth` int(11) NOT NULL,
  `user_status` int(11) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `users_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `users_updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=229 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'ダミーユーザ','a@gmail.com','aaa','ダミー',0,'1900-01-01',1,9,2023,NULL,9,NULL,0,0,NULL,NULL,'2023-11-17 07:00:00',NULL),(2,'村田 肇','mrthjm0223@gmail.com','aaa','村田コーチ',0,'1982-02-23',2,2,2023,NULL,0,NULL,0,0,NULL,NULL,'2023-11-17 07:00:00',NULL),(3,'堀口 光寿','sbc_1@gmail.com','aaa','堀口コーチ',0,'1900-01-01',2,1,2023,NULL,0,NULL,6,0,NULL,NULL,'2023-11-17 07:00:00',NULL),(4,'原田 哲','sbc_2@gmail.com','aaa','原田コーチ',0,'1981-04-02',2,2,2023,NULL,0,NULL,6,0,NULL,NULL,'2023-11-17 07:00:00',NULL),(5,'小嶋 拓郎','sbc_3@gmail.com','aaa','小嶋コーチ',0,'1900-01-01',2,2,2023,NULL,0,NULL,6,0,NULL,NULL,'2023-11-17 07:00:00',NULL),(6,'森田 浩之','sbc_4@gmail.com','aaa','森田コーチ',0,'1900-01-01',2,2,2023,NULL,0,NULL,6,0,NULL,NULL,'2023-11-17 07:00:00',NULL),(7,'村田 紬','sb_2@gmail.com','aaa','つむぐ',0,'2017-03-15',2,3,2023,2,7,NULL,9,0,NULL,NULL,'2023-11-17 07:00:00',NULL),(8,'松本 悠汰','sb_3@gmail.com','aaa','ゆうた',0,'2017-02-01',2,3,2023,3,5,NULL,9,0,NULL,NULL,'2023-11-17 07:00:00',NULL),(9,'寺田 陽文','sb_5@gmail.com','aaa','ふみ',0,'2016-04-02',2,3,2023,5,5,NULL,9,0,NULL,NULL,'2023-11-17 07:00:00',NULL),(10,'小川 佑都','sb_8@gmail.com','aaa','ゆうと',0,'2016-04-02',2,3,2023,8,5,NULL,9,0,NULL,NULL,'2023-11-17 07:00:00',NULL),(11,'大崎 弦和','sb_9@gmail.com','aaa','げんと',0,'2016-04-02',2,3,2023,9,7,NULL,9,0,NULL,NULL,'2023-11-17 07:00:00',NULL),(12,'廣瀬 道真','sb_10@gmail.com','aaa','とうま',0,'2016-04-02',2,3,2023,10,5,NULL,9,0,NULL,NULL,'2023-11-17 07:00:00',NULL),(13,'小嶋 麗龍','sb_11@gmail.com','aaa','りかる',0,'2016-04-02',2,3,2023,11,5,NULL,9,0,NULL,NULL,'2023-11-17 07:00:00',NULL),(14,'小林 麟太郎','sb_17@gmail.com','aaa','りんたろう',0,'2016-04-02',2,3,2023,17,5,NULL,9,0,NULL,NULL,'2023-11-17 07:00:00',NULL),(15,'原田 悠矢','sb_18@gmail.com','aaa','ゆうや',0,'2016-04-02',2,3,2023,18,5,NULL,9,0,NULL,NULL,'2023-11-17 07:00:00',NULL),(16,'伊藤 稜','sb_19@gmail.com','aaa','りょう',0,'2016-04-02',2,3,2023,19,5,NULL,9,0,NULL,NULL,'2023-11-17 07:00:00',NULL),(17,'丹野 友陽','sb_55@gmail.com','aaa','とも',0,'2016-04-02',2,3,2023,55,3,NULL,9,0,NULL,NULL,'2023-11-17 07:00:00',NULL),(18,'橋口 傑','sb_60@gmail.com','aaa','すぐる',0,'2016-04-02',2,3,2023,60,5,NULL,9,0,NULL,NULL,'2023-11-17 07:00:00',NULL),(19,'奥村 航','sb_37@gmail.com','aaa','わたる',0,'2016-04-02',2,3,2023,37,5,NULL,9,0,NULL,NULL,'2023-11-17 07:00:00',NULL),(20,'- -','tk-0@gmail.com','aaa','-',0,'2016-04-02',3,2,2023,NULL,9,NULL,6,0,NULL,NULL,'2023-11-25 14:41:38',NULL),(21,'- -','tk-1@gmail.com','aaa','-',0,'2016-04-02',3,3,2023,1,0,NULL,9,0,NULL,NULL,'2023-11-25 14:41:38',NULL),(22,'- -','tk-2@gmail.com','aaa','-',0,'2016-04-02',3,3,2023,2,0,NULL,9,0,NULL,NULL,'2023-11-25 14:41:38',NULL),(23,'- -','tk-3@gmail.com','aaa','-',0,'2016-04-02',3,3,2023,3,0,NULL,9,0,NULL,NULL,'2023-11-25 14:41:38',NULL),(24,'- -','tk-4@gmail.com','aaa','-',0,'2016-04-02',3,3,2023,4,0,NULL,9,0,NULL,NULL,'2023-11-25 14:41:38',NULL),(25,'- -','tk-5@gmail.com','aaa','-',0,'2016-04-02',3,3,2023,5,0,NULL,9,0,NULL,NULL,'2023-11-25 14:41:38',NULL),(26,'- -','tk-6@gmail.com','aaa','-',0,'2016-04-02',3,3,2023,6,0,NULL,9,0,NULL,NULL,'2023-11-25 14:41:38',NULL),(27,'- -','tk-7@gmail.com','aaa','-',0,'2016-04-02',3,3,2023,7,0,NULL,9,0,NULL,NULL,'2023-11-25 14:41:38',NULL),(28,'- -','tk-8@gmail.com','aaa','-',0,'2016-04-02',3,3,2023,8,0,NULL,9,0,NULL,NULL,'2023-11-25 14:41:38',NULL),(29,'- -','tk-9@gmail.com','aaa','-',0,'2016-04-02',3,3,2023,9,0,NULL,9,0,NULL,NULL,'2023-11-25 14:41:38',NULL),(30,'- -','tk-10@gmail.com','aaa','-',0,'2016-04-02',3,3,2023,10,0,NULL,9,0,NULL,NULL,'2023-11-25 14:41:38',NULL),(31,'- -','tk-11@gmail.com','aaa','-',0,'2016-04-02',3,3,2023,11,0,NULL,9,0,NULL,NULL,'2023-11-25 14:41:38',NULL),(32,'- -','tk-12@gmail.com','aaa','-',0,'2016-04-02',3,3,2023,12,0,NULL,9,0,NULL,NULL,'2023-11-25 14:41:38',NULL),(33,'- -','tk-13@gmail.com','aaa','-',0,'2016-04-02',3,3,2023,13,0,NULL,9,0,NULL,NULL,'2023-11-25 14:41:38',NULL),(34,'- -','tk-14@gmail.com','aaa','-',0,'2016-04-02',3,3,2023,14,0,NULL,9,0,NULL,NULL,'2023-11-25 14:41:38',NULL),(35,'- -','tk-15@gmail.com','aaa','-',0,'2016-04-02',3,3,2023,15,0,NULL,9,0,NULL,NULL,'2023-11-25 14:41:38',NULL),(36,'- -','e-0@gmail.com','aaa','-',0,'2016-04-02',4,2,2023,NULL,9,NULL,6,0,NULL,NULL,'2023-11-25 14:42:26',NULL),(37,'- -','e-1@gmail.com','aaa','-',0,'2016-04-02',4,3,2023,1,0,NULL,9,0,NULL,NULL,'2023-11-25 14:42:26',NULL),(38,'- -','e-2@gmail.com','aaa','-',0,'2016-04-02',4,3,2023,2,0,NULL,9,0,NULL,NULL,'2023-11-25 14:42:26',NULL),(39,'- -','e-3@gmail.com','aaa','-',0,'2016-04-02',4,3,2023,3,0,NULL,9,0,NULL,NULL,'2023-11-25 14:42:26',NULL),(40,'- -','e-4@gmail.com','aaa','-',0,'2016-04-02',4,3,2023,4,0,NULL,9,0,NULL,NULL,'2023-11-25 14:42:26',NULL),(41,'- -','e-5@gmail.com','aaa','-',0,'2016-04-02',4,3,2023,5,0,NULL,9,0,NULL,NULL,'2023-11-25 14:42:26',NULL),(42,'- -','e-6@gmail.com','aaa','-',0,'2016-04-02',4,3,2023,6,0,NULL,9,0,NULL,NULL,'2023-11-25 14:42:26',NULL),(43,'- -','e-7@gmail.com','aaa','-',0,'2016-04-02',4,3,2023,7,0,NULL,9,0,NULL,NULL,'2023-11-25 14:42:26',NULL),(44,'- -','e-8@gmail.com','aaa','-',0,'2016-04-02',4,3,2023,8,0,NULL,9,0,NULL,NULL,'2023-11-25 14:42:26',NULL),(45,'- -','e-9@gmail.com','aaa','-',0,'2016-04-02',4,3,2023,9,0,NULL,9,0,NULL,NULL,'2023-11-25 14:42:26',NULL),(46,'- -','e-10@gmail.com','aaa','-',0,'2016-04-02',4,3,2023,10,0,NULL,9,0,NULL,NULL,'2023-11-25 14:42:26',NULL),(47,'- -','e-11@gmail.com','aaa','-',0,'2016-04-02',4,3,2023,11,0,NULL,9,0,NULL,NULL,'2023-11-25 14:42:26',NULL),(48,'- -','e-12@gmail.com','aaa','-',0,'2016-04-02',4,3,2023,12,0,NULL,9,0,NULL,NULL,'2023-11-25 14:42:26',NULL),(49,'- -','e-13@gmail.com','aaa','-',0,'2016-04-02',4,3,2023,13,0,NULL,9,0,NULL,NULL,'2023-11-25 14:42:26',NULL),(50,'- -','e-14@gmail.com','aaa','-',0,'2016-04-02',4,3,2023,14,0,NULL,9,0,NULL,NULL,'2023-11-25 14:42:26',NULL),(51,'- -','e-15@gmail.com','aaa','-',0,'2016-04-02',4,3,2023,15,0,NULL,9,0,NULL,NULL,'2023-11-25 14:42:26',NULL),(52,'- -','hon-0@gmail.com','aaa','-',0,'2016-04-02',5,2,2023,NULL,9,NULL,6,0,NULL,NULL,'2023-11-25 14:43:13',NULL),(53,'- -','hon-1@gmail.com','aaa','-',0,'2016-04-02',5,3,2023,1,0,NULL,9,0,NULL,NULL,'2023-11-25 14:43:13',NULL),(54,'- -','hon-2@gmail.com','aaa','-',0,'2016-04-02',5,3,2023,2,0,NULL,9,0,NULL,NULL,'2023-11-25 14:43:13',NULL),(55,'- -','hon-3@gmail.com','aaa','-',0,'2016-04-02',5,3,2023,3,0,NULL,9,0,NULL,NULL,'2023-11-25 14:43:13',NULL),(56,'- -','hon-4@gmail.com','aaa','-',0,'2016-04-02',5,3,2023,4,0,NULL,9,0,NULL,NULL,'2023-11-25 14:43:13',NULL),(57,'- -','hon-5@gmail.com','aaa','-',0,'2016-04-02',5,3,2023,5,0,NULL,9,0,NULL,NULL,'2023-11-25 14:43:13',NULL),(58,'- -','hon-6@gmail.com','aaa','-',0,'2016-04-02',5,3,2023,6,0,NULL,9,0,NULL,NULL,'2023-11-25 14:43:13',NULL),(59,'- -','hon-7@gmail.com','aaa','-',0,'2016-04-02',5,3,2023,7,0,NULL,9,0,NULL,NULL,'2023-11-25 14:43:13',NULL),(60,'- -','hon-8@gmail.com','aaa','-',0,'2016-04-02',5,3,2023,8,0,NULL,9,0,NULL,NULL,'2023-11-25 14:43:13',NULL),(61,'- -','hon-9@gmail.com','aaa','-',0,'2016-04-02',5,3,2023,9,0,NULL,9,0,NULL,NULL,'2023-11-25 14:43:13',NULL),(62,'- -','hon-10@gmail.com','aaa','-',0,'2016-04-02',5,3,2023,10,0,NULL,9,0,NULL,NULL,'2023-11-25 14:43:13',NULL),(63,'- -','hon-11@gmail.com','aaa','-',0,'2016-04-02',5,3,2023,11,0,NULL,9,0,NULL,NULL,'2023-11-25 14:43:13',NULL),(64,'- -','hon-12@gmail.com','aaa','-',0,'2016-04-02',5,3,2023,12,0,NULL,9,0,NULL,NULL,'2023-11-25 14:43:13',NULL),(65,'- -','hon-13@gmail.com','aaa','-',0,'2016-04-02',5,3,2023,13,0,NULL,9,0,NULL,NULL,'2023-11-25 14:43:13',NULL),(66,'- -','hon-14@gmail.com','aaa','-',0,'2016-04-02',5,3,2023,14,0,NULL,9,0,NULL,NULL,'2023-11-25 14:43:13',NULL),(67,'- -','hon-15@gmail.com','aaa','-',0,'2016-04-02',5,3,2023,15,0,NULL,9,0,NULL,NULL,'2023-11-25 14:43:13',NULL),(68,'- -','hon-16@gmail.com','aaa','-',0,'2016-04-02',5,3,2023,16,0,NULL,9,0,NULL,NULL,'2023-11-25 14:43:13',NULL),(69,'- -','hon-17@gmail.com','aaa','-',0,'2016-04-02',5,3,2023,17,0,NULL,9,0,NULL,NULL,'2023-11-25 14:43:13',NULL),(70,'- -','hon-18@gmail.com','aaa','-',0,'2016-04-02',5,3,2023,18,0,NULL,9,0,NULL,NULL,'2023-11-25 14:43:13',NULL),(71,'- -','hon-19@gmail.com','aaa','-',0,'2016-04-02',5,3,2023,19,0,NULL,9,0,NULL,NULL,'2023-11-25 14:43:13',NULL),(72,'- -','hon-20@gmail.com','aaa','-',0,'2016-04-02',5,3,2023,20,0,NULL,9,0,NULL,NULL,'2023-11-25 14:43:13',NULL),(73,'- -','Mom-0@gmail.com','aaa','-',0,'2016-04-02',6,2,2023,NULL,9,NULL,6,0,NULL,NULL,'2023-11-25 15:12:00',NULL),(74,'- -','Mom-1@gmail.com','aaa','-',0,'2016-04-02',6,3,2023,1,0,NULL,9,0,NULL,NULL,'2023-11-25 15:12:00',NULL),(75,'- -','Mom-2@gmail.com','aaa','-',0,'2016-04-02',6,3,2023,2,0,NULL,9,0,NULL,NULL,'2023-11-25 15:12:00',NULL),(76,'- -','Mom-3@gmail.com','aaa','-',0,'2016-04-02',6,3,2023,3,0,NULL,9,0,NULL,NULL,'2023-11-25 15:12:00',NULL),(77,'- -','Mom-4@gmail.com','aaa','-',0,'2016-04-02',6,3,2023,4,0,NULL,9,0,NULL,NULL,'2023-11-25 15:12:00',NULL),(78,'- -','Mom-5@gmail.com','aaa','-',0,'2016-04-02',6,3,2023,5,0,NULL,9,0,NULL,NULL,'2023-11-25 15:12:00',NULL),(79,'- -','Mom-6@gmail.com','aaa','-',0,'2016-04-02',6,3,2023,6,0,NULL,9,0,NULL,NULL,'2023-11-25 15:12:00',NULL),(80,'- -','Mom-7@gmail.com','aaa','-',0,'2016-04-02',6,3,2023,7,0,NULL,9,0,NULL,NULL,'2023-11-25 15:12:00',NULL),(92,'- -','Ryo-0@gmail.com','aaa','-',0,'2016-04-02',8,2,2023,NULL,9,NULL,6,0,NULL,NULL,'2023-11-25 15:49:41',NULL),(93,'- -','Ryo-1@gmail.com','aaa','-',0,'2016-04-02',8,3,2023,1,0,NULL,9,0,NULL,NULL,'2023-11-25 15:49:41',NULL),(94,'- -','Ryo-2@gmail.com','aaa','-',0,'2016-04-02',8,3,2023,2,0,NULL,9,0,NULL,NULL,'2023-11-25 15:49:41',NULL),(95,'- -','Ryo-3@gmail.com','aaa','-',0,'2016-04-02',8,3,2023,3,0,NULL,9,0,NULL,NULL,'2023-11-25 15:49:41',NULL),(96,'- -','Ryo-4@gmail.com','aaa','-',0,'2016-04-02',8,3,2023,4,0,NULL,9,0,NULL,NULL,'2023-11-25 15:49:41',NULL),(97,'- -','Ryo-5@gmail.com','aaa','-',0,'2016-04-02',8,3,2023,5,0,NULL,9,0,NULL,NULL,'2023-11-25 15:49:41',NULL),(98,'- -','Ryo-6@gmail.com','aaa','-',0,'2016-04-02',8,3,2023,6,0,NULL,9,0,NULL,NULL,'2023-11-25 15:49:41',NULL),(99,'- -','Ryo-7@gmail.com','aaa','-',0,'2016-04-02',8,3,2023,7,0,NULL,9,0,NULL,NULL,'2023-11-25 15:49:41',NULL),(100,'- -','Ryo-8@gmail.com','aaa','-',0,'2016-04-02',8,3,2023,8,0,NULL,9,0,NULL,NULL,'2023-11-25 15:49:41',NULL),(101,'- -','Ryo-9@gmail.com','aaa','-',0,'2016-04-02',8,3,2023,9,0,NULL,9,0,NULL,NULL,'2023-11-25 15:49:41',NULL),(102,'- -','Ryo-10@gmail.com','aaa','-',0,'2016-04-02',8,3,2023,10,0,NULL,9,0,NULL,NULL,'2023-11-25 15:49:41',NULL),(103,'- -','jefa-0@gmail.com','aaa','-',0,'2016-04-02',9,2,2023,NULL,9,NULL,6,0,NULL,NULL,'2023-11-29 09:20:34',NULL),(104,'- -','jefa-1@gmail.com','aaa','-',0,'2016-04-02',9,3,2023,1,0,NULL,9,0,NULL,NULL,'2023-11-29 09:20:34',NULL),(105,'- -','jefa-2@gmail.com','aaa','-',0,'2016-04-02',9,3,2023,2,0,NULL,9,0,NULL,NULL,'2023-11-29 09:20:34',NULL),(106,'- -','jefa-3@gmail.com','aaa','-',0,'2016-04-02',9,3,2023,3,0,NULL,9,0,NULL,NULL,'2023-11-29 09:20:34',NULL),(107,'- -','jefa-4@gmail.com','aaa','-',0,'2016-04-02',9,3,2023,4,0,NULL,9,0,NULL,NULL,'2023-11-29 09:20:34',NULL),(108,'- -','jefa-5@gmail.com','aaa','-',0,'2016-04-02',9,3,2023,5,0,NULL,9,0,NULL,NULL,'2023-11-29 09:20:34',NULL),(109,'- -','jefa-6@gmail.com','aaa','-',0,'2016-04-02',9,3,2023,6,0,NULL,9,0,NULL,NULL,'2023-11-29 09:20:34',NULL),(110,'- -','jefa-7@gmail.com','aaa','-',0,'2016-04-02',9,3,2023,7,0,NULL,9,0,NULL,NULL,'2023-11-29 09:20:34',NULL),(111,'- -','jefa-8@gmail.com','aaa','-',0,'2016-04-02',9,3,2023,8,0,NULL,9,0,NULL,NULL,'2023-11-29 09:20:34',NULL),(112,'- -','jefa-9@gmail.com','aaa','-',0,'2016-04-02',9,3,2023,9,0,NULL,9,0,NULL,NULL,'2023-11-29 09:20:34',NULL),(113,'- -','jefa-10@gmail.com','aaa','-',0,'2016-04-02',9,3,2023,10,0,NULL,9,0,NULL,NULL,'2023-11-29 09:20:34',NULL),(114,'- -','mizumo-0@gmail.com','aaa','-',0,'2016-04-02',10,2,2023,NULL,9,NULL,6,0,NULL,NULL,'2023-11-29 09:26:30',NULL),(115,'- -','mizumo-1@gmail.com','aaa','-',0,'2016-04-02',10,3,2023,1,0,NULL,9,0,NULL,NULL,'2023-11-29 09:26:30',NULL),(116,'- -','mizumo-2@gmail.com','aaa','-',0,'2016-04-02',10,3,2023,2,0,NULL,9,0,NULL,NULL,'2023-11-29 09:26:30',NULL),(117,'- -','mizumo-3@gmail.com','aaa','-',0,'2016-04-02',10,3,2023,3,0,NULL,9,0,NULL,NULL,'2023-11-29 09:26:30',NULL),(118,'- -','mizumo-4@gmail.com','aaa','-',0,'2016-04-02',10,3,2023,4,0,NULL,9,0,NULL,NULL,'2023-11-29 09:26:30',NULL),(119,'- -','mizumo-5@gmail.com','aaa','-',0,'2016-04-02',10,3,2023,5,0,NULL,9,0,NULL,NULL,'2023-11-29 09:26:30',NULL),(120,'- -','mizumo-6@gmail.com','aaa','-',0,'2016-04-02',10,3,2023,6,0,NULL,9,0,NULL,NULL,'2023-11-29 09:26:30',NULL),(121,'- -','mizumo-7@gmail.com','aaa','-',0,'2016-04-02',10,3,2023,7,0,NULL,9,0,NULL,NULL,'2023-11-29 09:26:30',NULL),(122,'- -','mizumo-8@gmail.com','aaa','-',0,'2016-04-02',10,3,2023,8,0,NULL,9,0,NULL,NULL,'2023-11-29 09:26:30',NULL),(123,'- -','mizumo-9@gmail.com','aaa','-',0,'2016-04-02',10,3,2023,9,0,NULL,9,0,NULL,NULL,'2023-11-29 09:26:30',NULL),(124,'- -','mizumo-10@gmail.com','aaa','-',0,'2016-04-02',10,3,2023,10,0,NULL,9,0,NULL,NULL,'2023-11-29 09:26:30',NULL),(125,'- -','edo-0@gmail.com','aaa','-',0,'2016-04-02',11,2,2023,NULL,9,NULL,6,0,NULL,NULL,'2023-11-29 09:29:29',NULL),(126,'- -','edo-1@gmail.com','aaa','-',0,'2016-04-02',11,3,2023,1,0,NULL,9,0,NULL,NULL,'2023-11-29 09:29:29',NULL),(127,'- -','edo-2@gmail.com','aaa','-',0,'2016-04-02',11,3,2023,2,0,NULL,9,0,NULL,NULL,'2023-11-29 09:29:29',NULL),(128,'- -','edo-3@gmail.com','aaa','-',0,'2016-04-02',11,3,2023,3,0,NULL,9,0,NULL,NULL,'2023-11-29 09:29:29',NULL),(129,'- -','edo-4@gmail.com','aaa','-',0,'2016-04-02',11,3,2023,4,0,NULL,9,0,NULL,NULL,'2023-11-29 09:29:29',NULL),(130,'- -','edo-5@gmail.com','aaa','-',0,'2016-04-02',11,3,2023,5,0,NULL,9,0,NULL,NULL,'2023-11-29 09:29:29',NULL),(131,'- -','edo-6@gmail.com','aaa','-',0,'2016-04-02',11,3,2023,6,0,NULL,9,0,NULL,NULL,'2023-11-29 09:29:29',NULL),(132,'- -','edo-7@gmail.com','aaa','-',0,'2016-04-02',11,3,2023,7,0,NULL,9,0,NULL,NULL,'2023-11-29 09:29:29',NULL),(133,'- -','edo-8@gmail.com','aaa','-',0,'2016-04-02',11,3,2023,8,0,NULL,9,0,NULL,NULL,'2023-11-29 09:29:29',NULL),(134,'- -','kana-0@gmail.com','aaa','-',0,'2016-04-02',12,2,2023,NULL,9,NULL,6,0,NULL,NULL,'2023-12-23 12:53:22',NULL),(135,'- -','kana-1@gmail.com','aaa','-',0,'2016-04-02',12,3,2023,1,0,NULL,9,0,NULL,NULL,'2023-12-23 12:53:22',NULL),(136,'- -','kana-2@gmail.com','aaa','-',0,'2016-04-02',12,3,2023,2,0,NULL,9,0,NULL,NULL,'2023-12-23 12:53:22',NULL),(137,'- -','kana-3@gmail.com','aaa','-',0,'2016-04-02',12,3,2023,3,0,NULL,9,0,NULL,NULL,'2023-12-23 12:53:22',NULL),(138,'- -','kana-4@gmail.com','aaa','-',0,'2016-04-02',12,3,2023,4,0,NULL,9,0,NULL,NULL,'2023-12-23 12:53:22',NULL),(139,'- -','kana-5@gmail.com','aaa','-',0,'2016-04-02',12,3,2023,5,0,NULL,9,0,NULL,NULL,'2023-12-23 12:53:22',NULL),(140,'- -','kana-6@gmail.com','aaa','-',0,'2016-04-02',12,3,2023,6,0,NULL,9,0,NULL,NULL,'2023-12-23 12:53:22',NULL),(141,'- -','kana-7@gmail.com','aaa','-',0,'2016-04-02',12,3,2023,7,0,NULL,9,0,NULL,NULL,'2023-12-23 12:53:22',NULL),(142,'- -','kana-8@gmail.com','aaa','-',0,'2016-04-02',12,3,2023,8,0,NULL,9,0,NULL,NULL,'2023-12-23 12:53:22',NULL),(143,'- -','kana-9@gmail.com','aaa','-',0,'2016-04-02',12,3,2023,9,0,NULL,9,0,NULL,NULL,'2023-12-23 12:53:22',NULL),(144,'- -','kana-10@gmail.com','aaa','-',0,'2016-04-02',12,3,2023,10,0,NULL,9,0,NULL,NULL,'2023-12-23 12:53:22',NULL),(145,'- -','kana-11@gmail.com','aaa','-',0,'2016-04-02',12,3,2023,11,0,NULL,9,0,NULL,NULL,'2023-12-23 12:53:22',NULL),(146,'- -','kana-12@gmail.com','aaa','-',0,'2016-04-02',12,3,2023,12,0,NULL,9,0,NULL,NULL,'2023-12-23 12:53:22',NULL),(147,'- -','kana-13@gmail.com','aaa','-',0,'2016-04-02',12,3,2023,13,0,NULL,9,0,NULL,NULL,'2023-12-23 12:53:22',NULL),(148,'- -','kana-14@gmail.com','aaa','-',0,'2016-04-02',12,3,2023,14,0,NULL,9,0,NULL,NULL,'2023-12-23 12:53:22',NULL),(149,'- -','kana-15@gmail.com','aaa','-',0,'2016-04-02',12,3,2023,15,0,NULL,9,0,NULL,NULL,'2023-12-23 12:53:22',NULL),(150,'- -','kana-16@gmail.com','aaa','-',0,'2016-04-02',12,3,2023,16,0,NULL,9,0,NULL,NULL,'2023-12-23 12:53:22',NULL),(151,'- -','kana-17@gmail.com','aaa','-',0,'2016-04-02',12,3,2023,17,0,NULL,9,0,NULL,NULL,'2023-12-23 12:53:22',NULL),(152,'- -','kana-18@gmail.com','aaa','-',0,'2016-04-02',12,3,2023,18,0,NULL,9,0,NULL,NULL,'2023-12-23 12:53:22',NULL),(153,'- -','kana-19@gmail.com','aaa','-',0,'2016-04-02',12,3,2023,19,0,NULL,9,0,NULL,NULL,'2023-12-23 12:53:22',NULL),(154,'- -','kana-20@gmail.com','aaa','-',0,'2016-04-02',12,3,2023,20,0,NULL,9,0,NULL,NULL,'2023-12-23 12:53:22',NULL),(155,'- -','kana-21@gmail.com','aaa','-',0,'2016-04-02',12,3,2023,21,0,NULL,9,0,NULL,NULL,'2023-12-23 12:53:22',NULL),(156,'- -','kana-22@gmail.com','aaa','-',0,'2016-04-02',12,3,2023,22,0,NULL,9,0,NULL,NULL,'2023-12-23 12:53:22',NULL),(157,'- -','kana-23@gmail.com','aaa','-',0,'2016-04-02',12,3,2023,23,0,NULL,9,0,NULL,NULL,'2023-12-23 12:53:22',NULL),(158,'- -','kana-24@gmail.com','aaa','-',0,'2016-04-02',12,3,2023,24,0,NULL,9,0,NULL,NULL,'2023-12-23 12:53:22',NULL),(159,'- -','kana-25@gmail.com','aaa','-',0,'2016-04-02',12,3,2023,25,0,NULL,9,0,NULL,NULL,'2023-12-23 12:53:22',NULL),(160,'- -','kana-26@gmail.com','aaa','-',0,'2016-04-02',12,3,2023,26,0,NULL,9,0,NULL,NULL,'2023-12-23 12:53:22',NULL),(161,'- -','kana-27@gmail.com','aaa','-',0,'2016-04-02',12,3,2023,27,0,NULL,9,0,NULL,NULL,'2023-12-23 12:53:22',NULL),(162,'- -','kana-28@gmail.com','aaa','-',0,'2016-04-02',12,3,2023,28,0,NULL,9,0,NULL,NULL,'2023-12-23 12:53:22',NULL),(163,'- -','kana-29@gmail.com','aaa','-',0,'2016-04-02',12,3,2023,29,0,NULL,9,0,NULL,NULL,'2023-12-23 12:53:22',NULL),(164,'- -','kana-30@gmail.com','aaa','-',0,'2016-04-02',12,3,2023,30,0,NULL,9,0,NULL,NULL,'2023-12-23 12:53:22',NULL),(165,'- -','kitano-0@gmail.com','aaa','-',0,'2016-04-02',13,2,2023,NULL,9,NULL,6,0,NULL,NULL,'2023-12-23 12:54:33',NULL),(166,'- -','kitano-1@gmail.com','aaa','-',0,'2016-04-02',13,3,2023,1,0,NULL,9,0,NULL,NULL,'2023-12-23 12:54:33',NULL),(167,'- -','kitano-2@gmail.com','aaa','-',0,'2016-04-02',13,3,2023,2,0,NULL,9,0,NULL,NULL,'2023-12-23 12:54:33',NULL),(168,'- -','kitano-3@gmail.com','aaa','-',0,'2016-04-02',13,3,2023,3,0,NULL,9,0,NULL,NULL,'2023-12-23 12:54:33',NULL),(169,'- -','kitano-4@gmail.com','aaa','-',0,'2016-04-02',13,3,2023,4,0,NULL,9,0,NULL,NULL,'2023-12-23 12:54:33',NULL),(170,'- -','kitano-5@gmail.com','aaa','-',0,'2016-04-02',13,3,2023,5,0,NULL,9,0,NULL,NULL,'2023-12-23 12:54:33',NULL),(171,'- -','kitano-6@gmail.com','aaa','-',0,'2016-04-02',13,3,2023,6,0,NULL,9,0,NULL,NULL,'2023-12-23 12:54:33',NULL),(172,'- -','kitano-7@gmail.com','aaa','-',0,'2016-04-02',13,3,2023,7,0,NULL,9,0,NULL,NULL,'2023-12-23 12:54:33',NULL),(173,'- -','kitano-8@gmail.com','aaa','-',0,'2016-04-02',13,3,2023,8,0,NULL,9,0,NULL,NULL,'2023-12-23 12:54:33',NULL),(174,'- -','kitano-9@gmail.com','aaa','-',0,'2016-04-02',13,3,2023,9,0,NULL,9,0,NULL,NULL,'2023-12-23 12:54:33',NULL),(175,'- -','kitano-10@gmail.com','aaa','-',0,'2016-04-02',13,3,2023,10,0,NULL,9,0,NULL,NULL,'2023-12-23 12:54:33',NULL),(176,'- -','kitano-11@gmail.com','aaa','-',0,'2016-04-02',13,3,2023,11,0,NULL,9,0,NULL,NULL,'2023-12-23 12:54:33',NULL),(177,'- -','kitano-12@gmail.com','aaa','-',0,'2016-04-02',13,3,2023,12,0,NULL,9,0,NULL,NULL,'2023-12-23 12:54:33',NULL),(178,'- -','kitano-13@gmail.com','aaa','-',0,'2016-04-02',13,3,2023,13,0,NULL,9,0,NULL,NULL,'2023-12-23 12:54:33',NULL),(179,'- -','kitano-14@gmail.com','aaa','-',0,'2016-04-02',13,3,2023,14,0,NULL,9,0,NULL,NULL,'2023-12-23 12:54:33',NULL),(180,'- -','kitano-15@gmail.com','aaa','-',0,'2016-04-02',13,3,2023,15,0,NULL,9,0,NULL,NULL,'2023-12-23 12:54:33',NULL),(181,'- -','k_friendly-0@gmail.com','aaa','-',0,'2016-04-02',14,2,2023,NULL,9,NULL,6,0,NULL,NULL,'2023-12-23 12:55:59',NULL),(182,'- -','k_friendly-1@gmail.com','aaa','-',0,'2016-04-02',14,3,2023,1,0,NULL,9,0,NULL,NULL,'2023-12-23 12:55:59',NULL),(183,'- -','k_friendly-2@gmail.com','aaa','-',0,'2016-04-02',14,3,2023,2,0,NULL,9,0,NULL,NULL,'2023-12-23 12:55:59',NULL),(184,'- -','k_friendly-3@gmail.com','aaa','-',0,'2016-04-02',14,3,2023,3,0,NULL,9,0,NULL,NULL,'2023-12-23 12:55:59',NULL),(185,'- -','k_friendly-4@gmail.com','aaa','-',0,'2016-04-02',14,3,2023,4,0,NULL,9,0,NULL,NULL,'2023-12-23 12:55:59',NULL),(186,'- -','k_friendly-5@gmail.com','aaa','-',0,'2016-04-02',14,3,2023,5,0,NULL,9,0,NULL,NULL,'2023-12-23 12:55:59',NULL),(187,'- -','k_friendly-6@gmail.com','aaa','-',0,'2016-04-02',14,3,2023,6,0,NULL,9,0,NULL,NULL,'2023-12-23 12:55:59',NULL),(188,'- -','k_friendly-7@gmail.com','aaa','-',0,'2016-04-02',14,3,2023,7,0,NULL,9,0,NULL,NULL,'2023-12-23 12:55:59',NULL),(189,'- -','k_friendly-8@gmail.com','aaa','-',0,'2016-04-02',14,3,2023,8,0,NULL,9,0,NULL,NULL,'2023-12-23 12:55:59',NULL),(190,'- -','k_friendly-9@gmail.com','aaa','-',0,'2016-04-02',14,3,2023,9,0,NULL,9,0,NULL,NULL,'2023-12-23 12:55:59',NULL),(191,'- -','k_friendly-10@gmail.com','aaa','-',0,'2016-04-02',14,3,2023,10,0,NULL,9,0,NULL,NULL,'2023-12-23 12:55:59',NULL),(192,'- -','k_friendly-11@gmail.com','aaa','-',0,'2016-04-02',14,3,2023,11,0,NULL,9,0,NULL,NULL,'2023-12-23 12:55:59',NULL),(193,'- -','k_friendly-12@gmail.com','aaa','-',0,'2016-04-02',14,3,2023,12,0,NULL,9,0,NULL,NULL,'2023-12-23 12:55:59',NULL),(194,'- -','k_friendly-13@gmail.com','aaa','-',0,'2016-04-02',14,3,2023,13,0,NULL,9,0,NULL,NULL,'2023-12-23 12:55:59',NULL),(195,'- -','k_friendly-14@gmail.com','aaa','-',0,'2016-04-02',14,3,2023,14,0,NULL,9,0,NULL,NULL,'2023-12-23 12:55:59',NULL),(196,'- -','k_friendly-15@gmail.com','aaa','-',0,'2016-04-02',14,3,2023,15,0,NULL,9,0,NULL,NULL,'2023-12-23 12:55:59',NULL),(197,'- -','sumiyoshi-0@gmail.com','aaa','-',0,'2016-04-02',15,2,2023,NULL,9,NULL,6,0,NULL,NULL,'2023-12-23 12:57:59',NULL),(198,'- -','sumiyoshi-1@gmail.com','aaa','-',0,'2016-04-02',15,3,2023,1,0,NULL,9,0,NULL,NULL,'2023-12-23 12:57:59',NULL),(199,'- -','sumiyoshi-2@gmail.com','aaa','-',0,'2016-04-02',15,3,2023,2,0,NULL,9,0,NULL,NULL,'2023-12-23 12:57:59',NULL),(200,'- -','sumiyoshi-3@gmail.com','aaa','-',0,'2016-04-02',15,3,2023,3,0,NULL,9,0,NULL,NULL,'2023-12-23 12:57:59',NULL),(201,'- -','sumiyoshi-4@gmail.com','aaa','-',0,'2016-04-02',15,3,2023,4,0,NULL,9,0,NULL,NULL,'2023-12-23 12:57:59',NULL),(202,'- -','sumiyoshi-5@gmail.com','aaa','-',0,'2016-04-02',15,3,2023,5,0,NULL,9,0,NULL,NULL,'2023-12-23 12:57:59',NULL),(203,'- -','sumiyoshi-6@gmail.com','aaa','-',0,'2016-04-02',15,3,2023,6,0,NULL,9,0,NULL,NULL,'2023-12-23 12:57:59',NULL),(204,'- -','sumiyoshi-7@gmail.com','aaa','-',0,'2016-04-02',15,3,2023,7,0,NULL,9,0,NULL,NULL,'2023-12-23 12:57:59',NULL),(205,'- -','sumiyoshi-8@gmail.com','aaa','-',0,'2016-04-02',15,3,2023,8,0,NULL,9,0,NULL,NULL,'2023-12-23 12:57:59',NULL),(206,'- -','sumiyoshi-9@gmail.com','aaa','-',0,'2016-04-02',15,3,2023,9,0,NULL,9,0,NULL,NULL,'2023-12-23 12:57:59',NULL),(207,'- -','sumiyoshi-10@gmail.com','aaa','-',0,'2016-04-02',15,3,2023,10,0,NULL,9,0,NULL,NULL,'2023-12-23 12:57:59',NULL),(208,'- -','sumiyoshi-11@gmail.com','aaa','-',0,'2016-04-02',15,3,2023,11,0,NULL,9,0,NULL,NULL,'2023-12-23 12:57:59',NULL),(209,'- -','sumiyoshi-12@gmail.com','aaa','-',0,'2016-04-02',15,3,2023,12,0,NULL,9,0,NULL,NULL,'2023-12-23 12:57:59',NULL),(210,'- -','sumiyoshi-13@gmail.com','aaa','-',0,'2016-04-02',15,3,2023,13,0,NULL,9,0,NULL,NULL,'2023-12-23 12:57:59',NULL),(211,'- -','sumiyoshi-14@gmail.com','aaa','-',0,'2016-04-02',15,3,2023,14,0,NULL,9,0,NULL,NULL,'2023-12-23 12:57:59',NULL),(212,'- -','sumiyoshi-15@gmail.com','aaa','-',0,'2016-04-02',15,3,2023,15,0,NULL,9,0,NULL,NULL,'2023-12-23 12:57:59',NULL),(213,'- -','nosso-0@gmail.com','aaa','-',0,'2016-04-02',16,2,2023,NULL,9,NULL,6,0,NULL,NULL,'2023-12-23 12:58:50',NULL),(214,'- -','nosso-1@gmail.com','aaa','-',0,'2016-04-02',16,3,2023,1,0,NULL,9,0,NULL,NULL,'2023-12-23 12:58:50',NULL),(215,'- -','nosso-2@gmail.com','aaa','-',0,'2016-04-02',16,3,2023,2,0,NULL,9,0,NULL,NULL,'2023-12-23 12:58:50',NULL),(216,'- -','nosso-3@gmail.com','aaa','-',0,'2016-04-02',16,3,2023,3,0,NULL,9,0,NULL,NULL,'2023-12-23 12:58:50',NULL),(217,'- -','nosso-4@gmail.com','aaa','-',0,'2016-04-02',16,3,2023,4,0,NULL,9,0,NULL,NULL,'2023-12-23 12:58:50',NULL),(218,'- -','nosso-5@gmail.com','aaa','-',0,'2016-04-02',16,3,2023,5,0,NULL,9,0,NULL,NULL,'2023-12-23 12:58:50',NULL),(219,'- -','nosso-6@gmail.com','aaa','-',0,'2016-04-02',16,3,2023,6,0,NULL,9,0,NULL,NULL,'2023-12-23 12:58:50',NULL),(220,'- -','nosso-7@gmail.com','aaa','-',0,'2016-04-02',16,3,2023,7,0,NULL,9,0,NULL,NULL,'2023-12-23 12:58:50',NULL),(221,'- -','nosso-8@gmail.com','aaa','-',0,'2016-04-02',16,3,2023,8,0,NULL,9,0,NULL,NULL,'2023-12-23 12:58:50',NULL),(222,'- -','nosso-9@gmail.com','aaa','-',0,'2016-04-02',16,3,2023,9,0,NULL,9,0,NULL,NULL,'2023-12-23 12:58:50',NULL),(223,'- -','nosso-10@gmail.com','aaa','-',0,'2016-04-02',16,3,2023,10,0,NULL,9,0,NULL,NULL,'2023-12-23 12:58:50',NULL),(224,'- -','nosso-11@gmail.com','aaa','-',0,'2016-04-02',16,3,2023,11,0,NULL,9,0,NULL,NULL,'2023-12-23 12:58:50',NULL),(225,'- -','nosso-12@gmail.com','aaa','-',0,'2016-04-02',16,3,2023,12,0,NULL,9,0,NULL,NULL,'2023-12-23 12:58:50',NULL),(226,'- -','nosso-13@gmail.com','aaa','-',0,'2016-04-02',16,3,2023,13,0,NULL,9,0,NULL,NULL,'2023-12-23 12:58:50',NULL),(227,'- -','nosso-14@gmail.com','aaa','-',0,'2016-04-02',16,3,2023,14,0,NULL,9,0,NULL,NULL,'2023-12-23 12:58:50',NULL),(228,'- -','nosso-15@gmail.com','aaa','-',0,'2016-04-02',16,3,2023,15,0,NULL,9,0,NULL,NULL,'2023-12-23 12:58:50',NULL);
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

-- Dump completed on 2023-12-24  5:50:23
