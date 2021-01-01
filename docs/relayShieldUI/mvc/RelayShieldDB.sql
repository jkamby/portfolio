-- MySQL dump 10.13  Distrib 5.7.22, for Linux (x86_64)
--
-- Host: localhost    Database: RelayShieldDB
-- ------------------------------------------------------
-- Server version	5.7.22-0ubuntu0.16.04.1

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
-- Table structure for table `RSActivityLog`
--

DROP TABLE IF EXISTS `RSActivityLog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `RSActivityLog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `activitytime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `facilityid` int(11) DEFAULT NULL,
  `relaynumber` int(11) DEFAULT NULL,
  `activitytype` varchar(10) DEFAULT NULL,
  `activityduration` int(11) DEFAULT NULL,
  `activityinterval` int(11) DEFAULT NULL,
  `activitystatus` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `facilityid` (`facilityid`),
  CONSTRAINT `RSActivityLog_ibfk_1` FOREIGN KEY (`facilityid`) REFERENCES `RSFacilities` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `RSActivityLog`
--

LOCK TABLES `RSActivityLog` WRITE;
/*!40000 ALTER TABLE `RSActivityLog` DISABLE KEYS */;
/*!40000 ALTER TABLE `RSActivityLog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `RSDeletedStuff`
--

DROP TABLE IF EXISTS `RSDeletedStuff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `RSDeletedStuff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fromtable` varchar(30) NOT NULL,
  `recordsummary` json DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `RSDeletedStuff`
--

LOCK TABLES `RSDeletedStuff` WRITE;
/*!40000 ALTER TABLE `RSDeletedStuff` DISABLE KEYS */;
INSERT INTO `RSDeletedStuff` VALUES (1,'RSFacilities','{\"0\": \"29\", \"1\": \"Hi p hop\", \"2\": \"1\", \"3\": \"1\", \"id\": \"29\", \"activestatus\": \"1\", \"facilityname\": \"Hi p hop\", \"numberofrelays\": \"1\"}'),(2,'RSGroupUserMemberships','{\"28\": {\"0\": \"9\", \"1\": \"15\"}}'),(3,'RSUsers','{\"0\": \"28\", \"1\": \"Nally\", \"2\": \"Kay\", \"3\": \"nkay\", \"4\": \"nkay@efg.com\", \"5\": \"$2y$10$d3f8vwy6Gjor2A2KBPD25Oo8NkY3so0RmIwdvLJGfE7w0d8SazS/e\", \"6\": \"1\", \"7\": \"0\", \"id\": \"28\", \"email\": \"nkay@efg.com\", \"lastname\": \"Kay\", \"username\": \"nkay\", \"firstname\": \"Nally\", \"usertypeid\": \"1\", \"activestatus\": \"0\", \"encryptedpassword\": \"$2y$10$d3f8vwy6Gjor2A2KBPD25Oo8NkY3so0RmIwdvLJGfE7w0d8SazS/e\"}'),(4,'RSGroupUserMemberships','{\"27\": {\"0\": \"4\", \"1\": \"14\"}}'),(5,'RSFacilityGroupMemberships','{\"27\": {\"0\": \"1\", \"1\": \"18\"}}'),(6,'RSGroups','{\"0\": \"27\", \"1\": \"Yes prep talk\", \"2\": \"Ha ha ha\", \"3\": \"1\", \"id\": \"27\", \"groupname\": \"Yes prep talk\", \"activestatus\": \"1\", \"groupdescription\": \"Ha ha ha\"}'),(7,'RSDeviceFacilityMatches','{\"0\": \"27\", \"1\": \"17\", \"2\": \"25\", \"id\": \"27\", \"deviceid\": \"17\", \"facilityid\": \"25\"}'),(8,'RSDevices','false');
/*!40000 ALTER TABLE `RSDeletedStuff` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `RSDeviceFacilityMatches`
--

DROP TABLE IF EXISTS `RSDeviceFacilityMatches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `RSDeviceFacilityMatches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `deviceid` int(11) DEFAULT NULL,
  `facilityid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `deviceid` (`deviceid`,`facilityid`),
  KEY `facilityid` (`facilityid`),
  CONSTRAINT `RSDeviceFacilityMatches_ibfk_1` FOREIGN KEY (`deviceid`) REFERENCES `RSDevices` (`id`),
  CONSTRAINT `RSDeviceFacilityMatches_ibfk_2` FOREIGN KEY (`facilityid`) REFERENCES `RSFacilities` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `RSDeviceFacilityMatches`
