--=====================================
-- SECUENCIAS
--=====================================

DROP SEQUENCE sec_cliente;
CREATE SEQUENCE sec_cliente;

DROP SEQUENCE sec_producto;
CREATE SEQUENCE sec_producto;

DROP SEQUENCE sec_reserva;
CREATE SEQUENCE sec_reserva;

DROP SEQUENCE sec_mesa;
CREATE SEQUENCE sec_mesa;

DROP SEQUENCE sec_reposicion;
CREATE SEQUENCE sec_reposicion;

DROP SEQUENCE sec_lineareposicion;
CREATE SEQUENCE sec_lineareposicion;

DROP SEQUENCE sec_turno;
CREATE SEQUENCE sec_turno;

DROP SEQUENCE sec_lineaturnos;
CREATE SEQUENCE sec_lineaturnos;

DROP SEQUENCE sec_pedido;
CREATE SEQUENCE sec_pedido;

DROP SEQUENCE sec_lineapedido;
CREATE SEQUENCE sec_lineapedido;

--=====================================
-- ELIMINACIÓN DE TABLAS
--=====================================

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

--ALTER SESSION SET NLS_DATE_FORMAT = 'YYYY-MM-DD HH24:MI';
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

--=====================================
-- PROCEDIMIENTOS
--=====================================
create or replace PROCEDURE BORRAR_CLIENTE(id_cliente_a_quitar IN cliente.id_cliente%TYPE) IS
BEGIN
    DELETE FROM CLIENTE WHERE id_cliente = id_cliente_a_quitar;
END;
/
create or replace PROCEDURE BORRAR_PRODUCTO (nombre_producto_a_quitar IN carta.nombre_producto%TYPE) IS
BEGIN
    DELETE FROM PRODUCTO WHERE id_producto = (SELECT id_producto FROM PRODUCTO WHERE nombre_producto1 = nombre_producto_a_quitar);
    DELETE FROM CARTA WHERE nombre_producto = nombre_producto_a_quitar;
END;
/
create or replace PROCEDURE BORRAR_RESERVA(id_reserva_a_quitar IN reserva.id_reserva%TYPE) IS
BEGIN
    DELETE FROM RESERVA WHERE id_reserva = id_reserva_a_quitar;
END;
/
create or replace PROCEDURE EDITAR_RESERVA(id_r in reserva.id_reserva%TYPE, entrada in reserva.HoraEntrada_reserva%TYPE, salida in reserva.HoraSalida_reserva%TYPE, id_cliente in reserva.id_cliente1%TYPE, id_mesa in reserva.id_mesa1%TYPE)IS
BEGIN
	UPDATE RESERVA SET HoraEntrada_reserva = entrada, HoraSalida_reserva = salida, id_cliente1 = id_cliente, id_mesa1 = id_mesa
	WHERE id_reserva = id_r;
END;
/
create or replace PROCEDURE EDITAR_PRECIO(nombre_producto_mod in producto.nombre_producto1%TYPE, precio_producto_mod in producto.precio_producto%TYPE)IS
BEGIN
  UPDATE PRODUCTO SET precio_producto = precio_producto_mod WHERE nombre_producto1 = nombre_producto_mod;
END;
/
create or replace PROCEDURE EDITAR_CLIENTE(id_client in cliente.id_cliente%TYPE, tlf in cliente.tlf_cliente%TYPE, nombre in cliente.nombre_cliente%TYPE, apellidos in cliente.apellidos_cliente%TYPE)IS
BEGIN
	UPDATE CLIENTE  SET tlf_cliente = tlf, nombre_cliente = nombre, apellidos_cliente = apellidos
	WHERE id_cliente = id_client;
END;
/
CREATE OR REPLACE PROCEDURE add_empleado
(w_DNI VARCHAR,
w_NombreEmp VARCHAR,
w_ApellidoEmp VARCHAR,
w_telefono VARCHAR,
w_Poblacion VARCHAR,
w_CodigoPostal INT,
w_FechaAlta DATE,
w_FechaBaja DATE,
w_HashContraseña VARCHAR,
w_SaltContraseña VARCHAR,
w_Categoria VARCHAR)
IS
BEGIN
INSERT INTO empleado (DNI, NombreEmpleado, ApellidoEmpleado, telefono, Poblacion, CodigoPostal,
FechaAlta, FechaBaja, HashContraseña, SaltContraseña, Categoria)
VALUES (w_DNI, w_NombreEmp, w_ApellidoEmp, w_telefono, w_Poblacion, w_CodigoPostal, w_FechaAlta,
w_FechaBaja, w_HashContraseña, w_SaltContraseña, w_Categoria);
END add_empleado;
/
CREATE OR REPLACE PROCEDURE add_producto
(w_Nombre VARCHAR,
w_Precio_producto NUMBER,
w_Descripcion VARCHAR,
w_Cantidad INT)
IS
BEGIN
INSERT INTO producto(id_producto, nombre_producto1, precio_producto, Descripcion, Cantidad)
VALUES (sec_producto.currval, w_Nombre, w_Precio_producto, w_Descripcion, w_Cantidad);
END add_producto;
/
CREATE OR REPLACE PROCEDURE add_cliente
(w_tlf_cliente VARCHAR,
w_nombre_cliente VARCHAR,
w_apellidos_cliente VARCHAR)
IS
BEGIN
INSERT INTO cliente(id_cliente, tlf_cliente, nombre_cliente, apellidos_cliente)
VALUES (sec_cliente.currval, w_tlf_cliente, w_nombre_cliente, w_apellidos_cliente);
END add_cliente;
/
CREATE OR REPLACE PROCEDURE add_reserva
(w_HoraEntrada_reserva DATE,
w_HoraSalida_reserva DATE,
w_id_cliente1 INT,
w_id_mesa1 INT)
IS
BEGIN
INSERT INTO reserva(id_reserva, HoraEntrada_reserva, HoraSalida_reserva, id_cliente1, id_mesa1)
VALUES (sec_reserva.currval, w_HoraEntrada_reserva, w_HoraSalida_reserva, w_id_cliente1,
w_id_mesa1);
END add_reserva;
/
CREATE OR REPLACE PROCEDURE add_mesa
(w_tipo_mesa VARCHAR,
w_capacidad INT,
w_dni_empleado1 VARCHAR)
IS
BEGIN
INSERT INTO mesa(id_mesa,tipo_mesa,capacidad,dni_empleado1)
VALUES (sec_mesa.currval,w_tipo_mesa,w_capacidad,w_dni_empleado1);
END add_mesa;
/
CREATE OR REPLACE PROCEDURE add_proveedor
(w_nombre_p VARCHAR,
w_Telefono_p VARCHAR)
IS
BEGIN
INSERT INTO proveedor(nombre_p, Telefono_p)
VALUES (w_nombre_p, w_Telefono_p);
END add_proveedor;
/
CREATE OR REPLACE PROCEDURE add_pedido
(w_id_mesa2 INT)
IS
BEGIN
INSERT INTO pedido(id_pedido,id_mesa2,Fecha_pedido)
VALUES (sec_pedido.currval,w_id_mesa2,CURRENT_DATE);
END add_pedido;
/
CREATE OR REPLACE PROCEDURE add_lineapedido
(w_id_pedido1 INT,
w_nombre_producto2 VARCHAR,
w_cantidad_pedido INT)
IS
BEGIN
INSERT INTO lineapedido(id_linea_pedido,id_pedido1,nombre_producto2,cantidad_pedido)
VALUES (sec_lineapedido.currval,w_id_pedido1, w_nombre_producto2,w_cantidad_pedido);
END add_lineapedido;
/
CREATE OR REPLACE PROCEDURE add_lineareposicion
(w_Cantidad_reposicion INT,
w_nombre_p1 VARCHAR,
w_id_producto1 INT)
IS
BEGIN
INSERT INTO LineaReposicion(id_reposicion,cantidad_reposicion,Fecha_reposicion, nombre_p1,
id_producto1)
VALUES (sec_lineareposicion.currval,w_Cantidad_reposicion, CURRENT_DATE,w_nombre_p1,
w_id_producto1);
END add_lineareposicion;
/
CREATE OR REPLACE PROCEDURE add_producto_carta
(w_nombre_producto VARCHAR,
w_FechaInicio DATE,
w_FechaFin DATE)
IS
BEGIN
INSERT INTO carta(nombre_producto,FechaInicio_carta, FechaFin_carta)
VALUES (w_nombre_producto,w_FechaInicio, w_FechaFin);
END add_producto_carta;
/
CREATE OR REPLACE PROCEDURE add_turno
(w_tipo_turno VARCHAR,
w_HoraEntrada DATE,
w_HoraSalida DATE,
w_id_lineaturno1 INT)
IS
BEGIN
INSERT INTO turno(id_turno, tipo_turno, HoraEntrada, HoraSalida, id_lineaturno1)
VALUES (sec_turno.currval,w_tipo_turno,w_HoraEntrada,w_HoraSalida,w_id_lineaturno1);
END add_turno;
/
CREATE OR REPLACE PROCEDURE add_lineaturnos
(w_fecha_turno DATE,
w_DNI1 VARCHAR)
IS
BEGIN
INSERT INTO LineaTurnos(id_lineaturno, fecha_turno, DNI1)
VALUES (sec_lineaturnos.currval,w_fecha_turno, w_DNI1);
END add_lineaturnos;
/
CREATE OR REPLACE PROCEDURE producto_pedidos
    (w_fecha IN pedido.Fecha_pedido%TYPE)
AS
CURSOR cursor_pedido IS SELECT nombre_producto2,COUNT(nombre_producto2) AS value_occurrence
    FROM lineaPedido
    WHERE id_pedido1 = (SELECT id_pedido FROM pedido
    WHERE Fecha_pedido = w_fecha)
    GROUP BY nombre_producto2
    ORDER BY value_occurrence;
BEGIN
    FOR registro IN cursor_pedido LOOP
    DBMS_OUTPUT.PUT_LINE(registro.nombre_producto2 || registro.value_occurrence);
    END LOOP;
END;
/
CREATE OR REPLACE PROCEDURE reservas_por_mesa(w_id_mesa IN reserva.id_mesa1%TYPE)
AS
CURSOR cursor_reserva IS SELECT id_reserva,
    HoraEntrada_reserva,
    HoraSalida_reserva
    FROM reserva
    WHERE id_mesa1 = w_id_mesa;
BEGIN
    FOR registro IN cursor_reserva LOOP
    DBMS_OUTPUT.PUT_LINE(registro.id_reserva  ||' '|| registro.HoraEntrada_reserva ||' '
    ||registro.HoraSalida_reserva);
    END LOOP;
END;
/
CREATE OR REPLACE PROCEDURE reposiciones_por_producto
    (w_id_producto IN producto.id_producto%TYPE)
AS
CURSOR cursor_reposicion IS SELECT id_reposicion,
    cantidad_reposicion,
    Fecha_reposicion
    FROM LineaReposicion
    WHERE id_producto1 = w_id_producto
    ORDER BY Fecha_reposicion;
BEGIN
    FOR registro IN cursor_reposicion LOOP
    DBMS_OUTPUT.PUT_LINE(registro.id_reposicion ||' '|| registro.cantidad_reposicion  ||' '
    ||registro.Fecha_reposicion);
    END LOOP;
END;
/
CREATE OR REPLACE PROCEDURE reservas_de_cliente
    (w_telefono IN cliente.tlf_cliente%TYPE)
AS
CURSOR cursor_reserva_cliente IS SELECT id_mesa1,
    HoraEntrada_reserva,
    HoraSalida_reserva
    FROM reserva
    WHERE id_cliente1 = (SELECT id_cliente FROM cliente
    WHERE tlf_cliente = w_telefono);
