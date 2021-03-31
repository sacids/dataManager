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
INSERT INTO `ci_sessions` VALUES ('0eh4q9pdsf8er955vfjkvqapg4c5v8um','::1',1615596339,_binary '__ci_last_regenerate|i:1615596339;'),('1f62tr8plifg82tb9899n9ob8ie9tg57','::1',1615465334,_binary '__ci_last_regenerate|i:1615465334;'),('1ohffmrt3df6c03e0rddc5toik5v3peb','::1',1614082470,_binary '__ci_last_regenerate|i:1614082470;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1613567997\";projects|a:1:{i:0;O:8:\"stdClass\":8:{s:2:\"id\";s:1:\"1\";s:5:\"title\";s:17:\"Projecte de Congo\";s:11:\"description\";s:21:\"Project de Mozambique\";s:4:\"code\";N;s:10:\"created_at\";s:19:\"2021-02-23 15:13:09\";s:10:\"created_by\";s:1:\"1\";s:8:\"group_id\";N;s:5:\"perms\";N;}}'),('1qu5gmj2slfsq4lnv0n2hmenvl1i27q4','::1',1614080553,_binary '__ci_last_regenerate|i:1614080553;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1613567997\";'),('20f9tusoiints83hft73e2vbl3q5h7bh','::1',1615468945,_binary '__ci_last_regenerate|i:1615468932;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1614078496\";message|N;'),('2s7sd3dmlecgkbmd4jv8ll1igmrpsl5a','::1',1615597998,_binary '__ci_last_regenerate|i:1615597998;'),('30suoj84h80g8jjuntpujo43urgcdvdp','::1',1615595360,_binary '__ci_last_regenerate|i:1615595360;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1615554875\";'),('3se2t6me8g37i5g1u6j97e9co6imbkou','::1',1615467955,_binary '__ci_last_regenerate|i:1615467955;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1614078496\";'),('420u5n0kughecctifmjg1gt0enbmf516','::1',1615468260,_binary '__ci_last_regenerate|i:1615468260;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1614078496\";message|N;'),('68ut76pcrrugh9jn6ktffqjlt96jva7t','::1',1615594565,_binary '__ci_last_regenerate|i:1615594565;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1615554875\";'),('6nfip7rk4eftrjm0egft196p9r4oeep4','::1',1615466435,_binary '__ci_last_regenerate|i:1615466435;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1614078496\";'),('7c0phscm5hn4s5ruhv685fejn9ko20b2','::1',1615596128,_binary '__ci_last_regenerate|i:1615596128;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1615554875\";'),('7tirgvo38pgfjpqgpqlbeoca406eho68','::1',1615595807,_binary '__ci_last_regenerate|i:1615595807;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1615554875\";'),('8pgo96vuhc25ptqpdntc34nnq48hqu7t','::1',1615597071,_binary '__ci_last_regenerate|i:1615597071;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1615554875\";'),('9ldh4p08lb6e98anoc4ku8v7bkuumemo','::1',1615597383,_binary '__ci_last_regenerate|i:1615597383;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1615554875\";message|s:84:\"<div class=\"alert alert-success\">Clinical manifestation was added successfully</div>\";__ci_vars|a:1:{s:7:\"message\";s:3:\"old\";}'),('a5els0nd81ji1hqa6vvspa3geb1gdirn','::1',1615596071,_binary '__ci_last_regenerate|i:1615596071;'),('aodjpoqudrbloakvgg0155gsl4ac1lrj','::1',1614081452,_binary '__ci_last_regenerate|i:1614081452;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1613567997\";'),('apvkihf53dvobfsf7qo9sju6r0adn2jd','::1',1614405347,_binary '__ci_last_regenerate|i:1614405347;'),('aqhhjbrvuvoiioqg8h44kirje0df5q7h','::1',1615533380,_binary '__ci_last_regenerate|i:1615533204;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1615465408\";'),('astd90nmk1pnbg730o1mh5pmqb1o32vd','::1',1614082167,_binary '__ci_last_regenerate|i:1614082167;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1613567997\";'),('bf31t9kfifd71rk7th056irqg84li80j','::1',1614081814,_binary '__ci_last_regenerate|i:1614081814;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1613567997\";'),('c06pihsuou7jg5filnnrbjtmdltviin9','::1',1615598904,_binary '__ci_last_regenerate|i:1615598904;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1615554875\";'),('dg4g6i9ist28tuektme0q9dak3mb439g','::1',1615594033,_binary '__ci_last_regenerate|i:1615594033;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1615554875\";'),('elg7nk6pl8hrtv6n9vovf50n50t5klva','::1',1615597948,_binary '__ci_last_regenerate|i:1615597948;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1615554875\";'),('g8njh5pv512lap40losf0mvr4a2kj3h9','::1',1615598904,_binary '__ci_last_regenerate|i:1615598904;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1615554875\";message|s:0:\"\";__ci_vars|a:1:{s:7:\"message\";s:3:\"old\";}'),('h3rn58fe5sajpo3nepn6n2fj8u2pvvtl','::1',1615596272,_binary '__ci_last_regenerate|i:1615596272;'),('hhb4q4e67gepee2cp5o4b5bjjjvhnf54','::1',1615598069,_binary '__ci_last_regenerate|i:1615598069;'),('i2s3fftnumjv01ihu8dlo1hf6ohq73r0','::1',1615597285,_binary '__ci_last_regenerate|i:1615597285;'),('ic5cag4du98aelrqsb9vvn45erj9p1ms','::1',1615598270,_binary '__ci_last_regenerate|i:1615598270;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1615554875\";'),('idmc913l10u7vvm50cvv2tp2oh4f6vj7','::1',1614079550,_binary '__ci_last_regenerate|i:1614079550;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1613567997\";'),('kcac2at034e52h1n1kk4ho7e920o0qe3','::1',1615598042,_binary '__ci_last_regenerate|i:1615598042;'),('l6ie4a1imdea04gpirmgloldh694rctm','::1',1615467044,_binary '__ci_last_regenerate|i:1615467044;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1614078496\";'),('lp87u1gl5u808mdh0bvoe2sobhgpa8a7','::1',1615596304,_binary '__ci_last_regenerate|i:1615596304;'),('lss4dl0sa1qv2euov86gdem2pcmb2mf8','::1',1614079852,_binary '__ci_last_regenerate|i:1614079852;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1613567997\";'),('m2lkqp03ucgjjbjpb0fiajk185qhgq62','::1',1615468932,_binary '__ci_last_regenerate|i:1615468932;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1614078496\";message|N;'),('m6v69g6qi3518f0aeh9br6cd1r8mqm5r','::1',1615598093,_binary '__ci_last_regenerate|i:1615598093;'),('m7607np476atf7jnmnjb073abjm84gq0','::1',1615596334,_binary '__ci_last_regenerate|i:1615596334;'),('moieulk3siit4v31gktdjk9ghvkvbjur','::1',1615466736,_binary '__ci_last_regenerate|i:1615466736;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1614078496\";'),('otinu7vi7qa7pkshu1d27fbn3g36dndp','::1',1615465694,_binary '__ci_last_regenerate|i:1615465694;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1614078496\";'),('pfq3r7k1ad4bs4l7bj9an5bj61tcrjld','::1',1614080242,_binary '__ci_last_regenerate|i:1614080242;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1613567997\";'),('r1qi2hq2d9v0r0v7n12gmeq7qbf3a7d7','::1',1615595036,_binary '__ci_last_regenerate|i:1615595036;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1615554875\";'),('rlr34m7f8kccu712nhr4c5t60drdb6l3','::1',1614079242,_binary '__ci_last_regenerate|i:1614079242;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1613567997\";'),('rp9vrfob53jid5ml2f98vln16lid40qa','::1',1615596294,_binary '__ci_last_regenerate|i:1615596294;'),('tmhmiafp3n11t9p8pi6ncqiqrsseni7m','::1',1615598580,_binary '__ci_last_regenerate|i:1615598580;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1615554875\";'),('u1pvea40l2ffjtkcj92kbn7g446rvetb','::1',1615596078,_binary '__ci_last_regenerate|i:1615596078;'),('ugq854bofg1621km2bvkpe85ru71hfgb','::1',1615598270,_binary '__ci_last_regenerate|i:1615598270;'),('uhdf5195sr134cr5mqirthtnv7fvb61o','::1',1615467490,_binary '__ci_last_regenerate|i:1615467490;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1614078496\";'),('vhpglmeiotqtlrb3aei3psjk5ar7k2b2','::1',1614081134,_binary '__ci_last_regenerate|i:1614081134;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1613567997\";'),('vkt848oe77b6ohe6n6pdjd3qdk4ro1lk','::1',1615596564,_binary '__ci_last_regenerate|i:1615596564;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1615554875\";'),('vo30uqa228iuejr3e1dcld51arct1p9m','::1',1615555008,_binary '__ci_last_regenerate|i:1615554863;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1615533213\";'),('vu2ipmcubdmuijpfu5va0ajd512hcqcc','::1',1614082470,_binary '__ci_last_regenerate|i:1614082470;identity|s:5:\"admin\";username|s:5:\"admin\";email|s:16:\"admin@sacids.org\";user_id|s:1:\"1\";old_last_login|s:10:\"1613567997\";projects|a:1:{i:0;O:8:\"stdClass\":8:{s:2:\"id\";s:1:\"1\";s:5:\"title\";s:17:\"Projecte de Congo\";s:11:\"description\";s:21:\"Project de Mozambique\";s:4:\"code\";N;s:10:\"created_at\";s:19:\"2021-02-23 15:13:09\";s:10:\"created_by\";s:1:\"1\";s:8:\"group_id\";N;s:5:\"perms\";N;}}');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ohkr_disease_symptoms`
--

LOCK TABLES `ohkr_disease_symptoms` WRITE;
/*!40000 ALTER TABLE `ohkr_disease_symptoms` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ohkr_diseases`
--

