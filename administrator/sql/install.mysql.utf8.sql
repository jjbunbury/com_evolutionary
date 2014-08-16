CREATE TABLE IF NOT EXISTS `#__evolutionary_action` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`title` VARCHAR(255)  NOT NULL ,
`unique_id` VARCHAR(36)  NOT NULL ,
`attribs` TEXT NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`created` DATETIME NOT NULL ,
`created_by` INT(11)  NOT NULL ,
`modified` DATETIME NOT NULL ,
`modified_by` VARCHAR(255)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`version` VARCHAR(255)  NOT NULL ,
`ordering` INT(11)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__evolutionary_animation` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`title` VARCHAR(255)  NOT NULL ,
`frames` VARCHAR(255)  NOT NULL ,
`repeat` VARCHAR(255)  NOT NULL ,
`delay` VARCHAR(255)  NOT NULL ,
`method` TEXT NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`created` DATETIME NOT NULL ,
`created_by` INT(11)  NOT NULL ,
`modified` DATETIME NOT NULL ,
`modified_by` VARCHAR(255)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`version` VARCHAR(255)  NOT NULL ,
`ordering` INT(11)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__evolutionary_configuration` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`title` VARCHAR(255)  NOT NULL ,
`unique_id` VARCHAR(36)  NOT NULL ,
`attribs` TEXT NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`created` DATETIME NOT NULL ,
`created_by` INT(11)  NOT NULL ,
`modified` DATETIME NOT NULL ,
`modified_by` VARCHAR(255)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`version` VARCHAR(255)  NOT NULL ,
`ordering` INT(11)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__evolutionary_texture` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`title` VARCHAR(255)  NOT NULL ,
`catid` INT(11)  NOT NULL ,
`gen` VARCHAR(255)  NOT NULL ,
`class` VARCHAR(255)  NOT NULL ,
`limit` VARCHAR(255)  NOT NULL ,
`method` TEXT NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`created` DATETIME NOT NULL ,
`created_by` INT(11)  NOT NULL ,
`modified` DATETIME NOT NULL ,
`modified_by` VARCHAR(255)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`version` VARCHAR(255)  NOT NULL ,
`ordering` INT(11)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__evolutionary_breedable` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`asset_id` int(10) unsigned NOT NULL DEFAULT 0 COMMENT 'FK to the #__assets table.',
`title` VARCHAR(255)  NOT NULL ,
`unique_id` VARCHAR(36)  NOT NULL ,
`alias` VARCHAR(255)  NOT NULL ,
`catid` INT(11)  NOT NULL ,
`texture` VARCHAR(255)  NOT NULL ,
`configuration` VARCHAR(255)  NOT NULL ,
`animation` VARCHAR(255)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`created` DATETIME NOT NULL ,
`created_by` INT(11)  NOT NULL ,
`modified` DATETIME NOT NULL ,
`modified_by` VARCHAR(255)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`attribs` TEXT NOT NULL ,
`version` VARCHAR(255)  NOT NULL ,
`ordering` INT(11)  NOT NULL ,
`language` char(7) NOT NULL COMMENT 'The language code for the article.',
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