BEGIN
    FOR registro IN cursor_reserva_cliente LOOP
    DBMS_OUTPUT.PUT_LINE(registro.id_mesa1 ||' '||registro.HoraEntrada_reserva|| ' '
    ||registro.HoraSalida_reserva);
    END LOOP;
END;
/
CREATE OR REPLACE PROCEDURE producto_pedidos
    (w_fecha IN pedido.Fecha_pedido%TYPE)
AS
CURSOR cursor_pedido IS SELECT nombre_producto2,COUNT(nombre_producto2) AS value_occurrence
    FROM lineaPedido
    WHERE id_pedido1 = (SELECT id_pedido FROM pedido
    WHERE Fecha_pedido = w_fecha)
    GROUP BY nombre_producto2
    ORDER BY value_occurrence;
BEGIN
    FOR registro IN cursor_pedido LOOP
    DBMS_OUTPUT.PUT_LINE(registro.nombre_producto2 ||' '|| registro.value_occurrence);
    END LOOP;
END;
/
create or replace PROCEDURE mesas_reservadas
AS
CURSOR cursor_mesas IS SELECT mesa.id_mesa,mesa.capacidad,COUNT(reserva.id_mesa1) AS
value_occurrence
    FROM mesa,reserva
    WHERE mesa.id_mesa = reserva.id_mesa1
    GROUP BY mesa.id_mesa,mesa.capacidad
    ORDER BY value_occurrence;
BEGIN
    FOR registro IN cursor_mesas LOOP
    DBMS_OUTPUT.PUT_LINE(registro.id_mesa ||' '|| registro.capacidad ||' '||
registro.value_occurrence);
    END LOOP;
END;
/
--=====================================
-- TRIGGERS
--=====================================
CREATE OR REPLACE TRIGGER GENERA_PK_CLIENTE
BEFORE INSERT ON cliente
FOR EACH ROW
BEGIN
SELECT sec_cliente.NEXTVAL INTO :NEW.id_cliente FROM DUAL;
END;
/
CREATE OR REPLACE TRIGGER GENERA_PK_LINEAPEDIDO
BEFORE INSERT ON lineapedido
FOR EACH ROW
BEGIN
SELECT sec_lineapedido.NEXTVAL INTO :NEW.id_linea_pedido FROM DUAL;
END;
/
CREATE OR REPLACE TRIGGER GENERA_PK_REPOSICION
BEFORE INSERT ON lineareposicion
FOR EACH ROW
BEGIN
SELECT sec_lineareposicion.NEXTVAL INTO :NEW.id_reposicion FROM DUAL;
END;
/
CREATE OR REPLACE TRIGGER GENERA_PK_LINEATURNOS
BEFORE INSERT ON lineaturnos
FOR EACH ROW
BEGIN
SELECT sec_lineaturnos.NEXTVAL INTO :NEW.id_lineaturno FROM DUAL;
END;
/
CREATE OR REPLACE TRIGGER GENERA_PK_MESA
BEFORE INSERT ON mesa
FOR EACH ROW
BEGIN
SELECT sec_mesa.NEXTVAL INTO :NEW.id_mesa FROM DUAL;
END;
/
CREATE OR REPLACE TRIGGER GENERA_PK_PEDIDO
BEFORE INSERT ON pedido
FOR EACH ROW
BEGIN
SELECT sec_pedido.NEXTVAL INTO :NEW.id_pedido FROM DUAL;
END;
/
CREATE OR REPLACE TRIGGER GENERA_PK_PRODUCTO
BEFORE INSERT ON producto
FOR EACH ROW
BEGIN
SELECT sec_producto.NEXTVAL INTO :NEW.id_producto FROM DUAL;
END;
/
CREATE OR REPLACE TRIGGER GENERA_PK_RESERVA
BEFORE INSERT ON reserva
FOR EACH ROW
BEGIN
SELECT sec_reserva.NEXTVAL INTO :NEW.id_reserva FROM DUAL;
END;
/
CREATE OR REPLACE TRIGGER GENERA_PK_TURNO
BEFORE INSERT ON turno
FOR EACH ROW
BEGIN
SELECT sec_turno.NEXTVAL INTO :NEW.id_turno FROM DUAL;
END;
/
CREATE OR REPLACE TRIGGER existencias
AFTER
UPDATE ON producto
FOR EACH ROW
DECLARE
cantidad_producto INT;
BEGIN
SELECT Cantidad INTO cantidad_producto
FROM producto;
IF (cantidad_producto = 0)
THEN raise_application_error
(-20600,'Sin existencias.');
END IF;
END;
/
CREATE OR REPLACE TRIGGER reposicion
AFTER
UPDATE ON LineaReposicion
FOR EACH ROW
DECLARE
fecha_hoy Date;
BEGIN
SELECT CURRENT_DATE INTO fecha_hoy FROM DUAL;
UPDATE LineaReposicion SET Fecha_reposicion = fecha_hoy;
END;
/
CREATE OR REPLACE TRIGGER puede_pedir
BEFORE
INSERT ON LineaPedido
FOR EACH ROW
DECLARE
cantidad_producto INT;
nombre_carta VARCHAR(20);
nombre_producto2 VARCHAR(20);
BEGIN
SELECT Cantidad INTO cantidad_producto FROM producto;
SELECT nombre_producto INTO nombre_carta FROM carta;
SELECT nombre_producto1 INTO nombre_producto2 FROM producto;
IF (cantidad_producto = 0 AND nombre_carta = nombre_producto2)
THEN raise_application_error
(-20600,'Sin existencias o fuera de carta.');
END IF;
END;
/
CREATE OR REPLACE TRIGGER incrementaStock
BEFORE UPDATE ON LineaReposicion
FOR EACH ROW
BEGIN
    UPDATE producto
    SET producto.Cantidad = producto.Cantidad + :NEW.Cantidad_reposicion
    WHERE producto.id_producto = :NEW.id_producto1;
END;
/
CREATE OR REPLACE TRIGGER decrementaStock
BEFORE UPDATE ON lineaPedido
FOR EACH ROW
BEGIN
    UPDATE producto
    SET producto.Cantidad = producto.Cantidad - :NEW.cantidad_pedido
    WHERE producto.nombre_producto1 = :NEW.nombre_producto2;
END;
/
CREATE OR REPLACE TRIGGER FechasReservas
BEFORE INSERT ON reserva
FOR EACH ROW
DECLARE
V_Res Integer;
BEGIN
 SELECT COUNT(*) INTO V_Res
 FROM reserva
 WHERE id_mesa1 = :NEW.id_mesa1
 AND (HoraEntrada_reserva, HoraSalida_reserva)
 OVERLAPS (:NEW.HoraEntrada_reserva, :NEW.HoraSalida_reserva);
 IF (V_Res >= 1)
 THEN RAISE_APPLICATION_ERROR(-20600,'Para dicha mesa ya existe una reserva concurrente');
 END IF;
END;
/
--=====================================
-- FUNCIONES
--=====================================

CREATE OR REPLACE FUNCTION producto_restante
    (w_nombre_producto1 IN VARCHAR)
    RETURN INT
    IS w_Cantidad INT;
BEGIN
    SELECT Cantidad INTO w_Cantidad FROM producto
    WHERE nombre_producto1 = w_nombre_producto1;
    RETURN w_Cantidad;
END producto_restante;
/
CREATE OR REPLACE FUNCTION ASSERT_EQUALS (SALIDA BOOLEAN, SALIDA_ESPERADA BOOLEAN) RETURN
VARCHAR2 AS
BEGIN
    IF (SALIDA = SALIDA_ESPERADA) THEN
        RETURN 'ÉXITO';
    ELSE
        RETURN 'FALLO';
    END IF;
END ASSERT_EQUALS;
/
CREATE OR REPLACE FUNCTION empleados_categoria
    (w_categoria IN empleado.Categoria%TYPE)
    RETURN INT
    IS w_numero_empleados INT;
BEGIN
    SELECT COUNT(DNI) INTO w_numero_empleados FROM empleado
    WHERE Categoria = w_categoria;
    RETURN w_numero_empleados;
END empleados_categoria;
/
CREATE OR REPLACE FUNCTION precio_linea_pedido
    (w_id_linea_pedido IN lineaPedido.id_linea_pedido%TYPE)
    RETURN NUMBER AS
    precio NUMBER;
    cantidad INT;
BEGIN
    SELECT producto.precio_producto, lineaPedido.Cantidad_pedido INTO precio, cantidad
    FROM producto,lineaPedido
    WHERE lineaPedido.id_linea_pedido = w_id_linea_pedido;
    RETURN precio * cantidad;
END precio_linea_pedido;
/
--=====================================
-- PAQUETES
--=====================================
CL SCR;
SET SERVEROUTPUT ON;

/*PAQUETE PRUEBAS PROVEEDOR*/
CREATE OR REPLACE PACKAGE PRUEBAS_PROVEEDOR AS
    PROCEDURE INICIALIZAR;
    PROCEDURE INSERTAR(nombre_prueba VARCHAR2,
                    w_nombre_p IN proveedor.nombre_p%TYPE,
                    w_Telefono_p IN proveedor.Telefono_p%TYPE,
                    salidaEsperada BOOLEAN);
    PROCEDURE ACTUALIZAR(nombre_prueba VARCHAR2,
                    w_nombre_p IN proveedor.nombre_p%TYPE,
                    w_Telefono_p IN proveedor.Telefono_p%TYPE,
                    salidaEsperada BOOLEAN);
    PROCEDURE ELIMINAR(nombre_prueba VARCHAR2,
                    w_nombre_p IN proveedor.nombre_p%TYPE,
                    salidaEsperada BOOLEAN);
END PRUEBAS_PROVEEDOR;
/
CREATE OR REPLACE PACKAGE BODY PRUEBAS_PROVEEDOR AS
/* INICIALIZACION */
    PROCEDURE INICIALIZAR AS
    BEGIN
        DELETE FROM cliente; --BORRAR DE LA TABLA
    END INICIALIZAR;
/* INSERTAR PROVEEDOR Y VER QUE SE HA HECHO CORRECTAMENTE */
    PROCEDURE INSERTAR(nombre_prueba VARCHAR2,
                    w_nombre_p IN proveedor.nombre_p%TYPE,
                    w_Telefono_p IN proveedor.Telefono_p%TYPE,
                    salidaEsperada BOOLEAN)
        AS
            SALIDA BOOLEAN := TRUE;
            prov proveedor%ROWTYPE;
        BEGIN
            add_proveedor(w_nombre_p, w_Telefono_p);
/* VER QUE SE HA HECHO CORRECTAMENTE */
            SELECT * INTO prov FROM proveedor WHERE nombre_p = w_nombre_p;
            IF (prov.Telefono_p <> w_Telefono_p) THEN
                SALIDA := FALSE;
            END IF;
            COMMIT WORK;

/* MOSTRAR RESULTADO DE LA PRUEBA */
            DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(SALIDA, salidaEsperada));

            EXCEPTION
            WHEN OTHERS THEN
                DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false, salidaEsperada));
                ROLLBACK;
    END INSERTAR;

    PROCEDURE ACTUALIZAR(nombre_prueba VARCHAR2,
                    w_nombre_p IN proveedor.nombre_p%TYPE,
                    w_Telefono_p IN proveedor.Telefono_p%TYPE,
                    salidaEsperada BOOLEAN)
        AS
            SALIDA BOOLEAN := TRUE;
            prov proveedor%ROWTYPE;
        BEGIN
            UPDATE proveedor SET Telefono_p=w_Telefono_p WHERE nombre_p = w_nombre_p;

/* VER QUE SE HA HECHO CORRECTAMENTE */
            SELECT * INTO prov FROM proveedor WHERE nombre_p = w_nombre_p;
            IF (prov.Telefono_p <> w_Telefono_p) THEN
                SALIDA := FALSE;
            END IF;
            COMMIT WORK;

