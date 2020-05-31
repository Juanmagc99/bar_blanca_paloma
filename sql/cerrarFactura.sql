create or replace PROCEDURE CERRAR_PEDIDO(id_cerrar in pedido.id_pedido%TYPE)IS
BEGIN
  UPDATE PEDIDO SET ESTADO_PEDIDO = 'PAGADO' WHERE ID_PEDIDO = id_cerrar;
END;