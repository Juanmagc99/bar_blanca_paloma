<?php	
	session_start();
	
	if (isset($_REQUEST["ID_PRODUCTO"])) {
		$producto["ID_PRODUCTO"] = $_REQUEST["ID_PRODUCTO"];
		$producto["NOMBRE_PRODUCTO1"] = $_REQUEST["NOMBRE_PRODUCTO1"];
		$producto["PRECIO_PRODUCTO"] = $_REQUEST["PRECIO_PRODUCTO"];
		$producto["DESCRIPCION"] = $_REQUEST["DESCRIPCION"];
		$producto["CANTIDAD"] = $_REQUEST["CANTIDAD"];
		
		$_SESSION["producto"] = $producto;
			
		if (isset($_REQUEST["editar"])) Header("Location: adminCarta.php"); 
		else if (isset($_REQUEST["grabar"])) Header("Location: editarProducto.php");
		else Header("Location: borrarProducto.php"); 
	}
	else 
		Header("Location: adminCarta.php");
	
?>