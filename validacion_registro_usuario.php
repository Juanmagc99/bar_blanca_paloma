<?php
	session_start();

	
	if (isset($_SESSION["formulario"])) {
		$nuevoUsuario["nif"] = $_REQUEST["nif"];
		$nuevoUsuario["nombre"] = $_REQUEST["nombre"];
		$nuevoUsuario["apellidos"] = $_REQUEST["apellidos"];
		$nuevoUsuario["tlfn"] = $_REQUEST["tlfn"];
		$nuevoUsuario["poblacion"] = $_REQUEST["poblacion"];
		$nuevoUsuario["codigoPostal"] = $_REQUEST["codigoPostal"];
		$nuevoUsuario["perfil"] = $_REQUEST["perfil"];
		$nuevoUsuario["fechaNacimiento"] = $_REQUEST["fechaNacimiento"];
		$nuevoUsuario["email"] = $_REQUEST["email"];
		
		$nuevoUsuario["pass"] = $_REQUEST["pass"];
		$nuevoUsuario["confirmpass"] = $_REQUEST["confirmpass"];
	}
	else 
		Header("Location: registro_usuario.php");

	$_SESSION["formulario"] = $nuevoUsuario;

 
	$errores = validarDatosUsuario($nuevoUsuario);
	if (count($errores)>0) {
		$_SESSION["errores"] = $errores;
		Header('Location: registro_usuario.php');
	} else
		if ($nuevoUsuario["perfil"] == "Cliente"){
			Header('Location: alta_cliente.php');
		} else {
			Header('Location: alta_empleado.php');
		}

		
	// Validación en servidor del formulario de alta de usuario
	
	
	function validarDatosUsuario($nuevoUsuario){
				
		// Validación nif
		if(!preg_match("/^[0-9]{8}[A-Z]$/", $nuevoUsuario["nif"])){
			$errores[] = "<p>El NIF debe contener 8 números y una letra mayúscula: " . $nuevoUsuario["nif"]. "</p>";
		}
		
		//Validacion tlfn 9 digitos
		if(!preg_match("/^[0-9]{9}$/", $nuevoUsuario["tlfn"])){
			$errores[] = "<p>Formato de numero de teléfono incorrecto: " . $nuevoUsuario["tlfn"]. "</p>";
		}
		//Validacion codigo postal 5 digitos
		if(!preg_match("/^[0-9]{5}$/", $nuevoUsuario["codigoPostal"])){
			$errores[] = "<p>El código postal debe tener 5 numeros: " . $nuevoUsuario["codigoPostal"]. "</p>";
		}
		
		// Validación email
		if(!filter_var($nuevoUsuario["email"], FILTER_VALIDATE_EMAIL)){
			$errores[] = $error . "<p>El email es incorrecto: " . $nuevoUsuario["email"]. "</p>";
		}
		
		//Validacion fecha vacia
		if ($nuevoUsuario["fechaNacimiento"] == ""){
			$errores[] = "<p>La fecha de nacimiento no puede estar vacía</p>";
		//Validacion mayor de edad
		} else {
			$mayor = 18;
			$nacimiento = DateTime::createFromFormat('Y-m-d', $nuevoUsuario["fechaNacimiento"]);
			$calculo = $nacimiento->diff(new DateTime());
			$edad = $calculo -> y;
			if($edad < $mayor){
				$errores [] = "<p>No puedes registrarte si tienes menos de 18 años</p>";
			}
		}
		
		// Validación contraseña
		if(!isset($nuevoUsuario["pass"]) || strlen($nuevoUsuario["pass"])<8){
			$errores [] = "<p>Contraseña no válida: debe tener al menos 8 caracteres</p>";
		}else if(!preg_match("/[a-z]+/", $nuevoUsuario["pass"]) || 
			!preg_match("/[A-Z]+/", $nuevoUsuario["pass"]) || !preg_match("/[0-9]+/", $nuevoUsuario["pass"])){
			$errores[] = "<p>Contraseña no válida: debe contener letras mayúsculas y minúsculas y dígitos</p>";
		}else if($nuevoUsuario["pass"] != $nuevoUsuario["confirmpass"]){
			$errores[] = "<p>La confirmación de contraseña no coincide con la contraseña</p>";
		}
	
		return $errores;
	}

?>

