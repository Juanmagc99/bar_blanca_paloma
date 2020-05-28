<?php
	session_start();
	
	if (isset($_SESSION["formulario_cliente"])) {

		$nuevoCliente["TLF_CLIENTE"] = $_REQUEST["TLF_CLIENTE"];
		$nuevoCliente["NOMBRE_CLIENTE"] = $_REQUEST["NOMBRE_CLIENTE"];
		$nuevoCliente["APELLIDOS_CLIENTE"] = $_REQUEST["APELLIDOS_CLIENTE"];
	}
	else 
		Header("Location: clientes.php");

	$_SESSION["formulario_cliente"] = $nuevoCliente;

 
	$errores_cliente = validarDatosUsuario($nuevoCliente);
	if (count($errores_cliente)>0) {
		$_SESSION["errores_cliente"] = $errores_cliente;
		Header('Location: clientes.php');
	} else {
		require_once("gestionBD.php");
		$_SESSION["formulario_cliente"] = null;
		$_SESSION["errores"] = null;

		$conexion = crearConexionBD();
		add_cliente($conexion, $nuevoCliente);
		cerrarConexionBD($conexion);
		Header('Location: clientes.php');
	}
		
	// Validación en servidor del formulario
	function validarDatosUsuario($nuevoCliente){
		//Validacion tlfn 9 digitos
		if(!preg_match("/^[0-9]{9}$/", $nuevoCliente["TLF_CLIENTE"])){
			$errores_cliente[] = "<p>Formato de numero de teléfono incorrecto: " . $nuevoCliente["TLF_CLIENTE"]. "</p>";
		}
		return $errores_cliente;
	}

	//Añadir a la base de datos
	function add_cliente($conexion,$cliente)
	{
		try {
			$consulta = "CALL ADD_CLIENTE(:TLF_CLIENTE, :NOMBRE_CLIENTE, :APELLIDOS_CLIENTE)";
			$stmt = $conexion->prepare($consulta);

			$stmt->bindParam(':TLF_CLIENTE', $cliente["TLF_CLIENTE"]);
			$stmt->bindParam(':NOMBRE_CLIENTE', $cliente["NOMBRE_CLIENTE"]);
			$stmt->bindParam(':APELLIDOS_CLIENTE', $cliente["APELLIDOS_CLIENTE"]);

			$stmt->execute();

			return true;

		}
		catch (PDOException $e) {
			return false;
		}
	}
?>