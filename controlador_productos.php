<?php	
	session_start();
	
	if (isset($_REQUEST["ID_PRODUCTO"])) {
		$producto["ID_PRODUCTO"] = $_REQUEST["ID_PRODUCTO"];
		$producto["NOMBRE_PRODUCTO1"] = $_REQUEST["NOMBRE_PRODUCTO1"];
		$producto["PRECIO_PRODUCTO"] = $_REQUEST["PRECIO_PRODUCTO"];
		$producto["DESCRIPCION"] = $_REQUEST["DESCRIPCION"];
		$producto["CANTIDAD"] = $_REQUEST["CANTIDAD"];
		
		$_SESSION["producto"] = $producto;
		
		$errores;
		
		if ($producto["PRECIO_PRODUCTO"] == ""){
    		$errores[] = "<p>Precio vacio</p>";
    	} else if (!preg_match("/^[0-9]{1,2}(,[0-9]{1})?$/", $producto["PRECIO_PRODUCTO"])) {
    		$errores[] = "<p>Precio mal</p>";
		}
		
		if (count($errores)>0){
		$_SESSION["errores"] = $errores;
		Header("Location: adminCarta.php");
		
	} else {
			
		if (isset($_REQUEST["editar"])) Header("Location: adminCarta.php"); 
		else if (isset($_REQUEST["grabar"])) Header("Location: editarProducto.php");
		else Header("Location: borrarProducto.php");
	}
	}
	else 
		Header("Location: adminCarta.php");
?>