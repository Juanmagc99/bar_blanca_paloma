<?php
    
function consultarProductos($conexion) {
	$consulta = "SELECT * FROM CARTA, PRODUCTO"
		. " WHERE (CARTA.NOMBRE_PRODUCTO = PRODUCTO.NOMBRE_PRODUCTO1)";
    return $conexion->query($consulta);
}
 
function borrar_producto($conexion,$nombreProducto) {
	try {
		$stmt=$conexion->prepare('CALL BORRAR_PRODUCTO(:nombre_producto)');
		$stmt->bindParam(':nombre_producto',$nombreProducto);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}

function editar_precio($conexion,$nombreProducto,$precio_producto) {
	try {
		$stmt=$conexion->prepare('CALL EDITAR_PRECIO(:nombre_producto1,:precio_producto)');
		$stmt->bindParam(':nombre_producto1',$nombreProducto);
		$stmt->bindParam(':precio_producto',$precio_producto);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}
	
?>