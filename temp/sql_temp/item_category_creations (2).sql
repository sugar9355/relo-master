-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2020 at 09:54 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `relo5`
--

-- --------------------------------------------------------

--
-- Table structure for table `item_category_creations`
--

CREATE TABLE `item_category_creations` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `item_category_creations`
--

INSERT INTO `item_category_creations` (`id`, `category_id`, `type`, `created_at`, `updated_at`) VALUES
(32, '13', '1', NULL, NULL),
(33, '15', '1', NULL, NULL),
(34, '23', '1', NULL, NULL),
(35, '24', '1', NULL, NULL),
(36, '25', '1', NULL, NULL),
(37, '26', '1', NULL, NULL),
(38, '13', '2', NULL, NULL),
(39, '15', '2', NULL, NULL),
(40, '23', '2', NULL, NULL),
(41, '24', '2', NULL, NULL),
(42, '25', '2', NULL, NULL),
(43, '26', '2', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `item_category_creations`
--
ALTER TABLE `item_category_creations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `item_category_creations`
--
ALTER TABLE `item_category_creations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
