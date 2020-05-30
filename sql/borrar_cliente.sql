/*teneis que crear un nuevo procedimiento y llamarlo como pone abajo para probar el boton de borrar*/

create or replace PROCEDURE BORRAR_CLIENTE(id_cliente_a_quitar IN cliente.id_cliente%TYPE) IS
BEGIN
    DELETE FROM CLIENTE WHERE id_cliente = id_cliente_a_quitar;
END;