CREATE TABLE `postal_codes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cp` varchar(100) DEFAULT NULL,
  `settlement` varchar(100) DEFAULT NULL,
  `settlement_type` varchar(100) DEFAULT NULL,
  `municipality` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8