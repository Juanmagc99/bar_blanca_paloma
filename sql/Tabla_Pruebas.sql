--Eliminacion Tablas

DROP TABLE LineaReposicion CASCADE CONSTRAINTS;
DROP TABLE LineaPedido CASCADE CONSTRAINTS;
DROP TABLE pedido CASCADE CONSTRAINTS;
DROP TABLE producto CASCADE CONSTRAINTS;
DROP TABLE carta CASCADE CONSTRAINTS;
DROP TABLE turno CASCADE CONSTRAINTS;
DROP TABLE LineaTurnos CASCADE CONSTRAINTS;
DROP TABLE proveedor CASCADE CONSTRAINTS;
DROP TABLE reserva CASCADE CONSTRAINTS;
DROP TABLE mesa CASCADE CONSTRAINTS;
DROP TABLE empleado CASCADE CONSTRAINTS;
DROP TABLE cliente CASCADE CONSTRAINTS;

--===================================== 
-- CREACIÓN DE TABLAS 
--==================================== 

CREATE TABLE cliente (
id_cliente INT, 
tlf_cliente VARCHAR(9) NOT NULL,  
nombre_cliente VARCHAR(50) NOT NULL,  
apellidos_cliente VARCHAR(50) NOT NULL,   
CONSTRAINT pk_id_cliente PRIMARY KEY(id_cliente) 
);

CREATE TABLE empleado (
DNI VARCHAR(9) NOT NULL,
NombreEmpleado VARCHAR(50) NOT NULL,
ApellidoEmpleado VARCHAR(50) NOT NULL,
telefono VARCHAR(9) NOT NULL,
Poblacion VARCHAR(50),
CodigoPostal INT,
FechaAlta DATE,
FechaBaja DATE,
HashContraseña VARCHAR(16),
SaltContraseña VARCHAR(16),
Categoria VARCHAR(10) NOT NULL CHECK (Categoria IN('GERENTE', 'CAMARERO', 'COCINERO')),
CONSTRAINT pk_DNI PRIMARY KEY(DNI)
);

CREATE TABLE mesa(
id_mesa INT NOT NULL,
tipo_mesa VARCHAR(10) NOT NULL CHECK (tipo_mesa IN('EXTERIOR', 'INTERIOR')),
capacidad INT,
dni_empleado1 VARCHAR(9),
CONSTRAINT pk_id_mesa PRIMARY KEY (id_mesa),
CONSTRAINT fk_dni_empleado1 FOREIGN KEY(dni_empleado1) REFERENCES empleado(DNI)
);

CREATE TABLE reserva (
id_reserva INT NOT NULL,
HoraEntrada_reserva DATE,
HoraSalida_reserva DATE,
id_cliente1 INT,
id_mesa1 INT, 
CONSTRAINT pk_id_reserva PRIMARY KEY(id_reserva),
CONSTRAINT fk_id_cliente1 FOREIGN KEY(id_cliente1) REFERENCES cliente(id_cliente),
CONSTRAINT fk_id_mesa1 FOREIGN KEY(id_mesa1) REFERENCES mesa(id_mesa)
);

CREATE TABLE proveedor (   
nombre_p VARCHAR(50) NOT NULL,  
Telefono_p VARCHAR(9) NOT NULL,  
CONSTRAINT pk_nombre_p PRIMARY KEY(nombre_p)  
);

CREATE TABLE LineaTurnos(
id_lineaturno INT,
Fecha_turno DATE,
DNI1 VARCHAR(9),
CONSTRAINT pk_id_lineaturno PRIMARY KEY(id_lineaturno),
CONSTRAINT fk_DNI1 FOREIGN KEY(DNI1) REFERENCES empleado (DNI) 
);  

CREATE TABLE turno(
id_turno INT NOT NULL,
tipo_turno VARCHAR(10) NOT NULL CHECK (tipo_turno IN('MAÑANA', 'TARDE', 'NOCHE')),
HoraEntrada DATE,
HoraSalida DATE,
id_lineaturno1 INT,
CONSTRAINT pk_id_turno PRIMARY KEY(id_turno),
CONSTRAINT fk_id_lineaturno1 FOREIGN KEY (id_lineaturno1) REFERENCES LineaTurnos(id_lineaturno)
); 

