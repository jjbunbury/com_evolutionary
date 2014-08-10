CREATE TABLE IF NOT EXISTS `#__evolutionary_breedable` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`asset_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',

`title` VARCHAR(40)  NOT NULL ,
`alias` VARCHAR(40)  NOT NULL ,
`texture` VARCHAR(255)  NOT NULL ,
`animation` VARCHAR(255)  NOT NULL ,
`config` VARCHAR(255)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`category` INT(11)  NOT NULL ,
`created` DATE NOT NULL ,
`created_by` INT(11)  NOT NULL ,
`modified` DATE NOT NULL ,
`modified_by` INT(10)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`version` INT(10)  NOT NULL ,
`ordering` INT(11)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

