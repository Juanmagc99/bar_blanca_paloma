/*teneis que crear un nuevo procedimiento y llamarlo como pone abajo para probar el boton de editar, además de comentar el TRIGGER existencias*/

create or replace PROCEDURE EDITAR_PRECIO(nombre_producto_mod in producto.nombre_producto1%TYPE, precio_producto_mod in producto.precio_producto%TYPE)IS
BEGIN
  UPDATE PRODUCTO SET precio_producto = precio_producto_mod WHERE nombre_producto1 = nombre_producto_mod;
END;