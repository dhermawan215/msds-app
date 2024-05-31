-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table msdsapp.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table msdsapp.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table msdsapp.hazard_statement_categories
CREATE TABLE IF NOT EXISTS `hazard_statement_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table msdsapp.hazard_statement_categories: ~0 rows (approximately)

-- Dumping structure for table msdsapp.master_clasifications
CREATE TABLE IF NOT EXISTS `master_clasifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'en',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table msdsapp.master_clasifications: ~0 rows (approximately)

-- Dumping structure for table msdsapp.master_engineering_measures
CREATE TABLE IF NOT EXISTS `master_engineering_measures` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `description` text COLLATE utf8mb4_unicode_ci,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table msdsapp.master_engineering_measures: ~0 rows (approximately)

-- Dumping structure for table msdsapp.master_environmental_hazards
CREATE TABLE IF NOT EXISTS `master_environmental_hazards` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'en',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hscat_id` bigint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table msdsapp.master_environmental_hazards: ~2 rows (approximately)
INSERT INTO `master_environmental_hazards` (`id`, `code`, `description`, `language`, `created_by`, `hscat_id`, `created_at`, `updated_at`) VALUES
	(1, 'H400', 'Very toxic to aquatic life.', 'EN', 'Admin App', NULL, '2024-05-28 01:40:12', '2024-05-28 01:40:12'),
	(2, 'H410', 'Very toxic to aquatic life with long lasting effects', 'EN', 'Admin App', NULL, '2024-05-28 01:41:40', '2024-05-30 05:01:41');

-- Dumping structure for table msdsapp.master_extinguishing_media
CREATE TABLE IF NOT EXISTS `master_extinguishing_media` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `description` text COLLATE utf8mb4_unicode_ci,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table msdsapp.master_extinguishing_media: ~0 rows (approximately)

-- Dumping structure for table msdsapp.master_eye_contacts
CREATE TABLE IF NOT EXISTS `master_eye_contacts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `description` text COLLATE utf8mb4_unicode_ci,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table msdsapp.master_eye_contacts: ~0 rows (approximately)

-- Dumping structure for table msdsapp.master_eye_protections
CREATE TABLE IF NOT EXISTS `master_eye_protections` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `description` text COLLATE utf8mb4_unicode_ci,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table msdsapp.master_eye_protections: ~0 rows (approximately)

-- Dumping structure for table msdsapp.master_general_precautionary_statements
CREATE TABLE IF NOT EXISTS `master_general_precautionary_statements` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'en',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pscat_id` bigint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table msdsapp.master_general_precautionary_statements: ~0 rows (approximately)

-- Dumping structure for table msdsapp.master_hand_protections
CREATE TABLE IF NOT EXISTS `master_hand_protections` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `description` text COLLATE utf8mb4_unicode_ci,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table msdsapp.master_hand_protections: ~0 rows (approximately)

-- Dumping structure for table msdsapp.master_health_hazards
CREATE TABLE IF NOT EXISTS `master_health_hazards` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'en',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hscat_id` bigint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table msdsapp.master_health_hazards: ~2 rows (approximately)
INSERT INTO `master_health_hazards` (`id`, `code`, `description`, `language`, `created_by`, `hscat_id`, `created_at`, `updated_at`) VALUES
	(1, 'H300', 'Fatal is swallowed', 'EN', 'Admin App', NULL, '2024-02-13 08:38:51', '2024-02-13 08:38:51'),
	(2, 'H300 + H310', 'Fatal if swallowed or in contact with skin', 'EN', 'Admin App', NULL, '2024-02-13 08:45:04', '2024-02-13 08:45:04'),
	(4, '121212', '12121212', 'ID', 'Admin App', NULL, '2024-05-22 08:37:07', '2024-05-22 08:37:07');

-- Dumping structure for table msdsapp.master_hygiene_measures
CREATE TABLE IF NOT EXISTS `master_hygiene_measures` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `description` text COLLATE utf8mb4_unicode_ci,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table msdsapp.master_hygiene_measures: ~0 rows (approximately)

-- Dumping structure for table msdsapp.master_ingestions
CREATE TABLE IF NOT EXISTS `master_ingestions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `description` text COLLATE utf8mb4_unicode_ci,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table msdsapp.master_ingestions: ~0 rows (approximately)

-- Dumping structure for table msdsapp.master_inhalations
CREATE TABLE IF NOT EXISTS `master_inhalations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `description` text COLLATE utf8mb4_unicode_ci,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table msdsapp.master_inhalations: ~0 rows (approximately)

