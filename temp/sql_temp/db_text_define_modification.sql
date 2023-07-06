
DROP TABLE IF EXISTS `text_define`;

CREATE TABLE `text_define` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `font_size` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `text_define` */

insert  into `text_define`(`id`,`name`,`color`,`font_size`,`created_at`,`updated_at`) values 
(1,'This is a test','#9fbe23','12',NULL,NULL),
(2,'Flexible text','#2dc3d7','14',NULL,NULL),
(3,'Unflexible text','#d28b28','14',NULL,NULL);

