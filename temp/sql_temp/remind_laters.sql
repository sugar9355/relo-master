-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 19, 2020 at 02:42 AM
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
-- Table structure for table `remind_laters`
--

CREATE TABLE `remind_laters` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `reminddate` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `booking_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `remind_laters`
--

INSERT INTO `remind_laters` (`id`, `email`, `reminddate`, `booking_id`, `created_at`, `updated_at`) VALUES
(1, 'aammaann89@gmail.com', '2020-07-30', '575', NULL, NULL),
(2, 'aammaann89@gmail.com', '2020-07-30', '577', NULL, NULL),
(3, 'aammaan89@gmail.com', '2020-07-30', '577', NULL, NULL),
(4, 'aammaan89@gmail.com', '2020-07-23', '580', NULL, NULL),
(5, 'aman_sharma94@outlook.com', '2020-07-23', '580', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `remind_laters`
--
ALTER TABLE `remind_laters`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `remind_laters`
--
ALTER TABLE `remind_laters`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
