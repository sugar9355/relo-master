-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2020 at 09:40 PM
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
-- Table structure for table `booking_notify`
--

CREATE TABLE `booking_notify` (
  `id` int(10) UNSIGNED NOT NULL,
  `booking_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fullname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile_no` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `booking_notify`
--

INSERT INTO `booking_notify` (`id`, `booking_id`, `fullname`, `mobile_no`, `email`, `status`, `created_at`, `updated_at`) VALUES
(1, '588', 'aman sharma', '09718368408', 'aman_sharma94@outlook.com', '1', NULL, NULL),
(2, '589', 'aman sharma', '09718368408', 'aammaan89@gmail.com', '1', NULL, NULL),
(3, '589', 'aman sharma', '09718368408', 'aammaan89@gmail.com', '1', NULL, NULL),
(4, '589', 'aman sharma', '09718368408', 'aammaan89@gmail.com', '1', NULL, NULL),
(5, '593', 'aman sharma', '9718368408', 'aammaan89@gmail.com', '1', NULL, NULL),
(6, '594', 'aman sharma', '09718368408', 'aman_sharma94@outlook.com', '1', NULL, NULL),
(7, '595', 'aman sharma', '9718368408', 'info@admin.com', '1', NULL, NULL),
(8, '596', 'aman sharma', '9718368408', 'info@admin.com', '0', NULL, NULL),
(9, '598', 'aman sharma', '09718368408', 'info@admin.com', '0', NULL, NULL),
(10, '600', 'aman sharma', '9718368408', 'info@admin.com', '0', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking_notify`
--
ALTER TABLE `booking_notify`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking_notify`
--
ALTER TABLE `booking_notify`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
