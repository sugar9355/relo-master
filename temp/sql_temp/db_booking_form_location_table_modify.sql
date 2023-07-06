/*
SQLyog Professional v13.1.1 (64 bit)
MySQL - 10.4.11-MariaDB : Database - relo4_thesiriussolutionn
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

ALTER TABLE `booking_form_location` ADD  `curbside` int(1) DEFAULT 0;

ALTER TABLE `booking_form_location` ADD  `building_type` varchar(20) DEFAULT NULL;