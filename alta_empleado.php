<?php
	session_start();

	require_once("gestionBD.php");
	require_once("gestion_empleados.php");
	
	$fechaHoy = date('d-m-Y');
 	$fechaHoyFormateada = date('d/m/Y', strtotime($fechaHoy));
	$fechaBaja = date('d-m-Y',strtotime($fechaHoy . "+ 6 month"));
	$fechaBajaFormateada = date('d/m/Y', strtotime($fechaBaja));
	
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
  <title>Bar Blanca Paloma: Alta de empleado realizada con éxito</title>
</head>

<body>
	<?php
		include_once("header.html");
	?>

	<main>
		<?php 
			if (alta_empleado($conexion, $nuevoUsuario)) {  
                $nuevoUsuario['pass'] = null;
                $nuevoUsuario['confirmpass'] = null;
				$_SESSION['login'] = $nuevoUsuario;	
		?>
			<p>Hola <?php echo $nuevoUsuario["nombre"]; ?>, has sido dado de alta en nuestra página correctamente con los siguientes datos:</p>
			<ul>
				<li><?php echo "NIF: " . $nuevoUsuario["nif"]; ?></li>
				<li><?php echo "Nombre: " . $nuevoUsuario["nombre"]; ?></li>
				<li><?php echo "Apellidos: " . $nuevoUsuario["apellidos"]; ?></li>
				<li><?php echo "Teléfono: " . $nuevoUsuario["tlfn"]; ?></li>
				<li><?php echo "Población: " . $nuevoUsuario["poblacion"]; ?></li>
				<li><?php echo "CodigoPostal: " . $nuevoUsuario["codigoPostal"]; ?></li>
				<li><?php echo "Fecha de alta: " . $fechaHoyFormateada; ?></li>
				<li><?php echo "Fecha de baja: " . $fechaBajaFormateada; ?></li>
				<li><?php echo "Categoria: " . $nuevoUsuario["categoria"]; ?></li>
			</ul>
			<div >	
				Pulsa <a href="menu.php">aquí</a> para acceder a la pagina del bar.
			</div>
		<?php } else { ?>
			<p>Ya hay un empleado con esos datos.</p>
			<div>	
				Pulsa <a href="registro_usuario.php">aquí</a> para volver al formulario de registro.
			</div>
		<?php } ?>

	</main>
</body>
</html>
<?php
	cerrarConexionBD($conexion);
?>
