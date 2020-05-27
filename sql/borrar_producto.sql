/*teneis que crear un nuevo procedimiento y llamarlo como pone abajo para probar el boton de borrar*/

create or replace PROCEDURE BORRAR_PRODUCTO (nombre_producto_a_quitar IN carta.nombre_producto%TYPE) IS 
BEGIN
    DELETE FROM PRODUCTO WHERE id_producto = (SELECT id_producto FROM PRODUCTO WHERE nombre_producto1 = nombre_producto_a_quitar);
    DELETE FROM CARTA WHERE nombre_producto = nombre_producto_a_quitar;
END;