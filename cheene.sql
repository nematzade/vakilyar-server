-- MySQL dump 10.15  Distrib 10.0.31-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: cheene_db
-- ------------------------------------------------------
-- Server version	10.0.31-MariaDB-0ubuntu0.16.04.2

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
-- Table structure for table `ActionGroups`
--

DROP TABLE IF EXISTS `ActionGroups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ActionGroups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(11) DEFAULT NULL,
  `code` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `visible` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8206C79E77153098` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ActionGroups`
--

LOCK TABLES `ActionGroups` WRITE;
/*!40000 ALTER TABLE `ActionGroups` DISABLE KEYS */;
INSERT INTO `ActionGroups` VALUES (1,NULL,'USER_MANAGEMENT','User Management',1);
/*!40000 ALTER TABLE `ActionGroups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ActionGroups_Actions`
--

DROP TABLE IF EXISTS `ActionGroups_Actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ActionGroups_Actions` (
  `action_group_id` int(11) NOT NULL,
  `action_id` int(11) NOT NULL,
  PRIMARY KEY (`action_group_id`,`action_id`),
  KEY `IDX_90722E272983A921` (`action_group_id`),
  KEY `IDX_90722E279D32F035` (`action_id`),
  CONSTRAINT `FK_90722E272983A921` FOREIGN KEY (`action_group_id`) REFERENCES `ActionGroups` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_90722E279D32F035` FOREIGN KEY (`action_id`) REFERENCES `Actions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ActionGroups_Actions`
--

