/*Table structure for table `inventory_time_extra` */

DROP TABLE IF EXISTS `inventory_time_extra`;

CREATE TABLE `inventory_time_extra` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `num_worker` int(11) DEFAULT NULL,
  `num_stairs` varchar(20) DEFAULT NULL,
  `location_type` int(11) DEFAULT NULL,
  `groundfloor_min` float NOT NULL DEFAULT 0,
  `groundfloor_med` float NOT NULL DEFAULT 0,
  `groundfloor_max` float NOT NULL DEFAULT 0,
  `bulkhead_min` float NOT NULL DEFAULT 0,
  `bulkhead_med` float NOT NULL DEFAULT 0,
  `bulkhead_max` float NOT NULL DEFAULT 0,
  `en_steps_min` float NOT NULL DEFAULT 0,
  `en_steps_med` float NOT NULL DEFAULT 0,
  `en_steps_max` float NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=863 DEFAULT CHARSET=latin1;
