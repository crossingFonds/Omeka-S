CREATE TABLE `selection` (
    `id` INT AUTO_INCREMENT NOT NULL,
    `owner_id` INT NOT NULL,
    `is_public` TINYINT(1) DEFAULT 0 NOT NULL,
    `is_dynamic` TINYINT(1) DEFAULT 0 NOT NULL,
    `label` VARCHAR(190) NOT NULL,
    `comment` LONGTEXT DEFAULT NULL,
    `search_query` LONGTEXT DEFAULT NULL,
    `structure` LONGTEXT DEFAULT NULL COMMENT '(DC2Type:json)',
    `created` DATETIME NOT NULL,
    `modified` DATETIME DEFAULT NULL,
    INDEX IDX_96A50CD77E3C61F9 (`owner_id`),
    UNIQUE INDEX UNIQ_96A50CD77E3C61F9EA750E85D978C7C (`owner_id`, `label`, `is_dynamic`),
    PRIMARY KEY(`id`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB;
CREATE TABLE `selection_resource` (
    `id` INT AUTO_INCREMENT NOT NULL,
    `owner_id` INT NOT NULL,
    `resource_id` INT NOT NULL,
    `selection_id` INT DEFAULT NULL,
    `created` DATETIME NOT NULL,
    INDEX IDX_6B34815E7E3C61F9 (`owner_id`),
    INDEX IDX_6B34815E89329D25 (`resource_id`),
    INDEX IDX_6B34815EE48EFE78 (`selection_id`),
    UNIQUE INDEX UNIQ_6B34815E89329D25E48EFE78 (`resource_id`, `selection_id`),
    PRIMARY KEY(`id`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB;
ALTER TABLE `selection` ADD CONSTRAINT FK_96A50CD77E3C61F9 FOREIGN KEY (`owner_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
ALTER TABLE `selection_resource` ADD CONSTRAINT FK_6B34815E7E3C61F9 FOREIGN KEY (`owner_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
ALTER TABLE `selection_resource` ADD CONSTRAINT FK_6B34815E89329D25 FOREIGN KEY (`resource_id`) REFERENCES `resource` (`id`) ON DELETE CASCADE;
ALTER TABLE `selection_resource` ADD CONSTRAINT FK_6B34815EE48EFE78 FOREIGN KEY (`selection_id`) REFERENCES `selection` (`id`) ON DELETE CASCADE;
