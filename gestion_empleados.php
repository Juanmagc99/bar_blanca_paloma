<?php


 function alta_empleado($conexion,$usuario) {
 		
 	$fechaHoy = date('d-m-Y');
 	$fechaHoyFormateada = date('d/m/Y', strtotime($fechaHoy));
	$fechaBaja = date('d-m-Y',strtotime($fechaHoy . "+ 6 month"));
	$fechaBajaFormateada = date('d/m/Y', strtotime($fechaBaja));
	 
	try {
		$consulta = "CALL ADD_EMPLEADO(:nif, :nombre, :apellidos, :tlfn, :poblacion, :codigoPostal, :fechaAlta, :fechaBaja, :hashContraseña, :saltContraseña, :categoria)";
		$stmt=$conexion->prepare($consulta);
		
		$stmt->bindParam(':nif',$usuario["nif"]);
		$stmt->bindParam(':nombre',$usuario["nombre"]);
		$stmt->bindParam(':apellidos',$usuario["apellidos"]);
		$stmt->bindParam(':tlfn',$usuario["tlfn"]);
		$stmt->bindParam(':poblacion', $usuario["poblacion"]);
		$stmt->bindParam(':codigoPostal', $usuario["codigoPostal"]);
		$stmt->bindParam(':fechaAlta', $fechaHoyFormateada);
		$stmt->bindParam(':fechaBaja', $fechaBajaFormateada);
		
		$stmt->bindParam(':hashContraseña', $usuario["pass"]);
		$stmt->bindParam(':saltContraseña', $usuario["confirmPass"]);
		
		$stmt->bindParam(':categoria', $usuario["categoria"]);

		$stmt->execute();
		
		return true;
		
	}catch(PDOException $e){
		return false;
		
	}
	
}

function consultarEmpleado($conexion,$nif,$pass) {
 	$consulta = "SELECT COUNT(*) AS TOTAL FROM EMPLEADO WHERE DNI=:nif AND HASHCONTRASEÑA=:hashContraseña";
	$stmt = $conexion->prepare($consulta);
	$stmt->bindParam(':nif',$nif);
	$stmt->bindParam(':hashContraseña',$pass);
	$stmt->execute();
	return $stmt->fetchColumn();
}

function consultarCategoriaEmpleado($conexion,$nif,$pass) {
    $consulta = "SELECT categoria FROM EMPLEADO WHERE DNI=:nif AND HASHCONTRASEÑA=:hashContraseña";
    $stmt = $conexion->prepare($consulta);
    $stmt->bindParam(':nif',$nif);
    $stmt->bindParam(':hashContraseña',$pass);
    $stmt->execute();
    return $stmt->fetchColumn();
}