LOCK TABLES `ActionGroups_Actions` WRITE;
/*!40000 ALTER TABLE `ActionGroups_Actions` DISABLE KEYS */;
INSERT INTO `ActionGroups_Actions` VALUES (1,1),(1,2),(1,3),(1,4),(1,5),(1,6);
/*!40000 ALTER TABLE `ActionGroups_Actions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ActionGroups_Roles`
--

DROP TABLE IF EXISTS `ActionGroups_Roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ActionGroups_Roles` (
  `role_id` int(11) NOT NULL,
  `action_group_id` int(11) NOT NULL,
  PRIMARY KEY (`role_id`,`action_group_id`),
  KEY `IDX_46443E95D60322AC` (`role_id`),
  KEY `IDX_46443E952983A921` (`action_group_id`),
  CONSTRAINT `FK_46443E952983A921` FOREIGN KEY (`action_group_id`) REFERENCES `ActionGroups` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_46443E95D60322AC` FOREIGN KEY (`role_id`) REFERENCES `Roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ActionGroups_Roles`
--

LOCK TABLES `ActionGroups_Roles` WRITE;
/*!40000 ALTER TABLE `ActionGroups_Roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `ActionGroups_Roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Actions`
--

DROP TABLE IF EXISTS `Actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `visible` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_CAF5C87377153098` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Actions`
--

LOCK TABLES `Actions` WRITE;
/*!40000 ALTER TABLE `Actions` DISABLE KEYS */;
INSERT INTO `Actions` VALUES (1,'ACTION_USER_INDEX','User -> Index',1),(2,'ACTION_USER_NEW','User -> Create',1),(3,'ACTION_USER_SHOW','User -> Create',1),(4,'ACTION_USER_DELETE','User -> Delete',1),(5,'ACTION_USER_EDIT','User -> Edit',1),(6,'ACTION_USER_UPDATE','User -> Update',1);
/*!40000 ALTER TABLE `Actions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Configurations`
--

DROP TABLE IF EXISTS `Configurations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Configurations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(1023) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Configurations`
--

LOCK TABLES `Configurations` WRITE;
/*!40000 ALTER TABLE `Configurations` DISABLE KEYS */;
/*!40000 ALTER TABLE `Configurations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Roles`
--

DROP TABLE IF EXISTS `Roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `visible` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_77FF01C357698A6A` (`role`),
  KEY `role_index` (`role`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Roles`
--

LOCK TABLES `Roles` WRITE;
/*!40000 ALTER TABLE `Roles` DISABLE KEYS */;
INSERT INTO `Roles` VALUES (1,'Super Admin','ROLE_SUPER_ADMIN',1),(2,'Admin','ROLE_ADMIN',1);
/*!40000 ALTER TABLE `Roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `UserVerificationTokens`
--

DROP TABLE IF EXISTS `UserVerificationTokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `UserVerificationTokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `sms_token` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `email_token` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `used` tinyint(1) DEFAULT NULL,
  `expired` tinyint(1) DEFAULT NULL,
  `used_at` datetime DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `cellphone` varchar(35) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:phone_number)',
  `plain_cellphone` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cellphoneUser` (`cellphone`,`user_id`),
  KEY `IDX_58567E4CA76ED395` (`user_id`),
  CONSTRAINT `FK_58567E4CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `UserVerificationTokens`
--

LOCK TABLES `UserVerificationTokens` WRITE;
/*!40000 ALTER TABLE `UserVerificationTokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `UserVerificationTokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `username` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `salt` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('FRONTEND','BACKEND') COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('NOT_VERIFIED','NOT_VALIDATED','VERIFIED','ACTIVE','DEACTIVATED','DELETED','LOCKED','EXPIRED') COLLATE utf8_unicode_ci DEFAULT NULL,
  `firstname` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `cellphone` varchar(35) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:phone_number)',
  `sex` enum('MALE','FEMALE') COLLATE utf8_unicode_ci DEFAULT NULL,
  `comment` longtext COLLATE utf8_unicode_ci,
  `global` tinyint(1) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `birthday` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile_verification_token` longtext COLLATE utf8_unicode_ci,
  `is_mobile_verified` tinyint(1) DEFAULT NULL,
  `national_code` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `profile_image_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_confirmed` tinyint(1) DEFAULT NULL,
  `last_seen` datetime DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_D5428AEDF85E0677` (`username`),
  UNIQUE KEY `UNIQ_D5428AEDE7927C74` (`email`),
  UNIQUE KEY `UNIQ_D5428AEDD3C17DD2` (`national_code`),
  KEY `username_index` (`username`),
  KEY `email_index` (`email`),
  KEY `created_by_index` (`created_by`),
  KEY `updated_by_index` (`updated_by`),
  CONSTRAINT `FK_D5428AED16FE72E1` FOREIGN KEY (`updated_by`) REFERENCES `Users` (`id`),
  CONSTRAINT `FK_D5428AEDDE12AB56` FOREIGN KEY (`created_by`) REFERENCES `Users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users`
--

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
INSERT INTO `Users` VALUES (1,NULL,NULL,'root','k6luvybluxskkgw0kow0kkwww8c4c88','reza@seyf.fr','66224841fd19eaa24ef5b09cd5b1799d638e1d6cb5bd21be5d0346a5036a6c7302125c38da825c9218bd1f0760beb21a397e39d1e386869ea0d094bed78126f7','BACKEND','ACTIVE','سوپر','یوزر','+989198254644',NULL,'',1,0,NULL,'2017-09-09 19:12:01','2017-09-09 21:45:21','fa','',0,NULL,NULL,NULL,'2017-09-09 21:45:21',0);
/*!40000 ALTER TABLE `Users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `UsersForgotPasswords`
--

DROP TABLE IF EXISTS `UsersForgotPasswords`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `UsersForgotPasswords` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` enum('SMS','EMAIL') COLLATE utf8_unicode_ci DEFAULT NULL,
  `token` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `used` tinyint(1) NOT NULL,
  `tries` int(11) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6E30B5C9A76ED395` (`user_id`),
  CONSTRAINT `FK_6E30B5C9A76ED395` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `UsersForgotPasswords`
--

LOCK TABLES `UsersForgotPasswords` WRITE;
/*!40000 ALTER TABLE `UsersForgotPasswords` DISABLE KEYS */;
/*!40000 ALTER TABLE `UsersForgotPasswords` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Users_Roles`
--

DROP TABLE IF EXISTS `Users_Roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Users_Roles` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `IDX_16142A5DA76ED395` (`user_id`),
  KEY `IDX_16142A5DD60322AC` (`role_id`),
  CONSTRAINT `FK_16142A5DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_16142A5DD60322AC` FOREIGN KEY (`role_id`) REFERENCES `Roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users_Roles`
--

LOCK TABLES `Users_Roles` WRITE;
/*!40000 ALTER TABLE `Users_Roles` DISABLE KEYS */;
INSERT INTO `Users_Roles` VALUES (1,1);
/*!40000 ALTER TABLE `Users_Roles` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-09-09 21:50:46
