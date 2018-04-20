-- Tablas maestras :

-- @ db_nivel
-- @ db_genero
-- @ db_personal

-- Data Base name:
-- videocine

DROP DATABASE videocine;
CREATE DATABASE videocine;
USE videocine;

DROP TABLE IF EXISTS db_nivel;
CREATE TABLE db_nivel (
  `niv_id` smallint(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `niv_detalle` varchar(50) NOT NULL,
  `niv_key` varchar(70) NOT NULL,
  `niv_defi` text(50) NOT NULL,
  `niv_update` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, 
  UNIQUE (`niv_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


TRUNCATE TABLE db_nivel;
INSERT INTO db_nivel (niv_detalle) values ("Admin"),("Venta"),("Invitado");


DROP TABLE IF EXISTS db_genero;
CREATE TABLE db_genero (
  `gro_id` smallint(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `gro_detalle` varchar(100) NOT NULL,
  `gro_key` varchar(70) NOT NULL,
  `gro_update` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `gro_defi` text NOT NULL,
  UNIQUE (`gro_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

TRUNCATE TABLE db_genero;
INSERT INTO db_genero (gro_detalle) values ("Drama"),("Accion"),("Comedia");

DROP TABLE IF EXISTS db_personal;
CREATE TABLE db_personal (
  `prs_id` smallint(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `prs_nombre` varchar(50) NOT NULL,
  `prs_apellido` varchar(50) NOT NULL,
  `prs_documendo` char(8) NOT NULL,
  `prs_codigo` varchar(72) NOT NULL,
  `prs_update` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  
  UNIQUE (`prs_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

TRUNCATE TABLE db_personal;
INSERT INTO db_personal (prs_nombre,prs_apellido,prs_documendo,prs_codigo) VALUES ("Oscar","Chino Yuca","44802324","123456789123");
INSERT INTO db_personal (prs_nombre,prs_apellido,prs_documendo,prs_codigo) VALUES ("Martory","xxxxxxxxxx","01234587","123456789124");


DROP TABLE IF EXISTS db_acceso;
CREATE TABLE db_acceso (
  `acc_id` smallint(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `acc_login` varchar(100) NOT NULL,
  `acc_clave` varchar(100) NOT NULL, 
  `acc_personal` varchar(70) NOT NULL, 
  `acc_nivel` smallint(11) NOT NULL,
  `acc_update` TIMESTAMP DEFAULT CURRENT_TIMESTAMP    
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


TRUNCATE TABLE db_acceso;
INSERT INTO db_acceso (acc_login,acc_clave,acc_personal,acc_nivel) values ("oscar",PASSWORD('123'),"123456789123",1);
INSERT INTO db_acceso (acc_login,acc_clave,acc_personal,acc_nivel) values ("mar",PASSWORD('123'),"123456789124",2);


SELECT prs.prs_nombre, prs.prs_apellido, acc.acc_login, niv.niv_detalle FROM (db_acceso acc INNER JOIN db_personal prs ON prs.prs_codigo = acc.acc_perosonal) INNER JOIN db_nivel niv ON niv.niv_id = acc.acc_nivel;
SELECT count(*) FROM (db_acceso acc INNER JOIN db_personal prs ON prs.prs_codigo = acc.acc_personal) INNER JOIN db_nivel niv ON niv.niv_id = acc.acc_nivel;

-- Tablas foraneas

DROP TABLE IF EXISTS db_pelicula;
CREATE TABLE db_pelicula (
  `pel_id` smallint(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `pel_titulo` varchar(100) NOT NULL,
  `pel_director` varchar(100) NOT NULL,
  `pel_anio` YEAR NOT NULL,
  `pel_genero` smallint(11) NOT NULL,
  `pel_actor1` varchar(100) NOT NULL,
  `pel_actor2` varchar(100) NOT NULL,
  `pel_actor3` varchar(100) NOT NULL,
  `pel_poster` text NOT NULL,
  `pel_sinopsis` text NOT NULL,
  `pel_codigo` int(4) UNSIGNED ZEROFILL NOT NULL,
  `pel_usurio` int(11) NOT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8;

TRUNCATE TABLE db_pelicula;
INSERT INTO db_pelicula (pel_titulo,pel_director,pel_anio,pel_genero,pel_actor1,pel_poster,pel_sinopsis,pel_codigo,pel_usurio) values ("EL SILENCIO DE LOS INOCENTES","Jonathan Demme",'1991',1," Catherine Martin","http://localhost/d/sistemas/peliculas/inc/theme/videocine/recursos/img/demo.jpg","The Silence of the Lambs es una película estadounidense de 1991 de género thriller y terror. Fue dirigida por Jonathan Demme y presenta a Jodie Foster, Anthony Hopkins y Scott Glenn en los papeles principales",1);
INSERT INTO db_pelicula (pel_titulo,pel_director,pel_anio,pel_genero,pel_actor1,pel_poster,pel_sinopsis,pel_codigo) values ("EL TIGRE DE NOCHE","bOUQUT RIST",'1992',1," Miguel Mozqozo","http://localhost/d/sistemas/peliculas/inc/theme/videocine/recursos/img/demo.jpg","The Silence of the Lambs es una película estadounidense de 1991 de género thriller y terror. Fue dirigida por Jonathan Demme y presenta a Jodie Foster, Anthony Hopkins y Scott Glenn en los papeles principales",2);
INSERT INTO db_pelicula (pel_titulo,pel_director,pel_anio,pel_genero,pel_actor1,pel_poster,pel_sinopsis,pel_codigo) values ("DURO DE MATAR II","STIVEN SPILBERT",'2012',2," brus wilos","http://localhost/d/sistemas/peliculas/inc/theme/videocine/recursos/img/demo.jpg","The Silence of the Lambs es una película estadounidense de 1991 de género thriller y terror. Fue dirigida por Jonathan Demme y presenta a Jodie Foster, Anthony Hopkins y Scott Glenn en los papeles principales",1);
INSERT INTO db_pelicula (pel_titulo,pel_director,pel_anio,pel_genero,pel_actor1,pel_poster,pel_sinopsis,pel_codigo) values ("EL AMOR EN LOS TIEMPOS DEL COLERA","DESCONOCIDO",'1998',1,"MARTA LLASES","http://localhost/d/sistemas/peliculas/inc/theme/videocine/recursos/img/demo.jpg","The Silence of the Lambs es una película estadounidense de 1991 de género thriller y terror. Fue dirigida por Jonathan Demme y presenta a Jodie Foster, Anthony Hopkins y Scott Glenn en los papeles principales",3);




select CONCAT(SUBSTRING(g.gro_detalle, 1,1),"-", p.pel_codigo) AS cod, p.pel_codigo from db_pelicula p INNER JOIN db_genero g ON p.pel_genero = g.gro_id WHERE SUBSTRING(g.gro_detalle, 1,1) = "D" ORDER BY p.pel_codigo DESC LIMIT 0,5;
select CONCAT(SUBSTRING(g.gro_detalle, 1,1),"-", p.pel_codigo) AS cod, p.pel_codigo from db_pelicula p INNER JOIN db_genero g ON p.pel_genero = g.gro_id WHERE g.gro_id = 2 ORDER BY p.pel_codigo DESC LIMIT 0,1;

