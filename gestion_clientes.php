<?php
 

 function alta_usuario($conexion,$usuario) {
 
	try {
		$consulta = "CALL ADD_CLIENTE(:tlfn, :nombre, :apellidos)";
		$stmt=$conexion->prepare($consulta);
		$stmt->bindParam(':tlfn',$usuario["tlfn"]);
		$stmt->bindParam(':nombre',$usuario["nombre"]);
		$stmt->bindParam(':apellidos',$usuario["apellidos"]);
		
		$stmt->execute();
		
		return true;
		
	}catch(PDOException $e){
		return false;
	}
	
}

function consultarCliente($conexion,$nombre,$tlfn) {
 	$consulta = "SELECT COUNT(*) AS TOTAL FROM CLIENTE WHERE NOMBRE=:nombre AND TLFN=:tlfn";
	$stmt = $conexion->prepare($consulta);
	$stmt->bindParam(':nombre',$nombre);
	$stmt->bindParam(':tlfn',$tlf);
	$stmt->execute();
	return $stmt->fetchColumn();
	
}
