

CREATE DATABASE testCdd;

CREATE USER 'testCdd'@'localhost' IDENTIFIED BY 'eUcd3UsmVIanAyn9';
GRANT SELECT, INSERT, UPDATE, DELETE ON testCdd.* TO 'testCdd'@'localhost';

--INSERT INTO `user`(cedula) VALUES ('1');

USE testCdd;

CREATE TABLE `usuarios` (
  `id` INT NOT NULL AUTO_INCREMENT, /* 2147483647 usuarios posibles */
  `email` VARCHAR(250) NOT NULL, /* Se pone antes para que las búsquedas sean más rápidas al ser un índice */
  `pass` VARCHAR(250) NOT NULL,  /* Revisar */
  `rol` enum('administrador','docente') NOT NULL DEFAULT 'docente',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `uq_usuario_email` (`email` ASC) /* Índice de email, evita email repetidos y acelera las búsquedas, relentiza las insercciones */
  );

  CREATE TABLE `resetpass` (
  `usuario_id` INT NOT NULL, /* usuario al que se le va a reiniciar la contraseña */
  `peticion_id` CHAR(100) NOT NULL, /*  */
  `fecha` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_hasta` DATETIME NOT NULL, -- Tiempo máximo que la petición es válida
  PRIMARY KEY (`usuario_id`),
  UNIQUE INDEX `uq_resetpass_peticion_id` (`peticion_id` ASC) /* No puede haber dos peticiones iguales */
  );

CREATE TABLE `instituciones` (
  `id` SMALLINT NOT NULL AUTO_INCREMENT, /* 32000 instituciones posibles */
  `nombre` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`)
  );
insert into `instituciones` (`nombre`) values ('Sin institución');

CREATE TABLE `centros` (
  `id` MEDIUMINT NOT NULL AUTO_INCREMENT, /* 8388607 centros posibles */
  `institucion_id` SMALLINT NOT NULL, /* Permitimos que sea null para que la insitución sea opcional */
  `codigoPostal` SMALLINT,
  `nombre` VARCHAR(100) NOT NULL,
  `codigo` VARCHAR(20) NOT NULL,
  `provincia` ENUM('Alava','Albacete','Alicante','Almería','Asturias','Avila','Badajoz','Barcelona','Burgos','Cáceres', 'Cádiz','Cantabria','Castellón','Ciudad Real','Córdoba','La Coruña','Cuenca','Gerona','Granada','Guadalajara', 'Guipúzcoa','Huelva','Huesca','Islas Baleares','Jaén','León','Lérida','Lugo','Madrid','Málaga','Murcia','Navarra', 'Orense','Palencia','Las Palmas','Pontevedra','La Rioja','Salamanca','Segovia','Sevilla','Soria','Tarragona', 'Santa Cruz de Tenerife','Teruel','Toledo','Valencia','Valladolid','Vizcaya','Zamora','Zaragoza'),
  `telefono` VARCHAR(20) NOT NULL,
  `email` VARCHAR(250) NOT NULL,
  `link` VARCHAR(250) NOT NULL,
  CONSTRAINT `fk_instituciones_institucion_id` FOREIGN KEY (`institucion_id`) REFERENCES `instituciones` (`id`),
  PRIMARY KEY (`id`)
  );
insert into `testCdd`.`centros` (`institucion_id`, `nombre`)	values	('1', 'Sin centro');


CREATE TABLE `etapas` (
  `id` SMALLINT NOT NULL AUTO_INCREMENT, /* 128 etapas posibles */
  `nombre` VARCHAR(50) NOT NULL,
  UNIQUE INDEX `uq_etapas` (`nombre` ASC), /* Evita tener etapas repetidas */

  PRIMARY KEY (`id`)
); 

