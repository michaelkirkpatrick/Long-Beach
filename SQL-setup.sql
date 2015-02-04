# Dump of table authors
# ------------------------------------------------------------

CREATE TABLE `authors` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `author` varchar(100) DEFAULT NULL,
  `author_url` varchar(100) DEFAULT NULL,
  `latest_update` int(10) DEFAULT NULL,
  `date_added` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table blog
# ------------------------------------------------------------

CREATE TABLE `blog` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `atom_id` varchar(255) DEFAULT NULL,
  `url` varchar(255) NOT NULL DEFAULT '',
  `link` varchar(255) DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `author` varchar(100) NOT NULL DEFAULT '',
  `source` varchar(255) DEFAULT '',
  `published_time` int(10) NOT NULL,
  `published_month` char(2) NOT NULL DEFAULT '',
  `published_year` smallint(6) NOT NULL,
  `updated_time` int(10) DEFAULT NULL,
  `text` longtext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `URL` (`url`),
  UNIQUE KEY `ATOM_ID` (`atom_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table sources
# ------------------------------------------------------------

CREATE TABLE `sources` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `source` varchar(255) DEFAULT NULL,
  `source_url` varchar(255) DEFAULT NULL,
  `latest_update` int(10) DEFAULT NULL,
  `date_added` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;