-- MySQL dump 10.13  Distrib 8.0.41, for Linux (x86_64)
--
-- Host: mysql    Database: example_app
-- ------------------------------------------------------
-- Server version	8.0.32

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
-- Dumping data for table `academicworks`
--

LOCK TABLES `academicworks` WRITE;
/*!40000 ALTER TABLE `academicworks` DISABLE KEYS */;
/*!40000 ALTER TABLE `academicworks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `author_of_academicworks`
--

LOCK TABLES `author_of_academicworks` WRITE;
/*!40000 ALTER TABLE `author_of_academicworks` DISABLE KEYS */;
/*!40000 ALTER TABLE `author_of_academicworks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `author_of_papers`
--

LOCK TABLES `author_of_papers` WRITE;
/*!40000 ALTER TABLE `author_of_papers` DISABLE KEYS */;
/*!40000 ALTER TABLE `author_of_papers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `authors`
--

LOCK TABLES `authors` WRITE;
/*!40000 ALTER TABLE `authors` DISABLE KEYS */;
/*!40000 ALTER TABLE `authors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `books`
--

LOCK TABLES `books` WRITE;
/*!40000 ALTER TABLE `books` DISABLE KEYS */;
/*!40000 ALTER TABLE `books` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `courses`
--

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `degrees`
--

LOCK TABLES `degrees` WRITE;
/*!40000 ALTER TABLE `degrees` DISABLE KEYS */;
/*!40000 ALTER TABLE `degrees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `departments`
--

LOCK TABLES `departments` WRITE;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
/*!40000 ALTER TABLE `departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `education`
--

LOCK TABLES `education` WRITE;
/*!40000 ALTER TABLE `education` DISABLE KEYS */;
/*!40000 ALTER TABLE `education` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `expertises`
--

LOCK TABLES `expertises` WRITE;
/*!40000 ALTER TABLE `expertises` DISABLE KEYS */;
/*!40000 ALTER TABLE `expertises` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `files`
--

LOCK TABLES `files` WRITE;
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
/*!40000 ALTER TABLE `files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `fund_of_research`
--

LOCK TABLES `fund_of_research` WRITE;
/*!40000 ALTER TABLE `fund_of_research` DISABLE KEYS */;
/*!40000 ALTER TABLE `fund_of_research` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `funds`
--

LOCK TABLES `funds` WRITE;
/*!40000 ALTER TABLE `funds` DISABLE KEYS */;
/*!40000 ALTER TABLE `funds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `highlight_papers`
--

LOCK TABLES `highlight_papers` WRITE;
/*!40000 ALTER TABLE `highlight_papers` DISABLE KEYS */;
/*!40000 ALTER TABLE `highlight_papers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1,'2013_01_19_060928_create_departments_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (2,'2014_10_12_000000_create_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (3,'2014_10_12_100000_create_password_resets_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (4,'2019_08_19_000000_create_failed_jobs_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (5,'2021_11_02_091209_create_papers_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (6,'2021_11_02_091502_teacher__paper',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (7,'2021_11_07_093357_create_source_datas_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (8,'2021_11_07_093614_list_of_published',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (9,'2021_12_30_085642_create_funds_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (10,'2021_12_30_131353_create_research_projects_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (11,'2021_12_30_131609_create_work_of_research_projects_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (12,'2022_01_05_075720_create_fund_of_research_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (13,'2022_01_09_153100_create_authors_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (14,'2022_01_09_180504_author_of__paper',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (15,'2022_01_10_084125_create_permission_tables',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (16,'2022_01_14_065903_create_research_group_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (17,'2022_01_14_075140_create_work_of_research_groups_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (18,'2022_01_17_123959_create_posts_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (19,'2022_01_19_061454_create_work_of_department_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (20,'2022_01_26_091510_create_files_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (21,'2022_01_26_145335_create_products_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (22,'2022_01_27_092357_create_books_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (23,'2022_01_27_100103_create_customers_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (24,'2022_02_17_085429_create_expertises_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (25,'2022_02_22_075942_create_categories_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (26,'2022_03_14_160716_create_degrees_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (27,'2022_03_15_141518_create_programs_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (28,'2022_03_15_164730_add_programs_to_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (29,'2022_03_28_225334_create_education_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (30,'2022_03_31_222122_create_courses_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (31,'2022_04_17_221919_create_academicworks_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (32,'2022_04_17_222540_create_user_of_academicworks',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (33,'2022_04_17_222553_create_author_of_academicworks',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (34,'2022_04_29_143111_create_outsiders_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (35,'2022_04_29_155014_create_outsiders_work_of_project_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (36,'2025_02_08_002124_create_highlight_papers_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `outsiders`
--

LOCK TABLES `outsiders` WRITE;
/*!40000 ALTER TABLE `outsiders` DISABLE KEYS */;
/*!40000 ALTER TABLE `outsiders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `outsiders_work_of_project`
--

LOCK TABLES `outsiders_work_of_project` WRITE;
/*!40000 ALTER TABLE `outsiders_work_of_project` DISABLE KEYS */;
/*!40000 ALTER TABLE `outsiders_work_of_project` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `papers`
--

LOCK TABLES `papers` WRITE;
/*!40000 ALTER TABLE `papers` DISABLE KEYS */;
/*!40000 ALTER TABLE `papers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `programs`
--

LOCK TABLES `programs` WRITE;
/*!40000 ALTER TABLE `programs` DISABLE KEYS */;
/*!40000 ALTER TABLE `programs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `research_groups`
--

LOCK TABLES `research_groups` WRITE;
/*!40000 ALTER TABLE `research_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `research_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `research_projects`
--

LOCK TABLES `research_projects` WRITE;
/*!40000 ALTER TABLE `research_projects` DISABLE KEYS */;
/*!40000 ALTER TABLE `research_projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `source_data`
--

LOCK TABLES `source_data` WRITE;
/*!40000 ALTER TABLE `source_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `source_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `source_papers`
--

LOCK TABLES `source_papers` WRITE;
/*!40000 ALTER TABLE `source_papers` DISABLE KEYS */;
/*!40000 ALTER TABLE `source_papers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `teacher_papers`
--

LOCK TABLES `teacher_papers` WRITE;
/*!40000 ALTER TABLE `teacher_papers` DISABLE KEYS */;
/*!40000 ALTER TABLE `teacher_papers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `user_of_academicworks`
--

LOCK TABLES `user_of_academicworks` WRITE;
/*!40000 ALTER TABLE `user_of_academicworks` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_of_academicworks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `work_of_research_groups`
--

LOCK TABLES `work_of_research_groups` WRITE;
/*!40000 ALTER TABLE `work_of_research_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `work_of_research_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `work_of_research_projects`
--

LOCK TABLES `work_of_research_projects` WRITE;
/*!40000 ALTER TABLE `work_of_research_projects` DISABLE KEYS */;
/*!40000 ALTER TABLE `work_of_research_projects` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-02-10  7:00:53