/* MOSTRAR RESULTADO DE LA PRUEBA */
            DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(SALIDA, salidaEsperada));

            EXCEPTION
            WHEN OTHERS THEN
                DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false, salidaEsperada));
                ROLLBACK;
    END ACTUALIZAR;

    PROCEDURE ELIMINAR(nombre_prueba VARCHAR2,
                w_nombre_p IN proveedor.nombre_p%TYPE,
                salidaEsperada BOOLEAN)
        AS
            SALIDA BOOLEAN := TRUE;
            N_PROVEEDORES INTEGER;
        BEGIN
            DELETE FROM proveedor WHERE nombre_p=w_nombre_p;

/* VER QUE SE HA HECHO CORRECTAMENTE */
            SELECT COUNT(*) INTO N_PROVEEDORES FROM proveedor WHERE nombre_p=w_nombre_p;
            IF (N_PROVEEDORES <> 0) THEN
                SALIDA := FALSE;
            END IF;
            COMMIT WORK;
/* MOSTRAR RESULTADO DE LA PRUEBA */
            DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(SALIDA, salidaEsperada));
            EXCEPTION
            WHEN OTHERS THEN
                DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false, salidaEsperada));
                ROLLBACK;
    END ELIMINAR;
END PRUEBAS_PROVEEDOR;
/


/*PAQUETE PRUEBAS CLIENTE*/
CREATE OR REPLACE PACKAGE PRUEBAS_CLIENTE AS
    PROCEDURE INICIALIZAR;
    PROCEDURE INSERTAR(nombre_prueba VARCHAR2,
                    w_tlf_cliente IN cliente.tlf_cliente%TYPE,
                    w_nombre_cliente IN cliente.nombre_cliente%TYPE,
                    w_apellidos_cliente IN cliente.apellidos_cliente%TYPE,
                    salidaEsperada BOOLEAN);
    PROCEDURE ACTUALIZAR(nombre_prueba VARCHAR2,
                    w_id_cliente IN cliente.id_cliente%TYPE,
                    w_tlf_cliente IN cliente.tlf_cliente%TYPE,
                    w_nombre_cliente IN cliente.nombre_cliente%TYPE,
                    w_apellidos_cliente IN cliente.apellidos_cliente%TYPE,
                    salidaEsperada BOOLEAN);
    PROCEDURE ELIMINAR(nombre_prueba VARCHAR2,
                    w_id_cliente IN cliente.id_cliente%TYPE,
                    salidaEsperada BOOLEAN);
END PRUEBAS_CLIENTE;
/
CREATE OR REPLACE PACKAGE BODY PRUEBAS_CLIENTE AS
/* INICIALIZACION */
    PROCEDURE INICIALIZAR AS
    BEGIN
        DELETE FROM cliente; --BORRAR DE LA TABLA
    END INICIALIZAR;
/* INSERTAR Y VER QUE SE HA HECHO CORRECTAMENTE */
    PROCEDURE INSERTAR(nombre_prueba VARCHAR2,
                    w_tlf_cliente IN cliente.tlf_cliente%TYPE,
                    w_nombre_cliente IN cliente.nombre_cliente%TYPE,
                    w_apellidos_cliente IN cliente.apellidos_cliente%TYPE,
                    salidaEsperada BOOLEAN)
        AS
            SALIDA BOOLEAN := TRUE;
            w_cliente cliente%ROWTYPE;
            w_id_cliente INT;
        BEGIN
            INSERT INTO cliente(tlf_cliente, nombre_cliente, apellidos_cliente)
            VALUES (w_tlf_cliente, w_nombre_cliente, w_apellidos_cliente);
            w_id_cliente := sec_cliente.currval;
/* VER QUE SE HA HECHO CORRECTAMENTE */
            SELECT * INTO w_cliente FROM cliente WHERE id_cliente = w_id_cliente;
            IF (w_cliente.tlf_cliente <> w_tlf_cliente
                OR w_cliente.nombre_cliente <> w_nombre_cliente
                OR w_cliente.apellidos_cliente <> w_apellidos_cliente) THEN
                SALIDA := FALSE;
            END IF;
            COMMIT WORK;

/* MOSTRAR RESULTADO DE LA PRUEBA */
            DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(SALIDA, salidaEsperada));

            EXCEPTION
            WHEN OTHERS THEN
                DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false, salidaEsperada));
                ROLLBACK;
    END INSERTAR;

    PROCEDURE ACTUALIZAR(nombre_prueba VARCHAR2,
                    w_id_cliente IN cliente.id_cliente%TYPE,
                    w_tlf_cliente IN cliente.tlf_cliente%TYPE,
                    w_nombre_cliente IN cliente.nombre_cliente%TYPE,
                    w_apellidos_cliente IN cliente.apellidos_cliente%TYPE,
                    salidaEsperada BOOLEAN)
        AS
            SALIDA BOOLEAN := TRUE;
            w_cliente cliente%ROWTYPE;
        BEGIN
            UPDATE cliente SET tlf_cliente = w_tlf_cliente,
                    nombre_cliente = w_nombre_cliente,
                    apellidos_cliente = w_apellidos_cliente
                    WHERE id_cliente = w_id_cliente;

/* VER QUE SE HA HECHO CORRECTAMENTE */
            SELECT * INTO w_cliente FROM cliente WHERE id_cliente = w_id_cliente;
            IF (w_cliente.tlf_cliente <> w_tlf_cliente
                OR w_cliente.nombre_cliente <> w_nombre_cliente
                OR w_cliente.apellidos_cliente <> w_apellidos_cliente) THEN
                SALIDA := FALSE;
            END IF;
            COMMIT WORK;

/* MOSTRAR RESULTADO DE LA PRUEBA */
            DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(SALIDA, salidaEsperada));

            EXCEPTION
            WHEN OTHERS THEN
                DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false, salidaEsperada));
                ROLLBACK;
    END ACTUALIZAR;

    PROCEDURE ELIMINAR(nombre_prueba VARCHAR2,
                    w_id_cliente IN cliente.id_cliente%TYPE,
                    salidaEsperada BOOLEAN)
        AS
            SALIDA BOOLEAN := TRUE;
            N_CLIENTES INTEGER;
        BEGIN
            DELETE FROM cliente WHERE id_cliente = w_id_cliente;

/* VER QUE SE HA HECHO CORRECTAMENTE */
            SELECT COUNT(*) INTO N_CLIENTES FROM cliente WHERE id_cliente = w_id_cliente;
            IF (N_CLIENTES <> 0) THEN
                SALIDA := FALSE;
            END IF;
            COMMIT WORK;
/* MOSTRAR RESULTADO DE LA PRUEBA */
            DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(SALIDA, salidaEsperada));
            EXCEPTION
            WHEN OTHERS THEN
                DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false, salidaEsperada));
                ROLLBACK;
    END ELIMINAR;
END PRUEBAS_CLIENTE;
/



/*PAQUETE PRUEBAS LINEATURNOS*/
CREATE OR REPLACE PACKAGE PRUEBAS_LINEATURNOS AS
    PROCEDURE INICIALIZAR;
    PROCEDURE INSERTAR(nombre_prueba VARCHAR2,
                    w_fecha_turno IN LineaTurnos.fecha_turno %TYPE,
                    w_dni1 IN LineaTurnos.dni1%TYPE,
                    salidaEsperada BOOLEAN);
    PROCEDURE ACTUALIZAR(nombre_prueba VARCHAR2,
                    w_id_lineaturno IN LineaTurnos.id_lineaturno %TYPE,
                    w_fecha_turno IN LineaTurnos.fecha_turno %TYPE,
                    w_dni1 IN LineaTurnos.dni1%TYPE,
                    salidaEsperada BOOLEAN);
    PROCEDURE ELIMINAR(nombre_prueba VARCHAR2,
                    w_id_lineaturno IN LineaTurnos.id_lineaturno%TYPE,
                    salidaEsperada BOOLEAN);
END PRUEBAS_LINEATURNOS;
/
CREATE OR REPLACE PACKAGE BODY PRUEBAS_LINEATURNOS AS
/* INICIALIZACION */
    PROCEDURE INICIALIZAR AS
    BEGIN
        DELETE FROM LineaTurnos; --BORRAR DE LA TABLA
    END INICIALIZAR;
/* INSERTAR LINEATURNO Y VER QUE SE HA HECHO CORRECTAMENTE */
    PROCEDURE INSERTAR(nombre_prueba VARCHAR2,
                    w_fecha_turno IN LineaTurnos.fecha_turno %TYPE,
                    w_dni1 IN LineaTurnos.dni1%TYPE,
                    salidaEsperada BOOLEAN)
        AS
            SALIDA BOOLEAN := TRUE;
            lineturn LineaTurnos%ROWTYPE;
            w_id_lineaturno INT;
        BEGIN
            INSERT INTO LineaTurnos(fecha_turno, DNI1)
            VALUES (w_fecha_turno, w_DNI1);
            w_id_lineaturno := sec_lineaturnos.currval;
/* VER QUE SE HA HECHO CORRECTAMENTE */
            SELECT * INTO lineturn FROM LineaTurnos WHERE id_lineaturno = w_id_lineaturno;
            IF (lineturn.fecha_turno <> w_fecha_turno
                 OR lineturn.dni1 <> w_dni1) THEN
                SALIDA := FALSE;
            END IF;
            COMMIT WORK;

/* MOSTRAR RESULTADO DE LA PRUEBA */
            DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(SALIDA, salidaEsperada));

            EXCEPTION
            WHEN OTHERS THEN
                DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false, salidaEsperada));
                ROLLBACK;
    END INSERTAR;

    PROCEDURE ACTUALIZAR(nombre_prueba VARCHAR2,
                    w_id_lineaturno IN LineaTurnos.id_lineaturno %TYPE,
                    w_fecha_turno IN LineaTurnos.fecha_turno %TYPE,
                    w_dni1 IN LineaTurnos.dni1%TYPE,
                    salidaEsperada BOOLEAN)
        AS
            SALIDA BOOLEAN := TRUE;
            lineturn LineaTurnos%ROWTYPE;
        BEGIN
            UPDATE LineaTurnos SET fecha_turno=w_fecha_turno, dni1=w_dni1
            WHERE id_lineaturno = w_id_lineaturno;

/* VER QUE SE HA HECHO CORRECTAMENTE */
            SELECT * INTO lineturn FROM LineaTurnos WHERE id_lineaturno = w_id_lineaturno;
            IF (lineturn.fecha_turno <> w_fecha_turno
                 OR lineturn.dni1 <> w_dni1) THEN
                SALIDA := FALSE;
            END IF;
            COMMIT WORK;

/* MOSTRAR RESULTADO DE LA PRUEBA */
            DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(SALIDA, salidaEsperada));

            EXCEPTION
            WHEN OTHERS THEN
                DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false, salidaEsperada));
                ROLLBACK;
    END ACTUALIZAR;
    PROCEDURE ELIMINAR(nombre_prueba VARCHAR2,
                    w_id_lineaturno IN LineaTurnos.id_lineaturno%TYPE,
                    salidaEsperada BOOLEAN)
        AS
            SALIDA BOOLEAN := TRUE;
            N_LINEATURNO INTEGER;
        BEGIN
            DELETE FROM LineaTurnos WHERE id_lineaturno=w_id_lineaturno;

/* VER QUE SE HA HECHO CORRECTAMENTE */
            SELECT COUNT(*) INTO N_LINEATURNO FROM LineaTurnos WHERE
id_lineaturno=w_id_lineaturno;
            IF (N_LINEATURNO <> 0) THEN
                SALIDA := FALSE;
            END IF;
            COMMIT WORK;
