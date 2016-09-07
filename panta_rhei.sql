-- MySQL dump 10.13  Distrib 5.1.41, for debian-linux-gnu (i486)
--
-- Host: localhost    Database: panta_rhei
-- ------------------------------------------------------
-- Server version	5.1.41-3ubuntu12.6
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `agent`
--

DROP TABLE IF EXISTS `agent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(200) COLLATE utf8_bin NOT NULL DEFAULT '',
  `lname` varchar(200) COLLATE utf8_bin NOT NULL DEFAULT '',
  `alternate_name` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `organization_name` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Unique_Agent` (`fname`,`lname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `agenttype`
--

DROP TABLE IF EXISTS `agenttype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agenttype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(200) COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `folder`
--

DROP TABLE IF EXISTS `folder`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `folder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `text_en` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `text_fr` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `text_de` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `text_nl` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `text_es` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `text_it` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `number`  varchar(5)   COLLATE utf8_bin DEFAULT '0' NOT NULL,
  `sort_order`   int(11)  COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  CONSTRAINT `folder_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `folder` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `folder_merge_history`
--

DROP TABLE IF EXISTS `folder_merge_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `folder_merge_history` (
  `source_folder_id` int(11) NOT NULL DEFAULT '0',
  `dest_folder_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`source_folder_id`,`dest_folder_id`),
  KEY `source_folder_id` (`source_folder_id`),
  KEY `dest_folder_id` (`dest_folder_id`),
  CONSTRAINT `folder_merge_history_ibfk_2` FOREIGN KEY (`dest_folder_id`) REFERENCES `folder` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `folder_reference`
--

