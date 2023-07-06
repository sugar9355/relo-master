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
-- Table structure for table `inventories`
--

CREATE TABLE `inventories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `itemWighttype` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `itemdimensiontype` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meterial` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hoisting` int(1) DEFAULT 0,
  `category_id` int(10) DEFAULT NULL,
  `equipments` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `badges` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `storage_price` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `wrapping_material` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `wrapping_qty` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `wrapping_time` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `wrapping_price` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `weight_min` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `junk_price_min` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `weight_max` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `junk_price_max` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `width` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `height` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `breadth` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `volume` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `multiplier` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `packing_volume` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `R_A` int(10) NOT NULL DEFAULT 0,
  `R_B` int(10) NOT NULL DEFAULT 0,
  `R_C` int(10) NOT NULL DEFAULT 0,
  `R_D` int(10) NOT NULL DEFAULT 0,
  `R_E` int(10) NOT NULL DEFAULT 0,
  `ranking_id` int(1) DEFAULT NULL,
  `ranking_time` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stair_windy` varchar(255) COLLATE utf8_unicode_ci DEFAULT '1',
  `stair_narrow` varchar(255) COLLATE utf8_unicode_ci DEFAULT '1',
  `stair_wide` varchar(255) COLLATE utf8_unicode_ci DEFAULT '1',
  `stair_spiral` varchar(255) COLLATE utf8_unicode_ci DEFAULT '1',
  `elevator_passenger` varchar(255) COLLATE utf8_unicode_ci DEFAULT '1',
  `elevator_freight` varchar(255) COLLATE utf8_unicode_ci DEFAULT '1',
  `elevator_reserved_freight` varchar(255) COLLATE utf8_unicode_ci DEFAULT '1',
  `time_0_min` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time_0_med` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time_0_max` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time_1_min` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time_1_med` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time_1_max` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time_2_min` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time_2_med` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time_2_max` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time_3_min` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time_3_med` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time_3_max` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time_4_min` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time_4_med` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time_4_max` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time_5_min` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time_5_med` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time_5_max` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time_6_min` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time_6_med` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time_6_max` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_size` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `extension` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `flag` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `inventories`
--

INSERT INTO `inventories` (`id`, `name`, `itemWighttype`, `itemdimensiontype`, `meterial`, `hoisting`, `category_id`, `equipments`, `badges`, `storage_price`, `wrapping_material`, `wrapping_qty`, `wrapping_time`, `wrapping_price`, `weight_min`, `junk_price_min`, `weight_max`, `junk_price_max`, `width`, `height`, `breadth`, `volume`, `multiplier`, `packing_volume`, `R_A`, `R_B`, `R_C`, `R_D`, `R_E`, `ranking_id`, `ranking_time`, `stair_windy`, `stair_narrow`, `stair_wide`, `stair_spiral`, `elevator_passenger`, `elevator_freight`, `elevator_reserved_freight`, `time_0_min`, `time_0_med`, `time_0_max`, `time_1_min`, `time_1_med`, `time_1_max`, `time_2_min`, `time_2_med`, `time_2_max`, `time_3_min`, `time_3_med`, `time_3_max`, `time_4_min`, `time_4_med`, `time_4_max`, `time_5_min`, `time_5_med`, `time_5_max`, `time_6_min`, `time_6_med`, `time_6_max`, `image`, `file_name`, `file_size`, `file_path`, `file_type`, `extension`, `flag`, `created_at`, `updated_at`) VALUES
(3, 'Bed', NULL, NULL, '15', NULL, 14, '100,101', NULL, '0', NULL, '0', '0', '0', '12', '0', '0', '0', '1.5', '1.5', '1.5', '3.375', '2', '6.75', 1, 1, 1, 1, 1, NULL, NULL, '1', '1', '1', '1', '1.5', '1.5', '1.1', '0.5', '0.75', '1', '0.75', '1', '1.25', '1.25', '1.5', '1.75', '1.75', '2', '2.25', '2.25', '2.5', '2.75', '2.75', '3', '3.25', '3.25', '3.5', '3.75', 'default.png', 'download (4).jpg', '5420', '/uploads/inventory/3_download (4).jpg', 'image/jpeg', 'jpg', NULL, '2019-10-12 05:22:29', '2020-06-07 19:17:10'),
(4, 'Table', NULL, NULL, '19', NULL, 15, NULL, NULL, '0', NULL, '0', '0', '0', '10', '0', '0', '0', '10', '10', '10', '1000', '', '', 1, 1, 2, 3, 4, NULL, NULL, '2', '2', '2', '2', '2', '3', '2', '2', '2', '2', '1', '2', '2', '2', '2', '2', '2', '2', '2', '2', '2', '2', '2', '2', '2', '2', '2', '2', 'default.png', 'images.jpg', '4243', '/uploads/inventory/4_images.jpg', 'image/jpeg', 'jpg', 0, '2019-10-12 05:23:32', '2020-05-20 12:01:38'),
(10, 'Refrigerator', NULL, NULL, '15', 1, 15, '100,101,102', NULL, '0', NULL, '0', '0', '0', '10', '0', '0', '0', '12', '5', '74', '4440', '', '', 1, 2, 3, 4, 5, NULL, NULL, '1', '1', '1', '1', '1', '1', '1', '1', '2', '3', '1', '2', '3', '3', '4', '5', '5', '6', '7', '7', '8', '9', '9', '10', '11', '11', '12', '13', NULL, 'download (3).jpg', '3973', '/uploads/inventory/10_download (3).jpg', 'image/jpeg', 'jpg', 0, '2019-11-18 18:30:14', '2020-05-12 13:31:01'),
(11, 'Medium box', NULL, NULL, '15', NULL, 15, '100', NULL, '0', NULL, '0', '0', '0', '30', '0', '0', '0', '2', '1', '2', '4', '2', '8', 1, 1, 1, 1, 1, NULL, NULL, '1', '1', '1', '1', '1.2', '1.1', '1', '0.5', '0.75', '1', '0.75', '1', '1.25', '1', '1.25', '1.5', '1.25', '1.5', '1.75', '1.5', '1.75', '2', '1.75', '2', '2.25', '2', '2.25', '2.5', NULL, 'Medium Box.png', '14349', '/uploads/inventory/11_Medium Box.png', 'image/png', 'png', NULL, '2019-11-18 18:32:17', '2020-06-15 02:04:19'),
(12, 'Round Table', NULL, NULL, NULL, 0, NULL, NULL, NULL, '0', NULL, '0', '0', '0', '10', '0', '0', '0', '12', '5', '74', '4440', '', '', 1, 2, 3, 4, 5, NULL, NULL, '2', '2', '1', '1', '2', NULL, NULL, '1', '2', '3', '1', '2', '3', '1', '2', '3', '1', '2', '3', '1', '2', '3', '1', '2', '3', '1', '2', '3', NULL, 'download (1).jpg', '5922', '/uploads/inventory/12_download (1).jpg', 'image/jpeg', 'jpg', 0, '2019-11-18 19:50:30', '2020-01-22 02:05:07'),
(13, 'Square Table', NULL, NULL, NULL, 0, NULL, NULL, NULL, '0', NULL, '0', '0', '0', '10', '0', '0', '0', '12', '5', '7', '420', '', '', 1, 2, 3, 4, 5, NULL, NULL, '1', '1', '1', '1', '1', NULL, NULL, '1', '2', '3', '1', '2', '3', '1', '2', '3', '1', '2', '3', '1', '2', '3', '1', '2', '3', '1', '2', '3', NULL, 'download.jpg', '8458', '/uploads/inventory/13_download.jpg', 'image/jpeg', 'jpg', 0, '2019-11-18 23:01:20', '2020-01-22 02:05:39'),
(15, 'CupBoard', NULL, NULL, '15', 1, 13, '101,102,', NULL, '0', NULL, '0', '0', '0', '10', '0', '0', '0', '10', '10', '10', '10', '', '', 1, 1, 1, 1, 1, NULL, NULL, '1', '1', '1', '1', '1', 'freight', NULL, '5', '5', '5', '10', '10', '10', '10', '10', '10', '10', '10', '10', '15', '15', '15', '15', '15', '15', '20', '20', '20', NULL, '1-catalog_360.jpg', '20114', '/uploads/inventory/15_1-catalog_360.jpg', 'image/jpeg', 'jpg', 0, '2020-01-23 00:50:55', '2020-03-11 01:35:50'),
(16, 'trolly', NULL, NULL, '15', 0, 0, '100,101,102', NULL, '0', NULL, '0', '0', '0', '10', '0', '0', '0', '1', '2', '1', '2', '', '', 0, 0, 0, 0, 0, 5, '5', NULL, NULL, '1', '1', NULL, NULL, NULL, '1', '2', '3', '1', '2', '3', '1', '2', '3', '1', '2', '3', '1', '2', '3', '1', '2', '3', '1', '2', '3', 'default.png', NULL, NULL, NULL, NULL, NULL, 0, '2020-02-09 10:12:32', '2020-02-09 10:12:32'),
(19, 'sofa', NULL, NULL, NULL, NULL, NULL, '', NULL, '0', NULL, '0', '0', '0', '30', '0', '0', '0', '4', '5', '5', '100', '', '', 1, 1, 1, 1, 1, NULL, NULL, '1', '1', '1', '1', '1', 'freight', NULL, '1', '1', '1', '1', '2', '3', '3', '4', '5', '5', '6', '7', '7', '8', '9', '9', '10', '11', '11', '12', '13', NULL, 'images.jpg', '5961', '/uploads/inventory/19_images.jpg', 'image/jpeg', 'jpg', 0, '2020-02-16 16:58:31', '2020-02-16 16:58:31'),
(32, 'Cupboard', NULL, NULL, NULL, NULL, 14, NULL, NULL, '0', NULL, '0', '0', '0', '10', '0', '0', '0', '12', '12', '12', '1728', '', '', 1, 1, 1, 1, 1, NULL, NULL, NULL, NULL, '1', '1', NULL, NULL, NULL, '1', '2', '3', '1', '2', '3', '1', '2', '3', '1', '2', '3', '1', '2', '3', '1', '2', '3', '1', '2', '3', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2020-05-18 23:45:46', '2020-05-18 23:45:46'),
(34, 'Lamp Stand', NULL, NULL, '19', NULL, 15, NULL, NULL, '0', NULL, '0', '0', '0', '400', '0', '0', '0', '12', '12', '12', '1728', '', '', 1, 2, 3, 4, 5, NULL, NULL, '', '', '', '', '', '', '', '1', '2', '3', '1', '2', '3', '3', '4', '5', '5', '6', '7', '7', '8', '9', '9', '10', '11', '11', '12', '13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-05-20 06:52:11', '2020-06-25 11:08:18'),
(35, 'Tea Pot', NULL, NULL, '19', NULL, 13, '100', NULL, '0', NULL, '0', '0', '0', '12', '0', '0', '0', '2', '2', '2', '8', '2', '16', 0, 0, 0, 0, 0, NULL, NULL, '1', '1', '1', '1', '1', '1', '1', '5', '5', '5', '10', '10', '10', '10', '10', '10', '10', '10', '10', '15', '15', '15', '15', '15', '15', '20', '20', '20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-05-30 03:57:51', '2020-05-30 03:57:51'),
(38, 'Large Chest', NULL, NULL, '19', NULL, 19, NULL, NULL, '0', NULL, '0', '0', '0', '20', '20', '0', '0', '5', '2', '3', '30', '1', '30', 0, 0, 0, 0, 0, NULL, NULL, '1', '1', '1', '1', '1', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-06-06 06:05:41', '2020-06-06 06:08:21'),
(39, 'Small Box', NULL, NULL, '20', NULL, 15, '100', NULL, '0', NULL, '0', '0', '0', '25', '25', '0', '0', '1.5', '1', '1', '1.5', '1', '1.5', 0, 0, 0, 0, 0, NULL, NULL, '1', '1', '1', '1', '1', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Small Box.png', '459993', '/uploads/inventory/39_Small Box.png', 'image/png', 'png', NULL, '2020-06-06 06:50:02', '2020-06-20 00:51:44'),
(40, 'Door', NULL, NULL, '16', NULL, 19, NULL, NULL, '0', NULL, '0', '0', '0', '4', '32', '0', '0', '5', '2', '3', '30', '2', '60', 0, 0, 0, 0, 0, NULL, NULL, '1', '1', '1', '1', '1', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'URSA.jpg', '1460254', '/uploads/inventory/40_URSA.jpg', 'image/jpeg', 'jpg', NULL, '2020-06-06 07:31:51', '2020-06-09 19:27:01'),
(42, 'Small Box', NULL, NULL, '', NULL, 21, NULL, NULL, '0', NULL, '0', '0', '0', '25', '15', '0', '0', '1', '1', '1.5', '1.5', '1', '1.5', 0, 0, 0, 0, 0, NULL, NULL, '1', '1', '1', '1', '1', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-06-09 21:06:59', '2020-06-09 21:06:59'),
(64, 'testing2', NULL, NULL, '17', 1, 22, NULL, NULL, '0', NULL, '0', '0', '0', '20', '0', '0', '0', '10', '10', '10', '0', '0', '0', 0, 0, 0, 0, 0, NULL, NULL, '1', '1', '1', '1', '1', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'testing2.png', '24825', '/uploads/inventory/testing2.png', 'image/png', 'png', NULL, '2020-06-22 00:25:49', '2020-06-22 00:25:49'),
(65, 'Bar ', NULL, NULL, '0', 1, 19, NULL, NULL, '0', NULL, '0', '0', '0', '75', '0', '0', '0', '8', '10', '5', '0', '0', '0', 0, 0, 0, 0, 0, NULL, NULL, '1', '1', '1', '1', '1', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-06-22 00:55:43', '2020-06-22 00:55:43'),
(66, 'Large Desk', NULL, NULL, '0', NULL, 19, NULL, NULL, '0', NULL, '0', '0', '0', '75', '0', '0', '0', '2', '2', '5', '20', '0', '0', 0, 0, 0, 0, 0, NULL, NULL, '1', '1', '1', '1', '1', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-06-22 01:35:17', '2020-06-22 01:35:17'),
(67, 'thesiriussolutions.com', '3', '2', NULL, 1, 13, NULL, NULL, '0', NULL, '0', '0', '0', '0', '0', '67', '0', '78979878', '78789', '7987', '49701069169035354', '0', '0', 0, 0, 0, 0, 0, NULL, NULL, '1', '1', '1', '1', '1', '1', '1', '5', '5', '5', '10', '10', '10', '10', '10', '10', '10', '10', '10', '15', '15', '15', '15', '15', '15', '20', '20', '20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-07-13 11:43:32', '2020-07-13 11:43:32'),
(68, 'thesiriussolutions.com', '3', '2', NULL, 1, 13, NULL, NULL, '0', NULL, '0', '0', '0', '0', '0', '67', '0', '78979878', '78789', '7987', '49701069169035354', '0', '0', 0, 0, 0, 0, 0, NULL, NULL, '1', '1', '1', '1', '1', '1', '1', '5', '5', '5', '10', '10', '10', '10', '10', '10', '10', '10', '10', '15', '15', '15', '15', '15', '15', '20', '20', '20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-07-13 11:44:10', '2020-07-13 11:44:10'),
(69, 'thesiriussolutions.com', '3', '2', NULL, 1, 13, NULL, NULL, '0', NULL, '0', '0', '0', '0', '0', '67', '0', '78979878', '78789', '7987', '49701069169035354', '0', '0', 0, 0, 0, 0, 0, NULL, NULL, '1', '1', '1', '1', '1', '1', '1', '5', '5', '5', '10', '10', '10', '10', '10', '10', '10', '10', '10', '15', '15', '15', '15', '15', '15', '20', '20', '20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-07-13 11:44:40', '2020-07-13 11:44:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inventories`
--
ALTER TABLE `inventories`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inventories`
--
ALTER TABLE `inventories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