INSERT INTO `etapas`(`nombre`) VALUES ('Infantil'); 
INSERT INTO `etapas`(`nombre`) VALUES ('Primer ciclo de primaria'); 
INSERT INTO `etapas`(`nombre`) VALUES ('Segundo ciclo de primaria'); 
INSERT INTO `etapas`(`nombre`) VALUES ('Tercer ciclo de primaria'); 
INSERT INTO `etapas`(`nombre`) VALUES ('Secundaria'); 
INSERT INTO `etapas`(`nombre`) VALUES ('Bachillerato'); 
INSERT INTO `etapas`(`nombre`) VALUES ('Ciclos formativos'); 
INSERT INTO `etapas`(`nombre`) VALUES ('Educación superior'); 
INSERT INTO `etapas`(`nombre`) VALUES ('Universitario'); 

/*
  Lengua, matemáticas, ciencias, ....
  Aquí se añadirán las áreas que no esten puestas y que los usuarios escriban en el apartado "otros"
*/
CREATE TABLE `areas` (
  `id` SMALLINT NOT NULL AUTO_INCREMENT, /* 128 etapas posibles */
  `nombre` VARCHAR(50) NOT NULL,
  UNIQUE INDEX `uq_areas` (`nombre` ASC), /* Evita tener areas repetidas */

  PRIMARY KEY (`id`)
); 

INSERT INTO `areas`(`nombre`) VALUES ('Prefiero no decirlo'); 
INSERT INTO `areas`(`nombre`) VALUES ('Ciencias'); 
INSERT INTO `areas`(`nombre`) VALUES ('Matemáticas'); 
INSERT INTO `areas`(`nombre`) VALUES ('Lengua'); 
INSERT INTO `areas`(`nombre`) VALUES ('Humanidades'); 
INSERT INTO `areas`(`nombre`) VALUES ('Lenguas extranjeras'); 
INSERT INTO `areas`(`nombre`) VALUES ('Educación Física'); 
INSERT INTO `areas`(`nombre`) VALUES ('PAS'); 


CREATE TABLE `docentes` (
  `usuario_id` INT NOT NULL, /* 2147483647 usuarios posibles */
  `centro_id` MEDIUMINT NOT NULL DEFAULT 1, /* Obligamos que todos los usuarios estén ligados a un centro */
  `nombre` VARCHAR(100) NOT NULL,
  `apellidos` VARCHAR(150) NOT NULL,
  `area_id` SMALLINT NULL DEFAULT NULL,
  `edad` TINYINT NOT NULL DEFAULT 0, 
  -- `edad` ENUM('No especificada', 'Menos de 25', 'Entre 25 y 35',  'Entre 35 y 45',  'Entre 45 y 55',  'Más de 55'),
  `estado` ENUM('Perfil incompleto', 'Hacer Area 0 TestCDD', 'Hacer TestCDD', 'Completo') NOT NULL DEFAULT 0, -- Estado del docente. 0: Sin terminar el resgistro. 1: registro completado y activo. 2: Suspendido
  /*
  estado 0: Se acaba de registrar y aún no ha hecho el test por primera vez. ==> Hacer Test con area 0
  estado 1: Activo, ya ha hecho el test. Puede actualizar el perfil sin mas.
  */
  `testCdd_ultima_calificacion` BIGINT NULL DEFAULT NULL,  -- Es la última calificacion del usuario, permite saber qué obtuvo en su último test
  PRIMARY KEY (`usuario_id`),
  CONSTRAINT `fk_docente_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  CONSTRAINT `fk_docente_centro` FOREIGN KEY (`centro_id`) REFERENCES `centros` (`id`),
  CONSTRAINT `fk_docente_testcdd_ultima_calificacion` FOREIGN KEY (`testCdd_ultima_calificacion`) REFERENCES `testCDD_calificaciones` (`id`),
  CONSTRAINT `fk_docente_area` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`)
);


