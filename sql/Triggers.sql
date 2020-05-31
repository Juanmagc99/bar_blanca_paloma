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