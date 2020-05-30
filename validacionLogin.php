<?php	

	session_start();

	include_once("gestionBD.php");
	include_once("gestion_empleados.php");
	
	
	if (isset($_SESSION["inicio"])){
		$inicio["nif"] = $_REQUEST["nif"];
		$inicio["pass"] = $_REQUEST["pass"];
		
	}else 
		Header("Location: login_sesion.php");

	$_SESSION["inicio"] = $inicio;

	$errores = validarLogin($inicio);
	if (count($errores)>0) {
		$_SESSION["errores"] = $errores;
		Header('Location: login_sesion.php');
	} else {
		$conexion = crearConexionBD();
		$empleados = consultarEmpleado($conexion, $inicio["nif"], $inicio["pass"]);
		$categoria = consultarCategoriaEmpleado($conexion, $inicio["nif"], $inicio["pass"]);
		cerrarConexionBD($conexion);
	
		if ($empleados == 0){
			$login = "error";
		} else {
	    	$usuario["nif"] = $nif;
        	$usuario["categoria"] = $categoria;
			$_SESSION["login"] = $usuario;
			header("Location: menu.html");
	}
		
}

function validarLogin($inicio){
		
	if($inicio["nif"] == ""){
		$errores[] = "<p>El nif no puede estar vacio</p>";
	} else if (!preg_match("/^[0-9]{8}[A-Z]$/", $inicio['nif'])){
			$errores[] = "<p>El nif son 8 números y una letra</p>";
		}
	
	if($inicio["pass"] == ""){
		$errores[] = "<p>La contraseña de acceso no puede estar vacia</p>";
	}else if(strlen($inicio["pass"])<8){
		$errores [] = "<p>Contraseña no válida: debe tener al menos 8 caracteres</p>";
	}else if(!preg_match("/[a-z]+/", $inicio["pass"]) || 
		!preg_match("/[A-Z]+/", $inicio["pass"]) || !preg_match("/[0-9]+/", $inicio["pass"])){
		$errores[] = "<p>Contraseña no válida: debe contener letras mayúsculas y minúsculas y dígitos</p>";
	}
		return $errores;	
	}
	
?>	