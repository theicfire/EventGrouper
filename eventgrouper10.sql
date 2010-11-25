-- MySQL dump 10.13  Distrib 5.1.49, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: eventgrouper
-- ------------------------------------------------------
-- Server version	5.1.49-1ubuntu8.1

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
) ENGINE=MyISAM AUTO_INCREMENT=335 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acos`
--

LOCK TABLES `acos` WRITE;
/*!40000 ALTER TABLE `acos` DISABLE KEYS */;
INSERT INTO `acos` VALUES (1,0,'EventGroup',1,NULL,1,2),(334,319,'Event',9,NULL,22,23),(333,320,'Event',8,NULL,7,8),(332,320,'Event',7,NULL,5,6),(331,325,'Event',6,NULL,15,16),(330,325,'Event',5,NULL,13,14),(329,319,'Event',4,NULL,20,21),(328,327,'Event',3,NULL,29,30),(326,319,'EventGroup',105,NULL,18,19),(325,319,'EventGroup',104,NULL,12,17),(327,321,'EventGroup',106,NULL,28,31),(323,319,'Event',2,NULL,10,11),(322,321,'Event',1,NULL,26,27),(321,NULL,'EventGroup',102,NULL,25,32),(320,319,'EventGroup',101,NULL,4,9),(319,NULL,'EventGroup',100,NULL,3,24);
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
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aros`
--

LOCK TABLES `aros` WRITE;
/*!40000 ALTER TABLE `aros` DISABLE KEYS */;
INSERT INTO `aros` VALUES (1,0,'User',5,NULL,1,62),(34,1,'User',38,NULL,60,61),(33,1,'User',37,NULL,58,59);
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
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aros_acos`
--

LOCK TABLES `aros_acos` WRITE;
/*!40000 ALTER TABLE `aros_acos` DISABLE KEYS */;
INSERT INTO `aros_acos` VALUES (1,33,319,'1','1','1','1','1'),(2,1,319,'0','1','0','0','0'),(3,33,321,'1','1','1','1','1'),(4,1,321,'0','1','0','0','0'),(5,34,319,'1','0','0','0','0');
/*!40000 ALTER TABLE `aros_acos` ENABLE KEYS */;
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
  `highest_name` varchar(255) NOT NULL,
  `location` text,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=107 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_groups`
--

LOCK TABLES `event_groups` WRITE;
/*!40000 ALTER TABLE `event_groups` DISABLE KEYS */;
INSERT INTO `event_groups` VALUES (1,NULL,NULL,NULL,NULL,1,2,'','',NULL,NULL,NULL),(105,'how about this','',NULL,100,10,11,'cpw-10/how-about-this','cpw 10!!!!!o','',NULL,NULL),(104,'try again','',NULL,100,8,9,'cpw-10/try-again','cpw 10!!!!!o','',NULL,NULL),(106,'biscuits','',NULL,102,14,15,'and-another/biscuits','and another!!!','',NULL,NULL),(102,'and another!!!','',NULL,0,13,16,'and-another','and another!!!','',NULL,NULL),(100,'cpw 10!!!!!o','',NULL,NULL,3,12,'cpw-10','cpw 10!!!!!o','',NULL,NULL),(101,'ok by','',NULL,100,4,5,'cpw-10/ok-by','cpw 10!!!!!o','',NULL,NULL);
/*!40000 ALTER TABLE `event_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_groups_users`
--

DROP TABLE IF EXISTS `event_groups_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event_groups_users` (
  `user_id` int(10) NOT NULL,
  `event_group_id` int(10) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `uni` (`user_id`,`event_group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_groups_users`
--

LOCK TABLES `event_groups_users` WRITE;
/*!40000 ALTER TABLE `event_groups_users` DISABLE KEYS */;
INSERT INTO `event_groups_users` VALUES (37,102,'2010-11-24 21:45:52'),(37,100,'2010-11-25 02:59:04');
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
  `tags` text COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `searcher` (`title`,`description`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` VALUES (1,'crazy awesome','',102,NULL,'','2010-11-22 10:00:00',60,NULL,NULL,37,'hidden',''),(2,'earier','Lorem ipsum dolor sit amet, tempus donec, tempor enim ipsum nec, elit magna cras viverra at augue. Maecenas nec vulputate pulvinar bibendum dictum sit, ullamcorper nunc magna congue. Non vitae nunc odio per, porttitor leo in dolor sed id, nec cras dui viverra pellentesque etiam luctus. Et scelerisque vulputate, consequat iaculis aenean sagittis ipsum tellus, erat diam vivamus pede. Urna fermentum tempus a, eros purus turpis mauris. Posuere mauris, nunc dolor convallis cras proin metus, nulla nunc lectus mollis lobortis mollis sapien, etiam quis eget. Urna vel vel per, cumque consectetuer, ut erat, dignissim nam proin nec. Sit felis lacinia. Dictum velit felis, pede vivamus lorem non facilisis platea, fusce erat. Consequat nunc, blandit sit amet rutrum bibendum lorem mi, elementum donec quam et, nullam et. Ex omnis, pharetra orci metus elementum, ac tellus, morbi leo. Aliquam mattis placerat pharetra congue accumsan, mauris vel vitae ante velit ipsum id, montes mollis, et amet venenatis sit erat sed.\r\n\r\nNec morbi nunc dapibus consectetuer tortor, vehicula nunc et libero at vitae, elit gravida magna ultricies, aliquam ipsum libero pretium pellentesque dolor. Sed nunc unde neque et, etiam magna suspendisse mattis, ut et ante sit posuere, quis auctor felis, blandit ultrices. Ut sapien lobortis nonummy rutrum, ullamcorper vestibulum blandit mattis voluptatem a feugiat. Ligula pede porta tellus dolor, lorem fringilla vestibulum neque. Eget sed sit viverra est, donec dignissim, elit orci nonummy est inceptos, vulputate dui eleifend, et adipiscing sit placerat proin. Feugiat arcu, lectus at lectus quam egestas eu, eros curae lorem risus sagittis semper placerat, feugiat metus, egestas erat nulla v\r\n',100,NULL,'','2010-11-01 10:00:00',30360,NULL,NULL,37,'hidden',''),(3,'sweeet','',106,NULL,'df','2010-11-22 10:00:00',60,NULL,NULL,37,'hidden',''),(4,'another one','',100,NULL,'','2010-11-22 10:00:00',60,NULL,NULL,37,'hidden',''),(5,'try more!','',104,NULL,'','2010-11-22 10:00:00',60,NULL,NULL,37,'hidden',''),(6,'with cool location','',104,NULL,'','2010-11-22 10:00:00',60,42.357814537385,-71.0988593101501,37,'hidden',''),(7,'also has a location','',101,NULL,'killian','2010-11-22 10:00:00',60,42.3591622983518,-71.0942888259888,37,'hidden','food, fun, friends, required'),(8,'loooc','',101,NULL,'boston side','2010-11-22 10:00:00',60,42.35115458831,-71.0886025428772,37,'hidden','');
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
INSERT INTO `events_users` VALUES (7,37);
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
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (5,'Guest',''),(38,'b@b.com','unregistered'),(37,'a@a.com','3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d');
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

-- Dump completed on 2010-11-24 22:07:42
