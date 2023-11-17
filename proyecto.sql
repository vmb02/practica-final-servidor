CREATE SCHEMA db_peliculas;
USE db_peliculas;

CREATE TABLE peliculas (
	id_pelicula NUMERIC(8,0) PRIMARY KEY,
    titulo VARCHAR(80) NOT NULL,
    fecha_estreno DATE NOT NULL,
    edad_recomendada VARCHAR(2) NOT NULL,
    CONSTRAINT chk_fecha_estreno CHECK (fecha_estreno > '1895-01-01'),
    CONSTRAINT chk_edad_recomendada CHECK (edad_recomendada IN('0', '3', '7', '12', '16', '18'))
);

SELECT * FROM PELICULAS;
DROP SCHEMA db_peliculas;

CREATE SCHEMA db_tienda;
USE db_tienda;

CREATE TABLE productos (
	idProducto INT(8) PRIMARY KEY AUTO_INCREMENT,
    nombreProducto VARCHAR(40) NOT NULL,
    precio NUMERIC(7,2) NOT NULL,
    descripcion VARCHAR(255) NOT NULL,
    cantidad NUMERIC(5,0) NOT NULL
);

CREATE TABLE usuarios (
	usuario VARCHAR(12) PRIMARY KEY,
    contrasena VARCHAR(255) NOT NULL,
    fechaNacimiento DATE NOT NULL
);

CREATE TABLE cestas (
	idCesta INT(8) PRIMARY KEY AUTO_INCREMENT,
    usuario VARCHAR(12) NOT NULL,
    precioTotal NUMERIC(7,2) NOT NULL DEFAULT 0,
    CONSTRAINT fk_cestas_usuarios
		FOREIGN KEY (usuario)
        REFERENCES usuarios(usuario)
);

CREATE TABLE productosCestas(
	idProducto INT(8),
    idCesta INT(8),
    cantidad INT(2) NOT NULL,
    CONSTRAINT pk_productosCestas
		PRIMARY KEY (idProducto, idCesta),
	CONSTRAINT fk_productosCestas_productos
		FOREIGN KEY (idProducto)
        REFERENCES productos(idProducto),
	CONSTRAINT fk_productosCestas_cestas
		FOREIGN KEY (idCesta)
        REFERENCES cestas(idCesta)
);

CREATE SCHEMA db_login;
USE db_login;

CREATE TABLE usuarios (
	usuario VARCHAR(20) PRIMARY KEY,
    contrasena VARCHAR(255) NOT NULL
);

USE db_tienda;
select * from productos;

USE db_peliculas;
ALTER TABLE peliculas
ADD COLUMN imagen VARCHAR(100);

select * from usuarios;
use db_tienda;
select * from usuarios;

USE db_tienda;
ALTER TABLE productos
ADD COLUMN imagen VARCHAR(100);

ALTER TABLE usuarios 
ADD COLUMN rol VARCHAR(10) DEFAULT 'cliente';

