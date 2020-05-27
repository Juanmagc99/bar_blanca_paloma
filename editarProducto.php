<?php	
	session_start();	
	
	if (isset($_SESSION["producto"])) {
		$producto = $_SESSION["producto"];
		unset($_SESSION["producto"]);
		
		require_once("gestionBD.php");
		require_once("gestionProductos.php");
		
		
		$conexion = crearConexionBD();
		$excepcion = editar_precio($conexion,$producto["NOMBRE_PRODUCTO1"],$producto["PRECIO_PRODUCTO"]);
		cerrarConexionBD($conexion);
		
		if ($excepcion<>"") {
			$_SESSION["excepcion"] = $excepcion;
			$_SESSION["destino"] = "adminCarta.php";
			Header("Location: excepcion.php");
		} else
			Header("Location: adminCarta.php");
	} 
		
	else 
		Header("Location: adminCarta.php"); 
?>
