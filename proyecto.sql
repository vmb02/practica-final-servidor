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

ALTER TABLE productos
ADD COLUMN imagen VARCHAR(100);

ALTER TABLE usuarios 
ADD COLUMN rol VARCHAR(10) DEFAULT 'cliente';

CREATE TABLE pedidos(
	idPedido INTEGER(8) PRIMARY KEY AUTO_INCREMENT,
    usuario VARCHAR(12) NOT NULL,
    precioTotal NUMERIC(7,2) NOT NULL,
    fechaPedido DATE NOT NULL,
    FOREIGN KEY (usuario) REFERENCES usuarios(usuario)
);


CREATE TABLE lineasPedidos(
	lineaPedido NUMERIC(2) NOT NULL,
    idProducto INTEGER(8) NOT NULL,
    idPedido INTEGER(8) NOT NULL,
    precioUnitario NUMERIC(7,2) NOT NULL,
    cantidad NUMERIC(2,0) NOT NULL,
    FOREIGN KEY (idPedido)
    REFERENCES pedidos(idPedido), 
    FOREIGN KEY (idProducto)
    REFERENCES productos(idProducto)
);

