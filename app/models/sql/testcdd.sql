CREATE TABLE `usuarios` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(250) NOT NULL,
  `pass` VARCHAR(250) NOT NULL,
  `rol` ENUM('administrador','docente') NOT NULL DEFAULT 'docente',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_usuario_email` (`email`)
) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;



CREATE TABLE `areas` (
  `id` SMALLINT(6) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_areas` (`nombre`)
) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;




/*Data for the table `areas` */

INSERT  INTO `areas`(`id`,`nombre`) VALUES 
(1,'Ciencias'),
(6,'Educación Física'),
(4,'Humanidades'),
(3,'Lengua'),
(5,'Lenguas extranjeras'),
(2,'Matemáticas'),
(7,'PAS');



CREATE TABLE `etapas` (
  `id` SMALLINT(6) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_etapas` (`nombre`)
) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


INSERT  INTO `etapas`(`id`,`nombre`) VALUES 
(6,'Bachillerato'),
(7,'Ciclos formativos'),
(8,'Educación superior'),
(1,'Infantil'),
(2,'Primer ciclo de primaria'),
(5,'Secundaria'),
(3,'Segundo ciclo de primaria'),
(4,'Tercer ciclo de primaria'),
(9,'Universitario');

CREATE TABLE `instituciones` (
  `id` SMALLINT(6) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


CREATE TABLE `centros` (
  `id` MEDIUMINT(9) NOT NULL AUTO_INCREMENT,
  `institucion_id` SMALLINT(6) NOT NULL,
  `codigoPostal` MEDIUMINT(8) UNSIGNED DEFAULT NULL,
  `nombre` VARCHAR(100) NOT NULL,
  `codigo` VARCHAR(20) NOT NULL,
  `provincia` ENUM('Alava','Albacete','Alicante','Almería','Asturias','Avila','Badajoz','Barcelona','Burgos','Cáceres','Cádiz','Cantabria','Castellón','Ciudad Real','Córdoba','La Coruña','Cuenca','Gerona','Granada','Guadalajara','Guipúzcoa','Huelva','Huesca','Islas Baleares','Jaén','León','Lérida','Lugo','Madrid','Málaga','Murcia','Navarra','Orense','Palencia','Las Palmas','Pontevedra','La Rioja','Salamanca','Segovia','Sevilla','Soria','Tarragona','Santa Cruz de Tenerife','Teruel','Toledo','Valencia','Valladolid','Vizcaya','Zamora','Zaragoza') DEFAULT NULL,
  `localidad` VARCHAR(250) DEFAULT NULL,
  `direccion` VARBINARY(250) DEFAULT NULL,
  `telefono` VARCHAR(20) NOT NULL,
  `email` VARCHAR(250) NOT NULL,
  `link` VARCHAR(250) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_instituciones_institucion_id` (`institucion_id`),
  CONSTRAINT `fk_instituciones_institucion_id` FOREIGN KEY (`institucion_id`) REFERENCES `instituciones` (`id`)
) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE `docentes` (
  `usuario_id` INT(11) NOT NULL,
  `centro_id` MEDIUMINT(9) NOT NULL,
  `testCdd_ultimo_test` BIGINT(20) DEFAULT NULL,
  `nombre` VARCHAR(100) NOT NULL,
  `apellidos` VARCHAR(150) NOT NULL,
  `area_id` SMALLINT(6) DEFAULT NULL,
  `edad` TINYINT(4) NOT NULL DEFAULT 0,
  `estado` ENUM('Perfil incompleto','Hacer Area 0 TestCDD','Hacer TestCDD','Completo') NOT NULL DEFAULT 'Perfil incompleto',
  `create_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (`usuario_id`),
  KEY `fk_docente_centro` (`centro_id`),
  KEY `fk_docente_area` (`area_id`),
  KEY `docentes_ibfk_1` (`testCdd_ultimo_test`),
  CONSTRAINT `fk_docente_area` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`),
  CONSTRAINT `fk_docente_centro` FOREIGN KEY (`centro_id`) REFERENCES `centros` (`id`),
  CONSTRAINT `fk_docente_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  CONSTRAINT `fk_ultimo_test_testcdd_id` FOREIGN KEY (`testCdd_ultimo_test`) REFERENCES `testcdd` (`id`)
) ENGINE=INNODB DEFAULT CHARSET=latin1;

/*Data for the table `docentes` */

/*Table structure for table `docentes_etapas` */

CREATE TABLE `docentes_etapas` (
  `docente_id` INT(11) NOT NULL,
  `etapa_id` SMALLINT(6) NOT NULL,
  PRIMARY KEY (`docente_id`,`etapa_id`),
  KEY `fk_docente_etapas_etapas` (`etapa_id`),
  CONSTRAINT `fk_docente_etapas_etapas` FOREIGN KEY (`etapa_id`) REFERENCES `etapas` (`id`),
  CONSTRAINT `fk_docentes_etapas_docente` FOREIGN KEY (`docente_id`) REFERENCES `docentes` (`usuario_id`)
) ENGINE=INNODB DEFAULT CHARSET=latin1;


/*Table structure for table `instituciones` */



/*Table structure for table `resetpass` */

CREATE TABLE `resetpass` (
  `usuario_id` INT(11) NOT NULL,
  `peticion_id` CHAR(100) NOT NULL,
  `fecha` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `fecha_hasta` DATETIME NOT NULL,
  PRIMARY KEY (`usuario_id`),
  UNIQUE KEY `uq_resetpass_peticion_id` (`peticion_id`)
) ENGINE=INNODB DEFAULT CHARSET=latin1;

/*Data for the table `resetpass` */

/*Table structure for table `tempdata` */

CREATE TABLE `tempdata` (
  `docente_id` INT(11) UNSIGNED NOT NULL,
  `key` VARCHAR(70) NOT NULL,
  `data` TEXT NOT NULL,
  PRIMARY KEY (`docente_id`,`key`)
) ENGINE=INNODB DEFAULT CHARSET=latin1;


/*Table structure for table `testcdd` */

CREATE TABLE `testcdd` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `docente_id` INT(11) NOT NULL,
  `fecha` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `respuesta_1_1` CHAR(1) NOT NULL DEFAULT '',
  `respuesta_1_2` CHAR(1) NOT NULL DEFAULT '',
  `respuesta_1_3` CHAR(1) NOT NULL DEFAULT '',
  `respuesta_2_1` CHAR(1) NOT NULL DEFAULT '',
  `respuesta_2_2` CHAR(1) NOT NULL DEFAULT '',
  `respuesta_2_3` CHAR(1) NOT NULL DEFAULT '',
  `respuesta_2_4` CHAR(1) NOT NULL DEFAULT '',
  `respuesta_2_5` CHAR(1) NOT NULL DEFAULT '',
  `respuesta_2_6` CHAR(1) NOT NULL DEFAULT '',
  `respuesta_3_1` CHAR(1) NOT NULL DEFAULT '',
  `respuesta_3_2` CHAR(1) NOT NULL DEFAULT '',
  `respuesta_3_3` CHAR(1) NOT NULL DEFAULT '',
  `respuesta_3_4` CHAR(1) NOT NULL DEFAULT '',
  `respuesta_4_1` CHAR(1) NOT NULL DEFAULT '',
  `respuesta_4_2` CHAR(1) NOT NULL DEFAULT '',
  `respuesta_4_3` CHAR(1) NOT NULL DEFAULT '',
  `respuesta_4_4` CHAR(1) NOT NULL DEFAULT '',
  `respuesta_5_1` CHAR(1) NOT NULL DEFAULT '',
  `respuesta_5_2` CHAR(1) NOT NULL DEFAULT '',
  `respuesta_5_3` CHAR(1) NOT NULL DEFAULT '',
  `respuesta_5_4` CHAR(1) NOT NULL DEFAULT '',
  `area_0` TEXT DEFAULT NULL,
  `area_1` SMALLINT(6) NOT NULL DEFAULT 0,
  `area_2` SMALLINT(6) NOT NULL DEFAULT 0,
  `area_3` SMALLINT(6) NOT NULL DEFAULT 0,
  `area_4` SMALLINT(6) NOT NULL DEFAULT 0,
  `area_5` SMALLINT(6) NOT NULL DEFAULT 0,
  `finalMark` DECIMAL(3,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`id`),
  KEY `idx_docente_id_testcdd_respuestas` (`docente_id`),
  CONSTRAINT `fk_docente_id_testcdd_respuestas` FOREIGN KEY (`docente_id`) REFERENCES `docentes` (`usuario_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

