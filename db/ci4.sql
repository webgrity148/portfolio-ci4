-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 26, 2024 at 12:43 PM
-- Server version: 8.3.0
-- PHP Version: 8.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ci4`
--

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

DROP TABLE IF EXISTS `galleries`;
CREATE TABLE IF NOT EXISTS `galleries` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `meta_data`
--

DROP TABLE IF EXISTS `meta_data`;
CREATE TABLE IF NOT EXISTS `meta_data` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `meta_data`
--

INSERT INTO `meta_data` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'cv', 'dummy-1_6.pdf', '2024-12-23 01:32:34', '2024-12-23 03:48:57'),
(2, 'about', '<p><span class=\"custom-class text-danger\">A small river named Duden flows by their place and supplies it with the necessary regelialia.</span></p>\r\n<ul class=\"about-info mt-4 px-md-0 px-2\">\r\n<li>\r\n<pre>Name:</pre>\r\nClark Thompson</li>\r\n<li class=\"d-flex\"><strong>Date of birth:</strong>January 01, 1987</li>\r\n<li class=\"d-flex\"><strong>Address:</strong>San Francisco CA 97987 USA</li>\r\n<li class=\"d-flex\"><strong>Zip code:</strong>1000</li>\r\n<li class=\"d-flex\"><strong>Email:</strong>clarkthomp@gmail.com</li>\r\n<li class=\"d-flex\"><strong>Phone:</strong>+1-2234-5678-9-0</li>\r\n</ul>', '2024-12-23 04:19:47', '2024-12-23 05:04:59');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `version` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `namespace` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `time` int NOT NULL,
  `batch` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(2, '2024-12-19-095040', 'App\\Database\\Migrations\\CreateUsersTable', 'default', 'App', 1734602211, 1),
(4, '2024-12-23-063802', 'App\\Database\\Migrations\\MetaDataTable', 'default', 'App', 1734936239, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `profile_img` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `profile_img`, `email`, `password`, `remember_token`, `reset_token`, `reset_token_expiry`, `created_at`, `deleted_at`, `updated_at`) VALUES
(1, 'admin', 'https://lh3.googleusercontent.com/a/ACg8ocIm_EUFY66_MfPg60SE0aACYuEkSZ722p7Tqu6y2OVabkZ1LMg=s96-c', 'webgrity148@gmail.com', '$2y$10$y1Bp7zZHR2RMNeR8CHgHeeMHZvilMXsBg7/qs4BgMUM0weCfB7Ani', '702d834d8fd50deac3bc4157f9991306', NULL, NULL, NULL, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