LOCK TABLES `ohkr_diseases` WRITE;
/*!40000 ALTER TABLE `ohkr_diseases` DISABLE KEYS */;
INSERT INTO `ohkr_diseases` VALUES (1,'COVID-19','1','<p>Lorem ipsum</p>\r\n','0000-00-00 00:00:00',NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ohkr_species`
--

LOCK TABLES `ohkr_species` WRITE;
/*!40000 ALTER TABLE `ohkr_species` DISABLE KEYS */;
INSERT INTO `ohkr_species` VALUES (1,'Binadamu');
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (1,'Projecte de Congo','Project de Mozambique',NULL,'2021-02-23 15:13:09',1,NULL,NULL);
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
INSERT INTO `users` VALUES (1,'127.0.0.1','admin','$2y$08$3Bq1BvfiMjVXGD4jIvhrjOnowYmOrPTxHs5GMrKWwAWCuPxJ9vmi.','7dd95c462a5758425177c94c8df7757d','','admin@sacids.org','',NULL,NULL,NULL,1268889823,1615593718,1,'Admin','Demo','SACIDS','255732931717',NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_groups`
--

LOCK TABLES `users_groups` WRITE;
/*!40000 ALTER TABLE `users_groups` DISABLE KEYS */;
INSERT INTO `users_groups` VALUES (1,1,1),(2,1,2);
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
  `hide` int DEFAULT NULL,
  `field_type` varchar(50) DEFAULT NULL,
  `chart_use` int DEFAULT NULL,
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
  `project_id` int NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `attachment` varchar(255) DEFAULT NULL,
  `access` varchar(10) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
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

-- Dump completed on 2021-03-23  8:55:46
