/*Table structure for table `shuffle_fees` */

CREATE TABLE `shuffle_fees` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `base_rate` float DEFAULT NULL,
  `charge_cb_ft` float DEFAULT NULL,
  `curbside_fee` float DEFAULT NULL,
  `parking_situations` varchar(50) DEFAULT NULL,
  `parking_fees` varchar(200) DEFAULT NULL,
  `vol_min` text DEFAULT NULL,
  `vol_max` text DEFAULT NULL,
  `long_walk_fee` text DEFAULT NULL,
  `dis_assem_fee` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
