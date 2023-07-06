-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 13, 2020 at 07:23 PM
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
-- Database: `relo5_thesiriussolutionn`
--

-- --------------------------------------------------------

--
-- Table structure for table `item_dimensions`
--

CREATE TABLE `item_dimensions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `length` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `width` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `height` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_json` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `item_dimensions`
--

INSERT INTO `item_dimensions` (`id`, `name`, `length`, `width`, `height`, `category_json`, `created_at`, `updated_at`) VALUES
(1, 'Small boxshdkjas', '7866', '6767', '676786678', '[\"13\",\"15\",\"23\"]', NULL, NULL),
(2, 'hjhjk', '87', '89', '78', '[\"13\",\"23\",\"24\"]', NULL, NULL),
(3, 'jkmnnnnnnnn', '98', '776', '8909', '[\"15\",\"26\"]', NULL, NULL),
(4, 'Small boxsadjkasdh', '67', '67', '67', '[\"13\",\"15\",\"24\"]', NULL, NULL),
(5, 'Small asdhjkasdh', '872678667867', '677', '123', '[\"13\",\"15\",\"23\"]', NULL, NULL),
(6, 'Small boasdhsdkjx', '78', '76', '676', '[\"13\",\"15\",\"23\",\"24\",\"25\",\"26\",\"27\",\"28\",\"33\"]', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `item_dimensions`
--
ALTER TABLE `item_dimensions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `item_dimensions`
--
ALTER TABLE `item_dimensions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
