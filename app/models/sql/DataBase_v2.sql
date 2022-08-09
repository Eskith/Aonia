/*
SQLyog Community v13.1.7 (64 bit)
MySQL - 10.1.40-MariaDB : Database - testcdd
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`testcdd` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `testcdd`;

/*Table structure for table `areas` */

DROP TABLE IF EXISTS `areas`;

CREATE TABLE `areas` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_areas` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Table structure for table `centros` */

DROP TABLE IF EXISTS `centros`;

CREATE TABLE `centros` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `institucion_id` smallint(6) NOT NULL,
  `codigoPostal` mediumint(8) unsigned DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `provincia` enum('Alava','Albacete','Alicante','Almería','Asturias','Avila','Badajoz','Barcelona','Burgos','Cáceres','Cádiz','Cantabria','Castellón','Ciudad Real','Córdoba','La Coruña','Cuenca','Gerona','Granada','Guadalajara','Guipúzcoa','Huelva','Huesca','Islas Baleares','Jaén','León','Lérida','Lugo','Madrid','Málaga','Murcia','Navarra','Orense','Palencia','Las Palmas','Pontevedra','La Rioja','Salamanca','Segovia','Sevilla','Soria','Tarragona','Santa Cruz de Tenerife','Teruel','Toledo','Valencia','Valladolid','Vizcaya','Zamora','Zaragoza') DEFAULT NULL,
  `localidad` varchar(250) DEFAULT NULL,
  `direccion` varchar(250) DEFAULT NULL,
  `telefono` varchar(20) NOT NULL,
  `email` varchar(250) NOT NULL,
  `link` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_instituciones_institucion_id` (`institucion_id`),
  CONSTRAINT `fk_instituciones_institucion_id` FOREIGN KEY (`institucion_id`) REFERENCES `instituciones` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Table structure for table `docentes` */

DROP TABLE IF EXISTS `docentes`;

CREATE TABLE `docentes` (
  `usuario_id` int(11) NOT NULL,
  `centro_id` mediumint(9) NOT NULL,
  `testCdd_ultimo_test` bigint(20) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(150) NOT NULL,
  `area_id` smallint(6) DEFAULT NULL,
  `edad` tinyint(4) NOT NULL DEFAULT '0',
  `estado` enum('Perfil incompleto','Hacer Area 0 TestCDD','Hacer TestCDD','Completo') NOT NULL DEFAULT 'Perfil incompleto',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`usuario_id`),
  KEY `fk_docente_centro` (`centro_id`),
  KEY `fk_docente_area` (`area_id`),
  KEY `docentes_ibfk_1` (`testCdd_ultimo_test`),
  CONSTRAINT `fk_docente_area` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`),
  CONSTRAINT `fk_docente_centro` FOREIGN KEY (`centro_id`) REFERENCES `centros` (`id`),
  CONSTRAINT `fk_docente_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  CONSTRAINT `fk_ultimo_test_testcdd_id` FOREIGN KEY (`testCdd_ultimo_test`) REFERENCES `testcdd` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `docentes_etapas` */

DROP TABLE IF EXISTS `docentes_etapas`;

