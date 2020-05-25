<?php
	session_start();

	require_once("gestionBD.php");
	require_once("gestion_empleados.php");
	
	$fecha = date('d-m-Y');
	$fechaHoy = date('d/m/Y', strtotime($fecha));
	$fechaBaja = "---";
	
	if (isset($_SESSION["formulario"])) {
		$nuevoUsuario = $_SESSION["formulario"];
		$_SESSION["formulario"] = null;
		$_SESSION["errores"] = null;
	}
	else 
		Header("Location: registro_usuario.php");	

	$conexion = crearConexionBD(); 
	
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Bar Balnca Paloma: Alta de empleado realizada con éxito</title>
</head>

<body>
	<?php
		include_once("header.html");
	?>

	<main>
		<?php 	
			if (alta_empleado($conexion, $nuevoUsuario)) {  //Si la funcion alta_usuario devuelve TRUE 
				$SESSION['login'] = $nuevoUsuario['nif'];	//entonces el login de la sesion de ese empleado sera con el NIF
		?>
			<h1>Hola <?php echo $nuevoUsuario["nombre"]; ?>, has sido dado de alta en nuestra página exitosamente con los siguientes datos:</h1>
			<ul>
				<li><?php echo "NIF: " . $nuevoUsuario["nif"]; ?></li>
				<li><?php echo "Nombre: " . $nuevoUsuario["nombre"]; ?></li>
				<li><?php echo "Apellidos: " . $nuevoUsuario["apellidos"]; ?></li>
				<li><?php echo "Teléfono: " . $nuevoUsuario["tlfn"]; ?></li>
				<li><?php echo "Población: " . $nuevoUsuario["poblacion"]; ?></li>
				<li><?php echo "CodigoPostal: " . $nuevoUsuario["codigoPostal"]; ?></li>
				<li><?php echo "Fecha de alta: " . $fechaHoy; ?></li>
				<li><?php echo "Fecha de baja: " . $fechaBaja; ?></li>
				<li><?php echo "Categoría: " . $nuevoUsuario["categoria"]; ?></li>
			</ul>
			<div >	
				Pulsa <a href="menu.html">aquí</a> para acceder a la pagina del bar.
			</div>
		<?php } else { ?>
			<h1>Ya hay un empleado con esos datos.</h1>
			<div >	
				Pulsa <a href="registro_usuario.php">aquí</a> para volver al formulario de registro.
			</div>
		<?php } ?>

	</main>
</body>
</html>
<?php
	cerrarConexionBD($conexion);
?>