/* MOSTRAR RESULTADO DE LA PRUEBA */
            DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(SALIDA, salidaEsperada));
            EXCEPTION
            WHEN OTHERS THEN
                DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false, salidaEsperada));
                ROLLBACK;
    END ELIMINAR;
END PRUEBAS_LINEATURNOS;
/


/*PAQUETE PRUEBAS LINEAREPOSICION*/
CREATE OR REPLACE PACKAGE PRUEBAS_LINEAREPOSICION AS
    PROCEDURE INICIALIZAR;
    PROCEDURE INSERTAR(nombre_prueba VARCHAR2,
                    w_cantidad IN LineaReposicion.cantidad_reposicion%TYPE,
                    w_nombre_prov IN LineaReposicion.nombre_p1%TYPE,
                    w_id_producto IN LineaReposicion.id_producto1%TYPE,
                    salidaEsperada BOOLEAN);
    PROCEDURE ACTUALIZAR(nombre_prueba VARCHAR2,
                    w_id_reposicion IN LineaReposicion.id_reposicion%TYPE,
                    w_cantidad IN LineaReposicion.cantidad_reposicion%TYPE,
                    w_nombre_prov IN LineaReposicion.nombre_p1%TYPE,
                    w_id_producto IN LineaReposicion.id_producto1%TYPE,
                    salidaEsperada BOOLEAN);
    PROCEDURE ELIMINAR(nombre_prueba VARCHAR2,
                    w_id_reposicion IN LineaReposicion.id_reposicion%TYPE,
                    salidaEsperada BOOLEAN);
END PRUEBAS_LINEAREPOSICION;
/
CREATE OR REPLACE PACKAGE BODY PRUEBAS_LINEAREPOSICION AS
/* INICIALIZACION */
    PROCEDURE INICIALIZAR AS
    BEGIN
        DELETE FROM LineaReposicion; --BORRAR DE LA TABLA
    END INICIALIZAR;
/* INSERTAR Y VER QUE SE HA HECHO CORRECTAMENTE */
    PROCEDURE INSERTAR(nombre_prueba VARCHAR2,
                    w_cantidad IN LineaReposicion.cantidad_reposicion%TYPE,
                    w_nombre_prov IN LineaReposicion.nombre_p1%TYPE,
                    w_id_producto IN LineaReposicion.id_producto1%TYPE,
                    salidaEsperada BOOLEAN)
        AS
            SALIDA BOOLEAN := TRUE;
            w_lineareposicion LineaReposicion%ROWTYPE;
            w_id_reposicion INT;
        BEGIN
            INSERT INTO LineaReposicion(cantidad_reposicion,Fecha_reposicion, nombre_p1, id_producto1)
            VALUES (w_cantidad, CURRENT_DATE,w_nombre_prov, w_id_producto);
            w_id_reposicion := sec_lineareposicion.currval;
/* VER QUE SE HA HECHO CORRECTAMENTE */
            SELECT * INTO w_lineareposicion FROM LineaReposicion WHERE id_reposicion =
w_id_reposicion;
            IF (w_lineareposicion.cantidad_reposicion <> w_cantidad
                OR w_lineareposicion.nombre_p1 <> w_nombre_prov
                OR w_lineareposicion.id_producto1 <> w_id_producto) THEN
                SALIDA := FALSE;
            END IF;
            COMMIT WORK;

/* MOSTRAR RESULTADO DE LA PRUEBA */
            DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(SALIDA, salidaEsperada));

            EXCEPTION
            WHEN OTHERS THEN
                DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false, salidaEsperada));
                ROLLBACK;
    END INSERTAR;

    PROCEDURE ACTUALIZAR(nombre_prueba VARCHAR2,
                    w_id_reposicion IN LineaReposicion.id_reposicion%TYPE,
                    w_cantidad IN LineaReposicion.cantidad_reposicion%TYPE,
                    w_nombre_prov IN LineaReposicion.nombre_p1%TYPE,
                    w_id_producto IN LineaReposicion.id_producto1%TYPE,
                    salidaEsperada BOOLEAN)
        AS
            SALIDA BOOLEAN := TRUE;
            w_lineareposicion LineaReposicion%ROWTYPE;
        BEGIN
            UPDATE LineaReposicion SET cantidad_reposicion = w_cantidad,
                    nombre_p1 = w_nombre_prov,
                    id_producto1 = w_id_producto
                    WHERE id_reposicion = w_id_reposicion;

/* VER QUE SE HA HECHO CORRECTAMENTE */
            SELECT * INTO w_lineareposicion FROM LineaReposicion WHERE id_reposicion =
w_id_reposicion;
            IF (w_lineareposicion.cantidad_reposicion <> w_cantidad
                OR w_lineareposicion.nombre_p1 <> w_nombre_prov
                OR w_lineareposicion.id_producto1 <> w_id_producto) THEN
                SALIDA := FALSE;
            END IF;
            COMMIT WORK;

/* MOSTRAR RESULTADO DE LA PRUEBA */
            DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(SALIDA, salidaEsperada));

            EXCEPTION
            WHEN OTHERS THEN
                DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false, salidaEsperada));
                ROLLBACK;
    END ACTUALIZAR;

    PROCEDURE ELIMINAR(nombre_prueba VARCHAR2,
                    w_id_reposicion IN LineaReposicion.id_reposicion%TYPE,
                    salidaEsperada BOOLEAN)
        AS
            SALIDA BOOLEAN := TRUE;
            N_LINEAREPOSICION INTEGER;
        BEGIN
            DELETE FROM LineaReposicion WHERE id_reposicion = w_id_reposicion;

/* VER QUE SE HA HECHO CORRECTAMENTE */
            SELECT COUNT(*) INTO N_LINEAREPOSICION FROM LineaReposicion WHERE id_reposicion =
w_id_reposicion;
            IF (N_LINEAREPOSICION <> 0) THEN
                SALIDA := FALSE;
            END IF;
            COMMIT WORK;
/* MOSTRAR RESULTADO DE LA PRUEBA */
            DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(SALIDA, salidaEsperada));
            EXCEPTION
            WHEN OTHERS THEN
                DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false, salidaEsperada));
                ROLLBACK;
    END ELIMINAR;
END PRUEBAS_LINEAREPOSICION;
/


/*PAQUETE PRUEBAS TURNO*/
CREATE OR REPLACE PACKAGE PRUEBAS_TURNO AS
    PROCEDURE INICIALIZAR;
    PROCEDURE INSERTAR(nombre_prueba VARCHAR2,
                    w_tipo_turno IN turno.tipo_turno%TYPE,
                    w_HoraEntrada IN turno.HoraEntrada%TYPE,
                    w_HoraSalida IN turno.HoraSalida%TYPE,
                    w_id_lineaturno1 IN turno.id_lineaturno1%TYPE,
                    salidaEsperada BOOLEAN);
    PROCEDURE ACTUALIZAR(nombre_prueba VARCHAR2,
                    w_id_turno IN turno.id_turno%TYPE,
                    w_tipo_turno IN turno.tipo_turno%TYPE,
                    w_HoraEntrada IN turno.HoraEntrada%TYPE,
                    w_HoraSalida IN turno.HoraSalida%TYPE,
                    w_id_lineaturno1 IN turno.id_lineaturno1%TYPE,
                    salidaEsperada BOOLEAN);
    PROCEDURE ELIMINAR(nombre_prueba VARCHAR2,
                    w_id_turno IN turno.id_turno%TYPE,
                    salidaEsperada BOOLEAN);
END PRUEBAS_TURNO;
/
CREATE OR REPLACE PACKAGE BODY PRUEBAS_TURNO AS
/* INICIALIZACION */
    PROCEDURE INICIALIZAR AS
    BEGIN
        DELETE FROM turno; --BORRAR DE LA TABLA
    END INICIALIZAR;
/* INSERTAR Y VER QUE SE HA HECHO CORRECTAMENTE */
    PROCEDURE INSERTAR(nombre_prueba VARCHAR2,
                    w_tipo_turno IN turno.tipo_turno%TYPE,
                    w_HoraEntrada IN turno.HoraEntrada%TYPE,
                    w_HoraSalida IN turno.HoraSalida%TYPE,
                    w_id_lineaturno1 IN turno.id_lineaturno1%TYPE,
                    salidaEsperada BOOLEAN)
        AS
            SALIDA BOOLEAN := TRUE;
            w_turno turno%ROWTYPE;
            w_id_turno INT;
        BEGIN
            INSERT INTO turno(tipo_turno, HoraEntrada, HoraSalida, id_lineaturno1)
            VALUES (w_tipo_turno,w_HoraEntrada,w_HoraSalida,w_id_lineaturno1);
            w_id_turno := sec_turno.currval;
/* VER QUE SE HA HECHO CORRECTAMENTE */
            SELECT * INTO w_turno FROM turno WHERE id_turno = w_id_turno;
            IF (w_turno.tipo_turno <> w_tipo_turno
                OR w_turno.HoraEntrada <> w_HoraEntrada
                OR w_turno.HoraSalida <> w_HoraSalida
                OR w_turno.id_lineaturno1 <> w_id_lineaturno1) THEN
                SALIDA := FALSE;
            END IF;
            COMMIT WORK;

/* MOSTRAR RESULTADO DE LA PRUEBA */
            DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(SALIDA, salidaEsperada));

            EXCEPTION
            WHEN OTHERS THEN
                DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false, salidaEsperada));
                ROLLBACK;
    END INSERTAR;

    PROCEDURE ACTUALIZAR(nombre_prueba VARCHAR2,
                    w_id_turno IN turno.id_turno%TYPE,
                    w_tipo_turno IN turno.tipo_turno%TYPE,
                    w_HoraEntrada IN turno.HoraEntrada%TYPE,
                    w_HoraSalida IN turno.HoraSalida%TYPE,
                    w_id_lineaturno1 IN turno.id_lineaturno1%TYPE,
                    salidaEsperada BOOLEAN)
        AS
            SALIDA BOOLEAN := TRUE;
            w_turno turno%ROWTYPE;
        BEGIN
            UPDATE turno SET tipo_turno = w_tipo_turno,
                    HoraEntrada = w_HoraEntrada,
                    HoraSalida = w_HoraSalida,
                    id_lineaturno1 = w_id_lineaturno1
                    WHERE id_turno = w_id_turno;

/* VER QUE SE HA HECHO CORRECTAMENTE */
            SELECT * INTO w_turno FROM turno WHERE id_turno = w_id_turno;
            IF (w_turno.tipo_turno <> w_tipo_turno
                OR w_turno.HoraEntrada <> w_HoraEntrada
                OR w_turno.HoraSalida <> w_HoraSalida
                OR w_turno.id_lineaturno1 <> w_id_lineaturno1) THEN
                SALIDA := FALSE;
            END IF;
            COMMIT WORK;

/* MOSTRAR RESULTADO DE LA PRUEBA */
            DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(SALIDA, salidaEsperada));

            EXCEPTION
            WHEN OTHERS THEN
                DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false, salidaEsperada));
                ROLLBACK;
    END ACTUALIZAR;

    PROCEDURE ELIMINAR(nombre_prueba VARCHAR2,
                    w_id_turno IN turno.id_turno%TYPE,
                    salidaEsperada BOOLEAN)
        AS
            SALIDA BOOLEAN := TRUE;
            N_TURNO INTEGER;
        BEGIN
            DELETE FROM turno WHERE id_turno = w_id_turno;

/* VER QUE SE HA HECHO CORRECTAMENTE */
            SELECT COUNT(*) INTO N_TURNO FROM turno WHERE id_turno = w_id_turno;
            IF (N_TURNO <> 0) THEN
                SALIDA := FALSE;
            END IF;
            COMMIT WORK;
