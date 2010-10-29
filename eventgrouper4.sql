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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acos`
--

LOCK TABLES `acos` WRITE;
/*!40000 ALTER TABLE `acos` DISABLE KEYS */;
INSERT INTO `acos` VALUES (1,0,'EventGroup',1,NULL,1,2),(2,NULL,'EventGroup',2,NULL,3,12),(3,2,'EventGroup',3,NULL,4,7),(4,3,'EventGroup',4,NULL,5,6),(5,2,'EventGroup',5,NULL,8,11),(6,5,'EventGroup',6,NULL,9,10),(7,NULL,'EventGroup',7,NULL,13,14);
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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aros`
--

LOCK TABLES `aros` WRITE;
/*!40000 ALTER TABLE `aros` DISABLE KEYS */;
INSERT INTO `aros` VALUES (1,0,'User',5,NULL,1,4),(2,1,'User',6,NULL,2,3);
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
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aros_acos`
--

LOCK TABLES `aros_acos` WRITE;
/*!40000 ALTER TABLE `aros_acos` DISABLE KEYS */;
INSERT INTO `aros_acos` VALUES (1,2,2,'1','1','1','1','1'),(2,1,2,'0','1','0','0','0'),(3,2,3,'1','1','1','1','1'),(4,1,3,'0','1','0','0','0'),(5,2,4,'1','1','1','1','1'),(6,1,4,'0','1','0','0','0'),(7,2,5,'1','1','1','1','1'),(8,1,5,'0','1','0','0','0'),(9,2,6,'1','1','1','1','1'),(10,1,6,'0','1','0','0','0'),(11,2,7,'1','1','1','1','1'),(12,1,7,'0','1','0','0','0');
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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_choices`
--

LOCK TABLES `category_choices` WRITE;
/*!40000 ALTER TABLE `category_choices` DISABLE KEYS */;
INSERT INTO `category_choices` VALUES (1,'Food\r',2),(2,'Fun',2),(3,'Food\r',7),(4,'Fun',7);
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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_groups`
--

LOCK TABLES `event_groups` WRITE;
/*!40000 ALTER TABLE `event_groups` DISABLE KEYS */;
INSERT INTO `event_groups` VALUES (1,NULL,NULL,NULL,NULL,1,2,'',NULL,NULL,NULL),(2,'first','','',0,3,12,'somewhere','',NULL,NULL),(3,'another','','',2,4,7,'somewhere/another','',NULL,NULL),(4,'more','','',3,5,6,'somewhere/another/more','',NULL,NULL),(5,'woah','','',2,8,11,'somewhere/woah','',NULL,NULL),(6,'sheek','','',5,9,10,'somewhere/woah/sheek','',NULL,NULL),(7,'CPW 10','','',0,13,14,'cpw10','',NULL,NULL);
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (5,'Guest',''),(6,'frozen_fire1991@yahoo.com','fromfacebook');
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

-- Dump completed on 2010-10-29  2:09:22
