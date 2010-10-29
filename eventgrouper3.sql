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
) ENGINE=MyISAM AUTO_INCREMENT=191 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acos`
--

LOCK TABLES `acos` WRITE;
/*!40000 ALTER TABLE `acos` DISABLE KEYS */;
INSERT INTO `acos` VALUES (1,0,'EventGroup',1,NULL,1,2),(178,NULL,'EventGroup',22,NULL,3,8),(179,178,'EventGroup',23,NULL,4,7),(180,179,'Event',1,NULL,5,6),(181,NULL,'EventGroup',24,NULL,9,10),(182,NULL,'EventGroup',25,NULL,11,28),(183,182,'Event',2,NULL,12,13),(184,182,'Event',3,NULL,14,15),(185,182,'Event',4,NULL,16,17),(186,182,'Event',5,NULL,18,19),(187,182,'Event',6,NULL,20,21),(188,182,'EventGroup',26,NULL,22,25),(189,182,'EventGroup',27,NULL,26,27),(190,188,'Event',7,NULL,23,24);
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
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aros`
--

LOCK TABLES `aros` WRITE;
/*!40000 ALTER TABLE `aros` DISABLE KEYS */;
INSERT INTO `aros` VALUES (1,0,'User',5,NULL,1,28),(10,1,'User',20,NULL,16,17),(13,1,'User',23,NULL,20,21),(12,1,'User',22,NULL,18,19),(14,1,'User',24,NULL,22,23),(15,1,'User',25,NULL,24,25),(16,1,'User',27,NULL,26,27);
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
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aros_acos`
--

LOCK TABLES `aros_acos` WRITE;
/*!40000 ALTER TABLE `aros_acos` DISABLE KEYS */;
INSERT INTO `aros_acos` VALUES (1,10,178,'1','1','1','1','1'),(2,1,178,'0','1','0','0','0'),(3,12,178,'1','0','0','0','0'),(4,13,178,'1','0','0','0','0'),(5,10,179,'1','1','1','1','1'),(6,1,179,'0','1','0','0','0'),(7,10,180,'1','1','1','1','1'),(8,14,181,'1','1','1','1','1'),(9,1,181,'0','1','0','0','0'),(10,16,182,'1','1','1','1','1'),(11,1,182,'0','1','0','0','0'),(12,16,183,'1','1','1','1','1'),(13,16,184,'1','1','1','1','1'),(14,16,185,'1','1','1','1','1'),(15,16,186,'1','1','1','1','1'),(16,16,187,'1','1','1','1','1'),(17,16,188,'1','1','1','1','1'),(18,1,188,'0','1','0','0','0'),(19,16,189,'1','1','1','1','1'),(20,1,189,'0','1','0','0','0'),(21,16,190,'1','1','1','1','1');
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
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_choices`
--

LOCK TABLES `category_choices` WRITE;
/*!40000 ALTER TABLE `category_choices` DISABLE KEYS */;
INSERT INTO `category_choices` VALUES (1,'Food\r',22),(2,'Fun',22),(3,'Food\r',24),(4,'Fun\r',24),(5,'More Stuff\r',24),(6,'',24),(7,'Food\r',25),(8,'Fun',25);
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
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_groups`
--

LOCK TABLES `event_groups` WRITE;
/*!40000 ALTER TABLE `event_groups` DISABLE KEYS */;
INSERT INTO `event_groups` VALUES (0,NULL,NULL,NULL,NULL,1,2,'',NULL,NULL,NULL),(22,'cpw 10','','',0,3,6,'cpw10','',42.360539,-71.090074),(23,'pkt','','',22,4,5,'cpw10/pkt','some place on commonwealth',42.350295516087,-71.0818771692505),(24,'rush','','',0,7,8,'rush','mit',42.360539,-71.090074),(25,'blah','','',0,9,14,'cool','',NULL,NULL),(26,'pkt','crazy col','',25,10,11,'cool/pkt','',37.4605699514494,-122.221379217529),(27,'another','','',25,12,13,'cool/another','',NULL,NULL);
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
  PRIMARY KEY (`id`),
  FULLTEXT KEY `searcher` (`title`,`description`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` VALUES (1,'crazy party','',23,'','some place on commonwealth','2010-10-25 20:54:00',60,42.350295516087,-71.0818771692505,0),(2,'something','',25,'','','2010-10-25 20:54:00',60,37.4470789936835,-122.212538656616,0),(3,'and another','',25,'','','2010-10-25 20:54:00',60,NULL,NULL,0),(4,'and another ohh','',25,'','','2010-10-25 20:54:00',60,NULL,NULL,0),(5,'blah','',25,'','','2010-10-26 20:54:00',60,NULL,NULL,0),(6,'fifteen','',25,'','','2010-10-25 15:54:00',60,NULL,NULL,0),(7,'under pkt','',26,'','','2010-10-25 20:54:00',60,37.4605699514494,-122.221379217529,0);
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
INSERT INTO `events_users` VALUES (4,27);
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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_aliases`
--

LOCK TABLES `user_aliases` WRITE;
/*!40000 ALTER TABLE `user_aliases` DISABLE KEYS */;
INSERT INTO `user_aliases` VALUES (1,'theicfire@gmail.com',22);
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
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (5,'Guest',''),(20,'b@b.com','356a192b7913b04c54574d18c28d46e6395428ab'),(23,'lambertgchase@gmail.com','356a192b7913b04c54574d18c28d46e6395428ab'),(22,'chase.g.lambert@gmail.com','356a192b7913b04c54574d18c28d46e6395428ab'),(24,'lambertc@mit.edu','356a192b7913b04c54574d18c28d46e6395428ab'),(27,'frozen_fire1991@yahoo.com','fromfacebook');
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

-- Dump completed on 2010-10-29  2:00:48