-- Dumping structure for table msdsapp.master_other_protections
CREATE TABLE IF NOT EXISTS `master_other_protections` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `description` text COLLATE utf8mb4_unicode_ci,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table msdsapp.master_other_protections: ~0 rows (approximately)

-- Dumping structure for table msdsapp.master_personal_precautions
CREATE TABLE IF NOT EXISTS `master_personal_precautions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `description` text COLLATE utf8mb4_unicode_ci,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table msdsapp.master_personal_precautions: ~0 rows (approximately)

-- Dumping structure for table msdsapp.master_physical_hazards
CREATE TABLE IF NOT EXISTS `master_physical_hazards` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'en',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hscat_id` bigint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table msdsapp.master_physical_hazards: ~2 rows (approximately)
INSERT INTO `master_physical_hazards` (`id`, `code`, `description`, `language`, `created_by`, `hscat_id`, `created_at`, `updated_at`) VALUES
	(1, 'H315', 'Causes skin irritation', 'EN', 'Admin App', NULL, '2024-02-12 09:33:44', '2024-02-12 09:33:44'),
	(2, 'H300 + H310', 'Fatal if swallowed or in contact with skins', 'EN', 'Admin App', NULL, '2024-02-13 04:37:18', '2024-05-22 08:27:06'),
	(5, '111445', 'sasdafagew', 'ID', 'Admin App', NULL, '2024-05-22 08:37:26', '2024-05-22 08:37:26');

-- Dumping structure for table msdsapp.master_pmifs
CREATE TABLE IF NOT EXISTS `master_pmifs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `description` text COLLATE utf8mb4_unicode_ci,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table msdsapp.master_pmifs: ~0 rows (approximately)

-- Dumping structure for table msdsapp.master_prevention_precautionary_statements
CREATE TABLE IF NOT EXISTS `master_prevention_precautionary_statements` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'en',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pscat_id` bigint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table msdsapp.master_prevention_precautionary_statements: ~0 rows (approximately)

-- Dumping structure for table msdsapp.master_protective_equipment
CREATE TABLE IF NOT EXISTS `master_protective_equipment` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8mb4_unicode_ci,
  `image_path` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table msdsapp.master_protective_equipment: ~0 rows (approximately)

-- Dumping structure for table msdsapp.master_respiratory_equipment
CREATE TABLE IF NOT EXISTS `master_respiratory_equipment` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `description` text COLLATE utf8mb4_unicode_ci,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table msdsapp.master_respiratory_equipment: ~0 rows (approximately)

-- Dumping structure for table msdsapp.master_response_precautionary_statements
CREATE TABLE IF NOT EXISTS `master_response_precautionary_statements` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'en',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pscat_id` bigint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table msdsapp.master_response_precautionary_statements: ~0 rows (approximately)

-- Dumping structure for table msdsapp.master_skin_contacts
CREATE TABLE IF NOT EXISTS `master_skin_contacts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `description` text COLLATE utf8mb4_unicode_ci,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table msdsapp.master_skin_contacts: ~0 rows (approximately)

-- Dumping structure for table msdsapp.master_spesific_hazards
CREATE TABLE IF NOT EXISTS `master_spesific_hazards` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `description` text COLLATE utf8mb4_unicode_ci,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table msdsapp.master_spesific_hazards: ~0 rows (approximately)

-- Dumping structure for table msdsapp.master_ssfps
CREATE TABLE IF NOT EXISTS `master_ssfps` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `description` text COLLATE utf8mb4_unicode_ci,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table msdsapp.master_ssfps: ~0 rows (approximately)

-- Dumping structure for table msdsapp.master_storage_precautionary_statements
CREATE TABLE IF NOT EXISTS `master_storage_precautionary_statements` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'en',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pscat_id` bigint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table msdsapp.master_storage_precautionary_statements: ~0 rows (approximately)

-- Dumping structure for table msdsapp.master_storage_precautions
CREATE TABLE IF NOT EXISTS `master_storage_precautions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `description` text COLLATE utf8mb4_unicode_ci,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table msdsapp.master_storage_precautions: ~0 rows (approximately)

