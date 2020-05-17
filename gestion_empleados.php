<?php


 function alta_empleado($conexion,$usuario) {
 	
 	$fecha = date('d-m-Y');
	$fechaHoy = date('d/m/Y', strtotime($fecha));
	$fechaBaja = "---";
	
	try {
		$consulta = "CALL INSERTAR_USUARIO(:nif, :nombre, :apellidos, :tlfn, :poblacion, :fechaAlta, :fechaBaja, :hashContraseña, :categoria)";
		$stmt=$conexion->prepare($consulta);
		$stmt->bindParam(':nif',$usuario["nif"]);
		$stmt->bindParam(':nombre',$usuario["nombre"]);
		$stmt->bindParam(':apellidos',$usuario["apellidos"]);
		$stmt->bindParam(':tlfn',$usuario["tlfn"]);
		$stmt->bindParam(':poblacion', $usuario["poblacion"]);
		$stmt->bindParam(':fechaAlta', $fechaHoy);
		$stmt->bindParam(':fechaBaja', $fechaBaja);
		$stmt->bindParam(':hashContraseña', $usuario["pass"]);
		$stmt->bindParam(':saltContraseña', $usuario["confirmPass"]);
		//$stmt->bindParam(':categoria', $usuario["categoria"]);

		$stmt->execute();
		
		return true;
		
	}catch(PDOException $e){
		return false;
	}
	
}

function consultarEmpleado($conexion,$nif,$pass) {
 	$consulta = "SELECT COUNT(*) AS TOTAL FROM EMPLEADOS WHERE NIF=:nif AND PASS=:hashContraseña";
	$stmt = $conexion->prepare($consulta);
	$stmt->bindParam(':nif',$nif);
	$stmt->bindParam(':hashContraseña',$pass);
	$stmt->execute();
	return $stmt->fetchColumn();
	
}
