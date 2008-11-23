-- MySQL dump 10.11
--
-- Host: localhost    Database: mantis
-- ------------------------------------------------------
-- Server version	5.0.51a-3ubuntu5.4

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
-- Table structure for table `mantisrest_test_bug_file_table`
--

DROP TABLE IF EXISTS `mantisrest_test_bug_file_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test_bug_file_table` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `bug_id` int(10) unsigned NOT NULL default '0',
  `title` varchar(250) NOT NULL default '',
  `description` varchar(250) NOT NULL default '',
  `diskfile` varchar(250) NOT NULL default '',
  `filename` varchar(250) NOT NULL default '',
  `folder` varchar(250) NOT NULL default '',
  `filesize` int(11) NOT NULL default '0',
  `file_type` varchar(250) NOT NULL default '',
  `date_added` datetime NOT NULL default '1970-01-01 00:00:01',
  `content` longblob,
  PRIMARY KEY  (`id`),
  KEY `idx_bug_file_bug_id` (`bug_id`),
  KEY `idx_diskfile` (`diskfile`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test_bug_file_table`
--

LOCK TABLES `mantisrest_test_bug_file_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test_bug_file_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantisrest_test_bug_file_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test_bug_history_table`
--

DROP TABLE IF EXISTS `mantisrest_test_bug_history_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test_bug_history_table` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL default '0',
  `bug_id` int(10) unsigned NOT NULL default '0',
  `date_modified` datetime NOT NULL default '1970-01-01 00:00:01',
  `field_name` varchar(64) NOT NULL,
  `old_value` varchar(255) NOT NULL,
  `new_value` varchar(255) NOT NULL,
  `type` smallint(6) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `idx_bug_history_bug_id` (`bug_id`),
  KEY `idx_history_user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=71 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test_bug_history_table`
--

LOCK TABLES `mantisrest_test_bug_history_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test_bug_history_table` DISABLE KEYS */;
INSERT INTO `mantisrest_test_bug_history_table` VALUES (1,2,1,'2008-09-30 22:27:33','','','',1),(2,2,2,'2008-10-08 21:42:56','','','',1),(3,2,1,'2008-10-08 22:47:42','','0000001','',2),(4,2,1,'2008-10-14 23:17:40','handler_id','0','3',0),(5,2,1,'2008-10-14 23:39:56','handler_id','3','4',0),(6,2,1,'2008-10-18 14:50:39','reporter_id','2','3',0),(7,2,1,'2008-10-18 16:57:53','reporter_id','3','2',0),(8,2,1,'2008-11-10 15:28:21','priority','30','20',0),(9,2,1,'2008-11-10 15:41:23','duplicate_id','0','',0),(10,2,1,'2008-11-10 15:41:23','priority','20','-1',0),(11,2,1,'2008-11-10 15:41:23','severity','50','-1',0),(12,2,1,'2008-11-10 15:41:23','reproducibility','70','-1',0),(13,2,1,'2008-11-10 15:41:23','status','10','-1',0),(14,2,1,'2008-11-10 15:41:23','resolution','10','-1',0),(15,2,1,'2008-11-10 15:41:23','projection','10','-1',0),(16,2,1,'2008-11-10 15:43:57','duplicate_id','0','',0),(17,2,1,'2008-11-10 15:44:18','duplicate_id','0','',0),(18,2,1,'2008-11-10 15:44:52','duplicate_id','0','',0),(19,2,1,'2008-11-10 15:45:15','duplicate_id','0','',0),(20,2,1,'2008-11-10 15:47:05','duplicate_id','0','',0),(21,2,1,'2008-11-10 15:49:45','duplicate_id','0','',0),(22,2,1,'2008-11-10 15:55:18','duplicate_id','0','',0),(23,2,1,'2008-11-10 15:55:18','priority','-1','50',0),(24,2,1,'2008-11-10 15:55:18','severity','-1','10',0),(25,2,1,'2008-11-10 15:55:18','reproducibility','-1','10',0),(26,2,1,'2008-11-10 15:55:18','status','-1','50',0),(27,2,1,'2008-11-10 15:55:18','resolution','-1','10',0),(28,2,1,'2008-11-10 15:55:18','projection','-1','30',0),(29,2,1,'2008-11-10 15:57:32','duplicate_id','0','',0),(30,2,1,'2008-11-10 15:59:03','duplicate_id','0','',0),(31,2,1,'2008-11-10 15:59:03','','','',6),(32,2,1,'2008-11-10 15:59:03','','','',7),(33,2,1,'2008-11-11 21:28:27','','0000001','',3),(34,2,1,'2008-11-11 21:30:06','','0000001','',3),(35,2,1,'2008-11-11 21:30:35','','0000001','',3),(36,2,1,'2008-11-11 21:32:09','','0000001','',3),(37,2,1,'2008-11-11 21:44:42','','0000001','',3),(38,2,1,'2008-11-11 21:45:03','','0000001','',3),(39,2,1,'2008-11-12 10:55:32','','0000001','',3),(40,2,1,'2008-11-12 21:55:36','','0000001','',3),(41,2,1,'2008-11-15 21:35:32','','0000001','',3),(42,2,1,'2008-11-15 21:44:27','','0000001','',3),(43,2,1,'2008-11-15 21:46:35','','0000001','',3),(44,2,1,'2008-11-15 22:03:32','','0000001','',3),(45,2,1,'2008-11-16 12:19:01','eta','10','40',0),(46,2,1,'2008-11-16 12:19:01','','','',6),(47,2,1,'2008-11-18 21:30:49','status','50','30',0),(48,2,1,'2008-11-18 21:30:49','','','',6),(49,2,1,'2008-11-18 22:39:12','','0000001','',3),(50,2,1,'2008-11-18 23:11:55','','0000002','',2),(51,2,1,'2008-11-18 23:12:44','','0000002','',4),(52,2,1,'2008-11-18 23:13:53','','0000003','',2),(53,2,1,'2008-11-18 23:18:17','','0000004','',2),(54,2,1,'2008-11-18 23:19:15','','0000005','',2),(55,2,1,'2008-11-18 23:19:22','','0000004','',4),(56,2,1,'2008-11-18 23:19:27','','0000003','',4),(57,2,1,'2008-11-18 23:19:31','','0000005','',4),(58,2,1,'2008-11-18 23:26:12','','0000006','',2),(70,2,1,'2008-11-22 22:15:04','','0000008','',2),(69,2,2,'2008-11-22 22:14:20','','0000007','',2);
/*!40000 ALTER TABLE `mantisrest_test_bug_history_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test_bug_monitor_table`
--

DROP TABLE IF EXISTS `mantisrest_test_bug_monitor_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test_bug_monitor_table` (
  `user_id` int(10) unsigned NOT NULL default '0',
  `bug_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`bug_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test_bug_monitor_table`
--

LOCK TABLES `mantisrest_test_bug_monitor_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test_bug_monitor_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantisrest_test_bug_monitor_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test_bug_relationship_table`
--

DROP TABLE IF EXISTS `mantisrest_test_bug_relationship_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test_bug_relationship_table` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `source_bug_id` int(10) unsigned NOT NULL default '0',
  `destination_bug_id` int(10) unsigned NOT NULL default '0',
  `relationship_type` smallint(6) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `idx_relationship_source` (`source_bug_id`),
  KEY `idx_relationship_destination` (`destination_bug_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test_bug_relationship_table`
--

LOCK TABLES `mantisrest_test_bug_relationship_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test_bug_relationship_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantisrest_test_bug_relationship_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test_bug_table`
--

DROP TABLE IF EXISTS `mantisrest_test_bug_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test_bug_table` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `project_id` int(10) unsigned NOT NULL default '0',
  `reporter_id` int(10) unsigned NOT NULL default '0',
  `handler_id` int(10) unsigned NOT NULL default '0',
  `duplicate_id` int(10) unsigned NOT NULL default '0',
  `priority` smallint(6) NOT NULL default '30',
  `severity` smallint(6) NOT NULL default '50',
  `reproducibility` smallint(6) NOT NULL default '10',
  `status` smallint(6) NOT NULL default '10',
  `resolution` smallint(6) NOT NULL default '10',
  `projection` smallint(6) NOT NULL default '10',
  `category` varchar(64) NOT NULL default '',
  `date_submitted` datetime NOT NULL default '1970-01-01 00:00:01',
  `last_updated` datetime NOT NULL default '1970-01-01 00:00:01',
  `eta` smallint(6) NOT NULL default '10',
  `bug_text_id` int(10) unsigned NOT NULL default '0',
  `os` varchar(32) NOT NULL default '',
  `os_build` varchar(32) NOT NULL default '',
  `platform` varchar(32) NOT NULL default '',
  `version` varchar(64) NOT NULL default '',
  `fixed_in_version` varchar(64) NOT NULL default '',
  `build` varchar(32) NOT NULL default '',
  `profile_id` int(10) unsigned NOT NULL default '0',
  `view_state` smallint(6) NOT NULL default '10',
  `summary` varchar(128) NOT NULL default '',
  `sponsorship_total` int(11) NOT NULL default '0',
  `sticky` tinyint(4) NOT NULL default '0',
  `target_version` varchar(64) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `idx_bug_sponsorship_total` (`sponsorship_total`),
  KEY `idx_bug_fixed_in_version` (`fixed_in_version`),
  KEY `idx_bug_status` (`status`),
  KEY `idx_project` (`project_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test_bug_table`
--

LOCK TABLES `mantisrest_test_bug_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test_bug_table` DISABLE KEYS */;
INSERT INTO `mantisrest_test_bug_table` VALUES (1,1,2,4,0,50,10,10,30,10,30,'','2008-09-30 22:27:33','2008-11-22 22:15:04',40,1,'','','','','','',0,10,'Swizzle',0,0,''),(2,2,2,0,0,60,50,70,10,10,10,'','2008-10-08 21:42:56','2008-11-22 22:14:20',10,2,'','','','','','',0,10,'FIX IT',0,0,'');
/*!40000 ALTER TABLE `mantisrest_test_bug_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test_bug_tag_table`
--

DROP TABLE IF EXISTS `mantisrest_test_bug_tag_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test_bug_tag_table` (
  `bug_id` int(10) unsigned NOT NULL default '0',
  `tag_id` int(10) unsigned NOT NULL default '0',
  `user_id` int(10) unsigned NOT NULL default '0',
  `date_attached` datetime NOT NULL default '1970-01-01 00:00:01',
  PRIMARY KEY  (`bug_id`,`tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test_bug_tag_table`
--

LOCK TABLES `mantisrest_test_bug_tag_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test_bug_tag_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantisrest_test_bug_tag_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test_bug_text_table`
--

DROP TABLE IF EXISTS `mantisrest_test_bug_text_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test_bug_text_table` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `description` longtext NOT NULL,
  `steps_to_reproduce` longtext NOT NULL,
  `additional_information` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test_bug_text_table`
--

LOCK TABLES `mantisrest_test_bug_text_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test_bug_text_table` DISABLE KEYS */;
INSERT INTO `mantisrest_test_bug_text_table` VALUES (1,'Bitches hey','','Oh noes!  A bug!'),(2,'Fix it fix it fix it','','');
/*!40000 ALTER TABLE `mantisrest_test_bug_text_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test_bugnote_table`
--

DROP TABLE IF EXISTS `mantisrest_test_bugnote_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test_bugnote_table` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `bug_id` int(10) unsigned NOT NULL default '0',
  `reporter_id` int(10) unsigned NOT NULL default '0',
  `bugnote_text_id` int(10) unsigned NOT NULL default '0',
  `view_state` smallint(6) NOT NULL default '10',
  `date_submitted` datetime NOT NULL default '1970-01-01 00:00:01',
  `last_modified` datetime NOT NULL default '1970-01-01 00:00:01',
  `note_type` int(11) default '0',
  `note_attr` varchar(250) default '',
  `time_tracking` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `idx_bug` (`bug_id`),
  KEY `idx_last_mod` (`last_modified`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test_bugnote_table`
--

LOCK TABLES `mantisrest_test_bugnote_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test_bugnote_table` DISABLE KEYS */;
INSERT INTO `mantisrest_test_bugnote_table` VALUES (1,1,2,1,10,'2008-10-08 22:47:42','2008-11-18 22:39:12',0,'',0),(7,2,2,7,10,'2008-11-22 22:14:20','2008-11-22 22:14:20',0,'',0),(8,1,2,8,50,'2008-11-22 22:15:04','2008-11-22 22:15:04',0,'',0),(6,1,2,6,10,'2008-11-18 23:26:12','2008-11-18 23:26:12',0,'',0);
/*!40000 ALTER TABLE `mantisrest_test_bugnote_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test_bugnote_text_table`
--

DROP TABLE IF EXISTS `mantisrest_test_bugnote_text_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test_bugnote_text_table` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `note` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test_bugnote_text_table`
--

LOCK TABLES `mantisrest_test_bugnote_text_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test_bugnote_text_table` DISABLE KEYS */;
INSERT INTO `mantisrest_test_bugnote_text_table` VALUES (1,'Ring ring'),(7,'This note is in a restricted project.'),(6,'And introducing... another note!'),(8,'This note is private and reported by dan.');
/*!40000 ALTER TABLE `mantisrest_test_bugnote_text_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test_config_table`
--

DROP TABLE IF EXISTS `mantisrest_test_config_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test_config_table` (
  `config_id` varchar(64) NOT NULL,
  `project_id` int(11) NOT NULL default '0',
  `user_id` int(11) NOT NULL default '0',
  `access_reqd` int(11) default '0',
  `type` int(11) default '90',
  `value` longtext NOT NULL,
  PRIMARY KEY  (`config_id`,`project_id`,`user_id`),
  KEY `idx_config` (`config_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test_config_table`
--

LOCK TABLES `mantisrest_test_config_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test_config_table` DISABLE KEYS */;
INSERT INTO `mantisrest_test_config_table` VALUES ('database_version',0,0,90,1,'63');
/*!40000 ALTER TABLE `mantisrest_test_config_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test_custom_field_project_table`
--

DROP TABLE IF EXISTS `mantisrest_test_custom_field_project_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test_custom_field_project_table` (
  `field_id` int(11) NOT NULL default '0',
  `project_id` int(10) unsigned NOT NULL default '0',
  `sequence` smallint(6) NOT NULL default '0',
  PRIMARY KEY  (`field_id`,`project_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test_custom_field_project_table`
--

LOCK TABLES `mantisrest_test_custom_field_project_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test_custom_field_project_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantisrest_test_custom_field_project_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test_custom_field_string_table`
--

DROP TABLE IF EXISTS `mantisrest_test_custom_field_string_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test_custom_field_string_table` (
  `field_id` int(11) NOT NULL default '0',
  `bug_id` int(11) NOT NULL default '0',
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`field_id`,`bug_id`),
  KEY `idx_custom_field_bug` (`bug_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test_custom_field_string_table`
--

LOCK TABLES `mantisrest_test_custom_field_string_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test_custom_field_string_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantisrest_test_custom_field_string_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test_custom_field_table`
--

DROP TABLE IF EXISTS `mantisrest_test_custom_field_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test_custom_field_table` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(64) NOT NULL default '',
  `type` smallint(6) NOT NULL default '0',
  `possible_values` varchar(255) NOT NULL default '',
  `default_value` varchar(255) NOT NULL default '',
  `valid_regexp` varchar(255) NOT NULL default '',
  `access_level_r` smallint(6) NOT NULL default '0',
  `access_level_rw` smallint(6) NOT NULL default '0',
  `length_min` int(11) NOT NULL default '0',
  `length_max` int(11) NOT NULL default '0',
  `advanced` tinyint(4) NOT NULL default '0',
  `require_report` tinyint(4) NOT NULL default '0',
  `require_update` tinyint(4) NOT NULL default '0',
  `display_report` tinyint(4) NOT NULL default '1',
  `display_update` tinyint(4) NOT NULL default '1',
  `require_resolved` tinyint(4) NOT NULL default '0',
  `display_resolved` tinyint(4) NOT NULL default '0',
  `display_closed` tinyint(4) NOT NULL default '0',
  `require_closed` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `idx_custom_field_name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test_custom_field_table`
--

LOCK TABLES `mantisrest_test_custom_field_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test_custom_field_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantisrest_test_custom_field_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test_email_table`
--

DROP TABLE IF EXISTS `mantisrest_test_email_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test_email_table` (
  `email_id` int(10) unsigned NOT NULL auto_increment,
  `email` varchar(64) NOT NULL default '',
  `subject` varchar(250) NOT NULL default '',
  `submitted` datetime NOT NULL default '1970-01-01 00:00:01',
  `metadata` longtext NOT NULL,
  `body` longtext NOT NULL,
  PRIMARY KEY  (`email_id`),
  KEY `idx_email_id` (`email_id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test_email_table`
--

LOCK TABLES `mantisrest_test_email_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test_email_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantisrest_test_email_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test_filters_table`
--

DROP TABLE IF EXISTS `mantisrest_test_filters_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test_filters_table` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(11) NOT NULL default '0',
  `project_id` int(11) NOT NULL default '0',
  `is_public` tinyint(4) default NULL,
  `name` varchar(64) NOT NULL default '',
  `filter_string` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test_filters_table`
--

LOCK TABLES `mantisrest_test_filters_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test_filters_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantisrest_test_filters_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test_news_table`
--

DROP TABLE IF EXISTS `mantisrest_test_news_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test_news_table` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `project_id` int(10) unsigned NOT NULL default '0',
  `poster_id` int(10) unsigned NOT NULL default '0',
  `date_posted` datetime NOT NULL default '1970-01-01 00:00:01',
  `last_modified` datetime NOT NULL default '1970-01-01 00:00:01',
  `view_state` smallint(6) NOT NULL default '10',
  `announcement` tinyint(4) NOT NULL default '0',
  `headline` varchar(64) NOT NULL default '',
  `body` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test_news_table`
--

LOCK TABLES `mantisrest_test_news_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test_news_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantisrest_test_news_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test_project_category_table`
--

DROP TABLE IF EXISTS `mantisrest_test_project_category_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test_project_category_table` (
  `project_id` int(10) unsigned NOT NULL default '0',
  `category` varchar(64) NOT NULL default '',
  `user_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`project_id`,`category`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test_project_category_table`
--

LOCK TABLES `mantisrest_test_project_category_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test_project_category_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantisrest_test_project_category_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test_project_file_table`
--

DROP TABLE IF EXISTS `mantisrest_test_project_file_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test_project_file_table` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `project_id` int(10) unsigned NOT NULL default '0',
  `title` varchar(250) NOT NULL default '',
  `description` varchar(250) NOT NULL default '',
  `diskfile` varchar(250) NOT NULL default '',
  `filename` varchar(250) NOT NULL default '',
  `folder` varchar(250) NOT NULL default '',
  `filesize` int(11) NOT NULL default '0',
  `file_type` varchar(250) NOT NULL default '',
  `date_added` datetime NOT NULL default '1970-01-01 00:00:01',
  `content` longblob,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test_project_file_table`
--

LOCK TABLES `mantisrest_test_project_file_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test_project_file_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantisrest_test_project_file_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test_project_hierarchy_table`
--

DROP TABLE IF EXISTS `mantisrest_test_project_hierarchy_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test_project_hierarchy_table` (
  `child_id` int(10) unsigned NOT NULL,
  `parent_id` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test_project_hierarchy_table`
--

LOCK TABLES `mantisrest_test_project_hierarchy_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test_project_hierarchy_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantisrest_test_project_hierarchy_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test_project_table`
--

DROP TABLE IF EXISTS `mantisrest_test_project_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test_project_table` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(128) NOT NULL default '',
  `status` smallint(6) NOT NULL default '10',
  `enabled` tinyint(4) NOT NULL default '1',
  `view_state` smallint(6) NOT NULL default '10',
  `access_min` smallint(6) NOT NULL default '10',
  `file_path` varchar(250) NOT NULL default '',
  `description` longtext NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `idx_project_name` (`name`),
  KEY `idx_project_id` (`id`),
  KEY `idx_project_view` (`view_state`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test_project_table`
--

LOCK TABLES `mantisrest_test_project_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test_project_table` DISABLE KEYS */;
INSERT INTO `mantisrest_test_project_table` VALUES (1,'crap_project',10,1,10,10,'',''),(2,'restricted_project',10,1,50,10,'','');
/*!40000 ALTER TABLE `mantisrest_test_project_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test_project_user_list_table`
--

DROP TABLE IF EXISTS `mantisrest_test_project_user_list_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test_project_user_list_table` (
  `project_id` int(10) unsigned NOT NULL default '0',
  `user_id` int(10) unsigned NOT NULL default '0',
  `access_level` smallint(6) NOT NULL default '10',
  PRIMARY KEY  (`project_id`,`user_id`),
  KEY `idx_project_user` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test_project_user_list_table`
--

LOCK TABLES `mantisrest_test_project_user_list_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test_project_user_list_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantisrest_test_project_user_list_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test_project_version_table`
--

DROP TABLE IF EXISTS `mantisrest_test_project_version_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test_project_version_table` (
  `id` int(11) NOT NULL auto_increment,
  `project_id` int(10) unsigned NOT NULL default '0',
  `version` varchar(64) NOT NULL default '',
  `date_order` datetime NOT NULL default '1970-01-01 00:00:01',
  `description` longtext NOT NULL,
  `released` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `idx_project_version` (`project_id`,`version`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test_project_version_table`
--

LOCK TABLES `mantisrest_test_project_version_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test_project_version_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantisrest_test_project_version_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test_sponsorship_table`
--

DROP TABLE IF EXISTS `mantisrest_test_sponsorship_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test_sponsorship_table` (
  `id` int(11) NOT NULL auto_increment,
  `bug_id` int(11) NOT NULL default '0',
  `user_id` int(11) NOT NULL default '0',
  `amount` int(11) NOT NULL default '0',
  `logo` varchar(128) NOT NULL default '',
  `url` varchar(128) NOT NULL default '',
  `paid` tinyint(4) NOT NULL default '0',
  `date_submitted` datetime NOT NULL default '1970-01-01 00:00:01',
  `last_updated` datetime NOT NULL default '1970-01-01 00:00:01',
  PRIMARY KEY  (`id`),
  KEY `idx_sponsorship_bug_id` (`bug_id`),
  KEY `idx_sponsorship_user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test_sponsorship_table`
--

LOCK TABLES `mantisrest_test_sponsorship_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test_sponsorship_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantisrest_test_sponsorship_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test_tag_table`
--

DROP TABLE IF EXISTS `mantisrest_test_tag_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test_tag_table` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL default '0',
  `name` varchar(100) NOT NULL default '',
  `description` longtext NOT NULL,
  `date_created` datetime NOT NULL default '1970-01-01 00:00:01',
  `date_updated` datetime NOT NULL default '1970-01-01 00:00:01',
  PRIMARY KEY  (`id`,`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test_tag_table`
--

LOCK TABLES `mantisrest_test_tag_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test_tag_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantisrest_test_tag_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test_tokens_table`
--

DROP TABLE IF EXISTS `mantisrest_test_tokens_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test_tokens_table` (
  `id` int(11) NOT NULL auto_increment,
  `owner` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `timestamp` datetime NOT NULL,
  `expiry` datetime default NULL,
  `value` longtext NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `idx_typeowner` (`type`,`owner`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test_tokens_table`
--

LOCK TABLES `mantisrest_test_tokens_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test_tokens_table` DISABLE KEYS */;
INSERT INTO `mantisrest_test_tokens_table` VALUES (38,2,4,'2008-11-22 22:12:42','2008-11-22 22:18:27','1'),(39,2,3,'2008-11-22 22:13:33','2008-11-23 22:15:06','1,2');
/*!40000 ALTER TABLE `mantisrest_test_tokens_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test_user_pref_table`
--

DROP TABLE IF EXISTS `mantisrest_test_user_pref_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test_user_pref_table` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL default '0',
  `project_id` int(10) unsigned NOT NULL default '0',
  `default_profile` int(10) unsigned NOT NULL default '0',
  `default_project` int(10) unsigned NOT NULL default '0',
  `advanced_report` tinyint(4) NOT NULL default '0',
  `advanced_view` tinyint(4) NOT NULL default '0',
  `advanced_update` tinyint(4) NOT NULL default '0',
  `refresh_delay` int(11) NOT NULL default '0',
  `redirect_delay` tinyint(4) NOT NULL default '0',
  `bugnote_order` varchar(4) NOT NULL default 'ASC',
  `email_on_new` tinyint(4) NOT NULL default '0',
  `email_on_assigned` tinyint(4) NOT NULL default '0',
  `email_on_feedback` tinyint(4) NOT NULL default '0',
  `email_on_resolved` tinyint(4) NOT NULL default '0',
  `email_on_closed` tinyint(4) NOT NULL default '0',
  `email_on_reopened` tinyint(4) NOT NULL default '0',
  `email_on_bugnote` tinyint(4) NOT NULL default '0',
  `email_on_status` tinyint(4) NOT NULL default '0',
  `email_on_priority` tinyint(4) NOT NULL default '0',
  `email_on_priority_min_severity` smallint(6) NOT NULL default '10',
  `email_on_status_min_severity` smallint(6) NOT NULL default '10',
  `email_on_bugnote_min_severity` smallint(6) NOT NULL default '10',
  `email_on_reopened_min_severity` smallint(6) NOT NULL default '10',
  `email_on_closed_min_severity` smallint(6) NOT NULL default '10',
  `email_on_resolved_min_severity` smallint(6) NOT NULL default '10',
  `email_on_feedback_min_severity` smallint(6) NOT NULL default '10',
  `email_on_assigned_min_severity` smallint(6) NOT NULL default '10',
  `email_on_new_min_severity` smallint(6) NOT NULL default '10',
  `email_bugnote_limit` smallint(6) NOT NULL default '0',
  `language` varchar(32) NOT NULL default 'english',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test_user_pref_table`
--

LOCK TABLES `mantisrest_test_user_pref_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test_user_pref_table` DISABLE KEYS */;
INSERT INTO `mantisrest_test_user_pref_table` VALUES (1,2,0,0,0,0,0,0,30,2,'ASC',1,1,1,1,1,1,1,0,0,0,0,0,0,0,0,0,0,0,0,'english'),(2,1,0,0,0,0,0,0,30,2,'ASC',1,1,1,1,1,1,1,0,0,0,0,0,0,0,0,0,0,0,0,'english'),(3,3,0,0,0,0,0,0,30,2,'ASC',1,1,1,1,1,1,1,0,0,0,0,0,0,0,0,0,0,0,0,'english'),(4,4,0,0,0,0,0,0,30,2,'ASC',1,1,1,1,1,1,1,0,0,0,0,0,0,0,0,0,0,0,0,'english');
/*!40000 ALTER TABLE `mantisrest_test_user_pref_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test_user_print_pref_table`
--

DROP TABLE IF EXISTS `mantisrest_test_user_print_pref_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test_user_print_pref_table` (
  `user_id` int(10) unsigned NOT NULL default '0',
  `print_pref` varchar(64) NOT NULL,
  PRIMARY KEY  (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test_user_print_pref_table`
--

LOCK TABLES `mantisrest_test_user_print_pref_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test_user_print_pref_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantisrest_test_user_print_pref_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test_user_profile_table`
--

DROP TABLE IF EXISTS `mantisrest_test_user_profile_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test_user_profile_table` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL default '0',
  `platform` varchar(32) NOT NULL default '',
  `os` varchar(32) NOT NULL default '',
  `os_build` varchar(32) NOT NULL default '',
  `description` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test_user_profile_table`
--

LOCK TABLES `mantisrest_test_user_profile_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test_user_profile_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantisrest_test_user_profile_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test_user_table`
--

DROP TABLE IF EXISTS `mantisrest_test_user_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test_user_table` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `username` varchar(32) NOT NULL default '',
  `realname` varchar(64) NOT NULL default '',
  `email` varchar(64) NOT NULL default '',
  `password` varchar(32) NOT NULL default '',
  `date_created` datetime NOT NULL default '1970-01-01 00:00:01',
  `last_visit` datetime NOT NULL default '1970-01-01 00:00:01',
  `enabled` tinyint(4) NOT NULL default '1',
  `protected` tinyint(4) NOT NULL default '0',
  `access_level` smallint(6) NOT NULL default '10',
  `login_count` int(11) NOT NULL default '0',
  `lost_password_request_count` smallint(6) NOT NULL default '0',
  `failed_login_count` smallint(6) NOT NULL default '0',
  `cookie_string` varchar(64) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `idx_user_cookie_string` (`cookie_string`),
  UNIQUE KEY `idx_user_username` (`username`),
  KEY `idx_enable` (`enabled`),
  KEY `idx_access` (`access_level`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test_user_table`
--

LOCK TABLES `mantisrest_test_user_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test_user_table` DISABLE KEYS */;
INSERT INTO `mantisrest_test_user_table` VALUES (1,'administrator','','root@localhost','63a9f0ea7bb98050796b649e85481845','2008-09-29 22:09:41','2008-09-29 22:18:03',0,0,90,4,0,0,'e85315c61ede369081d9677978748d4de1ff1196e603461d8bdbc959a2a05798'),(2,'dan','whatever','dan@localhost','9180b4da3f0c7e80975fad685f7f134e','2008-09-29 22:15:27','2008-11-22 22:15:06',1,0,90,23,0,0,'37a1ae17a2985588c3ffd592bbae8a411cb2de6e697b5171fb5d20affd31e176'),(3,'nobody','what','dan@localhost','6e854442cd2a940c9e95941dce4ad598','2008-10-04 16:20:14','2008-10-04 16:22:00',1,0,25,1,0,0,'25a362b154a2144bf3ffcaf2f11722c87b3ec6e67e891b183ef8e7213d5263db'),(4,'somebody','yup','dan@mantis.localhost','78b9d09661da64f0bc6c146c524bae4a','2008-10-04 22:56:53','2008-11-18 21:26:02',1,0,55,6,0,0,'af704e3bfd9c3bae5beebc2c732d7840ffab78d1f5754ffabe9b0ee9c0cfa707');
/*!40000 ALTER TABLE `mantisrest_test_user_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test__bug_file_table`
--

DROP TABLE IF EXISTS `mantisrest_test__bug_file_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test__bug_file_table` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `bug_id` int(10) unsigned NOT NULL default '0',
  `title` varchar(250) NOT NULL default '',
  `description` varchar(250) NOT NULL default '',
  `diskfile` varchar(250) NOT NULL default '',
  `filename` varchar(250) NOT NULL default '',
  `folder` varchar(250) NOT NULL default '',
  `filesize` int(11) NOT NULL default '0',
  `file_type` varchar(250) NOT NULL default '',
  `date_added` datetime NOT NULL default '1970-01-01 00:00:01',
  `content` longblob,
  PRIMARY KEY  (`id`),
  KEY `idx_bug_file_bug_id` (`bug_id`),
  KEY `idx_diskfile` (`diskfile`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test__bug_file_table`
--

LOCK TABLES `mantisrest_test__bug_file_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test__bug_file_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantisrest_test__bug_file_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test__bug_history_table`
--

DROP TABLE IF EXISTS `mantisrest_test__bug_history_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test__bug_history_table` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL default '0',
  `bug_id` int(10) unsigned NOT NULL default '0',
  `date_modified` datetime NOT NULL default '1970-01-01 00:00:01',
  `field_name` varchar(64) NOT NULL,
  `old_value` varchar(255) NOT NULL,
  `new_value` varchar(255) NOT NULL,
  `type` smallint(6) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `idx_bug_history_bug_id` (`bug_id`),
  KEY `idx_history_user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=69 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test__bug_history_table`
--

LOCK TABLES `mantisrest_test__bug_history_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test__bug_history_table` DISABLE KEYS */;
INSERT INTO `mantisrest_test__bug_history_table` VALUES (1,2,1,'2008-09-30 22:27:33','','','',1),(2,2,2,'2008-10-08 21:42:56','','','',1),(3,2,1,'2008-10-08 22:47:42','','0000001','',2),(4,2,1,'2008-10-14 23:17:40','handler_id','0','3',0),(5,2,1,'2008-10-14 23:39:56','handler_id','3','4',0),(6,2,1,'2008-10-18 14:50:39','reporter_id','2','3',0),(7,2,1,'2008-10-18 16:57:53','reporter_id','3','2',0),(8,2,1,'2008-11-10 15:28:21','priority','30','20',0),(9,2,1,'2008-11-10 15:41:23','duplicate_id','0','',0),(10,2,1,'2008-11-10 15:41:23','priority','20','-1',0),(11,2,1,'2008-11-10 15:41:23','severity','50','-1',0),(12,2,1,'2008-11-10 15:41:23','reproducibility','70','-1',0),(13,2,1,'2008-11-10 15:41:23','status','10','-1',0),(14,2,1,'2008-11-10 15:41:23','resolution','10','-1',0),(15,2,1,'2008-11-10 15:41:23','projection','10','-1',0),(16,2,1,'2008-11-10 15:43:57','duplicate_id','0','',0),(17,2,1,'2008-11-10 15:44:18','duplicate_id','0','',0),(18,2,1,'2008-11-10 15:44:52','duplicate_id','0','',0),(19,2,1,'2008-11-10 15:45:15','duplicate_id','0','',0),(20,2,1,'2008-11-10 15:47:05','duplicate_id','0','',0),(21,2,1,'2008-11-10 15:49:45','duplicate_id','0','',0),(22,2,1,'2008-11-10 15:55:18','duplicate_id','0','',0),(23,2,1,'2008-11-10 15:55:18','priority','-1','50',0),(24,2,1,'2008-11-10 15:55:18','severity','-1','10',0),(25,2,1,'2008-11-10 15:55:18','reproducibility','-1','10',0),(26,2,1,'2008-11-10 15:55:18','status','-1','50',0),(27,2,1,'2008-11-10 15:55:18','resolution','-1','10',0),(28,2,1,'2008-11-10 15:55:18','projection','-1','30',0),(29,2,1,'2008-11-10 15:57:32','duplicate_id','0','',0),(30,2,1,'2008-11-10 15:59:03','duplicate_id','0','',0),(31,2,1,'2008-11-10 15:59:03','','','',6),(32,2,1,'2008-11-10 15:59:03','','','',7),(33,2,1,'2008-11-11 21:28:27','','0000001','',3),(34,2,1,'2008-11-11 21:30:06','','0000001','',3),(35,2,1,'2008-11-11 21:30:35','','0000001','',3),(36,2,1,'2008-11-11 21:32:09','','0000001','',3),(37,2,1,'2008-11-11 21:44:42','','0000001','',3),(38,2,1,'2008-11-11 21:45:03','','0000001','',3),(39,2,1,'2008-11-12 10:55:32','','0000001','',3),(40,2,1,'2008-11-12 21:55:36','','0000001','',3),(41,2,1,'2008-11-15 21:35:32','','0000001','',3),(42,2,1,'2008-11-15 21:44:27','','0000001','',3),(43,2,1,'2008-11-15 21:46:35','','0000001','',3),(44,2,1,'2008-11-15 22:03:32','','0000001','',3),(45,2,1,'2008-11-16 12:19:01','eta','10','40',0),(46,2,1,'2008-11-16 12:19:01','','','',6),(47,2,1,'2008-11-18 21:30:49','status','50','30',0),(48,2,1,'2008-11-18 21:30:49','','','',6),(49,2,1,'2008-11-18 22:39:12','','0000001','',3),(50,2,1,'2008-11-18 23:11:55','','0000002','',2),(51,2,1,'2008-11-18 23:12:44','','0000002','',4),(52,2,1,'2008-11-18 23:13:53','','0000003','',2),(53,2,1,'2008-11-18 23:18:17','','0000004','',2),(54,2,1,'2008-11-18 23:19:15','','0000005','',2),(55,2,1,'2008-11-18 23:19:22','','0000004','',4),(56,2,1,'2008-11-18 23:19:27','','0000003','',4),(57,2,1,'2008-11-18 23:19:31','','0000005','',4),(58,2,1,'2008-11-18 23:26:12','','0000006','',2);
/*!40000 ALTER TABLE `mantisrest_test__bug_history_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test__bug_monitor_table`
--

DROP TABLE IF EXISTS `mantisrest_test__bug_monitor_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test__bug_monitor_table` (
  `user_id` int(10) unsigned NOT NULL default '0',
  `bug_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`bug_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test__bug_monitor_table`
--

LOCK TABLES `mantisrest_test__bug_monitor_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test__bug_monitor_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantisrest_test__bug_monitor_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test__bug_relationship_table`
--

DROP TABLE IF EXISTS `mantisrest_test__bug_relationship_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test__bug_relationship_table` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `source_bug_id` int(10) unsigned NOT NULL default '0',
  `destination_bug_id` int(10) unsigned NOT NULL default '0',
  `relationship_type` smallint(6) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `idx_relationship_source` (`source_bug_id`),
  KEY `idx_relationship_destination` (`destination_bug_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test__bug_relationship_table`
--

LOCK TABLES `mantisrest_test__bug_relationship_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test__bug_relationship_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantisrest_test__bug_relationship_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test__bug_table`
--

DROP TABLE IF EXISTS `mantisrest_test__bug_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test__bug_table` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `project_id` int(10) unsigned NOT NULL default '0',
  `reporter_id` int(10) unsigned NOT NULL default '0',
  `handler_id` int(10) unsigned NOT NULL default '0',
  `duplicate_id` int(10) unsigned NOT NULL default '0',
  `priority` smallint(6) NOT NULL default '30',
  `severity` smallint(6) NOT NULL default '50',
  `reproducibility` smallint(6) NOT NULL default '10',
  `status` smallint(6) NOT NULL default '10',
  `resolution` smallint(6) NOT NULL default '10',
  `projection` smallint(6) NOT NULL default '10',
  `category` varchar(64) NOT NULL default '',
  `date_submitted` datetime NOT NULL default '1970-01-01 00:00:01',
  `last_updated` datetime NOT NULL default '1970-01-01 00:00:01',
  `eta` smallint(6) NOT NULL default '10',
  `bug_text_id` int(10) unsigned NOT NULL default '0',
  `os` varchar(32) NOT NULL default '',
  `os_build` varchar(32) NOT NULL default '',
  `platform` varchar(32) NOT NULL default '',
  `version` varchar(64) NOT NULL default '',
  `fixed_in_version` varchar(64) NOT NULL default '',
  `build` varchar(32) NOT NULL default '',
  `profile_id` int(10) unsigned NOT NULL default '0',
  `view_state` smallint(6) NOT NULL default '10',
  `summary` varchar(128) NOT NULL default '',
  `sponsorship_total` int(11) NOT NULL default '0',
  `sticky` tinyint(4) NOT NULL default '0',
  `target_version` varchar(64) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `idx_bug_sponsorship_total` (`sponsorship_total`),
  KEY `idx_bug_fixed_in_version` (`fixed_in_version`),
  KEY `idx_bug_status` (`status`),
  KEY `idx_project` (`project_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test__bug_table`
--

LOCK TABLES `mantisrest_test__bug_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test__bug_table` DISABLE KEYS */;
INSERT INTO `mantisrest_test__bug_table` VALUES (1,1,2,4,0,50,10,10,30,10,30,'','2008-09-30 22:27:33','2008-11-18 23:26:12',40,1,'','','','','','',0,10,'Swizzle',0,0,''),(2,2,2,0,0,60,50,70,10,10,10,'','2008-10-08 21:42:56','2008-10-08 21:42:56',10,2,'','','','','','',0,10,'FIX IT',0,0,'');
/*!40000 ALTER TABLE `mantisrest_test__bug_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test__bug_tag_table`
--

DROP TABLE IF EXISTS `mantisrest_test__bug_tag_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test__bug_tag_table` (
  `bug_id` int(10) unsigned NOT NULL default '0',
  `tag_id` int(10) unsigned NOT NULL default '0',
  `user_id` int(10) unsigned NOT NULL default '0',
  `date_attached` datetime NOT NULL default '1970-01-01 00:00:01',
  PRIMARY KEY  (`bug_id`,`tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test__bug_tag_table`
--

LOCK TABLES `mantisrest_test__bug_tag_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test__bug_tag_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantisrest_test__bug_tag_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test__bug_text_table`
--

DROP TABLE IF EXISTS `mantisrest_test__bug_text_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test__bug_text_table` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `description` longtext NOT NULL,
  `steps_to_reproduce` longtext NOT NULL,
  `additional_information` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test__bug_text_table`
--

LOCK TABLES `mantisrest_test__bug_text_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test__bug_text_table` DISABLE KEYS */;
INSERT INTO `mantisrest_test__bug_text_table` VALUES (1,'Bitches hey','','Oh noes!  A bug!'),(2,'Fix it fix it fix it','','');
/*!40000 ALTER TABLE `mantisrest_test__bug_text_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test__bugnote_table`
--

DROP TABLE IF EXISTS `mantisrest_test__bugnote_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test__bugnote_table` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `bug_id` int(10) unsigned NOT NULL default '0',
  `reporter_id` int(10) unsigned NOT NULL default '0',
  `bugnote_text_id` int(10) unsigned NOT NULL default '0',
  `view_state` smallint(6) NOT NULL default '10',
  `date_submitted` datetime NOT NULL default '1970-01-01 00:00:01',
  `last_modified` datetime NOT NULL default '1970-01-01 00:00:01',
  `note_type` int(11) default '0',
  `note_attr` varchar(250) default '',
  `time_tracking` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `idx_bug` (`bug_id`),
  KEY `idx_last_mod` (`last_modified`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test__bugnote_table`
--

LOCK TABLES `mantisrest_test__bugnote_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test__bugnote_table` DISABLE KEYS */;
INSERT INTO `mantisrest_test__bugnote_table` VALUES (1,1,2,1,10,'2008-10-08 22:47:42','2008-11-18 22:39:12',0,'',0),(6,1,2,6,10,'2008-11-18 23:26:12','2008-11-18 23:26:12',0,'',0);
/*!40000 ALTER TABLE `mantisrest_test__bugnote_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test__bugnote_text_table`
--

DROP TABLE IF EXISTS `mantisrest_test__bugnote_text_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test__bugnote_text_table` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `note` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test__bugnote_text_table`
--

LOCK TABLES `mantisrest_test__bugnote_text_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test__bugnote_text_table` DISABLE KEYS */;
INSERT INTO `mantisrest_test__bugnote_text_table` VALUES (1,'Ring ring'),(6,'And introducing... another note!');
/*!40000 ALTER TABLE `mantisrest_test__bugnote_text_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test__config_table`
--

DROP TABLE IF EXISTS `mantisrest_test__config_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test__config_table` (
  `config_id` varchar(64) NOT NULL,
  `project_id` int(11) NOT NULL default '0',
  `user_id` int(11) NOT NULL default '0',
  `access_reqd` int(11) default '0',
  `type` int(11) default '90',
  `value` longtext NOT NULL,
  PRIMARY KEY  (`config_id`,`project_id`,`user_id`),
  KEY `idx_config` (`config_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test__config_table`
--

LOCK TABLES `mantisrest_test__config_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test__config_table` DISABLE KEYS */;
INSERT INTO `mantisrest_test__config_table` VALUES ('database_version',0,0,90,1,'63');
/*!40000 ALTER TABLE `mantisrest_test__config_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test__custom_field_project_table`
--

DROP TABLE IF EXISTS `mantisrest_test__custom_field_project_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test__custom_field_project_table` (
  `field_id` int(11) NOT NULL default '0',
  `project_id` int(10) unsigned NOT NULL default '0',
  `sequence` smallint(6) NOT NULL default '0',
  PRIMARY KEY  (`field_id`,`project_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test__custom_field_project_table`
--

LOCK TABLES `mantisrest_test__custom_field_project_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test__custom_field_project_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantisrest_test__custom_field_project_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test__custom_field_string_table`
--

DROP TABLE IF EXISTS `mantisrest_test__custom_field_string_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test__custom_field_string_table` (
  `field_id` int(11) NOT NULL default '0',
  `bug_id` int(11) NOT NULL default '0',
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`field_id`,`bug_id`),
  KEY `idx_custom_field_bug` (`bug_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test__custom_field_string_table`
--

LOCK TABLES `mantisrest_test__custom_field_string_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test__custom_field_string_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantisrest_test__custom_field_string_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test__custom_field_table`
--

DROP TABLE IF EXISTS `mantisrest_test__custom_field_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test__custom_field_table` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(64) NOT NULL default '',
  `type` smallint(6) NOT NULL default '0',
  `possible_values` varchar(255) NOT NULL default '',
  `default_value` varchar(255) NOT NULL default '',
  `valid_regexp` varchar(255) NOT NULL default '',
  `access_level_r` smallint(6) NOT NULL default '0',
  `access_level_rw` smallint(6) NOT NULL default '0',
  `length_min` int(11) NOT NULL default '0',
  `length_max` int(11) NOT NULL default '0',
  `advanced` tinyint(4) NOT NULL default '0',
  `require_report` tinyint(4) NOT NULL default '0',
  `require_update` tinyint(4) NOT NULL default '0',
  `display_report` tinyint(4) NOT NULL default '1',
  `display_update` tinyint(4) NOT NULL default '1',
  `require_resolved` tinyint(4) NOT NULL default '0',
  `display_resolved` tinyint(4) NOT NULL default '0',
  `display_closed` tinyint(4) NOT NULL default '0',
  `require_closed` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `idx_custom_field_name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test__custom_field_table`
--

LOCK TABLES `mantisrest_test__custom_field_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test__custom_field_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantisrest_test__custom_field_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test__email_table`
--

DROP TABLE IF EXISTS `mantisrest_test__email_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test__email_table` (
  `email_id` int(10) unsigned NOT NULL auto_increment,
  `email` varchar(64) NOT NULL default '',
  `subject` varchar(250) NOT NULL default '',
  `submitted` datetime NOT NULL default '1970-01-01 00:00:01',
  `metadata` longtext NOT NULL,
  `body` longtext NOT NULL,
  PRIMARY KEY  (`email_id`),
  KEY `idx_email_id` (`email_id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test__email_table`
--

LOCK TABLES `mantisrest_test__email_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test__email_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantisrest_test__email_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test__filters_table`
--

DROP TABLE IF EXISTS `mantisrest_test__filters_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test__filters_table` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(11) NOT NULL default '0',
  `project_id` int(11) NOT NULL default '0',
  `is_public` tinyint(4) default NULL,
  `name` varchar(64) NOT NULL default '',
  `filter_string` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test__filters_table`
--

LOCK TABLES `mantisrest_test__filters_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test__filters_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantisrest_test__filters_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test__news_table`
--

DROP TABLE IF EXISTS `mantisrest_test__news_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test__news_table` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `project_id` int(10) unsigned NOT NULL default '0',
  `poster_id` int(10) unsigned NOT NULL default '0',
  `date_posted` datetime NOT NULL default '1970-01-01 00:00:01',
  `last_modified` datetime NOT NULL default '1970-01-01 00:00:01',
  `view_state` smallint(6) NOT NULL default '10',
  `announcement` tinyint(4) NOT NULL default '0',
  `headline` varchar(64) NOT NULL default '',
  `body` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test__news_table`
--

LOCK TABLES `mantisrest_test__news_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test__news_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantisrest_test__news_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test__project_category_table`
--

DROP TABLE IF EXISTS `mantisrest_test__project_category_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test__project_category_table` (
  `project_id` int(10) unsigned NOT NULL default '0',
  `category` varchar(64) NOT NULL default '',
  `user_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`project_id`,`category`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test__project_category_table`
--

LOCK TABLES `mantisrest_test__project_category_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test__project_category_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantisrest_test__project_category_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test__project_file_table`
--

DROP TABLE IF EXISTS `mantisrest_test__project_file_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test__project_file_table` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `project_id` int(10) unsigned NOT NULL default '0',
  `title` varchar(250) NOT NULL default '',
  `description` varchar(250) NOT NULL default '',
  `diskfile` varchar(250) NOT NULL default '',
  `filename` varchar(250) NOT NULL default '',
  `folder` varchar(250) NOT NULL default '',
  `filesize` int(11) NOT NULL default '0',
  `file_type` varchar(250) NOT NULL default '',
  `date_added` datetime NOT NULL default '1970-01-01 00:00:01',
  `content` longblob,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test__project_file_table`
--

LOCK TABLES `mantisrest_test__project_file_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test__project_file_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantisrest_test__project_file_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test__project_hierarchy_table`
--

DROP TABLE IF EXISTS `mantisrest_test__project_hierarchy_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test__project_hierarchy_table` (
  `child_id` int(10) unsigned NOT NULL,
  `parent_id` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test__project_hierarchy_table`
--

LOCK TABLES `mantisrest_test__project_hierarchy_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test__project_hierarchy_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantisrest_test__project_hierarchy_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test__project_table`
--

DROP TABLE IF EXISTS `mantisrest_test__project_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test__project_table` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(128) NOT NULL default '',
  `status` smallint(6) NOT NULL default '10',
  `enabled` tinyint(4) NOT NULL default '1',
  `view_state` smallint(6) NOT NULL default '10',
  `access_min` smallint(6) NOT NULL default '10',
  `file_path` varchar(250) NOT NULL default '',
  `description` longtext NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `idx_project_name` (`name`),
  KEY `idx_project_id` (`id`),
  KEY `idx_project_view` (`view_state`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test__project_table`
--

LOCK TABLES `mantisrest_test__project_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test__project_table` DISABLE KEYS */;
INSERT INTO `mantisrest_test__project_table` VALUES (1,'crap_project',10,1,10,10,'',''),(2,'restricted_project',10,1,50,10,'','');
/*!40000 ALTER TABLE `mantisrest_test__project_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test__project_user_list_table`
--

DROP TABLE IF EXISTS `mantisrest_test__project_user_list_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test__project_user_list_table` (
  `project_id` int(10) unsigned NOT NULL default '0',
  `user_id` int(10) unsigned NOT NULL default '0',
  `access_level` smallint(6) NOT NULL default '10',
  PRIMARY KEY  (`project_id`,`user_id`),
  KEY `idx_project_user` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test__project_user_list_table`
--

LOCK TABLES `mantisrest_test__project_user_list_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test__project_user_list_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantisrest_test__project_user_list_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test__project_version_table`
--

DROP TABLE IF EXISTS `mantisrest_test__project_version_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test__project_version_table` (
  `id` int(11) NOT NULL auto_increment,
  `project_id` int(10) unsigned NOT NULL default '0',
  `version` varchar(64) NOT NULL default '',
  `date_order` datetime NOT NULL default '1970-01-01 00:00:01',
  `description` longtext NOT NULL,
  `released` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `idx_project_version` (`project_id`,`version`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test__project_version_table`
--

LOCK TABLES `mantisrest_test__project_version_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test__project_version_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantisrest_test__project_version_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test__sponsorship_table`
--

DROP TABLE IF EXISTS `mantisrest_test__sponsorship_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test__sponsorship_table` (
  `id` int(11) NOT NULL auto_increment,
  `bug_id` int(11) NOT NULL default '0',
  `user_id` int(11) NOT NULL default '0',
  `amount` int(11) NOT NULL default '0',
  `logo` varchar(128) NOT NULL default '',
  `url` varchar(128) NOT NULL default '',
  `paid` tinyint(4) NOT NULL default '0',
  `date_submitted` datetime NOT NULL default '1970-01-01 00:00:01',
  `last_updated` datetime NOT NULL default '1970-01-01 00:00:01',
  PRIMARY KEY  (`id`),
  KEY `idx_sponsorship_bug_id` (`bug_id`),
  KEY `idx_sponsorship_user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test__sponsorship_table`
--

LOCK TABLES `mantisrest_test__sponsorship_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test__sponsorship_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantisrest_test__sponsorship_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test__tag_table`
--

DROP TABLE IF EXISTS `mantisrest_test__tag_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test__tag_table` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL default '0',
  `name` varchar(100) NOT NULL default '',
  `description` longtext NOT NULL,
  `date_created` datetime NOT NULL default '1970-01-01 00:00:01',
  `date_updated` datetime NOT NULL default '1970-01-01 00:00:01',
  PRIMARY KEY  (`id`,`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test__tag_table`
--

LOCK TABLES `mantisrest_test__tag_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test__tag_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantisrest_test__tag_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test__tokens_table`
--

DROP TABLE IF EXISTS `mantisrest_test__tokens_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test__tokens_table` (
  `id` int(11) NOT NULL auto_increment,
  `owner` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `timestamp` datetime NOT NULL,
  `expiry` datetime default NULL,
  `value` longtext NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `idx_typeowner` (`type`,`owner`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test__tokens_table`
--

LOCK TABLES `mantisrest_test__tokens_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test__tokens_table` DISABLE KEYS */;
INSERT INTO `mantisrest_test__tokens_table` VALUES (29,2,3,'2008-11-17 23:13:51','2008-11-20 21:18:55','4,3,1,2');
/*!40000 ALTER TABLE `mantisrest_test__tokens_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test__user_pref_table`
--

DROP TABLE IF EXISTS `mantisrest_test__user_pref_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test__user_pref_table` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL default '0',
  `project_id` int(10) unsigned NOT NULL default '0',
  `default_profile` int(10) unsigned NOT NULL default '0',
  `default_project` int(10) unsigned NOT NULL default '0',
  `advanced_report` tinyint(4) NOT NULL default '0',
  `advanced_view` tinyint(4) NOT NULL default '0',
  `advanced_update` tinyint(4) NOT NULL default '0',
  `refresh_delay` int(11) NOT NULL default '0',
  `redirect_delay` tinyint(4) NOT NULL default '0',
  `bugnote_order` varchar(4) NOT NULL default 'ASC',
  `email_on_new` tinyint(4) NOT NULL default '0',
  `email_on_assigned` tinyint(4) NOT NULL default '0',
  `email_on_feedback` tinyint(4) NOT NULL default '0',
  `email_on_resolved` tinyint(4) NOT NULL default '0',
  `email_on_closed` tinyint(4) NOT NULL default '0',
  `email_on_reopened` tinyint(4) NOT NULL default '0',
  `email_on_bugnote` tinyint(4) NOT NULL default '0',
  `email_on_status` tinyint(4) NOT NULL default '0',
  `email_on_priority` tinyint(4) NOT NULL default '0',
  `email_on_priority_min_severity` smallint(6) NOT NULL default '10',
  `email_on_status_min_severity` smallint(6) NOT NULL default '10',
  `email_on_bugnote_min_severity` smallint(6) NOT NULL default '10',
  `email_on_reopened_min_severity` smallint(6) NOT NULL default '10',
  `email_on_closed_min_severity` smallint(6) NOT NULL default '10',
  `email_on_resolved_min_severity` smallint(6) NOT NULL default '10',
  `email_on_feedback_min_severity` smallint(6) NOT NULL default '10',
  `email_on_assigned_min_severity` smallint(6) NOT NULL default '10',
  `email_on_new_min_severity` smallint(6) NOT NULL default '10',
  `email_bugnote_limit` smallint(6) NOT NULL default '0',
  `language` varchar(32) NOT NULL default 'english',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test__user_pref_table`
--

LOCK TABLES `mantisrest_test__user_pref_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test__user_pref_table` DISABLE KEYS */;
INSERT INTO `mantisrest_test__user_pref_table` VALUES (1,2,0,0,0,0,0,0,30,2,'ASC',1,1,1,1,1,1,1,0,0,0,0,0,0,0,0,0,0,0,0,'english'),(2,1,0,0,0,0,0,0,30,2,'ASC',1,1,1,1,1,1,1,0,0,0,0,0,0,0,0,0,0,0,0,'english'),(3,3,0,0,0,0,0,0,30,2,'ASC',1,1,1,1,1,1,1,0,0,0,0,0,0,0,0,0,0,0,0,'english'),(4,4,0,0,0,0,0,0,30,2,'ASC',1,1,1,1,1,1,1,0,0,0,0,0,0,0,0,0,0,0,0,'english');
/*!40000 ALTER TABLE `mantisrest_test__user_pref_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test__user_print_pref_table`
--

DROP TABLE IF EXISTS `mantisrest_test__user_print_pref_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test__user_print_pref_table` (
  `user_id` int(10) unsigned NOT NULL default '0',
  `print_pref` varchar(64) NOT NULL,
  PRIMARY KEY  (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test__user_print_pref_table`
--

LOCK TABLES `mantisrest_test__user_print_pref_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test__user_print_pref_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantisrest_test__user_print_pref_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test__user_profile_table`
--

DROP TABLE IF EXISTS `mantisrest_test__user_profile_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test__user_profile_table` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL default '0',
  `platform` varchar(32) NOT NULL default '',
  `os` varchar(32) NOT NULL default '',
  `os_build` varchar(32) NOT NULL default '',
  `description` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test__user_profile_table`
--

LOCK TABLES `mantisrest_test__user_profile_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test__user_profile_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantisrest_test__user_profile_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantisrest_test__user_table`
--

DROP TABLE IF EXISTS `mantisrest_test__user_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mantisrest_test__user_table` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `username` varchar(32) NOT NULL default '',
  `realname` varchar(64) NOT NULL default '',
  `email` varchar(64) NOT NULL default '',
  `password` varchar(32) NOT NULL default '',
  `date_created` datetime NOT NULL default '1970-01-01 00:00:01',
  `last_visit` datetime NOT NULL default '1970-01-01 00:00:01',
  `enabled` tinyint(4) NOT NULL default '1',
  `protected` tinyint(4) NOT NULL default '0',
  `access_level` smallint(6) NOT NULL default '10',
  `login_count` int(11) NOT NULL default '0',
  `lost_password_request_count` smallint(6) NOT NULL default '0',
  `failed_login_count` smallint(6) NOT NULL default '0',
  `cookie_string` varchar(64) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `idx_user_cookie_string` (`cookie_string`),
  UNIQUE KEY `idx_user_username` (`username`),
  KEY `idx_enable` (`enabled`),
  KEY `idx_access` (`access_level`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mantisrest_test__user_table`
--

LOCK TABLES `mantisrest_test__user_table` WRITE;
/*!40000 ALTER TABLE `mantisrest_test__user_table` DISABLE KEYS */;
INSERT INTO `mantisrest_test__user_table` VALUES (1,'administrator','','root@localhost','63a9f0ea7bb98050796b649e85481845','2008-09-29 22:09:41','2008-09-29 22:18:03',0,0,90,4,0,0,'e85315c61ede369081d9677978748d4de1ff1196e603461d8bdbc959a2a05798'),(2,'dan','whatever','dan@localhost','9180b4da3f0c7e80975fad685f7f134e','2008-09-29 22:15:27','2008-11-20 19:07:03',1,0,90,22,0,0,'37a1ae17a2985588c3ffd592bbae8a411cb2de6e697b5171fb5d20affd31e176'),(3,'nobody','what','dan@localhost','6e854442cd2a940c9e95941dce4ad598','2008-10-04 16:20:14','2008-10-04 16:22:00',1,0,25,1,0,0,'25a362b154a2144bf3ffcaf2f11722c87b3ec6e67e891b183ef8e7213d5263db'),(4,'somebody','yup','dan@mantis.localhost','78b9d09661da64f0bc6c146c524bae4a','2008-10-04 22:56:53','2008-11-18 21:26:02',1,0,55,6,0,0,'af704e3bfd9c3bae5beebc2c732d7840ffab78d1f5754ffabe9b0ee9c0cfa707');
/*!40000 ALTER TABLE `mantisrest_test__user_table` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2008-11-23  3:17:20
