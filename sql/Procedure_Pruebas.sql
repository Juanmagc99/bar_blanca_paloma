--===================================== 
-- PROCEDIMIENTOS 
--===================================== 

CREATE OR REPLACE PROCEDURE add_empleado  
(w_DNI VARCHAR,  
w_NombreEmp VARCHAR,  
w_ApellidoEmp VARCHAR,  
w_telefono VARCHAR,  
w_Poblacion VARCHAR,  
w_CodigoPostal INT,  
w_FechaAlta DATE,  
w_FechaBaja DATE,  
w_HashContrase�a VARCHAR,  
w_SaltContrase�a VARCHAR,  
w_Categoria VARCHAR)  
IS  
BEGIN  
INSERT INTO empleado (DNI, NombreEmpleado, ApellidoEmpleado, telefono, Poblacion, CodigoPostal, 
FechaAlta, FechaBaja, HashContrase�a, SaltContrase�a, Categoria)  
VALUES (w_DNI, w_NombreEmp, w_ApellidoEmp, w_telefono, w_Poblacion, w_CodigoPostal, w_FechaAlta, 
w_FechaBaja, w_HashContrase�a, w_SaltContrase�a, w_Categoria);  
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
VALUES (sec_producto.nextval, w_Nombre, w_Precio_producto, w_Descripcion, w_Cantidad); 
END add_producto; 
/
CREATE OR REPLACE PROCEDURE add_cliente 
(w_tlf_cliente IN VARCHAR, 
w_nombre_cliente IN VARCHAR, 
w_apellidos_cliente IN VARCHAR) 
IS 
BEGIN 
INSERT INTO cliente(id_cliente, tlf_cliente, nombre_cliente, apellidos_cliente) 
VALUES (sec_cliente.nextval, w_tlf_cliente, w_nombre_cliente, w_apellidos_cliente); 
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
VALUES (sec_reserva.nextval, w_HoraEntrada_reserva, w_HoraSalida_reserva, w_id_cliente1, 
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
VALUES (sec_mesa.nextval,w_tipo_mesa,w_capacidad,w_dni_empleado1); 
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
INSERT INTO pedido(id_pedido,id_mesa2,Fecha_pedido,estado_pedido,importe)  
VALUES (sec_pedido.nextval,w_id_mesa2,CURRENT_DATE,'SIN_PAGAR',NULL);
END add_pedido; 
/
CREATE OR REPLACE PROCEDURE add_lineapedido  
(w_id_pedido1 INT,  
w_nombre_producto2 VARCHAR, 
w_cantidad_pedido INT)  
IS 
BEGIN  
INSERT INTO lineapedido(id_linea_pedido,id_pedido1,nombre_producto2,cantidad_pedido)  
VALUES (sec_lineapedido.nextval,w_id_pedido1, w_nombre_producto2,w_cantidad_pedido);  
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
VALUES (sec_lineareposicion.nextval,w_Cantidad_reposicion, CURRENT_DATE,w_nombre_p1, 
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
VALUES (sec_turno.nextval,w_tipo_turno,w_HoraEntrada,w_HoraSalida,w_id_lineaturno1);  
END add_turno; 
/
CREATE OR REPLACE PROCEDURE add_lineaturnos  
(w_fecha_turno DATE,  
w_DNI1 VARCHAR)  
IS 
BEGIN  
INSERT INTO LineaTurnos(id_lineaturno, fecha_turno, DNI1)  
VALUES (sec_lineaturnos.nextval,w_fecha_turno, w_DNI1);  
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
create or replace PROCEDURE BORRAR_PRODUCTO (nombre_producto_a_quitar IN carta.nombre_producto%TYPE) IS 
BEGIN
    DELETE FROM PRODUCTO WHERE id_producto = (SELECT id_producto FROM PRODUCTO WHERE nombre_producto1 = nombre_producto_a_quitar);
    DELETE FROM CARTA WHERE nombre_producto = nombre_producto_a_quitar;
END;
/
create or replace PROCEDURE EDITAR_PRECIO(nombre_producto_mod in producto.nombre_producto1%TYPE, precio_producto_mod in producto.precio_producto%TYPE)IS
BEGIN
  UPDATE PRODUCTO SET precio_producto = precio_producto_mod WHERE nombre_producto1 = nombre_producto_mod;
END;
/
create or replace PROCEDURE BORRAR_PRODUCTO_FACTURA (id_linea_quitar IN LINEAPEDIDO.ID_LINEA_PEDIDO%TYPE) IS 
BEGIN
    DELETE FROM LINEAPEDIDO WHERE ID_LINEA_PEDIDO = id_linea_quitar;
END;
/
create or replace PROCEDURE EDITAR_PRECIO(nombre_producto_mod in producto.nombre_producto1%TYPE, precio_producto_mod in producto.precio_producto%TYPE)IS
BEGIN
  UPDATE PRODUCTO SET precio_producto = precio_producto_mod WHERE nombre_producto1 = nombre_producto_mod;
END;
/
create or replace PROCEDURE EDITAR_CANTIDAD_FACTURA(id_linea_editar in LINEAPEDIDO.ID_LINEA_PEDIDO%TYPE, cantidad_editar in LINEAPEDIDO.CANTIDAD_PEDIDO%TYPE)IS
BEGIN
  UPDATE LINEAPEDIDO SET CANTIDAD_PEDIDO = cantidad_editar WHERE ID_LINEA_PEDIDO = id_linea_editar;
END;
/
create or replace PROCEDURE CERRAR_PEDIDO(id_cerrar in pedido.id_pedido%TYPE, importe_total in pedido.importe%TYPE)IS
BEGIN
  UPDATE PEDIDO SET ESTADO_PEDIDO = 'PAGADO'  WHERE ID_PEDIDO = id_cerrar;
   UPDATE PEDIDO SET IMPORTE = importe_total WHERE ID_PEDIDO = id_cerrar;
END;

create or replace PROCEDURE A�ADIR_MESA (id_mesa_a_a�adir in mesa.id_mesa%TYPE,tipo_mesa_a_a�adir IN mesa.tipo_mesa%TYPE, capacidad_a_a�adir IN mesa.capacidad%TYPE, dni_a_a�adir IN mesa.dni_empleado1%TYPE) IS
BEGIN
    INSERT INTO MESA(ID_MESA,TIPO_MESA,CAPACIDAD,DNI_EMPLEADO1) VALUES (id_mesa_a_a�adir,tipo_mesa_a_a�adir,capacidad_a_a�adir,dni_a_a�adir);
END;
/
create or replace PROCEDURE BORRAR_MESA (id_mesa_a_quitar IN mesa.id_mesa%TYPE) IS
BEGIN
    DELETE FROM MESA WHERE id_mesa = id_mesa_a_quitar;
END;
/
create or replace PROCEDURE EDITAR_MESA(id_mesa_mod in mesa.id_mesa%TYPE, capacidad_mod in mesa.capacidad%TYPE)IS
    BEGIN
        UPDATE MESA SET capacidad = capacidad_mod WHERE id_mesa = id_mesa_mod;
END;
/
create or replace PROCEDURE EDITAR_EMPLEADO (dni_empleado in empleado.DNI%TYPE, telefono_empleado in empleado.telefono%TYPE,
poblacion_empleado in empleado.poblacion%TYPE, codpostal_empleado in empleado.codigopostal%TYPE,
categoria_empleado in empleado.categoria%TYPE)IS
BEGIN
  UPDATE EMPLEADO SET telefono = telefono_empleado, poblacion = poblacion_empleado, codigopostal = codpostal_empleado,
  categoria = categoria_empleado
  WHERE DNI = dni_empleado;
END;
/
create or replace PROCEDURE BORRAR_EMPLEADO (dni_empleado_borrar IN empleado.DNI%TYPE) IS 
BEGIN
    DELETE FROM EMPLEADO WHERE DNI = dni_empleado_borrar;
END;
/