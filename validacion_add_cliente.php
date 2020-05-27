<?php
	session_start();
	
	if (isset($_SESSION["formulario"])) {

		$nuevoCliente["TLF_CLIENTE"] = $_REQUEST["TLF_CLIENTE"];
		$nuevoCliente["NOMBRE_CLIENTE"] = $_REQUEST["NOMBRE_CLIENTE"];
		$nuevoCliente["APELLIDOS_CLIENTE"] = $_REQUEST["APELLIDOS_CLIENTE"];
	}
	else 
		Header("Location: clientes.php");

	$_SESSION["formulario"] = $nuevoCliente;

 
	$errores = validarDatosUsuario($nuevoCliente);
	if (count($errores)>0) {
		$_SESSION["errores"] = $errores;
		Header('Location: clientes.php');
	} else {
		Header('Location: gestion_cliente.php');
	}

		
	// Validación en servidor del formulario
	function validarDatosUsuario($nuevoCliente){
		//Validacion tlfn 9 digitos
		if(!preg_match("/^[0-9]{9}$/", $nuevoCliente["TLF_CLIENTE"])){
			$errores[] = "<p>Formato de numero de teléfono incorrecto: " . $nuevoCliente["TLF_CLIENTE"]. "</p>";
		}
		return $errores;
	}
?>

