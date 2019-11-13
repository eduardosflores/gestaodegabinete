DROP TABLE IF EXISTS `gab_agenda`;
DROP TABLE IF EXISTS `gab_agenda_ext`;

DROP TABLE IF EXISTS `gab_calendar_key`;
CREATE TABLE `gab_calendar_key` (
  `api_key` varchar(255),
  `calendar_id` varchar(255),
  PRIMARY KEY (`api_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Table structure for table `gab_cargo_politico`
--
DROP TABLE IF EXISTS `gab_cargo_politico`;
CREATE TABLE `gab_cargo_politico` (
  `cod_car_pol` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nom_car_pol` varchar(150) NOT NULL,
  `ind_car_pol` char(1) NOT NULL,
  PRIMARY KEY (`cod_car_pol`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

ALTER TABLE gab_vereador ADD nom_orgao varchar(150) DEFAULT NULL;

ALTER TABLE gab_vereador ADD GAB_CARGO_POLITICO_cod_car_pol int(10) unsigned DEFAULT NULL,
  ADD KEY `fk_cod_car_pol` (`GAB_CARGO_POLITICO_cod_car_pol`),
  ADD CONSTRAINT `fk_cod_car_pol` FOREIGN KEY (`GAB_CARGO_POLITICO_cod_car_pol`) REFERENCES `gab_cargo_politico` (`cod_car_pol`);

ALTER TABLE gab_vereador DROP COLUMN ind_sexo;