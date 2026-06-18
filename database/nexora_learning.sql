-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: nexora_learning
-- ------------------------------------------------------
-- Server version	8.0.30

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
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `certificate_templates`
--

DROP TABLE IF EXISTS `certificate_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `certificate_templates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Certificate of Completion',
  `subtitle` text COLLATE utf8mb4_unicode_ci,
  `body_text` text COLLATE utf8mb4_unicode_ci,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `background_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `background_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#FFFFFF',
  `primary_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#1E40AF',
  `secondary_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#3B82F6',
  `accent_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#06B6D4',
  `text_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#0F172A',
  `font_family` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Helvetica',
  `orientation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'landscape',
  `paper_size` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'letter',
  `show_logo` tinyint(1) NOT NULL DEFAULT '1',
  `show_qr` tinyint(1) NOT NULL DEFAULT '1',
  `show_signature` tinyint(1) NOT NULL DEFAULT '0',
  `signature_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signature_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signature_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `custom_styles` json DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `certificate_templates_company_id_foreign` (`company_id`),
  CONSTRAINT `certificate_templates_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `certificate_templates`
--

LOCK TABLES `certificate_templates` WRITE;
/*!40000 ALTER TABLE `certificate_templates` DISABLE KEYS */;
INSERT INTO `certificate_templates` VALUES (1,1,'Certificado Estándar Nexora','Certificate of Completion','Otorgado a','Por haber completado satisfactoriamente el curso y demostrado los conocimientos requeridos.',NULL,NULL,'#FFFFFF','#1E40AF','#3B82F6','#06B6D4','#0F172A','Helvetica','landscape','letter',1,1,1,NULL,'María Gómez','Directora de Formación',NULL,1,1,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(2,1,'Certificado Premium','Certificado de Excelencia','Se certifica que','Ha demostrado un desempeño excepcional completando el programa de formación avanzada.',NULL,NULL,'#F8FAFC','#1E40AF','#10B981','#F59E0B','#0F172A','Helvetica','landscape','letter',1,1,1,NULL,'Javier Teherán','CEO',NULL,0,1,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL);
/*!40000 ALTER TABLE `certificate_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `certificates`
--

DROP TABLE IF EXISTS `certificates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `certificates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint unsigned NOT NULL,
  `employee_id` bigint unsigned NOT NULL,
  `course_id` bigint unsigned DEFAULT NULL,
  `evaluation_id` bigint unsigned DEFAULT NULL,
  `template_id` bigint unsigned DEFAULT NULL,
  `certificate_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `issue_date` date NOT NULL,
  `expiry_date` date DEFAULT NULL,
  `score` decimal(5,2) DEFAULT NULL,
  `qr_code_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pdf_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `metadata` json DEFAULT NULL,
  `status` enum('active','revoked','expired') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `certificates_certificate_code_unique` (`certificate_code`),
  KEY `certificates_company_id_foreign` (`company_id`),
  KEY `certificates_employee_id_foreign` (`employee_id`),
  KEY `certificates_course_id_foreign` (`course_id`),
  KEY `certificates_evaluation_id_foreign` (`evaluation_id`),
  KEY `certificates_template_id_foreign` (`template_id`),
  CONSTRAINT `certificates_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `certificates_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE SET NULL,
  CONSTRAINT `certificates_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `certificates_evaluation_id_foreign` FOREIGN KEY (`evaluation_id`) REFERENCES `evaluations` (`id`) ON DELETE SET NULL,
  CONSTRAINT `certificates_template_id_foreign` FOREIGN KEY (`template_id`) REFERENCES `certificate_templates` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `certificates`
--

LOCK TABLES `certificates` WRITE;
/*!40000 ALTER TABLE `certificates` DISABLE KEYS */;
/*!40000 ALTER TABLE `certificates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `companies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'Colombia',
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `settings` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `companies_slug_unique` (`slug`),
  UNIQUE KEY `companies_nit_unique` (`nit`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `companies`
--

LOCK TABLES `companies` WRITE;
/*!40000 ALTER TABLE `companies` DISABLE KEYS */;
INSERT INTO `companies` VALUES (1,'Nexora Technologies','nexora-technologies','900.123.456-1','contacto@nexora.com.co','+57 601 234 5678','Carrera 15 #93-60, Torre B','Bogotá','Colombia',NULL,1,'\"{\\\"timezone\\\":\\\"America\\\\/Bogota\\\",\\\"language\\\":\\\"es\\\",\\\"date_format\\\":\\\"d\\\\/m\\\\/Y\\\"}\"','2026-06-18 07:39:21','2026-06-18 07:39:21',NULL),(2,'Innovación Digital SAS','innovacion-digital','800.987.654-2','info@innovaciondigital.com','+57 604 345 6789','Calle 10 #43E-25, Edificio Inteligente','Medellín','Colombia',NULL,1,'\"{\\\"timezone\\\":\\\"America\\\\/Bogota\\\",\\\"language\\\":\\\"es\\\",\\\"date_format\\\":\\\"d\\\\/m\\\\/Y\\\"}\"','2026-06-18 07:39:21','2026-06-18 07:39:21',NULL),(3,'Aprendizaje Global Ltda','aprendizaje-global','700.555.333-3','hola@aprendizajeglobal.co','+57 602 456 7890','Avenida 6N #17-40, Centro Empresarial','Cali','Colombia',NULL,1,'\"{\\\"timezone\\\":\\\"America\\\\/Bogota\\\",\\\"language\\\":\\\"es\\\",\\\"date_format\\\":\\\"d\\\\/m\\\\/Y\\\"}\"','2026-06-18 07:39:21','2026-06-18 07:39:21',NULL);
/*!40000 ALTER TABLE `companies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_categories`
--

DROP TABLE IF EXISTS `course_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `course_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint unsigned NOT NULL,
  `parent_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `course_categories_slug_unique` (`slug`),
  KEY `course_categories_company_id_foreign` (`company_id`),
  KEY `course_categories_parent_id_foreign` (`parent_id`),
  CONSTRAINT `course_categories_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `course_categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `course_categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_categories`
