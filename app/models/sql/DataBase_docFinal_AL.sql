

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

CREATE TABLE `instituciones` (
  `id` SMALLINT NOT NULL AUTO_INCREMENT, /* 32000 instituciones posibles */
  `nombre` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`)
  );

CREATE TABLE `centros` (
  `id` MEDIUMINT NOT NULL AUTO_INCREMENT, /* 8388607 centros posibles */
  `institucion_id` SMALLINT NOT NULL, /* Permitimos que sea null para que la insitución sea opcional */
  `nombre` VARCHAR(100) NOT NULL,
  `codigo` VARCHAR(20) NOT NULL,
  `provincia` ENUM('Alava','Albacete','Alicante','Almería','Asturias','Avila','Badajoz','Barcelona','Burgos','Cáceres', 'Cádiz','Cantabria','Castellón','Ciudad Real','Córdoba','La Coruña','Cuenca','Gerona','Granada','Guadalajara', 'Guipúzcoa','Huelva','Huesca','Islas Baleares','Jaén','León','Lérida','Lugo','Madrid','Málaga','Murcia','Navarra', 'Orense','Palencia','Las Palmas','Pontevedra','La Rioja','Salamanca','Segovia','Sevilla','Soria','Tarragona', 'Santa Cruz de Tenerife','Teruel','Toledo','Valencia','Valladolid','Vizcaya','Zamora','Zaragoza'),
  `telefono` VARCHAR(20) NOT NULL,
  `email` VARCHAR(250) NOT NULL,
  `link` VARCHAR(250) NOT NULL,
  CONSTRAINT `fk_instituciones_institucion_id` FOREIGN KEY (`institucion_id`) REFERENCES `instituciones` (`id`),
  PRIMARY KEY (`id`)
  );

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

INSERT INTO `areas`(`nombre`) VALUES ('Ciencias'); 
INSERT INTO `areas`(`nombre`) VALUES ('Matemáticas'); 
INSERT INTO `areas`(`nombre`) VALUES ('Lengua'); 
INSERT INTO `areas`(`nombre`) VALUES ('Humanidades'); 
INSERT INTO `areas`(`nombre`) VALUES ('Lenguas extranjeras'); 
INSERT INTO `areas`(`nombre`) VALUES ('Educación Física'); 
INSERT INTO `areas`(`nombre`) VALUES ('PAS'); 


CREATE TABLE `docentes` (
  `usuario_id` INT NOT NULL, /* 2147483647 usuarios posibles */
  `centro_id` MEDIUMINT NOT NULL, /* Obligamos que todos los usuarios estén ligados a un centro */
  `nombre` VARCHAR(100) NOT NULL,
  `apellidos` VARCHAR(150) NOT NULL,
  `area_id` SMALLINT NOT NULL,
  `edad` ENUM('No especificada', 'Menos de 25', 'Entre 25 y 35',  'Entre 35 y 45',  'Entre 45 y 55',  'Más de 55'),
  `estado` TINYINT NOT NULL DEFAULT 0, -- Estado del docente. 0: Sin terminar el resgistro. 1: registro completado y activo. 2: Suspendido
  PRIMARY KEY (`usuario_id`),
  CONSTRAINT `fk_docente_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  CONSTRAINT `fk_docente_centro` FOREIGN KEY (`centro_id`) REFERENCES `centros` (`id`),
  CONSTRAINT `fk_docente_area` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`)
);


CREATE TABLE `docentes_etapas` (
  `docente_id` INT NOT NULL,
  `etapa_id` SMALLINT NOT NULL,
  PRIMARY KEY (`docente_id`, `etapa_id`),
  CONSTRAINT `fk_docentes_etapas_docente` FOREIGN KEY (`docente_id`) REFERENCES `docentes` (`usuario_id`),
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
  
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_docente_id_testcdd_respuestas` FOREIGN KEY (`docente_id`) REFERENCES `docentes` (`usuario_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  INDEX `idx_docente_id_testcdd_respuestas` (`docente_id` ASC)
);

ALTER TABLE testCDD_respuestas ADD respuesta_1_1 CHAR(1) NOT NULL DEFAULT '';
ALTER TABLE testCDD_respuestas ADD respuesta_1_2 CHAR(1) NOT NULL DEFAULT '';
ALTER TABLE testCDD_respuestas ADD respuesta_1_3 CHAR(1) NOT NULL DEFAULT '';
ALTER TABLE testCDD_respuestas ADD respuesta_2_1 CHAR(1) NOT NULL DEFAULT '';
ALTER TABLE testCDD_respuestas ADD respuesta_2_2 CHAR(1) NOT NULL DEFAULT '';
ALTER TABLE testCDD_respuestas ADD respuesta_2_3 CHAR(1) NOT NULL DEFAULT '';
ALTER TABLE testCDD_respuestas ADD respuesta_2_4 CHAR(1) NOT NULL DEFAULT '';
ALTER TABLE testCDD_respuestas ADD respuesta_2_5 CHAR(1) NOT NULL DEFAULT '';
ALTER TABLE testCDD_respuestas ADD respuesta_2_6 CHAR(1) NOT NULL DEFAULT '';
ALTER TABLE testCDD_respuestas ADD respuesta_3_1 CHAR(1) NOT NULL DEFAULT '';
ALTER TABLE testCDD_respuestas ADD respuesta_3_2 CHAR(1) NOT NULL DEFAULT '';
ALTER TABLE testCDD_respuestas ADD respuesta_3_3 CHAR(1) NOT NULL DEFAULT '';
ALTER TABLE testCDD_respuestas ADD respuesta_3_4 CHAR(1) NOT NULL DEFAULT '';
ALTER TABLE testCDD_respuestas ADD respuesta_4_1 CHAR(1) NOT NULL DEFAULT '';
ALTER TABLE testCDD_respuestas ADD respuesta_4_2 CHAR(1) NOT NULL DEFAULT '';
ALTER TABLE testCDD_respuestas ADD respuesta_4_3 CHAR(1) NOT NULL DEFAULT '';
ALTER TABLE testCDD_respuestas ADD respuesta_4_4 CHAR(1) NOT NULL DEFAULT '';
ALTER TABLE testCDD_respuestas ADD respuesta_5_1 CHAR(1) NOT NULL DEFAULT '';
ALTER TABLE testCDD_respuestas ADD respuesta_5_2 CHAR(1) NOT NULL DEFAULT '';
ALTER TABLE testCDD_respuestas ADD respuesta_5_3 CHAR(1) NOT NULL DEFAULT '';
ALTER TABLE testCDD_respuestas ADD respuesta_5_4 CHAR(1) NOT NULL DEFAULT '';


CREATE TABLE `testCDD_calificaciones` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `docente_id` INT NOT NULL,
  `fecha` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_docente_id_testcdd_calificaciones` FOREIGN KEY (`docente_id`) REFERENCES `docentes` (`usuario_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  INDEX `idx_docente_id_testcdd_calificaciones` (`docente_id` ASC)
);

ALTER TABLE testCDD_calificaciones ADD area_1 SMALLINT NOT NULL DEFAULT 0;
ALTER TABLE testCDD_calificaciones ADD area_2 SMALLINT NOT NULL DEFAULT 0;
ALTER TABLE testCDD_calificaciones ADD area_3 SMALLINT NOT NULL DEFAULT 0;
ALTER TABLE testCDD_calificaciones ADD area_4 SMALLINT NOT NULL DEFAULT 0;
ALTER TABLE testCDD_calificaciones ADD area_5 SMALLINT NOT NULL DEFAULT 0;
ALTER TABLE testCDD_calificaciones ADD finalMark DECIMAL(3,2) NOT NULL DEFAULT 0;


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

ALTER TABLE testCDD_ultima_calificacion ADD area_1 SMALLINT NOT NULL DEFAULT -1;
ALTER TABLE testCDD_ultima_calificacion ADD area_2 SMALLINT NOT NULL DEFAULT -1;
ALTER TABLE testCDD_ultima_calificacion ADD area_3 SMALLINT NOT NULL DEFAULT -1;
ALTER TABLE testCDD_ultima_calificacion ADD area_4 SMALLINT NOT NULL DEFAULT -1;
ALTER TABLE testCDD_ultima_calificacion ADD area_5 SMALLINT NOT NULL DEFAULT -1;
ALTER TABLE testCDD_ultima_calificacion ADD finalMark DECIMAL(3,2) NOT NULL DEFAULT -1;



CREATE TABLE `testCDD_media` (
  `id` MEDIUMINT NOT NULL AUTO_INCREMENT,
  `centro_id` MEDIUMINT NOT NULL, /* Obligamos quelas medias estén ligadas a un centro */
  `count` INT NOT NULL,
  CONSTRAINT `fk_media_centro_id` FOREIGN KEY (`centro_id`) REFERENCES `centros` (`id`),

  PRIMARY KEY (`id`)
);

ALTER TABLE testCDD_media ADD area_1 DECIMAL(3,2) NOT NULL;
ALTER TABLE testCDD_media ADD area_2 DECIMAL(3,2) NOT NULL;
ALTER TABLE testCDD_media ADD area_3 DECIMAL(3,2) NOT NULL;
ALTER TABLE testCDD_media ADD area_4 DECIMAL(3,2) NOT NULL;
ALTER TABLE testCDD_media ADD area_5 DECIMAL(3,2) NOT NULL;
ALTER TABLE testCDD_media ADD finalMark DECIMAL(3,2) NOT NULL;
INSERT INTO testCDD_media(count, area_1, area_2, area_3, area_4, area_5, finalMark) VALUES (0, 0, 0, 0, 0, 0, 0);

/* separamos unos test incompletos de otros para facilitar y unificar los tests */
CREATE TABLE `testCDD_incompleto` (
  `user_id` INT NOT NULL,
  `data` TEXT NOT NULL,
  PRIMARY KEY (`user_id`)
);