/*Data for the table `testcdd` */

/*Table structure for table `testcdd_media` */

CREATE TABLE `testcdd_media` (
  `id` MEDIUMINT(9) NOT NULL AUTO_INCREMENT,
  `count` INT(11) NOT NULL,
  `area_1` DECIMAL(3,2) NOT NULL,
  `area_2` DECIMAL(3,2) NOT NULL,
  `area_3` DECIMAL(3,2) NOT NULL,
  `area_4` DECIMAL(3,2) NOT NULL,
  `area_5` DECIMAL(3,2) NOT NULL,
  `finalMark` DECIMAL(3,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

/*Data for the table `testcdd_media` */

/*Table structure for table `testcdd_media_centros` */

CREATE TABLE `testcdd_media_centros` (
  `centro_id` MEDIUMINT(9) UNSIGNED NOT NULL,
  `count` INT(11) NOT NULL,
  `area_1` DECIMAL(3,2) NOT NULL,
  `area_2` DECIMAL(3,2) NOT NULL,
  `area_3` DECIMAL(3,2) NOT NULL,
  `area_4` DECIMAL(3,2) NOT NULL,
  `area_5` DECIMAL(3,2) NOT NULL,
  `finalMark` DECIMAL(3,2) NOT NULL,
  PRIMARY KEY (`centro_id`),
  KEY `fk_media_centro_id` (`centro_id`)
) ENGINE=INNODB DEFAULT CHARSET=latin1;

/*Data for the table `testcdd_media_centros` */

/*Table structure for table `testcdd_media_instituciones` */

CREATE TABLE `testcdd_media_instituciones` (
  `institucion_id` SMALLINT(6) UNSIGNED NOT NULL,
  `count` INT(11) NOT NULL,
  `area_1` DECIMAL(3,2) NOT NULL,
  `area_2` DECIMAL(3,2) NOT NULL,
  `area_3` DECIMAL(3,2) NOT NULL,
  `area_4` DECIMAL(3,2) NOT NULL,
  `area_5` DECIMAL(3,2) NOT NULL,
  `finalMark` DECIMAL(3,2) NOT NULL,
  PRIMARY KEY (`institucion_id`)
) ENGINE=INNODB DEFAULT CHARSET=latin1;



CREATE TABLE `testcdd_ultima_calificacion` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `docente_id` INT(11) NOT NULL,
  `fecha` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `area_1` SMALLINT(6) NOT NULL DEFAULT -1,
  `area_2` SMALLINT(6) NOT NULL DEFAULT -1,
  `area_3` SMALLINT(6) NOT NULL DEFAULT -1,
  `area_4` SMALLINT(6) NOT NULL DEFAULT -1,
  `area_5` SMALLINT(6) NOT NULL DEFAULT -1,
  `finalMark` DECIMAL(3,2) NOT NULL DEFAULT -1.00,
  PRIMARY KEY (`id`),
  KEY `idx_docente_id_testCDD_ultima_calificacion` (`docente_id`),
  CONSTRAINT `fk_docente_id_testCDD_ultima_calificacion` FOREIGN KEY (`docente_id`) REFERENCES `docentes` (`usuario_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=INNODB DEFAULT CHARSET=latin1;



DELIMITER $$

 CREATE  TRIGGER `update_media` AFTER INSERT ON `testcdd` FOR EACH ROW BEGIN
	DECLARE centro_id_aux INT;
	DECLARE institucion_id_aux INT;
	SET centro_id_aux = (SELECT centro_id  FROM docentes WHERE usuario_id = NEW.docente_id);
	SET institucion_id_aux = (SELECT institucion_id  FROM centros WHERE id = centro_id_aux);
	
	-- Insertamos en el docente el ID de su última calificación
	UPDATE docentes SET testCdd_ultimo_test = NEW.id WHERE usuario_id=NEW.docente_id;
	
	-- Actualizamos la media global
	INSERT INTO testcdd_media (id, `count`,     area_1,     area_2,     area_3,    area_4,     area_5, area_6,      finalMark) 
	VALUES 			  (1, 1,     NEW.area_1, NEW.area_2, NEW.area_3, NEW.area_4, NEW.area_5, NEW.area_6, NEW.finalMark)
	ON DUPLICATE KEY UPDATE 
	area_1=((area_1*`count`) + NEW.area_1)/(`count`+1), 
	area_2=((area_2*`count`) + NEW.area_2)/(`count`+1), 
	area_3=((area_3*`count`) + NEW.area_3)/(`count`+1), 
	area_4=((area_4*`count`) + NEW.area_4)/(`count`+1), 
	area_5=((area_5*`count`) + NEW.area_5)/(`count`+1),
	area_6=((area_6*`count`) + NEW.area_6)/(`count`+1), 
-- Aqui nuevo trigger de area 6
	finalMark=((finalMark*`count`) + NEW.finalMark)/(`count`+1), 
	`count`=`count`+1;
	
	
	-- Actualizamos la media del centro
	INSERT INTO testcdd_media_centros (centro_id, `count`,     area_1,     area_2,     area_3,    area_4,     area_5, area_6,     finalMark) 
	VALUES 			  (centro_id_aux, 1,     NEW.area_1, NEW.area_2, NEW.area_3, NEW.area_4, NEW.area_5, NEW.area_6, NEW.finalMark)
	ON DUPLICATE KEY UPDATE 
	area_1=((area_1*`count`) + NEW.area_1)/(`count`+1), 
	area_2=((area_2*`count`) + NEW.area_2)/(`count`+1), 
	area_3=((area_3*`count`) + NEW.area_3)/(`count`+1), 
	area_4=((area_4*`count`) + NEW.area_4)/(`count`+1), 
	area_5=((area_5*`count`) + NEW.area_5)/(`count`+1), 
	area_6=((area_6*`count`) + NEW.area_6)/(`count`+1), 

	finalMark=((finalMark*`count`) + NEW.finalMark)/(`count`+1), 
	`count`=`count`+1;
	
	
	-- Actualizamos la media de la institución
	INSERT INTO testcdd_media_instituciones (institucion_id, `count`,     area_1,     area_2,     area_3,    area_4,     area_5,   area_6   finalMark) 
	VALUES 			  (institucion_id_aux, 1,     NEW.area_1, NEW.area_2, NEW.area_3, NEW.area_4, NEW.area_5, NEW.area_6, NEW.finalMark)
	ON DUPLICATE KEY UPDATE 
	area_1=((area_1*`count`) + NEW.area_1)/(`count`+1), 
	area_2=((area_2*`count`) + NEW.area_2)/(`count`+1), 
	area_3=((area_3*`count`) + NEW.area_3)/(`count`+1), 
	area_4=((area_4*`count`) + NEW.area_4)/(`count`+1), 
	area_5=((area_5*`count`) + NEW.area_5)/(`count`+1),
	area_6=((area_6*`count`) + NEW.area_6)/(`count`+1), 

	finalMark=((finalMark*`count`) + NEW.finalMark)/(`count`+1), 
	`count`=`count`+1;
	
    END $$


DELIMITER ;
