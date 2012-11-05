ALTER TABLE  `ph_exhibitions` ADD PRIMARY KEY (  `id` );
ALTER TABLE  `ph_exhibitions` CHANGE  `id`  `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE  `ph_photos` ADD  `num_exhibitions` INT NOT NULL AFTER  `num_contests`;
ALTER TABLE  `ph_exhibitions` ADD  `is_deleted` TINYINT NOT NULL;
CREATE TABLE IF NOT EXISTS `ph_mail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `from_users_id` int(11) NOT NULL,
  `to_users_id` int(11) NOT NULL,
  `iname` varchar(255) NOT NULL,
  `idesc` text NOT NULL,
  `add_date` int(11) NOT NULL,
  `is_read` int(11) NOT NULL,
  `is_deleted` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;