CREATE TABLE `docentes_etapas` (
  `docente_id` INT NOT NULL,
  `etapa_id` SMALLINT NOT NULL,
  PRIMARY KEY (`docente_id`, `etapa_id`),
  CONSTRAINT `fk_docentes_etapas_docente` FOREIGN KEY (`docente_id`) REFERENCES `docentes` (`usuario_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_docente_etapas_etapas` FOREIGN KEY (`etapa_id`) REFERENCES `etapas` (`id`)

);


/* Tablas del test CDD */

CREATE TABLE `testCDD_area0` ( -- Permitimos que le área 0 se desliguie del testcdd persé, da más flexibilidad
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `docente_id` INT NOT NULL,
  `respuesta_1` TINYINT NOT NULL,
  `respuesta_2` TINYINT NOT NULL,
  `respuesta_3` TINYINT NOT NULL,
  `respuesta_4` TINYINT NOT NULL,
  `comentario` TEXT,
  `fecha` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_testcdd_area0_docente_id` (`docente_id` ASC),
  CONSTRAINT `fk_testcdd_area0_docente` FOREIGN KEY (`docente_id`) REFERENCES `docentes` (`usuario_id`) ON DELETE CASCADE ON UPDATE NO ACTION

);



CREATE TABLE `testCDD_respuestas` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `docente_id` INT NOT NULL,
  `fecha` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `area0` TEXT,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_docente_id_testcdd_respuestas` FOREIGN KEY (`docente_id`) REFERENCES `docentes` (`usuario_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  INDEX `idx_docente_id_testcdd_respuestas` (`docente_id` ASC)
);

{{testCDD_respuestas}}

{{testCDD_calificaciones}}


CREATE TABLE `testCDD_calificaciones` (
  `respuesta_id` BIGINT NOT NULL,
  `docente_id` INT NOT NULL,
  `fecha` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_docente_id_testcdd_calificaciones` FOREIGN KEY (`docente_id`) REFERENCES `docentes` (`usuario_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_respuesta_id_testcdd_calificaciones` FOREIGN KEY (`respuesta_id`) REFERENCES `testCDD_respuestas` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  INDEX `idx_docente_id_testcdd_calificaciones` (`docente_id` ASC)
);


/* Si se añaden más test, se queda la tabla de docentes muy grande */
CREATE TABLE `testCDD_ultima_calificacion` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `docente_id` INT NOT NULL,
  `fecha` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_docente_id_testCDD_ultima_calificacion` FOREIGN KEY (`docente_id`) REFERENCES `docentes` (`usuario_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  INDEX `idx_docente_id_testCDD_ultima_calificacion` (`docente_id` ASC)
);


/* Generar el el resto de columnas con programación */

{{testCDD_ultima_calificacion}}


CREATE TABLE `testCDD_media` (
  `id` MEDIUMINT NOT NULL AUTO_INCREMENT,
  `count` INT NOT NULL,
  CONSTRAINT `fk_media_id` FOREIGN KEY (`centro_id`) REFERENCES `centros` (`id`),

  PRIMARY KEY (`id`)
);

{{testCDD_media}}

CREATE TABLE `testCDD_media_centros` (
  `id` MEDIUMINT NOT NULL AUTO_INCREMENT,
  `centro_id` MEDIUMINT NOT NULL, /* Obligamos quelas medias estén ligadas a un centro */
  `count` INT NOT NULL,
  CONSTRAINT `fk_media_centro_id` FOREIGN KEY (`centro_id`) REFERENCES `centros` (`id`),

  PRIMARY KEY (`id`)
);

CREATE TABLE `testCDD_media_institucion` (
  `id` MEDIUMINT NOT NULL AUTO_INCREMENT,
  `institucion_id` MEDIUMINT NOT NULL, /* Obligamos quelas medias estén ligadas a un centro */
  `count` INT NOT NULL,
  CONSTRAINT `fk_media_institucion_id` FOREIGN KEY (`institucion_id`) REFERENCES `instituciones` (`id`),

  PRIMARY KEY (`id`)
);

/* separamos unos test incompletos de otros para facilitar y unificar los tests */
/*
  Tabla para guardar datos temporales de los usuarios
*/
CREATE TABLE `tempData` (
  `docente_id` INT NOT NULL,
  `key` VARCHAR(70) NOT NULL,
  `data` TEXT NOT NULL,
  PRIMARY KEY (`docente_id`, `key`)
);



/* Triggers */


DELIMITER $$
USE `testcdd`$$

DROP TRIGGER IF EXISTS update_media$$

CREATE
    /*!50017 DEFINER = 'root'@'localhost' */
    TRIGGER `update_media` AFTER INSERT ON `testCDD` 
    FOR EACH ROW BEGIN
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
	
    END;
$$

DELIMITER ;