-- Dumping structure for table msdsapp.master_usage_precautions
CREATE TABLE IF NOT EXISTS `master_usage_precautions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `description` text COLLATE utf8mb4_unicode_ci,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table msdsapp.master_usage_precautions: ~0 rows (approximately)

-- Dumping structure for table msdsapp.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table msdsapp.migrations: ~0 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2024_01_03_033659_create_master_physical_hazards_table', 1),
	(6, '2024_01_03_043814_create_master_health_hazards_table', 1),
	(7, '2024_01_03_044314_create_master_environmental_hazards_table', 1),
	(8, '2024_01_03_050418_create_master_general_precautionary_statements_table', 1),
	(9, '2024_01_03_063517_create_master_prevention_precautionary_statements_table', 1),
	(10, '2024_01_03_064904_create_master_response_precautionary_statements_table', 1),
	(11, '2024_01_03_074726_create_master_storage_precautionary_statements_table', 1),
	(12, '2024_01_04_045828_create_hazard_statement_categories_table', 1),
	(13, '2024_01_04_050608_create_precautionary_statement_categories_table', 1),
	(14, '2024_01_04_065922_create_master_clasifications_table', 1),
	(15, '2024_01_04_082529_create_master_inhalations_table', 1),
	(16, '2024_01_04_082845_create_master_ingestions_table', 1),
	(17, '2024_01_04_083401_create_master_skin_contacts_table', 1),
	(18, '2024_01_04_083545_create_master_eye_contacts_table', 1),
	(19, '2024_01_11_034951_create_master_extinguishing_media_table', 1),
	(20, '2024_01_11_035802_create_master_ssfps_table', 1),
	(21, '2024_01_11_040244_create_master_spesific_hazards_table', 1),
	(22, '2024_01_11_040450_create_master_pmifs_table', 1),
	(23, '2024_01_11_045653_create_master_usage_precautions_table', 1),
	(24, '2024_01_11_063113_create_master_storage_precautions_table', 1),
	(25, '2024_01_11_064331_create_master_personal_precautions_table', 1),
	(26, '2024_01_11_081428_create_master_protective_equipment_table', 1),
	(27, '2024_01_11_081945_create_master_engineering_measures_table', 1),
	(28, '2024_01_11_083342_create_master_respiratory_equipment_table', 1),
	(29, '2024_01_11_083539_create_master_hand_protections_table', 1),
	(30, '2024_01_11_083705_create_master_eye_protections_table', 1),
	(31, '2024_01_11_083823_create_master_other_protections_table', 1),
	(32, '2024_01_11_083941_create_master_hygiene_measures_table', 1),
	(33, '2024_01_15_023719_create_sys_user_groups_table', 1),
	(34, '2024_01_16_080132_create_user_logs_table', 2),
	(35, '2024_01_18_150647_create_sys_modul_menus_table', 3),
	(36, '2024_01_18_153316_create_sys_user_modul_roles_table', 3);

-- Dumping structure for table msdsapp.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table msdsapp.password_resets: ~0 rows (approximately)

-- Dumping structure for table msdsapp.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table msdsapp.personal_access_tokens: ~0 rows (approximately)

-- Dumping structure for table msdsapp.precautionary_statement_categories
CREATE TABLE IF NOT EXISTS `precautionary_statement_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table msdsapp.precautionary_statement_categories: ~0 rows (approximately)

-- Dumping structure for table msdsapp.sys_modul_menus
CREATE TABLE IF NOT EXISTS `sys_modul_menus` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `route_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_menu` int DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table msdsapp.sys_modul_menus: ~5 rows (approximately)
INSERT INTO `sys_modul_menus` (`id`, `name`, `route_name`, `link_path`, `description`, `icon`, `order_menu`, `created_by`, `created_at`, `updated_at`) VALUES
	(1, 'user_management', 'admin_user_management', '/users-management', 'User Management', 'fa fa-users', 5, 'admin', '2024-02-01 08:34:32', '2024-02-01 08:37:12'),
	(2, 'permission_management', 'admin_permission', '/permission-management', 'Permission Management', 'fa fa-cogs', 5, 'Admin App', '2024-01-29 06:49:08', '2024-01-30 06:40:09'),
	(3, 'module_management', 'admin_module', '/module-management', 'Module Management', 'fa fa-th', 5, 'Admin App', '2024-01-29 06:51:14', '2024-01-30 06:41:04'),
	(4, 'physical_hazard', 'physical_hazard', '/physical-hazard', 'Physical Hazard', 'fa fa-clone', 1, 'Admin App', '2024-02-06 06:57:19', '2024-02-06 07:07:54'),
	(5, 'health_hazard', 'health_hazard', '/health-hazard', 'Health Hazard', 'fa fa-clone', 1, 'Admin App', '2024-02-13 08:14:03', '2024-02-13 08:14:03'),
	(6, 'environmental_hazard', 'environmental_hazard', '/environmental-hazard', 'Environmental Hazard', 'fa fa-clone', 1, 'Admin App', '2024-05-22 10:00:28', '2024-05-22 10:00:28'),
	(7, 'general_precautionary', 'general_precautionary', '/general-precautionary', 'General Precautionary', 'fa fa-clone', 2, 'Admin App', '2024-05-30 09:08:41', '2024-05-30 09:08:41');

