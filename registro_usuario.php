<?php
	session_start();

	if (!isset($_SESSION['formulario'])) {
		$formulario['nif'] = "";
		$formulario['nombre'] = "";
		$formulario['apellidos'] = "";
		$formulario['tlfn'] = "";
		$formulario['poblacion'] = "";
		$formulario['codigoPostal'] = "";
		$formulario['perfil'] = "Cliente";
		$formulario['fechaNacimiento'] = "";
		$formulario['email'] = "";
		
		$formulario['pass'] = "";
		$formulario['confirmPass'] = "";
	
		$_SESSION['formulario'] = $formulario;
	}
	else
		$formulario = $_SESSION['formulario'];
			
	if (isset($_SESSION["errores"]))
		$errores = $_SESSION["errores"];
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="css/registro_usuario.css" />
  <title>Gestión de Bar Blanca Paloma: Alta de Usuarios</title>
</head>

<body>
	<?php
		include_once("Header.html");
	?>
	
	<?php 
		// Mostrar los erroes de validación (Si los hay)
		if (isset($errores) && count($errores)>0) { 
	    	echo "<div id=\"div_errores\" class=\"error\">";
			echo "<h4> Errores en el formulario:</h4>";
    		foreach($errores as $error) echo $error; 
    		echo "</div>";
  		}
	?>
	
	<form id="altaUsuario" method="get" action="validacion_registro_usuario.php" novalidate>
		<p><i>TODOS LOS CAMPOS A RELLENAR SON DE CARACTER OBLIGATORIO</i><em>*</em></p>
		<fieldset><legend>Datos personales</legend>
			
			<div></div><label for="nif">NIF:</label>
			<input id="nif" name="nif" type="text" placeholder="12345678X" pattern="^[0-9]{8}[A-Z]" title="Ocho dígitos seguidos de una letra mayúscula" value="<?php echo $formulario['nif'];?>" required>
			</div>
			
			<div><label for="nombre">Nombre:</label>
			<input id="nombre" name="nombre" type="text" size="40" value="<?php echo $formulario['nombre'];?>" required/>
			</div>

			<div><label for="apellidos">Apellidos:</label>
			<input id="apellidos" name="apellidos" type="text" size="80" value="<?php echo $formulario['apellidos'];?>" required/>
			</div>
			
			<div><label for="tlfn">Numero de teléfono:</label>
			<input id="tlfn" name="tlfn" type="text" placeholder="p.e. 954334455" size="80" value="<?php echo $formulario['tlfn'];?>" required/>
			</div>
			
			<div>
				<label for="poblacion">Poblacion:</label>
				<input list="opcionesPoblacion" name="poblacion" id="poblacion" 
					value="<?php if ($formulario['poblacion'] != "") echo $formulario['poblacion'];?>" 
					required/>
				<datalist id="opcionesPoblacion">
				  	<option value="CD">Cádiz</option>
					<option value="SV">Sevilla</option>
					<option value="MA">Málaga</option>
					<option value="HU">Huelva</option>
					<option value="CO">Córdoba</option>
					<option value="JA">Jaén</option>
					<option value="AL">Almería</option>
					<option value="GR">Granada</option>
					<option value="OT">Otra</option>
				</datalist>
				</div>
			
			<div><label for="codigoPostal">Código Postal:</label>
			<input id="codigoPostal" name="codigoPostal" type="text" size="80" value="<?php echo $formulario['codigoPostal'];?>" required/>
			</div>
			
			<div><label>Perfil:</label>
			<label>
				<input name="perfil" type="radio" value="Cliente" checked="checked"<?php if($formulario['perfil']=='Cliente') echo ' checked ';?>/>
				Cliente</label>
			<label>
				<input name="perfil" type="radio" value="Empleado" <?php if($formulario['perfil']=='Empleado') echo ' checked ';?>/>
				Empleado</label>
			</div>
			
			<div<<label for="fechaNacimiento">Fecha de nacimiento:</label>
			<input type="date" id="fechaNacimiento" name="fechaNacimiento" value="<?php echo $formulario['fechaNacimiento'];?>" required/>
			</div>

			<div><label for="email">Email:</label>
			<input id="email" name="email"  type="email" placeholder="usuario@dominio.extension" value="<?php echo $formulario['email'];?>" required/><br>
			</div>
		</fieldset>

		<fieldset><legend>Datos de cuenta</legend>
			<div><label for="pass">Password:<em>*</em></label>
			<input type="password" name="pass" id="pass" placeholder="Mínimo 8 caracteres entre letras minúsculas y mayúsculas, ademas de dígitos" required/>
			</div>
			<div><label for="confirmpass">Confirmar Password:</label>
			<input type="password" name="confirmpass" id="confirmpass" placeholder="Confirmación de contraseña" required />
			</div>
		</fieldset>

		<div><input type="submit" value="Enviar" /></div>

	</form>

	</body>
</html>