CREATE TABLE carta (
nombre_producto VARCHAR(20),
FechaInicio_carta DATE,
FechaFin_carta DATE,
CONSTRAINT pk_carta PRIMARY KEY(nombre_producto)
);

CREATE TABLE producto (
id_producto INT NOT NULL, 
nombre_producto1 VARCHAR(20),
precio_producto NUMBER NOT NULL, 
Descripcion VARCHAR(200), 
Cantidad INT,
CONSTRAINT pk_id_producto PRIMARY KEY(id_producto), 
CONSTRAINT fk_nombre_producto1 FOREIGN KEY(nombre_producto1) REFERENCES carta(nombre_producto)
);

CREATE TABLE pedido ( 
id_pedido INT,
id_mesa2 INT,
Fecha_pedido DATE,
estado_pedido VARCHAR(20),
importe INT,
CONSTRAINT pk_id_pedido PRIMARY KEY(id_pedido),
CONSTRAINT fk_id_mesa2 FOREIGN KEY(id_mesa2) REFERENCES mesa(id_mesa)
);

CREATE TABLE lineaPedido(
id_linea_pedido INT,
id_pedido1 INT,
nombre_producto2 VARCHAR(20),
cantidad_pedido INT,
CONSTRAINT pk_id_linea_pedido PRIMARY KEY(id_linea_pedido),
CONSTRAINT fk_nombre_producto2 FOREIGN KEY(nombre_producto2) REFERENCES carta(nombre_producto),
CONSTRAINT fk_id_pedido1 FOREIGN KEY(id_pedido1) REFERENCES pedido(id_pedido)
);

CREATE TABLE LineaReposicion(
id_reposicion INT NOT NULL, 
Cantidad_reposicion INT,
Fecha_reposicion DATE, 
nombre_p1 VARCHAR(50), 
id_producto1 INT, 
CONSTRAINT pk_id_reposicion PRIMARY KEY(id_reposicion),
CONSTRAINT fk_id_producto1 FOREIGN KEY(id_producto1) REFERENCES producto(id_producto), 
CONSTRAINT fk_nombre_p1 FOREIGN KEY(nombre_p1) REFERENCES proveedor(nombre_p) 
);


--===================================== 
-- CHECKERS
--===================================== 

ALTER SESSION SET NLS_DATE_FORMAT = 'YYYY-MM-DD HH24:MI';
ALTER TABLE cliente ADD CONSTRAINT CK_NUM_CLIENTE CHECK (REGEXP_LIKE(tlf_cliente, '^[0-9]{9}$')); 
   
ALTER TABLE empleado ADD CONSTRAINT CK_DNI_EMPLEADO CHECK (REGEXP_LIKE(DNI, '[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][A-Z]'));   
ALTER TABLE empleado ADD CONSTRAINT CK_NUM_EMPLEADO CHECK (REGEXP_LIKE(Telefono, '^[0-9]{9}$'));  
ALTER TABLE mesa ADD CONSTRAINT CK_DNI_EMPLEADO_MESA CHECK (REGEXP_LIKE(dni_empleado1, '[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][A-Z]')); 
ALTER TABLE mesa ADD CONSTRAINT CK_CANTIDAD_MESA CHECK ( capacidad >= 0);
ALTER TABLE proveedor ADD CONSTRAINT CK_NUM_PROVEEDOR CHECK (REGEXP_LIKE(Telefono_p, '^[0-9]{9}$'));    
ALTER TABLE LineaTurnos ADD CONSTRAINT CK_DNI_EMPLEADO_LINEATURNOS CHECK (REGEXP_LIKE(DNI1, '[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][A-Z]'));   
ALTER TABLE producto ADD CONSTRAINT CK_PRECIO_PRODUCTO CHECK ( precio_producto >= 0.0);
ALTER TABLE LineaReposicion ADD CONSTRAINT CK_REPOSICION CHECK ( Cantidad_reposicion >= 0);
ALTER TABLE lineaPedido ADD CONSTRAINT CK_PEDIDO CHECK (cantidad_pedido >= 0);
ALTER TABLE producto ADD CONSTRAINT CK_CANTIDAD_PRODUCTO CHECK ( Cantidad >= 0);