--

LOCK TABLES `course_categories` WRITE;
/*!40000 ALTER TABLE `course_categories` DISABLE KEYS */;
INSERT INTO `course_categories` VALUES (1,1,NULL,'Tecnología','tecnologia','Cursos de tecnología y desarrollo','pi pi-code','#1E40AF',1,1,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(2,1,NULL,'Liderazgo','liderazgo','Habilidades de liderazgo y gestión','pi pi-users','#3B82F6',2,1,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(3,1,NULL,'Ventas','ventas','Técnicas de ventas y negociación','pi pi-chart-line','#06B6D4',3,1,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(4,1,NULL,'Desarrollo Personal','desarrollo-personal','Crecimiento personal y profesional','pi pi-star','#10B981',4,1,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(5,1,NULL,'Seguridad','seguridad','Seguridad informática y física','pi pi-shield','#EF4444',5,1,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(6,1,NULL,'Idiomas','idiomas','Aprendizaje de idiomas','pi pi-globe','#F59E0B',6,1,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL);
/*!40000 ALTER TABLE `course_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_enrollments`
--

DROP TABLE IF EXISTS `course_enrollments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `course_enrollments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `course_id` bigint unsigned NOT NULL,
  `employee_id` bigint unsigned NOT NULL,
  `company_id` bigint unsigned NOT NULL,
  `progress` decimal(5,2) NOT NULL DEFAULT '0.00',
  `status` enum('enrolled','in_progress','completed','failed','dropped') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'enrolled',
  `enrolled_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `started_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `score` decimal(5,2) DEFAULT NULL,
  `attempts` int NOT NULL DEFAULT '0',
  `metadata` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `course_enrollment_unique` (`course_id`,`employee_id`),
  KEY `course_enrollments_employee_id_foreign` (`employee_id`),
  KEY `course_enrollments_company_id_foreign` (`company_id`),
  CONSTRAINT `course_enrollments_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `course_enrollments_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `course_enrollments_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_enrollments`
--

LOCK TABLES `course_enrollments` WRITE;
/*!40000 ALTER TABLE `course_enrollments` DISABLE KEYS */;
/*!40000 ALTER TABLE `course_enrollments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_lessons`
--

DROP TABLE IF EXISTS `course_lessons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `course_lessons` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `module_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `content_type` enum('text','image','video','audio','pdf','link','embed','quiz') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `video_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `audio_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `external_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration_minutes` int NOT NULL DEFAULT '0',
  `sort_order` int NOT NULL DEFAULT '0',
  `is_published` tinyint(1) NOT NULL DEFAULT '1',
  `is_preview` tinyint(1) NOT NULL DEFAULT '0',
  `attachments` json DEFAULT NULL,
  `metadata` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `course_lessons_module_id_foreign` (`module_id`),
  CONSTRAINT `course_lessons_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `course_modules` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_lessons`
--

LOCK TABLES `course_lessons` WRITE;
/*!40000 ALTER TABLE `course_lessons` DISABLE KEYS */;
INSERT INTO `course_lessons` VALUES (1,1,'¿Qué es el Desarrollo Web?',NULL,'text','<p>El desarrollo web es el proceso de crear sitios y aplicaciones web...</p>',NULL,NULL,NULL,NULL,15,1,1,0,NULL,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(2,1,'Estructura de un Proyecto Web',NULL,'text','<p>Un proyecto web típico contiene archivos HTML, CSS y JavaScript...</p>',NULL,NULL,NULL,NULL,20,2,1,0,NULL,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(3,1,'Herramientas del Desarrollador',NULL,'video',NULL,'https://www.youtube.com/watch?v=example',NULL,NULL,NULL,25,3,1,0,NULL,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(4,2,'Etiquetas HTML Básicas',NULL,'text','<p>HTML usa etiquetas como h1, p, div, span...</p>',NULL,NULL,NULL,NULL,30,1,1,0,NULL,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(5,2,'Formularios HTML',NULL,'text','<p>Los formularios permiten recopilar datos del usuario...</p>',NULL,NULL,NULL,NULL,30,2,1,0,NULL,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(6,2,'Semántica HTML5',NULL,'text','<p>HTML5 introdujo etiquetas semánticas como header, nav, main...</p>',NULL,NULL,NULL,NULL,30,3,1,0,NULL,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(7,3,'Selectores CSS',NULL,'text','<p>Los selectores CSS permiten seleccionar elementos HTML para aplicar estilos...</p>',NULL,NULL,NULL,NULL,30,1,1,0,NULL,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(8,3,'Flexbox y Grid',NULL,'video',NULL,'https://www.youtube.com/watch?v=flexbox',NULL,NULL,NULL,45,2,1,0,NULL,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(9,3,'Diseño Responsive',NULL,'text','<p>El diseño responsive adapta la interfaz a diferentes tamaños de pantalla...</p>',NULL,NULL,NULL,NULL,45,3,1,0,NULL,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(10,4,'Variables y Tipos de Datos',NULL,'text','<p>JavaScript tiene varios tipos de datos: string, number, boolean...</p>',NULL,NULL,NULL,NULL,30,1,1,0,NULL,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(11,4,'Funciones y Eventos',NULL,'text','<p>Las funciones son bloques de código reutilizables...</p>',NULL,NULL,NULL,NULL,45,2,1,0,NULL,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(12,4,'Manipulación del DOM',NULL,'video',NULL,'https://www.youtube.com/watch?v=dom',NULL,NULL,NULL,45,3,1,0,NULL,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(13,5,'Manifiesto Ágil',NULL,'text','<p>El Manifiesto Ágil establece 4 valores y 12 principios...</p>',NULL,NULL,NULL,NULL,30,1,1,0,NULL,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(14,5,'Roles en Scrum',NULL,'text','<p>Scrum define tres roles: Product Owner, Scrum Master y Development Team...</p>',NULL,NULL,NULL,NULL,30,2,1,0,NULL,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(15,5,'Ceremonias Ágiles',NULL,'video',NULL,'https://www.youtube.com/watch?v=scrum',NULL,NULL,NULL,30,3,1,0,NULL,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(16,6,'Escucha Activa',NULL,'text','<p>La escucha activa es fundamental para un liderazgo efectivo...</p>',NULL,NULL,NULL,NULL,30,1,1,0,NULL,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(17,6,'Feedback Constructivo',NULL,'text','<p>Dar y recibir feedback de manera constructiva fortalece el equipo...</p>',NULL,NULL,NULL,NULL,30,2,1,0,NULL,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(18,7,'Bienvenida al Curso',NULL,'text','<p>Bienvenido a este curso. Aquí aprenderás los fundamentos...</p>',NULL,NULL,NULL,NULL,20,1,1,0,NULL,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(19,7,'Objetivos de Aprendizaje',NULL,'text','<p>Al finalizar este curso, serás capaz de...</p>',NULL,NULL,NULL,NULL,20,2,1,0,NULL,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(20,7,'Metodología',NULL,'video',NULL,'https://www.youtube.com/watch?v=intro',NULL,NULL,NULL,20,3,1,0,NULL,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(21,8,'Conceptos Clave',NULL,'text','<p>Los conceptos fundamentales que necesitas dominar...</p>',NULL,NULL,NULL,NULL,45,1,1,0,NULL,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(22,8,'Caso Práctico',NULL,'text','<p>Aplicaremos lo aprendido en un caso real...</p>',NULL,NULL,NULL,NULL,45,2,1,0,NULL,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL);
/*!40000 ALTER TABLE `course_lessons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_modules`
--

DROP TABLE IF EXISTS `course_modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `course_modules` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `course_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `sort_order` int NOT NULL DEFAULT '0',
  `duration_minutes` int NOT NULL DEFAULT '0',
  `is_published` tinyint(1) NOT NULL DEFAULT '1',
  `metadata` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `course_modules_course_id_foreign` (`course_id`),
  CONSTRAINT `course_modules_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_modules`
--

LOCK TABLES `course_modules` WRITE;
/*!40000 ALTER TABLE `course_modules` DISABLE KEYS */;
INSERT INTO `course_modules` VALUES (1,1,'Introducción al Desarrollo Web','Conceptos básicos',1,60,1,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(2,1,'HTML5 Fundamentos','Etiquetas y estructura',2,90,1,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(3,1,'CSS3 y Diseño Responsive','Estilizado y layouts',3,120,1,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(4,1,'JavaScript Básico','Fundamentos de programación',4,120,1,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(5,2,'Fundamentos del Liderazgo Ágil','Principios ágiles',1,90,1,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(6,2,'Comunicación Efectiva','Habilidades comunicativas',2,60,1,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(7,3,'Módulo 1: Introducción','Conceptos fundamentales',1,60,1,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(8,3,'Módulo 2: Contenido Principal','Desarrollo del tema',2,90,1,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL);
/*!40000 ALTER TABLE `course_modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `courses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned DEFAULT NULL,
  `instructor_id` bigint unsigned DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `objectives` text COLLATE utf8mb4_unicode_ci,
  `requirements` text COLLATE utf8mb4_unicode_ci,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cover_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration_hours` int NOT NULL DEFAULT '0',
  `duration_minutes` int NOT NULL DEFAULT '0',
  `level` enum('beginner','intermediate','advanced','expert') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'beginner',
  `status` enum('draft','published','archived') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `has_certificate` tinyint(1) NOT NULL DEFAULT '0',
  `passing_score` decimal(5,2) NOT NULL DEFAULT '70.00',
  `max_attempts` int NOT NULL DEFAULT '3',
  `sort_order` int NOT NULL DEFAULT '0',
  `metadata` json DEFAULT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `courses_slug_unique` (`slug`),
  KEY `courses_company_id_foreign` (`company_id`),
  KEY `courses_category_id_foreign` (`category_id`),
  KEY `courses_instructor_id_foreign` (`instructor_id`),
  CONSTRAINT `courses_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `course_categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `courses_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `courses_instructor_id_foreign` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courses`
--

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
INSERT INTO `courses` VALUES (1,1,1,3,'Fundamentos de Programación Web','fundamentos-programacion-web','Aprende los fundamentos de HTML, CSS y JavaScript para desarrollo web moderno.','Comprender la estructura de páginas web, estilizar con CSS, programar interactividad con JavaScript.',NULL,NULL,NULL,0,0,'beginner','published',0,1,70.00,3,0,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(2,1,2,3,'Liderazgo Efectivo en Equipos Ágiles','liderazgo-efectivo-equipos-agiles','Desarrolla habilidades de liderazgo para gestionar equipos ágiles de alto rendimiento.','Aprender metodologías ágiles, gestión de equipos, comunicación efectiva.',NULL,NULL,NULL,0,0,'intermediate','published',0,1,75.00,2,0,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(3,1,3,3,'Técnicas Avanzadas de Negociación','tecnicas-avanzadas-negociacion','Domina las técnicas de negociación moderna para cerrar más ventas.',NULL,NULL,NULL,NULL,0,0,'advanced','published',0,1,80.00,2,0,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24','2026-06-18 07:39:24',NULL);
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee_imports`
--

DROP TABLE IF EXISTS `employee_imports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employee_imports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_rows` int NOT NULL DEFAULT '0',
  `successful_rows` int NOT NULL DEFAULT '0',
  `failed_rows` int NOT NULL DEFAULT '0',
  `errors` json DEFAULT NULL,
  `status` enum('pending','processing','completed','failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_imports_company_id_foreign` (`company_id`),
  KEY `employee_imports_user_id_foreign` (`user_id`),
  CONSTRAINT `employee_imports_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `employee_imports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_imports`
--

LOCK TABLES `employee_imports` WRITE;
/*!40000 ALTER TABLE `employee_imports` DISABLE KEYS */;
/*!40000 ALTER TABLE `employee_imports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employees` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `document_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'CC',
  `document_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive','suspended') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `hire_date` date DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `metadata` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `employees_document_number_unique` (`document_number`),
  KEY `employees_company_id_foreign` (`company_id`),
  KEY `employees_user_id_foreign` (`user_id`),
  CONSTRAINT `employees_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `employees_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
INSERT INTO `employees` VALUES (1,1,NULL,'Andrea','Ramírez','CC','1234567890','aramirez@nexoratech.com','+57 310 111 2233','Desarrollador Senior','Tecnología','Desarrollo','active','2024-01-15',NULL,'Femenino',NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(2,1,NULL,'Juan','Pérez','CC','2345678901','jperez@nexoratech.com','+57 310 222 3344','Ingeniero DevOps','Tecnología','Infraestructura','active','2024-02-20',NULL,'Masculino',NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(3,1,NULL,'Sofía','García','CC','3456789012','sgarcia@nexoratech.com','+57 310 333 4455','Diseñadora UX/UI','Diseño','UX','active','2024-03-10',NULL,'Femenino',NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(4,1,NULL,'Miguel','Ortiz','CC','4567890123','mortiz@nexoratech.com','+57 310 444 5566','Gerente de Proyecto','Operaciones','Proyectos','active','2024-04-05',NULL,'Masculino',NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(5,1,NULL,'Valentina','Castro','CC','5678901234','vcastro@nexoratech.com','+57 310 555 6677','Analista QA','Calidad','Testing','active','2024-05-15',NULL,'Femenino',NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(6,1,NULL,'Daniel','Morales','CC','6789012345','dmorales@nexoratech.com','+57 310 666 7788','Business Analyst','Negocios','Análisis','active','2024-06-01',NULL,'Masculino',NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(7,1,NULL,'Camila','Ríos','CC','7890123456','crios@nexoratech.com','+57 310 777 8899','Data Scientist','Tecnología','Datos','active','2024-07-10',NULL,'Femenino',NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(8,1,NULL,'Andrés','Vargas','CC','8901234567','avargas@nexoratech.com','+57 310 888 9900','Soporte Técnico','Soporte','Help Desk','active','2024-08-20',NULL,'Masculino',NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(9,1,NULL,'Natalia','Jiménez','CC','9012345678','njimenez@nexoratech.com','+57 310 999 0011','Marketing Digital','Marketing','Digital','active','2024-09-05',NULL,'Femenino',NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(10,1,NULL,'Fernando','Medina','CC','0123456789','fmedina@nexoratech.com','+57 310 000 1122','Contador','Finanzas','Contabilidad','inactive','2024-10-01',NULL,'Masculino',NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL);
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evaluation_answers`
--

DROP TABLE IF EXISTS `evaluation_answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `evaluation_answers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `attempt_id` bigint unsigned NOT NULL,
  `question_id` bigint unsigned NOT NULL,
  `selected_options` json DEFAULT NULL,
  `text_answer` text COLLATE utf8mb4_unicode_ci,
  `is_correct` tinyint(1) NOT NULL DEFAULT '0',
  `points_earned` decimal(5,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `evaluation_answers_attempt_id_foreign` (`attempt_id`),
  KEY `evaluation_answers_question_id_foreign` (`question_id`),
  CONSTRAINT `evaluation_answers_attempt_id_foreign` FOREIGN KEY (`attempt_id`) REFERENCES `evaluation_attempts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `evaluation_answers_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evaluation_answers`
--

LOCK TABLES `evaluation_answers` WRITE;
/*!40000 ALTER TABLE `evaluation_answers` DISABLE KEYS */;
/*!40000 ALTER TABLE `evaluation_answers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evaluation_attempts`
--

DROP TABLE IF EXISTS `evaluation_attempts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `evaluation_attempts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `evaluation_id` bigint unsigned NOT NULL,
  `employee_id` bigint unsigned NOT NULL,
  `company_id` bigint unsigned NOT NULL,
  `attempt_number` int NOT NULL DEFAULT '1',
  `score` decimal(5,2) DEFAULT NULL,
  `total_points` decimal(5,2) DEFAULT NULL,
  `percentage` decimal(5,2) DEFAULT NULL,
  `is_passed` tinyint(1) NOT NULL DEFAULT '0',
  `status` enum('in_progress','completed','timed_out','abandoned') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'in_progress',
  `time_spent_seconds` int NOT NULL DEFAULT '0',
  `started_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `questions_snapshot` json DEFAULT NULL,
  `metadata` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `evaluation_attempts_evaluation_id_foreign` (`evaluation_id`),
  KEY `evaluation_attempts_employee_id_foreign` (`employee_id`),
  KEY `evaluation_attempts_company_id_foreign` (`company_id`),
  CONSTRAINT `evaluation_attempts_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `evaluation_attempts_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `evaluation_attempts_evaluation_id_foreign` FOREIGN KEY (`evaluation_id`) REFERENCES `evaluations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evaluation_attempts`
--

LOCK TABLES `evaluation_attempts` WRITE;
/*!40000 ALTER TABLE `evaluation_attempts` DISABLE KEYS */;
/*!40000 ALTER TABLE `evaluation_attempts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evaluations`
--

DROP TABLE IF EXISTS `evaluations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `evaluations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint unsigned NOT NULL,
  `course_id` bigint unsigned DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `instructions` text COLLATE utf8mb4_unicode_ci,
  `total_questions` int NOT NULL DEFAULT '10',
  `time_limit_minutes` int NOT NULL DEFAULT '30',
  `passing_score` decimal(5,2) NOT NULL DEFAULT '70.00',
  `max_attempts` int NOT NULL DEFAULT '3',
  `randomize_questions` tinyint(1) NOT NULL DEFAULT '1',
  `randomize_options` tinyint(1) NOT NULL DEFAULT '1',
  `show_results` tinyint(1) NOT NULL DEFAULT '1',
  `show_correct_answers` tinyint(1) NOT NULL DEFAULT '0',
  `status` enum('draft','published','archived') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `question_categories` json DEFAULT NULL,
  `difficulty_distribution` json DEFAULT NULL,
  `available_from` timestamp NULL DEFAULT NULL,
  `available_until` timestamp NULL DEFAULT NULL,
  `metadata` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `evaluations_company_id_foreign` (`company_id`),
  KEY `evaluations_course_id_foreign` (`course_id`),
  CONSTRAINT `evaluations_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `evaluations_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evaluations`
--

LOCK TABLES `evaluations` WRITE;
/*!40000 ALTER TABLE `evaluations` DISABLE KEYS */;
INSERT INTO `evaluations` VALUES (1,1,1,'Evaluación Final - Fundamentos de Programación Web','Evaluación final del curso de fundamentos de programación web.','Responde todas las preguntas. Tienes 30 minutos. Necesitas 70% para aprobar.',10,30,70.00,3,1,1,1,0,'published','\"[\\\"desarrollo-web\\\"]\"','\"{\\\"easy\\\":40,\\\"medium\\\":40,\\\"hard\\\":20}\"',NULL,NULL,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(2,1,2,'Evaluación Final - Liderazgo Efectivo','Evaluación del curso de liderazgo efectivo en equipos ágiles.','Responde todas las preguntas. Tienes 25 minutos.',8,25,75.00,2,1,1,1,0,'published','\"[\\\"liderazgo-preguntas\\\"]\"','\"{\\\"easy\\\":50,\\\"medium\\\":50}\"',NULL,NULL,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL);
/*!40000 ALTER TABLE `evaluations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lesson_progress`
--

DROP TABLE IF EXISTS `lesson_progress`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lesson_progress` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `lesson_id` bigint unsigned NOT NULL,
  `employee_id` bigint unsigned NOT NULL,
  `company_id` bigint unsigned NOT NULL,
  `is_completed` tinyint(1) NOT NULL DEFAULT '0',
  `time_spent_seconds` int NOT NULL DEFAULT '0',
  `started_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `metadata` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lesson_progress_unique` (`lesson_id`,`employee_id`),
  KEY `lesson_progress_employee_id_foreign` (`employee_id`),
  KEY `lesson_progress_company_id_foreign` (`company_id`),
  CONSTRAINT `lesson_progress_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `lesson_progress_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `lesson_progress_lesson_id_foreign` FOREIGN KEY (`lesson_id`) REFERENCES `course_lessons` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lesson_progress`
--

LOCK TABLES `lesson_progress` WRITE;
/*!40000 ALTER TABLE `lesson_progress` DISABLE KEYS */;
/*!40000 ALTER TABLE `lesson_progress` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `microlearning_assignments`
--

DROP TABLE IF EXISTS `microlearning_assignments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `microlearning_assignments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `microlearning_content_id` bigint unsigned NOT NULL,
  `company_id` bigint unsigned NOT NULL,
  `assign_type` enum('employee','area','position','department','all') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'all',
  `assignee_id` bigint unsigned DEFAULT NULL,
  `assignee_value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assigned_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `microlearning_assignments_microlearning_content_id_foreign` (`microlearning_content_id`),
  KEY `microlearning_assignments_company_id_foreign` (`company_id`),
  CONSTRAINT `microlearning_assignments_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `microlearning_assignments_microlearning_content_id_foreign` FOREIGN KEY (`microlearning_content_id`) REFERENCES `microlearning_contents` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `microlearning_assignments`
--

LOCK TABLES `microlearning_assignments` WRITE;
/*!40000 ALTER TABLE `microlearning_assignments` DISABLE KEYS */;
/*!40000 ALTER TABLE `microlearning_assignments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `microlearning_contents`
--

DROP TABLE IF EXISTS `microlearning_contents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `microlearning_contents` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `content_type` enum('text','image','video','pdf','link','embed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `external_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `read_time_minutes` int NOT NULL DEFAULT '5',
  `frequency` enum('daily','weekly','custom') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'daily',
  `custom_cron` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('draft','published','archived') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `tags` json DEFAULT NULL,
  `metadata` json DEFAULT NULL,
  `scheduled_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `microlearning_contents_company_id_foreign` (`company_id`),
  CONSTRAINT `microlearning_contents_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `microlearning_contents`
--

LOCK TABLES `microlearning_contents` WRITE;
/*!40000 ALTER TABLE `microlearning_contents` DISABLE KEYS */;
INSERT INTO `microlearning_contents` VALUES (1,1,'Tip del día: Atajos de teclado en VS Code','Aprende los atajos más útiles para aumentar tu productividad.','text','<p>Ctrl+P: Abrir archivo rápidamente. Ctrl+Shift+P: Paleta de comandos. Ctrl+D: Seleccionar siguiente ocurrencia. Alt+↑/↓: Mover línea.</p>',NULL,NULL,NULL,NULL,3,'daily',NULL,'published','\"[\\\"productividad\\\",\\\"desarrollo\\\",\\\"tips\\\"]\"',NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(2,1,'Microlearning: Comunicación Asertiva','Técnica semanal para mejorar la comunicación en el equipo.','video','<p>La comunicación asertiva implica expresar tus ideas con claridad y respeto.</p>',NULL,'https://www.youtube.com/watch?v=comunicacion',NULL,NULL,5,'weekly',NULL,'published','\"[\\\"liderazgo\\\",\\\"comunicacion\\\",\\\"soft-skills\\\"]\"',NULL,'2026-06-19 07:39:24','2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(3,1,'Concepto: Principio de Responsabilidad Única (SOLID)','Uno de los principios SOLID más importantes en programación.','text','<p>El Principio de Responsabilidad Única establece que una clase debe tener una sola razón para cambiar. Esto hace el código más mantenible y fácil de entender.</p>',NULL,NULL,NULL,NULL,4,'daily',NULL,'published','\"[\\\"desarrollo\\\",\\\"arquitectura\\\",\\\"SOLID\\\"]\"',NULL,'2026-06-18 13:39:24','2026-06-18 07:39:24','2026-06-18 07:39:24',NULL);
/*!40000 ALTER TABLE `microlearning_contents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `microlearning_tracking`
--

DROP TABLE IF EXISTS `microlearning_tracking`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `microlearning_tracking` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `microlearning_content_id` bigint unsigned NOT NULL,
  `employee_id` bigint unsigned NOT NULL,
  `company_id` bigint unsigned NOT NULL,
  `status` enum('delivered','seen','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'delivered',
  `delivered_at` timestamp NULL DEFAULT NULL,
  `seen_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `time_spent_seconds` int NOT NULL DEFAULT '0',
  `metadata` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ml_tracking_unique` (`microlearning_content_id`,`employee_id`),
  KEY `microlearning_tracking_employee_id_foreign` (`employee_id`),
  KEY `microlearning_tracking_company_id_foreign` (`company_id`),
  CONSTRAINT `microlearning_tracking_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `microlearning_tracking_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `microlearning_tracking_microlearning_content_id_foreign` FOREIGN KEY (`microlearning_content_id`) REFERENCES `microlearning_contents` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `microlearning_tracking`
--

LOCK TABLES `microlearning_tracking` WRITE;
/*!40000 ALTER TABLE `microlearning_tracking` DISABLE KEYS */;
/*!40000 ALTER TABLE `microlearning_tracking` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_06_18_000001_create_companies_table',1),(5,'2026_06_18_000002_update_users_table',1),(6,'2026_06_18_000003_create_employees_table',1),(7,'2026_06_18_000004_create_course_categories_table',1),(8,'2026_06_18_000005_create_courses_table',1),(9,'2026_06_18_000006_create_course_modules_lessons_table',1),(10,'2026_06_18_000007_create_microlearning_tables',1),(11,'2026_06_18_000008_create_question_tables',1),(12,'2026_06_18_000009_create_evaluations_tables',1),(13,'2026_06_18_000010_create_certificates_tables',1),(14,'2026_06_18_000011_create_notifications_imports_tables',1),(15,'2026_06_18_012449_create_permission_tables',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',1),(2,'App\\Models\\User',2),(3,'App\\Models\\User',3),(4,'App\\Models\\User',4),(5,'App\\Models\\User',5),(2,'App\\Models\\User',6),(3,'App\\Models\\User',7);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notification_settings`
--

DROP TABLE IF EXISTS `notification_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notification_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `email_course_enrolled` tinyint(1) NOT NULL DEFAULT '1',
  `email_course_completed` tinyint(1) NOT NULL DEFAULT '1',
  `email_certificate_issued` tinyint(1) NOT NULL DEFAULT '1',
  `email_evaluation_assigned` tinyint(1) NOT NULL DEFAULT '1',
  `email_microlearning_daily` tinyint(1) NOT NULL DEFAULT '1',
  `push_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notification_settings_user_id_foreign` (`user_id`),
  CONSTRAINT `notification_settings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification_settings`
--

LOCK TABLES `notification_settings` WRITE;
/*!40000 ALTER TABLE `notification_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `notification_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint unsigned NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'users.view','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(2,'users.create','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(3,'users.edit','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(4,'users.delete','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(5,'employees.view','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(6,'employees.create','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(7,'employees.edit','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(8,'employees.delete','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(9,'employees.import','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(10,'employees.export','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(11,'courses.view','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(12,'courses.create','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(13,'courses.edit','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(14,'courses.delete','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(15,'modules.view','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(16,'modules.create','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(17,'modules.edit','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(18,'modules.delete','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(19,'lessons.view','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(20,'lessons.create','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(21,'lessons.edit','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(22,'lessons.delete','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(23,'enrollments.view','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(24,'enrollments.manage','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(25,'questions.view','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(26,'questions.create','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(27,'questions.edit','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(28,'questions.delete','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(29,'evaluations.view','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(30,'evaluations.create','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(31,'evaluations.edit','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(32,'evaluations.delete','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(33,'evaluations.grade','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(34,'certificates.view','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(35,'certificates.create','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(36,'certificates.revoke','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(37,'certificates.templates.manage','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(38,'microlearning.view','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(39,'microlearning.create','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(40,'microlearning.edit','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(41,'microlearning.delete','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(42,'microlearning.assign','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(43,'companies.view','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(44,'companies.create','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(45,'companies.edit','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(46,'companies.delete','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(47,'dashboard.view','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(48,'dashboard.export','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(49,'reports.view','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(50,'reports.export','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(51,'settings.view','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(52,'settings.edit','web','2026-06-18 07:39:21','2026-06-18 07:39:21');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question_categories`
--

DROP TABLE IF EXISTS `question_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `question_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `question_categories_slug_unique` (`slug`),
  KEY `question_categories_company_id_foreign` (`company_id`),
  CONSTRAINT `question_categories_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_categories`
--

LOCK TABLES `question_categories` WRITE;
/*!40000 ALTER TABLE `question_categories` DISABLE KEYS */;
INSERT INTO `question_categories` VALUES (1,1,'Desarrollo Web','desarrollo-web','Preguntas sobre HTML, CSS y JavaScript',1,'2026-06-18 07:39:24','2026-06-18 07:39:24'),(2,1,'Liderazgo','liderazgo-preguntas','Preguntas sobre liderazgo y gestión',1,'2026-06-18 07:39:24','2026-06-18 07:39:24'),(3,1,'Seguridad Informática','seguridad-informatica','Preguntas sobre ciberseguridad',1,'2026-06-18 07:39:24','2026-06-18 07:39:24');
/*!40000 ALTER TABLE `question_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question_options`
--

DROP TABLE IF EXISTS `question_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `question_options` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `question_id` bigint unsigned NOT NULL,
  `option_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_correct` tinyint(1) NOT NULL DEFAULT '0',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `question_options_question_id_foreign` (`question_id`),
  CONSTRAINT `question_options_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_options`
--

LOCK TABLES `question_options` WRITE;
/*!40000 ALTER TABLE `question_options` DISABLE KEYS */;
INSERT INTO `question_options` VALUES (1,1,'HyperText Markup Language',1,0,'2026-06-18 07:39:24','2026-06-18 07:39:24'),(2,1,'High Tech Modern Language',0,1,'2026-06-18 07:39:24','2026-06-18 07:39:24'),(3,1,'HyperTool Markup Language',0,2,'2026-06-18 07:39:24','2026-06-18 07:39:24'),(4,1,'Home Tool Markup Language',0,3,'2026-06-18 07:39:24','2026-06-18 07:39:24'),(5,2,'<p>',1,0,'2026-06-18 07:39:24','2026-06-18 07:39:24'),(6,2,'<paragraph>',0,1,'2026-06-18 07:39:24','2026-06-18 07:39:24'),(7,2,'<par>',0,2,'2026-06-18 07:39:24','2026-06-18 07:39:24'),(8,2,'<pg>',0,3,'2026-06-18 07:39:24','2026-06-18 07:39:24'),(9,3,'document.getElementById()',1,0,'2026-06-18 07:39:24','2026-06-18 07:39:24'),(10,3,'document.querySelectorClass()',0,1,'2026-06-18 07:39:24','2026-06-18 07:39:24'),(11,3,'document.getElementByName()',0,2,'2026-06-18 07:39:24','2026-06-18 07:39:24'),(12,3,'document.selectById()',0,3,'2026-06-18 07:39:24','2026-06-18 07:39:24'),(13,4,'Verdadero',1,0,'2026-06-18 07:39:24','2026-06-18 07:39:24'),(14,4,'Falso',0,1,'2026-06-18 07:39:24','2026-06-18 07:39:24'),(15,5,'Verdadero',0,0,'2026-06-18 07:39:24','2026-06-18 07:39:24'),(16,5,'Falso',1,1,'2026-06-18 07:39:24','2026-06-18 07:39:24'),(17,6,'React',1,0,'2026-06-18 07:39:24','2026-06-18 07:39:24'),(18,6,'Django',0,1,'2026-06-18 07:39:24','2026-06-18 07:39:24'),(19,6,'Vue.js',1,2,'2026-06-18 07:39:24','2026-06-18 07:39:24'),(20,6,'Angular',1,3,'2026-06-18 07:39:24','2026-06-18 07:39:24'),(21,7,'Individuos e interacciones sobre procesos y herramientas',1,0,'2026-06-18 07:39:24','2026-06-18 07:39:24'),(22,7,'Documentación exhaustiva sobre software funcionando',0,1,'2026-06-18 07:39:24','2026-06-18 07:39:24'),(23,7,'Seguir el plan sobre responder al cambio',0,2,'2026-06-18 07:39:24','2026-06-18 07:39:24'),(24,7,'Negociación de contratos sobre colaboración con el cliente',0,3,'2026-06-18 07:39:24','2026-06-18 07:39:24'),(25,8,'Verdadero',1,0,'2026-06-18 07:39:24','2026-06-18 07:39:24'),(26,8,'Falso',0,1,'2026-06-18 07:39:24','2026-06-18 07:39:24'),(27,9,'Un ataque que suplanta identidades para robar información',1,0,'2026-06-18 07:39:24','2026-06-18 07:39:24'),(28,9,'Un tipo de firewall',0,1,'2026-06-18 07:39:24','2026-06-18 07:39:24'),(29,9,'Un protocolo de cifrado',0,2,'2026-06-18 07:39:24','2026-06-18 07:39:24'),(30,9,'Un antivirus',0,3,'2026-06-18 07:39:24','2026-06-18 07:39:24'),(31,10,'Verdadero',0,0,'2026-06-18 07:39:24','2026-06-18 07:39:24'),(32,10,'Falso',1,1,'2026-06-18 07:39:24','2026-06-18 07:39:24');
/*!40000 ALTER TABLE `question_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `questions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned DEFAULT NULL,
  `type` enum('multiple_choice','true_false','multiple_select') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'multiple_choice',
  `difficulty` enum('easy','medium','hard') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'medium',
  `question_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `explanation` text COLLATE utf8mb4_unicode_ci,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `points` int NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `metadata` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `questions_company_id_foreign` (`company_id`),
  KEY `questions_category_id_foreign` (`category_id`),
  CONSTRAINT `questions_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `question_categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `questions_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions`
--

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
INSERT INTO `questions` VALUES (1,1,1,'multiple_choice','easy','¿Qué significa HTML?','HTML significa HyperText Markup Language, es el lenguaje estándar para crear páginas web.',NULL,1,1,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(2,1,1,'multiple_choice','easy','¿Cuál es la etiqueta correcta para un párrafo en HTML?',NULL,NULL,1,1,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(3,1,1,'multiple_choice','medium','¿Qué método JavaScript se usa para seleccionar un elemento por su ID?',NULL,NULL,1,1,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(4,1,1,'true_false','easy','CSS significa Cascading Style Sheets.','Correcto, CSS (Cascading Style Sheets) se usa para estilizar páginas web.',NULL,1,1,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(5,1,1,'true_false','medium','JavaScript solo se ejecuta en el servidor.','Falso, JavaScript se ejecuta tanto en el navegador (cliente) como en el servidor (Node.js).',NULL,1,1,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(6,1,1,'multiple_select','hard','¿Cuáles de los siguientes son frameworks de JavaScript? (Seleccione todos los que apliquen)','React, Vue.js y Angular son frameworks/bibliotecas de JavaScript. Django es de Python.',NULL,2,1,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(7,1,2,'multiple_choice','medium','¿Cuál es un principio del Manifiesto Ágil?',NULL,NULL,1,1,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(8,1,2,'true_false','easy','Un líder efectivo debe saber delegar responsabilidades.',NULL,NULL,1,1,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(9,1,3,'multiple_choice','medium','¿Qué es phishing?',NULL,NULL,1,1,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL),(10,1,3,'true_false','easy','Es seguro usar la misma contraseña en todas tus cuentas.',NULL,NULL,1,1,NULL,'2026-06-18 07:39:24','2026-06-18 07:39:24',NULL);
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(15,1),(16,1),(17,1),(18,1),(19,1),(20,1),(21,1),(22,1),(23,1),(24,1),(25,1),(26,1),(27,1),(28,1),(29,1),(30,1),(31,1),(32,1),(33,1),(34,1),(35,1),(36,1),(37,1),(38,1),(39,1),(40,1),(41,1),(42,1),(43,1),(44,1),(45,1),(46,1),(47,1),(48,1),(49,1),(50,1),(51,1),(52,1),(1,2),(2,2),(3,2),(5,2),(6,2),(7,2),(9,2),(10,2),(11,2),(12,2),(13,2),(15,2),(16,2),(17,2),(19,2),(20,2),(21,2),(23,2),(24,2),(25,2),(26,2),(27,2),(29,2),(30,2),(31,2),(33,2),(34,2),(35,2),(37,2),(38,2),(39,2),(40,2),(42,2),(47,2),(49,2),(50,2),(51,2),(52,2),(11,3),(13,3),(15,3),(16,3),(17,3),(19,3),(20,3),(21,3),(23,3),(25,3),(26,3),(27,3),(29,3),(30,3),(31,3),(33,3),(34,3),(38,3),(39,3),(40,3),(47,3),(5,4),(11,4),(23,4),(29,4),(33,4),(34,4),(38,4),(47,4),(49,4),(11,5),(19,5),(29,5),(34,5),(38,5),(47,5);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Super Administrador','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(2,'Administrador Empresa','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(3,'Instructor','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(4,'Supervisor','web','2026-06-18 07:39:21','2026-06-18 07:39:21'),(5,'Empleado','web','2026-06-18 07:39:21','2026-06-18 07:39:21');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `preferences` json DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_company_id_foreign` (`company_id`),
  CONSTRAINT `users_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,NULL,'Javier','Teherán',NULL,NULL,'admin@nexora.com','+57 300 111 2233','Super Administrador',NULL,1,NULL,NULL,'$2y$12$/awSFsR2y2Vzt/53f2XwkO.aqvDlPfnlKnLJef./7lcdaI.MuSIrm',NULL,'2026-06-18 07:39:23','2026-06-18 07:39:23',NULL),(2,1,'María','Gómez',NULL,NULL,'admin@nexoratech.com','+57 300 222 3344','Administrador Empresa',NULL,1,NULL,NULL,'$2y$12$klijmeZdDppeP26HXJJGOOD87SbD6/QOJ.kHD1KSUn2n8Wtf/YMeu',NULL,'2026-06-18 07:39:23','2026-06-18 07:39:23',NULL),(3,1,'Carlos','Rodríguez',NULL,NULL,'instructor@nexoratech.com','+57 300 333 4455','Instructor Senior',NULL,1,NULL,NULL,'$2y$12$EV7n18cCdYkVbfvXXNs1re/3463aOnn7hTsTJRGRwvjKz1.653d5.',NULL,'2026-06-18 07:39:23','2026-06-18 07:39:23',NULL),(4,1,'Ana','Martínez',NULL,NULL,'supervisor@nexoratech.com','+57 300 444 5566','Supervisor de Ventas',NULL,1,NULL,NULL,'$2y$12$SxcEnkft6DE6dvRiYYKKSu85oF0k7Tx2Nfk26CDBXhOWW6qdigrD2',NULL,'2026-06-18 07:39:23','2026-06-18 07:39:23',NULL),(5,1,'Pedro','López',NULL,NULL,'empleado@nexoratech.com','+57 300 555 6677','Analista de Soporte',NULL,1,NULL,NULL,'$2y$12$nofxwageInuVwYRqV.fu9.aOU3sIXot86KTLKt.pATdWl/EIrHk.C',NULL,'2026-06-18 07:39:23','2026-06-18 07:39:23',NULL),(6,2,'Laura','Hernández',NULL,NULL,'admin@innovaciondigital.com','+57 300 666 7788','Administrador Empresa',NULL,1,NULL,NULL,'$2y$12$lajP7ZB8cLkXVfdlRGBpvuFCJCdRhkhuAMQ8FqKv7t7h2H4OjTprq',NULL,'2026-06-18 07:39:23','2026-06-18 07:39:23',NULL),(7,2,'Diego','Torres',NULL,NULL,'instructor@innovaciondigital.com','+57 300 777 8899','Instructor',NULL,1,NULL,NULL,'$2y$12$z5Ej3fW.u7fJuELAhRbw3.J.3Db7.G6cNxVNY801VezY.LQVqbPVm',NULL,'2026-06-18 07:39:23','2026-06-18 07:39:23',NULL);
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

-- Dump completed on 2026-06-17 21:39:52