/* MOSTRAR RESULTADO DE LA PRUEBA */
            DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(SALIDA, salidaEsperada));
            EXCEPTION
            WHEN OTHERS THEN
                DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false, salidaEsperada));
                ROLLBACK;
    END ELIMINAR;
END PRUEBAS_TURNO;
/



/*PAQUETE PRUEBAS RESERVA*/
CREATE OR REPLACE PACKAGE PRUEBAS_RESERVA AS
    PROCEDURE INICIALIZAR;
    PROCEDURE INSERTAR(nombre_prueba VARCHAR2,
                    w_HoraEntrada_reserva IN reserva.HoraEntrada_reserva%TYPE,
                    w_HoraSalida_reserva IN reserva.HoraSalida_reserva%TYPE,
                    w_id_cliente1 IN reserva.id_cliente1%TYPE,
                    w_id_mesa1 IN reserva.id_mesa1%TYPE,
                    salidaEsperada BOOLEAN);
    PROCEDURE ACTUALIZAR(nombre_prueba VARCHAR2,
                    w_id_reserva IN reserva.id_reserva%TYPE,
                    w_HoraEntrada_reserva IN reserva.HoraEntrada_reserva%TYPE,
                    w_HoraSalida_reserva IN reserva.HoraSalida_reserva%TYPE,
                    w_id_cliente1 IN reserva.id_cliente1%TYPE,
                    w_id_mesa1 IN reserva.id_mesa1%TYPE,
                    salidaEsperada BOOLEAN);
    PROCEDURE ELIMINAR(nombre_prueba VARCHAR2,
                    w_id_reserva IN reserva.id_reserva%TYPE,
                    salidaEsperada BOOLEAN);
END PRUEBAS_RESERVA;
/
CREATE OR REPLACE PACKAGE BODY PRUEBAS_RESERVA AS
/* INICIALIZACION */
    PROCEDURE INICIALIZAR AS
    BEGIN
        DELETE FROM reserva; --BORRAR DE LA TABLA
    END INICIALIZAR;
/* INSERTAR Y VER QUE SE HA HECHO CORRECTAMENTE */
    PROCEDURE INSERTAR(nombre_prueba VARCHAR2,
                    w_HoraEntrada_reserva IN reserva.HoraEntrada_reserva%TYPE,
                    w_HoraSalida_reserva IN reserva.HoraSalida_reserva%TYPE,
                    w_id_cliente1 IN reserva.id_cliente1%TYPE,
                    w_id_mesa1 IN reserva.id_mesa1%TYPE,
                    salidaEsperada BOOLEAN)
        AS
            SALIDA BOOLEAN := TRUE;
            w_reserva reserva%ROWTYPE;
            w_id_reserva INT;
        BEGIN
            INSERT INTO reserva( HoraEntrada_reserva, HoraSalida_reserva, id_cliente1, id_mesa1)
            VALUES ( w_HoraEntrada_reserva, w_HoraSalida_reserva, w_id_cliente1, w_id_mesa1);
            w_id_reserva := sec_reserva.currval;
/* VER QUE SE HA HECHO CORRECTAMENTE */
            SELECT * INTO w_reserva FROM reserva WHERE id_reserva = w_id_reserva;
            IF (w_reserva.HoraEntrada_reserva <> w_HoraEntrada_reserva
                OR w_reserva.HoraSalida_reserva <> w_HoraSalida_reserva
                OR w_reserva.id_cliente1 <> w_id_cliente1
                OR w_reserva.id_mesa1 <> w_id_mesa1) THEN
                SALIDA := FALSE;
            END IF;
            COMMIT WORK;

/* MOSTRAR RESULTADO DE LA PRUEBA */
            DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(SALIDA, salidaEsperada));

            EXCEPTION
            WHEN OTHERS THEN
                DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false, salidaEsperada));
                ROLLBACK;
    END INSERTAR;

   PROCEDURE ACTUALIZAR(nombre_prueba VARCHAR2,
                    w_id_reserva IN reserva.id_reserva%TYPE,
                    w_HoraEntrada_reserva IN reserva.HoraEntrada_reserva%TYPE,
                    w_HoraSalida_reserva IN reserva.HoraSalida_reserva%TYPE,
                    w_id_cliente1 IN reserva.id_cliente1%TYPE,
                    w_id_mesa1 IN reserva.id_mesa1%TYPE,
                    salidaEsperada BOOLEAN)
        AS
            SALIDA BOOLEAN := TRUE;
            w_reserva reserva%ROWTYPE;
        BEGIN
            UPDATE reserva SET HoraEntrada_reserva = w_HoraEntrada_reserva,
                    HoraSalida_reserva = w_HoraSalida_reserva,
                    id_cliente1 = w_id_cliente1,
                    id_mesa1 = w_id_mesa1
                    WHERE id_reserva = w_id_reserva;

/* VER QUE SE HA HECHO CORRECTAMENTE */
            SELECT * INTO w_reserva FROM reserva WHERE id_reserva = w_id_reserva;
            IF (w_reserva.HoraEntrada_reserva <> w_HoraEntrada_reserva
                OR w_reserva.HoraSalida_reserva <> w_HoraSalida_reserva
                OR w_reserva.id_cliente1 <> w_id_cliente1
                OR w_reserva.id_mesa1 <> w_id_mesa1) THEN
                SALIDA := FALSE;
            END IF;
            COMMIT WORK;

/* MOSTRAR RESULTADO DE LA PRUEBA */
            DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(SALIDA, salidaEsperada));

            EXCEPTION
            WHEN OTHERS THEN
                DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false, salidaEsperada));
                ROLLBACK;
    END ACTUALIZAR;

    PROCEDURE ELIMINAR(nombre_prueba VARCHAR2,
                    w_id_reserva IN reserva.id_reserva%TYPE,
                    salidaEsperada BOOLEAN)
        AS
            SALIDA BOOLEAN := TRUE;
            N_RESERVA INTEGER;
        BEGIN
            DELETE FROM reserva WHERE id_reserva = w_id_reserva;

/* VER QUE SE HA HECHO CORRECTAMENTE */
            SELECT COUNT(*) INTO N_RESERVA FROM reserva WHERE id_reserva = w_id_reserva;
            IF (N_RESERVA <> 0) THEN
                SALIDA := FALSE;
            END IF;
            COMMIT WORK;
/* MOSTRAR RESULTADO DE LA PRUEBA */
            DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(SALIDA, salidaEsperada));
            EXCEPTION
            WHEN OTHERS THEN
                DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false, salidaEsperada));
                ROLLBACK;
    END ELIMINAR;
END PRUEBAS_RESERVA;
/


/*PAQUETE PRUEBAS PRODUCTO*/
CREATE OR REPLACE PACKAGE PRUEBAS_PRODUCTO AS
    PROCEDURE INICIALIZAR;
    PROCEDURE INSERTAR(nombre_prueba VARCHAR2,
                    w_Nombre_producto1 IN producto.Nombre_producto1%TYPE,
                    w_Precio_producto IN producto.Precio_producto%TYPE,
                    w_Descripcion IN producto.Descripcion%TYPE,
                    w_Cantidad IN producto.Cantidad%TYPE,
                    salidaEsperada BOOLEAN);
    PROCEDURE ACTUALIZAR(nombre_prueba VARCHAR2,
                    w_id_producto IN producto.id_producto%TYPE,
                    w_Nombre_producto1 IN producto.Nombre_producto1%TYPE,
                    w_Precio_producto IN producto.Precio_producto%TYPE,
                    w_Descripcion IN producto.Descripcion%TYPE,
                    w_Cantidad IN producto.Cantidad%TYPE,
                    salidaEsperada BOOLEAN);
    PROCEDURE ELIMINAR(nombre_prueba VARCHAR2,
                    w_id_producto IN producto.id_producto%TYPE,
                    salidaEsperada BOOLEAN);
END PRUEBAS_PRODUCTO;
/
CREATE OR REPLACE PACKAGE BODY PRUEBAS_PRODUCTO AS
/* INICIALIZACION */
    PROCEDURE INICIALIZAR AS
    BEGIN
        DELETE FROM producto; --BORRAR DE LA TABLA
    END INICIALIZAR;
/* INSERTAR Y VER QUE SE HA HECHO CORRECTAMENTE */
    PROCEDURE INSERTAR(nombre_prueba VARCHAR2,
                    w_Nombre_producto1 IN producto.Nombre_producto1%TYPE,
                    w_Precio_producto IN producto.Precio_producto%TYPE,
                    w_Descripcion IN producto.Descripcion%TYPE,
                    w_Cantidad IN producto.Cantidad%TYPE,
                    salidaEsperada BOOLEAN)
        AS
            SALIDA BOOLEAN := TRUE;
            w_producto producto%ROWTYPE;
            w_id_producto INT;
        BEGIN
            INSERT INTO producto(Nombre_producto1, Precio_producto, Descripcion, Cantidad)
            VALUES ( w_Nombre_producto1, w_Precio_producto, w_Descripcion, w_Cantidad);
            w_id_producto := sec_producto.currval;
/* VER QUE SE HA HECHO CORRECTAMENTE */
            SELECT * INTO w_producto FROM producto WHERE id_producto = w_id_producto;
            IF (w_producto.Nombre_producto1 <> w_Nombre_producto1
                OR w_producto.Precio_producto <> w_Precio_producto
                OR w_producto.Descripcion <> w_Descripcion
                OR w_producto.Cantidad <> w_Cantidad) THEN
                SALIDA := FALSE;
            END IF;
            COMMIT WORK;

/* MOSTRAR RESULTADO DE LA PRUEBA */
            DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(SALIDA, salidaEsperada));

            EXCEPTION
            WHEN OTHERS THEN
                DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false, salidaEsperada));
                ROLLBACK;
    END INSERTAR;

   PROCEDURE ACTUALIZAR(nombre_prueba VARCHAR2,
                    w_id_producto IN producto.id_producto%TYPE,
                    w_Nombre_producto1 IN producto.Nombre_producto1%TYPE,
                    w_Precio_producto IN producto.Precio_producto%TYPE,
                    w_Descripcion IN producto.Descripcion%TYPE,
                    w_Cantidad IN producto.Cantidad%TYPE,
                    salidaEsperada BOOLEAN)
        AS
            SALIDA BOOLEAN := TRUE;
            w_producto producto%ROWTYPE;
        BEGIN
            UPDATE producto SET Nombre_producto1 = w_Nombre_producto1,
                    Precio_producto = w_Precio_producto,
                    Descripcion = w_Descripcion,
                    Cantidad = w_Cantidad
                    WHERE id_producto = w_id_producto;

/* VER QUE SE HA HECHO CORRECTAMENTE */
            SELECT * INTO w_producto FROM producto WHERE id_producto = w_id_producto;
            IF (w_producto.Nombre_producto1 <> w_Nombre_producto1
                OR w_producto.Precio_producto <> w_Precio_producto
                OR w_producto.Descripcion <> w_Descripcion
                OR w_producto.Cantidad <> w_Cantidad) THEN
                SALIDA := FALSE;
            END IF;
            COMMIT WORK;

/* MOSTRAR RESULTADO DE LA PRUEBA */
            DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(SALIDA, salidaEsperada));

            EXCEPTION
            WHEN OTHERS THEN
                DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false, salidaEsperada));
                ROLLBACK;
    END ACTUALIZAR;

    PROCEDURE ELIMINAR(nombre_prueba VARCHAR2,
                    w_id_producto IN producto.id_producto%TYPE,
                    salidaEsperada BOOLEAN)
        AS
            SALIDA BOOLEAN := TRUE;
            N_PRODUCTO INTEGER;
        BEGIN
            DELETE FROM producto WHERE id_producto = w_id_producto;

