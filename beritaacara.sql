-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 01, 2026 at 10:45 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_berita_acara`
--

-- --------------------------------------------------------

--
-- Table structure for table `berita_acara`
--

CREATE TABLE `berita_acara` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `wa_notif_sent_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_pelanggan`
--

CREATE TABLE `data_pelanggan` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_ktp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat_lengkap` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `wa_notif_sent_at` timestamp NULL DEFAULT NULL,
  `tanggal_registrasi` date NOT NULL,
  `jenis_perangkat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mac_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_teknisi_1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_teknisi_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paket_berlangganan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `biaya_registrasi` decimal(12,2) NOT NULL DEFAULT '0.00',
  `accept_terms` tinyint(1) NOT NULL DEFAULT '0',
  `tanda_tangan_pelanggan` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanda_tangan_petugas` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto_rumah` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_odp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_dokumentasi_pelanggan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `data_pelanggan`
--

INSERT INTO `data_pelanggan` (`id`, `nama_lengkap`, `no_ktp`, `email`, `alamat_lengkap`, `no_hp`, `wa_notif_sent_at`, `tanggal_registrasi`, `jenis_perangkat`, `mac_address`, `serial_number`, `nama_teknisi_1`, `nama_teknisi_2`, `paket_berlangganan`, `biaya_registrasi`, `accept_terms`, `tanda_tangan_pelanggan`, `tanda_tangan_petugas`, `foto_rumah`, `foto_odp`, `foto_dokumentasi_pelanggan`, `created_at`, `updated_at`, `user_id`) VALUES
(23, 'SAKARSO', '3512012407590001', 'Sakarso@gmail.com', 'KP.PETTONG RT.001 / RW.001 PATEMO', '085232477300', NULL, '2026-01-29', 'XSF609', '08:AA:81:50:C3:75', 'ZICG8150C375', 'FATHOR ROSYID', 'SUTIPYO', 'Rp. 125.000 (10 Mbps)', '250000.00', 1, 'tanda-tangan/tanda_tangan_pelanggan_1769760656.png', 'tanda-tangan/tanda_tangan_petugas_1769760656.png', 'berita-acara/UuVQ1FgDl6cJWsyW2QnzfjXNIQFrF6Kp3NpbkqZp.jpg', 'berita-acara/HHxFpygxSVWF4Z0NgnZaimLpEodr77D4HTgvGUkJ.jpg', 'berita-acara/fZLFh3YMWIvWyj9UWWcUzNLkZPO3159qujbGcF2V.jpg', '2026-01-30 08:10:56', '2026-01-30 08:10:56', 2),
(24, 'HOLIP', '3512010103020001', 'Holip@gmail.com', 'Jatibanteng kab Situbondo Provinsi Jawa Timur', '082247686565', NULL, '2026-01-29', 'XSF609', '08:AA:5B:1E:D8:11', 'ZICG5B1ED811', 'FATHOR ROSYID', 'SUTIPYO', 'Rp. 125.000 (10 Mbps)', '250000.00', 1, 'tanda-tangan/tanda_tangan_pelanggan_1769760909.png', 'tanda-tangan/tanda_tangan_petugas_1769760909.png', 'berita-acara/tIRCysWDe19KtFOENTYXCtVdWDEhUTq8vmi3Xz0Q.jpg', 'berita-acara/bXzFsHKhsHpuXFrxPa7wKsOSlkGv3a6LSMY4KcCM.jpg', 'berita-acara/fJGSOKTDDUFtZSibiBZRKlh6fR09ac3ZWVhY3t5b.jpg', '2026-01-30 08:15:09', '2026-01-30 08:15:09', 2),
(26, 'SUHARTO', '3512010103020098', 'Suharto@gmail.com', 'KP. PETONG RT 002 RW 002 DESA PATEMON KEC JATIBANTENG', '082132282557', NULL, '2026-01-29', 'XSF609', '08:AA:76:E5:90:FB', 'ZICG76E590FA', 'FATHOR ROSYID', 'SUTIPYO', 'Rp. 125.000 (10 Mbps)', '250000.00', 1, 'tanda-tangan/tanda_tangan_pelanggan_1769761149.png', 'tanda-tangan/tanda_tangan_petugas_1769761149.png', 'berita-acara/2Oekq5XcezPrcgubkNqLukyBW5qFll74nnw4ILrs.jpg', 'berita-acara/GWKL4AVBdl5z0AsnVTTkpBkW65pei875gIkOf0rj.jpg', 'berita-acara/ycMjOvlvUDYNx8kknovAeEz4rrDW40Eg4tuqo6o6.jpg', '2026-01-30 08:19:09', '2026-01-30 08:19:09', 2),
(27, 'TRINITA SUHARTINI', '3512165004020001', 'trinitasuhartini@gmail.com', 'KP. BRINGIN RT. 003 / RW. 002 SELOBANTENG Kecamatan banyuglugur  Kabupaten Situbondo  Provinsi Jawa rimur', '085232477300', NULL, '2026-01-31', 'xstech', '08:AA:DC:67:87:53', 'ZICGDC678753', 'FATHOR ROSYID', 'FATHOR ROSYID', 'Rp. 125.000 (10 Mbps)', '250000.00', 1, 'tanda-tangan/tanda_tangan_pelanggan_1769918339.png', 'tanda-tangan/tanda_tangan_petugas_1769918339.png', 'berita-acara/y7YZAqj4bC0jYXhR8I6HpsuRUnoUwbfARHWhc08n.jpg', 'berita-acara/EwzzajF7V0zyTsemdYs2eiuTHZFflR1dzxRG7FZL.jpg', 'berita-acara/wEai7TTcHe95iVnPgpGgfTDwixvaYlY4AiWrZcPl.jpg', '2026-02-01 03:58:59', '2026-02-01 03:58:59', 2),
(28, 'REDITA UTOMO', '3512164707950002', 'reditautomo@gmail.com', 'KP.BUNUT RT.003 / RW.003 SELOBANTENG Kecamatan banyuglugur Kabupaten Situbondo Provinsi Jawa timur', '082131380064', NULL, '2026-01-31', 'xstech', '08:AA:0E:42:1F:51', 'ZICG0E421F51', 'FATHOR ROSYID', 'FATHOR ROSYID', 'Rp. 125.000 (10 Mbps)', '250000.00', 1, 'tanda-tangan/tanda_tangan_pelanggan_1769918558.png', 'tanda-tangan/tanda_tangan_petugas_1769918558.png', 'berita-acara/57JSaRv98bfdRJJScl8Rfjwo1JCIUudTgApfvY1A.jpg', 'berita-acara/WDMRG6NxrWf8cGFCLMTw5IYhoP4yLwTonedW6qPs.jpg', 'berita-acara/FDDspA2Kus5Bbc1y4pcjnMSHopE5ZzM3zFn4uIvC.jpg', '2026-02-01 04:02:38', '2026-02-01 04:02:38', 2);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

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
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login_logs`
--