--

LOCK TABLES `RSDeviceFacilityMatches` WRITE;
/*!40000 ALTER TABLE `RSDeviceFacilityMatches` DISABLE KEYS */;
INSERT INTO `RSDeviceFacilityMatches` VALUES (3,3,1),(17,12,30);
/*!40000 ALTER TABLE `RSDeviceFacilityMatches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `RSDevices`
--

DROP TABLE IF EXISTS `RSDevices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `RSDevices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `deviceid` varchar(100) NOT NULL,
  `encryptedaccesstoken` varchar(255) DEFAULT NULL,
  `devicedescription` varchar(255) DEFAULT NULL,
  `activestatus` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `deviceid` (`deviceid`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `RSDevices`
--

LOCK TABLES `RSDevices` WRITE;
/*!40000 ALTER TABLE `RSDevices` DISABLE KEYS */;
INSERT INTO `RSDevices` VALUES (3,'350042000e51353532343635','8db83ede2e5eb5b0047413935c796aaf9ab165ff','photon connected to a 4-switch relayshield',1),(12,'3a0029000c51353432383931','1a0aa49668aa90f4bead0a7a3ce2633a6299e62d','SSB',1),(13,'cjeej','fewofj','Test',1);
/*!40000 ALTER TABLE `RSDevices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `RSFacilities`
--

DROP TABLE IF EXISTS `RSFacilities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `RSFacilities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `facilityname` varchar(30) NOT NULL,
  `numberofrelays` int(11) DEFAULT NULL,
  `activestatus` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `facilityname` (`facilityname`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `RSFacilities`
--

LOCK TABLES `RSFacilities` WRITE;
/*!40000 ALTER TABLE `RSFacilities` DISABLE KEYS */;
INSERT INTO `RSFacilities` VALUES (1,'Area 52',3,1),(17,'NIH',4,1),(18,'test',3,0),(25,'Penultimate Test',3,1),(30,'SSB',4,0);
/*!40000 ALTER TABLE `RSFacilities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `RSFacilityGroupMemberships`
--

DROP TABLE IF EXISTS `RSFacilityGroupMemberships`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `RSFacilityGroupMemberships` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `facilityid` int(11) DEFAULT NULL,
  `groupid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `facilityid` (`facilityid`,`groupid`),
  KEY `groupid` (`groupid`),
  CONSTRAINT `RSFacilityGroupMemberships_ibfk_1` FOREIGN KEY (`facilityid`) REFERENCES `RSFacilities` (`id`),
  CONSTRAINT `RSFacilityGroupMemberships_ibfk_2` FOREIGN KEY (`groupid`) REFERENCES `RSGroups` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `RSFacilityGroupMemberships`
--

LOCK TABLES `RSFacilityGroupMemberships` WRITE;
/*!40000 ALTER TABLE `RSFacilityGroupMemberships` DISABLE KEYS */;
INSERT INTO `RSFacilityGroupMemberships` VALUES (1,1,1),(39,17,1),(44,17,9),(48,17,15),(63,25,15),(64,25,16),(65,25,17),(83,30,28);
/*!40000 ALTER TABLE `RSFacilityGroupMemberships` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `RSGroupUserMemberships`
--

DROP TABLE IF EXISTS `RSGroupUserMemberships`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `RSGroupUserMemberships` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupid` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `groupid` (`groupid`,`userid`),
  KEY `userid` (`userid`),
  CONSTRAINT `RSGroupUserMemberships_ibfk_1` FOREIGN KEY (`groupid`) REFERENCES `RSGroups` (`id`),
  CONSTRAINT `RSGroupUserMemberships_ibfk_2` FOREIGN KEY (`userid`) REFERENCES `RSUsers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `RSGroupUserMemberships`
--

LOCK TABLES `RSGroupUserMemberships` WRITE;
/*!40000 ALTER TABLE `RSGroupUserMemberships` DISABLE KEYS */;
INSERT INTO `RSGroupUserMemberships` VALUES (20,1,4),(30,15,14),(34,15,24),(35,16,4),(38,17,4),(59,28,14),(60,28,24);
/*!40000 ALTER TABLE `RSGroupUserMemberships` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `RSGroups`
--

DROP TABLE IF EXISTS `RSGroups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `RSGroups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupname` varchar(30) NOT NULL,
  `groupdescription` varchar(255) DEFAULT NULL,
  `activestatus` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `groupname` (`groupname`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `RSGroups`
--

LOCK TABLES `RSGroups` WRITE;
/*!40000 ALTER TABLE `RSGroups` DISABLE KEYS */;
INSERT INTO `RSGroups` VALUES (1,'area_52','level 5 clearance',1),(9,'Let\'s See','sldfjss;fk',1),(15,'NIH','NIH',1),(16,'Children\'s Hospital ','Children\'s Hospital ',1),(17,'BCH','BCH',0),(28,'SSB','SSB',1);
/*!40000 ALTER TABLE `RSGroups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `RSHouseKeepingLog`
--

DROP TABLE IF EXISTS `RSHouseKeepingLog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `RSHouseKeepingLog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `occurredat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `remarks` varchar(255) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=218 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `RSHouseKeepingLog`
--

LOCK TABLES `RSHouseKeepingLog` WRITE;
/*!40000 ALTER TABLE `RSHouseKeepingLog` DISABLE KEYS */;
INSERT INTO `RSHouseKeepingLog` VALUES (1,'2018-04-03 02:20:09','Initialization of database!',NULL),(2,'2018-04-25 04:36:11','Updating user: Sallo first name successful.not attempted.',12),(3,'2018-04-26 01:37:11','\'facility-groupid pairs deleted.\'',4),(4,'2018-04-26 01:37:11',' deleted.',4),(5,'2018-04-26 01:43:47','\'facility-groupid pairs deleted.\'',4),(6,'2018-04-26 01:43:47','The Triangle deleted.',4),(7,'2018-04-26 02:45:30',' deleted.',4),(8,'2018-04-26 02:45:30',' deleted.',4),(9,'2018-04-26 03:22:43','Adding user: tkay successful.',4),(10,'2018-04-26 03:27:24','Adding user: jkim successful.',4),(11,'2018-04-26 03:27:45',' deleted.',4),(12,'2018-04-26 03:27:45',' deleted.',4),(13,'2018-04-26 03:27:48',' deleted.',4),(14,'2018-04-26 03:27:48',' deleted.',4),(15,'2018-04-26 03:27:51',' deleted.',4),(16,'2018-04-26 03:27:51',' deleted.',4),(17,'2018-04-26 03:27:54',' deleted.',4),(18,'2018-04-26 03:27:54',' deleted.',4),(19,'2018-04-26 03:27:58',' deleted.',4),(20,'2018-04-26 03:27:58',' deleted.',4),(21,'2018-04-26 03:28:01',' deleted.',4),(22,'2018-04-26 03:28:01',' deleted.',4),(23,'2018-04-26 03:32:18',' deleted.',4),(24,'2018-04-26 03:32:18','user: nkay deleted.',4),(25,'2018-04-26 21:33:16','Adding user: mshaw successful.',14),(26,'2018-04-26 21:34:34',' successful.',14),(27,'2018-04-26 21:35:18','Updating group: NIHstatus successful.',14),(28,'2018-04-26 21:36:53','Adding user: mshia successful.',14),(29,'2018-04-26 21:37:06','Updating user: Mitchel  status successful.',14),(30,'2018-04-26 21:37:26','Updating user: Mitchel  status successful.',14),(31,'2018-04-27 01:22:00','Adding user: jkim successful.',4),(32,'2018-04-27 03:43:16','Adding user: dkay successful.',4),(33,'2018-04-30 03:43:17',' deleted.',4),(34,'2018-04-30 03:43:20',' deleted.',4),(35,'2018-04-30 03:43:33',' deleted.',4),(36,'2018-04-30 03:43:40',' deleted.',4),(37,'2018-04-30 03:43:52',' deleted.',4),(38,'2018-04-30 03:44:15',' deleted.',4),(39,'2018-04-30 03:44:15','user: mshaw deleted.',4),(40,'2018-04-30 03:44:24',' deleted.',4),(41,'2018-04-30 03:44:24','user: dkay deleted.',4),(42,'2018-04-30 03:44:33',' deleted.',4),(43,'2018-04-30 03:44:33','user: jkim deleted.',4),(44,'2018-04-30 03:44:44',' deleted.',4),(45,'2018-04-30 03:44:44','user: skay deleted.',4),(46,'2018-04-30 04:40:22',' deleted.',4),(47,'2018-04-30 04:40:22',' deleted.',4),(48,'2018-04-30 04:40:31',' deleted.',4),(49,'2018-04-30 04:40:31',' deleted.',4),(50,'2018-04-30 05:06:32',' deleted.',4),(51,'2018-04-30 05:06:32',' deleted.',4),(52,'2018-04-30 05:06:35',' deleted.',4),(53,'2018-04-30 05:06:35',' deleted.',4),(54,'2018-04-30 05:06:43',' deleted.',4),(55,'2018-04-30 05:06:43',' deleted.',4),(56,'2018-04-30 05:06:46',' deleted.',4),(57,'2018-04-30 05:06:46',' deleted.',4),(58,'2018-04-30 05:06:46',' deleted.',4),(59,'2018-04-30 05:06:50',' deleted.',4),(60,'2018-04-30 05:06:50',' deleted.',4),(61,'2018-04-30 05:06:50',' deleted.',4),(62,'2018-04-30 05:43:26',' successful.',4),(63,'2018-04-30 05:58:27',' successful.',4),(64,'2018-04-30 08:29:29',' added.',4),(65,'2018-04-30 08:29:29',' successful.',4),(66,'2018-04-30 08:29:37','Updating device: cjeejnot attempted.',4),(67,'2018-04-30 08:30:40',' successful.',4),(68,'2018-04-30 13:37:48',' successful.',4),(69,'2018-04-30 13:47:50',' successful.',4),(70,'2018-04-30 13:57:48',' successful.',4),(71,'2018-04-30 14:06:57',' successful.',4),(72,'2018-04-30 14:07:45',' successful.',4),(73,'2018-04-30 14:09:22',' successful.',4),(74,'2018-04-30 14:13:39',' deleted.',4),(75,'2018-04-30 14:13:39',' deleted.',4),(76,'2018-04-30 14:13:43',' deleted.',4),(77,'2018-04-30 14:13:45',' deleted.',4),(78,'2018-04-30 14:13:45',' deleted.',4),(79,'2018-04-30 14:14:14',' successful.',4),(80,'2018-04-30 14:14:14',' successful.',4),(81,'2018-04-30 14:14:22',' deleted.',4),(82,'2018-04-30 14:14:22',' deleted.',4),(83,'2018-04-30 14:14:22',' deleted.',4),(84,'2018-04-30 14:19:37','Updating device: 3a0029000c51353432383931not attempted.',4),(85,'2018-04-30 14:20:48',' successful.',4),(86,'2018-04-30 14:20:48','Adding groupid-userid pair successful.',4),(87,'2018-04-30 14:20:48','Adding groupid-userid pair successful.',4),(88,'2018-04-30 14:21:14',' deleted.',4),(89,'2018-04-30 14:21:14',' deleted.',4),(90,'2018-04-30 14:21:14',' deleted.',4),(91,'2018-04-30 15:33:35',' successful.',4),(92,'2018-04-30 15:33:35','Adding groupid-userid pair successful.',4),(93,'2018-04-30 15:33:35','Adding groupid-userid pair successful.',4),(94,'2018-04-30 16:48:50','groupid-userid pairs deleted.',4),(95,'2018-04-30 16:48:50',' deleted.',4),(96,'2018-04-30 16:49:00','groupid-userid pairs deleted.',4),(97,'2018-04-30 16:49:00',' deleted.',4),(98,'2018-04-30 16:49:00',' deleted.',4),(99,'2018-04-30 17:50:14',' successful.',4),(100,'2018-04-30 17:57:03',' added.',4),(101,'2018-04-30 17:57:03',' successful.',4),(102,'2018-04-30 18:29:34',' successful.',4),(103,'2018-04-30 18:32:51',' successful.',4),(104,'2018-04-30 18:34:52',' added.',4),(105,'2018-04-30 18:35:14','Updating device: Some test name successful.not attempted.',4),(106,'2018-04-30 18:36:56','Updating device: Some test 2access token successful.not attempted.',4),(107,'2018-04-30 18:37:04','Updating device: Some test 2description successful.not attempted.',4),(108,'2018-04-30 18:37:14','Updating device: Some test 2description successful.not attempted.',4),(109,'2018-04-30 18:37:20','Updating device: Some test 2status successful.not attempted.',4),(110,'2018-04-30 18:37:46','Updating facility: One more test name successful.',4),(111,'2018-04-30 18:37:52','Updating facility: One more test 2relays successful.',4),(112,'2018-04-30 18:38:03',' deleted.',4),(113,'2018-04-30 18:38:03',' deleted.',4),(114,'2018-04-30 18:38:09','Updating facility: One more test 2status successful.',4),(115,'2018-04-30 18:38:21',' successful.',4),(116,'2018-04-30 18:40:49','\'facility-groupid pairs deleted.\'',4),(117,'2018-04-30 18:40:49','Another Test deleted.',4),(118,'2018-04-30 18:40:53','\'facility-groupid pairs deleted.\'',4),(119,'2018-04-30 18:40:53','sadf\'fhfg deleted.',4),(120,'2018-04-30 18:40:59','\'facility-groupid pairs deleted.\'',4),(121,'2018-04-30 18:40:59','One more test 2 deleted.',4),(122,'2018-04-30 18:41:57',' successful.',4),(123,'2018-04-30 18:45:46',' successful.',4),(124,'2018-04-30 18:46:00',' deleted.',4),(125,'2018-04-30 18:46:02',' deleted.',4),(126,'2018-04-30 18:46:09','\'facility-groupid pairs deleted.\'',4),(127,'2018-04-30 18:46:09','I\'m here too deleted.',4),(128,'2018-04-30 18:46:12','\'facility-groupid pairs deleted.\'',4),(129,'2018-04-30 18:46:12','I\'m available deleted.',4),(130,'2018-04-30 20:30:56','Adding facility: Final_test successful.',4),(131,'2018-04-30 20:39:52','Adding facility: Penultimate Test successful.',4),(132,'2018-04-30 20:39:52','Adding facilityid-groupid pair successful.',4),(133,'2018-04-30 20:39:52','Adding facilityid-groupid pair successful.',4),(134,'2018-04-30 20:39:52','Adding facilityid-groupid pair successful.',4),(135,'2018-04-30 20:39:52','Adding facilityid-groupid pair successful.',4),(136,'2018-04-30 20:40:11','Updating facility: Final_teststatus successful.',4),(137,'2018-04-30 20:41:17','\'facility-groupid pairs deleted.\'',4),(138,'2018-04-30 20:41:17','Final_test deleted.',4),(139,'2018-04-30 20:42:14','Device:  added.',4),(140,'2018-04-30 20:43:14','Adding group: Yes prep talk successful.',4),(141,'2018-04-30 20:43:14','Adding groupid-userid pair successful.',4),(142,'2018-04-30 20:43:14','Adding groupid-userid pair successful.',4),(143,'2018-04-30 20:43:14','Adding facilityid-groupid pair successful.',4),(144,'2018-04-30 20:43:14','Adding facilityid-groupid pair successful.',4),(145,'2018-04-30 20:43:24','groupid-userid pairs deleted.',4),(146,'2018-04-30 20:43:24','N#asd\'d deleted.',4),(147,'2018-04-30 20:43:28','groupid-userid pairs deleted.',4),(148,'2018-04-30 20:43:28','facility-groupid pairs deleted.',4),(149,'2018-04-30 20:43:28','O\'clock deleted.',4),(150,'2018-04-30 20:44:20','Adding user: jkay successful.',4),(151,'2018-04-30 20:45:26','Adding user: nkay successful.',4),(152,'2018-04-30 20:45:32','groupid-userid pairs deleted.',4),(153,'2018-04-30 20:45:32','user: jkay deleted.',4),(154,'2018-05-01 00:58:42','Updating group: Yes prep talkstatus successful.',99999),(155,'2018-05-01 01:33:10','Adding facility: To be deleted  successful.',4),(156,'2018-05-01 01:33:10','Adding deviceid-facilityid pair successful.',4),(157,'2018-05-01 01:33:10','Adding facilityid-groupid pair successful.',4),(158,'2018-05-01 01:33:10','Adding facilityid-groupid pair successful.',4),(159,'2018-05-01 01:33:10','Adding facilityid-groupid pair successful.',4),(160,'2018-05-01 01:33:10','Adding facilityid-groupid pair successful.',4),(161,'2018-05-01 01:34:14','\'facility-groupid pairs deleted.\'',4),(162,'2018-05-01 01:34:14','To be deleted  deleted.',4),(163,'2018-05-01 01:55:50','Adding facility: Yadi yada yadi successful.',4),(164,'2018-05-01 01:55:50','Adding deviceid-facilityid pair successful.',4),(165,'2018-05-01 01:55:50','Adding facilityid-groupid pair successful.',4),(166,'2018-05-01 01:55:50','Adding facilityid-groupid pair successful.',4),(167,'2018-05-01 01:55:50','Adding facilityid-groupid pair successful.',4),(168,'2018-05-01 01:55:50','Adding facilityid-groupid pair successful.',4),(169,'2018-05-01 01:55:50','Adding facilityid-groupid pair successful.',4),(170,'2018-05-01 01:55:59','\'facility-groupid pairs deleted.\'',4),(171,'2018-05-01 01:55:59','Yadi yada yadi deleted.',4),(172,'2018-05-01 01:57:52','Adding facility: dsfgsd successful.',4),(173,'2018-05-01 01:57:52','Adding facilityid-groupid pair successful.',4),(174,'2018-05-01 01:57:52','Adding facilityid-groupid pair successful.',4),(175,'2018-05-01 01:57:55','\'facility-groupid pairs deleted.\'',4),(176,'2018-05-01 01:57:55','dsfgsd deleted.',4),(177,'2018-05-01 02:00:41','Adding facility: Hi p hop successful.',4),(178,'2018-05-01 02:00:41','Adding deviceid-facilityid pair successful.',4),(179,'2018-05-01 02:00:41','Adding facilityid-groupid pair successful.',4),(180,'2018-05-01 02:00:41','Adding facilityid-groupid pair successful.',4),(181,'2018-05-01 02:00:41','Adding facilityid-groupid pair successful.',4),(182,'2018-05-01 02:00:45','\'facility-groupid pairs deleted.\'',4),(183,'2018-05-01 02:00:45','Hi p hop deleted.',4),(184,'2018-05-01 02:00:45','RSFacilities deletion archive  successful.',4),(185,'2018-05-01 02:04:31','Device And another deleted.',4),(186,'2018-05-01 03:11:19','Adding groupid-userid pair successful.',4),(187,'2018-05-01 03:11:19','Adding groupid-userid pair successful.',4),(188,'2018-05-01 03:11:25','groupid-userid pairs deleted.',4),(189,'2018-05-01 03:11:25','RSGroupUserMemberships deletion archive  successful.',4),(190,'2018-05-01 03:11:25','user: nkay deleted.',4),(191,'2018-05-01 03:11:25','RSUsers deletion archive  successful.',4),(192,'2018-05-01 03:29:08','Updating device: cjeejstatus successful.not attempted.',4),(193,'2018-05-01 03:55:34','groupid-userid pairs deleted.',4),(194,'2018-05-01 03:55:34','RSGroupUserMemberships deletion archive  successful.',4),(195,'2018-05-01 03:55:34','facility-groupid pairs deleted.',4),(196,'2018-05-01 03:55:34','RSFacilityGroupMemberships deletion archive  successful.',4),(197,'2018-05-01 03:55:34','Yes prep talk deleted.',4),(198,'2018-05-01 03:55:34','RSGroups deletion archive  successful.',4),(199,'2018-05-01 04:46:59','Device:  added.',4),(200,'2018-05-01 04:46:59','Adding deviceid-facilityid pair successful.',4),(201,'2018-05-01 04:47:38','Updating device: gfdsfgds\'#fgfgsdf name successful.not attempted.',4),(202,'2018-05-01 04:47:45','Updating device: gfdsfgds\'#fgfgsaccess token successful.not attempted.',4),(203,'2018-05-01 04:47:54','Updating device: gfdsfgds\'#fgfgsnot attempted.',4),(204,'2018-05-01 04:47:54','Updating deviceid-facilityid pair successful.',4),(205,'2018-05-01 04:47:59','Updating device: gfdsfgds\'#fgfgsstatus successful.not attempted.',4),(206,'2018-05-01 04:48:05','Updating device: gfdsfgds\'#fgfgsdescription successful.not attempted.',4),(207,'2018-05-01 04:48:12','deviceid-facilityid pair deleted.',4),(208,'2018-05-01 04:48:12','RSDeviceFacilityMatches deletion archive  successful.',4),(209,'2018-05-01 04:48:12','Device gfdsfgds\'#fgfgs deleted.',4),(210,'2018-05-01 04:48:12','RSDevices deletion archive  successful.',4),(211,'2018-05-14 16:48:04','Adding facility: SSB successful.',14),(212,'2018-05-14 16:49:56','Adding group: SSB successful.',14),(213,'2018-05-14 16:49:56','Adding groupid-userid pair successful.',14),(214,'2018-05-14 16:49:56','Adding groupid-userid pair successful.',14),(215,'2018-05-14 16:49:56','Adding facilityid-groupid pair successful.',14),(216,'2018-05-14 16:53:24','Updating device: 3a0029000c51353432383931description successful.not attempted.',14),(217,'2018-05-14 16:53:24','Updating deviceid-facilityid pair successful.',14);
/*!40000 ALTER TABLE `RSHouseKeepingLog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `RSUserTypes`
--

DROP TABLE IF EXISTS `RSUserTypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `RSUserTypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typename` varchar(20) NOT NULL,
  `typedescription` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `typename` (`typename`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `RSUserTypes`
--

LOCK TABLES `RSUserTypes` WRITE;
/*!40000 ALTER TABLE `RSUserTypes` DISABLE KEYS */;
INSERT INTO `RSUserTypes` VALUES (1,'regular','single-facility access'),(2,'uber','multi-facility access'),(3,'admin','resource allocator'),(4,'super','entity creator');
/*!40000 ALTER TABLE `RSUserTypes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `RSUsers`
--

DROP TABLE IF EXISTS `RSUsers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `RSUsers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(30) DEFAULT NULL,
  `lastname` varchar(30) DEFAULT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `encryptedpassword` varchar(255) DEFAULT NULL,
  `usertypeid` int(11) DEFAULT NULL,
  `activestatus` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `usertypeid` (`usertypeid`),
  CONSTRAINT `RSUsers_ibfk_1` FOREIGN KEY (`usertypeid`) REFERENCES `RSUserTypes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `RSUsers`
--

LOCK TABLES `RSUsers` WRITE;
/*!40000 ALTER TABLE `RSUsers` DISABLE KEYS */;
INSERT INTO `RSUsers` VALUES (4,'Rick','Root','rroot','rroot@booya.com','$2y$10$C88h3C6o0btMZF7Ralm8tud7/Gzw0qjm30oqyvBgGBV6oyzC838ve',4,1),(14,'R','F','rick','rick@fredkin.com','$2y$10$9qD7Nck2/TD86d.n2NcjfeV1/uKgNdNVsMZZWebVZryfvLLYGSI8i',4,0),(24,'Mitchel ','Shia','mshia','mitchel.shia@gmail.com','$2y$10$Yd74K1fV./C1JUZdAkWqleeshxaray2oOp7TY0x6N00NR37hA.ULC',1,0);
/*!40000 ALTER TABLE `RSUsers` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-05-26  3:08:56