/* VER QUE SE HA HECHO CORRECTAMENTE */
            SELECT COUNT(*) INTO N_PRODUCTO FROM producto WHERE id_producto = w_id_producto;
            IF (N_PRODUCTO <> 0) THEN
                SALIDA := FALSE;
            END IF;
            COMMIT WORK;
/* MOSTRAR RESULTADO DE LA PRUEBA */
            DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(SALIDA, salidaEsperada));
            EXCEPTION
            WHEN OTHERS THEN
                DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false, salidaEsperada));
                ROLLBACK;
    END ELIMINAR;
END PRUEBAS_PRODUCTO;
/


/*PAQUETE PRUEBAS MESA*/
CREATE OR REPLACE PACKAGE PRUEBAS_MESA AS
    PROCEDURE INICIALIZAR;
    PROCEDURE INSERTAR(nombre_prueba VARCHAR2,
                    w_tipo_mesa IN mesa.tipo_mesa%TYPE,
                    w_capacidad IN mesa.capacidad%TYPE,
                    w_dni_empleado1 IN mesa.dni_empleado1%TYPE,
                    salidaEsperada BOOLEAN);
    PROCEDURE ACTUALIZAR(nombre_prueba VARCHAR2,
                    w_id_mesa IN mesa.id_mesa%TYPE,
                    w_tipo_mesa IN mesa.tipo_mesa%TYPE,
                    w_capacidad IN mesa.capacidad%TYPE,
                    w_dni_empleado1 IN mesa.dni_empleado1%TYPE,
                    salidaEsperada BOOLEAN);
    PROCEDURE ELIMINAR(nombre_prueba VARCHAR2,
                    w_id_mesa IN mesa.id_mesa%TYPE,
                    salidaEsperada BOOLEAN);
END PRUEBAS_MESA;
/
CREATE OR REPLACE PACKAGE BODY PRUEBAS_MESA AS
/* INICIALIZACION */
    PROCEDURE INICIALIZAR AS
    BEGIN
        DELETE FROM mesa; --BORRAR DE LA TABLA
    END INICIALIZAR;
/* INSERTAR Y VER QUE SE HA HECHO CORRECTAMENTE */
    PROCEDURE INSERTAR(nombre_prueba VARCHAR2,
                    w_tipo_mesa IN mesa.tipo_mesa%TYPE,
                    w_capacidad IN mesa.capacidad%TYPE,
                    w_dni_empleado1 IN mesa.dni_empleado1%TYPE,
                    salidaEsperada BOOLEAN)
        AS
            SALIDA BOOLEAN := TRUE;
            w_mesa mesa%ROWTYPE;
            w_id_mesa INT;
        BEGIN
            INSERT INTO mesa(tipo_mesa,capacidad,dni_empleado1)
            VALUES (w_tipo_mesa,w_capacidad,w_dni_empleado1);
            w_id_mesa := sec_mesa.currval;
/* VER QUE SE HA HECHO CORRECTAMENTE */
            SELECT * INTO w_mesa FROM mesa WHERE id_mesa = w_id_mesa;
            IF (w_mesa.tipo_mesa <> w_tipo_mesa
                OR w_mesa.capacidad <> w_capacidad
                OR w_mesa.dni_empleado1 <> w_dni_empleado1) THEN
                SALIDA := FALSE;
            END IF;
            COMMIT WORK;

/* MOSTRAR RESULTADO DE LA PRUEBA */
            DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(SALIDA, salidaEsperada));

            EXCEPTION
            WHEN OTHERS THEN
                DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false, salidaEsperada));
                ROLLBACK;
    END INSERTAR;

    PROCEDURE ACTUALIZAR(nombre_prueba VARCHAR2,
                    w_id_mesa IN mesa.id_mesa%TYPE,
                    w_tipo_mesa IN mesa.tipo_mesa%TYPE,
                    w_capacidad IN mesa.capacidad%TYPE,
                    w_dni_empleado1 IN mesa.dni_empleado1%TYPE,
                    salidaEsperada BOOLEAN)
        AS
            SALIDA BOOLEAN := TRUE;
            w_mesa mesa%ROWTYPE;
        BEGIN
            UPDATE mesa SET tipo_mesa = w_tipo_mesa,
                    capacidad = w_capacidad,
                    dni_empleado1 = w_dni_empleado1
                    WHERE id_mesa = w_id_mesa;

/* VER QUE SE HA HECHO CORRECTAMENTE */
            SELECT * INTO w_mesa FROM mesa WHERE id_mesa = w_id_mesa;
            IF (w_mesa.tipo_mesa <> w_tipo_mesa
                OR w_mesa.capacidad <> w_capacidad
                OR w_mesa.dni_empleado1 <> w_dni_empleado1) THEN
                SALIDA := FALSE;
            END IF;
            COMMIT WORK;

/* MOSTRAR RESULTADO DE LA PRUEBA */
            DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(SALIDA, salidaEsperada));

            EXCEPTION
            WHEN OTHERS THEN
                DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false, salidaEsperada));
                ROLLBACK;
    END ACTUALIZAR;

    PROCEDURE ELIMINAR(nombre_prueba VARCHAR2,
                    w_id_mesa IN mesa.id_mesa%TYPE,
                    salidaEsperada BOOLEAN)
        AS
            SALIDA BOOLEAN := TRUE;
            N_MESAS INTEGER;
        BEGIN
            DELETE FROM mesa WHERE id_mesa = w_id_mesa;

/* VER QUE SE HA HECHO CORRECTAMENTE */
            SELECT COUNT(*) INTO N_MESAS FROM mesa WHERE id_mesa = w_id_mesa;
            IF (N_MESAS <> 0) THEN
                SALIDA := FALSE;
            END IF;
            COMMIT WORK;
/* MOSTRAR RESULTADO DE LA PRUEBA */
            DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(SALIDA, salidaEsperada));
            EXCEPTION
            WHEN OTHERS THEN
                DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false, salidaEsperada));
                ROLLBACK;
    END ELIMINAR;
END PRUEBAS_MESA;
/



/*PAQUETE PRUEBAS PEDIDO*/
CREATE OR REPLACE PACKAGE PRUEBAS_PEDIDO AS
    PROCEDURE INICIALIZAR;
    PROCEDURE INSERTAR(nombre_prueba VARCHAR2,
                    w_id_mesa2 IN pedido.id_mesa2%TYPE,
                    salidaEsperada BOOLEAN);
    PROCEDURE ACTUALIZAR(nombre_prueba VARCHAR2,
                    w_id_pedido IN pedido.id_pedido %TYPE,
                    w_id_mesa2 IN pedido.id_mesa2%TYPE,
                    salidaEsperada BOOLEAN);
    PROCEDURE ELIMINAR(nombre_prueba VARCHAR2,
                    w_id_pedido IN pedido.id_pedido%TYPE,
                    salidaEsperada BOOLEAN);
END PRUEBAS_PEDIDO;
/
CREATE OR REPLACE PACKAGE BODY PRUEBAS_PEDIDO AS
/* INICIALIZACION */
    PROCEDURE INICIALIZAR AS
    BEGIN
        DELETE FROM pedido; --BORRAR DE LA TABLA
    END INICIALIZAR;
/* INSERTAR LINEATURNO Y VER QUE SE HA HECHO CORRECTAMENTE */
    PROCEDURE INSERTAR(nombre_prueba VARCHAR2,
                    w_id_mesa2 IN pedido.id_mesa2%TYPE,
                    salidaEsperada BOOLEAN)
        AS
            SALIDA BOOLEAN := TRUE;
            w_pedido pedido%ROWTYPE;
            w_id_pedido INT;
        BEGIN
            INSERT INTO pedido(id_mesa2,Fecha_pedido)
            VALUES (w_id_mesa2,CURRENT_DATE);
            w_id_pedido := sec_pedido.currval;
/* VER QUE SE HA HECHO CORRECTAMENTE */
            SELECT * INTO w_pedido FROM pedido WHERE id_pedido = w_id_pedido;
            IF (w_pedido.id_mesa2 <> w_id_mesa2) THEN
                SALIDA := FALSE;
            END IF;
            COMMIT WORK;

/* MOSTRAR RESULTADO DE LA PRUEBA */
            DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(SALIDA, salidaEsperada));

            EXCEPTION
            WHEN OTHERS THEN
                DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false, salidaEsperada));
                ROLLBACK;
    END INSERTAR;

    PROCEDURE ACTUALIZAR(nombre_prueba VARCHAR2,
                    w_id_pedido IN pedido.id_pedido %TYPE,
                    w_id_mesa2 IN pedido.id_mesa2%TYPE,
                    salidaEsperada BOOLEAN)
        AS
            SALIDA BOOLEAN := TRUE;
            w_pedido pedido%ROWTYPE;
        BEGIN
            UPDATE pedido SET id_mesa2=w_id_mesa2
            WHERE id_pedido = w_id_pedido;

/* VER QUE SE HA HECHO CORRECTAMENTE */
            SELECT * INTO w_pedido FROM pedido WHERE id_pedido = w_id_pedido;
            IF (w_pedido.id_mesa2 <> w_id_mesa2) THEN
                SALIDA := FALSE;
            END IF;
            COMMIT WORK;

/* MOSTRAR RESULTADO DE LA PRUEBA */
            DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(SALIDA, salidaEsperada));

            EXCEPTION
            WHEN OTHERS THEN
                DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false, salidaEsperada));
                ROLLBACK;
    END ACTUALIZAR;
    PROCEDURE ELIMINAR(nombre_prueba VARCHAR2,
                    w_id_pedido IN pedido.id_pedido%TYPE,
                    salidaEsperada BOOLEAN)
        AS
            SALIDA BOOLEAN := TRUE;
            N_PEDIDO INTEGER;
        BEGIN
            DELETE FROM pedido WHERE id_pedido=w_id_pedido;

/* VER QUE SE HA HECHO CORRECTAMENTE */
            SELECT COUNT(*) INTO N_PEDIDO FROM pedido WHERE id_pedido=w_id_pedido;
            IF (N_PEDIDO <> 0) THEN
                SALIDA := FALSE;
            END IF;
            COMMIT WORK;
/* MOSTRAR RESULTADO DE LA PRUEBA */
            DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(SALIDA, salidaEsperada));
            EXCEPTION
            WHEN OTHERS THEN
                DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false, salidaEsperada));
                ROLLBACK;
    END ELIMINAR;
END PRUEBAS_PEDIDO;
/



/*PAQUETE PRUEBAS CARTA*/
CREATE OR REPLACE PACKAGE PRUEBAS_CARTA AS
    PROCEDURE INICIALIZAR;
    PROCEDURE INSERTAR(nombre_prueba VARCHAR2,
                    w_nombre_producto IN carta.nombre_producto %TYPE,
                    w_FechaInicio_carta IN carta.FechaInicio_carta%TYPE,
                    w_FechaFin_carta IN carta.FechaFin_carta %TYPE,
                    salidaEsperada BOOLEAN);
    PROCEDURE ACTUALIZAR(nombre_prueba VARCHAR2,
                    w_nombre_producto IN carta.nombre_producto %TYPE,
                    w_FechaInicio_carta IN carta.FechaInicio_carta%TYPE,
                    w_FechaFin_carta IN carta.FechaFin_carta %TYPE,
                    salidaEsperada BOOLEAN);
    PROCEDURE ELIMINAR(nombre_prueba VARCHAR2,
                    w_nombre_producto IN carta.nombre_producto%TYPE,
                    salidaEsperada BOOLEAN);
END PRUEBAS_CARTA;
/
CREATE OR REPLACE PACKAGE BODY PRUEBAS_CARTA AS
/* INICIALIZACION */
    PROCEDURE INICIALIZAR AS
    BEGIN
        DELETE FROM carta; --BORRAR DE LA TABLA
    END INICIALIZAR;
