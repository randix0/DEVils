CREATE TABLE IF NOT EXISTS `ph_mail_conversations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `users_id_1` int(11) NOT NULL,
  `users_id_2` int(11) NOT NULL,
  `unread_msg_1` int(11) NOT NULL,
  `unread_msg_2` int(11) NOT NULL,
  `readed_msg_1` int(11) NOT NULL,
  `readed_msg_2` int(11) NOT NULL,
  `last_msg` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
