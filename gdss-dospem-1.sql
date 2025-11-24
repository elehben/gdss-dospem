-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               9.0.1 - MySQL Community Server - GPL
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


-- Dumping database structure for gdss-dospem
CREATE DATABASE IF NOT EXISTS `gdss-dospem` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `gdss-dospem`;

-- Dumping structure for table gdss-dospem.alternatif
CREATE TABLE IF NOT EXISTS `alternatif` (
  `id_alt` char(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_alt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_alt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table gdss-dospem.alternatif: ~0 rows (approximately)

-- Dumping structure for table gdss-dospem.bobot_borda
CREATE TABLE IF NOT EXISTS `bobot_borda` (
  `ranking` bigint unsigned NOT NULL AUTO_INCREMENT,
  `bobot_borda` int NOT NULL,
  PRIMARY KEY (`ranking`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table gdss-dospem.bobot_borda: ~0 rows (approximately)

-- Dumping structure for table gdss-dospem.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table gdss-dospem.cache: ~0 rows (approximately)

-- Dumping structure for table gdss-dospem.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table gdss-dospem.cache_locks: ~0 rows (approximately)

-- Dumping structure for table gdss-dospem.failed_jobs
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

-- Dumping data for table gdss-dospem.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table gdss-dospem.hasil_borda
CREATE TABLE IF NOT EXISTS `hasil_borda` (
  `id_hasil` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_alt` char(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_poin` decimal(10,4) NOT NULL,
  `nilai_borda` decimal(10,4) NOT NULL,
  `rangking_borda` int NOT NULL,
  PRIMARY KEY (`id_hasil`),
  KEY `hasil_borda_id_alt_foreign` (`id_alt`),
  CONSTRAINT `hasil_borda_id_alt_foreign` FOREIGN KEY (`id_alt`) REFERENCES `alternatif` (`id_alt`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table gdss-dospem.hasil_borda: ~0 rows (approximately)

-- Dumping structure for table gdss-dospem.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table gdss-dospem.jobs: ~0 rows (approximately)

-- Dumping structure for table gdss-dospem.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
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

-- Dumping data for table gdss-dospem.job_batches: ~0 rows (approximately)

-- Dumping structure for table gdss-dospem.kriteria
CREATE TABLE IF NOT EXISTS `kriteria` (
  `id_kriteria` char(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_kriteria` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bobot` decimal(10,4) NOT NULL,
  `bobot_normalisasi` decimal(10,4) NOT NULL,
  PRIMARY KEY (`id_kriteria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table gdss-dospem.kriteria: ~0 rows (approximately)

-- Dumping structure for table gdss-dospem.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table gdss-dospem.migrations: ~7 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2025_11_24_072520_create_alternatifs_table', 1),
	(5, '2025_11_24_072618_create_kriterias_table', 1),
	(6, '2025_11_24_114846_create_penilaians_table', 1),
	(7, '2025_11_24_115842_create_bordas_table', 1);

-- Dumping structure for table gdss-dospem.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table gdss-dospem.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table gdss-dospem.penilaian
CREATE TABLE IF NOT EXISTS `penilaian` (
  `id_penilaian` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_user` char(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_alt` char(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_kriteria` char(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nilai_awal` decimal(10,4) NOT NULL,
  `nilai_terbobot` decimal(10,4) NOT NULL,
  PRIMARY KEY (`id_penilaian`),
  KEY `penilaian_id_user_foreign` (`id_user`),
  KEY `penilaian_id_alt_foreign` (`id_alt`),
  KEY `penilaian_id_kriteria_foreign` (`id_kriteria`),
  CONSTRAINT `penilaian_id_alt_foreign` FOREIGN KEY (`id_alt`) REFERENCES `alternatif` (`id_alt`) ON DELETE CASCADE,
  CONSTRAINT `penilaian_id_kriteria_foreign` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE,
  CONSTRAINT `penilaian_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table gdss-dospem.penilaian: ~0 rows (approximately)

-- Dumping structure for table gdss-dospem.preferensi_wp
CREATE TABLE IF NOT EXISTS `preferensi_wp` (
  `id_pref` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_alt` char(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_user` char(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `perkalian` decimal(10,4) NOT NULL,
  `skor_pref` decimal(10,4) NOT NULL,
  `rangking_wp` int NOT NULL,
  PRIMARY KEY (`id_pref`),
  KEY `preferensi_wp_id_alt_foreign` (`id_alt`),
  KEY `preferensi_wp_id_user_foreign` (`id_user`),
  CONSTRAINT `preferensi_wp_id_alt_foreign` FOREIGN KEY (`id_alt`) REFERENCES `alternatif` (`id_alt`) ON DELETE CASCADE,
  CONSTRAINT `preferensi_wp_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table gdss-dospem.preferensi_wp: ~0 rows (approximately)

-- Dumping structure for table gdss-dospem.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
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

-- Dumping data for table gdss-dospem.sessions: ~0 rows (approximately)

-- Dumping structure for table gdss-dospem.users
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` char(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table gdss-dospem.users: ~0 rows (approximately)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
