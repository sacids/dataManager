-- MySQL dump 10.13  Distrib 8.0.21, for macos10.15 (x86_64)
--
-- Host: 127.0.0.1    Database: afyadata_db
-- ------------------------------------------------------
-- Server version	8.0.21

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
-- Table structure for table `acl_filters`
--

DROP TABLE IF EXISTS `acl_filters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `acl_filters` (
  `id` int NOT NULL AUTO_INCREMENT,
  `permission_id` int DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `table_name` varchar(255) DEFAULT NULL,
  `description` text,
  `where_condition` text,
  `date_added` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acl_filters`
--

LOCK TABLES `acl_filters` WRITE;
/*!40000 ALTER TABLE `acl_filters` DISABLE KEYS */;
/*!40000 ALTER TABLE `acl_filters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acl_permissions`
--

DROP TABLE IF EXISTS `acl_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `acl_permissions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `date_created` datetime DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acl_permissions`
--

LOCK TABLES `acl_permissions` WRITE;
/*!40000 ALTER TABLE `acl_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `acl_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acl_user_permissions`
--

DROP TABLE IF EXISTS `acl_user_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `acl_user_permissions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `permission_id` int DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acl_user_permissions`
--

LOCK TABLES `acl_user_permissions` WRITE;
/*!40000 ALTER TABLE `acl_user_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `acl_user_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_version`
--

DROP TABLE IF EXISTS `app_version`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `app_version` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `version` varchar(20) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_version`
--

LOCK TABLES `app_version` WRITE;
/*!40000 ALTER TABLE `app_version` DISABLE KEYS */;
/*!40000 ALTER TABLE `app_version` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `campaign`
--

DROP TABLE IF EXISTS `campaign`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `campaign` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `icon` varchar(100) NOT NULL,
  `form_id` varchar(255) NOT NULL,
  `end_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `campaign`
--

LOCK TABLES `campaign` WRITE;
/*!40000 ALTER TABLE `campaign` DISABLE KEYS */;
/*!40000 ALTER TABLE `campaign` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ci_sessions`
--

DROP TABLE IF EXISTS `ci_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int unsigned NOT NULL,
  `data` blob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_sessions`
--

LOCK TABLES `ci_sessions` WRITE;
/*!40000 ALTER TABLE `ci_sessions` DISABLE KEYS */;
INSERT INTO `ci_sessions` VALUES ('0508hvukj8u1c11kljnurpifk49nkjt3','::1',1617237990,_binary '__ci_last_regenerate|i:1617237990;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1617207714\";__ci_vars|a:1:{s:7:\"message\";s:3:\"old\";}message|s:57:\"<div class=\"alert alert-danger\">Account deactivated</div>\";'),('2ngud8d0ffjc699thtl7r9pf6cqpb0d0','::1',1617234230,_binary '__ci_last_regenerate|i:1617234230;'),('36at5mt86mbkse62v3dvti1pi34n5k0l','::1',1617240875,_binary '__ci_last_regenerate|i:1617240875;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1617207714\";'),('4v7rnt1cdrif5oa9cr3m1gtv2712m214','::1',1617236224,_binary '__ci_last_regenerate|i:1617236224;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1617207714\";'),('6bj4iu63bbai4s1vc6dtg04n9lopttk7','::1',1617239747,_binary '__ci_last_regenerate|i:1617239747;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1617207714\";message|N;'),('6hsm36rs1h8mvt3cllb5lsseqoo0r5nn','::1',1617232547,_binary '__ci_last_regenerate|i:1617232547;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1617207714\";'),('74cnjmqajenj0iu7knphn0t155pgocic','::1',1617238694,_binary '__ci_last_regenerate|i:1617238694;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1617207714\";'),('7m8g40rt66q62ohag1fa86n3i87frqmr','::1',1617234953,_binary '__ci_last_regenerate|i:1617234953;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1617207714\";'),('7usv9f4qb6rtpq6o9gsqm8ic1vkp3q3o','::1',1617231665,_binary '__ci_last_regenerate|i:1617231665;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1617207714\";'),('95a87gcphfmj300oq08ask0tjdvlp97c','::1',1617233993,_binary '__ci_last_regenerate|i:1617233993;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1617207714\";'),('9nqjr2u06hg68ed8i9gvphi1ga7mque1','::1',1617231358,_binary '__ci_last_regenerate|i:1617231358;'),('cmossfag0eomgnvbchqgqv9265990sjf','::1',1617234307,_binary '__ci_last_regenerate|i:1617234307;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1617207714\";'),('cmrhtkvo0ekv2vk60t9ifi8coogla927','::1',1617235547,_binary '__ci_last_regenerate|i:1617235547;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1617207714\";'),('fh8kj8h7cprncuav8qmk08kvlpbhbqbb','::1',1617237329,_binary '__ci_last_regenerate|i:1617237329;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1617207714\";csrfkey|s:8:\"MlgZLCz1\";__ci_vars|a:2:{s:7:\"csrfkey\";s:3:\"new\";s:9:\"csrfvalue\";s:3:\"new\";}csrfvalue|s:20:\"vxHhedzQAaNpnZCsoKM2\";'),('fn471pakpmvnqufe70atd517klbh67o6','::1',1617236592,_binary '__ci_last_regenerate|i:1617236592;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1617207714\";'),('g4ai2008rppsi2mruq6nlgbunj0ibn8j','::1',1617234236,_binary '__ci_last_regenerate|i:1617234236;'),('gj0hq1212e4282gvakts7ubhlu9352vv','::1',1617237678,_binary '__ci_last_regenerate|i:1617237678;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1617207714\";csrfkey|s:8:\"zO8fq4dK\";__ci_vars|a:2:{s:7:\"csrfkey\";s:3:\"new\";s:9:\"csrfvalue\";s:3:\"new\";}csrfvalue|s:20:\"1bnxYSU3tDGPI0VNHFBO\";'),('hc4cmca8lcbsrhri24bm4f0u2bu1q265','::1',1617241123,_binary '__ci_last_regenerate|i:1617240875;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1617207714\";'),('iend2hva3v79pn1nfq8g1klhpftubo83','::1',1617208183,_binary '__ci_last_regenerate|i:1617208002;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1617191618\";'),('ipj0mdg7jau29r30km39iveobspnv7rg','::1',1617234456,_binary '__ci_last_regenerate|i:1617234456;'),('jkfont3e0oeiojsa0apm628b2ti0u6q5','::1',1617240185,_binary '__ci_last_regenerate|i:1617240185;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1617207714\";'),('lkpmeqjdnhf7pn8js1v0eisogcgdq1ih','::1',1617233807,_binary '__ci_last_regenerate|i:1617233807;'),('o6omtspm64d5oqh5nics607nnb3ch1gp','::1',1617232613,_binary '__ci_last_regenerate|i:1617232613;'),('oh07bqbvso3f34ackhcelhdbju8vtsn8','::1',1617237028,_binary '__ci_last_regenerate|i:1617237028;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1617207714\";'),('po5sm3ace4m2qnicoir8c0k3n5ujl72t','::1',1617239003,_binary '__ci_last_regenerate|i:1617239003;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1617207714\";message|N;'),('qb2fo05mhesnc07mi4ej19b1eq9kpt7c','::1',1617233817,_binary '__ci_last_regenerate|i:1617233817;'),('qfojeq4ablohosj6vf4shdhlgp4njdof','::1',1617234637,_binary '__ci_last_regenerate|i:1617234637;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1617207714\";'),('qi9a13no90127fhho0qfqa17n4utt6v0','::1',1617231352,_binary '__ci_last_regenerate|i:1617231352;'),('qun6sb52odcr6jrnj7efh2inngqqeg13','::1',1617240560,_binary '__ci_last_regenerate|i:1617240560;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1617207714\";'),('r28b9727toih2dckaktsll42j9vdbfsq','::1',1617230263,_binary '__ci_last_regenerate|i:1617230263;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1617207714\";'),('rljv6etcibkno96v13o5qrc1lf9gttir','::1',1617233679,_binary '__ci_last_regenerate|i:1617233679;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1617207714\";'),('s351762pnicsadbt2ch246oq42jmubaq','::1',1617230591,_binary '__ci_last_regenerate|i:1617230591;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1617207714\";'),('stu87ppq6qfmhblq0unb2pqs8jbia0h9','::1',1617232236,_binary '__ci_last_regenerate|i:1617232236;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1617207714\";'),('t3q54a41d329dmoblu2145m0enbp2hte','::1',1617235866,_binary '__ci_last_regenerate|i:1617235866;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1617207714\";'),('u4hoj5cag8qise3uoqifmrthr7ct4qmp','::1',1617208002,_binary '__ci_last_regenerate|i:1617208002;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1617191618\";message|s:54:\"<div class=\"alert alert-success\">Project updated</div>\";__ci_vars|a:1:{s:7:\"message\";s:3:\"old\";}'),('ubmvufl3dfi03aefp6l7of8mofovvoo9','::1',1617238291,_binary '__ci_last_regenerate|i:1617238291;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1617207714\";'),('upk1e9r86jhpvf8njmj3aol9auj32o7p','::1',1617230985,_binary '__ci_last_regenerate|i:1617230985;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1617207714\";'),('v021544fr5e1a7pminnf20hffj3erf8b','::1',1617231340,_binary '__ci_last_regenerate|i:1617231340;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1617207714\";'),('v72nj0sqkijipn8m7knskj2v48ai5qhv','::1',1617239377,_binary '__ci_last_regenerate|i:1617239377;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1617207714\";message|N;');
/*!40000 ALTER TABLE `ci_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `feedback` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `form_id` varchar(100) NOT NULL,
  `user_id` int NOT NULL,
  `message` text NOT NULL,
  `date_created` datetime NOT NULL,
  `viewed_by` text,
  `instance_id` varchar(255) DEFAULT NULL,
  `sender` varchar(10) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `reply_by` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feedback`
--

LOCK TABLES `feedback` WRITE;
/*!40000 ALTER TABLE `feedback` DISABLE KEYS */;
/*!40000 ALTER TABLE `feedback` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `feedback_user_map`
--

DROP TABLE IF EXISTS `feedback_user_map`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `feedback_user_map` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `users` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feedback_user_map`
--

LOCK TABLES `feedback_user_map` WRITE;
/*!40000 ALTER TABLE `feedback_user_map` DISABLE KEYS */;
/*!40000 ALTER TABLE `feedback_user_map` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `groups` (
  `id` mediumint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (1,'admin','Administrator'),(2,'members','General User');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login_attempts`
--

DROP TABLE IF EXISTS `login_attempts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `login_attempts` (
  `id` mediumint unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(16) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_attempts`
--

LOCK TABLES `login_attempts` WRITE;
/*!40000 ALTER TABLE `login_attempts` DISABLE KEYS */;
/*!40000 ALTER TABLE `login_attempts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `version` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (20160421171933);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ohkr_detected_diseases`
--

DROP TABLE IF EXISTS `ohkr_detected_diseases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ohkr_detected_diseases` (
  `id` int NOT NULL AUTO_INCREMENT,
  `form_id` varchar(100) NOT NULL,
  `instance_id` varchar(255) NOT NULL,
  `disease_id` int NOT NULL,
  `location` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ohkr_detected_diseases`
--

LOCK TABLES `ohkr_detected_diseases` WRITE;
/*!40000 ALTER TABLE `ohkr_detected_diseases` DISABLE KEYS */;
/*!40000 ALTER TABLE `ohkr_detected_diseases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ohkr_disease_symptoms`
--

DROP TABLE IF EXISTS `ohkr_disease_symptoms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ohkr_disease_symptoms` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `specie_id` int unsigned NOT NULL,
  `disease_id` int unsigned NOT NULL,
  `symptom_id` int unsigned NOT NULL,
  `importance` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_disease_id` (`disease_id`),
  KEY `fk_symptom_id` (`symptom_id`),
  CONSTRAINT `fk_disease_id` FOREIGN KEY (`disease_id`) REFERENCES `ohkr_diseases` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_symptom_id` FOREIGN KEY (`symptom_id`) REFERENCES `ohkr_symptoms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ohkr_disease_symptoms`
--

LOCK TABLES `ohkr_disease_symptoms` WRITE;
/*!40000 ALTER TABLE `ohkr_disease_symptoms` DISABLE KEYS */;
INSERT INTO `ohkr_disease_symptoms` VALUES (2,1,6,1,20);
/*!40000 ALTER TABLE `ohkr_disease_symptoms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ohkr_diseases`
--

DROP TABLE IF EXISTS `ohkr_diseases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ohkr_diseases` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `species` text,
  `description` text NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ohkr_diseases`
--

LOCK TABLES `ohkr_diseases` WRITE;
/*!40000 ALTER TABLE `ohkr_diseases` DISABLE KEYS */;
INSERT INTO `ohkr_diseases` VALUES (6,'tets','1','<p>tets</p>\r\n','0000-00-00 00:00:00',NULL);
/*!40000 ALTER TABLE `ohkr_diseases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ohkr_faq`
--

DROP TABLE IF EXISTS `ohkr_faq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ohkr_faq` (
  `id` int NOT NULL AUTO_INCREMENT,
  `disease_id` varchar(45) NOT NULL,
  `question` text,
  `answer` text,
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ohkr_faq`
--

LOCK TABLES `ohkr_faq` WRITE;
/*!40000 ALTER TABLE `ohkr_faq` DISABLE KEYS */;
/*!40000 ALTER TABLE `ohkr_faq` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ohkr_response_sms`
--

DROP TABLE IF EXISTS `ohkr_response_sms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ohkr_response_sms` (
  `id` int NOT NULL AUTO_INCREMENT,
  `disease_id` int NOT NULL,
  `group_id` mediumint NOT NULL,
  `message` text,
  `type` enum('TEXT','IMAGE') DEFAULT NULL,
  `media_url` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `modified_by` int DEFAULT NULL,
  `status` enum('Enabled','Disabled') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ohkr_response_sms`
--

LOCK TABLES `ohkr_response_sms` WRITE;
/*!40000 ALTER TABLE `ohkr_response_sms` DISABLE KEYS */;
/*!40000 ALTER TABLE `ohkr_response_sms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ohkr_sent_sms`
--

DROP TABLE IF EXISTS `ohkr_sent_sms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ohkr_sent_sms` (
  `id` int NOT NULL AUTO_INCREMENT,
  `response_msg_id` int NOT NULL,
  `phone` varchar(25) NOT NULL,
  `sent_at` datetime DEFAULT NULL,
  `delivered_at` datetime DEFAULT NULL,
  `status` enum('PENDING','SENT','DELIVERED','REJECTED') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ohkr_sent_sms`
--

LOCK TABLES `ohkr_sent_sms` WRITE;
/*!40000 ALTER TABLE `ohkr_sent_sms` DISABLE KEYS */;
/*!40000 ALTER TABLE `ohkr_sent_sms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ohkr_species`
--

DROP TABLE IF EXISTS `ohkr_species`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ohkr_species` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ohkr_species`
--

LOCK TABLES `ohkr_species` WRITE;
/*!40000 ALTER TABLE `ohkr_species` DISABLE KEYS */;
INSERT INTO `ohkr_species` VALUES (1,'Binadamu'),(4,'Mbuzi'),(5,'Ng\'ombe');
/*!40000 ALTER TABLE `ohkr_species` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ohkr_symptoms`
--

DROP TABLE IF EXISTS `ohkr_symptoms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ohkr_symptoms` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ohkr_symptoms`
--

LOCK TABLES `ohkr_symptoms` WRITE;
/*!40000 ALTER TABLE `ohkr_symptoms` DISABLE KEYS */;
INSERT INTO `ohkr_symptoms` VALUES (1,'Kuvimba tezi','A01','<p>lksdlvks</p>\r\n');
/*!40000 ALTER TABLE `ohkr_symptoms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perms_class`
--

DROP TABLE IF EXISTS `perms_class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `perms_class` (
  `id` int NOT NULL AUTO_INCREMENT,
  `label` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `class` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `sequence` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perms_class`
--

LOCK TABLES `perms_class` WRITE;
/*!40000 ALTER TABLE `perms_class` DISABLE KEYS */;
/*!40000 ALTER TABLE `perms_class` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perms_groups`
--

DROP TABLE IF EXISTS `perms_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `perms_groups` (
  `id` int NOT NULL AUTO_INCREMENT,
  `group_id` int NOT NULL,
  `classes` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `perms` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perms_groups`
--

LOCK TABLES `perms_groups` WRITE;
/*!40000 ALTER TABLE `perms_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `perms_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perms_methods`
--

DROP TABLE IF EXISTS `perms_methods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `perms_methods` (
  `id` int NOT NULL AUTO_INCREMENT,
  `class_id` int NOT NULL,
  `label` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `method` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perms_methods`
--

LOCK TABLES `perms_methods` WRITE;
/*!40000 ALTER TABLE `perms_methods` DISABLE KEYS */;
/*!40000 ALTER TABLE `perms_methods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_groups`
--

DROP TABLE IF EXISTS `project_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `project_groups` (
  `id` int NOT NULL AUTO_INCREMENT,
  `project_id` int DEFAULT NULL,
  `group_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_groups`
--

LOCK TABLES `project_groups` WRITE;
/*!40000 ALTER TABLE `project_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `project_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `projects` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `code` varchar(25) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `group_id` int DEFAULT NULL,
  `perms` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `submission_form`
--

DROP TABLE IF EXISTS `submission_form`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `submission_form` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `device_id` varchar(100) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `submitted_on` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `file_name` (`file_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `submission_form`
--

LOCK TABLES `submission_form` WRITE;
/*!40000 ALTER TABLE `submission_form` DISABLE KEYS */;
/*!40000 ALTER TABLE `submission_form` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `submission_forms`
--

DROP TABLE IF EXISTS `submission_forms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `submission_forms` (
  `id` int NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) NOT NULL,
  `device_id` varchar(100) DEFAULT NULL,
  `status` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `submission_forms`
--

LOCK TABLES `submission_forms` WRITE;
/*!40000 ALTER TABLE `submission_forms` DISABLE KEYS */;
/*!40000 ALTER TABLE `submission_forms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` mediumint unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(16) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(80) NOT NULL,
  `digest_password` varchar(255) NOT NULL,
  `salt` varchar(40) NOT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int unsigned NOT NULL,
  `last_login` int unsigned DEFAULT NULL,
  `active` tinyint unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `country_code` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'127.0.0.1','admin','$2y$08$3Bq1BvfiMjVXGD4jIvhrjOnowYmOrPTxHs5GMrKWwAWCuPxJ9vmi.','7dd95c462a5758425177c94c8df7757d','','admin@sacids.org','b002219ba3dc3ef7bf0aba620b0ec597db215cb6',NULL,NULL,NULL,1268889823,1617229591,1,'Admin','Demo','SACIDS','255732931717',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_groups`
--

DROP TABLE IF EXISTS `users_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users_groups` (
  `id` mediumint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint unsigned NOT NULL,
  `group_id` mediumint unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_groups`
--

LOCK TABLES `users_groups` WRITE;
/*!40000 ALTER TABLE `users_groups` DISABLE KEYS */;
INSERT INTO `users_groups` VALUES (5,1,1),(6,1,2);
/*!40000 ALTER TABLE `users_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `whatsapp`
--

DROP TABLE IF EXISTS `whatsapp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `whatsapp` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date_sent_received` datetime NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `whatsapp`
--

LOCK TABLES `whatsapp` WRITE;
/*!40000 ALTER TABLE `whatsapp` DISABLE KEYS */;
/*!40000 ALTER TABLE `whatsapp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `xform_config`
--

DROP TABLE IF EXISTS `xform_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `xform_config` (
  `id` int NOT NULL AUTO_INCREMENT,
  `xform_id` int DEFAULT NULL,
  `push` int DEFAULT NULL,
  `has_feedback` int DEFAULT NULL,
  `has_ohkr` int DEFAULT NULL,
  `has_map` int DEFAULT NULL,
  `has_charts` int DEFAULT NULL,
  `allow_dhis` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xform_config`
--

LOCK TABLES `xform_config` WRITE;
/*!40000 ALTER TABLE `xform_config` DISABLE KEYS */;
/*!40000 ALTER TABLE `xform_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `xform_fieldname_map`
--

DROP TABLE IF EXISTS `xform_fieldname_map`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `xform_fieldname_map` (
  `id` int NOT NULL AUTO_INCREMENT,
  `xform_id` int NOT NULL,
  `table_name` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `col_name` text,
  `field_name` text,
  `field_label` text,
  `hide` int DEFAULT NULL,
  `field_type` varchar(50) DEFAULT NULL,
  `chart_use` int DEFAULT NULL,
  `allow_dhis` int DEFAULT NULL,
  `dhis_data_element` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xform_fieldname_map`
--

LOCK TABLES `xform_fieldname_map` WRITE;
/*!40000 ALTER TABLE `xform_fieldname_map` DISABLE KEYS */;
/*!40000 ALTER TABLE `xform_fieldname_map` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `xforms`
--

DROP TABLE IF EXISTS `xforms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `xforms` (
  `id` int NOT NULL AUTO_INCREMENT,
  `form_id` varchar(255) NOT NULL,
  `jr_form_id` varchar(255) DEFAULT NULL,
  `project_id` int NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `filename` varchar(255) DEFAULT NULL,
  `access` varchar(10) DEFAULT NULL,
  `status` varchar(10) NOT NULL,
  `push` int DEFAULT NULL,
  `perms` varchar(255) DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `form_type` varchar(25) DEFAULT 'XML',
  `has_symptoms_field` int DEFAULT NULL,
  `has_specie_type_field` int DEFAULT NULL,
  `allow_dhis` int DEFAULT '0',
  `dhis_data_set` varchar(255) DEFAULT NULL,
  `org_unit_id` varchar(255) DEFAULT NULL,
  `period_type` varchar(255) DEFAULT NULL,
  `last_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`,`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xforms`
--

LOCK TABLES `xforms` WRITE;
/*!40000 ALTER TABLE `xforms` DISABLE KEYS */;
/*!40000 ALTER TABLE `xforms` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-04-01  4:40:37
