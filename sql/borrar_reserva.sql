/*teneis que crear un nuevo procedimiento y llamarlo como pone abajo para probar el boton de borrar*/

    create or replace PROCEDURE BORRAR_RESERVA(id_reserva_a_quitar IN reserva.id_reserva%TYPE) IS
BEGIN
    DELETE FROM RESERVA WHERE id_reserva = id_reserva_a_quitar;
END;