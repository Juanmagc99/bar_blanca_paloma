<?php
	session_start();
	
	include_once("gestionBD.php");
	include_once("gestion_clientes.php");
	include_once("gestion_empleados.php");
	
	if (isset($_POST['submit'])){
	
	//lo que piden a los clientes
		$nombre = $_POST['nombre'];
		$tlfn = $_POST['tlfn'];
	
	//lo que piden a los empleados	
		$nif = $_POST['nif'];
		$pass = $_POST['pass'];
		
		
	$conexion = crearConexionBD();
	$clientes = consultarCliente($conexion, $nombre, $tlfn);
	$empleados = consultarEmpleado($conexion, $nif, $pass);
	
	if ($clientes == 0 && $empleados == 0){
		$login = "error";
	} else if ($empleados == 0){
		$_SESSION['login'] = $nombre;
		header("Location: menu.html");
	} else if ($clientes == 0){
		$_SESSION['login'] = $nif;
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

<?php if (isset($login)) {
		echo "<div class=\"error\">";
		echo "No existe ningun cliente ni empleado con esos datos introducidos";
		echo "</div>";
	}	
	?>

<form action="login_sesion.php" method="post">
	<input id="user" name="user" type="text" placeholder="User..." required/>	</br></br>
	<input id="password" name="password" type="text" placeholder="Password..." required/>
    </br></br>
<input type="submit" name="submit" value="submit">

<p>¿No estás registrado?<a href="registro_usuario.php">Registrate</a></p>

</div>

</body>
</html>