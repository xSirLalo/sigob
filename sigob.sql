SET SESSION FOREIGN_KEY_CHECKS=0;

/* Drop Tables */

DROP TABLE IF EXISTS aportacion;
DROP TABLE IF EXISTS archivo;
DROP TABLE IF EXISTS archivo_categoria;
DROP TABLE IF EXISTS predio_colindancia;
DROP TABLE IF EXISTS predio;
DROP TABLE IF EXISTS contribuyente;
DROP TABLE IF EXISTS tabla_valor_construccion;




/* Create Tables */

CREATE TABLE aportacion
(
	id_aportacion bigint NOT NULL AUTO_INCREMENT,
	id_predio bigint NOT NULL,
	id_contribuyente bigint NOT NULL,
	pago float,
	fecha date,
	metros_terreno float,
	metros_construccion float,
	valor_terreno float,
	valor_construccion float,
	avaluo float,
	estatus int,
	created_at timestamp,
	updated_at timestamp,
	PRIMARY KEY (id_aportacion)
);


CREATE TABLE archivo
(
	id_archivo bigint NOT NULL AUTO_INCREMENT,
	id_contribuyente bigint NOT NULL,
	id_predio bigint NOT NULL,
	id_archivo_categoria bigint NOT NULL,
	file longblob,
	extension varchar(45),
	size varchar(45),
	created_at timestamp,
	updated_at timestamp,
	PRIMARY KEY (id_archivo)
);


CREATE TABLE archivo_categoria
(
	id_archivo_categoria bigint NOT NULL AUTO_INCREMENT,
	nombre varchar(255),
	created_at timestamp,
	updated_at timestamp,
	PRIMARY KEY (id_archivo_categoria)
);


CREATE TABLE contribuyente
(
	id_contribuyente bigint NOT NULL AUTO_INCREMENT,
	nombre varchar(255),
	apellido_paterno varchar(255),
	apellido_materno varchar(255),
	rfc varchar(255),
	curp varchar(255),
	genero int DEFAULT 0 NOT NULL,
	created_at timestamp,
	updated_at timestamp,
	PRIMARY KEY (id_contribuyente)
);


CREATE TABLE predio
(
	id_predio bigint NOT NULL AUTO_INCREMENT,
	id_contribuyente bigint NOT NULL,
	clave_catastral varchar(255),
	ubicacion varchar(255),
	titular varchar(255),
	titular_anterior varchar(255),
	created_at timestamp,
	updated_at timestamp,
	PRIMARY KEY (id_predio)
);


CREATE TABLE predio_colindancia
(
	id_predio_colindancia bigint NOT NULL AUTO_INCREMENT,
	id_predio bigint NOT NULL,
	medida_metros float,
	descripcion varchar(255),
	orientacion_geografica varchar(45),
	PRIMARY KEY (id_predio_colindancia)
);


CREATE TABLE tabla_valor_construccion
(
	id_tabla_valor_construccion bigint NOT NULL AUTO_INCREMENT,
	grupo varchar(255),
	caracteristicas varchar(255),
	costo float,
	PRIMARY KEY (id_tabla_valor_construccion)
);



/* Create Foreign Keys */

ALTER TABLE archivo
	ADD FOREIGN KEY (id_archivo_categoria)
	REFERENCES archivo_categoria (id_archivo_categoria)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE aportacion
	ADD FOREIGN KEY (id_contribuyente)
	REFERENCES contribuyente (id_contribuyente)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE archivo
	ADD FOREIGN KEY (id_contribuyente)
	REFERENCES contribuyente (id_contribuyente)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE predio
	ADD FOREIGN KEY (id_contribuyente)
	REFERENCES contribuyente (id_contribuyente)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE aportacion
	ADD FOREIGN KEY (id_predio)
	REFERENCES predio (id_predio)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE archivo
	ADD FOREIGN KEY (id_predio)
	REFERENCES predio (id_predio)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE predio_colindancia
	ADD FOREIGN KEY (id_predio)
	REFERENCES predio (id_predio)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;



