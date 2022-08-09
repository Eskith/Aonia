/*

CREATE DATABASE testCdd;

CREATE USER 'testCdd'@'localhost' IDENTIFIED BY 'eUcd3UsmVIanAyn9';
GRANT SELECT, INSERT, UPDATE, DELETE ON testCdd.* TO 'testCdd'@'localhost';

INSERT INTO `user`(cedula) VALUES ('1');

*/

CREATE TABLE `user` (
  `id` MEDIUMINT NOT NULL AUTO_INCREMENT,
  `cedula` VARCHAR(20) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `uq_cedula` (`cedula` ASC)
  );

{{userMarksSQL}}

CREATE TABLE `adminUsers` (
  `user` VARCHAR(50) NULL DEFAULT NULL,
  `pass` VARCHAR(260) NULL DEFAULT NULL,
  PRIMARY KEY (`user`)
  );

CREATE TABLE `testCDD_responses` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `user_id` MEDIUMINT NOT NULL,
  `fecha` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  INDEX `idx_user_id` (`user_id` ASC)
);

{{responsesSQL}}

CREATE TABLE `testCDD_marks` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `user_id` MEDIUMINT NOT NULL,
  `fecha` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_user_id_marks` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  INDEX `idx_user_id_marks` (`user_id` ASC)
);

{{marksSQL}}

CREATE TABLE `testCDD_media` (
  `id` SMALLINT NOT NULL AUTO_INCREMENT,
  `count` INT NOT NULL,

  PRIMARY KEY (`id`)
);

{{mediasSQL}}



CREATE TABLE `uncompleted_test` (
  `user_id` INT NOT NULL,
  `data` TEXT NOT NULL,
  PRIMARY KEY (`user_id`)
);
