<?php
	session_start();

	
	if (isset($_SESSION["formulario"])) {
		
		$nuevoUsuario["nif"] = $_REQUEST["nif"];
		$nuevoUsuario["nombre"] = $_REQUEST["nombre"];
		$nuevoUsuario["apellidos"] = $_REQUEST["apellidos"];
		$nuevoUsuario["tlfn"] = $_REQUEST["tlfn"];
		$nuevoUsuario["poblacion"] = $_REQUEST["poblacion"];
		$nuevoUsuario["codigoPostal"] = $_REQUEST["codigoPostal"];
		$nuevoUsuario["categoria"] = $_REQUEST["categoria"];
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
	} else {
		Header('Location: alta_empleado.php');
	}

		
	// Validación en servidor del formulario
	
	function validarDatosUsuario($nuevoUsuario){
				
		//validacion nombre
		if ($nuevoUsuario["nombre"] == ""){
			$errores[] = "<p>No puedes continuar sin poner tu nombre</p>";
		} else if(!preg_match("/^[A-Za-z]+$/", $nuevoUsuario["nombre"])){
			$errores[] = "<p>El nombre debe ser una cadena de letras: " . $nuevoUsuario["nombre"]. "</p>";
		}
		
		//validacion apellidos
		if ($nuevoUsuario["apellidos"] == ""){
			$errores[] = "<p>No puedes continuar sin poner tus apellidos</p>";
		} else if(!preg_match("/^[A-Za-z ]+$/", $nuevoUsuario["apellidos"])){
			$errores[] = "<p>Los apellidos deben ser una cadena de letras: " . $nuevoUsuario["nombre"]. "</p>";
		}
				
		// Validación nif
		if ($nuevoUsuario["nif"] == ""){
			$errores[] = "<p>No puedes continuar sin poner tu NIF</p>";
		}else if(!preg_match("/^[0-9]{8}[A-Z]$/", $nuevoUsuario["nif"])){
			$errores[] = "<p>El NIF debe contener 8 números y una letra mayúscula: " . $nuevoUsuario["nif"]. "</p>";
		}
		
		//Validacion tlfn 9 digitos
		if ($nuevoUsuario["tlfn"] == ""){
			$errores[] = "<p>No puedes continuar sin poner tu teléfono de contacto</p>";
		}else if(!preg_match("/^[0-9]{9}$/", $nuevoUsuario["tlfn"])){
			$errores[] = "<p>Formato de numero de teléfono incorrecto: " . $nuevoUsuario["tlfn"]. "</p>";
		}
		//Validacion codigo postal 5 digitos
		if ($nuevoUsuario["codigoPostal"] == ""){
			$errores[] = "<p>No puedes continuar sin poner tu código postal</p>";
		}else if(!preg_match("/^[0-9]{5}$/", $nuevoUsuario["codigoPostal"])){
			$errores[] = "<p>El código postal debe tener 5 numeros: " . $nuevoUsuario["codigoPostal"]. "</p>";
		}
		
		// Validación email
		if ($nuevoUsuario["email"] == ""){
			$errores[] = "<p>No puedes continuar sin poner tu email de contacto</p>";
		}else if(!filter_var($nuevoUsuario["email"], FILTER_VALIDATE_EMAIL)){
			$errores[] = $error . "<p>El email es incorrecto: " . $nuevoUsuario["email"]. "</p>";
		}
		
		//Validacion fecha vacia
		if ($nuevoUsuario["fechaNacimiento"] == ""){
			$errores[] = "<p>La fecha de nacimiento no puede estar vacía</p>";
			
		// Validación del perfil
	
		if(($nuevoUsuario["categoria"] != "GERENTE" && $nuevoUsuario["categoria"] != "CAMARERO" && $nuevoUsuario["categoria"] != "COCINERO")){
		$errores[]= "<p>Debe seleccionar un perfil de empleado</p>";
	}
			
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
		if ($nuevoUsuario["pass"] == ""){
			$errores[] = "<p>No puedes continuar sin poner una contraseña para loguearte</p>";
		}else if(strlen($nuevoUsuario["pass"])<8){
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

