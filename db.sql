# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.5-10.4.13-MariaDB)
# Database: contoh_aplikasi_saw
# Generation Time: 2021-04-06 14:08:33 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table atribut
# ------------------------------------------------------------

DROP TABLE IF EXISTS `atribut`;

CREATE TABLE `atribut` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kriteria_id` bigint(20) unsigned DEFAULT NULL,
  `mahasiswa_id` bigint(20) unsigned DEFAULT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `atribut_kriteria_id_foreign` (`kriteria_id`),
  KEY `atribut_mahasiswa_id_foreign` (`mahasiswa_id`),
  CONSTRAINT `atribut_kriteria_id_foreign` FOREIGN KEY (`kriteria_id`) REFERENCES `kriteria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `atribut_mahasiswa_id_foreign` FOREIGN KEY (`mahasiswa_id`) REFERENCES `mahasiswa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `atribut` WRITE;
/*!40000 ALTER TABLE `atribut` DISABLE KEYS */;

INSERT INTO `atribut` (`id`, `kriteria_id`, `mahasiswa_id`, `value`, `created_at`, `updated_at`)
VALUES
	(1,1,1,'3.92',NULL,NULL),
	(2,1,2,'3.95',NULL,NULL),
	(3,1,3,'3.4',NULL,NULL),
	(4,1,4,'4',NULL,NULL),
	(5,1,5,'3.2',NULL,NULL),
	(6,2,1,'2',NULL,NULL),
	(7,2,2,'3',NULL,NULL),
	(8,2,3,'4',NULL,NULL),
	(9,2,4,'3',NULL,NULL),
	(10,2,5,'1',NULL,NULL),
	(11,3,1,'2',NULL,NULL),
	(12,3,2,'2',NULL,NULL),
	(13,3,3,'3',NULL,NULL),
	(14,3,4,'4',NULL,NULL),
	(15,3,5,'2',NULL,NULL),
	(16,4,1,'4',NULL,NULL),
	(17,4,2,'3',NULL,NULL),
	(18,4,3,'2',NULL,NULL),
	(19,4,4,'4',NULL,NULL),
	(20,4,5,'1',NULL,NULL),
	(21,5,1,'100',NULL,NULL),
	(22,5,2,'89',NULL,NULL),
	(23,5,3,'70',NULL,NULL),
	(24,5,4,'120',NULL,NULL),
	(25,5,5,'140',NULL,NULL);

/*!40000 ALTER TABLE `atribut` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table config
# ------------------------------------------------------------

DROP TABLE IF EXISTS `config`;

CREATE TABLE `config` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table crips
# ------------------------------------------------------------

DROP TABLE IF EXISTS `crips`;

CREATE TABLE `crips` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_crips` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `crips` WRITE;
/*!40000 ALTER TABLE `crips` DISABLE KEYS */;

INSERT INTO `crips` (`id`, `nama_crips`, `created_at`, `updated_at`)
VALUES
	(1,'Penghasilan Orang Tua',NULL,NULL),
	(2,'Prestasi',NULL,NULL);

/*!40000 ALTER TABLE `crips` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table crips_detail
# ------------------------------------------------------------

DROP TABLE IF EXISTS `crips_detail`;

CREATE TABLE `crips_detail` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `crips_id` bigint(20) unsigned DEFAULT NULL,
  `deskripsi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kelompok` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `crips_detail_crips_id_foreign` (`crips_id`),
  CONSTRAINT `crips_detail_crips_id_foreign` FOREIGN KEY (`crips_id`) REFERENCES `crips` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `crips_detail` WRITE;
/*!40000 ALTER TABLE `crips_detail` DISABLE KEYS */;

INSERT INTO `crips_detail` (`id`, `crips_id`, `deskripsi`, `kelompok`, `created_at`, `updated_at`)
VALUES
	(1,1,'<= Rp. 1.000.000',1,NULL,NULL),
	(2,1,'Rp. 1.000.000 - Rp. 3.000.000',2,NULL,NULL),
	(3,1,'Rp. 3.000.000 - Rp. 5.000.000',3,NULL,NULL),
	(4,1,'>= Rp. 5.000.000',4,NULL,NULL),
	(6,2,'Tingkat Kota/Kabupaten',1,NULL,NULL),
	(7,2,'Tingkat Provinsi',2,NULL,NULL),
	(8,2,'Tingkat Nasional',3,NULL,NULL),
	(9,2,'Tingkat Internasional',4,NULL,NULL);

/*!40000 ALTER TABLE `crips_detail` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table failed_jobs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table kriteria
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kriteria`;

CREATE TABLE `kriteria` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_kriteria` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `satuan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bobot` double(5,2) DEFAULT NULL,
  `crips_id` bigint(20) unsigned DEFAULT NULL,
  `tipe_data` enum('integer','float','crips') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kriteria_crips_id_foreign` (`crips_id`),
  CONSTRAINT `kriteria_crips_id_foreign` FOREIGN KEY (`crips_id`) REFERENCES `crips` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `kriteria` WRITE;
/*!40000 ALTER TABLE `kriteria` DISABLE KEYS */;

INSERT INTO `kriteria` (`id`, `nama_kriteria`, `satuan`, `bobot`, `crips_id`, `tipe_data`, `created_at`, `updated_at`)
VALUES
	(1,'IPK','-',25.00,NULL,'float',NULL,NULL),
	(2,'Penghasilan Ortu/bln','juta',15.00,1,'crips',NULL,NULL),
	(3,'Jumlah Tanggungan','orang',20.00,NULL,'integer',NULL,NULL),
	(4,'Prestasi','-',30.00,2,'crips',NULL,NULL),
	(5,'Lokasi Rumah','km',10.00,NULL,'integer',NULL,NULL);

/*!40000 ALTER TABLE `kriteria` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table mahasiswa
# ------------------------------------------------------------

DROP TABLE IF EXISTS `mahasiswa`;

CREATE TABLE `mahasiswa` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nim` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `mahasiswa` WRITE;
/*!40000 ALTER TABLE `mahasiswa` DISABLE KEYS */;

INSERT INTO `mahasiswa` (`id`, `nim`, `nama`, `created_at`, `updated_at`)
VALUES
	(1,'137006990','Lionel Messi',NULL,NULL),
	(2,'137006991','Cristiano Ronaldo',NULL,NULL),
	(3,'137006992','Muhammad Salah',NULL,NULL),
	(4,'137006993','Ponaryo Astaman',NULL,NULL),
	(5,'137006994','Robert Lewandowski',NULL,NULL);

/*!40000 ALTER TABLE `mahasiswa` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES
	(1,'2014_10_12_000000_create_users_table',1),
	(2,'2014_10_12_100000_create_password_resets_table',1),
	(3,'2019_08_19_000000_create_failed_jobs_table',1),
	(4,'2021_03_03_204252_create_saw_table',2);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table password_resets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`)
VALUES
	(1,'Dede Gunawan','gunawanassanusi1@gmail.com',NULL,'$2y$10$z1Y33B18z01DiStN0ij5iunnSx2dT5aIau3nFSTFSfx8H1oYTm3G.',NULL,'2021-03-03 20:19:32','2021-03-03 20:19:32'),
	(2,'Dede Gunawan','dede@unsil.ac.id',NULL,'$2y$10$4OY05lLokozsO2mVwO4MtuhQz6imTF3AwiFmaDx.idQJ3Vwnexave',NULL,'2021-03-07 05:38:05','2021-03-07 05:38:05');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
