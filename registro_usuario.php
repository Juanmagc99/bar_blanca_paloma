<?php
	session_start();

	if (!isset($_SESSION['formulario'])) {
		
		$formulario['nif'] = "";
		$formulario['nombre'] = "";
		$formulario['apellidos'] = "";
		$formulario['tlfn'] = "";
		$formulario['poblacion'] = "";
		$formulario['codigoPostal'] = "";
		$formulario['categoria'] = "CAMARERO";
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
  <link rel="stylesheet" type="text/css" href="../../../Users/Juanma/Desktop/Blanca%20Paloma%20Prada/css/registro_usuario.css"/>
  <script src="js/validacion_registro_usuario.js" type="text/javascript"></script>
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
			echo "<h4> Ha cometido errores al realizar el formulario:</h4>";
    		foreach($errores as $error) echo $error; 
    		echo "</div>";
  		}
	?>
	
	<form id="altaUsuario" method="get" action="validacion_registro_usuario.php" onsubmit="return validateForm()">
		<p><i>TODOS LOS CAMPOS A RELLENAR SON DE CARÁCTER OBLIGATORIO</i></p>
		<fieldset><legend>Datos personales</legend>
			
			<div></div><label for="nif">NIF:</label>
			<input id="nif" name="nif" type="text" placeholder="12345678X" size="20" pattern="^[0-9]{8}[A-Z]" title="8 dígitos y una letra mayúscula" value="<?php echo $formulario['nif'];?>" required>
			</div>
			
			<div><label for="nombre">Nombre:</label>
			<input id="nombre" name="nombre" type="text" size="30" pattern="[A-Za-z]+" title="Tu nombre no puede tener números o caractéres especiales..." value="<?php echo $formulario['nombre'];?>" required/>
			</div>

			<div><label for="apellidos">Apellidos:</label>
			<input id="apellidos" name="apellidos" type="text" size="40" pattern="[A-Za-z ]+" title="Tus apellidos no pueden tener números o caractéres especiales..." value="<?php echo $formulario['apellidos'];?>" required/>
			</div>
			
			<div><label for="tlfn">Numero de teléfono:</label>
			<input id="tlfn" name="tlfn" type="text" placeholder="p.e. 954334455" size="25" pattern="[0-9]{9}" title="9 números" value="<?php echo $formulario['tlfn'];?>" required/>
			</div>
			
			<div>
				<label for="poblacion">Poblacion:</label>
				<input list="opcionesPoblacion" name="poblacion" id="poblacion" placeholder="Click dos veces..."
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
			<input id="codigoPostal" name="codigoPostal" type="text" placeholder="p.e. 41000" size="20" pattern="[0-9]{5}" title="5 números" value="<?php echo $formulario["codigoPostal"];?>" required/>
			</div>
			
			<div><label for="categoria">Categoría:</label>
			<label>
				<input class="opciones" name="categoria" type="radio" value="GERENTE" <?php if($formulario['categoria']=='GERENTE') echo ' checked ';?>/>
				Gerente</label>
			<label>
				<input class="opciones" name="categoria" type="radio" value="CAMARERO" <?php if($formulario['categoria']=='CAMARERO') echo ' checked ';?>/>
				Camarero</label>
			<label>
				<input class="opciones" name="categoria" type="radio" value="COCINERO" <?php if($formulario['categoria']=='COCINERO') echo ' checked ';?>/>
				Cocinero</label>
			</div>
		
			<div<<label for="fechaNacimiento">Fecha de nacimiento:</label>
			<input type="date" id="fechaNacimiento" name="fechaNacimiento" value="<?php echo $formulario['fechaNacimiento'];?>" required/>
			</div>

			<div><label for="email">Email:</label>
			<input id="email" name="email" type="email" placeholder="usuario@dominio.extension" size="40" value="<?php echo $formulario['email'];?>" required/><br>
			</div>
		</fieldset>

		<fieldset><legend>Datos de cuenta</legend>
			<div><label for="pass">Password:<em>*</em></label>
			<input type="password" name="pass" id="pass" size="70" title="8 caracteres con letras minúsculas y mayúsculas, ademas de dígitos" required oninput="passwordValidation()"/>
			</div>
			<div><label for="confirmpass">Confirmar Password:</label>
			<input type="password" name="confirmpass" id="confirmpass" size="60" placeholder="Confirmación de contraseña" required oninput="passwordConfirmation()"/>
			</div>
		</fieldset>

		<div class="botonEnviar"><input class="registro" type="submit" value="Enviar" /></div>

	</form>

	</body>
</html>
