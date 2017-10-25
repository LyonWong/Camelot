CREATE TABLE IF NOT EXISTS `configs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `val` varchar(255) DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='config series';

CREATE TABLE IF NOT EXISTS `scope_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `depth` tinyint(4) NOT NULL DEFAULT '0',
  `rank` tinyint(4) NOT NULL DEFAULT '0',
  `path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `scope_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `scope` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'group name',
  `auths` json DEFAULT NULL COMMENT 'group auths',
  PRIMARY KEY (`id`),
  UNIQUE KEY `s-g` (`scope`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `scope_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL COMMENT 'user id',
  `groups` json DEFAULT NULL COMMENT 'auth group',
  `auths` json DEFAULT NULL COMMENT 'user auths',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sn` varchar(255) NOT NULL COMMENT 'serial number',
  `name` varchar(255) NOT NULL COMMENT 'user name',
  `info` json DEFAULT NULL COMMENT 'user info',
  `tms_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tms_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sn` (`sn`),
  KEY `tms-crt` (`tms_create`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `user_auth` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `i_type` tinyint(4) NOT NULL COMMENT 'auth type',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'user id',
  `uaid` varchar(255) NOT NULL COMMENT 'user auth id',
  `code` varchar(255) NOT NULL COMMENT 'auth code',
  `expire` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'expire timeint, 0:infi',
  `extra` json DEFAULT NULL,
  `tms_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tms_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `i-u` (`i_type`,`uaid`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

