DROP TABLE IF EXISTS `gab_agenda`;
DROP TABLE IF EXISTS `gab_agenda_ext`;

DROP TABLE IF EXISTS `gab_calendar_key`;
CREATE TABLE `gab_calendar_key` (
  `api_key` varchar(255),
  `calendar_id` varchar(255),
  PRIMARY KEY (`api_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;