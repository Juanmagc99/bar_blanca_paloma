<?php
	session_start();
	
	include_once("gestionBD.php");
	include_once("gestion_empleados.php");
	
	
	if (isset($_POST["submit"])){
		$nif = $_POST["nif"];
		$pass = $_POST["pass"];
		
		$datos["nif"] = $_POST["nif"];
		$datos["pass"] = $_POST["pass"];
		
	$errores = validarDatos($datos);
	
	if($errores == "") {
			
	$conexion = crearConexionBD();
	$empleados = consultarEmpleado($conexion, $nif, $pass);
	$categoria = consultarCategoriaEmpleado($conexion, $nif, $pass);
	cerrarConexionBD($conexion);
	
	if ($empleados == 0){
		$login = "error";
	} else {
	    $usuario["nif"] = $nif;
        $usuario["categoria"] = $categoria;
		$_SESSION["login"] = $usuario;
		header("Location: menu.php");
	}
}
	}

	
	function validarDatos($datos){
		
	$errores = "";
		
	if($datos["nif"] == ""){
		$errores[] = "<p>El nif no puede estar vacio</p>";
	} else if (!preg_match("/^[0-9]{8}[A-Z]$/", $datos['nif'])){
			$errores[] = "<p>El nif son 8 números y una letra</p>";
		}
	
	if($datos["pass"] == ""){
		$errores[] = "<p>La contraseña de acceso no puede estar vacia</p>";
	}else if(strlen($datos["pass"])<8){
		$errores [] = "<p>Contraseña no válida: debe tener al menos 8 caracteres</p>";
	}else if(!preg_match("/[a-z]+/", $datos["pass"]) || !preg_match("/[A-Z]+/", $datos["pass"]) || !preg_match("/[0-9]+/", $datos["pass"])){
		$errores[] = "<p>Contraseña no válida: debe contener letras mayúsculas, minúsculas y dígitos</p>";
	}
		return $errores;
	}	

?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/login_session.css" />
	<script src="js/validacion_login.js" type="text/javascript"></script>
	<title>Pagina login</title>
</head>
<body>
</br>

<div class=centrado>
<img src=https://cdn.discordapp.com/attachments/645379804564029440/702833590542663730/Paloma.png>
</div>

<div class=centrado>
	
<h1>Bar Blanca Paloma</h1>

<?php if (isset($login)) {
		echo "<div class=\"error\">";
		echo "No existe ningun empleado con los datos introducidos";
		echo "</div>";
	}	

	if (isset($errores) && count($errores)>0) { 
	    	echo "<div id=\"div_errores\" class=\"error\">";
    		foreach($errores as $error) echo $error; 
    		echo "</div>";
  		}
	?>
	
	<form id="loginForm" action="login_sesion.php" method="post" onsubmit="return validateForm()">
		<input id="nif" name="nif" type="text" placeholder="NIF..." pattern="^[0-9]{8}[A-Z]" title="8 dígitos y una letra mayúscula" required/> </br></br>
		<input id="pass" name="pass" type="password" placeholder="Password..." required oninput="passwordValidation();"/>
    	</br></br>
		<input type="submit" class="entrar" name="submit" value="Iniciar sesión">
	</form>
	</br>
	<p>SI ERES UN NUEVO EMPLEADO REGISTRATE PULSANDO <a href="registro_usuario.php">AQUÍ</a></p>

</div>
</main>

</body>
</html>