-- Dumping structure for table msdsapp.sys_user_groups
CREATE TABLE IF NOT EXISTS `sys_user_groups` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table msdsapp.sys_user_groups: ~2 rows (approximately)
INSERT INTO `sys_user_groups` (`id`, `name`, `created_by`, `created_at`, `updated_at`) VALUES
	(1, 'SUPER_ADMIN', NULL, '2024-01-15 02:51:34', NULL),
	(2, 'LAB_USER', NULL, '2024-01-15 02:51:36', NULL),
	(3, 'REGULER_USER', NULL, '2024-01-15 02:51:37', NULL);

-- Dumping structure for table msdsapp.sys_user_modul_roles
CREATE TABLE IF NOT EXISTS `sys_user_modul_roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sys_modul_id` bigint NOT NULL,
  `sys_user_group_id` bigint NOT NULL,
  `is_akses` tinyint NOT NULL,
  `fungsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table msdsapp.sys_user_modul_roles: ~5 rows (approximately)
INSERT INTO `sys_user_modul_roles` (`id`, `sys_modul_id`, `sys_user_group_id`, `is_akses`, `fungsi`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 1, '["add","edit","change_password"]', '2024-01-25 08:16:04', '2024-02-06 04:50:03'),
	(2, 3, 1, 1, '["add","edit","delete"]', '2024-02-01 08:33:41', '2024-02-01 08:33:42'),
	(3, 2, 1, 1, '["add","edit","delete"]', '2024-02-05 02:15:09', '2024-02-05 02:15:10'),
	(7, 4, 1, 1, '["add","edit","delete","detail"]', '2024-02-06 06:57:46', '2024-02-06 09:11:57'),
	(8, 5, 1, 1, '["add","edit","detail","delete"]', '2024-02-13 08:14:25', '2024-02-13 08:43:19'),
	(9, 6, 1, 1, '["add","edit","delete","detail"]', '2024-05-22 10:00:57', '2024-05-30 04:51:08'),
	(10, 7, 1, 1, '["add","edit","delete","detail"]', '2024-05-30 09:09:04', '2024-05-30 09:09:04');

-- Dumping structure for table msdsapp.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sys_group_id` bigint NOT NULL,
  `is_active` int NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table msdsapp.users: ~0 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `sys_group_id`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Admin App', 'support@zekindo.co.id', NULL, '$2y$10$wSlJnwqn6MIT3X9h.NGoeu.u4alZo6g8uujdjLCmr6s22xFI3sPC.', 1, 1, NULL, '2024-01-15 03:00:39', '2024-01-23 08:03:02'),
	(2, 'fransiska selly', 'fransiska.selly@zekindo.co.id', NULL, '$2y$10$2FzhONifu2lvzptrB/0eGOciR5Pe0Oj2Qa9f7LDcxFYzbIo50dtpq', 2, 1, NULL, '2024-01-23 09:12:32', '2024-02-01 08:37:39');

