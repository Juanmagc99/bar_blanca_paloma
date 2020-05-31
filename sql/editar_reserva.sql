/*teneis que crear un nuevo procedimiento y llamarlo como pone abajo para probar el boton de editar, además de comentar el TRIGGER existencias*/

create or replace PROCEDURE EDITAR_RESERVA(id_r in reserva.id_reserva%TYPE, entrada in reserva.HoraEntrada_reserva%TYPE, salida in reserva.HoraSalida_reserva%TYPE, id_cliente in reserva.id_cliente1%TYPE, id_mesa in reserva.id_mesa1%TYPE)IS
BEGIN
	UPDATE RESERVA SET HoraEntrada_reserva = entrada, HoraSalida_reserva = salida, id_cliente1 = id_cliente, id_mesa1 = id_mesa
	WHERE id_reserva = id_r;
END;