CREATE TABLE IF NOT EXISTS `#__share_draft` (
  `id`         INT(10) UNSIGNED NOT NULL AUTO_INCREMENT
  COMMENT 'Primary Key',
  `articleId`  INT(10) UNSIGNED NOT NULL
  COMMENT '#__content',
  `created`    DATETIME         NOT NULL,
  `sharetoken` VARCHAR(255)     NOT NULL,
  PRIMARY KEY (`id`)
)
  DEFAULT CHARSET = utf8;