-- Dumping structure for table msdsapp.user_logs
CREATE TABLE IF NOT EXISTS `user_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `log_user_agent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_time` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table msdsapp.user_logs: ~38 rows (approximately)
INSERT INTO `user_logs` (`id`, `user_id`, `email`, `ip_address`, `log_user_agent`, `activity`, `status`, `date_time`, `created_at`, `updated_at`) VALUES
	(1, NULL, 'hr.admin@acmechem.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'login to system', '0', '2024-01-16 08:53:22', '2024-01-16 08:53:23', '2024-01-16 08:53:23'),
	(2, NULL, 'hr.admin@acmechem.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'login to system', 'false', '2024-01-16 08:56:06', '2024-01-16 08:56:06', '2024-01-16 08:56:06'),
	(3, 1, 'support@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'logout from system', 'true', '2024-01-16 09:43:59', '2024-01-16 09:43:59', '2024-01-16 09:43:59'),
	(4, 1, 'support@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'login to system', 'true', '2024-01-16 09:47:37', '2024-01-16 09:47:37', '2024-01-16 09:47:37'),
	(5, 1, 'support@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'logout from system', 'true', '2024-01-16 09:59:34', '2024-01-16 09:59:34', '2024-01-16 09:59:34'),
	(6, 1, 'support@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'login to system', 'true', '2024-01-18 08:59:43', '2024-01-18 08:59:43', '2024-01-18 08:59:43'),
	(7, 1, 'support@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'logout from system', 'true', '2024-01-18 10:02:30', '2024-01-18 10:02:30', '2024-01-18 10:02:30'),
	(8, 1, 'support@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'login to system', 'true', '2024-01-19 05:48:59', '2024-01-19 05:49:00', '2024-01-19 05:49:00'),
	(9, 1, 'support@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'logout from system', 'true', '2024-01-19 07:26:26', '2024-01-19 07:26:26', '2024-01-19 07:26:26'),
	(10, 1, 'support@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'login to system', 'true', '2024-01-22 08:01:40', '2024-01-22 08:01:41', '2024-01-22 08:01:41'),
	(11, 1, 'support@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'change password', 'true', '2024-01-22 09:27:51', '2024-01-22 09:27:51', '2024-01-22 09:27:51'),
	(12, 1, 'support@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'logout from system', 'true', '2024-01-22 09:28:09', '2024-01-22 09:28:09', '2024-01-22 09:28:09'),
	(13, 1, 'support@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'login to system', 'true', '2024-01-22 09:28:18', '2024-01-22 09:28:18', '2024-01-22 09:28:18'),
	(14, 1, 'support@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'login to system', 'true', '2024-01-23 03:15:56', '2024-01-23 03:15:56', '2024-01-23 03:15:56'),
	(15, 1, 'support@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'login to system', 'true', '2024-01-25 03:37:37', '2024-01-25 03:37:37', '2024-01-25 03:37:37'),
	(16, 1, 'support@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'logout from system', 'true', '2024-01-25 03:51:53', '2024-01-25 03:51:53', '2024-01-25 03:51:53'),
	(17, 2, 'fransiska.selly@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'login to system', 'true', '2024-01-25 03:52:10', '2024-01-25 03:52:10', '2024-01-25 03:52:10'),
	(18, 2, 'fransiska.selly@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'logout from system', 'true', '2024-01-25 03:54:40', '2024-01-25 03:54:40', '2024-01-25 03:54:40'),
	(19, 1, 'support@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'login to system', 'true', '2024-01-25 03:54:53', '2024-01-25 03:54:54', '2024-01-25 03:54:54'),
	(20, 1, 'support@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'logout from system', 'true', '2024-01-25 07:08:27', '2024-01-25 07:08:27', '2024-01-25 07:08:27'),
	(21, 2, 'fransiska.selly@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'login to system', 'false', '2024-01-25 07:08:37', '2024-01-25 07:08:37', '2024-01-25 07:08:37'),
	(22, 2, 'fransiska.selly@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'login to system', 'true', '2024-01-25 07:08:41', '2024-01-25 07:08:41', '2024-01-25 07:08:41'),
	(23, 2, 'fransiska.selly@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'change password', 'true', '2024-01-25 07:09:06', '2024-01-25 07:09:07', '2024-01-25 07:09:07'),
	(24, 2, 'fransiska.selly@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'logout from system', 'true', '2024-01-25 07:09:15', '2024-01-25 07:09:15', '2024-01-25 07:09:15'),
	(25, 2, 'fransiska.selly@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'login to system', 'true', '2024-01-25 07:09:27', '2024-01-25 07:09:27', '2024-01-25 07:09:27'),
	(26, 2, 'fransiska.selly@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'logout from system', 'true', '2024-01-25 07:09:45', '2024-01-25 07:09:45', '2024-01-25 07:09:45'),
	(27, 1, 'support@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'login to system', 'true', '2024-01-25 07:12:12', '2024-01-25 07:12:12', '2024-01-25 07:12:12'),
	(28, 1, 'support@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'login to system', 'true', '2024-01-29 03:25:20', '2024-01-29 03:25:20', '2024-01-29 03:25:20'),
	(29, 1, 'support@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'login to system', 'true', '2024-01-29 06:46:54', '2024-01-29 06:46:55', '2024-01-29 06:46:55'),
	(30, 1, 'support@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'logout from system', 'true', '2024-01-29 09:41:45', '2024-01-29 09:41:45', '2024-01-29 09:41:45'),
	(31, 1, 'support@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36', 'login to system', 'true', '2024-01-30 06:26:21', '2024-01-30 06:26:21', '2024-01-30 06:26:21'),
	(32, 1, 'support@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36', 'login to system', 'true', '2024-02-01 06:45:10', '2024-02-01 06:45:12', '2024-02-01 06:45:12'),
	(33, 1, 'support@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36', 'login to system', 'true', '2024-02-02 06:48:49', '2024-02-02 06:48:50', '2024-02-02 06:48:50'),
	(34, 1, 'support@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36', 'logout from system', 'true', '2024-02-02 08:34:33', '2024-02-02 08:34:33', '2024-02-02 08:34:33'),
	(35, 1, 'support@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36', 'login to system', 'false', '2024-02-02 08:34:44', '2024-02-02 08:34:45', '2024-02-02 08:34:45'),
	(36, 1, 'support@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36', 'login to system', 'true', '2024-02-02 08:34:52', '2024-02-02 08:34:52', '2024-02-02 08:34:52'),
	(37, 1, 'support@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36', 'login to system', 'true', '2024-02-05 02:11:59', '2024-02-05 02:11:59', '2024-02-05 02:11:59'),
	(38, 1, 'support@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36', 'logout from system', 'true', '2024-02-05 10:06:53', '2024-02-05 10:06:53', '2024-02-05 10:06:53'),
	(39, 1, 'support@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36', 'login to system', 'true', '2024-02-05 10:07:01', '2024-02-05 10:07:01', '2024-02-05 10:07:01'),
	(40, 1, 'support@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36', 'login to system', 'true', '2024-02-06 01:52:37', '2024-02-06 01:52:38', '2024-02-06 01:52:38'),
	(41, 1, 'support@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36', 'login to system', 'true', '2024-02-12 08:56:25', '2024-02-12 08:56:25', '2024-02-12 08:56:25'),
	(42, 1, 'support@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36', 'logout from system', 'true', '2024-02-12 10:06:35', '2024-02-12 10:06:35', '2024-02-12 10:06:35'),
	(43, 1, 'support@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36', 'login to system', 'true', '2024-02-13 04:20:43', '2024-02-13 04:20:43', '2024-02-13 04:20:43'),
	(44, 1, 'support@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 'login to system', 'true', '2024-05-22 08:11:19', '2024-05-22 08:11:20', '2024-05-22 08:11:20'),
	(45, 1, 'support@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 'logout from system', 'true', '2024-05-22 10:03:13', '2024-05-22 10:03:13', '2024-05-22 10:03:13'),
	(46, 2, 'fransiska.selly@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 'login to system', 'true', '2024-05-22 10:03:24', '2024-05-22 10:03:25', '2024-05-22 10:03:25'),
	(47, 1, 'support@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'login to system', 'true', '2024-05-27 07:01:37', '2024-05-27 07:01:37', '2024-05-27 07:01:37'),
	(48, 1, 'support@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'logout from system', 'true', '2024-05-27 07:04:13', '2024-05-27 07:04:13', '2024-05-27 07:04:13'),
	(49, 2, 'fransiska.selly@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'login to system', 'true', '2024-05-27 07:04:23', '2024-05-27 07:04:23', '2024-05-27 07:04:23'),
	(50, 2, 'fransiska.selly@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'logout from system', 'true', '2024-05-27 07:09:29', '2024-05-27 07:09:29', '2024-05-27 07:09:29'),
	(51, 1, 'support@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'login to system', 'true', '2024-05-27 07:09:45', '2024-05-27 07:09:45', '2024-05-27 07:09:45'),
	(52, 1, 'support@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'login to system', 'true', '2024-05-28 01:21:54', '2024-05-28 01:21:55', '2024-05-28 01:21:55'),
	(53, 1, 'support@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'login to system', 'true', '2024-05-28 01:22:32', '2024-05-28 01:22:33', '2024-05-28 01:22:33'),
	(54, 1, 'support@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'login to system', 'true', '2024-05-30 02:30:34', '2024-05-30 02:30:35', '2024-05-30 02:30:35'),
	(55, 1, 'support@zekindo.co.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'login to system', 'true', '2024-05-30 08:27:54', '2024-05-30 08:27:54', '2024-05-30 08:27:54');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
