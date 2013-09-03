-- -
-- テーブルの構造 `patchworks`
-- お知らせに近い構造
-- -

CREATE TABLE `patchworks` (
  `block_id`         int(11) unsigned NOT NULL,
  `room_id`          int(11) NOT NULL default '0',
  `patchworks_id`    int(11) NOT NULL default '0',
  `item`    MEDIUMTEXT NOT NULL default '',
  `insert_time`      varchar(14) NOT NULL default '',
  `insert_site_id`   varchar(40) NOT NULL default '',
  `insert_user_id`   varchar(40) NOT NULL default '',
  `insert_user_name` varchar(255) NOT NULL,
  `update_time`      varchar(14) NOT NULL default '',
  `update_site_id`   varchar(40) NOT NULL default '',
  `update_user_id`   varchar(40) NOT NULL default '',
  `update_user_name` varchar(255) NOT NULL,
  PRIMARY KEY  (`block_id`),
  KEY `room_id` (`room_id`)
) ENGINE=MyISAM;

CREATE TABLE `patchworks_config` (
  `patchworks_id`    int(11) NOT NULL default '0',
  `config`    MEDIUMTEXT NOT NULL default '',
  `insert_time`      varchar(14) NOT NULL default '',
  `insert_site_id`   varchar(40) NOT NULL default '',
  `insert_user_id`   varchar(40) NOT NULL default '',
  `insert_user_name` varchar(255) NOT NULL,
  `update_time`      varchar(14) NOT NULL default '',
  `update_site_id`   varchar(40) NOT NULL default '',
  `update_user_id`   varchar(40) NOT NULL default '',
  `update_user_name` varchar(255) NOT NULL,
  PRIMARY KEY  (`patchworks_id`)
) ENGINE=MyISAM;
