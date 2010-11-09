-- MySQL dump 10.13  Distrib 5.1.49, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: eventgrouper
-- ------------------------------------------------------
-- Server version	5.1.49-1ubuntu8

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `acos`
--

DROP TABLE IF EXISTS `acos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(10) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=205 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acos`
--

LOCK TABLES `acos` WRITE;
/*!40000 ALTER TABLE `acos` DISABLE KEYS */;
INSERT INTO `acos` VALUES (1,0,'EventGroup',1,NULL,1,2),(171,16,'Event',154,NULL,27,28),(172,16,'Event',155,NULL,29,30),(173,16,'Event',156,NULL,31,32),(174,16,'Event',157,NULL,33,34),(175,16,'EventGroup',18,NULL,35,36),(7,NULL,'EventGroup',7,NULL,3,352),(8,7,'Event',1,NULL,4,5),(9,7,'Event',2,NULL,6,7),(10,7,'Event',3,NULL,8,9),(11,7,'Event',4,NULL,10,11),(12,7,'Event',5,NULL,12,13),(13,7,'Event',6,NULL,14,15),(14,7,'Event',7,NULL,16,17),(15,7,'Event',8,NULL,18,19),(16,7,'Event',9,NULL,20,39),(162,NULL,'EventGroup',11,NULL,355,356),(18,7,'Event',11,NULL,40,41),(19,7,'Event',12,NULL,42,45),(21,7,'Event',14,NULL,46,47),(22,7,'Event',15,NULL,48,49),(23,7,'Event',16,NULL,50,51),(24,7,'Event',17,NULL,52,53),(25,7,'Event',18,NULL,54,55),(26,7,'Event',19,NULL,56,63),(27,7,'Event',20,NULL,64,69),(28,7,'Event',21,NULL,70,71),(29,7,'Event',22,NULL,72,75),(30,7,'Event',23,NULL,76,83),(31,7,'Event',24,NULL,84,99),(32,7,'Event',25,NULL,100,103),(33,7,'Event',26,NULL,104,107),(34,7,'Event',27,NULL,108,113),(35,7,'Event',28,NULL,114,117),(36,7,'Event',29,NULL,118,119),(37,7,'Event',30,NULL,120,121),(38,7,'Event',31,NULL,122,123),(39,7,'Event',32,NULL,124,125),(40,7,'Event',33,NULL,126,127),(41,7,'Event',34,NULL,128,129),(42,7,'Event',35,NULL,130,131),(43,7,'Event',36,NULL,132,133),(44,7,'Event',37,NULL,134,135),(45,7,'Event',38,NULL,136,137),(46,7,'Event',39,NULL,138,139),(47,7,'Event',40,NULL,140,141),(48,7,'Event',41,NULL,142,143),(49,7,'Event',42,NULL,144,145),(50,7,'Event',43,NULL,146,147),(51,7,'Event',44,NULL,148,149),(52,7,'Event',45,NULL,150,151),(53,7,'Event',46,NULL,152,153),(54,7,'Event',47,NULL,154,155),(55,7,'Event',48,NULL,156,157),(56,7,'Event',49,NULL,158,159),(57,7,'Event',50,NULL,160,161),(58,7,'Event',51,NULL,162,163),(59,7,'Event',52,NULL,164,165),(60,7,'Event',53,NULL,166,167),(61,7,'Event',54,NULL,168,169),(62,7,'Event',55,NULL,170,171),(63,7,'Event',56,NULL,172,173),(64,7,'Event',57,NULL,174,175),(65,7,'Event',58,NULL,176,177),(66,7,'Event',59,NULL,178,179),(67,7,'Event',60,NULL,180,181),(68,7,'Event',61,NULL,182,183),(69,7,'Event',62,NULL,184,185),(70,7,'Event',63,NULL,186,187),(71,7,'Event',64,NULL,188,189),(72,7,'Event',65,NULL,190,191),(73,7,'Event',66,NULL,192,193),(74,7,'Event',67,NULL,194,195),(75,7,'Event',68,NULL,196,197),(76,7,'Event',69,NULL,198,199),(77,7,'Event',70,NULL,200,201),(78,7,'Event',71,NULL,202,203),(79,7,'Event',72,NULL,204,205),(80,7,'Event',73,NULL,206,207),(81,7,'Event',74,NULL,208,209),(82,7,'Event',75,NULL,210,211),(83,7,'Event',76,NULL,212,213),(84,7,'Event',77,NULL,214,215),(85,7,'Event',78,NULL,216,217),(86,7,'Event',79,NULL,218,219),(87,7,'Event',80,NULL,220,221),(88,7,'Event',81,NULL,222,223),(89,7,'Event',82,NULL,224,225),(90,7,'Event',83,NULL,226,227),(91,7,'Event',84,NULL,228,229),(92,7,'Event',85,NULL,230,231),(93,7,'Event',86,NULL,232,233),(94,7,'Event',87,NULL,234,235),(95,7,'Event',88,NULL,236,237),(96,7,'Event',89,NULL,238,239),(97,7,'Event',90,NULL,240,241),(98,7,'Event',91,NULL,242,243),(99,7,'Event',92,NULL,244,245),(100,7,'Event',93,NULL,246,247),(101,7,'Event',94,NULL,248,249),(102,7,'Event',95,NULL,250,251),(103,7,'Event',96,NULL,252,253),(104,7,'Event',97,NULL,254,255),(105,7,'Event',98,NULL,256,257),(106,7,'Event',99,NULL,258,259),(107,7,'Event',100,NULL,260,261),(108,7,'Event',101,NULL,262,263),(109,7,'Event',102,NULL,264,265),(110,7,'Event',103,NULL,266,267),(111,7,'Event',104,NULL,268,269),(112,7,'Event',105,NULL,270,271),(113,7,'Event',106,NULL,272,273),(114,7,'Event',107,NULL,274,275),(115,7,'Event',108,NULL,276,277),(116,7,'Event',109,NULL,278,279),(117,7,'Event',110,NULL,280,281),(118,7,'Event',111,NULL,282,283),(119,7,'Event',112,NULL,284,285),(120,7,'Event',113,NULL,286,287),(121,7,'Event',114,NULL,288,289),(122,7,'Event',115,NULL,290,291),(123,7,'Event',116,NULL,292,293),(124,7,'Event',117,NULL,294,295),(125,7,'Event',118,NULL,296,297),(126,7,'Event',119,NULL,298,299),(127,7,'Event',120,NULL,300,301),(128,7,'Event',121,NULL,302,303),(129,7,'Event',122,NULL,304,305),(130,7,'Event',123,NULL,306,307),(131,7,'Event',124,NULL,308,309),(132,7,'Event',125,NULL,310,311),(133,7,'Event',126,NULL,312,313),(134,7,'Event',127,NULL,314,315),(135,7,'Event',128,NULL,316,317),(136,7,'Event',129,NULL,318,319),(137,7,'Event',130,NULL,320,321),(138,7,'Event',131,NULL,322,323),(139,7,'Event',132,NULL,324,325),(140,7,'Event',133,NULL,326,327),(141,7,'Event',134,NULL,328,329),(142,7,'Event',135,NULL,330,331),(143,7,'Event',136,NULL,332,333),(144,7,'Event',137,NULL,334,335),(145,7,'Event',138,NULL,336,337),(146,7,'Event',139,NULL,338,339),(147,7,'Event',140,NULL,340,341),(148,7,'Event',141,NULL,342,343),(149,7,'Event',142,NULL,344,345),(183,NULL,'EventGroup',21,NULL,363,364),(152,7,'EventGroup',8,NULL,346,347),(153,7,'Event',145,NULL,348,349),(154,NULL,'EventGroup',9,NULL,353,354),(155,16,'Event',146,NULL,21,22),(156,16,'Event',147,NULL,23,24),(157,16,'Event',148,NULL,25,26),(182,NULL,'EventGroup',20,NULL,361,362),(181,26,'Event',162,NULL,61,62),(180,26,'Event',161,NULL,59,60),(163,NULL,'EventGroup',12,NULL,357,358),(164,19,'EventGroup',13,NULL,43,44),(179,26,'Event',160,NULL,57,58),(178,NULL,'EventGroup',19,NULL,359,360),(177,7,'Event',159,NULL,350,351),(176,16,'Event',158,NULL,37,38),(184,NULL,'EventGroup',22,NULL,365,366),(185,29,'EventGroup',23,NULL,73,74),(186,30,'Event',163,NULL,77,78),(187,30,'Event',164,NULL,79,80),(188,30,'Event',165,NULL,81,82),(189,NULL,'EventGroup',24,NULL,367,368),(190,31,'EventGroup',25,NULL,85,86),(191,32,'Event',166,NULL,101,102),(192,31,'Event',167,NULL,87,88),(193,31,'Event',169,NULL,89,90),(194,31,'EventGroup',26,NULL,91,92),(195,33,'Event',174,NULL,105,106),(196,31,'Event',175,NULL,93,94),(197,31,'Event',176,NULL,95,96),(198,31,'Event',177,NULL,97,98),(199,NULL,'EventGroup',27,NULL,369,370),(200,34,'EventGroup',28,NULL,109,110),(201,34,'Event',178,NULL,111,112),(202,27,'Event',179,NULL,65,66),(203,27,'Event',180,NULL,67,68),(204,35,'Event',181,NULL,115,116);
/*!40000 ALTER TABLE `acos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aros`
--

DROP TABLE IF EXISTS `aros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aros` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(10) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aros`
--

LOCK TABLES `aros` WRITE;
/*!40000 ALTER TABLE `aros` DISABLE KEYS */;
INSERT INTO `aros` VALUES (1,0,'User',5,NULL,1,16),(2,1,'User',6,NULL,2,3),(3,1,'User',7,NULL,4,5),(4,1,'User',8,NULL,6,7),(5,1,'User',9,NULL,8,9),(6,1,'User',10,NULL,10,11),(7,1,'User',11,NULL,12,13),(8,1,'User',12,NULL,14,15);
/*!40000 ALTER TABLE `aros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aros_acos`
--

DROP TABLE IF EXISTS `aros_acos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aros_acos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `aro_id` int(10) NOT NULL,
  `aco_id` int(10) NOT NULL,
  `_create` varchar(2) NOT NULL DEFAULT '0',
  `_read` varchar(2) NOT NULL DEFAULT '0',
  `_update` varchar(2) NOT NULL DEFAULT '0',
  `_delete` varchar(2) NOT NULL DEFAULT '0',
  `_editperms` varchar(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ARO_ACO_KEY` (`aro_id`,`aco_id`)
) ENGINE=MyISAM AUTO_INCREMENT=94 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aros_acos`
--

LOCK TABLES `aros_acos` WRITE;
/*!40000 ALTER TABLE `aros_acos` DISABLE KEYS */;
INSERT INTO `aros_acos` VALUES (56,6,178,'1','1','1','1','1'),(51,2,175,'1','1','1','1','1'),(52,1,175,'0','1','0','0','0'),(53,5,154,'1','0','0','0','0'),(54,5,176,'1','1','1','1','1'),(55,2,177,'1','1','1','1','1'),(64,2,183,'1','1','1','1','1'),(11,2,7,'1','1','1','1','1'),(12,1,7,'0','1','0','0','0'),(65,1,183,'0','1','0','0','0'),(63,1,182,'0','1','0','0','0'),(15,2,152,'1','1','1','1','1'),(16,1,152,'0','1','0','0','0'),(17,2,153,'1','1','1','1','1'),(18,2,154,'1','1','1','1','1'),(19,1,154,'0','1','0','0','0'),(20,2,155,'1','1','1','1','1'),(21,2,156,'1','1','1','1','1'),(22,2,157,'1','1','1','1','1'),(50,2,174,'1','1','1','1','1'),(47,2,171,'1','1','1','1','1'),(48,2,172,'1','1','1','1','1'),(49,2,173,'1','1','1','1','1'),(29,3,162,'1','1','1','1','1'),(30,1,162,'0','1','0','0','0'),(31,2,162,'1','0','0','0','0'),(32,3,163,'1','1','1','1','1'),(33,1,163,'0','1','0','0','0'),(34,3,164,'1','1','1','1','1'),(35,1,164,'0','1','0','0','0'),(36,2,164,'1','0','0','0','0'),(62,2,182,'1','1','1','1','1'),(61,7,154,'1','0','0','0','0'),(60,6,181,'1','1','1','1','1'),(59,6,180,'1','1','1','1','1'),(58,6,179,'1','1','1','1','1'),(57,1,178,'0','1','0','0','0'),(66,2,184,'1','1','1','1','1'),(67,1,184,'0','1','0','0','0'),(68,2,185,'1','1','1','1','1'),(69,1,185,'0','1','0','0','0'),(70,2,186,'1','1','1','1','1'),(71,2,187,'1','1','1','1','1'),(72,2,188,'1','1','1','1','1'),(73,8,189,'1','1','1','1','1'),(74,1,189,'0','1','0','0','0'),(75,8,190,'1','1','1','1','1'),(76,1,190,'0','1','0','0','0'),(77,8,191,'1','1','1','1','1'),(78,8,192,'1','1','1','1','1'),(79,8,193,'1','1','1','1','1'),(80,8,194,'1','1','1','1','1'),(81,1,194,'0','1','0','0','0'),(82,8,195,'1','1','1','1','1'),(83,8,196,'1','1','1','1','1'),(84,8,197,'1','1','1','1','1'),(85,8,198,'1','1','1','1','1'),(86,2,199,'1','1','1','1','1'),(87,1,199,'0','1','0','0','0'),(88,2,200,'1','1','1','1','1'),(89,1,200,'0','1','0','0','0'),(90,2,201,'1','1','1','1','1'),(91,2,202,'1','1','1','1','1'),(92,2,203,'1','1','1','1','1'),(93,2,204,'1','1','1','1','1');
/*!40000 ALTER TABLE `aros_acos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category_choices`
--

DROP TABLE IF EXISTS `category_choices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category_choices` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `event_group_id` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=74 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_choices`
--

LOCK TABLES `category_choices` WRITE;
/*!40000 ALTER TABLE `category_choices` DISABLE KEYS */;
INSERT INTO `category_choices` VALUES (38,' Information',19),(37,' Tours',19),(3,'Food\r',7),(4,'Fun',7),(5,'Food',9),(6,' Fun',9),(7,' noobs',9),(12,'Food',11),(13,' Tours',11),(14,' Information',11),(15,'Food',12),(16,' Tours',12),(17,' Information',12),(36,'Food',19),(67,'   Tours',20),(66,'  Food',20),(65,'   Information',20),(49,'  Tours',21),(48,'Food',21),(50,'  Information',21),(54,'Food',22),(55,' Tours',22),(56,' Information',22),(57,'Food',24),(58,' Tours',24),(59,' Information',24),(71,'Othertag',27),(70,'Information',27),(69,'Tours',27),(68,'Food',27),(72,'with space',27),(73,'lots of space',27);
/*!40000 ALTER TABLE `category_choices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category_choices_events`
--

DROP TABLE IF EXISTS `category_choices_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category_choices_events` (
  `category_choice_id` int(10) NOT NULL,
  `event_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_choices_events`
--

LOCK TABLES `category_choices_events` WRITE;
/*!40000 ALTER TABLE `category_choices_events` DISABLE KEYS */;
INSERT INTO `category_choices_events` VALUES (3,1),(62,178),(60,178),(4,1);
/*!40000 ALTER TABLE `category_choices_events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_groups`
--

DROP TABLE IF EXISTS `event_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event_groups` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` text,
  `description` text,
  `photo_url` text,
  `parent_id` int(10) DEFAULT NULL COMMENT 'aka the parent group. 0 means there is no parent.',
  `lft` int(10) NOT NULL,
  `rght` int(10) NOT NULL,
  `path` text NOT NULL,
  `location` text,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_groups`
--

LOCK TABLES `event_groups` WRITE;
/*!40000 ALTER TABLE `event_groups` DISABLE KEYS */;
INSERT INTO `event_groups` VALUES (1,NULL,NULL,NULL,NULL,1,2,'',NULL,NULL,NULL),(22,'woahshit','',NULL,0,39,42,'woahshit',NULL,42.3593842797384,-71.1044383049011),(23,'under','',NULL,22,40,41,'woahshit/under',NULL,42.4112905190282,-71.7338562011719),(21,'and this','',NULL,NULL,37,38,'and-this',NULL,42.3591147308098,-71.0951256752014),(7,'CPW 10','','',0,19,22,'cpw10','',NULL,NULL),(8,'coolio','',NULL,7,20,21,'cpw10/coolio','',NULL,NULL),(9,'sweetshit','blah',NULL,0,23,26,'laugh','',NULL,NULL),(11,'otherthing','',NULL,0,27,28,'yessir',NULL,NULL,NULL),(12,'chiil','',NULL,0,29,32,'dude',NULL,NULL,NULL),(18,'nice','',NULL,9,24,25,'laugh/nice',NULL,NULL,NULL),(19,'badass','',NULL,0,33,34,'bada',NULL,NULL,NULL),(20,'newtest','',NULL,NULL,35,36,'newtest','stanford',37.424106,-122.166076),(24,'way cool','des',NULL,0,43,48,'way-cool',NULL,42.358987883855,-71.0967993736267),(25,'under here','des',NULL,24,44,45,'way-cool/under-here',NULL,42.358987883855,-71.0967993736267),(26,'group underneath','',NULL,24,46,47,'way-cool/group-underneath','stanford',37.424106,-122.166076),(27,'check cats','',NULL,NULL,49,52,'check-cats','',NULL,NULL),(28,'check for cats','',NULL,27,50,51,'check-cats/check-for-cats','',NULL,NULL);
/*!40000 ALTER TABLE `event_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_groups_users`
--

DROP TABLE IF EXISTS `event_groups_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event_groups_users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `event_group_id` int(10) NOT NULL,
  `acl_num` int(2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uni` (`user_id`,`event_group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_groups_users`
--

LOCK TABLES `event_groups_users` WRITE;
/*!40000 ALTER TABLE `event_groups_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `event_groups_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `events` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` text COLLATE latin1_spanish_ci NOT NULL,
  `description` text COLLATE latin1_spanish_ci,
  `event_group_id` int(10) NOT NULL,
  `photo_url` text COLLATE latin1_spanish_ci,
  `location` text COLLATE latin1_spanish_ci,
  `time_start` datetime NOT NULL,
  `duration` int(10) NOT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `user_id` int(10) NOT NULL,
  `status` enum('unconfirmed','confirmed','hidden','rejected') COLLATE latin1_spanish_ci NOT NULL DEFAULT 'unconfirmed',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `searcher` (`title`,`description`)
) ENGINE=MyISAM AUTO_INCREMENT=182 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` VALUES (1,'CPW Registration and Help Desk','',7,NULL,'Student Center Floor La Sala de Puerto Rico','2010-11-04 07:00:00',60,NULL,NULL,6,'hidden'),(2,'Next House Hospitality Lounge','Nothing says &quot;welcome&quot; like an endless supply of snacks, cookies, and juice! Enjoy Next House\'s relaxed and friendly atmosphere while basking in the glory of food. Start CPW off right - stop by Next\'s Hospitality Lounge!',7,NULL,'Next House (W71), Lobby','2010-04-08 09:00:00',180,NULL,NULL,6,'hidden'),(3,'UROP Tours Sign-up','See first-hand the accessible and cutting edge research opportunities available to MIT undergraduates! A complete list of tour descriptions will be available at registration. Tour sign-up required to participate. Limit one tour per student; first-come, first-served. For general information about the UROP program, come to the UROP discussion panel Friday, April 9th at 12pm in Kresge Auditorium (W16).',7,NULL,'Sign up in the Student Center (W20), 2nd Floor, La Sala de Puerto Rico','2010-04-08 09:00:00',360,NULL,NULL,6,'hidden'),(4,'Financial Aid Appointments','For questions regarding aid, loans, student employment, and/or billing, please visit the Student Financial Services (SFS) desk in La Sala de Puerto Rico. General questions are answered immediately or you will be advised to schedule a 20-minute appointment. Scheduled appointments are limited and held in 11-120.',7,NULL,'Sign up in the Student Center, (W20), 2nd Floor, La Sala de Puerto Rico','2010-04-08 09:00:00',480,NULL,NULL,6,'hidden'),(5,'Parent Hospitality Lounge','Grab a cup of coffee or tea and chat with current MIT parents as well as other parents of MIT prefrosh. Also, learn about the MIT Parents Association and the Parent Connector Network from current volunteers and staff.',7,NULL,'Student Center (W20), 2nd Floor, La Sala de Puerto Rico','2010-04-08 09:00:00',480,NULL,NULL,6,'hidden'),(6,'Hillel Open House','Stop by at any time to the Hillel Office (basement of W11) to meet the Hillel Staff. While you\'re here, you can buy your very own MIT Hillel t-shirt (in Hebrew).',7,NULL,'Religious Activities Center (W11), Basement','2010-04-08 09:00:00',480,NULL,NULL,6,'hidden'),(7,'Chocolate City Jukebox','Come join us for an opportunity to listen to hip-hop, r&amp;b, reggae, and dancehall provided by the Brothers of Chocolate City. Stop by to hang out, listen to hot music, and introduce yourself to a chill atmosphere.',7,NULL,'Front Steps of Student Center (W20)','2010-04-08 09:00:00',480,NULL,NULL,6,'hidden'),(8,'New House Welcome Lounge','Come join New House as we welcome you to MIT. We will have snacks and residents around all day so stop by and say hi!',7,NULL,'New House (W70)','2010-04-08 09:00:00',480,NULL,NULL,6,'hidden'),(9,'Classes','Many MIT classes open their doors to prefrosh during CPW. See your registration packet for the list sorted by date, time and subject. Before sitting in on a class that is not on the list, you <strong>must</strong> receive permission from the department in advance; some classes will be holding exams or do not have space to accommodate visitors.',7,NULL,'Various Locations','2010-04-08 09:00:00',480,NULL,NULL,6,'hidden'),(10,'Baptist Campus Ministry Open House','Come grab a bite of brunch with the Baptist Chaplain, members of Baptist Campus Ministry (BCM) and Baptist Student Fellowship. Learn about the MIT Christian scene and local churches in the area.',7,NULL,'Religious Activities Center (W11), Community Room','2010-04-08 09:59:00',121,NULL,NULL,6,'hidden'),(11,'Campus Tour','Departing on the hour and the half hour from Wiesner Student Art Gallery.',7,NULL,'Student Center (W20), 2nd Floor','2010-04-08 10:00:00',60,NULL,NULL,6,'hidden'),(12,'Campus Tour','Departing on the hour and the half hour from Wiesner Student Art Gallery.',7,NULL,'Student Center (W20), 2nd Floor','2010-04-08 10:30:00',60,NULL,NULL,6,'hidden'),(13,'Campus Tour','Departing on the hour and the half hour from Wiesner Student Art Gallery.',7,NULL,'Student Center (W20), 2nd Floor','2010-04-08 11:00:00',60,NULL,NULL,6,'hidden'),(14,'Campus Tour','Departing on the hour and the half hour from Wiesner Student Art Gallery.',7,NULL,'Student Center (W20), 2nd Floor','2010-04-08 11:30:00',60,NULL,NULL,6,'confirmed'),(15,'Lunch at Kappa Sigma','Just got to MIT? Stop by our house on campus for some lunch.',7,NULL,'Kappa Sigma, 407 Memorial Dr., Cambridge','2010-04-08 11:30:00',150,NULL,NULL,6,'confirmed'),(16,'Campus Tour','Departing on the hour and the half hour from Wiesner Student Art Gallery.',7,NULL,'Student Center (W20), 2nd Floor','2010-04-08 12:00:00',60,NULL,NULL,6,'confirmed'),(17,'Lunch at DKE!','Tired from activities? Just hungry? Enjoy a fresh, warm meal cooked by our chef Tom and find out why his dishes like Clam Chowda were rated the best by the \"Boston Globe.\"',7,NULL,'Delta Kappa Epsilon, 403 Memorial Dr., Cambridge','2010-04-08 12:00:00',60,NULL,NULL,6,'hidden'),(18,'Chillin\' at the House','Come hang out with the brothers of Alpha Delta Phi and see how Greek life differs here at MIT than from anywhere in the world! We\'re across the street and to the left from Random Hall (NW61).',7,NULL,'Alpha Delta Phi, 351 Massachusetts Ave., Cambridge','2010-04-08 12:00:00',300,NULL,NULL,6,'hidden'),(19,'Video Games at ADP','Come hang out with the brothers of Alpha Delta Phi and see how Greek life differs at MIT than from anywhere in the world! Alpha Delta Phi is across the street and to the left from Random Hall (NW61).',7,NULL,'Alpha Delta Phi, 351 Massachusetts Ave., Cambridge','2010-04-08 12:00:00',300,NULL,NULL,6,'confirmed'),(20,'Campus Tour','Departing on the hour and the half hour from Wiesner Student Art Gallery.',7,NULL,'Student Center (W20), 2nd Floor','2010-04-08 12:30:00',60,NULL,NULL,6,'confirmed'),(21,'Lunch','Come see how the brothers of Nu Delta make the best of a lunch break. There will be music and jokes to go around.',7,NULL,'Student Center Steps (W20)','2010-04-08 12:59:00',121,NULL,NULL,6,'confirmed'),(22,'BBQ at TDC','It\'s like summer, only colder!',7,NULL,'Theta Delta Chi, 372 Memorial Dr., Cambridge','2010-04-08 13:00:00',60,NULL,NULL,6,'confirmed'),(23,'Campus Tour','Departing on the hour and the half hour from Wiesner Student Art Gallery.',7,NULL,'Student Center (W20), 2nd Floor','2010-04-08 13:00:00',60,NULL,NULL,6,'confirmed'),(24,'Ocean Engineering Open House','Discover the exciting possibilities of course 2-OE. Learn about the curriculum and labs, plus meet our faculty that lead the field in underwater robotics, ocean modeling, ship design, acoustic sensing, ocean energy and more. 2-OE students will be answering questions about their academics and post-MIT careers.',7,NULL,'Room 3-270','2010-04-08 13:00:00',60,NULL,NULL,6,'confirmed'),(25,'HEY YOU GUYS!','Come meet the dorm and its residents. Get a tour of our dorm, ask some questions about what to do this weekend, or just hang out with some cool people.',7,NULL,'Burton-Conner House (W51), TV Lounge','2010-04-08 13:00:00',180,NULL,NULL,6,'confirmed'),(26,'Campus Tour','Departing on the hour and the half hour from Wiesner Student Art Gallery.',7,NULL,'Student Center (W20), 2nd Floor','2010-04-08 13:30:00',60,NULL,NULL,6,'unconfirmed'),(27,'Back to Kindergarten','Nervous about college? Relax and return to your kindergarten days, where your biggest worry was your favorite crayon breaking. Come finger paint, play with playdoh, and enjoy goldfish and juice boxes with current students and other prefrosh!',7,NULL,'Next House (W71), Dining','2010-04-08 13:30:00',120,NULL,NULL,6,'unconfirmed'),(28,'Campus Tour','Departing on the hour and the half hour from Wiesner Student Art Gallery.',7,NULL,'Student Center (W20), 2nd Floor','2010-04-08 14:00:00',60,NULL,NULL,6,'unconfirmed'),(29,'Residential Life Information Session','Karen Nilsson, Senior Associate Dean for Residential Life, will lead a discussion covering life in residences, residential support in the halls, activities, dining options, the freshmen housing assignment process and more. We\'ll equip you with the answers to your most important questions pertaining to your student\'s residential experience at MIT.',7,NULL,'Kresge Auditorium (W16)','2010-04-08 14:00:00',60,NULL,NULL,6,'unconfirmed'),(30,'Cookies and Christianity','Do you have questions about Christianity at MIT? Need information about Christian student groups and activities during CPW and next fall? Just want a place to relax and have some cookies? Drop by!',7,NULL,'Religious Activities Center (W11), Christian Fellowship Lounge in Basement','2010-04-08 14:00:00',120,NULL,NULL,6,'unconfirmed'),(31,'Rock Band!','Come play Rock Band at Eran Egozy\'s (founder of Harmonix) old house! Come play on our massive 80Ã“ projector screen with surround sound!',7,NULL,'Alpha Delta Phi, 351 Massachusetts Ave., Cambridge','2010-04-08 14:00:00',120,NULL,NULL,6,'unconfirmed'),(32,'Academics and Life: How to Balance','Interested in finding out about classes, UROPs, jobs, opportunities and teams at MIT? Come ask our brothers how they balance school and sports, attend a class with us, or inquire about anything that\'s on your mind.',7,NULL,'Delta Kappa Epsilon, 403 Memorial Dr., Cambridge','2010-04-08 14:00:00',180,NULL,NULL,6,'unconfirmed'),(33,'CPW Prefrosh Lounge','Looking for a place to relax between events? Have a question only an MIT student can answer? Just drop by!',7,NULL,'Student Center (W20), 3rd Floor, Coffeehouse','2010-04-08 14:00:00',360,NULL,NULL,6,'unconfirmed'),(34,'Campus Tour','Departing on the hour and the half hour from Wiesner Student Art Gallery.',7,NULL,'Student Center (W20), 2nd Floor','2010-04-08 14:30:00',60,NULL,NULL,6,'unconfirmed'),(35,'Grillin\' on Kresge','The brothers of Beta Theta Pi are grilling on campus.  Come grab something to eat - we\'ll have burgers, veggie burgers, and over 20 of the hottest hot sauces.',7,NULL,'Kresge BBQ Pits (behind Kresge Auditorium, W16)','2010-04-08 14:30:00',180,NULL,NULL,6,'unconfirmed'),(36,'Campus Tour','Departing on the hour and the half hour from Wiesner Student Art Gallery.',7,NULL,'Student Center (W20), 2nd Floor','2010-04-08 15:00:00',60,NULL,NULL,6,'unconfirmed'),(37,'Opportunities for Aerospace Engineers in the Future of Space Explorations','Dr. Jeffrey Hoffman, a former NASA astronaut, flew five shuttle missions and was inducted into the U.S. Astronaut Hall of Fame in 2007. Hoffman is now a Professor of the Practice in the Department of Aeronautics and Astronautics but still has close ties with NASA. Among courses taught by Prof. Hoffman is the popular project-based course, 16.00 - Introduction of Aerospace and Design, which meets in the spring and is open to freshmen. Refreshments will be served.',7,NULL,'Room 4-163','2010-04-08 15:00:00',60,NULL,NULL,6,'unconfirmed'),(38,'The Urban Campus - Safety and Security','What does MIT do to ensure the safety of its students both on and off campus? How does MIT integrate into the urban landscape of Boston and Cambridge? John DiFava, Chief of MIT Police, and others will address these issues and answer your questions.',7,NULL,'Kresge Auditorium (W16)','2010-04-08 15:00:00',60,NULL,NULL,6,'unconfirmed'),(39,'CPW Prefrosh Lounge','Looking for a place to relax between events? Have a question only an MIT student can answer? Just drop by!',7,NULL,'Student Center (W20), 3rd Floor, Coffeehouse','2010-04-08 15:00:00',300,NULL,NULL,6,'unconfirmed'),(40,'Courtyard Antics','Hang out in our courtyard! Get your hair dyed, build wooden contraptions, and get classy tours of East Campus.',7,NULL,'East Campus Courtyard (between Buildings 62 and 64)','2010-04-08 15:00:00',360,NULL,NULL,6,'unconfirmed'),(41,'Truffles!','Come to Random Hall and make your own delicious truffles! Dark chocolate with raspberry, milk chocolate with lemon and ginger, white chocolate with wasabi (for the brave of heart). Are your taste buds up to the challenge?',7,NULL,'Random Hall (NW61)','2010-04-08 15:17:00',60,NULL,NULL,6,'unconfirmed'),(42,'Campus Tour','Departing on the hour and the half hour from Wiesner Student Art Gallery.',7,NULL,'Student Center (W20), 2nd Floor','2010-04-08 15:30:00',60,NULL,NULL,6,'unconfirmed'),(43,'Chemical Engineering Open House ','Chemical engineering is about transformation. It\'s about gaining fundamental knowledge about a substance, then using that knowledge to synthesize a solution to an important medical, mechanical, or societal need. MIT offers the largest chem-e program in the nation. Come tour our labs and learn from faculty &amp; students about how we\'re changing the world! ',7,NULL,'Room 66-201','2010-04-08 15:30:00',90,NULL,NULL,6,'unconfirmed'),(44,'Next House Dorm Tours','Come on a tour of one of the friendliest dorms on campus! Our eight wings all have their own subcultures, joining together to form the warm community that is Next House.',7,NULL,'leaves from Next House (W71), Lobby','2010-04-08 15:30:00',120,NULL,NULL,6,'unconfirmed'),(45,'Campus Tour','Departing on the hour and the half hour from Wiesner Student Art Gallery.',7,NULL,'Student Center (W20), 2nd Floor','2010-04-08 16:00:00',60,NULL,NULL,6,'unconfirmed'),(46,'Introduction to OME and Interphase','The staff of the Office of Minority Education (OME), along with past Interphase participants, will provide an overview of the office\'s programs and services, and discuss the benefits of attending the 2010 Interphase Program. Parents are encouraged to attend. ',7,NULL,'Room 32-155 (Stata Center, 1st Floor)','2010-04-08 16:00:00',60,NULL,NULL,6,'unconfirmed'),(47,'Marvelous Molecules in Play','A selection of live chemical reactions followed by explanation, with Dr. John Dolhun, Department of Chemistry. Includes audience participation. ',7,NULL,'Room 4-370','2010-04-08 16:00:00',60,NULL,NULL,6,'unconfirmed'),(48,'Ashdown House Dorm Tour','Meet at the Student Center (W20) to walk over to New Ashdown (NW35). See for yourself what life is like in the newest dorm on campus! Then come chill with us, and have your questions about MIT answered by Phoenix Group members. ',7,NULL,'Meet at Student Center (W20)','2010-04-08 16:00:00',60,NULL,NULL,6,'unconfirmed'),(49,'Student Opportunities to Go Global','This panel of administrators, faculty, and students will help you understand the range of international opportunities available to students to go global and the resources they can utilize to pursue their interests. The panel will also answer questions about specific programs, scheduling an experience abroad, safety and funding.<br>',7,NULL,'Room 26-100','2010-04-08 16:00:00',60,NULL,NULL,6,'unconfirmed'),(50,'Ice Cream Social','You LOVE ice cream. You cannot resist the ice cream. To resist is hopeless. Your existence is meaningless without ice cream.',7,NULL,'Burton-Conner House (W51), Barbecue Pits','2010-04-08 16:00:00',90,NULL,NULL,6,'unconfirmed'),(51,'Ultimate Frisbee','Come relax and play a friendly game of ultimate with the brothers and female friends of Kappa Sigma. We\'ll meet up at our house at 4pm and head out from there.',7,NULL,'Kappa Sigma, 407 Memorial Dr., Cambridge','2010-04-08 16:00:00',120,NULL,NULL,6,'unconfirmed'),(52,'Faire La Cuisine avec La Maison Francaise!','Help La Maison Francaise prepare a scrumptious meal from scratch. Cooking at French House is always fun whether we\'re making pizza or coq au vin. Stick around until dinnertime, quand nous mangerons. No kitchen experience required!',7,NULL,'New House (W70), House 6 (French House), 5th floor kitchen','2010-04-08 16:00:00',135,NULL,NULL,6,'unconfirmed'),(53,'CPW Prefrosh Lounge','Looking for a place to relax between events? Have a question only an MIT student can answer? Just drop by!',7,NULL,'Student Center (W20), 3rd Floor, Coffeehouse','2010-04-08 16:00:00',240,NULL,NULL,6,'unconfirmed'),(54,'Chainmail','Learn how to protect yourselves and your loved ones against impending doom! Next time you find yourself in a medieval pitched battle, you\'ll be all set. Meet us in Lobby 7 to catch our Big Silver Van to Epsilon Theta.',7,NULL,'Epsilon Theta, 259 Saint Paul St., Brookline','2010-04-08 16:15:00',60,NULL,NULL,6,'unconfirmed'),(55,'Bubble Wrap Room','Bubble wrap: it goes pop. We have an entire room of it. Come bounce off the walls!',7,NULL,'Random Hall (NW61)','2010-04-08 16:17:00',60,NULL,NULL,6,'unconfirmed'),(56,'Welcome BBQ at Alpha Epsilon Pi','Meat is what\'s for dinner in Back Bay Boston. Come enjoy good food, good music, great people, and a beautiful view of Cambridge and the Charles River... Call us for ride: 847-902-0863',7,NULL,'Alpha Epsilon Pi, 155 Bay State Rd., Boston','2010-04-08 16:30:00',180,NULL,NULL,6,'unconfirmed'),(57,'Community Sing!','Singing in the shower just not cutting it? Come sing some of the most famous and best-loved pieces from the choral tradition with the MIT Concert Choir - MIT\'s largest vocal performing group! Stop by for a few minutes or stay the whole time!',7,NULL,'Lobby 10','2010-04-08 17:00:00',60,NULL,NULL,6,'unconfirmed'),(58,'Dinner and Cafe Thursday','Come view our signature literary event: Cafe Thursday! Eat dinner with us while viewing a showcase of talent ranging from music, art, comedy, and more.',7,NULL,'Alpha Delta Phi, 351 Massachusetts Ave., Cambridge','2010-04-08 17:00:00',180,NULL,NULL,6,'unconfirmed'),(59,'Chill and Grill','You chill, we grill. We\'ll be cooking up a storm on the historic Bay State Road and relaxing in and around our beautiful brownstone house. You can\'t miss us - we\'re right under the CITGO sign!',7,NULL,'Theta Xi, 64 Bay State Rd., Boston','2010-04-08 17:00:00',180,NULL,NULL,6,'unconfirmed'),(60,'CPW Prefrosh Lounge','Looking for a place to relax between events? Have a question only an MIT student can answer? Just drop by!',7,NULL,'Student Center (W20), 3rd Floor, Coffeehouse','2010-04-08 17:00:00',180,NULL,NULL,6,'unconfirmed'),(61,'Featured House Dining for Parents','Check out MIT\'s house dining options in Ashdown House (NW35) - 5:30-8:30pm; Baker House (W7-100) - 5:30-8:30pm; McCormick Hall (W4-100) - 5:00-8:00pm; Next House (W71-100) - 5:30-8:30pm; and Simmons Hall (W79-100) - 5:00-8:00pm. Bring your CPW parent meal voucher (available at registration) and your meal is free!',7,NULL,'Various Locations','2010-04-08 17:00:00',210,NULL,NULL,6,'unconfirmed'),(62,'Wiki Racing &amp; Dinner','Race through cyberspace from \"Bananas\" to \"Communism\" then enjoy a delicious home-cooked meal with honey mustard chicken, spinach salad, and cherry crisp! Vegetarian options always available. Meet us in Lobby 7 to catch our Big Silver van to ET.',7,NULL,'Epsilon Theta, 259 Saint Paul St., Brookline','2010-04-08 17:15:00',105,NULL,NULL,6,'unconfirmed'),(63,'Dumpling Hylomorphism','Anamorphism: the building up of a structure. Catamorphism: the consumption of a structure. Hylomorphism: both an anamorphism and a catamorphism. This event? A hylomorphism on dumplings. Come learn the basic fold, or just perform a metabolic reduction on food.',7,NULL,'Random Hall (NW61)','2010-04-08 17:17:00',120,NULL,NULL,6,'unconfirmed'),(64,'Global Poverty Initiative General Body Meeting','Come learn about the Global Poverty Initiative at MIT and see what we do on campus, in the community, and around the world. Food will be provided, and students will be making stethoscopes out of simple materials. ',7,NULL,'Room 1-150','2010-04-08 17:30:00',60,NULL,NULL,6,'unconfirmed'),(65,'Toons at Dinner!','Experience a cappella like never before! The MIT/Wellesley Toons, MIT\'s only cross-campus a cappella group, will be performing through all the campus dining halls, starting with McCormick and ending with Simmons. What could be better? Dorm food, good music, and PRIZES!',7,NULL,'Campus dining halls','2010-04-08 17:30:00',90,NULL,NULL,6,'unconfirmed'),(66,'Minority Student Dinner &amp; Discussion','Enjoy great food and meet students from the African American, Latino, and Native American communities. Hear about clubs, events, and organizations with which you could be involved, as well as personal stories of life as a student of color at the Institute.',7,NULL,'Walker Memorial (50), Morss Hall','2010-04-08 17:30:00',105,NULL,NULL,6,'unconfirmed'),(67,'Minority Parent Reception','MIT welcomes parents to its African American, Latino, and Native American communities. You are invited to join campus administrators, faculty, current students, and parents to learn more about the campus, student resources, and support services. Guest speakers from throughout the community will share their insight and experiences.',7,NULL,'Stata Center (32), 4th Floor, The R and D','2010-04-08 17:30:00',105,NULL,NULL,6,'unconfirmed'),(68,'NALGAS Fiesta','Come spice up your day with the Next Association of Latinos Giving Alltimate Satisfaction (NALGAS)! Taste incredible hispanic food and break an authentic pinata. Throw all your cares to the wind to the sound of Latino Music and real mariachi!',7,NULL,'Next House Dining (W71)','2010-04-08 17:30:00',120,NULL,NULL,6,'unconfirmed'),(69,'Absorb Ice Cream Like a Sponge!','Come join the fun and create the most extravagant ice cream sundae possible with a selection of hot fudge, whipped cream, sprinkles and more - all while meeting other prefrosh and friendly Simmons residents!',7,NULL,'Simmons Hall (W79)','2010-04-08 17:30:00',120,NULL,NULL,6,'unconfirmed'),(70,'Come Check Out the Beta House','Check out our house, jam with some of the brothers in our stage room, play hacky sack, skateboard out in front, we like all of the above.',7,NULL,'Beta Theta Pi, 119 Bay State Rd., Boston','2010-04-08 17:30:00',150,NULL,NULL,6,'unconfirmed'),(71,'Design a page in tomorrow\'s issue of The Tech!','Interested in writing, taking photos, or helping lay out the paper? We are devoting several pages to YOU: your content and skills! Come in and have fun, and get your work distributed across campus the next day.',7,NULL,'Room W20-483','2010-04-08 18:00:00',360,NULL,NULL,6,'unconfirmed'),(72,'The Tech\'s Open Newsroom','Watch as we put together tomorrow\'s issue of \"The Tech\", featuring a special section about you, our visiting prefrosh! Find out how you can be part of it - if you stop by early enough, you might grab a byline!',7,NULL,'Room W20-483','2010-04-08 18:00:00',480,NULL,NULL,6,'unconfirmed'),(73,'Dinner at DKE!','Looking for a hearty meal after a long day of exploring campus?  Come join the brothers of DKE and enjoy a fresh, warm meal cooked by our chef Tom as we unwind after the day.',7,NULL,'Delta Kappa Epsilon, 403 Memorial Dr., Cambridge','2010-04-08 18:00:00',60,NULL,NULL,6,'unconfirmed'),(74,'Baking With Pumpkins','Here at German House, we love to bake. Our residential expert on pumpkin baking will be creating delicious combinations of cinammon, nutmeg, and ginger into cookies, brownies and cakes. Come bake or just eat!',7,NULL,'New House (W70), German House (House 6), 2nd Floor','2010-04-08 18:00:00',60,NULL,NULL,6,'unconfirmed'),(75,'Dinner','Come enjoy dinner with the brothers of Zeta Beta Tau and hear brothers speak about their MIT experiences - call Rick at 617-232-3257 for a ride.',7,NULL,'Zeta Beta Tau, 58 Manchester Rd., Brookline','2010-04-08 18:00:00',90,NULL,NULL,6,'unconfirmed'),(76,'Gerry\'s World Famous Fried Chicken','Come to Phi Kappa Sigma (Skullhouse) for chef extraordinaire Gerry Martinez\'s world famous delicious fried chicken, with corn and mashed potatoes. You haven\'t tried chicken until you\'ve tried Gerry\'s fried chicken. ',7,NULL,'Phi Kappa Sigma, 530 Beacon St., Boston','2010-04-08 18:00:00',120,NULL,NULL,6,'unconfirmed'),(77,'Dinner with Kappa Sigma','Stop by our on-campus location to grab some dinner and play some table-hockey, ping-pong and more.',7,NULL,'Kappa Sigma, 407 Memorial Dr., Cambridge','2010-04-08 18:00:00',120,NULL,NULL,6,'unconfirmed'),(78,'East Campus Grilling','Stuff your face with hot beef (and veggie burgers if storing dead animals is none of your stomach\'s business).',7,NULL,'East Campus Courtyard (between Buildings 62 and 64)','2010-04-08 18:00:00',120,NULL,NULL,6,'unconfirmed'),(79,'CPW Prefrosh Lounge','Looking for a place to relax between events? Have a question only an MIT student can answer? Just drop by!',7,NULL,'Student Center (W20), 3rd Floor, Coffeehouse','2010-04-08 18:00:00',120,NULL,NULL,6,'unconfirmed'),(80,'Featured House Dining for Parents','Check out MIT\'s house dining options in Ashdown House (NW35) - 5:30-8:30pm; Baker House (W7-100) - open until 8:30pm; McCormick Hall (W4-100) - open until 8:00pm; Next House (W71-100) - open until 8:30pm; and Simmons Hall (W79-100) - open until 8:00pm. Bring your CPW parent meal Voucher (available at registration) and your meal is free!',7,NULL,'Various Locations','2010-04-08 18:00:00',150,NULL,NULL,6,'unconfirmed'),(81,'Chillin With Delts','Come kick it at DTD. We\'ll be shooting pool, playing foosball, maybe some poker, and eating a dope turkey dinner.',7,NULL,'Delta Tau Delta, 416 Beacon St., Boston','2010-04-08 18:00:00',240,NULL,NULL,6,'unconfirmed'),(82,'Game Show Night','Team up with your peers and show off your MIT knowledge in jeopardy, family feud or find your perfect match in the dating game.',7,NULL,'Burton-Conner House (W51), TV Lounge','2010-04-08 18:00:00',270,NULL,NULL,6,'unconfirmed'),(83,'China Care Dumpling Dinner','Wanna have some dumplings? Learn more about helping orphans in China and making a difference? Or just hang out with your fellow pre-froshes? The China Care Dumpling Dinner will be a perfect event for you!!',7,NULL,'McCormick Hall (W4), Country Kitchen','2010-04-08 18:15:00',60,NULL,NULL,6,'unconfirmed'),(84,'Diner a La Maison Francaise','Come eat a home-cooked dinner on la maison!',7,NULL,'New House (W70), House 6 (French House), 5th floor kitchen','2010-04-08 18:15:00',60,NULL,NULL,6,'unconfirmed'),(85,'Meet the Men\'s Ultimate Frisbee Team','Catch the end of our last practice before the Championship Series. Come meet the team and see what college Ultimate is all about. We\'ll be available after practice to answer any questions or just to toss some plastic around.',7,NULL,'Briggs Field (grass across from MacGregor House-W61)','2010-04-08 18:15:00',75,NULL,NULL,6,'unconfirmed'),(86,'Liquid Nitrogen Ice Cream','Colder than the heart of a freshman physics professor. This event has one-in-three chance of being Deep Fried Liquid Nitrogen Ice Cream in disguise!',7,NULL,'Random Hall (NW61)','2010-04-08 18:17:00',60,NULL,NULL,6,'unconfirmed'),(87,'Indian Dinner at pika','Authentic. Homemade. Delicious. Vegan. Gluten Free. Meet a pikan at lobby 7 at 6:00pm to be walked over or just follow the little orange flags from Simmons to pika.',7,NULL,'pika, 69 Chestnut St., Cambridge','2010-04-08 18:30:00',60,NULL,NULL,6,'unconfirmed'),(88,'Teriyaki!','Beef teriyaki for dinner! Who could want more?',7,NULL,'Theta Delta Chi, 372 Memorial Dr., Cambridge','2010-04-08 18:30:00',60,NULL,NULL,6,'unconfirmed'),(89,'Biology Open House','Are you a prospective course VII major? Are you thinking about a double major with VII/VIIA? Are you interested in the minor in Biology Program? Are you considering premed? Get the information you need! After 6pm, enter Bldg 68 across from the Stata Center parking lot at the door closest to Building 66.',7,NULL,'Room 68-181','2010-04-08 19:00:00',60,NULL,NULL,6,'unconfirmed'),(90,'Sundaes on Thursday','You\'ll be gone by Sunday, so enjoy some ice cream now. Make your perfect sundae at our top-notch sundae bar or have our distinguished sundae chef make one for you. Fun is guaranteed.',7,NULL,'Kappa Sigma, 407 Memorial Dr., Cambridge','2010-04-08 19:00:00',60,NULL,NULL,6,'unconfirmed'),(91,'Dinner With German House','What makes German House the best place to live on campus? Our delicious dinners! Come experience first-hand the great chefs living here.',7,NULL,'New House (W70), German House (House 6), 2nd Floor','2010-04-08 19:00:00',60,NULL,NULL,6,'unconfirmed'),(92,'Meet the Musicians','Come meet the musicians of the MIT Symphony Orchestra! Find out about the music the group plays and the events we hold all year long. Mingle with fellow musicians and stay to hear us prepare for our next concert!',7,NULL,'Kresge Auditorium, Rehearsal Room B','2010-04-08 19:00:00',60,NULL,NULL,6,'unconfirmed'),(93,'CPW Prefrosh Lounge','Looking for a place to relax between events? Have a question only an MIT student can answer? Just drop by!',7,NULL,'Student Center (W20), 3rd Floor, Coffeehouse','2010-04-08 19:00:00',60,NULL,NULL,6,'unconfirmed'),(94,'Improv','It\'s surprising how easily a group of people can entertain themselves with nothing but their wits and a stick of celery. Meet us in Lobby 7 to catch our Big Silver Van to Epsilon Theta.',7,NULL,'Epsilon Theta, 259 Saint Paul St., Brookline','2010-04-08 19:00:00',75,NULL,NULL,6,'unconfirmed'),(95,'Super FHE','MIT LDS students guarantee a message, fun activity, treats, and the opportunity to meet new friends with shared values. You\'ll leave inspired for the official Class of 2014 Student Welcome, just as weekly Family Home Evening (FHE) inspires us.',7,NULL,'McCormick Hall (W4), East Penthouse','2010-04-08 19:00:00',90,NULL,NULL,6,'unconfirmed'),(96,'Featured House Dining for Parents','Check out MIT\'s house dining options in Ashdown House (NW35) - open until 8:30pm; Baker House (W7-100) - open until 8:30pm; McCormick Hall (W4-100) - open until 8:00pm; Next House (W71-100) - open until 8:30pm; and Simmons Hall (W79-100) - open until 8:00pm. Bring your CPW parent meal Voucher (available at registration) and your meal is free!',7,NULL,'Various Locations','2010-04-08 19:00:00',90,NULL,NULL,6,'unconfirmed'),(97,'Bridge Building Competition','Think you have what it takes to build the best bridge? Then prove it in head-to-head competition for the grand prize! Snacks will be available.',7,NULL,'Theta Delta Chi, 372 Memorial Dr., Cambridge','2010-04-08 19:00:00',120,NULL,NULL,6,'unconfirmed'),(98,'International Feast ','Take your taste buds on an international journey around the world. Come and help us cook our multicultural dinner. Then enjoy a celebration of our meal with games, lively discussion, and huge cards.',7,NULL,'New House (W70), iHouse ','2010-04-08 19:00:00',120,NULL,NULL,6,'unconfirmed'),(99,'Quiz Bowl!','If you like books, reading, random trivia, SCIENCE!, music, and knowledge, come to practice! Old-timers and first-timers to quiz bowl welcome; we love you either way.',7,NULL,'Room 4-144','2010-04-08 19:00:00',120,NULL,NULL,6,'unconfirmed'),(100,'Food Event, Part I','You\'re hungry. You want to eat all of our delicious foods. Come to Senior Haus, building E2. Across Ames Street and into your heart.',7,NULL,'Senior House (E2)','2010-04-08 19:00:00',120,NULL,NULL,6,'unconfirmed'),(101,'NONLINEAR CHAOS (Games Night!!!)','Come by for a night of karaoke, fun games, and tons of FOOD!',7,NULL,'McCormick Hall (W4), East Penthouse','2010-04-08 19:00:00',120,NULL,NULL,6,'unconfirmed'),(102,'Printing Press Tour','What does an early 1900s printing press look like and why does MIT have one? Tours of our letter press start every 15 minutes.',7,NULL,'Student Center (W20), 4th floor, Room W20-415','2010-04-08 19:15:00',60,NULL,NULL,6,'unconfirmed'),(103,'Juggling in Enclosed Spaces','What\'s more fun than throwing brightly colored objects at people? Doing it at the same time as fifteen other people all packed into a small lounge. Come juggle with us! Don\'t know how? We\'re happy to teach you! ',7,NULL,'Random Hall (NW61)','2010-04-08 19:17:00',60,NULL,NULL,6,'unconfirmed'),(104,'Tea and Math','Drink tea, eat biscuits, and learn math! No purchase necessary.',7,NULL,'Random Hall (NW61)','2010-04-08 19:17:00',60,NULL,NULL,6,'unconfirmed'),(105,'Dinner at DU','Enjoy a dinner cooked by our very own chef. We are just across the Mass. Ave. Bridge and to the right at 526 Beacon Street (we\'re the house with a putting green for a front lawn).',7,NULL,'Delta Upsilon, 526 Beacon St., Boston','2010-04-08 19:30:00',45,NULL,NULL,6,'unconfirmed'),(106,'pika House Tours','Learn where we got the door to our upstairs bathroom and why pika is never capitalized. Guaranteed to be one of the most interesting house tours you ever take. The secret of this event is that it will happen every night of CPW.',7,NULL,'pika, 69 Chestnut St., Cambridge','2010-04-08 19:30:00',60,NULL,NULL,6,'unconfirmed'),(107,'Dinner at Zeta Psi','Looking for a warm, home-cooked meal? Come enjoy a delicious family-style dinner prepared by the brothers of Zeta Psi.',7,NULL,'Zeta Psi, 233 Massachusetts Ave., Cambridge','2010-04-08 19:30:00',60,NULL,NULL,6,'unconfirmed'),(108,'Parent Welcome','Stu Schmill, Dean of Admissions and Donald Sadoway, John F. Elliott Professor of Materials Chemistry, welcome the Class of 2014 parents to Campus Preview Weekend.',7,NULL,'Room 26-100','2010-04-08 19:30:00',75,NULL,NULL,6,'unconfirmed'),(109,'Next Act Presents &quot;Urinetown&quot;!','Next Act presents a hilarious musical comedy about what it\'s like when people can\'t pee free! Remember, you better go before the show, because there often is a line! Tickets are FREE and will be available at the door. Also shows Fri. and Sat.',7,NULL,'Next House (W71), Tastefully Furnished Lounge','2010-04-08 20:00:00',120,NULL,NULL,6,'unconfirmed'),(110,'Analog Game Night','Good old-fashioned fun! Hop on Saferide and join us for a night full of board games, pool, foosball, and other things you can do without electronics, all while snacking on foods made in-house on our famous Frialator.',7,NULL,'Theta Xi, 64 Bay State Rd., Boston','2010-04-08 20:00:00',120,NULL,NULL,6,'unconfirmed'),(111,'French Films','Traveling garden gnomes, a musical saw, guys who can scale tall buildings...French movies have it all!',7,NULL,'New House (W70), House 6 (French House), 5th floor kitchen','2010-04-08 20:00:00',180,NULL,NULL,6,'unconfirmed'),(112,'Speed Games','FallingSpeedscrabbleGalaxytruckerRicochetrobots! <br>Not your grandpa\'s game of chess! Meet us in Lobby 7 to catch our Big Silver Van to Epsilon Theta.',7,NULL,'Epsilon Theta, 259 Saint Paul St., Brookline','2010-04-08 20:15:00',60,NULL,NULL,6,'unconfirmed'),(113,'Pillow Wars','Come get out some extra energy and test your skills in our pillow fight tournament.  ',7,NULL,'Random Hall (NW61)','2010-04-08 20:17:00',60,NULL,NULL,6,'unconfirmed'),(114,'CPW Student Welcome and Prefrosh Icebreaker','The official welcome for the Class of 2014 - this will be the first time that all of your prospective MIT classmates will be together!',7,NULL,'Rockwell Cage (W33)','2010-04-08 20:30:00',60,NULL,NULL,6,'unconfirmed'),(115,'Rock Band Tournament','Come join the brothers of DKE as we battle it out rock band style. Food, video games, and fun are all included. Come show off your skills and you just might win a prize.',7,NULL,'Delta Kappa Epsilon, 403 Memorial Dr., Cambridge','2010-04-08 21:00:00',180,NULL,NULL,6,'unconfirmed'),(116,'Indian Movie Night','Come watch \"Diwali Dulhania Le Jayenge\" with us in our own in-house theater! A great first introduction to Indian movies, and a classic for lovers of the genre.',7,NULL,'Alpha Delta Phi, 351 Massachusetts Ave., Cambridge','2010-04-08 21:00:00',120,NULL,NULL,6,'unconfirmed'),(117,'CPW Festival','MIT students welcome you to the community. Experience what makes us unique and what MIT students do for fun.',7,NULL,'Johnson Athletics Center (W34)','2010-04-08 21:30:00',150,NULL,NULL,6,'unconfirmed'),(118,'Chick Flick Night','Wondering where you can be really girly at MIT? Look no further. This is a really casual event: movies, popcorn, nail painting, hair braiding, and a chance to meet friends you can hang out with for the rest of CPW.',7,NULL,'New House (W70), House 3','2010-04-08 22:00:00',120,NULL,NULL,6,'unconfirmed'),(119,'Party at DU','Start the weekend early with a great party. Mingle with coeds from MIT and the greater Boston area - we\'re just across the Mass. Ave. Bridge and to the right.',7,NULL,'Delta Upsilon, 526 Beacon St., Boston','2010-04-08 22:00:00',180,NULL,NULL,6,'unconfirmed'),(120,'Baker House presents HORIZON','Come kick off CPW with the hottest party of the evening! Enjoy the Boston skyline while dancing the night away to the beats of DJ NITE. Rising hip-hop artists E-Jeezy and MiKO will make an appearance. Refreshments will be served.',7,NULL,'Baker House (W7), Rooftop ','2010-04-08 22:00:00',180,NULL,NULL,6,'unconfirmed'),(121,'Rock Band Showdown','Think you and your friends have what it takes to beat our Rock Band champions? Bring \'em all and bring it... if you can.  ',7,NULL,'Theta Xi, 64 Bay State Rd., Boston','2010-04-08 22:00:00',180,NULL,NULL,6,'unconfirmed'),(122,'Simmons Movie Theater Mania','Action. Comedy. Crime. Drama. Fantasy. Horror. Mystery. Romance. Sci-Fi. Thriller. Pick a genre, choose the movie and we\'ll play it in our movie theater on a 10-FOOT SCREEN with BOSE SURROUND SOUND! There will be plenty of popular movie snacks.',7,NULL,'Simmons Hall (W70), Multi-purpose Room','2010-04-08 22:00:00',240,NULL,NULL,6,'unconfirmed'),(123,'Molecular Gastronomy','Caviar that tastes like blueberry? Lemons (no sweeteners added) that taste like lemon candy? Chocolate mousse that disappears in your mouth, leaving only the delicious flavor behind? Come make some, eat some, and learn about the science behind these treats!',7,NULL,'New House (W70), House 6 (French House), 5th floor kitchen','2010-04-08 22:00:00',60,NULL,NULL,6,'unconfirmed'),(124,'Dessert Night: S\'mores','Join us in the Next House courtyard to toast s\'mores! Come enjoy the chocolate-marshmallow-graham cracker goodness as we share some entertaining MIT tales.',7,NULL,'Next House (W71), Courtyard','2010-04-08 22:30:00',90,NULL,NULL,6,'unconfirmed'),(125,'Poker Tournament','Come relax and play poker at LCA for a prize. Take Boston West saferide to the 3rd stop, or call 516-503-2875 for a ride from campus.',7,NULL,'Lambda Chi Alpha, 99 Baystate Rd., Boston','2010-04-08 22:30:00',90,NULL,NULL,6,'unconfirmed'),(126,'Ice Cream Social','Ice Cream, Ice Cream, Ice Cream! Who could resist this deliciousness? Enjoy a night of tasty ice cream with everyone as you settle in for CPW! ',7,NULL,'New House (W70), House 4, 5th floor south','2010-04-08 22:30:00',90,NULL,NULL,6,'unconfirmed'),(127,'Painting, Fondue, and Star Gazing','Come join us for &quot;wall&quot; painting, star gazing, and an expensive cheeses study break!',7,NULL,'Simmons Hall (W79), 4C Hallway','2010-04-08 22:30:00',90,NULL,NULL,6,'unconfirmed'),(128,'SUGAR HIGH DANCE PARTY','Can you feel the bass? Come dance it up with your future classmates. We have enough sugar to power you through the rest of this crazy weekend. And did we mention glow sticks? Check out http://tinyurl.com/bc-sugarhigh for updates.',7,NULL,'Burton-Conner House (W51), Porter Room','2010-04-08 22:30:00',210,NULL,NULL,6,'unconfirmed'),(129,'FIREHOSE: Duct-Tape Mania','Want to make a duct tape wallet? Sandals? A fire hydrant? Come make awesome things out of duct tape! Duct tape provided. PRETTY COLORS. Come hang out, eat food, and take classes until stupid late.',7,NULL,'6th floor of building 24','2010-04-08 23:00:00',60,NULL,NULL,6,'unconfirmed'),(130,'FIREHOUSE: Burnside\'s Lemma','Want to know how many ways you can paint the faces of a cube with n colors? Abstract algebra can help you--but be warned, this is not the algebra everybody did in high school! ',7,NULL,'6th floor of building 24','2010-04-08 23:00:00',60,NULL,NULL,6,'unconfirmed'),(131,'La Casa Study Break','Come after the CPW festival and join us for our weekly study break Thursday night. Our study breaks consist of good food and serve as a fun break from homework and responsibilities. Make new friends and get to know the La Casa familia.',7,NULL,'New House (W70), House 3, Spanish House Dining Room','2010-04-08 23:00:00',90,NULL,NULL,6,'unconfirmed'),(132,'FIREHOSE: Your Art Teacher LIED to You!','Come see your art teacher\'s claims fall at the hand of experimental science: the science of human vision. This class is part of ESP\'s FIREHOSE Event! Come hang out, eat our food, and take classes until stupid late. ',7,NULL,'6th floor of building 24','2010-04-08 23:00:00',120,NULL,NULL,6,'unconfirmed'),(133,'Cocoa and Stories ','Come join Fourth East for an extended version of our nightly cocoa tradition. We provide the hot chocolate, dessert, and MIT stories. Meet in the East Campus courtyard by the ugly modern art.',7,NULL,'East Campus (64), Fourth East','2010-04-08 23:00:00',120,NULL,NULL,6,'unconfirmed'),(134,'AEPi Cidernight','Hot apple cider, homemade banana bread, lots of other baked goodies, and some fun games make this late night event a can\'t-miss... 5th stop on Saferide Boston West, or call us at 847-902-0863 for a ride.',7,NULL,'Alpha Epsilon Pi, 155 Bay State Rd., Boston','2010-04-08 23:00:00',180,NULL,NULL,6,'unconfirmed'),(135,'Nightmare','We\'re bringing back our favorite holiday, like Jason and Freddy from the grave. Let your inner monster loose on the dancefloor at Skullhouse. ',7,NULL,'Phi Kappa Sigma, 530 Beacon St., Boston','2010-04-08 23:00:00',180,NULL,NULL,6,'unconfirmed'),(136,'The 3 P\'s: Pizza, Poker, Pool','CPW has begun: it is time to put on your poker face. Win cool MIT prizes, eat delicious pizza, and test your pool skillz. By the way, no counting cards!',7,NULL,'Sigma Phi Epsilon (the big red door), 518 Beacon St., Boston','2010-04-08 23:00:00',270,NULL,NULL,6,'unconfirmed'),(137,'Midnight Buffet','Not thinking about calling it a night, were you? Drop by the Kappa Sig stoop instead for a late-night snack, some pick-up basketball or that last game of Wii Olympics.',7,NULL,'Kappa Sigma, 407 Memorial Dr., Cambridge','2010-04-08 23:30:00',90,NULL,NULL,6,'unconfirmed'),(138,'Room For One More','Watch the modern cult movie \"The Room\" with the residents of the Third HNC. Idolize Tommy Wisseau, and marvel at the intricate twists of the subplots.',7,NULL,'Senior House (E2), Third HNC','2010-04-08 23:30:00',150,NULL,NULL,6,'unconfirmed'),(139,'Movie on the Roof','Enjoy a movie on our roof deck overlooking the heart of Kenmore Square, the famous CITGO sign, and Fenway Park. Third stop Saferide Boston East.',7,NULL,'Phi Sigma Kappa, 487 Commonwealth Ave., Boston','2010-04-08 23:45:00',135,NULL,NULL,6,'unconfirmed'),(140,'Late-Night Snack','Got the midnight munchies? Stop by TDC for some late-night grub.',7,NULL,'Theta Delta Chi, 372 Memorial Dr., Cambridge','2010-04-08 23:59:00',60,NULL,NULL,6,'unconfirmed'),(141,'Midnight Frisbee','Come join the brothers of Alpha Delta Phi and hordes of your newfound friends playing glow-in-the-dark frisbee! Meet on Briggs Field, between MacGregor (W61)and Simmons (W79).',7,NULL,'Briggs Field','2010-04-08 23:59:00',60,NULL,NULL,6,'unconfirmed'),(142,'Midnight Snack','Come eat french toast sticks, bacon, wings, pot stickers and other tasty fried snacks with the guys at Theta Chi.',7,NULL,'Theta Chi, 528 Beacon St., Boston','2010-04-08 23:59:00',121,NULL,NULL,6,'unconfirmed'),(145,'something else','blah',7,NULL,'','2010-11-09 00:00:00',31614,NULL,NULL,0,'unconfirmed'),(146,'sweet event','',9,NULL,'','0000-00-00 00:00:00',1241,NULL,NULL,0,'confirmed'),(147,'another one','',9,NULL,'','0000-00-00 00:00:00',1240,NULL,NULL,0,'confirmed'),(154,'booya','',9,NULL,'','2010-11-03 22:54:00',0,NULL,NULL,0,'confirmed'),(155,'something','',9,NULL,'','2010-11-03 22:54:00',0,NULL,NULL,0,'rejected'),(156,'sldkfjdfs','',9,NULL,'','2010-11-03 22:54:00',0,NULL,NULL,0,'rejected'),(157,'aha','',9,NULL,'','2010-11-03 22:54:00',0,NULL,NULL,6,'hidden'),(158,'byb','',9,NULL,NULL,'2010-11-17 20:00:00',1268544900,NULL,NULL,9,'confirmed'),(159,'way cool','',7,NULL,NULL,'2010-11-10 20:00:00',1267950180,NULL,NULL,6,'hidden'),(160,'niceness','',19,NULL,NULL,'2010-11-04 00:00:00',1267366080,NULL,NULL,10,'hidden'),(161,'shouldhavelat','',19,NULL,NULL,'2010-11-04 00:00:00',1267366080,NULL,NULL,10,'hidden'),(162,'shoulddefhavelat','',19,NULL,NULL,'2010-11-04 00:00:00',1267366080,42.3591464425085,-71.0954260826111,10,'hidden'),(163,'coolio','',23,NULL,NULL,'2010-11-04 04:00:00',1267380240,42.4124787088531,-71.7281055450439,6,'hidden'),(164,'badass','',23,NULL,NULL,'2010-11-04 04:00:00',1267380240,42.4112905190282,-71.7338562011719,6,'hidden'),(165,'coollsaa','',23,NULL,NULL,'2010-11-04 04:00:00',1267380240,42.4112746763451,-71.7308735847473,6,'hidden'),(166,'cool thing here','',25,NULL,NULL,'2010-11-04 05:00:00',1267383780,42.358987883855,-71.0967993736267,12,'hidden'),(167,'blah2','',24,NULL,'sdffd','2010-11-04 06:00:00',1267387320,42.358987883855,-71.0967993736267,12,'hidden'),(168,'',NULL,0,NULL,NULL,'2010-11-04 05:45:26',1267382861,NULL,NULL,0,'unconfirmed'),(169,'woahshitsdffa','',24,NULL,'aaaabbb','2010-11-04 06:00:00',1267387320,42.358987883855,-71.0967993736267,12,'hidden'),(170,'',NULL,0,NULL,NULL,'2010-11-04 05:47:11',1267382964,NULL,NULL,0,'unconfirmed'),(171,'',NULL,0,NULL,NULL,'2010-11-04 05:47:17',1267382970,NULL,NULL,0,'unconfirmed'),(172,'',NULL,0,NULL,NULL,'2010-11-04 05:47:27',1267382980,NULL,NULL,0,'unconfirmed'),(173,'',NULL,0,NULL,NULL,'2010-11-04 05:47:40',1267382992,NULL,NULL,0,'unconfirmed'),(174,'nice event','',26,NULL,'stanford as well','2010-11-04 06:00:00',1267387320,37.424106,-122.166076,12,'hidden'),(175,'checktime','',24,NULL,'','2010-11-04 19:00:00',60,42.358987883855,-71.0967993736267,12,'hidden'),(176,'again','',24,NULL,'','2010-11-04 07:00:00',1267390860,42.358987883855,-71.0967993736267,12,'hidden'),(177,'fixednow','',24,NULL,'','2010-11-18 06:00:00',17400,42.358987883855,-71.0967993736267,12,'hidden'),(178,'caty','',27,NULL,'','2010-11-04 07:00:00',60,NULL,NULL,6,'hidden'),(179,'jus\'!?st checking','',20,NULL,'','2010-11-04 11:00:00',60,42.360351475199,-71.1026358604431,6,'hidden'),(180,'waycoool','',20,NULL,'stanford','2010-11-04 11:00:00',60,37.424106,-122.166076,6,'hidden'),(181,'woah event','',28,NULL,'','2010-11-04 18:00:00',120,NULL,NULL,6,'hidden');
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events_users`
--

DROP TABLE IF EXISTS `events_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `events_users` (
  `event_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  UNIQUE KEY `un` (`event_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events_users`
--

LOCK TABLES `events_users` WRITE;
/*!40000 ALTER TABLE `events_users` DISABLE KEYS */;
INSERT INTO `events_users` VALUES (2,6),(3,6),(166,12);
/*!40000 ALTER TABLE `events_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_aliases`
--

DROP TABLE IF EXISTS `user_aliases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_aliases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alias` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `alias` (`alias`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_aliases`
--

LOCK TABLES `user_aliases` WRITE;
/*!40000 ALTER TABLE `user_aliases` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_aliases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `email` varchar(200) NOT NULL,
  `pass` char(40) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (5,'Guest',''),(6,'frozen_fire1991@yahoo.com','fromfacebook'),(7,'a@a.com','356a192b7913b04c54574d18c28d46e6395428ab'),(8,'blahdee@da.com','unregistered'),(9,'b@b.com','356a192b7913b04c54574d18c28d46e6395428ab'),(10,'love@love.com','356a192b7913b04c54574d18c28d46e6395428ab'),(11,'someguy@blah.com','unregistered'),(12,'me@you.com','3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d');
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

-- Dump completed on 2010-11-04 11:58:22
