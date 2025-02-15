-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 15, 2025 at 03:00 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `apotek`
--

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_10_31_082414_create_m_tax_table', 1),
(5, '2024_10_31_082530_create_m_unit_table', 1),
(6, '2024_10_31_082633_create_m_payment_type_table', 1),
(7, '2024_11_01_082633_create_m_supplier_table', 1),
(8, '2024_11_18_041038_add_role_and_soft_delete_to_users_table', 1),
(9, '2024_11_25_015110_create_m_doctor_table', 1),
(10, '2024_11_25_015628_create_m_customer_table', 1),
(11, '2024_12_03_035413_create_m_category_product_table', 1),
(20, '2024_12_27_100203_create_m_purchase_order_table', 3),
(22, '2024_12_04_023358_create_m_product_table', 4),
(23, '2024_12_25_102130_create_m_product_unit_conversion_table', 4),
(25, '2024_12_30_050436_create_m_product_purchase_order_table', 5),
(26, '2025_01_23_032902_create_m_recipe_table', 6),
(27, '2025_01_23_034636_create_m_product_recipe_table', 6),
(30, '2025_01_29_040337_create_m_transaction_table', 7),
(31, '2025_01_29_040341_create_m_product_transaction_table', 7),
(32, '2025_02_05_025955_create_m_return_table', 8),
(33, '2025_02_05_030022_create_m_product_return_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `m_payment_type`
--

CREATE TABLE `m_payment_type` (
  `id` bigint UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `account_bank` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_bank` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_payment_type`
--

INSERT INTO `m_payment_type` (`id`, `deleted_at`, `created_at`, `updated_at`, `name`, `description`, `account_bank`, `name_bank`, `is_active`) VALUES
(1, NULL, '2024-12-25 09:05:49', '2024-12-25 09:05:59', 'Transfer Mandiri', 'Transfer Mandiri A.N. 123812983712', '123812983712', 'PT. Apotek Sami', 1),
(2, NULL, '2025-02-15 07:31:20', '2025-02-15 07:31:20', 'Tunai', 'Pembayaran tunai', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `m_product`
--

CREATE TABLE `m_product` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('Obat','Alat Kesehatan','Umum','Lain-Lain') COLLATE utf8mb4_unicode_ci NOT NULL,
  `drug_group` enum('Obat Bebas','Obat Bebas Terbatas','Obat Keras','Obat Golongan Narkotika','Obat Fitofarmaka','Obat Herbal Terstandar (OHT)','Obat Herbal (Jamu)') COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `minimum_smallest_stock` int NOT NULL DEFAULT '0',
  `smallest_stock` decimal(12,2) NOT NULL DEFAULT '0.00',
  `largest_stock` decimal(12,2) NOT NULL DEFAULT '0.00',
  `largest_unit` bigint UNSIGNED NOT NULL,
  `smallest_unit` bigint UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `supplier_id` bigint UNSIGNED NOT NULL,
  `conversion_value` int NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `purchase_price` decimal(12,2) NOT NULL,
  `selling_price` decimal(12,2) NOT NULL,
  `margin_percentage` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_product`
--

INSERT INTO `m_product` (`id`, `created_at`, `updated_at`, `deleted_at`, `name`, `type`, `drug_group`, `sku`, `minimum_smallest_stock`, `smallest_stock`, `largest_stock`, `largest_unit`, `smallest_unit`, `is_active`, `supplier_id`, `conversion_value`, `description`, `purchase_price`, `selling_price`, `margin_percentage`) VALUES
(93, '2025-01-31 02:13:57', '2025-02-14 05:11:04', NULL, '(0) Testing Product', 'Obat', 'Obat Bebas', 'SKU-0', 10, 180.00, 18.00, 1, 2, 1, 1, 10, 'Description 0', 10000.00, 15000.00, 33.33),
(94, '2025-01-31 02:13:57', '2025-02-14 05:17:35', NULL, 'HANSAPLAST KAIN ELASTIS STANDAR 100 PCS', 'Obat', 'Obat Bebas', 'SKU-1', 10, 6.00, 0.60, 1, 2, 1, 1, 10, 'Description 1', 10000.00, 15000.00, 33.33),
(95, '2025-01-31 02:13:57', '2025-02-15 14:58:31', NULL, '(2) Testing Product', 'Obat', 'Obat Bebas', 'SKU-2', 10, 70.00, 7.00, 4, 2, 1, 1, 10, 'Description 2', 9000.00, 10000.00, 10.00),
(96, '2025-01-31 02:13:58', '2025-02-04 23:13:54', NULL, '(3) Testing Product', 'Obat', 'Obat Bebas', 'SKU-3', 10, 8.00, 0.80, 4, 3, 1, 1, 10, 'Description 3', 50000.00, 55000.00, 9.09),
(97, '2025-01-31 02:13:58', '2025-02-06 09:01:06', NULL, '(4) Testing Product', 'Obat', 'Obat Bebas', 'SKU-4', 10, 97.00, 9.70, 1, 2, 1, 1, 10, 'Description 4', 10000.00, 15000.00, 33.33),
(98, '2025-01-31 02:13:58', '2025-01-31 02:13:58', NULL, '(5) Testing Product', 'Obat', 'Obat Bebas', 'SKU-5', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 5', 10000.00, 15000.00, 33.33),
(99, '2025-01-31 02:13:58', '2025-01-31 02:13:58', NULL, '(6) Testing Product', 'Obat', 'Obat Bebas', 'SKU-6', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 6', 10000.00, 15000.00, 33.33),
(100, '2025-01-31 02:13:59', '2025-01-31 02:13:59', NULL, '(7) Testing Product', 'Obat', 'Obat Bebas', 'SKU-7', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 7', 10000.00, 15000.00, 33.33),
(101, '2025-01-31 02:14:00', '2025-01-31 02:14:00', NULL, '(8) Testing Product', 'Obat', 'Obat Bebas', 'SKU-8', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 8', 10000.00, 15000.00, 33.33),
(102, '2025-01-31 02:14:01', '2025-01-31 02:14:01', NULL, '(9) Testing Product', 'Obat', 'Obat Bebas', 'SKU-9', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 9', 10000.00, 15000.00, 33.33),
(103, '2025-01-31 02:14:01', '2025-01-31 02:14:01', NULL, '(10) Testing Product', 'Obat', 'Obat Bebas', 'SKU-10', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 10', 10000.00, 15000.00, 33.33),
(104, '2025-01-31 02:14:02', '2025-01-31 02:14:02', NULL, '(11) Testing Product', 'Obat', 'Obat Bebas', 'SKU-11', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 11', 10000.00, 15000.00, 33.33),
(105, '2025-01-31 02:14:02', '2025-01-31 02:14:02', NULL, '(12) Testing Product', 'Obat', 'Obat Bebas', 'SKU-12', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 12', 10000.00, 15000.00, 33.33),
(106, '2025-01-31 02:14:03', '2025-01-31 02:14:03', NULL, '(13) Testing Product', 'Obat', 'Obat Bebas', 'SKU-13', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 13', 10000.00, 15000.00, 33.33),
(107, '2025-01-31 02:14:03', '2025-01-31 02:14:03', NULL, '(14) Testing Product', 'Obat', 'Obat Bebas', 'SKU-14', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 14', 10000.00, 15000.00, 33.33),
(108, '2025-01-31 02:14:04', '2025-01-31 02:14:04', NULL, '(15) Testing Product', 'Obat', 'Obat Bebas', 'SKU-15', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 15', 10000.00, 15000.00, 33.33),
(109, '2025-01-31 02:14:04', '2025-01-31 02:14:04', NULL, '(16) Testing Product', 'Obat', 'Obat Bebas', 'SKU-16', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 16', 10000.00, 15000.00, 33.33),
(110, '2025-01-31 02:14:05', '2025-01-31 02:14:05', NULL, '(17) Testing Product', 'Obat', 'Obat Bebas', 'SKU-17', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 17', 10000.00, 15000.00, 33.33),
(111, '2025-01-31 02:14:06', '2025-01-31 02:14:06', NULL, '(18) Testing Product', 'Obat', 'Obat Bebas', 'SKU-18', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 18', 10000.00, 15000.00, 33.33),
(112, '2025-01-31 02:14:06', '2025-01-31 02:14:06', NULL, '(19) Testing Product', 'Obat', 'Obat Bebas', 'SKU-19', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 19', 10000.00, 15000.00, 33.33),
(113, '2025-01-31 02:14:07', '2025-01-31 02:14:07', NULL, '(20) Testing Product', 'Obat', 'Obat Bebas', 'SKU-20', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 20', 10000.00, 15000.00, 33.33),
(114, '2025-01-31 02:14:07', '2025-01-31 02:14:07', NULL, '(21) Testing Product', 'Obat', 'Obat Bebas', 'SKU-21', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 21', 10000.00, 15000.00, 33.33),
(115, '2025-01-31 02:14:08', '2025-01-31 02:14:08', NULL, '(22) Testing Product', 'Obat', 'Obat Bebas', 'SKU-22', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 22', 10000.00, 15000.00, 33.33),
(116, '2025-01-31 02:14:09', '2025-01-31 02:14:09', NULL, '(23) Testing Product', 'Obat', 'Obat Bebas', 'SKU-23', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 23', 10000.00, 15000.00, 33.33),
(117, '2025-01-31 02:14:09', '2025-01-31 02:14:09', NULL, '(24) Testing Product', 'Obat', 'Obat Bebas', 'SKU-24', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 24', 10000.00, 15000.00, 33.33),
(118, '2025-01-31 02:14:09', '2025-01-31 02:14:09', NULL, '(25) Testing Product', 'Obat', 'Obat Bebas', 'SKU-25', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 25', 10000.00, 15000.00, 33.33),
(119, '2025-01-31 02:14:10', '2025-01-31 02:14:10', NULL, '(26) Testing Product', 'Obat', 'Obat Bebas', 'SKU-26', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 26', 10000.00, 15000.00, 33.33),
(120, '2025-01-31 02:14:10', '2025-01-31 02:14:10', NULL, '(27) Testing Product', 'Obat', 'Obat Bebas', 'SKU-27', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 27', 10000.00, 15000.00, 33.33),
(121, '2025-01-31 02:14:11', '2025-01-31 02:14:11', NULL, '(28) Testing Product', 'Obat', 'Obat Bebas', 'SKU-28', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 28', 10000.00, 15000.00, 33.33),
(122, '2025-01-31 02:14:12', '2025-01-31 02:14:12', NULL, '(29) Testing Product', 'Obat', 'Obat Bebas', 'SKU-29', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 29', 10000.00, 15000.00, 33.33),
(123, '2025-01-31 02:14:12', '2025-01-31 02:14:12', NULL, '(30) Testing Product', 'Obat', 'Obat Bebas', 'SKU-30', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 30', 10000.00, 15000.00, 33.33),
(124, '2025-01-31 02:14:13', '2025-01-31 02:14:13', NULL, '(31) Testing Product', 'Obat', 'Obat Bebas', 'SKU-31', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 31', 10000.00, 15000.00, 33.33),
(125, '2025-01-31 02:14:13', '2025-01-31 02:14:13', NULL, '(32) Testing Product', 'Obat', 'Obat Bebas', 'SKU-32', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 32', 10000.00, 15000.00, 33.33),
(126, '2025-01-31 02:14:14', '2025-01-31 02:14:14', NULL, '(33) Testing Product', 'Obat', 'Obat Bebas', 'SKU-33', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 33', 10000.00, 15000.00, 33.33),
(127, '2025-01-31 02:14:14', '2025-01-31 02:14:14', NULL, '(34) Testing Product', 'Obat', 'Obat Bebas', 'SKU-34', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 34', 10000.00, 15000.00, 33.33),
(128, '2025-01-31 02:14:15', '2025-01-31 02:14:15', NULL, '(35) Testing Product', 'Obat', 'Obat Bebas', 'SKU-35', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 35', 10000.00, 15000.00, 33.33),
(129, '2025-01-31 02:14:16', '2025-01-31 02:14:16', NULL, '(36) Testing Product', 'Obat', 'Obat Bebas', 'SKU-36', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 36', 10000.00, 15000.00, 33.33),
(130, '2025-01-31 02:14:16', '2025-01-31 02:14:16', NULL, '(37) Testing Product', 'Obat', 'Obat Bebas', 'SKU-37', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 37', 10000.00, 15000.00, 33.33),
(131, '2025-01-31 02:14:17', '2025-01-31 02:14:17', NULL, '(38) Testing Product', 'Obat', 'Obat Bebas', 'SKU-38', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 38', 10000.00, 15000.00, 33.33),
(132, '2025-01-31 02:14:18', '2025-01-31 02:14:18', NULL, '(39) Testing Product', 'Obat', 'Obat Bebas', 'SKU-39', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 39', 10000.00, 15000.00, 33.33),
(133, '2025-01-31 02:14:18', '2025-01-31 02:14:18', NULL, '(40) Testing Product', 'Obat', 'Obat Bebas', 'SKU-40', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 40', 10000.00, 15000.00, 33.33),
(134, '2025-01-31 02:14:19', '2025-01-31 02:14:19', NULL, '(41) Testing Product', 'Obat', 'Obat Bebas', 'SKU-41', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 41', 10000.00, 15000.00, 33.33),
(135, '2025-01-31 02:14:19', '2025-01-31 02:14:19', NULL, '(42) Testing Product', 'Obat', 'Obat Bebas', 'SKU-42', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 42', 10000.00, 15000.00, 33.33),
(136, '2025-01-31 02:14:20', '2025-01-31 02:14:20', NULL, '(43) Testing Product', 'Obat', 'Obat Bebas', 'SKU-43', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 43', 10000.00, 15000.00, 33.33),
(137, '2025-01-31 02:14:20', '2025-01-31 02:14:20', NULL, '(44) Testing Product', 'Obat', 'Obat Bebas', 'SKU-44', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 44', 10000.00, 15000.00, 33.33),
(138, '2025-01-31 02:14:20', '2025-01-31 02:14:20', NULL, '(45) Testing Product', 'Obat', 'Obat Bebas', 'SKU-45', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 45', 10000.00, 15000.00, 33.33),
(139, '2025-01-31 02:14:21', '2025-01-31 02:14:21', NULL, '(46) Testing Product', 'Obat', 'Obat Bebas', 'SKU-46', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 46', 10000.00, 15000.00, 33.33),
(140, '2025-01-31 02:14:21', '2025-01-31 02:14:21', NULL, '(47) Testing Product', 'Obat', 'Obat Bebas', 'SKU-47', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 47', 10000.00, 15000.00, 33.33),
(141, '2025-01-31 02:14:22', '2025-01-31 02:14:22', NULL, '(48) Testing Product', 'Obat', 'Obat Bebas', 'SKU-48', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 48', 10000.00, 15000.00, 33.33),
(142, '2025-01-31 02:14:22', '2025-01-31 02:14:22', NULL, '(49) Testing Product', 'Obat', 'Obat Bebas', 'SKU-49', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 49', 10000.00, 15000.00, 33.33),
(143, '2025-01-31 02:14:23', '2025-01-31 02:14:23', NULL, '(50) Testing Product', 'Obat', 'Obat Bebas', 'SKU-50', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 50', 10000.00, 15000.00, 33.33),
(144, '2025-01-31 02:14:23', '2025-01-31 02:14:23', NULL, '(51) Testing Product', 'Obat', 'Obat Bebas', 'SKU-51', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 51', 10000.00, 15000.00, 33.33),
(145, '2025-01-31 02:14:23', '2025-01-31 02:14:23', NULL, '(52) Testing Product', 'Obat', 'Obat Bebas', 'SKU-52', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 52', 10000.00, 15000.00, 33.33),
(146, '2025-01-31 02:14:24', '2025-01-31 02:14:24', NULL, '(53) Testing Product', 'Obat', 'Obat Bebas', 'SKU-53', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 53', 10000.00, 15000.00, 33.33),
(147, '2025-01-31 02:14:24', '2025-01-31 02:14:24', NULL, '(54) Testing Product', 'Obat', 'Obat Bebas', 'SKU-54', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 54', 10000.00, 15000.00, 33.33),
(148, '2025-01-31 02:14:24', '2025-01-31 02:14:24', NULL, '(55) Testing Product', 'Obat', 'Obat Bebas', 'SKU-55', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 55', 10000.00, 15000.00, 33.33),
(149, '2025-01-31 02:14:25', '2025-01-31 02:14:25', NULL, '(56) Testing Product', 'Obat', 'Obat Bebas', 'SKU-56', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 56', 10000.00, 15000.00, 33.33),
(150, '2025-01-31 02:14:25', '2025-01-31 02:14:25', NULL, '(57) Testing Product', 'Obat', 'Obat Bebas', 'SKU-57', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 57', 10000.00, 15000.00, 33.33),
(151, '2025-01-31 02:14:25', '2025-01-31 02:14:25', NULL, '(58) Testing Product', 'Obat', 'Obat Bebas', 'SKU-58', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 58', 10000.00, 15000.00, 33.33),
(152, '2025-01-31 02:14:26', '2025-01-31 02:14:26', NULL, '(59) Testing Product', 'Obat', 'Obat Bebas', 'SKU-59', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 59', 10000.00, 15000.00, 33.33),
(153, '2025-01-31 02:14:26', '2025-01-31 02:14:26', NULL, '(60) Testing Product', 'Obat', 'Obat Bebas', 'SKU-60', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 60', 10000.00, 15000.00, 33.33),
(154, '2025-01-31 02:14:27', '2025-01-31 02:14:27', NULL, '(61) Testing Product', 'Obat', 'Obat Bebas', 'SKU-61', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 61', 10000.00, 15000.00, 33.33),
(155, '2025-01-31 02:14:27', '2025-01-31 02:14:27', NULL, '(62) Testing Product', 'Obat', 'Obat Bebas', 'SKU-62', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 62', 10000.00, 15000.00, 33.33),
(156, '2025-01-31 02:14:27', '2025-01-31 02:14:27', NULL, '(63) Testing Product', 'Obat', 'Obat Bebas', 'SKU-63', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 63', 10000.00, 15000.00, 33.33),
(157, '2025-01-31 02:14:27', '2025-01-31 02:14:27', NULL, '(64) Testing Product', 'Obat', 'Obat Bebas', 'SKU-64', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 64', 10000.00, 15000.00, 33.33),
(158, '2025-01-31 02:14:28', '2025-01-31 02:14:28', NULL, '(65) Testing Product', 'Obat', 'Obat Bebas', 'SKU-65', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 65', 10000.00, 15000.00, 33.33),
(159, '2025-01-31 02:14:29', '2025-01-31 02:14:29', NULL, '(66) Testing Product', 'Obat', 'Obat Bebas', 'SKU-66', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 66', 10000.00, 15000.00, 33.33),
(160, '2025-01-31 02:14:29', '2025-01-31 02:14:29', NULL, '(67) Testing Product', 'Obat', 'Obat Bebas', 'SKU-67', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 67', 10000.00, 15000.00, 33.33),
(161, '2025-01-31 02:14:30', '2025-01-31 02:14:30', NULL, '(68) Testing Product', 'Obat', 'Obat Bebas', 'SKU-68', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 68', 10000.00, 15000.00, 33.33),
(162, '2025-01-31 02:14:30', '2025-01-31 02:14:30', NULL, '(69) Testing Product', 'Obat', 'Obat Bebas', 'SKU-69', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 69', 10000.00, 15000.00, 33.33),
(163, '2025-01-31 02:14:31', '2025-01-31 02:14:31', NULL, '(70) Testing Product', 'Obat', 'Obat Bebas', 'SKU-70', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 70', 10000.00, 15000.00, 33.33),
(164, '2025-01-31 02:14:31', '2025-01-31 02:14:31', NULL, '(71) Testing Product', 'Obat', 'Obat Bebas', 'SKU-71', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 71', 10000.00, 15000.00, 33.33),
(165, '2025-01-31 02:14:32', '2025-01-31 02:14:32', NULL, '(72) Testing Product', 'Obat', 'Obat Bebas', 'SKU-72', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 72', 10000.00, 15000.00, 33.33),
(166, '2025-01-31 02:14:33', '2025-01-31 02:14:33', NULL, '(73) Testing Product', 'Obat', 'Obat Bebas', 'SKU-73', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 73', 10000.00, 15000.00, 33.33),
(167, '2025-01-31 02:14:33', '2025-01-31 02:14:33', NULL, '(74) Testing Product', 'Obat', 'Obat Bebas', 'SKU-74', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 74', 10000.00, 15000.00, 33.33),
(168, '2025-01-31 02:14:34', '2025-01-31 02:14:34', NULL, '(75) Testing Product', 'Obat', 'Obat Bebas', 'SKU-75', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 75', 10000.00, 15000.00, 33.33),
(169, '2025-01-31 02:14:34', '2025-01-31 02:14:34', NULL, '(76) Testing Product', 'Obat', 'Obat Bebas', 'SKU-76', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 76', 10000.00, 15000.00, 33.33),
(170, '2025-01-31 02:14:35', '2025-01-31 02:14:35', NULL, '(77) Testing Product', 'Obat', 'Obat Bebas', 'SKU-77', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 77', 10000.00, 15000.00, 33.33),
(171, '2025-01-31 02:14:35', '2025-01-31 02:14:35', NULL, '(78) Testing Product', 'Obat', 'Obat Bebas', 'SKU-78', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 78', 10000.00, 15000.00, 33.33),
(172, '2025-01-31 02:14:36', '2025-01-31 02:14:36', NULL, '(79) Testing Product', 'Obat', 'Obat Bebas', 'SKU-79', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 79', 10000.00, 15000.00, 33.33),
(173, '2025-01-31 02:14:36', '2025-01-31 02:14:36', NULL, '(80) Testing Product', 'Obat', 'Obat Bebas', 'SKU-80', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 80', 10000.00, 15000.00, 33.33),
(174, '2025-01-31 02:14:37', '2025-01-31 02:14:37', NULL, '(81) Testing Product', 'Obat', 'Obat Bebas', 'SKU-81', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 81', 10000.00, 15000.00, 33.33),
(175, '2025-01-31 02:14:37', '2025-01-31 02:14:37', NULL, '(82) Testing Product', 'Obat', 'Obat Bebas', 'SKU-82', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 82', 10000.00, 15000.00, 33.33),
(176, '2025-01-31 02:14:37', '2025-01-31 02:14:37', NULL, '(83) Testing Product', 'Obat', 'Obat Bebas', 'SKU-83', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 83', 10000.00, 15000.00, 33.33),
(177, '2025-01-31 02:14:38', '2025-01-31 02:14:38', NULL, '(84) Testing Product', 'Obat', 'Obat Bebas', 'SKU-84', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 84', 10000.00, 15000.00, 33.33),
(178, '2025-01-31 02:14:38', '2025-01-31 02:14:38', NULL, '(85) Testing Product', 'Obat', 'Obat Bebas', 'SKU-85', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 85', 10000.00, 15000.00, 33.33),
(179, '2025-01-31 02:14:38', '2025-01-31 02:14:38', NULL, '(86) Testing Product', 'Obat', 'Obat Bebas', 'SKU-86', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 86', 10000.00, 15000.00, 33.33),
(180, '2025-01-31 02:14:39', '2025-01-31 02:14:39', NULL, '(87) Testing Product', 'Obat', 'Obat Bebas', 'SKU-87', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 87', 10000.00, 15000.00, 33.33),
(181, '2025-01-31 02:14:39', '2025-01-31 02:14:39', NULL, '(88) Testing Product', 'Obat', 'Obat Bebas', 'SKU-88', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 88', 10000.00, 15000.00, 33.33),
(182, '2025-01-31 02:14:39', '2025-01-31 02:14:39', NULL, '(89) Testing Product', 'Obat', 'Obat Bebas', 'SKU-89', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 89', 10000.00, 15000.00, 33.33),
(183, '2025-01-31 02:14:39', '2025-01-31 02:14:39', NULL, '(90) Testing Product', 'Obat', 'Obat Bebas', 'SKU-90', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 90', 10000.00, 15000.00, 33.33),
(184, '2025-01-31 02:14:40', '2025-01-31 02:14:40', NULL, '(91) Testing Product', 'Obat', 'Obat Bebas', 'SKU-91', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 91', 10000.00, 15000.00, 33.33),
(185, '2025-01-31 02:14:40', '2025-01-31 02:14:40', NULL, '(92) Testing Product', 'Obat', 'Obat Bebas', 'SKU-92', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 92', 10000.00, 15000.00, 33.33),
(186, '2025-01-31 02:14:41', '2025-01-31 02:14:41', NULL, '(93) Testing Product', 'Obat', 'Obat Bebas', 'SKU-93', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 93', 10000.00, 15000.00, 33.33),
(187, '2025-01-31 02:14:41', '2025-01-31 02:14:41', NULL, '(94) Testing Product', 'Obat', 'Obat Bebas', 'SKU-94', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 94', 10000.00, 15000.00, 33.33),
(188, '2025-01-31 02:14:41', '2025-01-31 02:14:41', NULL, '(95) Testing Product', 'Obat', 'Obat Bebas', 'SKU-95', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 95', 10000.00, 15000.00, 33.33),
(189, '2025-01-31 02:14:42', '2025-01-31 02:14:42', NULL, '(96) Testing Product', 'Obat', 'Obat Bebas', 'SKU-96', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 96', 10000.00, 15000.00, 33.33),
(190, '2025-01-31 02:14:42', '2025-01-31 02:14:42', NULL, '(97) Testing Product', 'Obat', 'Obat Bebas', 'SKU-97', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 97', 10000.00, 15000.00, 33.33),
(191, '2025-01-31 02:14:42', '2025-01-31 02:14:42', NULL, '(98) Testing Product', 'Obat', 'Obat Bebas', 'SKU-98', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 98', 10000.00, 15000.00, 33.33),
(192, '2025-01-31 02:14:43', '2025-02-03 21:00:39', '2025-02-03 21:00:39', '(99) Testing Product', 'Obat', 'Obat Bebas', 'SKU-99', 10, 0.00, 0.00, 1, 2, 1, 1, 10, 'Description 99', 10000.00, 15000.00, 33.33);

-- --------------------------------------------------------

--
-- Table structure for table `m_product_purchase_order`
--

CREATE TABLE `m_product_purchase_order` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `purchase_order_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `unit_id` bigint UNSIGNED NOT NULL,
  `qty` int NOT NULL DEFAULT '0',
  `price` decimal(12,2) NOT NULL,
  `discount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `discount_type` enum('Percentage','Nominal') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Percentage',
  `subtotal` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_product_purchase_order`
--

INSERT INTO `m_product_purchase_order` (`id`, `created_at`, `updated_at`, `deleted_at`, `purchase_order_id`, `product_id`, `unit_id`, `qty`, `price`, `discount`, `discount_type`, `subtotal`) VALUES
(14, '2025-01-31 02:40:01', '2025-01-31 02:40:01', NULL, 12, 93, 1, 1, 10000.00, 0.00, 'Nominal', 10000.00),
(15, '2025-01-31 02:40:01', '2025-01-31 02:40:01', NULL, 12, 94, 2, 1, 1000.00, 0.00, 'Nominal', 1000.00),
(16, '2025-01-31 02:43:20', '2025-01-31 02:43:20', NULL, 13, 93, 1, 1, 10000.00, 0.00, 'Nominal', 10000.00),
(17, '2025-01-31 02:43:20', '2025-01-31 02:43:20', NULL, 13, 94, 2, 1, 1000.00, 0.00, 'Nominal', 1000.00),
(18, '2025-01-31 02:45:06', '2025-01-31 02:45:06', NULL, 14, 93, 1, 1, 10000.00, 0.00, 'Nominal', 10000.00),
(19, '2025-01-31 02:45:06', '2025-01-31 02:45:06', NULL, 14, 94, 2, 1, 1000.00, 0.00, 'Nominal', 1000.00),
(20, '2025-01-31 20:05:09', '2025-01-31 20:05:09', NULL, 15, 94, 2, 7, 1000.00, 0.00, 'Nominal', 7000.00),
(21, '2025-02-02 23:27:05', '2025-02-02 23:27:05', NULL, 16, 95, 1, 10, 10000.00, 0.00, 'Nominal', 100000.00),
(22, '2025-02-06 02:25:59', '2025-02-06 02:25:59', NULL, 17, 93, 1, 20, 10000.00, 0.00, 'Nominal', 200000.00),
(23, '2025-02-12 21:30:46', '2025-02-12 21:30:46', NULL, 18, 93, 1, 1, 10000.00, 0.00, 'Nominal', 10000.00),
(24, '2025-02-14 05:17:35', '2025-02-14 05:17:35', NULL, 19, 94, 2, 1, 1000.00, 0.00, 'Nominal', 1000.00);

-- --------------------------------------------------------

--
-- Table structure for table `m_product_recipe`
--

CREATE TABLE `m_product_recipe` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `recipe_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `unit_id` bigint UNSIGNED NOT NULL,
  `qty` int NOT NULL DEFAULT '0',
  `price` decimal(12,2) NOT NULL,
  `tuslah` decimal(12,2) NOT NULL DEFAULT '0.00',
  `discount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `discount_type` enum('Percentage','Nominal') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Percentage',
  `subtotal` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_product_recipe`
--

INSERT INTO `m_product_recipe` (`id`, `created_at`, `updated_at`, `deleted_at`, `recipe_id`, `product_id`, `unit_id`, `qty`, `price`, `tuslah`, `discount`, `discount_type`, `subtotal`) VALUES
(16, '2025-02-02 23:44:18', '2025-02-02 23:44:18', NULL, 27, 95, 1, 1, 15000.00, 2000.00, 0.00, 'Nominal', 17000.00),
(17, '2025-02-04 19:19:14', '2025-02-05 19:48:59', '2025-02-05 19:48:59', 28, 95, 2, 12, 1000.00, 0.00, 1000.00, 'Nominal', 11000.00),
(18, '2025-02-04 19:19:14', '2025-02-05 19:48:59', '2025-02-05 19:48:59', 28, 96, 3, 1, 5500.00, 0.00, 0.00, 'Nominal', 5500.00),
(19, '2025-02-04 19:19:14', '2025-02-05 19:48:59', '2025-02-05 19:48:59', 28, 94, 2, 1, 1500.00, 500.00, 0.00, 'Nominal', 2000.00),
(21, '2025-02-05 00:47:10', '2025-02-05 00:47:10', NULL, 30, 95, 4, 1, 10000.00, 2000.00, 500.00, 'Nominal', 11500.00),
(22, '2025-02-05 19:48:59', '2025-02-05 21:32:44', NULL, 28, 94, 2, 6, 1500.00, 500.00, 0.00, 'Nominal', 12000.00),
(23, '2025-02-05 19:48:59', '2025-02-05 21:32:44', NULL, 28, 95, 4, 2, 10000.00, 0.00, 1000.00, 'Nominal', 19000.00),
(24, '2025-02-05 19:48:59', '2025-02-05 21:17:07', '2025-02-05 21:17:07', 28, 96, 4, 10, 55000.00, 0.00, 0.00, 'Nominal', 550000.00),
(25, '2025-02-05 21:17:07', '2025-02-05 21:32:44', NULL, 28, 97, 1, 1, 15000.00, 0.00, 0.00, 'Nominal', 15000.00);

-- --------------------------------------------------------

--
-- Table structure for table `m_product_return`
--

CREATE TABLE `m_product_return` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `return_id` bigint UNSIGNED NOT NULL,
  `product_transaction_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `unit_id` bigint UNSIGNED NOT NULL,
  `qty_return` int NOT NULL DEFAULT '0',
  `subtotal_return` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_product_transaction`
--

CREATE TABLE `m_product_transaction` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `transaction_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `unit_id` bigint UNSIGNED NOT NULL,
  `qty` int NOT NULL DEFAULT '0',
  `price` decimal(12,2) NOT NULL,
  `tuslah` decimal(12,2) NOT NULL DEFAULT '0.00',
  `discount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `nominal_discount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `discount_type` enum('Percentage','Nominal') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Percentage',
  `subtotal` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_product_transaction`
--

INSERT INTO `m_product_transaction` (`id`, `created_at`, `updated_at`, `deleted_at`, `transaction_id`, `product_id`, `unit_id`, `qty`, `price`, `tuslah`, `discount`, `nominal_discount`, `discount_type`, `subtotal`) VALUES
(49, '2025-02-06 09:01:06', '2025-02-06 09:01:06', NULL, 34, 94, 2, 1, 1500.00, 500.00, 0.00, 0.00, 'Nominal', 2000.00),
(50, '2025-02-06 09:01:06', '2025-02-06 09:01:06', NULL, 34, 95, 2, 2, 1000.00, 0.00, 1000.00, 1000.00, 'Nominal', 1000.00),
(51, '2025-02-06 09:01:06', '2025-02-06 09:01:06', NULL, 34, 97, 2, 3, 1500.00, 0.00, 0.00, 0.00, 'Nominal', 4500.00),
(53, '2025-02-06 09:20:53', '2025-02-06 09:20:53', NULL, 36, 94, 2, 4, 1500.00, 0.00, 0.00, 0.00, 'Nominal', 6000.00),
(54, '2025-02-06 18:04:33', '2025-02-06 18:04:33', NULL, 37, 95, 4, 1, 15000.00, 2000.00, 0.00, 0.00, 'Nominal', 17000.00),
(55, '2025-02-06 18:07:12', '2025-02-06 18:07:12', NULL, 38, 93, 1, 1, 15000.00, 0.00, 0.00, 0.00, 'Nominal', 15000.00),
(56, '2025-02-12 21:29:32', '2025-02-12 21:29:32', NULL, 39, 95, 4, 1, 15000.00, 2000.00, 0.00, 0.00, 'Nominal', 17000.00),
(57, '2025-02-14 05:05:34', '2025-02-14 05:05:34', NULL, 40, 93, 1, 1, 15000.00, 0.00, 0.00, 0.00, 'Nominal', 15000.00),
(58, '2025-02-14 05:11:04', '2025-02-14 05:11:04', NULL, 41, 93, 1, 1, 15000.00, 0.00, 99.00, 99.00, 'Nominal', 14901.00),
(59, '2025-02-15 07:31:36', '2025-02-15 07:31:36', NULL, 42, 95, 4, 1, 15000.00, 2000.00, 0.00, 0.00, 'Nominal', 17000.00),
(60, '2025-02-15 07:44:58', '2025-02-15 07:44:58', NULL, 43, 95, 4, 1, 15000.00, 2000.00, 0.00, 0.00, 'Nominal', 17000.00),
(63, '2025-02-15 07:48:20', '2025-02-15 07:48:20', NULL, 46, 95, 4, 1, 15000.00, 2000.00, 0.00, 0.00, 'Nominal', 17000.00),
(64, '2025-02-15 14:53:04', '2025-02-15 14:53:04', NULL, 47, 95, 4, 1, 15000.00, 2000.00, 0.00, 0.00, 'Nominal', 17000.00),
(65, '2025-02-15 14:58:31', '2025-02-15 14:58:31', NULL, 48, 95, 4, 1, 15000.00, 2000.00, 0.00, 0.00, 'Nominal', 17000.00);

-- --------------------------------------------------------

--
-- Table structure for table `m_purchase_order`
--

CREATE TABLE `m_purchase_order` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_id` bigint UNSIGNED NOT NULL,
  `order_date` date NOT NULL,
  `delivery_date` date DEFAULT NULL,
  `payment_due_date` date NOT NULL,
  `tax_id` bigint UNSIGNED NOT NULL,
  `no_factur_supplier` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `payment_type_id` bigint UNSIGNED NOT NULL,
  `payment_term` enum('Tunai','1 Hari','7 Hari','14 Hari','21 Hari','30 Hari','45 Hari') COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_include_tax` tinyint(1) NOT NULL DEFAULT '0',
  `qty_total` int NOT NULL DEFAULT '0',
  `discount` decimal(12,2) NOT NULL,
  `discount_type` enum('Percentage','Nominal') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Percentage',
  `total_before_tax_discount` decimal(12,2) NOT NULL,
  `tax_total` decimal(12,2) NOT NULL,
  `discount_total` decimal(12,2) NOT NULL,
  `total` decimal(12,2) NOT NULL,
  `nominal_discount` decimal(12,2) NOT NULL,
  `payment_status` enum('Lunas','Belum Terbayar') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_purchase_order`
--

INSERT INTO `m_purchase_order` (`id`, `created_at`, `updated_at`, `deleted_at`, `code`, `supplier_id`, `order_date`, `delivery_date`, `payment_due_date`, `tax_id`, `no_factur_supplier`, `description`, `payment_type_id`, `payment_term`, `payment_include_tax`, `qty_total`, `discount`, `discount_type`, `total_before_tax_discount`, `tax_total`, `discount_total`, `total`, `nominal_discount`, `payment_status`) VALUES
(12, '2025-01-31 02:40:01', '2025-01-31 02:40:01', NULL, 'PO-20250131094000', 1, '2025-01-31', '2025-01-31', '2025-01-31', 1, 'FKTR-0001', 'TEST PENAMBAHAN PRODUK', 1, 'Tunai', 0, 2, 0.00, 'Nominal', 11000.00, 1210.00, 0.00, 12210.00, 0.00, 'Lunas'),
(13, '2025-01-31 02:43:20', '2025-01-31 02:43:59', NULL, 'PO-20250131094319', 1, '2025-01-30', '2025-01-30', '2025-01-31', 1, 'FKTR-0002', 'Test term pembayaran tidak tunai', 1, '1 Hari', 0, 2, 0.00, 'Nominal', 11000.00, 1210.00, 0.00, 12210.00, 0.00, 'Lunas'),
(14, '2025-01-31 02:45:06', '2025-01-31 02:49:25', NULL, 'PO-20250131094505', 1, '2025-01-29', '2025-01-30', '2025-02-05', 1, 'FKTR-0003', 'Tanggal pengantaran tidak sama dengan pemesanan', 1, '7 Hari', 0, 2, 0.00, 'Nominal', 11000.00, 1210.00, 0.00, 12210.00, 0.00, 'Lunas'),
(15, '2025-01-31 20:05:09', '2025-01-31 20:05:09', NULL, 'PO-20250201030509', 1, '2025-03-01', '2025-03-01', '2025-03-01', 1, 'FKTR-0004', 'Penambahan smallest stock agar largest stock menjadi 1', 1, 'Tunai', 0, 7, 0.00, 'Nominal', 7000.00, 770.00, 0.00, 7770.00, 0.00, 'Lunas'),
(16, '2025-02-02 23:27:05', '2025-02-02 23:27:05', NULL, 'PO-20250203062705', 1, '2025-02-03', '2025-02-03', '2025-02-03', 1, 'FKTR-0006', NULL, 1, 'Tunai', 1, 10, 0.00, 'Nominal', 90090.00, 9910.00, 0.00, 100000.00, 0.00, 'Lunas'),
(17, '2025-02-06 02:25:59', '2025-02-06 18:05:07', NULL, 'PO-20250206092558', 1, '2025-02-01', '2025-02-01', '2025-02-08', 1, 'FKTR-0006', 'TEST PO', 1, '7 Hari', 0, 20, 0.00, 'Nominal', 200000.00, 22000.00, 0.00, 222000.00, 0.00, 'Lunas'),
(18, '2025-02-12 21:30:46', '2025-02-12 21:30:46', NULL, 'PO-20250213043046', 1, '2025-02-13', '2025-02-13', '2025-02-20', 1, 'FKTR-00010', 'Test  mantappp', 1, '7 Hari', 0, 1, 0.00, 'Nominal', 10000.00, 1100.00, 0.00, 11100.00, 0.00, 'Belum Terbayar'),
(19, '2025-02-14 05:17:35', '2025-02-14 05:17:49', NULL, 'PO-20250214121734', 1, '2025-02-16', '2025-02-16', '2025-02-17', 1, NULL, NULL, 1, '1 Hari', 0, 1, 0.00, 'Nominal', 1000.00, 110.00, 0.00, 1110.00, 0.00, 'Lunas');

-- --------------------------------------------------------

--
-- Table structure for table `m_recipe`
--

CREATE TABLE `m_recipe` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `staff_id` bigint UNSIGNED NOT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_age` int NOT NULL,
  `customer_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `doctor_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `doctor_sip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_recipe`
--

INSERT INTO `m_recipe` (`id`, `created_at`, `updated_at`, `deleted_at`, `name`, `staff_id`, `customer_name`, `customer_age`, `customer_address`, `doctor_name`, `doctor_sip`) VALUES
(27, '2025-02-02 23:44:18', '2025-02-02 23:44:18', NULL, 'Flu', 1, 'Paimen', 20, 'Sleman', 'Dr. Suparmanto', 'SIP-0001'),
(28, '2025-02-04 19:19:14', '2025-02-04 19:19:14', NULL, 'Panas Dingin', 1, 'Tukinem', 20, 'Bagor', 'Dr. Sulistro', 'SIP-0002'),
(30, '2025-02-05 00:47:10', '2025-02-05 10:14:50', '2025-02-05 10:14:50', 'Pusing', 1, 'Supardi', 36, 'Solo', 'Dr. Sulistro', 'SIP-0003'),
(31, '2025-02-05 00:47:10', '2025-02-05 00:47:10', NULL, 'Pusing', 1, 'Supardi', 36, 'Solo', 'Dr. Sulistro', 'SIP-0003');

-- --------------------------------------------------------

--
-- Table structure for table `m_return`
--

CREATE TABLE `m_return` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `return_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_id` bigint UNSIGNED NOT NULL,
  `return_reason` text COLLATE utf8mb4_unicode_ci,
  `qty_total` int NOT NULL DEFAULT '0',
  `total_before_discount` decimal(12,2) NOT NULL,
  `total_return` decimal(12,2) NOT NULL,
  `created_by` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_supplier`
--

CREATE TABLE `m_supplier` (
  `id` bigint UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` enum('Pedagang Besar Farmasi','Apotek Lain','Toko Obat','Lain-Lain') COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `payment_type` bigint UNSIGNED NOT NULL,
  `payment_term` enum('Tunai','1 Hari','7 Hari','14 Hari','21 Hari','30 Hari','45 Hari') COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `address` text COLLATE utf8mb4_unicode_ci,
  `postal_code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_1` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_2` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_supplier`
--

INSERT INTO `m_supplier` (`id`, `deleted_at`, `created_at`, `updated_at`, `type`, `code`, `name`, `is_active`, `payment_type`, `payment_term`, `description`, `address`, `postal_code`, `phone_1`, `phone_2`, `email`) VALUES
(1, NULL, '2024-12-25 09:07:19', '2024-12-25 09:07:19', 'Pedagang Besar Farmasi', 'SPLR-0001', 'PT. BINTANG MAHIR SANTOSA', 1, 1, 'Tunai', 'SIPPP', 'Jl. Pegangsaan Timur, Jakarta Barat', NULL, '082190219021', '082190219021', 'bintang.sentosa@yopmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `m_tax`
--

CREATE TABLE `m_tax` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` decimal(5,2) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_tax`
--

INSERT INTO `m_tax` (`id`, `created_at`, `updated_at`, `deleted_at`, `name`, `rate`, `description`, `is_active`) VALUES
(1, '2024-12-25 09:02:13', '2025-01-06 01:35:59', NULL, 'PPN', 11.00, 'Pajak Pertambahan Nilai', 1);

-- --------------------------------------------------------

--
-- Table structure for table `m_transaction`
--

CREATE TABLE `m_transaction` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `customer_type` enum('Umum','Rutin','Karyawan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Umum',
  `recipe_id` bigint UNSIGNED DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `payment_type_id` bigint UNSIGNED NOT NULL,
  `status` enum('Terbayar','Proses','Tertunda','Retur') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Terbayar',
  `invoice_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `discount_type` enum('Percentage','Nominal') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Percentage',
  `nominal_discount` decimal(12,2) NOT NULL,
  `paid_amount` decimal(12,2) NOT NULL,
  `change_amount` decimal(12,2) NOT NULL,
  `total_amount` decimal(12,2) NOT NULL,
  `total_before_discount` decimal(12,2) NOT NULL,
  `created_by` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_transaction`
--

INSERT INTO `m_transaction` (`id`, `created_at`, `updated_at`, `deleted_at`, `customer_type`, `recipe_id`, `notes`, `payment_type_id`, `status`, `invoice_number`, `discount`, `discount_type`, `nominal_discount`, `paid_amount`, `change_amount`, `total_amount`, `total_before_discount`, `created_by`) VALUES
(34, '2025-02-05 09:01:06', '2025-02-06 09:01:06', NULL, 'Umum', 28, NULL, 1, 'Terbayar', 'ST-06022025001', 0.00, 'Nominal', 0.00, 10000.00, 2500.00, 7500.00, 7500.00, 1),
(36, '2025-02-06 09:20:53', '2025-02-06 09:20:53', NULL, 'Umum', NULL, NULL, 1, 'Terbayar', 'ST-06022025002', 0.00, 'Nominal', 0.00, 15000.00, 9000.00, 6000.00, 6000.00, 1),
(37, '2025-02-06 18:04:33', '2025-02-06 18:04:33', NULL, 'Umum', 27, NULL, 1, 'Terbayar', 'ST-07022025001', 0.00, 'Nominal', 0.00, 20000.00, 3000.00, 17000.00, 17000.00, 1),
(38, '2025-02-06 18:07:12', '2025-02-06 18:07:12', NULL, 'Umum', NULL, NULL, 1, 'Terbayar', 'ST-07022025002', 0.00, 'Nominal', 0.00, 15000.00, 0.00, 15000.00, 15000.00, 1),
(39, '2025-02-12 21:29:32', '2025-02-12 21:29:32', NULL, 'Umum', 27, NULL, 1, 'Terbayar', 'ST-13022025001', 0.00, 'Nominal', 0.00, 20000.00, 3000.00, 17000.00, 17000.00, 1),
(40, '2025-02-14 05:05:34', '2025-02-14 05:05:34', NULL, 'Rutin', NULL, NULL, 1, 'Terbayar', 'ST-14022025001', 0.00, 'Nominal', 0.00, 20000.00, 5000.00, 15000.00, 15000.00, 1),
(41, '2025-02-14 05:11:04', '2025-02-14 05:11:04', NULL, 'Umum', NULL, NULL, 1, 'Terbayar', 'ST-14022025002', 0.00, 'Nominal', 0.00, 20000.00, 5099.00, 14901.00, 14901.00, 1),
(42, '2025-02-15 07:31:36', '2025-02-15 07:31:36', NULL, 'Umum', 27, NULL, 2, 'Terbayar', 'ST-15022025001', 0.00, 'Nominal', 0.00, 20000.00, 3000.00, 17000.00, 17000.00, 1),
(43, '2025-02-15 07:44:58', '2025-02-15 07:44:58', NULL, 'Karyawan', 27, NULL, 2, 'Terbayar', 'ST-15022025002', 0.00, 'Nominal', 0.00, 20000.00, 3000.00, 17000.00, 17000.00, 1),
(46, '2025-02-15 07:48:20', '2025-02-15 07:48:20', NULL, 'Karyawan', 27, NULL, 2, 'Terbayar', 'ST-15022025003', 0.00, 'Nominal', 0.00, 20000.00, 3000.00, 17000.00, 17000.00, 1),
(47, '2025-02-15 14:53:04', '2025-02-15 14:53:04', NULL, 'Umum', 27, NULL, 2, 'Terbayar', 'ST-15022025004', 0.00, 'Nominal', 0.00, 20000.00, 3000.00, 17000.00, 17000.00, 1),
(48, '2025-02-15 14:58:31', '2025-02-15 14:58:31', NULL, 'Umum', 27, NULL, 1, 'Terbayar', 'ST-15022025005', 0.00, 'Nominal', 0.00, 20000.00, 3000.00, 17000.00, 17000.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `m_unit`
--

CREATE TABLE `m_unit` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `symbol` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_unit`
--

INSERT INTO `m_unit` (`id`, `created_at`, `updated_at`, `deleted_at`, `name`, `symbol`, `description`, `is_active`) VALUES
(1, '2024-12-25 09:05:00', '2024-12-25 09:05:00', NULL, 'Pieces', 'PCS', 'Pieces', 1),
(2, '2024-12-25 09:05:08', '2025-01-21 16:52:41', NULL, 'SACHET', 'SCHT', 'SACHET', 1),
(3, '2025-01-20 06:07:28', '2025-01-21 16:52:52', NULL, 'STRIP', 'STRP', 'STRIP', 1),
(4, '2025-01-20 06:07:37', '2025-01-20 06:07:37', NULL, 'BOX', 'BOX', 'BOX', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('smn2kX3daUyBBy6U1gqhe43MzxtVXHxITPW3MaAn', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiS1ZpNkl1NElZNnA3VEpHcEZncXhLcWhRVmtMd1ZPenlmQm5XVnUyTCI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI1OiJodHRwOi8vbG9jYWxob3N0OjgwMDAvcG9zIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1739631565);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` tinyint NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `deleted_at`) VALUES
(1, 'Admin', 'admin@gmail.com', NULL, '$2y$12$T9f6MOXEw2VzYIpgkHa0hOkNzlwUK5/gQgXrTWTbYPNaxiorYBAWO', NULL, '2024-12-25 09:02:13', '2024-12-25 09:02:13', 0, NULL),
(2, 'Kasir', 'kasir@gmail.com', NULL, '$2y$12$kpneU6RDkkgVVMEF8B2vEOrp67GlXieUdROHQnCe3E3mVN8dYioGy', NULL, '2024-12-25 09:02:29', '2024-12-25 09:02:29', 1, NULL);

--
-- Indexes for dumped tables
--

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_payment_type`
--
ALTER TABLE `m_payment_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `m_payment_type_name_unique` (`name`);

--
-- Indexes for table `m_product`
--
ALTER TABLE `m_product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `m_product_sku_unique` (`sku`),
  ADD KEY `m_product_supplier_id_foreign` (`supplier_id`),
  ADD KEY `m_product_largest_unit_foreign` (`largest_unit`),
  ADD KEY `m_product_smallest_unit_foreign` (`smallest_unit`);

--
-- Indexes for table `m_product_purchase_order`
--
ALTER TABLE `m_product_purchase_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `m_product_purchase_order_product_id_foreign` (`product_id`),
  ADD KEY `m_product_purchase_order_unit_id_foreign` (`unit_id`),
  ADD KEY `m_product_purchase_order_purchase_order_id_product_id_index` (`purchase_order_id`,`product_id`);

--
-- Indexes for table `m_product_recipe`
--
ALTER TABLE `m_product_recipe`
  ADD PRIMARY KEY (`id`),
  ADD KEY `m_product_recipe_product_id_foreign` (`product_id`),
  ADD KEY `m_product_recipe_unit_id_foreign` (`unit_id`),
  ADD KEY `m_product_recipe_recipe_id_product_id_unit_id_index` (`recipe_id`,`product_id`,`unit_id`);

--
-- Indexes for table `m_product_return`
--
ALTER TABLE `m_product_return`
  ADD PRIMARY KEY (`id`),
  ADD KEY `m_product_return_product_transaction_id_foreign` (`product_transaction_id`),
  ADD KEY `m_product_return_product_id_foreign` (`product_id`),
  ADD KEY `m_product_return_unit_id_foreign` (`unit_id`),
  ADD KEY `m_product_return_return_id_product_transaction_id_index` (`return_id`,`product_transaction_id`);

--
-- Indexes for table `m_product_transaction`
--
ALTER TABLE `m_product_transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `m_product_transaction_product_id_foreign` (`product_id`),
  ADD KEY `m_product_transaction_unit_id_foreign` (`unit_id`),
  ADD KEY `m_product_transaction_transaction_id_product_id_unit_id_index` (`transaction_id`,`product_id`,`unit_id`);

--
-- Indexes for table `m_purchase_order`
--
ALTER TABLE `m_purchase_order`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `m_purchase_order_code_unique` (`code`),
  ADD KEY `m_purchase_order_tax_id_foreign` (`tax_id`),
  ADD KEY `m_purchase_order_payment_type_id_foreign` (`payment_type_id`),
  ADD KEY `m_purchase_order_supplier_id_order_date_code_index` (`supplier_id`,`order_date`,`code`);

--
-- Indexes for table `m_recipe`
--
ALTER TABLE `m_recipe`
  ADD PRIMARY KEY (`id`),
  ADD KEY `m_recipe_staff_id_index` (`staff_id`);

--
-- Indexes for table `m_return`
--
ALTER TABLE `m_return`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `m_return_return_number_unique` (`return_number`),
  ADD KEY `m_return_created_by_foreign` (`created_by`),
  ADD KEY `m_return_transaction_id_index` (`transaction_id`);

--
-- Indexes for table `m_supplier`
--
ALTER TABLE `m_supplier`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `m_supplier_code_unique` (`code`),
  ADD KEY `m_supplier_payment_type_foreign` (`payment_type`);

--
-- Indexes for table `m_tax`
--
ALTER TABLE `m_tax`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_transaction`
--
ALTER TABLE `m_transaction`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `m_transaction_invoice_number_unique` (`invoice_number`),
  ADD KEY `m_transaction_recipe_id_foreign` (`recipe_id`),
  ADD KEY `m_transaction_payment_type_id_foreign` (`payment_type_id`),
  ADD KEY `m_transaction_created_by_foreign` (`created_by`);

--
-- Indexes for table `m_unit`
--
ALTER TABLE `m_unit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

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
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `m_payment_type`
--
ALTER TABLE `m_payment_type`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `m_product`
--
ALTER TABLE `m_product`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=193;

--
-- AUTO_INCREMENT for table `m_product_purchase_order`
--
ALTER TABLE `m_product_purchase_order`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `m_product_recipe`
--
ALTER TABLE `m_product_recipe`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `m_product_return`
--
ALTER TABLE `m_product_return`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `m_product_transaction`
--
ALTER TABLE `m_product_transaction`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `m_purchase_order`
--
ALTER TABLE `m_purchase_order`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `m_recipe`
--
ALTER TABLE `m_recipe`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `m_return`
--
ALTER TABLE `m_return`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `m_supplier`
--
ALTER TABLE `m_supplier`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `m_tax`
--
ALTER TABLE `m_tax`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `m_transaction`
--
ALTER TABLE `m_transaction`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `m_unit`
--
ALTER TABLE `m_unit`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `m_product`
--
ALTER TABLE `m_product`
  ADD CONSTRAINT `m_product_largest_unit_foreign` FOREIGN KEY (`largest_unit`) REFERENCES `m_unit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `m_product_smallest_unit_foreign` FOREIGN KEY (`smallest_unit`) REFERENCES `m_unit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `m_product_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `m_supplier` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `m_product_purchase_order`
--
ALTER TABLE `m_product_purchase_order`
  ADD CONSTRAINT `m_product_purchase_order_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `m_product` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `m_product_purchase_order_purchase_order_id_foreign` FOREIGN KEY (`purchase_order_id`) REFERENCES `m_purchase_order` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `m_product_purchase_order_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `m_unit` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `m_product_recipe`
--
ALTER TABLE `m_product_recipe`
  ADD CONSTRAINT `m_product_recipe_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `m_product` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `m_product_recipe_recipe_id_foreign` FOREIGN KEY (`recipe_id`) REFERENCES `m_recipe` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `m_product_recipe_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `m_unit` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `m_product_return`
--
ALTER TABLE `m_product_return`
  ADD CONSTRAINT `m_product_return_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `m_product` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `m_product_return_product_transaction_id_foreign` FOREIGN KEY (`product_transaction_id`) REFERENCES `m_product_transaction` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `m_product_return_return_id_foreign` FOREIGN KEY (`return_id`) REFERENCES `m_return` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `m_product_return_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `m_unit` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `m_product_transaction`
--
ALTER TABLE `m_product_transaction`
  ADD CONSTRAINT `m_product_transaction_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `m_product` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `m_product_transaction_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `m_transaction` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `m_product_transaction_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `m_unit` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `m_purchase_order`
--
ALTER TABLE `m_purchase_order`
  ADD CONSTRAINT `m_purchase_order_payment_type_id_foreign` FOREIGN KEY (`payment_type_id`) REFERENCES `m_payment_type` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `m_purchase_order_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `m_supplier` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `m_purchase_order_tax_id_foreign` FOREIGN KEY (`tax_id`) REFERENCES `m_tax` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `m_recipe`
--
ALTER TABLE `m_recipe`
  ADD CONSTRAINT `m_recipe_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `m_return`
--
ALTER TABLE `m_return`
  ADD CONSTRAINT `m_return_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `m_return_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `m_transaction` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `m_supplier`
--
ALTER TABLE `m_supplier`
  ADD CONSTRAINT `m_supplier_payment_type_foreign` FOREIGN KEY (`payment_type`) REFERENCES `m_payment_type` (`id`);

--
-- Constraints for table `m_transaction`
--
ALTER TABLE `m_transaction`
  ADD CONSTRAINT `m_transaction_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `m_transaction_payment_type_id_foreign` FOREIGN KEY (`payment_type_id`) REFERENCES `m_payment_type` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `m_transaction_recipe_id_foreign` FOREIGN KEY (`recipe_id`) REFERENCES `m_recipe` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