/* INSERTAR LINEATURNO Y VER QUE SE HA HECHO CORRECTAMENTE */
    PROCEDURE INSERTAR(nombre_prueba VARCHAR2,
                    w_nombre_producto IN carta.nombre_producto %TYPE,
                    w_FechaInicio_carta IN carta.FechaInicio_carta%TYPE,
                    w_FechaFin_carta IN carta.FechaFin_carta %TYPE,
                    salidaEsperada BOOLEAN)
        AS
            SALIDA BOOLEAN := TRUE;
            w_carta carta%ROWTYPE;
        BEGIN
            add_producto_carta(w_nombre_producto, w_FechaInicio_carta, w_FechaFin_carta);
/* VER QUE SE HA HECHO CORRECTAMENTE */
            SELECT * INTO w_carta FROM carta WHERE nombre_producto = w_nombre_producto;
            IF (w_carta.FechaFin_carta <> w_FechaFin_carta
                 OR w_carta.FechaInicio_carta <> w_FechaInicio_carta) THEN
                SALIDA := FALSE;
            END IF;
            COMMIT WORK;

/* MOSTRAR RESULTADO DE LA PRUEBA */
            DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(SALIDA, salidaEsperada));

            EXCEPTION
            WHEN OTHERS THEN
                DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false, salidaEsperada));
                ROLLBACK;
    END INSERTAR;

    PROCEDURE ACTUALIZAR(nombre_prueba VARCHAR2,
                    w_nombre_producto IN carta.nombre_producto %TYPE,
                    w_FechaInicio_carta IN carta.FechaInicio_carta%TYPE,
                    w_FechaFin_carta IN carta.FechaFin_carta %TYPE,
                    salidaEsperada BOOLEAN)
        AS
            SALIDA BOOLEAN := TRUE;
            w_carta carta%ROWTYPE;
        BEGIN
            UPDATE carta SET FechaFin_carta=w_FechaFin_carta,
FechaInicio_carta=w_FechaInicio_carta
            WHERE nombre_producto = w_nombre_producto;

/* VER QUE SE HA HECHO CORRECTAMENTE */
            SELECT * INTO w_carta FROM carta WHERE nombre_producto = w_nombre_producto;
            IF (w_carta.FechaFin_carta <> w_FechaFin_carta
                 OR w_carta.FechaInicio_carta <> w_FechaInicio_carta) THEN
                SALIDA := FALSE;
            END IF;
            COMMIT WORK;

/* MOSTRAR RESULTADO DE LA PRUEBA */
            DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(SALIDA, salidaEsperada));

            EXCEPTION
            WHEN OTHERS THEN
                DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false, salidaEsperada));
                ROLLBACK;
    END ACTUALIZAR;
    PROCEDURE ELIMINAR(nombre_prueba VARCHAR2,
                    w_nombre_producto IN carta.nombre_producto%TYPE,
                    salidaEsperada BOOLEAN)
        AS
            SALIDA BOOLEAN := TRUE;
            N_CARTA INTEGER;
        BEGIN
            DELETE FROM carta WHERE nombre_producto=w_nombre_producto;

/* VER QUE SE HA HECHO CORRECTAMENTE */
            SELECT COUNT(*) INTO N_CARTA FROM carta WHERE nombre_producto=w_nombre_producto;
            IF (N_CARTA <> 0) THEN
                SALIDA := FALSE;
            END IF;
            COMMIT WORK;
/* MOSTRAR RESULTADO DE LA PRUEBA */
            DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(SALIDA, salidaEsperada));
            EXCEPTION
            WHEN OTHERS THEN
                DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false, salidaEsperada));
                ROLLBACK;
    END ELIMINAR;
END PRUEBAS_CARTA;
/



/*PAQUETE PRUEBAS LINEAPEDIDO*/
CREATE OR REPLACE PACKAGE PRUEBAS_LINEAPEDIDO AS
    PROCEDURE INICIALIZAR;
    PROCEDURE INSERTAR(nombre_prueba VARCHAR2,
                    w_id_pedido1 IN lineapedido.id_pedido1%TYPE,
                    w_Nombre_producto2 IN lineapedido.Nombre_producto2%TYPE,
                    w_Cantidad_pedido IN lineapedido.Cantidad_pedido%TYPE,
                    salidaEsperada BOOLEAN);
    PROCEDURE ACTUALIZAR(nombre_prueba VARCHAR2,
                    w_id_linea_pedido IN lineapedido.id_linea_pedido%TYPE,
                    w_id_pedido1 IN lineapedido.id_pedido1%TYPE,
                    w_Nombre_producto2 IN lineapedido.Nombre_producto2%TYPE,
                    w_Cantidad_pedido IN lineapedido.Cantidad_pedido%TYPE,
                    salidaEsperada BOOLEAN);
    PROCEDURE ELIMINAR(nombre_prueba VARCHAR2,
                    w_id_linea_pedido IN lineapedido.id_linea_pedido%TYPE,
                    salidaEsperada BOOLEAN);
END PRUEBAS_LINEAPEDIDO;
/
CREATE OR REPLACE PACKAGE BODY PRUEBAS_LINEAPEDIDO AS
/* INICIALIZACION */
    PROCEDURE INICIALIZAR AS
    BEGIN
        DELETE FROM lineapedido; --BORRAR DE LA TABLA
    END INICIALIZAR;
/* INSERTAR Y VER QUE SE HA HECHO CORRECTAMENTE */
    PROCEDURE INSERTAR(nombre_prueba VARCHAR2,
                    w_id_pedido1 IN lineapedido.id_pedido1%TYPE,
                    w_Nombre_producto2 IN lineapedido.Nombre_producto2%TYPE,
                    w_Cantidad_pedido IN lineapedido.Cantidad_pedido%TYPE,
                    salidaEsperada BOOLEAN)
        AS
            SALIDA BOOLEAN := TRUE;
            w_lineapedido lineapedido%ROWTYPE;
            w_id_linea_pedido INT;
        BEGIN
            INSERT INTO lineapedido(id_pedido1,nombre_producto2,cantidad_pedido)
            VALUES (w_id_pedido1, w_nombre_producto2,w_cantidad_pedido);
            w_id_linea_pedido := sec_lineapedido.currval;
/* VER QUE SE HA HECHO CORRECTAMENTE */
            SELECT * INTO w_lineapedido FROM lineapedido WHERE id_linea_pedido =
w_id_linea_pedido;
            IF (w_lineapedido.id_pedido1 <> w_id_pedido1
                OR w_lineapedido.Nombre_producto2 <> w_Nombre_producto2
                OR w_lineapedido.Cantidad_pedido <> w_Cantidad_pedido) THEN
                SALIDA := FALSE;
            END IF;
            COMMIT WORK;

/* MOSTRAR RESULTADO DE LA PRUEBA */
            DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(SALIDA, salidaEsperada));

            EXCEPTION
            WHEN OTHERS THEN
                DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false, salidaEsperada));
                ROLLBACK;
    END INSERTAR;

   PROCEDURE ACTUALIZAR(nombre_prueba VARCHAR2,
                    w_id_linea_pedido IN lineapedido.id_linea_pedido%TYPE,
                    w_id_pedido1 IN lineapedido.id_pedido1%TYPE,
                    w_Nombre_producto2 IN lineapedido.Nombre_producto2%TYPE,
                    w_Cantidad_pedido IN lineapedido.Cantidad_pedido%TYPE,
                    salidaEsperada BOOLEAN)
        AS
            SALIDA BOOLEAN := TRUE;
            w_lineapedido lineapedido%ROWTYPE;
        BEGIN
            UPDATE lineapedido SET id_pedido1 = w_id_pedido1,
                    Nombre_producto2 = w_Nombre_producto2,
                    Cantidad_pedido = w_Cantidad_pedido
                    WHERE id_linea_pedido = w_id_linea_pedido;

/* VER QUE SE HA HECHO CORRECTAMENTE */
            SELECT * INTO w_lineapedido FROM lineapedido WHERE id_linea_pedido = w_id_linea_pedido;
            IF (w_lineapedido.id_pedido1 <> w_id_pedido1
                OR w_lineapedido.Nombre_producto2 <> w_Nombre_producto2
                OR w_lineapedido.Cantidad_pedido <> w_Cantidad_pedido) THEN
                SALIDA := FALSE;
            END IF;
            COMMIT WORK;

/* MOSTRAR RESULTADO DE LA PRUEBA */
            DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(SALIDA, salidaEsperada));

            EXCEPTION
            WHEN OTHERS THEN
                DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false, salidaEsperada));
                ROLLBACK;
    END ACTUALIZAR;

    PROCEDURE ELIMINAR(nombre_prueba VARCHAR2,
                    w_id_linea_pedido IN lineapedido.id_linea_pedido%TYPE,
                    salidaEsperada BOOLEAN)
        AS
            SALIDA BOOLEAN := TRUE;
            N_LINEAPEDIDO INTEGER;
        BEGIN
            DELETE FROM lineapedido WHERE id_linea_pedido = w_id_linea_pedido;

/* VER QUE SE HA HECHO CORRECTAMENTE */
            SELECT COUNT(*) INTO N_LINEAPEDIDO FROM lineapedido WHERE id_linea_pedido =
w_id_linea_pedido;
            IF (N_LINEAPEDIDO <> 0) THEN
                SALIDA := FALSE;
            END IF;
            COMMIT WORK;
/* MOSTRAR RESULTADO DE LA PRUEBA */
            DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(SALIDA, salidaEsperada));
            EXCEPTION
            WHEN OTHERS THEN
                DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false, salidaEsperada));
                ROLLBACK;
    END ELIMINAR;
END PRUEBAS_LINEAPEDIDO;
/
/*PAQUETE PRUEBAS EMPLEADO*/
CREATE OR REPLACE PACKAGE PRUEBAS_EMPLEADO AS
    PROCEDURE INICIALIZAR;
    PROCEDURE INSERTAR(nombre_prueba VARCHAR2,
                    w_DNI IN empleado.DNI %TYPE,
                    w_NombreEmpleado IN empleado.NombreEmpleado%TYPE,
                    w_ApellidoEmpleado IN empleado.ApellidoEmpleado %TYPE,
                    w_Telefono IN empleado.Telefono %TYPE,
                    w_Poblacion IN empleado.Poblacion %TYPE,
                    w_CodigoPostal IN empleado.CodigoPostal %TYPE,
                    w_FechaAlta IN empleado.FechaAlta %TYPE,
                    w_FechaBaja IN empleado.FechaBaja %TYPE,
                    w_HashContraseña IN empleado.HashContraseña %TYPE,
                    w_SaltContraseña IN empleado.SaltContraseña %TYPE,
                    w_Categoria IN empleado.Categoria %TYPE,
                    salidaEsperada BOOLEAN);
    PROCEDURE ACTUALIZAR(nombre_prueba VARCHAR2,
                    w_DNI IN empleado.DNI %TYPE,
                    w_NombreEmpleado IN empleado.NombreEmpleado%TYPE,
                    w_ApellidoEmpleado IN empleado.ApellidoEmpleado %TYPE,
                    w_Telefono IN empleado.Telefono %TYPE,
                    w_Poblacion IN empleado.Poblacion %TYPE,
                    w_CodigoPostal IN empleado.CodigoPostal %TYPE,
                    w_FechaAlta IN empleado.FechaAlta %TYPE,
                    w_FechaBaja IN empleado.FechaBaja %TYPE,
                    w_HashContraseña IN empleado.HashContraseña %TYPE,
                    w_SaltContraseña IN empleado.SaltContraseña %TYPE,
                    w_Categoria IN empleado.Categoria %TYPE,
                    salidaEsperada BOOLEAN);
    PROCEDURE ELIMINAR(nombre_prueba VARCHAR2,
                    w_DNI IN empleado.DNI%TYPE,
                    salidaEsperada BOOLEAN);
