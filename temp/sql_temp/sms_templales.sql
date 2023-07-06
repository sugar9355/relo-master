-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2020 at 09:42 PM
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
-- Table structure for table `sms_templales`
--

CREATE TABLE `sms_templales` (
  `id` int(10) UNSIGNED NOT NULL,
  `template_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `template_subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `template` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `createdat` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedat` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sms_templales`
--

INSERT INTO `sms_templales` (`id`, `template_id`, `template_subject`, `template`, `createdat`, `updatedat`, `created_at`, `updated_at`) VALUES
(1, '1', 'sadlasdjkljdaskjdkljsadlk', '<p>sakjdklasjdlkasjdlksadekrjekr&nbsp;</p>\n', '2020-07-18 15:29:11', '2020-07-18 15:36:52', NULL, NULL),
(2, 'a;sjkdajsdlk', 'jkljsdkljds', '<p>jkjasdklsadksalk sdl sad hasdkj</p>\n', '2020-07-18 15:32:56', NULL, NULL, NULL),
(3, '12', 'asdjaklsdj', '<p>aksjd asjd asjkdhas d sa dkjashd asd&nbsp; &nbsp;</p>\n\n<p>asd</p>\n\n<p>sad</p>\n\n<p>asd</p>\n\n<p>sad</p>\n\n<p>sa</p>\n\n<p>d</p>\n', '2020-07-18 15:50:45', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sms_templales`
--
ALTER TABLE `sms_templales`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sms_templales`
--
ALTER TABLE `sms_templales`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