CREATE TABLE `login_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `login_time` timestamp NULL DEFAULT NULL,
  `login_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `login_logs`
--

INSERT INTO `login_logs` (`id`, `user_id`, `email`, `ip_address`, `login_time`, `login_at`, `created_at`, `updated_at`) VALUES
(1, 4, 'abisma410@gmail.com', '127.0.0.1', '2025-11-12 12:57:42', '2025-11-12 06:52:25', '2025-11-11 23:52:25', '2025-11-12 12:57:42'),
(2, 4, 'abisma410@gmail.com', '127.0.0.1', NULL, '2025-11-12 06:52:25', '2025-11-11 23:52:25', '2025-11-11 23:52:25'),
(3, 1, 'admin@gmail.com', '127.0.0.1', '2025-11-12 13:07:01', '2025-11-12 06:52:41', '2025-11-11 23:52:41', '2025-11-12 13:07:01'),
(10, 6, 'ananda@gmail.com', '127.0.0.1', '2025-11-12 05:50:43', '2025-11-12 07:48:56', '2025-11-12 00:48:56', '2025-11-12 05:50:43'),
(14, 1, 'admin@gmail.com', '127.0.0.1', '2025-11-12 05:47:43', '2025-11-12 12:47:43', '2025-11-12 05:47:43', '2025-11-12 05:47:43'),
(15, 1, 'admin@gmail.com', '127.0.0.1', '2025-11-12 13:09:30', '2025-11-12 13:09:30', '2025-11-12 13:09:30', '2025-11-12 13:09:30'),
(16, 2, 'teknisi@gmail.com', '127.0.0.1', '2025-11-12 13:12:59', '2025-11-12 13:12:59', '2025-11-12 13:12:59', '2025-11-12 13:12:59'),
(17, 4, 'abisma410@gmail.com', '127.0.0.1', '2025-11-12 13:13:14', '2025-11-12 13:13:14', '2025-11-12 13:13:14', '2025-11-12 13:13:14'),
(18, 6, 'ananda@gmail.com', '127.0.0.1', '2025-11-12 13:13:29', '2025-11-12 13:13:29', '2025-11-12 13:13:29', '2025-11-12 13:13:29'),
(19, 1, 'admin@gmail.com', '127.0.0.1', '2025-11-12 13:13:44', '2025-11-12 13:13:44', '2025-11-12 13:13:44', '2025-11-12 13:13:44'),
(20, 4, 'abisma410@gmail.com', '127.0.0.1', '2025-11-12 13:20:30', '2025-11-12 13:20:30', '2025-11-12 13:20:30', '2025-11-12 13:20:30'),
(21, 1, 'admin@gmail.com', '127.0.0.1', '2025-11-12 13:23:33', '2025-11-12 13:23:33', '2025-11-12 13:23:33', '2025-11-12 13:23:33'),
(22, 1, 'admin@gmail.com', '127.0.0.1', '2025-11-14 07:59:16', '2025-11-14 07:59:16', '2025-11-14 07:59:16', '2025-11-14 07:59:16'),
(23, 1, 'admin@gmail.com', '127.0.0.1', '2025-11-14 08:43:58', '2025-11-14 08:43:58', '2025-11-14 08:43:58', '2025-11-14 08:43:58'),
(24, 4, 'abisma410@gmail.com', '127.0.0.1', '2025-11-14 08:46:03', '2025-11-14 08:46:03', '2025-11-14 08:46:03', '2025-11-14 08:46:03'),
(25, 1, 'admin@gmail.com', '127.0.0.1', '2025-11-14 08:49:57', '2025-11-14 08:49:57', '2025-11-14 08:49:57', '2025-11-14 08:49:57'),
(26, 1, 'admin@gmail.com', '127.0.0.1', '2025-11-14 09:26:09', '2025-11-14 09:26:09', '2025-11-14 09:26:09', '2025-11-14 09:26:09'),
(27, 1, 'admin@gmail.com', '127.0.0.1', '2025-11-14 09:29:25', '2025-11-14 09:29:25', '2025-11-14 09:29:25', '2025-11-14 09:29:25'),
(28, 1, 'admin@gmail.com', '192.168.1.22', '2025-11-14 12:29:55', '2025-11-14 12:29:55', '2025-11-14 12:29:55', '2025-11-14 12:29:55'),
(29, 1, 'admin@gmail.com', '192.168.1.8', '2025-11-14 12:31:09', '2025-11-14 12:31:09', '2025-11-14 12:31:09', '2025-11-14 12:31:09'),
(30, 2, 'teknisi@gmail.com', '192.168.1.22', '2025-11-14 12:49:39', '2025-11-14 12:49:39', '2025-11-14 12:49:39', '2025-11-14 12:49:39'),
(31, 1, 'admin@gmail.com', '192.168.1.22', '2025-11-14 12:50:59', '2025-11-14 12:50:59', '2025-11-14 12:50:59', '2025-11-14 12:50:59'),
(32, 1, 'admin@gmail.com', '127.0.0.1', '2025-11-16 12:33:25', '2025-11-16 12:33:25', '2025-11-16 12:33:25', '2025-11-16 12:33:25'),
(33, 1, 'admin@gmail.com', '127.0.0.1', '2025-11-17 11:45:56', '2025-11-17 11:45:56', '2025-11-17 11:45:56', '2025-11-17 11:45:56'),
(34, 2, 'teknisi@gmail.com', '127.0.0.1', '2025-11-17 11:46:27', '2025-11-17 11:46:27', '2025-11-17 11:46:27', '2025-11-17 11:46:27'),
(35, 4, 'abisma410@gmail.com', '127.0.0.1', '2025-11-17 11:46:45', '2025-11-17 11:46:45', '2025-11-17 11:46:45', '2025-11-17 11:46:45'),
(36, 1, 'admin@gmail.com', '127.0.0.1', '2025-11-18 06:34:56', '2025-11-18 06:34:56', '2025-11-18 06:34:56', '2025-11-18 06:34:56'),
(37, 2, 'teknisi@gmail.com', '127.0.0.1', '2025-11-18 07:18:01', '2025-11-18 07:18:01', '2025-11-18 07:18:01', '2025-11-18 07:18:01'),
(38, 1, 'admin1@gmail.com', '127.0.0.1', '2025-11-18 07:19:07', '2025-11-18 07:19:07', '2025-11-18 07:19:07', '2025-11-18 07:19:07'),
(39, 2, 'teknisi@gmail.com', '127.0.0.1', '2025-11-18 07:35:24', '2025-11-18 07:35:24', '2025-11-18 07:35:24', '2025-11-18 07:35:24'),
(40, 1, 'admin1@gmail.com', '127.0.0.1', '2025-11-18 07:45:00', '2025-11-18 07:45:00', '2025-11-18 07:45:00', '2025-11-18 07:45:00'),
(41, 1, 'admin1@gmail.com', '127.0.0.1', '2025-11-18 14:56:34', '2025-11-18 14:56:34', '2025-11-18 14:56:34', '2025-11-18 14:56:34'),
(42, 2, 'teknisi@gmail.com', '127.0.0.1', '2025-11-19 07:37:45', '2025-11-19 07:37:46', '2025-11-19 07:37:46', '2025-11-19 07:37:46'),
(43, 4, 'abisma410@gmail.com', '127.0.0.1', '2025-11-21 07:00:31', '2025-11-21 07:00:31', '2025-11-21 07:00:31', '2025-11-21 07:00:31'),
(44, 2, 'teknisi@gmail.com', '127.0.0.1', '2025-11-26 08:43:38', '2025-11-26 08:43:39', '2025-11-26 08:43:39', '2025-11-26 08:43:39'),
(45, 4, 'abisma410@gmail.com', '127.0.0.1', '2025-11-26 08:45:18', '2025-11-26 08:45:18', '2025-11-26 08:45:18', '2025-11-26 08:45:18'),
(46, 1, 'admin1@gmail.com', '127.0.0.1', '2025-12-02 11:28:48', '2025-12-02 11:28:48', '2025-12-02 11:28:48', '2025-12-02 11:28:48'),
(47, 4, 'abisma410@gmail.com', '127.0.0.1', '2025-12-03 02:40:15', '2025-12-03 02:40:15', '2025-12-03 02:40:15', '2025-12-03 02:40:15'),
(48, 1, 'admin1@gmail.com', '127.0.0.1', '2025-12-03 02:43:08', '2025-12-03 02:43:08', '2025-12-03 02:43:08', '2025-12-03 02:43:08'),
(49, 4, 'abisma410@gmail.com', '127.0.0.1', '2025-12-03 02:47:15', '2025-12-03 02:47:15', '2025-12-03 02:47:15', '2025-12-03 02:47:15'),
(50, 4, 'abisma410@gmail.com', '127.0.0.1', '2025-12-03 02:56:21', '2025-12-03 02:56:21', '2025-12-03 02:56:21', '2025-12-03 02:56:21'),
(51, 4, 'abisma410@gmail.com', '127.0.0.1', '2025-12-03 04:19:48', '2025-12-03 04:19:48', '2025-12-03 04:19:48', '2025-12-03 04:19:48'),
(52, 1, 'admin1@gmail.com', '127.0.0.1', '2025-12-03 04:20:26', '2025-12-03 04:20:26', '2025-12-03 04:20:26', '2025-12-03 04:20:26'),
(53, 2, 'teknisi@gmail.com', '127.0.0.1', '2025-12-03 04:21:58', '2025-12-03 04:21:58', '2025-12-03 04:21:58', '2025-12-03 04:21:58'),
(54, 1, 'admin1@gmail.com', '127.0.0.1', '2025-12-03 04:28:10', '2025-12-03 04:28:10', '2025-12-03 04:28:10', '2025-12-03 04:28:10'),
(55, 2, 'teknisi@gmail.com', '127.0.0.1', '2025-12-03 04:28:36', '2025-12-03 04:28:36', '2025-12-03 04:28:36', '2025-12-03 04:28:36'),
(56, 1, 'admin1@gmail.com', '127.0.0.1', '2025-12-03 04:35:12', '2025-12-03 04:35:12', '2025-12-03 04:35:12', '2025-12-03 04:35:12'),
(57, 2, 'teknisi@gmail.com', '127.0.0.1', '2025-12-03 05:04:03', '2025-12-03 05:04:03', '2025-12-03 05:04:03', '2025-12-03 05:04:03'),
(58, 1, 'admin1@gmail.com', '127.0.0.1', '2025-12-13 05:17:16', '2025-12-13 05:17:16', '2025-12-13 05:17:16', '2025-12-13 05:17:16'),
(59, 1, 'admin1@gmail.com', '127.0.0.1', '2025-12-13 05:26:37', '2025-12-13 05:26:37', '2025-12-13 05:26:37', '2025-12-13 05:26:37'),
(60, 1, 'admin1@gmail.com', '127.0.0.1', '2025-12-13 06:25:56', '2025-12-13 06:25:56', '2025-12-13 06:25:56', '2025-12-13 06:25:56'),
(61, 2, 'teknisi@gmail.com', '127.0.0.1', '2025-12-13 06:26:48', '2025-12-13 06:26:48', '2025-12-13 06:26:48', '2025-12-13 06:26:48'),
(62, 1, 'admin1@gmail.com', '127.0.0.1', '2025-12-13 09:55:06', '2025-12-13 09:55:06', '2025-12-13 09:55:06', '2025-12-13 09:55:06'),
(63, 2, 'teknisi@gmail.com', '127.0.0.1', '2025-12-13 09:55:55', '2025-12-13 09:55:55', '2025-12-13 09:55:55', '2025-12-13 09:55:55'),
(64, 1, 'admin1@gmail.com', '127.0.0.1', '2025-12-14 03:20:22', '2025-12-14 03:20:22', '2025-12-14 03:20:22', '2025-12-14 03:20:22'),
(65, 1, 'admin1@gmail.com', '127.0.0.1', '2025-12-21 07:56:30', '2025-12-21 07:56:30', '2025-12-21 07:56:30', '2025-12-21 07:56:30'),
(66, 2, 'teknisi@gmail.com', '127.0.0.1', '2025-12-21 07:56:57', '2025-12-21 07:56:57', '2025-12-21 07:56:57', '2025-12-21 07:56:57'),
(67, 1, 'admin1@gmail.com', '127.0.0.1', '2025-12-24 06:35:45', '2025-12-24 06:35:45', '2025-12-24 06:35:45', '2025-12-24 06:35:45'),
(68, 1, 'admin1@gmail.com', '127.0.0.1', '2025-12-24 06:39:05', '2025-12-24 06:39:05', '2025-12-24 06:39:05', '2025-12-24 06:39:05'),
(69, 2, 'teknisi@gmail.com', '127.0.0.1', '2025-12-24 06:39:31', '2025-12-24 06:39:31', '2025-12-24 06:39:31', '2025-12-24 06:39:31'),
(70, 1, 'admin1@gmail.com', '127.0.0.1', '2025-12-24 07:49:24', '2025-12-24 07:49:24', '2025-12-24 07:49:24', '2025-12-24 07:49:24'),
(71, 1, 'admin1@gmail.com', '127.0.0.1', '2025-12-24 08:00:31', '2025-12-24 08:00:31', '2025-12-24 08:00:31', '2025-12-24 08:00:31'),
(72, 4, 'abisma410@gmail.com', '127.0.0.1', '2025-12-24 08:00:56', '2025-12-24 08:00:56', '2025-12-24 08:00:56', '2025-12-24 08:00:56'),
(73, 1, 'admin1@gmail.com', '127.0.0.1', '2025-12-24 08:04:26', '2025-12-24 08:04:26', '2025-12-24 08:04:26', '2025-12-24 08:04:26'),
(74, 2, 'teknisi@gmail.com', '127.0.0.1', '2025-12-24 08:05:56', '2025-12-24 08:05:56', '2025-12-24 08:05:56', '2025-12-24 08:05:56'),
(75, 1, 'admin1@gmail.com', '127.0.0.1', '2025-12-24 08:06:54', '2025-12-24 08:06:54', '2025-12-24 08:06:54', '2025-12-24 08:06:54'),
(76, 1, 'admin1@gmail.com', '127.0.0.1', '2025-12-24 10:58:17', '2025-12-24 10:58:17', '2025-12-24 10:58:17', '2025-12-24 10:58:17'),
(77, 1, 'admin1@gmail.com', '127.0.0.1', '2025-12-24 11:13:10', '2025-12-24 11:13:10', '2025-12-24 11:13:10', '2025-12-24 11:13:10'),
(78, 2, 'teknisi@gmail.com', '127.0.0.1', '2025-12-24 11:14:56', '2025-12-24 11:14:56', '2025-12-24 11:14:56', '2025-12-24 11:14:56'),
(79, 1, 'admin1@gmail.com', '127.0.0.1', '2025-12-27 03:49:25', '2025-12-27 03:49:25', '2025-12-27 03:49:25', '2025-12-27 03:49:25'),
(80, 2, 'teknisi@gmail.com', '127.0.0.1', '2025-12-27 03:50:16', '2025-12-27 03:50:16', '2025-12-27 03:50:16', '2025-12-27 03:50:16'),
(81, 1, 'admin1@gmail.com', '127.0.0.1', '2025-12-27 05:41:47', '2025-12-27 05:41:47', '2025-12-27 05:41:47', '2025-12-27 05:41:47'),
(82, 2, 'teknisi@gmail.com', '127.0.0.1', '2025-12-27 05:42:35', '2025-12-27 05:42:35', '2025-12-27 05:42:35', '2025-12-27 05:42:35'),
(83, 1, 'admin1@gmail.com', '127.0.0.1', '2025-12-27 05:49:39', '2025-12-27 05:49:39', '2025-12-27 05:49:39', '2025-12-27 05:49:39'),
(84, 1, 'admin1@gmail.com', '127.0.0.1', '2025-12-27 06:00:26', '2025-12-27 06:00:26', '2025-12-27 06:00:26', '2025-12-27 06:00:26'),
(85, 2, 'teknisi@gmail.com', '127.0.0.1', '2025-12-27 06:01:18', '2025-12-27 06:01:18', '2025-12-27 06:01:18', '2025-12-27 06:01:18'),
(86, 1, 'admin1@gmail.com', '127.0.0.1', '2025-12-27 06:11:07', '2025-12-27 06:11:07', '2025-12-27 06:11:07', '2025-12-27 06:11:07'),
(87, 2, 'teknisi@gmail.com', '127.0.0.1', '2025-12-27 06:12:03', '2025-12-27 06:12:03', '2025-12-27 06:12:03', '2025-12-27 06:12:03'),
(88, 2, 'teknisi@gmail.com', '127.0.0.1', '2025-12-27 06:24:00', '2025-12-27 06:24:00', '2025-12-27 06:24:00', '2025-12-27 06:24:00'),
(89, 1, 'admin1@gmail.com', '127.0.0.1', '2025-12-27 06:32:22', '2025-12-27 06:32:22', '2025-12-27 06:32:22', '2025-12-27 06:32:22'),
(90, 2, 'teknisi@gmail.com', '127.0.0.1', '2025-12-27 06:32:51', '2025-12-27 06:32:51', '2025-12-27 06:32:51', '2025-12-27 06:32:51'),
(91, 1, 'admin1@gmail.com', '127.0.0.1', '2025-12-27 06:44:50', '2025-12-27 06:44:50', '2025-12-27 06:44:50', '2025-12-27 06:44:50'),
(92, 2, 'teknisi@gmail.com', '127.0.0.1', '2025-12-27 06:45:26', '2025-12-27 06:45:26', '2025-12-27 06:45:26', '2025-12-27 06:45:26'),
(93, 1, 'admin1@gmail.com', '127.0.0.1', '2025-12-27 06:48:55', '2025-12-27 06:48:55', '2025-12-27 06:48:55', '2025-12-27 06:48:55'),
(94, 2, 'teknisi@gmail.com', '127.0.0.1', '2025-12-27 06:49:29', '2025-12-27 06:49:29', '2025-12-27 06:49:29', '2025-12-27 06:49:29'),
(95, 2, 'teknisi@gmail.com', '127.0.0.1', '2025-12-27 07:02:33', '2025-12-27 07:02:33', '2025-12-27 07:02:33', '2025-12-27 07:02:33'),
(96, 1, 'admin1@gmail.com', '127.0.0.1', '2025-12-27 07:03:24', '2025-12-27 07:03:24', '2025-12-27 07:03:24', '2025-12-27 07:03:24'),
(97, 2, 'teknisi@gmail.com', '127.0.0.1', '2025-12-27 07:05:02', '2025-12-27 07:05:02', '2025-12-27 07:05:02', '2025-12-27 07:05:02'),
(98, 1, 'admin1@gmail.com', '127.0.0.1', '2025-12-27 07:05:38', '2025-12-27 07:05:39', '2025-12-27 07:05:39', '2025-12-27 07:05:39'),
(99, 1, 'admin1@gmail.com', '127.0.0.1', '2025-12-27 07:09:16', '2025-12-27 07:09:16', '2025-12-27 07:09:16', '2025-12-27 07:09:16'),
(100, 2, 'teknisi@gmail.com', '127.0.0.1', '2025-12-27 07:09:38', '2025-12-27 07:09:38', '2025-12-27 07:09:38', '2025-12-27 07:09:38'),
(101, 2, 'teknisi@gmail.com', '127.0.0.1', '2025-12-30 07:58:48', '2025-12-30 07:58:48', '2025-12-30 07:58:48', '2025-12-30 07:58:48'),
(102, 1, 'admin1@gmail.com', '127.0.0.1', '2025-12-30 16:30:39', '2025-12-30 16:30:39', '2025-12-30 16:30:39', '2025-12-30 16:30:39'),
(103, 1, 'admin1@gmail.com', '127.0.0.1', '2025-12-31 09:02:12', '2025-12-31 09:02:13', '2025-12-31 09:02:12', '2025-12-31 09:02:12'),
(104, 1, 'admin1@gmail.com', '127.0.0.1', '2026-01-05 02:54:00', '2026-01-05 02:54:00', '2026-01-05 02:54:00', '2026-01-05 02:54:00'),
(105, 1, 'admin1@gmail.com', '127.0.0.1', '2026-01-18 07:50:27', '2026-01-18 07:50:27', '2026-01-18 07:50:27', '2026-01-18 07:50:27'),
(106, 1, 'admin1@gmail.com', '127.0.0.1', '2026-01-30 02:37:39', '2026-01-30 02:37:39', '2026-01-30 02:37:39', '2026-01-30 02:37:39'),
(107, 1, 'admin@gmail.com', '127.0.0.1', '2026-01-30 03:26:45', '2026-01-30 03:26:45', '2026-01-30 03:26:45', '2026-01-30 03:26:45'),
(108, 4, 'abisma410@gmail.com', '127.0.0.1', '2026-01-30 03:30:17', '2026-01-30 03:30:17', '2026-01-30 03:30:17', '2026-01-30 03:30:17'),
(109, 1, 'admin@gmail.com', '127.0.0.1', '2026-01-30 04:09:53', '2026-01-30 04:09:53', '2026-01-30 04:09:53', '2026-01-30 04:09:53'),
(110, 1, 'admin@gmail.com', '127.0.0.1', '2026-01-30 07:45:10', '2026-01-30 07:45:10', '2026-01-30 07:45:10', '2026-01-30 07:45:10'),
(111, 1, 'admin@gmail.com', '127.0.0.1', '2026-01-30 08:05:15', '2026-01-30 08:05:15', '2026-01-30 08:05:15', '2026-01-30 08:05:15'),
(112, 2, 'teknisi@gmail.com', '127.0.0.1', '2026-01-30 08:05:47', '2026-01-30 08:05:47', '2026-01-30 08:05:47', '2026-01-30 08:05:47'),
(113, 1, 'admin@gmail.com', '127.0.0.1', '2026-01-30 08:19:25', '2026-01-30 08:19:25', '2026-01-30 08:19:25', '2026-01-30 08:19:25'),
(114, 1, 'admin@gmail.com', '127.0.0.1', '2026-01-30 16:49:32', '2026-01-30 16:49:32', '2026-01-30 16:49:32', '2026-01-30 16:49:32'),
(115, 2, 'teknisi@gmail.com', '127.0.0.1', '2026-01-30 16:50:59', '2026-01-30 16:50:59', '2026-01-30 16:50:59', '2026-01-30 16:50:59'),
(116, 1, 'admin@gmail.com', '127.0.0.1', '2026-02-01 03:49:02', '2026-02-01 03:49:02', '2026-02-01 03:49:02', '2026-02-01 03:49:02'),
(117, 2, 'teknisi@gmail.com', '127.0.0.1', '2026-02-01 03:49:19', '2026-02-01 03:49:19', '2026-02-01 03:49:19', '2026-02-01 03:49:19'),
(118, 1, 'admin@gmail.com', '127.0.0.1', '2026-02-01 04:03:09', '2026-02-01 04:03:09', '2026-02-01 04:03:09', '2026-02-01 04:03:09');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2025_09_29_033453_create_berita_acara_table', 1),
(4, '2025_10_22_145303_create_users_table', 1),
(5, '2025_11_07_065721_add_user_id_to_data_pelanggan_table', 1),
(6, '2025_11_11_074100_change_default_role_in_users_table', 2),
(7, '2025_11_12_063602_create_login_logs_table', 3),
(8, '2025_11_12_073650_add_alamat_and_no_hp_to_users_table', 4),
(9, '2025_11_12_121728_add_login_time_to_login_logs_table', 5),
(10, '2025_11_21_135418_create_berita_acara_table_with_wa_notif', 6),
(11, '2025_11_21_135802_add_wa_notif_sent_at_to_data_pelanggan_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'teknisi',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `alamat`, `no_hp`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@gmail.com', NULL, NULL, '$2y$12$i3adBvuSYe5aTlCs2CNJB.fUKaIMuJb5rZb3eQ0p5yLZPF1zUQiry', 'admin', NULL, '2025-11-08 09:06:00', '2026-01-30 03:26:05'),
(2, 'Teknisi Satu', 'teknisi@gmail.com', NULL, NULL, '$2y$12$LzPGzuwdvFWMhRwnGnYPjeSuP5TGs15qjpYiB0lcflJNsSXSxJKt2', 'teknisi', NULL, '2025-11-08 09:06:00', '2026-01-30 08:05:34'),
(3, 'User Biasa', 'user@example.com', NULL, NULL, '$2y$12$Ia46QYeRlxN636Zy4W2VhO0tBgofGN7QeucU16ie6bYg/TUuG8vpS', 'user', NULL, '2025-11-08 09:06:01', '2025-11-08 09:06:01'),
(4, 'Moh. Bisma Saiful Islam', 'abisma410@gmail.com', NULL, NULL, '$2y$12$lZvENz1e.IOYv/TMJhz0muqX5sqTthINtQF2OS8jjZTaEBz5j3xL.', 'teknisi', NULL, '2025-11-11 00:49:48', '2025-11-11 00:49:48'),
(6, 'Ananda', 'ananda@gmail.com', 'Bloro Barat', '082131252417', '$2y$12$tPmDpYM87c2uRaaT9PRfwOAA9agCayWojX4sTWOwtWw.IfRurrgvy', 'teknisi', NULL, '2025-11-12 00:42:07', '2025-11-12 00:42:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `berita_acara`
--
ALTER TABLE `berita_acara`
  ADD PRIMARY KEY (`id`),
  ADD KEY `berita_acara_user_id_foreign` (`user_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `data_pelanggan`
--
ALTER TABLE `data_pelanggan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `data_pelanggan_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_logs`
--
ALTER TABLE `login_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `login_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `berita_acara`
--
ALTER TABLE `berita_acara`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_pelanggan`
--
ALTER TABLE `data_pelanggan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login_logs`
--
ALTER TABLE `login_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `berita_acara`
--
ALTER TABLE `berita_acara`
  ADD CONSTRAINT `berita_acara_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `data_pelanggan`
--
ALTER TABLE `data_pelanggan`
  ADD CONSTRAINT `data_pelanggan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `login_logs`
--
ALTER TABLE `login_logs`
  ADD CONSTRAINT `login_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