END PRUEBAS_EMPLEADO;
/
CREATE OR REPLACE PACKAGE BODY PRUEBAS_EMPLEADO AS
/* INICIALIZACION */
    PROCEDURE INICIALIZAR AS
    BEGIN
        DELETE FROM empleado; --BORRAR DE LA TABLA
    END INICIALIZAR;
/* INSERTAR LINEATURNO Y VER QUE SE HA HECHO CORRECTAMENTE */
    PROCEDURE INSERTAR(nombre_prueba VARCHAR2,
                    w_DNI IN empleado.DNI %TYPE,
                    w_NombreEmpleado IN empleado.NombreEmpleado%TYPE,
                    w_ApellidoEmpleado IN empleado.ApellidoEmpleado %TYPE,
                    w_Telefono IN empleado.Telefono %TYPE,
                    w_Poblacion IN empleado.Poblacion %TYPE,
                    w_CodigoPostal IN empleado.CodigoPostal %TYPE,
                    w_FechaAlta IN empleado.FechaAlta %TYPE,
                    w_FechaBaja IN empleado.FechaBaja %TYPE,
                    w_HashContraseña IN empleado.HashContraseña %TYPE,
                    w_SaltContraseña IN empleado.SaltContraseña %TYPE,
                    w_Categoria IN empleado.Categoria %TYPE,
                    salidaEsperada BOOLEAN)
        AS
            SALIDA BOOLEAN := TRUE;
            w_empleado empleado%ROWTYPE;
        BEGIN
            add_empleado(w_DNI, w_NombreEmpleado, w_ApellidoEmpleado, w_Telefono, w_Poblacion,
w_CodigoPostal, w_FechaAlta, w_FechaBaja, w_HashContraseña, w_SaltContraseña, w_Categoria);
/* VER QUE SE HA HECHO CORRECTAMENTE */
            SELECT * INTO w_empleado FROM empleado WHERE DNI = w_DNI;
            IF (w_empleado.ApellidoEmpleado <> w_ApellidoEmpleado
                 OR w_empleado.NombreEmpleado <> w_NombreEmpleado
                 OR w_empleado.Telefono <> w_Telefono
                 OR w_empleado.Poblacion <> w_Poblacion
                 OR w_empleado.CodigoPostal <> w_CodigoPostal
                 OR w_empleado.FechaAlta <> w_FechaAlta
                 OR w_empleado.FechaBaja <> w_FechaBaja
                 OR w_empleado.HashContraseña <> w_HashContraseña
                 OR w_empleado.SaltContraseña <> w_SaltContraseña
                 OR w_empleado.Categoria <> w_Categoria) THEN
                SALIDA := FALSE;
            END IF;
            COMMIT WORK;

/* MOSTRAR RESULTADO DE LA PRUEBA */
            DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(SALIDA, salidaEsperada));

            EXCEPTION
            WHEN OTHERS THEN
                DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false, salidaEsperada));
                ROLLBACK;
    END INSERTAR;

    PROCEDURE ACTUALIZAR(nombre_prueba VARCHAR2,
                    w_DNI IN empleado.DNI %TYPE,
                    w_NombreEmpleado IN empleado.NombreEmpleado%TYPE,
                    w_ApellidoEmpleado IN empleado.ApellidoEmpleado %TYPE,
                    w_Telefono IN empleado.Telefono %TYPE,
                    w_Poblacion IN empleado.Poblacion %TYPE,
                    w_CodigoPostal IN empleado.CodigoPostal %TYPE,
                    w_FechaAlta IN empleado.FechaAlta %TYPE,
                    w_FechaBaja IN empleado.FechaBaja %TYPE,
                    w_HashContraseña IN empleado.HashContraseña %TYPE,
                    w_SaltContraseña IN empleado.SaltContraseña %TYPE,
                    w_Categoria IN empleado.Categoria %TYPE,
                    salidaEsperada BOOLEAN)
        AS
            SALIDA BOOLEAN := TRUE;
            w_empleado empleado%ROWTYPE;
        BEGIN
            UPDATE empleado SET
            ApellidoEmpleado = w_ApellidoEmpleado,
            NombreEmpleado = w_NombreEmpleado,
            Telefono = w_Telefono,
            Poblacion = w_Poblacion,
            CodigoPostal = w_CodigoPostal,
            FechaAlta = w_FechaAlta,
            FechaBaja = w_FechaBaja,
            HashContraseña = w_HashContraseña,
            SaltContraseña = w_SaltContraseña,
            Categoria = w_Categoria
            WHERE DNI = w_DNI;

/* VER QUE SE HA HECHO CORRECTAMENTE */
            SELECT * INTO w_empleado FROM empleado WHERE DNI = w_DNI;
            IF (w_empleado.ApellidoEmpleado <> w_ApellidoEmpleado
                 OR w_empleado.NombreEmpleado <> w_NombreEmpleado
                 OR w_empleado.Telefono <> w_Telefono
                 OR w_empleado.Poblacion <> w_Poblacion
                 OR w_empleado.CodigoPostal <> w_CodigoPostal
                 OR w_empleado.FechaAlta <> w_FechaAlta
                 OR w_empleado.FechaBaja <> w_FechaBaja
                 OR w_empleado.HashContraseña <> w_HashContraseña
                 OR w_empleado.SaltContraseña <> w_SaltContraseña
                 OR w_empleado.Categoria <> w_Categoria) THEN
                SALIDA := FALSE;
            END IF;
            COMMIT WORK;

/* MOSTRAR RESULTADO DE LA PRUEBA */
            DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(SALIDA, salidaEsperada));

            EXCEPTION
            WHEN OTHERS THEN
                DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false, salidaEsperada));
                ROLLBACK;
    END ACTUALIZAR;
    PROCEDURE ELIMINAR(nombre_prueba VARCHAR2,
                    w_DNI IN empleado.DNI%TYPE,
                    salidaEsperada BOOLEAN)
        AS
            SALIDA BOOLEAN := TRUE;
            N_EMPLEADO INTEGER;
        BEGIN
            DELETE FROM empleado WHERE DNI=w_DNI;

/* VER QUE SE HA HECHO CORRECTAMENTE */
            SELECT COUNT(*) INTO N_EMPLEADO FROM empleado WHERE DNI=w_DNI;
            IF (N_EMPLEADO <> 0) THEN
                SALIDA := FALSE;
            END IF;
            COMMIT WORK;
/* MOSTRAR RESULTADO DE LA PRUEBA */
            DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(SALIDA, salidaEsperada));
            EXCEPTION
            WHEN OTHERS THEN
                DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false, salidaEsperada));
                ROLLBACK;
    END ELIMINAR;
END PRUEBAS_EMPLEADO;
/


CREATE OR REPLACE PACKAGE PRUEBAS_FUNCIONES AS
    PROCEDURE INICIALIZAR;
    PROCEDURE RESERVAS_CLIENTE(w_Telefono IN cliente.tlf_cliente%TYPE);
    PROCEDURE RESERVAS_MESA(w_id_mesa1 IN reserva.id_mesa1%TYPE);
    PROCEDURE REPOSICIONES_PRODUCTO(w_id_producto IN producto.id_producto%TYPE);
    PROCEDURE LISTA_MESAS_RESERVADAS;
END PRUEBAS_FUNCIONES;
/
CREATE OR REPLACE PACKAGE BODY PRUEBAS_FUNCIONES AS
/* INICIALIZACION */
    PROCEDURE INICIALIZAR AS
    BEGIN
        PRUEBAS_LINEAPEDIDO.INICIALIZAR;
        PRUEBAS_PEDIDO.INICIALIZAR;
        PRUEBAS_TURNO.INICIALIZAR;
        PRUEBAS_LINEATURNOS.INICIALIZAR;
        PRUEBAS_RESERVA.INICIALIZAR;
        PRUEBAS_CLIENTE.INICIALIZAR;
        PRUEBAS_MESA.INICIALIZAR;
        PRUEBAS_EMPLEADO.INICIALIZAR;
        PRUEBAS_LINEAREPOSICION.INICIALIZAR;
        PRUEBAS_PROVEEDOR.INICIALIZAR;
        PRUEBAS_PRODUCTO.INICIALIZAR;
        PRUEBAS_CARTA.INICIALIZAR;
        add_empleado('58229849K','FELIPE', 'SANCHEZ','123456789', 'SEVILLA', 41000, TO_DATE('2017-02-25', 'YYYY-MM-DD') , TO_DATE('2024-01-20', 'YYYY-MM-DD'), 'hash', 'salt', 'CAMARERO');
        add_empleado('65329531M','ANTONIO', 'FERNANDEZ','987654321', 'SEVILLA', 41000, TO_DATE('2017-02-25', 'YYYY-MM-DD') , TO_DATE('2024-01-20', 'YYYY-MM-DD'), 'hash', 'salt', 'CAMARERO');
        add_empleado('32348899L','JUANJO', 'GONZALEZ','123050709', 'SEVILLA', 41000, TO_DATE('2017-02-25', 'YYYY-MM-DD') , TO_DATE('2024-01-20', 'YYYY-MM-DD'), 'hash', 'salt', 'GERENTE');
        INSERT INTO mesa(tipo_mesa,capacidad,dni_empleado1) VALUES ('EXTERIOR', 4, '58229849K');
        INSERT INTO cliente(tlf_cliente, nombre_cliente, apellidos_cliente) VALUES ('123456789', 'JUAN', 'GONZALEZ');
        INSERT INTO reserva( HoraEntrada_reserva, HoraSalida_reserva, id_cliente1, id_mesa1) VALUES ( TO_DATE('2020-01-20 15:00','YYYY-MM-DD HH24:MI'),TO_DATE('2020-01-20 16:00', 'YYYY-MM-DD HH24:MI'), 1, 1);
        INSERT INTO reserva( HoraEntrada_reserva, HoraSalida_reserva, id_cliente1, id_mesa1) VALUES ( TO_DATE('2020-01-24 16:00','YYYY-MM-DD HH24:MI'),TO_DATE('2020-01-24 17:00','YYYY-MM-DD HH24:MI'), 1, 1);
        add_producto_carta('COCA COLA', NULL, NULL);
        INSERT INTO producto(Nombre_producto1, Precio_producto, Descripcion, Cantidad) VALUES ('COCA COLA', '2,5', 'MUY FRESQUITA', 50);
        add_proveedor('PEPITOS SL',  '123111739');
        INSERT INTO LineaReposicion(cantidad_reposicion,Fecha_reposicion, nombre_p1, id_producto1)  VALUES (30, CURRENT_DATE, 'PEPITOS SL', 1);
        INSERT INTO pedido(id_mesa2,Fecha_pedido) VALUES (1, CURRENT_DATE);
        INSERT INTO lineapedido(id_pedido1,nombre_producto2,cantidad_pedido) VALUES (1, 'COCA COLA', 4);
    END INICIALIZAR;

    PROCEDURE RESERVAS_CLIENTE(w_Telefono IN cliente.tlf_cliente%TYPE) AS
        BEGIN
            reservas_de_cliente(w_Telefono);
    END RESERVAS_CLIENTE;

    PROCEDURE RESERVAS_MESA(w_id_mesa1 IN reserva.id_mesa1%TYPE) AS
        BEGIN
            reservas_por_mesa(w_id_mesa1);
    END RESERVAS_MESA;

    PROCEDURE REPOSICIONES_PRODUCTO(w_id_producto IN producto.id_producto%TYPE) AS
        BEGIN
            reposiciones_por_producto(w_id_producto);
    END REPOSICIONES_PRODUCTO;

    PROCEDURE LISTA_MESAS_RESERVADAS AS
        BEGIN
            mesas_reservadas();
    END LISTA_MESAS_RESERVADAS;

END PRUEBAS_FUNCIONES;
/