/*
SQLyog Professional v13.1.1 (64 bit)
MySQL - 10.4.11-MariaDB : Database - relo4_thesiriussolutionn
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`relo4_thesiriussolutionn` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `relo4_thesiriussolutionn`;

/*Table structure for table `inventories` */

DROP TABLE IF EXISTS `inventories`;

CREATE TABLE `inventories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `meterial` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hoisting` int(1) DEFAULT 0,
  `category_id` int(10) DEFAULT NULL,
  `equipments` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `badges` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stackable` int(1) NOT NULL DEFAULT 0,
  `stackable_multiplier` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `storage_price` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `pickup_price` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `dropoff_price` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `weight_min` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `junk_price_min` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `weight_max` varchar(255) COLLATE utf8_unicode_ci DEFAULT '0',
  `junk_price_max` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `width` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `height` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `breadth` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `volume` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `multiplier` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `packing_volume` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `wrapping_material` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `wrapping_qty` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `wrapping_time` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `wrapping_price` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
