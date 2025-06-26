-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 25, 2025 at 07:51 AM
-- Server version: 9.1.0
-- PHP Version: 8.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kasboom`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'course',
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `count` int NOT NULL DEFAULT '1',
  `status` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `slug`, `type`, `icon`, `image`, `count`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'صنایع دستی', 'crafts', 'course', NULL, 'crafts.png', 1, 1, '2025-06-22 16:00:45', '2025-06-22 16:00:45', '2025-06-22 16:00:45'),
(2, 'مد و پوشاک', 'fashions', 'course', NULL, 'fashions.png', 1, 1, '2025-06-22 16:01:04', '2025-06-22 16:01:04', '2025-06-22 16:01:04'),
(3, 'صنایع غذایی و کشاورزی', 'culinary', 'course', NULL, 'culinary.png', 1, 1, '2025-06-22 16:01:44', '2025-06-22 16:01:44', '2025-06-22 16:01:44'),
(4, 'طراحی و هنر', 'illustration', 'course', NULL, 'illustration.png', 1, 1, '2025-06-22 16:02:34', '2025-06-22 16:02:34', '2025-06-22 16:02:34'),
(5, 'دام و طیور', 'animal-poultry', 'course', NULL, 'animal-poultry.png', 1, 1, '2025-06-22 16:18:19', '2025-06-22 16:18:19', '2025-06-22 16:18:19'),
(6, 'فناوری اطلاعات', 'information-technology', 'course', NULL, 'information-technology.png', 1, 1, '2025-06-22 16:18:58', '2025-06-22 16:18:58', '2025-06-22 16:18:58'),
(7, 'فروش و بازاریابی', 'marketing', 'course', NULL, 'marketing.png', 1, 1, '2025-06-22 16:19:15', '2025-06-22 16:19:15', '2025-06-22 16:19:15'),
(9, 'هوش مصنوعی', 'artificial-intelligence', 'course', NULL, 'artificial-intelligence.png', 1, 1, '2025-06-22 16:20:24', '2025-06-22 16:20:24', '2025-06-22 16:20:24'),
(10, 'کسب و کار', 'business', 'course', NULL, 'business.png', 1, 1, '2025-06-22 16:21:09', '2025-06-22 16:21:09', '2025-06-22 16:21:09'),
(11, 'فنی و خدماتی', 'technician', 'course', NULL, 'technician.png', 1, 1, '2025-06-22 16:34:39', '2025-06-22 16:34:39', '2025-06-22 16:34:39');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
