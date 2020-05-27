<?php	
	session_start();	
	
	if (isset($_SESSION["producto"])) {
		$producto = $_SESSION["producto"];
		unset($_SESSION["producto"]);
		
		require_once("gestionBD.php");
		require_once("gestionProductos.php");
		
		$conexion = crearConexionBD();
		$excepcion = borrar_producto($conexion,$producto["NOMBRE_PRODUCTO1"]);
		cerrarConexionBD($conexion);
		
		if ($excepcion<>"") {
			$_SESSION["excepcion"] = $excepcion;
			$_SESSION["destino"] = "adminCarta.php";
			Header("Location: excepcion.php");
		} else
			Header("Location: adminCarta.php");

	}
	
		Header("Location: adminCarta.php"); 
?>