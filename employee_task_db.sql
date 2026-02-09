-- MySQL dump 10.13  Distrib 8.4.7, for Linux (x86_64)
--
-- Host: localhost    Database: employee_task_db
-- ------------------------------------------------------
-- Server version	8.4.7-0ubuntu0.25.04.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `message` text COLLATE utf8mb4_general_ci NOT NULL,
  `recipient` int NOT NULL,
  `type` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `date` date NOT NULL,
  `is_read` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES (1,'\'Customer Feedback Survey Analysis\' has been assigned to you. Please review and start working on it.',7,'New Task Assigned','2024-09-05',1),(2,'\'test task\' has been assigned to you. Please review and start working on it',7,'New Task Assigned','0000-00-00',1),(3,'\'Example task 2\' has been assigned to you. Please review and start working on it',2,'New Task Assigned','2006-09-24',1),(4,'\'test\' has been assigned to you. Please review and start working on it',8,'New Task Assigned','2009-06-24',0),(5,'\'test task 3\' has been assigned to you. Please review and start working on it',7,'New Task Assigned','2024-09-06',1),(6,'\'Prepare monthly sales report\' has been assigned to you. Please review and start working on it',7,'New Task Assigned','2024-09-06',1),(7,'\'Update client database\' has been assigned to you. Please review and start working on it',7,'New Task Assigned','2024-09-06',1),(8,'\'Fix server downtime issue\' has been assigned to you. Please review and start working on it',2,'New Task Assigned','2024-09-06',0),(9,'\'Plan annual marketing strategy\' has been assigned to you. Please review and start working on it',2,'New Task Assigned','2024-09-06',0),(10,'\'Onboard new employees\' has been assigned to you. Please review and start working on it',7,'New Task Assigned','2024-09-06',0),(11,'\'Design new company website\' has been assigned to you. Please review and start working on it',2,'New Task Assigned','2024-09-06',0),(12,'\'Conduct software testing\' has been assigned to you. Please review and start working on it',7,'New Task Assigned','2024-09-06',0),(13,'\'Schedule team meeting\' has been assigned to you. Please review and start working on it',2,'New Task Assigned','2024-09-06',0),(14,'\'Prepare budget for Q4\' has been assigned to you. Please review and start working on it',7,'New Task Assigned','2024-09-06',0),(15,'\'Write blog post on industry trend\' has been assigned to you. Please review and start working on it',7,'New Task Assigned','2024-09-06',0),(16,'\'Renew software license\' has been assigned to you. Please review and start working on it',2,'New Task Assigned','2024-09-06',0),(17,'\'student enrollment\' has been assigned to you. Please review and start working on it',2,'New Task Assigned','0000-00-00',0),(18,'\'Placement Mentees Notebook\' has been assigned to you. Please review and start working on it',17,'New Task Assigned','0000-00-00',0),(19,'\'Research Status\' has been assigned to you. Please review and start working on it',14,'New Task Assigned','0000-00-00',0),(20,'\'Course Committee and Class Committee Meetings\' has been assigned to you. Please review and start working on it',16,'New Task Assigned','0000-00-00',0),(21,'\'Application for OD approval by the mentors (AIML) and faculty members (AIML)\' has been assigned to you. Please review and start working on it',12,'New Task Assigned','0000-00-00',0),(22,'\'this for testing\' has been assigned to you. Please review and start working on it',9,'New Task Assigned','0000-00-00',0),(23,'\'testing\' has been assigned to you. Please review and start working on it',25,'New Task Assigned','0000-00-00',1),(24,'Admin added a follow-up note on task: \'this for testing\'',9,'Admin Follow-up','0000-00-00',0),(25,'\'this for testing task type\' has been assigned to you. Please review and start working on it',25,'New Task Assigned','0000-00-00',0),(26,'\'sdfdbg\' has been assigned to you. Please review and start working on it',25,'New Task Assigned','0000-00-00',0),(27,'Admin added a follow-up note on task: \'sdfdbg\'',25,'Admin Follow-up','0000-00-00',0),(28,'Faculty has uploaded acknowledgment for task: \'sdfdbg\'',1,'Acknowledgment Uploaded','0000-00-00',0),(29,'\'for testing\' has been assigned to you. Please review and start working on it',9,'New Task Assigned','0000-00-00',0),(30,'\'for testing\' has been assigned to you. Please review and start working on it',25,'New Task Assigned','0000-00-00',0),(31,'\'dwefgty\' has been assigned to you. Please review and start working on it',25,'New Task Assigned','0000-00-00',0),(32,'Faculty has uploaded acknowledgment for task: \'dwefgty\'',1,'Acknowledgment Uploaded','0000-00-00',0),(33,'New Verification Task: Verify completion of \'dwefgty\' by barath for testing',26,'Verification Request','0000-00-00',0),(34,'Admin added a follow-up note on task: \'dwefgty\'',26,'Admin Follow-up','0000-00-00',0),(35,'\'123\' has been assigned to you. Please review and start working on it',25,'New Task Assigned','0000-00-00',0),(36,'\'zsdfgvhb\' has been assigned to you. Please review and start working on it',25,'New Task Assigned','0000-00-00',0),(37,'Faculty has uploaded acknowledgment for task: \'zsdfgvhb\'',1,'Acknowledgment Uploaded','0000-00-00',0),(38,'New Verification Task: Verify completion of \'zsdfgvhb\' by barath for testing',26,'Verification Request','0000-00-00',0),(39,'Faculty has uploaded acknowledgment for task: \'zsdfgvhb\'',1,'Acknowledgment Uploaded','0000-00-00',0),(40,'Faculty has uploaded acknowledgment for task: \'dwefgty\'',1,'Acknowledgment Uploaded','0000-00-00',0),(41,'\'e3wrgthy\' has been assigned to you. Please review and start working on it',25,'New Task Assigned','0000-00-00',0),(42,'Faculty has uploaded acknowledgment for task: \'e3wrgthy\'',1,'Acknowledgment Uploaded','0000-00-00',0),(43,'New Verification Task: Verify completion of \'e3wrgthy\' by barath for testing',26,'Verification Request','0000-00-00',0),(44,'\'sdvfbvgnh\' has been assigned to you. Please review and start working on it',25,'New Task Assigned','0000-00-00',0),(45,'Faculty has uploaded acknowledgment for task: \'sdvfbvgnh\'',1,'Acknowledgment Uploaded','0000-00-00',0),(46,'New Verification Task: Verify completion of \'sdvfbvgnh\' by barath for testing',26,'Verification Request','0000-00-00',0),(47,'Faculty has uploaded acknowledgment for task: \'sdvfbvgnh\'',1,'Acknowledgment Uploaded','0000-00-00',0),(48,'\'aaaaaa\' has been assigned to you. Please review and start working on it',26,'New Task Assigned','0000-00-00',0),(49,'Task \'aaaaaa\' has been marked as completed by the Assigned Person.',1,'Task Completed','0000-00-00',0),(50,'\'alert remainder\' has been assigned to you. Please review and start working on it',26,'New Task Assigned','0000-00-00',0),(51,'CRITICAL: Task \'alert remainder\' is due in less than 15 minutes!',26,'Deadline Alert','0000-00-00',0),(52,'Task \'alert remainder\' is due in less than 15 minutes!',26,'Deadline Alert','2026-02-09',0),(53,'Task \'sdvfbvgnh\' has been completed by the assigned faculty.',1,'Task Completed','2026-02-09',0),(54,'Task \'sdvfbvgnh\' has been completed by the assigned faculty.',1,'Task Completed','2026-02-09',0);
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task_documents`
--

DROP TABLE IF EXISTS `task_documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `task_documents` (
  `id` int NOT NULL AUTO_INCREMENT,
  `task_id` int NOT NULL,
  `uploaded_by` int NOT NULL,
  `document_type` enum('task_document','acknowledgment') NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `uploaded_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `task_id` (`task_id`),
  KEY `uploaded_by` (`uploaded_by`),
  CONSTRAINT `task_documents_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  CONSTRAINT `task_documents_ibfk_2` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_documents`
--

LOCK TABLES `task_documents` WRITE;
/*!40000 ALTER TABLE `task_documents` DISABLE KEYS */;
/*!40000 ALTER TABLE `task_documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task_progress`
--

DROP TABLE IF EXISTS `task_progress`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `task_progress` (
  `id` int NOT NULL AUTO_INCREMENT,
  `task_id` int NOT NULL,
  `user_id` int NOT NULL,
  `progress_type` enum('faculty_progress','admin_followup') NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `task_id` (`task_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `task_progress_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  CONSTRAINT `task_progress_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_progress`
--

LOCK TABLES `task_progress` WRITE;
/*!40000 ALTER TABLE `task_progress` DISABLE KEYS */;
INSERT INTO `task_progress` VALUES (1,34,25,'faculty_progress','i am still working','2026-02-06 20:26:34'),(3,35,25,'faculty_progress','this is completed','2026-02-07 20:29:14'),(4,36,1,'admin_followup','dcfgvhb','2026-02-08 20:06:43'),(5,40,26,'faculty_progress','I will verify this','2026-02-09 00:06:20'),(6,40,1,'admin_followup','ok do it','2026-02-09 00:08:29');
/*!40000 ALTER TABLE `task_progress` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tasks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `task_type` enum('Teaching','Research','Administrative','Establishment') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `subtopic` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `task_document` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `acknowledgment_document` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `acknowledgment_uploaded_at` datetime DEFAULT NULL,
  `assigned_to` int DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  `status` enum('pending','in_progress','completed') COLLATE utf8mb4_general_ci DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `verified_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `assigned_to` (`assigned_to`),
  CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tasks`
--

LOCK TABLES `tasks` WRITE;
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
INSERT INTO `tasks` VALUES (29,'Placement Mentees Notebook','All AIML Placement mentors should counsel their respective mentees. complete the placement notebooks, update the final number of placement eligible students to Dr Prabhu',NULL,NULL,NULL,NULL,NULL,17,'2026-02-10 00:00:00','pending','2026-02-06 12:05:07',NULL),(30,'Research Status','Create a form to collect the list of publications of all faculty members with DOI (only SRM affiliation) for increasing the citation count of the papers. Contact Librarian in any prominent institute and try to collect the list of publications of our faculty members, directly from scopus.',NULL,NULL,NULL,NULL,NULL,14,'2026-02-12 00:00:00','pending','2026-02-06 12:07:04',NULL),(31,'Course Committee and Class Committee Meetings','Madam, Ensure the meetings are conducted and collect the signed copy of the minutes of the meeting and add it in GDRIVE',NULL,NULL,NULL,NULL,NULL,16,'2026-02-10 00:00:00','pending','2026-02-06 12:08:29',NULL),(32,'Application for OD approval by the mentors (AIML) and faculty members (AIML)','Develop an Application for OD approval for the students (AIML only). Demo to be made to all the faculty members (AIML) and Mentors (AIML)',NULL,NULL,NULL,NULL,NULL,12,'2026-02-11 00:00:00','pending','2026-02-06 12:10:29',NULL),(34,'testing','testing',NULL,NULL,NULL,NULL,NULL,25,'2026-02-06 20:04:00','in_progress','2026-02-06 14:29:48',NULL),(35,'this for testing task type','this for testing task type','Research','research',NULL,NULL,NULL,25,'2026-02-07 20:30:00','completed','2026-02-07 14:56:44',NULL),(36,'sdfdbg','adsfg','Research','research','task_69889f5ee9e534.28823759.pdf','ack_6988aec552b830.68650468.pdf','2026-02-08 21:11:57',25,'2026-02-08 20:07:00','completed','2026-02-08 14:36:14',NULL),(39,'dwefgty','swdefsdgth','Teaching','dfdbg','task_6988d6076cea88.84405505.pdf','ack_6988d740c18124.61907132.pdf','2026-02-09 00:04:40',25,'2026-02-08 15:02:00','in_progress','2026-02-08 18:29:27',26),(40,'dwefgty','Verify task completion for: swdefsdgth','','Verification for barath for testing','ack_6988d740c18124.61907132.pdf','ack_6988ecf76b5a64.55717402.pdf','2026-02-09 01:37:19',26,NULL,'in_progress','2026-02-08 18:34:40',NULL),(41,'123','123','Establishment','sdfvbgvn',NULL,NULL,NULL,25,'2026-02-09 00:55:00','pending','2026-02-08 19:24:47',26),(42,'zsdfgvhb','zsxdfcvgybh','Administrative','research','task_6988e426744839.94079005.pdf','ack_6988e4501f8e84.11878071.pdf','2026-02-09 01:00:24',25,'2026-02-09 00:01:00','pending','2026-02-08 19:29:42',26),(43,'zsdfgvhb','Verify task completion for: zsxdfcvgybh','','Verification for barath for testing','ack_6988e4501f8e84.11878071.pdf','ack_6988e8013dd5f9.41922538.pdf','2026-02-09 01:16:09',26,NULL,'pending','2026-02-08 19:30:24',NULL),(44,'e3wrgthy','ewrfgth','Teaching','research','task_6988ed899346f4.11155477.pdf','ack_6988edc22329b2.97666270.pdf','2026-02-09 01:40:42',25,'2026-02-09 01:43:00','pending','2026-02-08 20:09:45',26),(45,'e3wrgthy','Verify task completion for: ewrfgth','','Verification for barath for testing','ack_6988edc22329b2.97666270.pdf',NULL,NULL,26,NULL,'pending','2026-02-08 20:10:42',NULL),(46,'sdvfbvgnh','fdgbnhj','Teaching','defdrgft','task_6988efa2e2af39.68617963.pdf','ack_6988efbe2f2dd5.98937228.pdf','2026-02-09 01:49:10',25,'2026-02-09 01:50:00','completed','2026-02-08 20:18:42',26),(47,'sdvfbvgnh','Verify task completion for: fdgbnhj','','Verification for barath for testing','ack_6988efbe2f2dd5.98937228.pdf','ack_6988effcba7708.75187077.pdf','2026-02-09 01:50:12',26,NULL,'completed','2026-02-08 20:19:10',NULL),(48,'aaaaaa','aaaaaaaaa','Teaching','research',NULL,NULL,NULL,26,'2026-02-09 03:00:00','completed','2026-02-08 21:09:46',NULL),(49,'alert remainder','alert remainder','Research','wdsefg',NULL,NULL,NULL,26,'2026-02-09 03:00:00','pending','2026-02-08 21:11:32',NULL);
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('admin','employee') COLLATE utf8mb4_general_ci NOT NULL,
  `department` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Oliver','admin','$2y$10$TnyR1Y43m1EIWpb0MiwE8Ocm6rj0F2KojE3PobVfQDo9HYlAHY/7O','admin','AIML','2024-08-28 07:10:04'),(9,'DR.R.Balaji Ganesh','balaji','$2y$12$HAQ2CsD9R.6Dky1hDst4auSodWOC2E8I6nTv8zLxPQBPfe5wXCYEC','employee',NULL,'2026-02-06 07:48:13'),(10,'Dr.S.Saravanakumar','Saravanakumar','$2y$12$KobHwMHehtrjUHCLCczGgOUez4OKviD.zCHTtSOLEjqK9Cs8tGQ/S','employee',NULL,'2026-02-06 07:50:57'),(12,'Dr.Thurai Pandian M','ThuraipandianM','$2y$12$CN2LtQNUEyPfkvatP1KwAu/sXActWmGyf6U8Vcbj6CE.8N5PwCx96','employee',NULL,'2026-02-06 07:52:03'),(13,'Dr.S.Lakshmana Prakash','Lakshmanaprakash','$2y$12$ooBYinDYvXSKR/T8JlCTpeZGWy/JR1vp5W.r7sa7gvONUGl8eagV.','employee',NULL,'2026-02-06 07:52:26'),(14,'Dr.M.Maragatharajan','Maragatharajan','$2y$12$qBJrQtqy.j1mjHoRjmrRye8R/DM1DO3DiP8uD.akfaJDAA56HpdkC','employee',NULL,'2026-02-06 07:53:24'),(15,'Dr.S.Saravanan','SSaravanan','$2y$12$kT.Ky.HqmaLSPUvKqoOrY.Db3U3JEk51XaiXtBwiytqZfwmO81dNG','employee',NULL,'2026-02-06 07:53:46'),(16,'Dr.J.Shajeena','JShajeena','$2y$12$oxez1F8Mfufp2hq8OUnY6eqon7IavSCOWJvYIOdMs1EUdDe8mg.iK','employee',NULL,'2026-02-06 07:54:10'),(17,'Dr.Chitra PKA','PKAChitra','$2y$12$CZ612cjkfW1dI/aXyD7FzO7wp59WiQcM8K/3LXsGAQ7ZfDw5ZjNbm','employee',NULL,'2026-02-06 07:54:29'),(18,'Ms.L.Sasikala','LSasikala','$2y$12$pV0vbjpClZbF8qcg8e8d7.4IzGIUxmMQAO8FoAruWqPyvI37rP1Dq','employee',NULL,'2026-02-06 07:55:07'),(19,'Dr.Prabu S','SPrabu','$2y$12$EUOraLPZMqx35Tr9/eDrSu4G1c8moLjcYegwaW0TTbZl/l/gfm8Xa','employee',NULL,'2026-02-06 07:55:32'),(20,'Ms.Priyadharsini C','CPriyadharsini','$2y$12$ZxFbVxUDxydjKpFrBgaKVeWr4ml7rWWqMqKFuM0bA9DvsawQ8goiO','employee',NULL,'2026-02-06 07:55:53'),(21,'Dr.Gunasundari C','CGunasundari','$2y$12$Hh6vhi/TuDxabZZeE47IMOgzQ1b8d0WE/u/xSfyrfmXzpqeCgn.se','employee',NULL,'2026-02-06 07:56:15'),(22,'Prema','Prema','$2y$12$kEaJ0SCcZ0wpyvIGXYaDYORf60PK8pYJ8tUbx9tUWKRKFcrnDEh5O','employee',NULL,'2026-02-06 11:59:58'),(23,'Dr R Jagadeesh Kannan','deanfet','$2y$12$63TPHzNLZtSHnwB8xPQo/OXnEGFwFL3EZGPQaGtsqlYal.OX1Yt4i','employee',NULL,'2026-02-06 12:14:45'),(24,'Dr. M. Padmapriya','MPadmapriya','$2y$12$abpf6WpMQ1pFe5qrEZ7ThO64uZXql/CtB8KDR11aIrYZPUUaf9BcC','employee',NULL,'2026-02-06 12:24:31'),(25,'barath for testing','barath for testing','$2y$12$sg2kIBEgvH0PGQ/HOST5ze0KiHvOVwgV4tIMYwGb8xb4OVfWs7YWC','employee','Physics','2026-02-06 14:29:03'),(26,'barathtest','barathtest','$2y$12$8V9gTtoj4noxTHVfeBQDV.qFA.iORFADJiDdAELU6s02PGYqf4SVS','employee','AIML','2026-02-08 18:27:10');
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

-- Dump completed on 2026-02-09 12:07:29
