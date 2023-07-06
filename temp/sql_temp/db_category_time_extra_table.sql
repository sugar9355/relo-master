DROP TABLE IF EXISTS `category_time_extra`;

CREATE TABLE `category_time_extra` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `num_worker` int(11) DEFAULT NULL,
  `num_stairs` varchar(20) DEFAULT NULL,
  `location_type` int(11) DEFAULT NULL,
  `groundfloor_min` float DEFAULT 0,
  `groundfloor_med` float DEFAULT 0,
  `groundfloor_max` float DEFAULT 0,
  `bulkhead_min` float DEFAULT 0,
  `bulkhead_med` float DEFAULT 0,
  `bulkhead_max` float DEFAULT 0,
  `en_steps_min` float DEFAULT 0,
  `en_steps_med` float DEFAULT 0,
  `en_steps_max` float DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=289 DEFAULT CHARSET=latin1;
