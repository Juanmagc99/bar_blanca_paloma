<?php


    function facturaEnCurso($conexion, $idMesa){
        $consulta = "SELECT * FROM PEDIDO WHERE ID_MESA2 = :ID_MESA AND ESTADO_PEDIDO = 'SIN_PAGAR'";
        $stmt = $conexion->prepare($consulta);
        $stmt->bindParam(':ID_MESA', $idMesa);
        $stmt->execute();
        return $stmt;
    }

    function productosEnFactura($conexion, $idPedido){
        $consulta = "SELECT * FROM LINEAPEDIDO WHERE ID_PEDIDO1 = :ID_PEDIDO";
        $stmt = $conexion->prepare($consulta);
        $stmt->bindParam(':ID_PEDIDO', $idPedido);
        $stmt->execute();
        return $stmt;
    }

function borrar_producto_factura($conexion,$idLinea) {
    try {
        $stmt=$conexion->prepare('CALL BORRAR_PRODUCTO_FACTURA(:id_linea_pedido)');
        $stmt->bindParam(':id_linea_pedido',$idLinea);
        $stmt->execute();
        return "";
    } catch(PDOException $e) {
        return $e->getMessage();
    }
}


function editar_cantidad_factura($conexion,$idLinea,$cantidad) {
    try {
        $stmt=$conexion->prepare('CALL EDITAR_CANTIDAD_FACTURA(:id_linea,:cantidad)');
        $stmt->bindParam(':id_linea',$idLinea);
        $stmt->bindParam(':cantidad',$cantidad);
        $stmt->execute();
        return "";
    } catch(PDOException $e) {
        return $e->getMessage();
    }
}

function añadir_producto_factura($conexion,$idPedido, $nombreNuevo, $cantidadInicial){
    try {
        $stmt=$conexion->prepare('CALL add_lineapedido(:idPedido,:nombre,:cantidad)');
        $stmt->bindParam(':idPedido',$idPedido);
        $stmt->bindParam(':nombre',$nombreNuevo);
        $stmt->bindParam(':cantidad', $cantidadInicial);
        $stmt->execute();
        return "";
    } catch(PDOException $e) {
        return $e->getMessage();
    }
}

function añadir_factura($conexion,$idMesa){
    try {
        $stmt=$conexion->prepare('CALL add_pedido(:idMesa)');
        $stmt->bindParam(':idMesa',$idMesa);
        $stmt->execute();
        return "";
    } catch(PDOException $e) {
        return $e->getMessage();
    }
}
function cerrarFactura($conexion, $idCerrar){
    try {
        $stmt=$conexion->prepare('CALL CERRAR_PEDIDO(:idPedido)');
        $stmt->bindParam(':idPedido',$idCerrar);
        $stmt->execute();
        return "";
    } catch(PDOException $e) {
        return $e->getMessage();
    }
}

?>