CREATE TABLE `docentes_etapas` (
  `docente_id` int(11) NOT NULL,
  `etapa_id` smallint(6) NOT NULL,
  PRIMARY KEY (`docente_id`,`etapa_id`),
  KEY `fk_docente_etapas_etapas` (`etapa_id`),
  CONSTRAINT `fk_docente_etapas_etapas` FOREIGN KEY (`etapa_id`) REFERENCES `etapas` (`id`),
  CONSTRAINT `fk_docentes_etapas_docente` FOREIGN KEY (`docente_id`) REFERENCES `docentes` (`usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `etapas` */

DROP TABLE IF EXISTS `etapas`;

CREATE TABLE `etapas` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_etapas` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Table structure for table `instituciones` */

DROP TABLE IF EXISTS `instituciones`;

CREATE TABLE `instituciones` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Table structure for table `resetpass` */

DROP TABLE IF EXISTS `resetpass`;

CREATE TABLE `resetpass` (
  `usuario_id` int(11) NOT NULL,
  `peticion_id` char(100) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_hasta` datetime NOT NULL,
  PRIMARY KEY (`usuario_id`),
  UNIQUE KEY `uq_resetpass_peticion_id` (`peticion_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tempdata` */

DROP TABLE IF EXISTS `tempdata`;

CREATE TABLE `tempdata` (
  `docente_id` int(11) unsigned NOT NULL,
  `key` varchar(70) NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`docente_id`,`key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `testcdd` */

DROP TABLE IF EXISTS `testcdd`;

CREATE TABLE `testcdd` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `docente_id` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `respuesta_1_1` char(1) NOT NULL DEFAULT '',
  `respuesta_1_2` char(1) NOT NULL DEFAULT '',
  `respuesta_1_3` char(1) NOT NULL DEFAULT '',
  `respuesta_2_1` char(1) NOT NULL DEFAULT '',
  `respuesta_2_2` char(1) NOT NULL DEFAULT '',
  `respuesta_2_3` char(1) NOT NULL DEFAULT '',
  `respuesta_2_4` char(1) NOT NULL DEFAULT '',
  `respuesta_2_5` char(1) NOT NULL DEFAULT '',
  `respuesta_2_6` char(1) NOT NULL DEFAULT '',
  `respuesta_3_1` char(1) NOT NULL DEFAULT '',
  `respuesta_3_2` char(1) NOT NULL DEFAULT '',
  `respuesta_3_3` char(1) NOT NULL DEFAULT '',
  `respuesta_3_4` char(1) NOT NULL DEFAULT '',
  `respuesta_4_1` char(1) NOT NULL DEFAULT '',
  `respuesta_4_2` char(1) NOT NULL DEFAULT '',
  `respuesta_4_3` char(1) NOT NULL DEFAULT '',
  `respuesta_4_4` char(1) NOT NULL DEFAULT '',
  `respuesta_5_1` char(1) NOT NULL DEFAULT '',
  `respuesta_5_2` char(1) NOT NULL DEFAULT '',
  `respuesta_5_3` char(1) NOT NULL DEFAULT '',
  `respuesta_5_4` char(1) NOT NULL DEFAULT '',
  `area_0` text,
  `area_1` smallint(6) NOT NULL DEFAULT '0',
  `area_2` smallint(6) NOT NULL DEFAULT '0',
  `area_3` smallint(6) NOT NULL DEFAULT '0',
  `area_4` smallint(6) NOT NULL DEFAULT '0',
  `area_5` smallint(6) NOT NULL DEFAULT '0',
  `finalMark` decimal(3,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `idx_docente_id_testcdd_respuestas` (`docente_id`),
  CONSTRAINT `fk_docente_id_testcdd_respuestas` FOREIGN KEY (`docente_id`) REFERENCES `docentes` (`usuario_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=latin1;

/*Table structure for table `testcdd_media` */

DROP TABLE IF EXISTS `testcdd_media`;

CREATE TABLE `testcdd_media` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `count` int(11) NOT NULL,
  `area_1` decimal(3,2) NOT NULL,
  `area_2` decimal(3,2) NOT NULL,
  `area_3` decimal(3,2) NOT NULL,
  `area_4` decimal(3,2) NOT NULL,
  `area_5` decimal(3,2) NOT NULL,
  `finalMark` decimal(3,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Table structure for table `testcdd_media_centros` */

DROP TABLE IF EXISTS `testcdd_media_centros`;

CREATE TABLE `testcdd_media_centros` (
  `centro_id` mediumint(9) unsigned NOT NULL,
  `count` int(11) NOT NULL,
  `area_1` decimal(3,2) NOT NULL,
  `area_2` decimal(3,2) NOT NULL,
  `area_3` decimal(3,2) NOT NULL,
  `area_4` decimal(3,2) NOT NULL,
  `area_5` decimal(3,2) NOT NULL,
  `finalMark` decimal(3,2) NOT NULL,
  PRIMARY KEY (`centro_id`),
  KEY `fk_media_centro_id` (`centro_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `testcdd_media_instituciones` */

DROP TABLE IF EXISTS `testcdd_media_instituciones`;

CREATE TABLE `testcdd_media_instituciones` (
  `institucion_id` smallint(6) unsigned NOT NULL,
  `count` int(11) NOT NULL,
  `area_1` decimal(3,2) NOT NULL,
  `area_2` decimal(3,2) NOT NULL,
  `area_3` decimal(3,2) NOT NULL,
  `area_4` decimal(3,2) NOT NULL,
  `area_5` decimal(3,2) NOT NULL,
  `finalMark` decimal(3,2) NOT NULL,
  PRIMARY KEY (`institucion_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `testcdd_ultima_calificacion` */

DROP TABLE IF EXISTS `testcdd_ultima_calificacion`;

CREATE TABLE `testcdd_ultima_calificacion` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `docente_id` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `area_1` smallint(6) NOT NULL DEFAULT '-1',
  `area_2` smallint(6) NOT NULL DEFAULT '-1',
  `area_3` smallint(6) NOT NULL DEFAULT '-1',
  `area_4` smallint(6) NOT NULL DEFAULT '-1',
  `area_5` smallint(6) NOT NULL DEFAULT '-1',
  `finalMark` decimal(3,2) NOT NULL DEFAULT '-1.00',
  PRIMARY KEY (`id`),
  KEY `idx_docente_id_testCDD_ultima_calificacion` (`docente_id`),
  CONSTRAINT `fk_docente_id_testCDD_ultima_calificacion` FOREIGN KEY (`docente_id`) REFERENCES `docentes` (`usuario_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `usuarios` */

DROP TABLE IF EXISTS `usuarios`;

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(250) NOT NULL,
  `pass` varchar(250) NOT NULL,
  `rol` enum('administrador','docente') NOT NULL DEFAULT 'docente',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_usuario_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=730 DEFAULT CHARSET=latin1;

/* Trigger structure for table `testcdd` */

DELIMITER $$

DROP TRIGGER IF EXISTS  `update_media` $$

CREATE  TRIGGER `update_media` AFTER INSERT ON `testcdd` FOR EACH ROW BEGIN
	DECLARE centro_id_aux INT;
	DECLARE institucion_id_aux INT;
	SET centro_id_aux = (SELECT centro_id  FROM docentes WHERE usuario_id = NEW.docente_id);
	SET institucion_id_aux = (SELECT institucion_id  FROM centros WHERE id = centro_id_aux);
	
	-- Insertamos en el docente el ID de su última calificación
	UPDATE docentes SET testCdd_ultimo_test = NEW.id WHERE usuario_id=NEW.docente_id;
	
	-- Actualizamos la media global
	INSERT INTO testcdd_media (id, `count`,     area_1,     area_2,     area_3,    area_4,     area_5,      finalMark) 
	VALUES 			  (1, 1,     NEW.area_1, NEW.area_2, NEW.area_3, NEW.area_4, NEW.area_5, NEW.finalMark)
	ON DUPLICATE KEY UPDATE 
	area_1=((area_1*`count`) + NEW.area_1)/(`count`+1), 
	area_2=((area_2*`count`) + NEW.area_2)/(`count`+1), 
	area_3=((area_3*`count`) + NEW.area_3)/(`count`+1), 
	area_4=((area_4*`count`) + NEW.area_4)/(`count`+1), 
	area_5=((area_5*`count`) + NEW.area_5)/(`count`+1), 
	finalMark=((finalMark*`count`) + NEW.finalMark)/(`count`+1), 
	`count`=`count`+1;
	
	
	-- Actualizamos la media del centro
	INSERT INTO testcdd_media_centros (centro_id, `count`,     area_1,     area_2,     area_3,    area_4,     area_5,      finalMark) 
	VALUES 			  (centro_id_aux, 1,     NEW.area_1, NEW.area_2, NEW.area_3, NEW.area_4, NEW.area_5, NEW.finalMark)
	ON DUPLICATE KEY UPDATE 
	area_1=((area_1*`count`) + NEW.area_1)/(`count`+1), 
	area_2=((area_2*`count`) + NEW.area_2)/(`count`+1), 
	area_3=((area_3*`count`) + NEW.area_3)/(`count`+1), 
	area_4=((area_4*`count`) + NEW.area_4)/(`count`+1), 
	area_5=((area_5*`count`) + NEW.area_5)/(`count`+1), 
	finalMark=((finalMark*`count`) + NEW.finalMark)/(`count`+1), 
	`count`=`count`+1;
	
	
	-- Actualizamos la media de la institución
	INSERT INTO testcdd_media_instituciones (institucion_id, `count`,     area_1,     area_2,     area_3,    area_4,     area_5,      finalMark) 
	VALUES 			  (institucion_id_aux, 1,     NEW.area_1, NEW.area_2, NEW.area_3, NEW.area_4, NEW.area_5, NEW.finalMark)
	ON DUPLICATE KEY UPDATE 
	area_1=((area_1*`count`) + NEW.area_1)/(`count`+1), 
	area_2=((area_2*`count`) + NEW.area_2)/(`count`+1), 
	area_3=((area_3*`count`) + NEW.area_3)/(`count`+1), 
	area_4=((area_4*`count`) + NEW.area_4)/(`count`+1), 
	area_5=((area_5*`count`) + NEW.area_5)/(`count`+1), 
	finalMark=((finalMark*`count`) + NEW.finalMark)/(`count`+1), 
	`count`=`count`+1;
	
    END $$



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
