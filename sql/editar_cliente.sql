/*teneis que crear un nuevo procedimiento y llamarlo como pone abajo para probar el boton de editar, además de comentar el TRIGGER existencias*/

create or replace PROCEDURE EDITAR_CLIENTE(id_client in cliente.id_cliente%TYPE, tlf in cliente.tlf_cliente%TYPE, nombre in cliente.nombre_cliente%TYPE, apellidos in cliente.apellidos_cliente%TYPE)IS
BEGIN
	UPDATE CLIENTE  SET tlf_cliente = tlf, nombre_cliente = nombre, apellidos_cliente = apellidos
	WHERE id_cliente = id_client;
END;