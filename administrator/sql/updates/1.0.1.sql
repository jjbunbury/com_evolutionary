ALTER TABLE `#__evolutionary_breedable` ADD `asset_id` int(10) unsigned NOT NULL DEFAULT 0 COMMENT 'FK to the #__assets table.' AFTER id;
ALTER TABLE `__evolutionary_breedable` ADD `language` CHAR(7) NOT NULL COMMENT 'The language code for the article.' AFTER `ordering`;