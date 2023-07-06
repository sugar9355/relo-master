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
-- Table structure for table `mail_templates`
--

CREATE TABLE `mail_templates` (
  `id` int(10) UNSIGNED NOT NULL,
  `template_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `from_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `template_subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `template` longtext COLLATE utf8_unicode_ci NOT NULL,
  `createdat` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedat` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `mail_templates`
--

INSERT INTO `mail_templates` (`id`, `template_id`, `from_email`, `template_subject`, `template`, `createdat`, `updatedat`, `created_at`, `updated_at`) VALUES
(1, '1', 'adadsasd@adasd.com', 'confirmation mail', '<p>askdjasdkl&nbsp;&nbsp;<a href=\"http://localhost:8000/admin/edit-template/1\">http://localhost:8000/admin/edit-template/1</a>&nbsp; &nbsp;<a href=\"http://localhost:8000/admin/edit-template/1\">http://localhost:8000/admin/edit-template/1</a>&nbsp; &nbsp;askdjasdkl&nbsp;&nbsp;<a href=\"http://localhost:8000/admin/edit-template/1\">http://localhost:8000/admin/edit-template/1</a>&nbsp; &nbsp;<a href=\"http://localhost:8000/admin/edit-template/1\">http://localhost:8000/admin/edit-template/1</a>&nbsp; &nbsp;askdjasdkl&nbsp;&nbsp;<a href=\"http://localhost:8000/admin/edit-template/1\">http://localhost:8000/admin/edit-template/1</a>&nbsp; &nbsp;<a href=\"http://localhost:8000/admin/edit-template/1\">http://localhost:8000/admin/edit-template/1</a>&nbsp; &nbsp;askdjasdkl&nbsp;&nbsp;<a href=\"http://localhost:8000/admin/edit-template/1\">http://localhost:8000/admin/edit-template/1</a>&nbsp; &nbsp;<a href=\"http://localhost:8000/admin/edit-template/1\">http://localhost:8000/admin/edit-template/1</a>&nbsp; &nbsp;askdjasdkl&nbsp;&nbsp;<a href=\"http://localhost:8000/admin/edit-template/1\">http://localhost:8000/admin/edit-template/1</a>&nbsp; &nbsp;<a href=\"http://localhost:8000/admin/edit-template/1\">http://localhost:8000/admin/edit-template/1</a>&nbsp; &nbsp;askdjasdkl&nbsp;&nbsp;<a href=\"http://localhost:8000/admin/edit-template/1\">http://localhost:8000/admin/edit-template/1</a>&nbsp; &nbsp;<a href=\"http://localhost:8000/admin/edit-template/1\">http://localhost:8000/admin/edit-template/1</a>&nbsp; &nbsp;askdjasdkl&nbsp;&nbsp;<a href=\"http://localhost:8000/admin/edit-template/1\">http://localhost:8000/admin/edit-template/1</a>&nbsp; &nbsp;<a href=\"http://localhost:8000/admin/edit-template/1\">http://localhost:8000/admin/edit-template/1</a>&nbsp; &nbsp;askdjasdkl&nbsp;&nbsp;<a href=\"http://localhost:8000/admin/edit-template/1\">http://localhost:8000/admin/edit-template/1</a>&nbsp; &nbsp;<a href=\"http://localhost:8000/admin/edit-template/1\">http://localhost:8000/admin/edit-template/1</a>&nbsp; &nbsp;askdjasdkl&nbsp;&nbsp;<a href=\"http://localhost:8000/admin/edit-template/1\">http://localhost:8000/admin/edit-template/1</a>&nbsp; &nbsp;<a href=\"http://localhost:8000/admin/edit-template/1\">http://localhost:8000/admin/edit-template/1</a>&nbsp; &nbsp;askdjasdkl&nbsp;&nbsp;<a href=\"http://localhost:8000/admin/edit-template/1\">http://localhost:8000/admin/edit-template/1</a>&nbsp; &nbsp;<a href=\"http://localhost:8000/admin/edit-template/1\">http://localhost:8000/admin/edit-template/1</a>&nbsp; &nbsp;askdjasdkl&nbsp;&nbsp;<a href=\"http://localhost:8000/admin/edit-template/1\">http://localhost:8000/admin/edit-template/1</a>&nbsp; &nbsp;<a href=\"http://localhost:8000/admin/edit-template/1\">http://localhost:8000/admin/edit-template/1</a>&nbsp; &nbsp;askdjasdkl&nbsp;&nbsp;<a href=\"http://localhost:8000/admin/edit-template/1\">http://localhost:8000/admin/edit-template/1</a>&nbsp; &nbsp;<a href=\"http://localhost:8000/admin/edit-template/1\">http://localhost:8000/admin/edit-template/1</a>&nbsp; &nbsp;askdjasdkl&nbsp;&nbsp;<a href=\"http://localhost:8000/admin/edit-template/1\">http://localhost:8000/admin/edit-template/1</a>&nbsp; &nbsp;<a href=\"http://localhost:8000/admin/edit-template/1\">http://localhost:8000/admin/edit-template/1</a>&nbsp; &nbsp;askdjasdkl&nbsp;&nbsp;<a href=\"http://localhost:8000/admin/edit-template/1\">http://localhost:8000/admin/edit-template/1</a>&nbsp; &nbsp;<a href=\"http://localhost:8000/admin/edit-template/1\">http://localhost:8000/admin/edit-template/1</a>&nbsp; &nbsp;askdjasdkl&nbsp;&nbsp;<a href=\"http://localhost:8000/admin/edit-template/1\">http://localhost:8000/admin/edit-template/1</a>&nbsp; &nbsp;<a href=\"http://localhost:8000/admin/edit-template/1\">http://localhost:8000/admin/edit-template/1</a>&nbsp; &nbsp;askdjasdkl&nbsp;&nbsp;<a href=\"http://localhost:8000/admin/edit-template/1\">http://localhost:8000/admin/edit-template/1</a>&nbsp; &nbsp;<a href=\"http://localhost:8000/admin/edit-template/1\">http://localhost:8000/admin/edit-template/1</a>&nbsp; &nbsp;askdjasdkl&nbsp;&nbsp;<a href=\"http://localhost:8000/admin/edit-template/1\">http://localhost:8000/admin/edit-template/1</a>&nbsp; &nbsp;<a href=\"http://localhost:8000/admin/edit-template/1\">http://localhost:8000/admin/edit-template/1</a>&nbsp; &nbsp;askdjasdkl&nbsp;&nbsp;<a href=\"http://localhost:8000/admin/edit-template/1\">http://localhost:8000/admin/edit-template/1</a>&nbsp; &nbsp;<a href=\"http://localhost:8000/admin/edit-template/1\">http://localhost:8000/admin/edit-template/1</a>&nbsp; &nbsp;askdjasdkl&nbsp;&nbsp;<a href=\"http://localhost:8000/admin/edit-template/1\">http://localhost:8000/admin/edit-template/1</a>&nbsp; &nbsp;<a href=\"http://localhost:8000/admin/edit-template/1\">http://localhost:8000/admin/edit-template/1</a>&nbsp; &nbsp;</p>\n', '2020-07-01 16:09:04', '2020-07-06 06:18:13', NULL, NULL),
(2, '23', 'asdasd@sdas.com', 'sdhauisdhusiad', '<p>sdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiadsdhauisdhusiad</p>\n', '2020-07-02 16:49:37', '2020-07-06 05:34:11', NULL, NULL),
(3, '13', 'DASD@ASDADS.COM', 'DSADASDJK', '<p>asdasdsadasdasdsadasdasdsadasdasdsadasdasdsadasdasdsadasdasdsadasdasdsadasdasdsadasdasdsadasdasdsadasdasdsadasdasdsadasdasdsadasdasdsadasdasdsadasdasdsadasdasdsadasdasdsadasdasdsadasdasdsadasdasdsadasdasdsadasdasdsadasdasdsadasdasdsadasdasdsadasdasdsadasdasdsadasdasdsadasdasdsadasdasdsadasdasdsadasdasdsad</p>\n', '2020-07-02 16:57:31', '2020-07-06 05:34:27', NULL, NULL),
(4, '0', 'asdasd@sdas.com', 'sadlasdjklj', '<p>sadlasdjkljsadlasdjkljsadlasdjkljsadlasdjkljsadlasdjkljsadlasdjkljsadlasdjkljsadlasdjkljsadlasdjkljsadlasdjkljsadlasdjkljsadlasdjkljsadlasdjkljsadlasdjkljsadlasdjkljsadlasdjkljsadlasdjkljsadlasdjkljsadlasdjkljsadlasdjkljsadlasdjkljsadlasdjkljsadlasdjkljsadlasdjkljsadlasdjkljsadlasdjkljsadlasdjkljsadlasdjkljsadlasdjklj</p>\n', '2020-07-05 13:44:55', '2020-07-06 06:01:28', NULL, NULL),
(5, '100', 'ashdjsah@sadsa.com', 'sadaskdjkasdhjk', '<p>sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;sadaskdjkasdhjk&nbsp; &nbsp;</p>\n', '2020-07-06 05:35:09', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mail_templates`
--
ALTER TABLE `mail_templates`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mail_templates`
--
ALTER TABLE `mail_templates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