DROP TABLE IF EXISTS `folder_reference`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `folder_reference` (
  `folder_id` int(11) NOT NULL DEFAULT '0',
  `reference_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`folder_id`,`reference_id`),
  KEY `reference_id` (`reference_id`),
  CONSTRAINT `folder_reference_ibfk_1` FOREIGN KEY (`folder_id`) REFERENCES `folder` (`id`) ON DELETE CASCADE,
  CONSTRAINT `folder_reference_ibfk_2` FOREIGN KEY (`reference_id`) REFERENCES `folder` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `publisher`
--

DROP TABLE IF EXISTS `publisher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `publisher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Unique_Publisher` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `publisher_location`
--

DROP TABLE IF EXISTS `publisher_location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `publisher_location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `publisher_id` int(11) NOT NULL DEFAULT '0',
  `location` varchar(100) COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `publisher_id` (`publisher_id`),
  CONSTRAINT `publisher_location_ibfk_1` FOREIGN KEY (`publisher_id`) REFERENCES `publisher` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_bin NOT NULL DEFAULT '',
  `username` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '',
  `password` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '',
  `language` char(2) COLLATE utf8_bin NOT NULL DEFAULT 'en',
  `level` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `work`
--

DROP TABLE IF EXISTS `work`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `work` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `work_id` int(11) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `subtitle` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `paralleltitle` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `description` text COLLATE utf8_bin,
  `create_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `create_user_id` int(11) DEFAULT NULL,
  `modify_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modify_user_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `publish_year` int(11) DEFAULT NULL,
  `publish_month` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `work_id` (`work_id`),
  KEY `type_id` (`type_id`),
  KEY `create_user_id` (`create_user_id`),
  KEY `modify_user_id` (`modify_user_id`),
  CONSTRAINT `work_ibfk_5` FOREIGN KEY (`work_id`) REFERENCES `work` (`id`) ON DELETE SET NULL,
  CONSTRAINT `work_ibfk_6` FOREIGN KEY (`type_id`) REFERENCES `worktype` (`id`) ON DELETE SET NULL,
  CONSTRAINT `work_ibfk_7` FOREIGN KEY (`create_user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL,
  CONSTRAINT `work_ibfk_8` FOREIGN KEY (`modify_user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `work_agent`
--

DROP TABLE IF EXISTS `work_agent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `work_agent` (
  `work_id` int(11) NOT NULL DEFAULT '0',
  `agent_id` int(11) NOT NULL DEFAULT '0',
  `agenttype_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`work_id`,`agent_id`,`agenttype_id`),
  KEY `agent_id` (`agent_id`),
  KEY `agenttype_id` (`agenttype_id`),
  CONSTRAINT `work_agent_ibfk_1` FOREIGN KEY (`work_id`) REFERENCES `work` (`id`) ON DELETE CASCADE,
  CONSTRAINT `work_agent_ibfk_2` FOREIGN KEY (`agent_id`) REFERENCES `agent` (`id`) ON DELETE CASCADE,
  CONSTRAINT `work_agent_ibfk_3` FOREIGN KEY (`agenttype_id`) REFERENCES `agenttype` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `work_folder`
--

DROP TABLE IF EXISTS `work_folder`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `work_folder` (
  `work_id` int(11) NOT NULL DEFAULT '0',
  `folder_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`work_id`,`folder_id`),
  KEY `work_id` (`work_id`),
  KEY `folder_id` (`folder_id`),
  CONSTRAINT `work_folder_ibfk_2` FOREIGN KEY (`work_id`) REFERENCES `work` (`id`) ON DELETE CASCADE,
  CONSTRAINT `work_folder_ibfk_3` FOREIGN KEY (`folder_id`) REFERENCES `folder` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `work_publisher`
--

DROP TABLE IF EXISTS `work_publisher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `work_publisher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `work_id` int(11) NOT NULL DEFAULT '0',
  `publisher_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `publish_month` int(11) DEFAULT NULL,
  `publish_year` int(4) DEFAULT NULL,
  `publish_month_end` int(11) DEFAULT NULL,
  `publish_year_end` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `publisher_id` (`publisher_id`),
  KEY `location_id` (`location_id`),
  KEY `work_id` (`work_id`),
  CONSTRAINT `work_publisher_ibfk_6` FOREIGN KEY (`work_id`) REFERENCES `work` (`id`) ON DELETE CASCADE,
  CONSTRAINT `work_publisher_ibfk_7` FOREIGN KEY (`publisher_id`) REFERENCES `publisher` (`id`) ON DELETE CASCADE,
  CONSTRAINT `work_publisher_ibfk_8` FOREIGN KEY (`location_id`) REFERENCES `publisher_location` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `work_workattribute`
--

DROP TABLE IF EXISTS `work_workattribute`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `work_workattribute` (
  `work_id` int(11) NOT NULL DEFAULT '0',
  `workattribute_id` int(11) NOT NULL DEFAULT '0',
  `value` text COLLATE utf8_bin,
  PRIMARY KEY (`work_id`,`workattribute_id`),
  KEY `workattribute_id` (`workattribute_id`),
  CONSTRAINT `work_workattribute_ibfk_1` FOREIGN KEY (`work_id`) REFERENCES `work` (`id`) ON DELETE CASCADE,
  CONSTRAINT `work_workattribute_ibfk_2` FOREIGN KEY (`workattribute_id`) REFERENCES `workattribute` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `workattribute`
--

DROP TABLE IF EXISTS `workattribute`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `workattribute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field` varchar(200) COLLATE utf8_bin NOT NULL DEFAULT '',
  `type` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT 'Text',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `workattribute_option`
--

DROP TABLE IF EXISTS `workattribute_option`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `workattribute_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `workattribute_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(200) COLLATE utf8_bin NOT NULL DEFAULT '',
  `value` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `worktype`
--

DROP TABLE IF EXISTS `worktype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `worktype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(200) COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `worktype_workattribute`
--

DROP TABLE IF EXISTS `worktype_workattribute`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `worktype_workattribute` (
  `worktype_id` int(11) NOT NULL DEFAULT '0',
  `workattribute_id` int(11) NOT NULL DEFAULT '0',
  `rank` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`worktype_id`,`workattribute_id`),
  CONSTRAINT `worktype_workattribute_ibfk_1` FOREIGN KEY (`worktype_id`) REFERENCES `worktype` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

