-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2020 at 09:17 AM
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
-- Table structure for table `msgs`
--

CREATE TABLE `msgs` (
  `id` int(10) UNSIGNED NOT NULL,
  `booking_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone_number` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `message` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `count_msg` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `createdat` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedat` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `msgs`
--

INSERT INTO `msgs` (`id`, `booking_id`, `full_name`, `phone_number`, `message`, `count_msg`, `createdat`, `updatedat`, `created_at`, `updated_at`) VALUES
(1, '51', 'aman sharma', '+919718368408', 'kjaslkdjaskdjkljsakld', '0', '2020-07-05 13:39:59', '2020-07-06 05:17:16', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `msgs`
--
ALTER TABLE `msgs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `msgs_booking_id_unique` (`booking_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `msgs`
--
ALTER TABLE `msgs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
