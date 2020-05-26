<?php
	session_start();
	
	include_once("gestionBD.php");
	include_once("gestion_empleados.php");
	
	if (isset($_POST["submit"])){

	//lo que piden a los empleados	
		$nif = $_POST["nif"];
		$pass = $_POST["pass"];
		
		
	$conexion = crearConexionBD();
	$empleados = consultarEmpleado($conexion, $nif, $pass);
	cerrarConexionBD($conexion);
	
	if ($empleados == 0){
		$login = "error";
	} else {
		$_SESSION["login"] = $nif;
		header("Location: menu.html");
	}
}
		

?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/login_session.css" />
	<title>Pagina login</title>
</head>
<body>
</br>

<div class=centrado>
<img src=https://cdn.discordapp.com/attachments/645379804564029440/702833590542663730/Paloma.png>
</div>

<div class=centrado>
	
<h1>Bar Blanca Paloma</h1>

<main>

<?php if (isset($login)) {
		echo "<div class=\"error\">";
		echo "No existe ningun empleado con los datos introducidos";
		echo "</div>";
	}	
	?>
	</br>
	<form action="login_sesion.php" method="post">
		<input id="nif" name="nif" type="text" placeholder="NIF..." required/>	</br></br>
		<input id="pass" name="pass" type="password" placeholder="Password..." required/>
    	</br></br>
		<input type="submit" name="submit" value="submit">
	</form>

	<p>¿No estás registrado?<a href="registro_usuario.php">Registrate</a></p>

</div>
</main>

</body>
</html>