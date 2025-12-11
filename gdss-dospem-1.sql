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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_alt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table gdss-dospem.alternatif: ~10 rows (approximately)
INSERT INTO `alternatif` (`id_alt`, `nama_alt`, `created_at`, `updated_at`) VALUES
	('A01', 'Dr. Budi Santoso, M.Kom.', NULL, NULL),
	('A02', 'Prof. Dr. Siti Aminah, S.Si., M.T.', NULL, NULL),
	('A03', 'Rahmat Hidayat, S.T., M.Cs.', NULL, NULL),
	('A04', 'Dr. Eko Prasetyo, S.Kom., M.Kom.', NULL, NULL),
	('A05', 'Dewi Sartika, S.T., M.T.', NULL, NULL),
	('A06', 'Dr. Ir. Andi Wijaya, M.Eng.', NULL, NULL),
	('A07', 'Ratna Sari, S.Kom., M.MSI.', NULL, NULL),
	('A08', 'Bambang Suryadi, Ph.D.', NULL, NULL),
	('A09', 'Lina Marlina, S.Si., M.Kom.', NULL, NULL),
	('A10', 'Dr. Hendra Gunawan, S.T., M.T.', NULL, NULL);

-- Dumping structure for table gdss-dospem.bobot_borda
CREATE TABLE IF NOT EXISTS `bobot_borda` (
  `ranking` bigint unsigned NOT NULL AUTO_INCREMENT,
  `bobot_borda` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ranking`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table gdss-dospem.bobot_borda: ~10 rows (approximately)
INSERT INTO `bobot_borda` (`ranking`, `bobot_borda`, `created_at`, `updated_at`) VALUES
	(1, 9, NULL, NULL),
	(2, 8, NULL, NULL),
	(3, 7, NULL, NULL),
	(4, 6, NULL, NULL),
	(5, 5, NULL, NULL),
	(6, 4, NULL, NULL),
	(7, 3, NULL, NULL),
	(8, 2, NULL, NULL),
	(9, 1, NULL, NULL),
	(10, 0, NULL, NULL);

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
  `tahun` year NOT NULL DEFAULT '2025',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_hasil`),
  KEY `hasil_borda_id_alt_foreign` (`id_alt`),
  KEY `hasil_borda_tahun_index` (`tahun`),
  CONSTRAINT `hasil_borda_id_alt_foreign` FOREIGN KEY (`id_alt`) REFERENCES `alternatif` (`id_alt`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table gdss-dospem.hasil_borda: ~20 rows (approximately)
INSERT INTO `hasil_borda` (`id_hasil`, `id_alt`, `total_poin`, `nilai_borda`, `rangking_borda`, `tahun`, `created_at`, `updated_at`) VALUES
	(1, 'A01', 3.1056, 0.2168, 1, '2025', NULL, NULL),
	(2, 'A02', 2.5698, 0.1794, 2, '2025', NULL, NULL),
	(3, 'A03', 2.0528, 0.1433, 4, '2025', NULL, NULL),
	(4, 'A04', 2.1324, 0.1489, 3, '2025', NULL, NULL),
	(5, 'A05', 1.6686, 0.1165, 5, '2025', NULL, NULL),
	(6, 'A06', 0.6780, 0.0473, 8, '2025', NULL, NULL),
	(7, 'A07', 0.7588, 0.0529, 7, '2025', NULL, NULL),
	(8, 'A08', 0.9221, 0.0643, 6, '2025', NULL, NULL),
	(9, 'A09', 0.0000, 0.0000, 10, '2025', NULL, NULL),
	(10, 'A10', 0.4316, 0.0301, 9, '2025', NULL, NULL),
	(11, 'A01', 3.1056, 0.2168, 1, '2026', NULL, NULL),
	(12, 'A02', 2.5698, 0.1794, 2, '2026', NULL, NULL),
	(13, 'A03', 2.0528, 0.1433, 4, '2026', NULL, NULL),
	(14, 'A04', 2.1324, 0.1489, 3, '2026', NULL, NULL),
	(15, 'A05', 1.6686, 0.1165, 5, '2026', NULL, NULL),
	(16, 'A06', 0.6780, 0.0473, 8, '2026', NULL, NULL),
	(17, 'A07', 0.7588, 0.0529, 7, '2026', NULL, NULL),
	(18, 'A08', 0.9221, 0.0643, 6, '2026', NULL, NULL),
	(19, 'A09', 0.0000, 0.0000, 10, '2026', NULL, NULL),
	(20, 'A10', 0.4316, 0.0301, 9, '2026', NULL, NULL);

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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_kriteria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table gdss-dospem.kriteria: ~5 rows (approximately)
INSERT INTO `kriteria` (`id_kriteria`, `nama_kriteria`, `jenis`, `bobot`, `bobot_normalisasi`, `created_at`, `updated_at`) VALUES
	('C1', 'Tingkat Pendidikan', 'Benefit', 5.0000, 0.2500, NULL, NULL),
	('C2', 'Jabatan Akademik', 'Benefit', 4.0000, 0.2000, NULL, NULL),
	('C3', 'Jabatan Kelompok', 'Benefit', 3.0000, 0.1500, NULL, NULL),
	('C4', 'Sertifikasi Dosen', 'Benefit', 3.0000, 0.1500, NULL, NULL),
	('C5', 'Pencapaian 3 Pilar Pendidikan Tinggi', 'Benefit', 5.0000, 0.2500, NULL, NULL);

-- Dumping structure for table gdss-dospem.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table gdss-dospem.migrations: ~8 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2025_11_24_072520_create_alternatifs_table', 1),
	(5, '2025_11_24_072618_create_kriterias_table', 1),
	(6, '2025_11_24_114846_create_penilaians_table', 1),
	(7, '2025_11_24_115842_create_bordas_table', 1),
	(8, '2025_12_11_025751_add_tahun_to_penilaian_preferensi_hasil_tables', 1);

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
  `tahun` year NOT NULL DEFAULT '2025',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_penilaian`),
  KEY `penilaian_id_user_foreign` (`id_user`),
  KEY `penilaian_id_alt_foreign` (`id_alt`),
  KEY `penilaian_id_kriteria_foreign` (`id_kriteria`),
  KEY `penilaian_tahun_index` (`tahun`),
  CONSTRAINT `penilaian_id_alt_foreign` FOREIGN KEY (`id_alt`) REFERENCES `alternatif` (`id_alt`) ON DELETE CASCADE,
  CONSTRAINT `penilaian_id_kriteria_foreign` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE,
  CONSTRAINT `penilaian_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=301 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table gdss-dospem.penilaian: ~300 rows (approximately)
INSERT INTO `penilaian` (`id_penilaian`, `id_user`, `id_alt`, `id_kriteria`, `nilai_awal`, `nilai_terbobot`, `tahun`, `created_at`, `updated_at`) VALUES
	(1, 'U0002', 'A01', 'C1', 1.0000, 1.0000, '2025', NULL, NULL),
	(2, 'U0002', 'A01', 'C2', 4.0000, 1.3195, '2025', NULL, NULL),
	(3, 'U0002', 'A01', 'C3', 4.0000, 1.2311, '2025', NULL, NULL),
	(4, 'U0002', 'A01', 'C4', 2.0000, 1.1095, '2025', NULL, NULL),
	(5, 'U0002', 'A01', 'C5', 4.0000, 1.4142, '2025', NULL, NULL),
	(6, 'U0002', 'A02', 'C1', 1.0000, 1.0000, '2025', NULL, NULL),
	(7, 'U0002', 'A02', 'C2', 4.0000, 1.3195, '2025', NULL, NULL),
	(8, 'U0002', 'A02', 'C3', 3.0000, 1.1791, '2025', NULL, NULL),
	(9, 'U0002', 'A02', 'C4', 2.0000, 1.1095, '2025', NULL, NULL),
	(10, 'U0002', 'A02', 'C5', 4.0000, 1.4142, '2025', NULL, NULL),
	(11, 'U0002', 'A03', 'C1', 1.0000, 1.0000, '2025', NULL, NULL),
	(12, 'U0002', 'A03', 'C2', 4.0000, 1.3195, '2025', NULL, NULL),
	(13, 'U0002', 'A03', 'C3', 4.0000, 1.2311, '2025', NULL, NULL),
	(14, 'U0002', 'A03', 'C4', 2.0000, 1.1095, '2025', NULL, NULL),
	(15, 'U0002', 'A03', 'C5', 4.0000, 1.4142, '2025', NULL, NULL),
	(16, 'U0002', 'A04', 'C1', 1.0000, 1.0000, '2025', NULL, NULL),
	(17, 'U0002', 'A04', 'C2', 4.0000, 1.3195, '2025', NULL, NULL),
	(18, 'U0002', 'A04', 'C3', 3.0000, 1.1791, '2025', NULL, NULL),
	(19, 'U0002', 'A04', 'C4', 2.0000, 1.1095, '2025', NULL, NULL),
	(20, 'U0002', 'A04', 'C5', 4.0000, 1.4142, '2025', NULL, NULL),
	(21, 'U0002', 'A05', 'C1', 1.0000, 1.0000, '2025', NULL, NULL),
	(22, 'U0002', 'A05', 'C2', 3.0000, 1.2457, '2025', NULL, NULL),
	(23, 'U0002', 'A05', 'C3', 3.0000, 1.1791, '2025', NULL, NULL),
	(24, 'U0002', 'A05', 'C4', 2.0000, 1.1095, '2025', NULL, NULL),
	(25, 'U0002', 'A05', 'C5', 5.0000, 1.4953, '2025', NULL, NULL),
	(26, 'U0002', 'A06', 'C1', 1.0000, 1.0000, '2025', NULL, NULL),
	(27, 'U0002', 'A06', 'C2', 2.0000, 1.1486, '2025', NULL, NULL),
	(28, 'U0002', 'A06', 'C3', 3.0000, 1.1791, '2025', NULL, NULL),
	(29, 'U0002', 'A06', 'C4', 2.0000, 1.1095, '2025', NULL, NULL),
	(30, 'U0002', 'A06', 'C5', 4.0000, 1.4142, '2025', NULL, NULL),
	(31, 'U0002', 'A07', 'C1', 1.0000, 1.0000, '2025', NULL, NULL),
	(32, 'U0002', 'A07', 'C2', 3.0000, 1.2457, '2025', NULL, NULL),
	(33, 'U0002', 'A07', 'C3', 3.0000, 1.1791, '2025', NULL, NULL),
	(34, 'U0002', 'A07', 'C4', 2.0000, 1.1095, '2025', NULL, NULL),
	(35, 'U0002', 'A07', 'C5', 3.0000, 1.3160, '2025', NULL, NULL),
	(36, 'U0002', 'A08', 'C1', 2.0000, 1.1892, '2025', NULL, NULL),
	(37, 'U0002', 'A08', 'C2', 2.0000, 1.1486, '2025', NULL, NULL),
	(38, 'U0002', 'A08', 'C3', 3.0000, 1.1791, '2025', NULL, NULL),
	(39, 'U0002', 'A08', 'C4', 1.0000, 1.0000, '2025', NULL, NULL),
	(40, 'U0002', 'A08', 'C5', 4.0000, 1.4142, '2025', NULL, NULL),
	(41, 'U0002', 'A09', 'C1', 1.0000, 1.0000, '2025', NULL, NULL),
	(42, 'U0002', 'A09', 'C2', 2.0000, 1.1486, '2025', NULL, NULL),
	(43, 'U0002', 'A09', 'C3', 3.0000, 1.1791, '2025', NULL, NULL),
	(44, 'U0002', 'A09', 'C4', 2.0000, 1.1095, '2025', NULL, NULL),
	(45, 'U0002', 'A09', 'C5', 2.0000, 1.1892, '2025', NULL, NULL),
	(46, 'U0002', 'A10', 'C1', 1.0000, 1.0000, '2025', NULL, NULL),
	(47, 'U0002', 'A10', 'C2', 3.0000, 1.2457, '2025', NULL, NULL),
	(48, 'U0002', 'A10', 'C3', 2.0000, 1.1095, '2025', NULL, NULL),
	(49, 'U0002', 'A10', 'C4', 2.0000, 1.1095, '2025', NULL, NULL),
	(50, 'U0002', 'A10', 'C5', 3.0000, 1.3160, '2025', NULL, NULL),
	(51, 'U0003', 'A01', 'C1', 1.0000, 1.0000, '2025', NULL, NULL),
	(52, 'U0003', 'A01', 'C2', 4.0000, 1.3195, '2025', NULL, NULL),
	(53, 'U0003', 'A01', 'C3', 4.0000, 1.2311, '2025', NULL, NULL),
	(54, 'U0003', 'A01', 'C4', 2.0000, 1.1095, '2025', NULL, NULL),
	(55, 'U0003', 'A01', 'C5', 5.0000, 1.4953, '2025', NULL, NULL),
	(56, 'U0003', 'A02', 'C1', 1.0000, 1.0000, '2025', NULL, NULL),
	(57, 'U0003', 'A02', 'C2', 4.0000, 1.3195, '2025', NULL, NULL),
	(58, 'U0003', 'A02', 'C3', 3.0000, 1.1791, '2025', NULL, NULL),
	(59, 'U0003', 'A02', 'C4', 2.0000, 1.1095, '2025', NULL, NULL),
	(60, 'U0003', 'A02', 'C5', 5.0000, 1.4953, '2025', NULL, NULL),
	(61, 'U0003', 'A03', 'C1', 1.0000, 1.0000, '2025', NULL, NULL),
	(62, 'U0003', 'A03', 'C2', 4.0000, 1.3195, '2025', NULL, NULL),
	(63, 'U0003', 'A03', 'C3', 4.0000, 1.2311, '2025', NULL, NULL),
	(64, 'U0003', 'A03', 'C4', 2.0000, 1.1095, '2025', NULL, NULL),
	(65, 'U0003', 'A03', 'C5', 3.0000, 1.3160, '2025', NULL, NULL),
	(66, 'U0003', 'A04', 'C1', 1.0000, 1.0000, '2025', NULL, NULL),
	(67, 'U0003', 'A04', 'C2', 4.0000, 1.3195, '2025', NULL, NULL),
	(68, 'U0003', 'A04', 'C3', 3.0000, 1.1791, '2025', NULL, NULL),
	(69, 'U0003', 'A04', 'C4', 2.0000, 1.1095, '2025', NULL, NULL),
	(70, 'U0003', 'A04', 'C5', 4.0000, 1.4142, '2025', NULL, NULL),
	(71, 'U0003', 'A05', 'C1', 1.0000, 1.0000, '2025', NULL, NULL),
	(72, 'U0003', 'A05', 'C2', 3.0000, 1.2457, '2025', NULL, NULL),
	(73, 'U0003', 'A05', 'C3', 3.0000, 1.1791, '2025', NULL, NULL),
	(74, 'U0003', 'A05', 'C4', 2.0000, 1.1095, '2025', NULL, NULL),
	(75, 'U0003', 'A05', 'C5', 5.0000, 1.4953, '2025', NULL, NULL),
	(76, 'U0003', 'A06', 'C1', 1.0000, 1.0000, '2025', NULL, NULL),
	(77, 'U0003', 'A06', 'C2', 2.0000, 1.1486, '2025', NULL, NULL),
	(78, 'U0003', 'A06', 'C3', 3.0000, 1.1791, '2025', NULL, NULL),
	(79, 'U0003', 'A06', 'C4', 2.0000, 1.1095, '2025', NULL, NULL),
	(80, 'U0003', 'A06', 'C5', 5.0000, 1.4953, '2025', NULL, NULL),
	(81, 'U0003', 'A07', 'C1', 1.0000, 1.0000, '2025', NULL, NULL),
	(82, 'U0003', 'A07', 'C2', 3.0000, 1.2457, '2025', NULL, NULL),
	(83, 'U0003', 'A07', 'C3', 3.0000, 1.1791, '2025', NULL, NULL),
	(84, 'U0003', 'A07', 'C4', 2.0000, 1.1095, '2025', NULL, NULL),
	(85, 'U0003', 'A07', 'C5', 3.0000, 1.3160, '2025', NULL, NULL),
	(86, 'U0003', 'A08', 'C1', 2.0000, 1.1892, '2025', NULL, NULL),
	(87, 'U0003', 'A08', 'C2', 2.0000, 1.1486, '2025', NULL, NULL),
	(88, 'U0003', 'A08', 'C3', 3.0000, 1.1791, '2025', NULL, NULL),
	(89, 'U0003', 'A08', 'C4', 1.0000, 1.0000, '2025', NULL, NULL),
	(90, 'U0003', 'A08', 'C5', 3.0000, 1.3160, '2025', NULL, NULL),
	(91, 'U0003', 'A09', 'C1', 1.0000, 1.0000, '2025', NULL, NULL),
	(92, 'U0003', 'A09', 'C2', 2.0000, 1.1486, '2025', NULL, NULL),
	(93, 'U0003', 'A09', 'C3', 3.0000, 1.1791, '2025', NULL, NULL),
	(94, 'U0003', 'A09', 'C4', 2.0000, 1.1095, '2025', NULL, NULL),
	(95, 'U0003', 'A09', 'C5', 2.0000, 1.1892, '2025', NULL, NULL),
	(96, 'U0003', 'A10', 'C1', 1.0000, 1.0000, '2025', NULL, NULL),
	(97, 'U0003', 'A10', 'C2', 3.0000, 1.2457, '2025', NULL, NULL),
	(98, 'U0003', 'A10', 'C3', 2.0000, 1.1095, '2025', NULL, NULL),
	(99, 'U0003', 'A10', 'C4', 2.0000, 1.1095, '2025', NULL, NULL),
	(100, 'U0003', 'A10', 'C5', 3.0000, 1.3160, '2025', NULL, NULL),
	(101, 'U0004', 'A01', 'C1', 1.0000, 1.0000, '2025', NULL, NULL),
	(102, 'U0004', 'A01', 'C2', 4.0000, 1.3195, '2025', NULL, NULL),
	(103, 'U0004', 'A01', 'C3', 4.0000, 1.2311, '2025', NULL, NULL),
	(104, 'U0004', 'A01', 'C4', 2.0000, 1.1095, '2025', NULL, NULL),
	(105, 'U0004', 'A01', 'C5', 5.0000, 1.4953, '2025', NULL, NULL),
	(106, 'U0004', 'A02', 'C1', 1.0000, 1.0000, '2025', NULL, NULL),
	(107, 'U0004', 'A02', 'C2', 4.0000, 1.3195, '2025', NULL, NULL),
	(108, 'U0004', 'A02', 'C3', 3.0000, 1.1791, '2025', NULL, NULL),
	(109, 'U0004', 'A02', 'C4', 2.0000, 1.1095, '2025', NULL, NULL),
	(110, 'U0004', 'A02', 'C5', 5.0000, 1.4953, '2025', NULL, NULL),
	(111, 'U0004', 'A03', 'C1', 1.0000, 1.0000, '2025', NULL, NULL),
	(112, 'U0004', 'A03', 'C2', 4.0000, 1.3195, '2025', NULL, NULL),
	(113, 'U0004', 'A03', 'C3', 4.0000, 1.2311, '2025', NULL, NULL),
	(114, 'U0004', 'A03', 'C4', 2.0000, 1.1095, '2025', NULL, NULL),
	(115, 'U0004', 'A03', 'C5', 4.0000, 1.4142, '2025', NULL, NULL),
	(116, 'U0004', 'A04', 'C1', 1.0000, 1.0000, '2025', NULL, NULL),
	(117, 'U0004', 'A04', 'C2', 4.0000, 1.3195, '2025', NULL, NULL),
	(118, 'U0004', 'A04', 'C3', 3.0000, 1.1791, '2025', NULL, NULL),
	(119, 'U0004', 'A04', 'C4', 2.0000, 1.1095, '2025', NULL, NULL),
	(120, 'U0004', 'A04', 'C5', 5.0000, 1.4953, '2025', NULL, NULL),
	(121, 'U0004', 'A05', 'C1', 1.0000, 1.0000, '2025', NULL, NULL),
	(122, 'U0004', 'A05', 'C2', 3.0000, 1.2457, '2025', NULL, NULL),
	(123, 'U0004', 'A05', 'C3', 3.0000, 1.1791, '2025', NULL, NULL),
	(124, 'U0004', 'A05', 'C4', 2.0000, 1.1095, '2025', NULL, NULL),
	(125, 'U0004', 'A05', 'C5', 4.0000, 1.4142, '2025', NULL, NULL),
	(126, 'U0004', 'A06', 'C1', 1.0000, 1.0000, '2025', NULL, NULL),
	(127, 'U0004', 'A06', 'C2', 2.0000, 1.1486, '2025', NULL, NULL),
	(128, 'U0004', 'A06', 'C3', 3.0000, 1.1791, '2025', NULL, NULL),
	(129, 'U0004', 'A06', 'C4', 2.0000, 1.1095, '2025', NULL, NULL),
	(130, 'U0004', 'A06', 'C5', 4.0000, 1.4142, '2025', NULL, NULL),
	(131, 'U0004', 'A07', 'C1', 1.0000, 1.0000, '2025', NULL, NULL),
	(132, 'U0004', 'A07', 'C2', 3.0000, 1.2457, '2025', NULL, NULL),
	(133, 'U0004', 'A07', 'C3', 3.0000, 1.1791, '2025', NULL, NULL),
	(134, 'U0004', 'A07', 'C4', 2.0000, 1.1095, '2025', NULL, NULL),
	(135, 'U0004', 'A07', 'C5', 3.0000, 1.3160, '2025', NULL, NULL),
	(136, 'U0004', 'A08', 'C1', 2.0000, 1.1892, '2025', NULL, NULL),
	(137, 'U0004', 'A08', 'C2', 2.0000, 1.1486, '2025', NULL, NULL),
	(138, 'U0004', 'A08', 'C3', 3.0000, 1.1791, '2025', NULL, NULL),
	(139, 'U0004', 'A08', 'C4', 1.0000, 1.0000, '2025', NULL, NULL),
	(140, 'U0004', 'A08', 'C5', 4.0000, 1.4142, '2025', NULL, NULL),
	(141, 'U0004', 'A09', 'C1', 1.0000, 1.0000, '2025', NULL, NULL),
	(142, 'U0004', 'A09', 'C2', 2.0000, 1.1486, '2025', NULL, NULL),
	(143, 'U0004', 'A09', 'C3', 3.0000, 1.1791, '2025', NULL, NULL),
	(144, 'U0004', 'A09', 'C4', 2.0000, 1.1095, '2025', NULL, NULL),
	(145, 'U0004', 'A09', 'C5', 3.0000, 1.3160, '2025', NULL, NULL),
	(146, 'U0004', 'A10', 'C1', 1.0000, 1.0000, '2025', NULL, NULL),
	(147, 'U0004', 'A10', 'C2', 3.0000, 1.2457, '2025', NULL, NULL),
	(148, 'U0004', 'A10', 'C3', 2.0000, 1.1095, '2025', NULL, NULL),
	(149, 'U0004', 'A10', 'C4', 2.0000, 1.1095, '2025', NULL, NULL),
	(150, 'U0004', 'A10', 'C5', 4.0000, 1.4142, '2025', NULL, NULL),
	(151, 'U0002', 'A01', 'C1', 1.0000, 1.0000, '2026', NULL, NULL),
	(152, 'U0002', 'A01', 'C2', 4.0000, 1.3195, '2026', NULL, NULL),
	(153, 'U0002', 'A01', 'C3', 4.0000, 1.2311, '2026', NULL, NULL),
	(154, 'U0002', 'A01', 'C4', 2.0000, 1.1095, '2026', NULL, NULL),
	(155, 'U0002', 'A01', 'C5', 4.0000, 1.4142, '2026', NULL, NULL),
	(156, 'U0002', 'A02', 'C1', 1.0000, 1.0000, '2026', NULL, NULL),
	(157, 'U0002', 'A02', 'C2', 4.0000, 1.3195, '2026', NULL, NULL),
	(158, 'U0002', 'A02', 'C3', 3.0000, 1.1791, '2026', NULL, NULL),
	(159, 'U0002', 'A02', 'C4', 2.0000, 1.1095, '2026', NULL, NULL),
	(160, 'U0002', 'A02', 'C5', 4.0000, 1.4142, '2026', NULL, NULL),
	(161, 'U0002', 'A03', 'C1', 1.0000, 1.0000, '2026', NULL, NULL),
	(162, 'U0002', 'A03', 'C2', 4.0000, 1.3195, '2026', NULL, NULL),
	(163, 'U0002', 'A03', 'C3', 4.0000, 1.2311, '2026', NULL, NULL),
	(164, 'U0002', 'A03', 'C4', 2.0000, 1.1095, '2026', NULL, NULL),
	(165, 'U0002', 'A03', 'C5', 4.0000, 1.4142, '2026', NULL, NULL),
	(166, 'U0002', 'A04', 'C1', 1.0000, 1.0000, '2026', NULL, NULL),
	(167, 'U0002', 'A04', 'C2', 4.0000, 1.3195, '2026', NULL, NULL),
	(168, 'U0002', 'A04', 'C3', 3.0000, 1.1791, '2026', NULL, NULL),
	(169, 'U0002', 'A04', 'C4', 2.0000, 1.1095, '2026', NULL, NULL),
	(170, 'U0002', 'A04', 'C5', 4.0000, 1.4142, '2026', NULL, NULL),
	(171, 'U0002', 'A05', 'C1', 1.0000, 1.0000, '2026', NULL, NULL),
	(172, 'U0002', 'A05', 'C2', 3.0000, 1.2457, '2026', NULL, NULL),
	(173, 'U0002', 'A05', 'C3', 3.0000, 1.1791, '2026', NULL, NULL),
	(174, 'U0002', 'A05', 'C4', 2.0000, 1.1095, '2026', NULL, NULL),
	(175, 'U0002', 'A05', 'C5', 5.0000, 1.4953, '2026', NULL, NULL),
	(176, 'U0002', 'A06', 'C1', 1.0000, 1.0000, '2026', NULL, NULL),
	(177, 'U0002', 'A06', 'C2', 2.0000, 1.1486, '2026', NULL, NULL),
	(178, 'U0002', 'A06', 'C3', 3.0000, 1.1791, '2026', NULL, NULL),
	(179, 'U0002', 'A06', 'C4', 2.0000, 1.1095, '2026', NULL, NULL),
	(180, 'U0002', 'A06', 'C5', 4.0000, 1.4142, '2026', NULL, NULL),
	(181, 'U0002', 'A07', 'C1', 1.0000, 1.0000, '2026', NULL, NULL),
	(182, 'U0002', 'A07', 'C2', 3.0000, 1.2457, '2026', NULL, NULL),
	(183, 'U0002', 'A07', 'C3', 3.0000, 1.1791, '2026', NULL, NULL),
	(184, 'U0002', 'A07', 'C4', 2.0000, 1.1095, '2026', NULL, NULL),
	(185, 'U0002', 'A07', 'C5', 3.0000, 1.3160, '2026', NULL, NULL),
	(186, 'U0002', 'A08', 'C1', 2.0000, 1.1892, '2026', NULL, NULL),
	(187, 'U0002', 'A08', 'C2', 2.0000, 1.1486, '2026', NULL, NULL),
	(188, 'U0002', 'A08', 'C3', 3.0000, 1.1791, '2026', NULL, NULL),
	(189, 'U0002', 'A08', 'C4', 1.0000, 1.0000, '2026', NULL, NULL),
	(190, 'U0002', 'A08', 'C5', 4.0000, 1.4142, '2026', NULL, NULL),
	(191, 'U0002', 'A09', 'C1', 1.0000, 1.0000, '2026', NULL, NULL),
	(192, 'U0002', 'A09', 'C2', 2.0000, 1.1486, '2026', NULL, NULL),
	(193, 'U0002', 'A09', 'C3', 3.0000, 1.1791, '2026', NULL, NULL),
	(194, 'U0002', 'A09', 'C4', 2.0000, 1.1095, '2026', NULL, NULL),
	(195, 'U0002', 'A09', 'C5', 2.0000, 1.1892, '2026', NULL, NULL),
	(196, 'U0002', 'A10', 'C1', 1.0000, 1.0000, '2026', NULL, NULL),
	(197, 'U0002', 'A10', 'C2', 3.0000, 1.2457, '2026', NULL, NULL),
	(198, 'U0002', 'A10', 'C3', 2.0000, 1.1095, '2026', NULL, NULL),
	(199, 'U0002', 'A10', 'C4', 2.0000, 1.1095, '2026', NULL, NULL),
	(200, 'U0002', 'A10', 'C5', 3.0000, 1.3160, '2026', NULL, NULL),
	(201, 'U0003', 'A01', 'C1', 1.0000, 1.0000, '2026', NULL, NULL),
	(202, 'U0003', 'A01', 'C2', 4.0000, 1.3195, '2026', NULL, NULL),
	(203, 'U0003', 'A01', 'C3', 4.0000, 1.2311, '2026', NULL, NULL),
	(204, 'U0003', 'A01', 'C4', 2.0000, 1.1095, '2026', NULL, NULL),
	(205, 'U0003', 'A01', 'C5', 5.0000, 1.4953, '2026', NULL, NULL),
	(206, 'U0003', 'A02', 'C1', 1.0000, 1.0000, '2026', NULL, NULL),
	(207, 'U0003', 'A02', 'C2', 4.0000, 1.3195, '2026', NULL, NULL),
	(208, 'U0003', 'A02', 'C3', 3.0000, 1.1791, '2026', NULL, NULL),
	(209, 'U0003', 'A02', 'C4', 2.0000, 1.1095, '2026', NULL, NULL),
	(210, 'U0003', 'A02', 'C5', 5.0000, 1.4953, '2026', NULL, NULL),
	(211, 'U0003', 'A03', 'C1', 1.0000, 1.0000, '2026', NULL, NULL),
	(212, 'U0003', 'A03', 'C2', 4.0000, 1.3195, '2026', NULL, NULL),
	(213, 'U0003', 'A03', 'C3', 4.0000, 1.2311, '2026', NULL, NULL),
	(214, 'U0003', 'A03', 'C4', 2.0000, 1.1095, '2026', NULL, NULL),
	(215, 'U0003', 'A03', 'C5', 3.0000, 1.3160, '2026', NULL, NULL),
	(216, 'U0003', 'A04', 'C1', 1.0000, 1.0000, '2026', NULL, NULL),
	(217, 'U0003', 'A04', 'C2', 4.0000, 1.3195, '2026', NULL, NULL),
	(218, 'U0003', 'A04', 'C3', 3.0000, 1.1791, '2026', NULL, NULL),
	(219, 'U0003', 'A04', 'C4', 2.0000, 1.1095, '2026', NULL, NULL),
	(220, 'U0003', 'A04', 'C5', 4.0000, 1.4142, '2026', NULL, NULL),
	(221, 'U0003', 'A05', 'C1', 1.0000, 1.0000, '2026', NULL, NULL),
	(222, 'U0003', 'A05', 'C2', 3.0000, 1.2457, '2026', NULL, NULL),
	(223, 'U0003', 'A05', 'C3', 3.0000, 1.1791, '2026', NULL, NULL),
	(224, 'U0003', 'A05', 'C4', 2.0000, 1.1095, '2026', NULL, NULL),
	(225, 'U0003', 'A05', 'C5', 5.0000, 1.4953, '2026', NULL, NULL),
	(226, 'U0003', 'A06', 'C1', 1.0000, 1.0000, '2026', NULL, NULL),
	(227, 'U0003', 'A06', 'C2', 2.0000, 1.1486, '2026', NULL, NULL),
	(228, 'U0003', 'A06', 'C3', 3.0000, 1.1791, '2026', NULL, NULL),
	(229, 'U0003', 'A06', 'C4', 2.0000, 1.1095, '2026', NULL, NULL),
	(230, 'U0003', 'A06', 'C5', 5.0000, 1.4953, '2026', NULL, NULL),
	(231, 'U0003', 'A07', 'C1', 1.0000, 1.0000, '2026', NULL, NULL),
	(232, 'U0003', 'A07', 'C2', 3.0000, 1.2457, '2026', NULL, NULL),
	(233, 'U0003', 'A07', 'C3', 3.0000, 1.1791, '2026', NULL, NULL),
	(234, 'U0003', 'A07', 'C4', 2.0000, 1.1095, '2026', NULL, NULL),
	(235, 'U0003', 'A07', 'C5', 3.0000, 1.3160, '2026', NULL, NULL),
	(236, 'U0003', 'A08', 'C1', 2.0000, 1.1892, '2026', NULL, NULL),
	(237, 'U0003', 'A08', 'C2', 2.0000, 1.1486, '2026', NULL, NULL),
	(238, 'U0003', 'A08', 'C3', 3.0000, 1.1791, '2026', NULL, NULL),
	(239, 'U0003', 'A08', 'C4', 1.0000, 1.0000, '2026', NULL, NULL),
	(240, 'U0003', 'A08', 'C5', 3.0000, 1.3160, '2026', NULL, NULL),
	(241, 'U0003', 'A09', 'C1', 1.0000, 1.0000, '2026', NULL, NULL),
	(242, 'U0003', 'A09', 'C2', 2.0000, 1.1486, '2026', NULL, NULL),
	(243, 'U0003', 'A09', 'C3', 3.0000, 1.1791, '2026', NULL, NULL),
	(244, 'U0003', 'A09', 'C4', 2.0000, 1.1095, '2026', NULL, NULL),
	(245, 'U0003', 'A09', 'C5', 2.0000, 1.1892, '2026', NULL, NULL),
	(246, 'U0003', 'A10', 'C1', 1.0000, 1.0000, '2026', NULL, NULL),
	(247, 'U0003', 'A10', 'C2', 3.0000, 1.2457, '2026', NULL, NULL),
	(248, 'U0003', 'A10', 'C3', 2.0000, 1.1095, '2026', NULL, NULL),
	(249, 'U0003', 'A10', 'C4', 2.0000, 1.1095, '2026', NULL, NULL),
	(250, 'U0003', 'A10', 'C5', 3.0000, 1.3160, '2026', NULL, NULL),
	(251, 'U0004', 'A01', 'C1', 1.0000, 1.0000, '2026', NULL, NULL),
	(252, 'U0004', 'A01', 'C2', 4.0000, 1.3195, '2026', NULL, NULL),
	(253, 'U0004', 'A01', 'C3', 4.0000, 1.2311, '2026', NULL, NULL),
	(254, 'U0004', 'A01', 'C4', 2.0000, 1.1095, '2026', NULL, NULL),
	(255, 'U0004', 'A01', 'C5', 5.0000, 1.4953, '2026', NULL, NULL),
	(256, 'U0004', 'A02', 'C1', 1.0000, 1.0000, '2026', NULL, NULL),
	(257, 'U0004', 'A02', 'C2', 4.0000, 1.3195, '2026', NULL, NULL),
	(258, 'U0004', 'A02', 'C3', 3.0000, 1.1791, '2026', NULL, NULL),
	(259, 'U0004', 'A02', 'C4', 2.0000, 1.1095, '2026', NULL, NULL),
	(260, 'U0004', 'A02', 'C5', 5.0000, 1.4953, '2026', NULL, NULL),
	(261, 'U0004', 'A03', 'C1', 1.0000, 1.0000, '2026', NULL, NULL),
	(262, 'U0004', 'A03', 'C2', 4.0000, 1.3195, '2026', NULL, NULL),
	(263, 'U0004', 'A03', 'C3', 4.0000, 1.2311, '2026', NULL, NULL),
	(264, 'U0004', 'A03', 'C4', 2.0000, 1.1095, '2026', NULL, NULL),
	(265, 'U0004', 'A03', 'C5', 4.0000, 1.4142, '2026', NULL, NULL),
	(266, 'U0004', 'A04', 'C1', 1.0000, 1.0000, '2026', NULL, NULL),
	(267, 'U0004', 'A04', 'C2', 4.0000, 1.3195, '2026', NULL, NULL),
	(268, 'U0004', 'A04', 'C3', 3.0000, 1.1791, '2026', NULL, NULL),
	(269, 'U0004', 'A04', 'C4', 2.0000, 1.1095, '2026', NULL, NULL),
	(270, 'U0004', 'A04', 'C5', 5.0000, 1.4953, '2026', NULL, NULL),
	(271, 'U0004', 'A05', 'C1', 1.0000, 1.0000, '2026', NULL, NULL),
	(272, 'U0004', 'A05', 'C2', 3.0000, 1.2457, '2026', NULL, NULL),
	(273, 'U0004', 'A05', 'C3', 3.0000, 1.1791, '2026', NULL, NULL),
	(274, 'U0004', 'A05', 'C4', 2.0000, 1.1095, '2026', NULL, NULL),
	(275, 'U0004', 'A05', 'C5', 4.0000, 1.4142, '2026', NULL, NULL),
	(276, 'U0004', 'A06', 'C1', 1.0000, 1.0000, '2026', NULL, NULL),
	(277, 'U0004', 'A06', 'C2', 2.0000, 1.1486, '2026', NULL, NULL),
	(278, 'U0004', 'A06', 'C3', 3.0000, 1.1791, '2026', NULL, NULL),
	(279, 'U0004', 'A06', 'C4', 2.0000, 1.1095, '2026', NULL, NULL),
	(280, 'U0004', 'A06', 'C5', 4.0000, 1.4142, '2026', NULL, NULL),
	(281, 'U0004', 'A07', 'C1', 1.0000, 1.0000, '2026', NULL, NULL),
	(282, 'U0004', 'A07', 'C2', 3.0000, 1.2457, '2026', NULL, NULL),
	(283, 'U0004', 'A07', 'C3', 3.0000, 1.1791, '2026', NULL, NULL),
	(284, 'U0004', 'A07', 'C4', 2.0000, 1.1095, '2026', NULL, NULL),
	(285, 'U0004', 'A07', 'C5', 3.0000, 1.3160, '2026', NULL, NULL),
	(286, 'U0004', 'A08', 'C1', 2.0000, 1.1892, '2026', NULL, NULL),
	(287, 'U0004', 'A08', 'C2', 2.0000, 1.1486, '2026', NULL, NULL),
	(288, 'U0004', 'A08', 'C3', 3.0000, 1.1791, '2026', NULL, NULL),
	(289, 'U0004', 'A08', 'C4', 1.0000, 1.0000, '2026', NULL, NULL),
	(290, 'U0004', 'A08', 'C5', 4.0000, 1.4142, '2026', NULL, NULL),
	(291, 'U0004', 'A09', 'C1', 1.0000, 1.0000, '2026', NULL, NULL),
	(292, 'U0004', 'A09', 'C2', 2.0000, 1.1486, '2026', NULL, NULL),
	(293, 'U0004', 'A09', 'C3', 3.0000, 1.1791, '2026', NULL, NULL),
	(294, 'U0004', 'A09', 'C4', 2.0000, 1.1095, '2026', NULL, NULL),
	(295, 'U0004', 'A09', 'C5', 3.0000, 1.3160, '2026', NULL, NULL),
	(296, 'U0004', 'A10', 'C1', 1.0000, 1.0000, '2026', NULL, NULL),
	(297, 'U0004', 'A10', 'C2', 3.0000, 1.2457, '2026', NULL, NULL),
	(298, 'U0004', 'A10', 'C3', 2.0000, 1.1095, '2026', NULL, NULL),
	(299, 'U0004', 'A10', 'C4', 2.0000, 1.1095, '2026', NULL, NULL),
	(300, 'U0004', 'A10', 'C5', 4.0000, 1.4142, '2026', NULL, NULL);

-- Dumping structure for table gdss-dospem.preferensi_wp
CREATE TABLE IF NOT EXISTS `preferensi_wp` (
  `id_pref` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_alt` char(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_user` char(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `perkalian` decimal(10,4) NOT NULL,
  `skor_pref` decimal(10,4) NOT NULL,
  `rangking_wp` int NOT NULL,
  `tahun` year NOT NULL DEFAULT '2025',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_pref`),
  KEY `preferensi_wp_id_alt_foreign` (`id_alt`),
  KEY `preferensi_wp_id_user_foreign` (`id_user`),
  KEY `preferensi_wp_tahun_index` (`tahun`),
  CONSTRAINT `preferensi_wp_id_alt_foreign` FOREIGN KEY (`id_alt`) REFERENCES `alternatif` (`id_alt`) ON DELETE CASCADE,
  CONSTRAINT `preferensi_wp_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table gdss-dospem.preferensi_wp: ~60 rows (approximately)
INSERT INTO `preferensi_wp` (`id_pref`, `id_alt`, `id_user`, `perkalian`, `skor_pref`, `rangking_wp`, `tahun`, `created_at`, `updated_at`) VALUES
	(1, 'A01', 'U0002', 2.5491, 0.1119, 1, '2025', NULL, NULL),
	(2, 'A02', 'U0002', 2.4414, 0.1072, 3, '2025', NULL, NULL),
	(3, 'A03', 'U0002', 2.5491, 0.1119, 2, '2025', NULL, NULL),
	(4, 'A04', 'U0002', 2.4414, 0.1072, 4, '2025', NULL, NULL),
	(5, 'A05', 'U0002', 2.4371, 0.1070, 5, '2025', NULL, NULL),
	(6, 'A06', 'U0002', 2.1254, 0.0933, 8, '2025', NULL, NULL),
	(7, 'A07', 'U0002', 2.1449, 0.0941, 7, '2025', NULL, NULL),
	(8, 'A08', 'U0002', 2.2779, 0.1000, 6, '2025', NULL, NULL),
	(9, 'A09', 'U0002', 1.7872, 0.0784, 10, '2025', NULL, NULL),
	(10, 'A10', 'U0002', 2.0184, 0.0886, 9, '2025', NULL, NULL),
	(11, 'A01', 'U0003', 2.6953, 0.1179, 1, '2025', NULL, NULL),
	(12, 'A02', 'U0003', 2.5815, 0.1129, 2, '2025', NULL, NULL),
	(13, 'A03', 'U0003', 2.3722, 0.1038, 5, '2025', NULL, NULL),
	(14, 'A04', 'U0003', 2.4414, 0.1068, 3, '2025', NULL, NULL),
	(15, 'A05', 'U0003', 2.4371, 0.1066, 4, '2025', NULL, NULL),
	(16, 'A06', 'U0003', 2.2473, 0.0983, 6, '2025', NULL, NULL),
	(17, 'A07', 'U0003', 2.1449, 0.0938, 7, '2025', NULL, NULL),
	(18, 'A08', 'U0003', 2.1198, 0.0927, 8, '2025', NULL, NULL),
	(19, 'A09', 'U0003', 1.7872, 0.0782, 10, '2025', NULL, NULL),
	(20, 'A10', 'U0003', 2.0184, 0.0883, 9, '2025', NULL, NULL),
	(21, 'A01', 'U0004', 2.6953, 0.1151, 1, '2025', NULL, NULL),
	(22, 'A02', 'U0004', 2.5815, 0.1102, 2, '2025', NULL, NULL),
	(23, 'A03', 'U0004', 2.5491, 0.1089, 4, '2025', NULL, NULL),
	(24, 'A04', 'U0004', 2.5815, 0.1102, 3, '2025', NULL, NULL),
	(25, 'A05', 'U0004', 2.3049, 0.0984, 5, '2025', NULL, NULL),
	(26, 'A06', 'U0004', 2.1254, 0.0907, 9, '2025', NULL, NULL),
	(27, 'A07', 'U0004', 2.1449, 0.0916, 8, '2025', NULL, NULL),
	(28, 'A08', 'U0004', 2.2779, 0.0973, 6, '2025', NULL, NULL),
	(29, 'A09', 'U0004', 1.9779, 0.0844, 10, '2025', NULL, NULL),
	(30, 'A10', 'U0004', 2.1689, 0.0926, 7, '2025', NULL, NULL),
	(31, 'A01', 'U0002', 2.5491, 0.1119, 1, '2026', NULL, NULL),
	(32, 'A02', 'U0002', 2.4414, 0.1072, 3, '2026', NULL, NULL),
	(33, 'A03', 'U0002', 2.5491, 0.1119, 2, '2026', NULL, NULL),
	(34, 'A04', 'U0002', 2.4414, 0.1072, 4, '2026', NULL, NULL),
	(35, 'A05', 'U0002', 2.4371, 0.1070, 5, '2026', NULL, NULL),
	(36, 'A06', 'U0002', 2.1254, 0.0933, 8, '2026', NULL, NULL),
	(37, 'A07', 'U0002', 2.1449, 0.0941, 7, '2026', NULL, NULL),
	(38, 'A08', 'U0002', 2.2779, 0.1000, 6, '2026', NULL, NULL),
	(39, 'A09', 'U0002', 1.7872, 0.0784, 10, '2026', NULL, NULL),
	(40, 'A10', 'U0002', 2.0184, 0.0886, 9, '2026', NULL, NULL),
	(41, 'A01', 'U0003', 2.6953, 0.1179, 1, '2026', NULL, NULL),
	(42, 'A02', 'U0003', 2.5815, 0.1129, 2, '2026', NULL, NULL),
	(43, 'A03', 'U0003', 2.3722, 0.1038, 5, '2026', NULL, NULL),
	(44, 'A04', 'U0003', 2.4414, 0.1068, 3, '2026', NULL, NULL),
	(45, 'A05', 'U0003', 2.4371, 0.1066, 4, '2026', NULL, NULL),
	(46, 'A06', 'U0003', 2.2473, 0.0983, 6, '2026', NULL, NULL),
	(47, 'A07', 'U0003', 2.1449, 0.0938, 7, '2026', NULL, NULL),
	(48, 'A08', 'U0003', 2.1198, 0.0927, 8, '2026', NULL, NULL),
	(49, 'A09', 'U0003', 1.7872, 0.0782, 10, '2026', NULL, NULL),
	(50, 'A10', 'U0003', 2.0184, 0.0883, 9, '2026', NULL, NULL),
	(51, 'A01', 'U0004', 2.6953, 0.1151, 1, '2026', NULL, NULL),
	(52, 'A02', 'U0004', 2.5815, 0.1102, 2, '2026', NULL, NULL),
	(53, 'A03', 'U0004', 2.5491, 0.1089, 4, '2026', NULL, NULL),
	(54, 'A04', 'U0004', 2.5815, 0.1102, 3, '2026', NULL, NULL),
	(55, 'A05', 'U0004', 2.3049, 0.0984, 5, '2026', NULL, NULL),
	(56, 'A06', 'U0004', 2.1254, 0.0907, 9, '2026', NULL, NULL),
	(57, 'A07', 'U0004', 2.1449, 0.0916, 8, '2026', NULL, NULL),
	(58, 'A08', 'U0004', 2.2779, 0.0973, 6, '2026', NULL, NULL),
	(59, 'A09', 'U0004', 1.9779, 0.0844, 10, '2026', NULL, NULL),
	(60, 'A10', 'U0004', 2.1689, 0.0926, 7, '2026', NULL, NULL);

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

-- Dumping data for table gdss-dospem.users: ~4 rows (approximately)
INSERT INTO `users` (`id_user`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	('U0001', 'Administrator', 'admin@gdss.com', NULL, '$2y$12$Q4BIU2cjq9x2HE9mLiByLeMQET5/4raq5ozt8GQ32W/GRfDxCsx.e', NULL, '2025-12-10 22:15:48', NULL),
	('U0002', 'Kepala Departemen', 'kadep@gdss.com', NULL, '$2y$12$AKPnhgExGaOL9n..e5cp9eXClxz8r4QepNw8sq5KixsQAbEq5/7FO', NULL, '2025-12-10 22:15:48', NULL),
	('U0003', 'Sekretaris Departemen', 'sekdep@gdss.com', NULL, '$2y$12$lk9dujzI3UkBPmzV4YMfZeewMorzS5pKgru77ORcuo.Cc7dwfYrtm', NULL, '2025-12-10 22:15:48', NULL),
	('U0004', 'Kepala Program Studi', 'kaprodi@gdss.com', NULL, '$2y$12$bFGvBhdcn0aok6SZiM5KdutzgnUTl6UWZIsQuOyPJ.8vDhcMYem1q', NULL, '2025-12-10 22:15:48', NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
