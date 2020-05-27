<?php
	session_start();

	require_once("gestionBD.php");
	require_once("gestionProductos.php");
	
	if (isset($_SESSION["producto"])){
		$producto = $_SESSION["producto"];
		unset($_SESSION["producto"]);
	}

	$conexion = crearConexionBD();
	$filas = consultarProductos($conexion);
	cerrarConexionBD($conexion);
	
	
	$productos = array();
	foreach ($filas as $fila) {
		array_push($productos, $fila);
	}

?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/adminCarta.css">
	<title>adminCarta</title>
</head>
<body>
	
<div>
        <?php
            include_once("Header.html");
        ?>
</div>
	
<div class="divHome">
    <table class="tableHome">
    <tr>
    	<th class="home"><a class="enlaceHome" href="menu.html">Home</a></button>
    </table>
</div>

<div class="adminPaginas">
	<table class="tablaEnlaces">
	<tr>
		<th class="botonCarta"><a class="enlace" href="adminCarta.php">Gestión Carta</a></th>
		<th class="boton"><a class="enlace" href="adminMesas.php">Gestión Mes</a></th>
		<th class="boton"><a class="enlace" href="adminEmpleados.php">Empleados</a></th>
		<th class="boton"><a class="enlace" href="adminEstadisticas.php">Estadisticas</a></th>
	</tr>
    </table>
</div>

<div class="tab">
  <button class="tablinks" onclick="abrirProducto(event, 'Medias')" id="default">Medias</button>
  <button class="tablinks" onclick="abrirProducto(event, 'Combinados')">Combinados</button>
  <button class="tablinks" onclick="abrirProducto(event, 'Carnes')">Carnes</button>
  <button class="tablinks" onclick="abrirProducto(event, 'Pescados')">Pescados</button>
  <button class="tablinks" onclick="abrirProducto(event, 'Bebidas')">Bebidas</button>
  <button class="tablinks" onclick="abrirProducto(event, 'Postres')">Postres</button>
</div>

<div id="Medias" class="tabcontent">
  <table class="tablaCarta">
	<tr>
		<th class="celdaNombre1">Nombre</th>
    	<th class="celdaPrecio1">Precio</th>
        <th class="blanco"></th>
        <th class="blanco1"></th>
	</tr>
    <?php foreach ($productos as $media){
    	 		if($media["DESCRIPCION"] == 'Media') { ?>
	<tr>
		<form method="post" action="controlador_productos.php">
			<input id="ID_PRODUCTO" name="ID_PRODUCTO" type="hidden" value="<?php echo $media["ID_PRODUCTO"]; ?>" />
			<input id="NOMBRE_PRODUCTO1" name="NOMBRE_PRODUCTO1" type="hidden" value="<?php echo $media["NOMBRE_PRODUCTO1"]; ?>" />
			<input id="PRECIO_PRODUCTO" name="PRECIO_PRODUCTO" type="hidden" value="<?php echo $media["PRECIO_PRODUCTO"]; ?>" />
			<input id="DESCRIPCION" name="DESCRIPCION" type="hidden" value="<?php echo $media["DESCRIPCION"]; ?>" /> 
			<input id="CANTIDAD" name="CANTIDAD" type="hidden" value="<?php echo $media["CANTIDAD"]; ?>" />
			
			<?php 
			if (isset($producto) and ($producto["NOMBRE_PRODUCTO1"] == $media["NOMBRE_PRODUCTO1"])) { ?>
			<td class="celdaNombre"><?php echo $media["NOMBRE_PRODUCTO1"] ?></td>
    		<td class="celdaPrecio""><input id="PRECIO_PRODUCTO" name="PRECIO_PRODUCTO" value="<?php echo $media["PRECIO_PRODUCTO"] ?>"/></td>
    		<?php }	else { ?>
    		<input id="PRECIO_PRODUCTO" name="PRECIO_PRODUCTO" type="hidden" value="<?php echo $media["PRECIO_PRODUCTO"]; ?>"/>
    		<td class="celdaNombre"><?php echo $media["NOMBRE_PRODUCTO1"] ?></td>
    		<td class="celdaPrecio"><?php echo $media["PRECIO_PRODUCTO"] ?></td>
    		<?php } ?>
    		
        	<td class="edit">
        		<?php if (isset($producto) and ($producto["NOMBRE_PRODUCTO1"] == $media["NOMBRE_PRODUCTO1"])) { ?>
        			<button type="submit" id="grabar" name="grabar" class="botonEditar">OK</button>
        		<?php } else {?>
        			<button type="submit" id="editar" name="editar" class="botonEditar">Edit</button></td>
        		<?php } ?>
        	<td class="delete">
        		<button type="submit" id="borrar" name="borrar" class="botonDelete">Delete</button></td> 
		</form>
	</tr>
       <?php
        }
        }
        ?>
  </table>
</div>

<div id="Combinados" class="tabcontent">
   <table class="tablaCarta">
	<tr>
		<th class="celdaNombre1">Nombre</th>
    	<th class="celdaPrecio1">Precio</th>
    	<th class="blanco"></th>
        <th class="blanco1"></th>
	</tr>
	<?php foreach ($productos as $combinado) { if($combinado["DESCRIPCION"] == 'Combinado') { ?>
	<tr>
		<form method="post" action="controlador_productos.php">
			<input id="ID_PRODUCTO" name="ID_PRODUCTO" type="hidden" value="<?php echo $combinado["ID_PRODUCTO"]; ?>" />
			<input id="NOMBRE_PRODUCTO1" name="NOMBRE_PRODUCTO1" type="hidden" value="<?php echo $combinado["NOMBRE_PRODUCTO1"]; ?>" />
			<input id="PRECIO_PRODUCTO" name="PRECIO_PRODUCTO" type="hidden" value="<?php echo $combinado["PRECIO_PRODUCTO"]; ?>" />
			<input id="DESCRIPCION" name="DESCRIPCION" type="hidden" value="<?php echo $combinado["DESCRIPCION"]; ?>" /> 
			<input id="CANTIDAD" name="CANTIDAD" type="hidden" value="<?php echo $combinado["CANTIDAD"]; ?>" />
			
			<?php 
			if (isset($producto) and ($producto["NOMBRE_PRODUCTO1"] == $combinado["NOMBRE_PRODUCTO1"])) { ?>
			<td class="celdaNombre"><?php echo $combinado["NOMBRE_PRODUCTO1"] ?></td>
    		<td class="celdaPrecio"><input id="PRECIO_PRODUCTO" name="PRECIO_PRODUCTO" value="<?php echo $combinado["PRECIO_PRODUCTO"] ?>"/></td>
    		<?php }	else { ?>
    		<input id="PRECIO_PRODUCTO" name="PRECIO_PRODUCTO" type="hidden" value="<?php echo $combinado["PRECIO_PRODUCTO"]; ?>"/>
    		<td class="celdaNombre"><?php echo $combinado["NOMBRE_PRODUCTO1"] ?></td>
    		<td class="celdaPrecio"><?php echo $combinado["PRECIO_PRODUCTO"] ?></td>
    		<?php } ?>
    		
        	<td class="edit">
        		<?php if (isset($producto) and ($producto["NOMBRE_PRODUCTO1"] == $combinado["NOMBRE_PRODUCTO1"])) { ?>
        			<button type="submit" id="grabar" name="grabar" class="botonEditar">OK</button>
        		<?php } else {?>
        			<button type="submit" id="editar" name="editar" class="botonEditar">Edit</button></td>
        		<?php } ?>
        	<td class="delete">
        		<button type="submit" id="borrar" name="borrar" class="botonDelete">Delete</button></td> 
		</form>
	</tr>
       <?php
        }
        }
        ?>
  </table>
</div>

<div id="Carnes" class="tabcontent">
   <table class="tablaCarta">
	<tr>
		<th class="celdaNombre1">Nombre</th>
    	<th class="celdaPrecio1">Precio</th>
    	<th class="blanco"></th>
        <th class="blanco1"></th>
	</tr>
	<?php foreach ($productos as $carne){ if($carne["DESCRIPCION"] == 'Carne') { ?>
	<tr>
		<form method="post" action="controlador_productos.php">
			<input id="ID_PRODUCTO" name="ID_PRODUCTO" type="hidden" value="<?php echo $carne["ID_PRODUCTO"]; ?>" />
			<input id="NOMBRE_PRODUCTO1" name="NOMBRE_PRODUCTO1" type="hidden" value="<?php echo $carne["NOMBRE_PRODUCTO1"]; ?>" />
			<input id="PRECIO_PRODUCTO" name="PRECIO_PRODUCTO" type="hidden" value="<?php echo $carne["PRECIO_PRODUCTO"]; ?>" />
			<input id="DESCRIPCION" name="DESCRIPCION" type="hidden" value="<?php echo $carne["DESCRIPCION"]; ?>" /> 
			<input id="CANTIDAD" name="CANTIDAD" type="hidden" value="<?php echo $carne["CANTIDAD"]; ?>" />
			
			<?php 
			if (isset($producto) and ($producto["NOMBRE_PRODUCTO1"] == $carne["NOMBRE_PRODUCTO1"])) { ?>
			<td class="celdaNombre"><?php echo $carne["NOMBRE_PRODUCTO1"] ?></td>
    		<td class="celdaPrecio"><input id="PRECIO_PRODUCTO" name="PRECIO_PRODUCTO" value="<?php echo $carne["PRECIO_PRODUCTO"] ?>"/></td>
    		<?php }	else { ?>
    		<input id="PRECIO_PRODUCTO" name="PRECIO_PRODUCTO" type="hidden" value="<?php echo $carne["PRECIO_PRODUCTO"]; ?>"/>
    		<td class="celdaNombre"><?php echo $carne["NOMBRE_PRODUCTO1"] ?></td>
    		<td class="celdaPrecio"><?php echo $carne["PRECIO_PRODUCTO"] ?></td>
    		<?php } ?>
    		
        	<td class="edit">
        		<?php if (isset($producto) and ($producto["NOMBRE_PRODUCTO1"] == $carne["NOMBRE_PRODUCTO1"])) { ?>
        			<button type="submit" id="grabar" name="grabar" class="botonEditar">OK</button>
        		<?php } else {?>
        			<button type="submit" id="editar" name="editar" class="botonEditar">Edit</button></td>
        		<?php } ?>
        	<td class="delete">
        		<button type="submit" id="borrar" name="borrar" class="botonDelete">Delete</button></td> 
		</form>
	</tr>
       <?php
        }
        }
        ?>
  </table>
</div>

<div id="Pescados" class="tabcontent">
   <table class="tablaCarta">
	<tr>
		<th class="celdaNombre1">Nombre</th>
    	<th class="celdaPrecio1">Precio</th>
    	<th class="blanco"></th>
        <th class="blanco1"></th>
	</tr>
	<?php foreach ($productos as $pescado){ if($pescado["DESCRIPCION"] == 'Pescado') { ?>
	<tr>
		<form method="post" action="controlador_productos.php">
			<input id="ID_PRODUCTO" name="ID_PRODUCTO" type="hidden" value="<?php echo $pescado["ID_PRODUCTO"]; ?>" />
			<input id="NOMBRE_PRODUCTO1" name="NOMBRE_PRODUCTO1" type="hidden" value="<?php echo $pescado["NOMBRE_PRODUCTO1"]; ?>" />
			<input id="PRECIO_PRODUCTO" name="PRECIO_PRODUCTO" type="hidden" value="<?php echo $pescado["PRECIO_PRODUCTO"]; ?>" />
			<input id="DESCRIPCION" name="DESCRIPCION" type="hidden" value="<?php echo $pescado["DESCRIPCION"]; ?>" /> 
			<input id="CANTIDAD" name="CANTIDAD" type="hidden" value="<?php echo $pescado["CANTIDAD"]; ?>" />
			
			<?php 
			if (isset($producto) and ($producto["NOMBRE_PRODUCTO1"] == $pescado["NOMBRE_PRODUCTO1"])) { ?>
			<td class="celdaNombre"><?php echo $pescado["NOMBRE_PRODUCTO1"] ?></td>
    		<td class="celdaPrecio"><input id="PRECIO_PRODUCTO" name="PRECIO_PRODUCTO" value="<?php echo $pescado["PRECIO_PRODUCTO"] ?>"/></td>
    		<?php }	else { ?>
    		<input id="PRECIO_PRODUCTO" name="PRECIO_PRODUCTO" type="hidden" value="<?php echo $pescado["PRECIO_PRODUCTO"]; ?>"/>
    		<td class="celdaNombre"><?php echo $pescado["NOMBRE_PRODUCTO1"] ?></td>
    		<td class="celdaPrecio"><?php echo $pescado["PRECIO_PRODUCTO"] ?></td>
    		<?php } ?>
    		
        	<td class="edit">
        		<?php if (isset($producto) and ($producto["NOMBRE_PRODUCTO1"] == $pescado["NOMBRE_PRODUCTO1"])) { ?>
        			<button type="submit" id="grabar" name="grabar" class="botonEditar">OK</button>
        		<?php } else {?>
        			<button type="submit" id="editar" name="editar" class="botonEditar">Edit</button></td>
        		<?php } ?>
        	<td class="delete">
        		<button type="submit" id="borrar" name="borrar" class="botonDelete">Delete</button></td> 
		</form>
	</tr>
       <?php
        }
        }
        ?>
    </table>
</div>

<div id="Bebidas" class="tabcontent">
   <table class="tablaCarta">
	<tr>
		<th class="celdaNombre1">Nombre</th>
    	<th class="celdaPrecio1">Precio</th>
    	<th class="blanco"></th>
        <th class="blanco1"></th>
	</tr>
	<?php foreach ($productos as $bebida){ if($bebida["DESCRIPCION"] == 'Bebida') { ?>
	<tr>
		<form method="post" action="controlador_productos.php">
			<input id="ID_PRODUCTO" name="ID_PRODUCTO" type="hidden" value="<?php echo $bebida["ID_PRODUCTO"]; ?>" />
			<input id="NOMBRE_PRODUCTO1" name="NOMBRE_PRODUCTO1" type="hidden" value="<?php echo $bebida["NOMBRE_PRODUCTO1"]; ?>" />
			<input id="PRECIO_PRODUCTO" name="PRECIO_PRODUCTO" type="hidden" value="<?php echo $bebida["PRECIO_PRODUCTO"]; ?>" />
			<input id="DESCRIPCION" name="DESCRIPCION" type="hidden" value="<?php echo $bebida["DESCRIPCION"]; ?>" /> 
			<input id="CANTIDAD" name="CANTIDAD" type="hidden" value="<?php echo $bebida["CANTIDAD"]; ?>" />
			
			<?php 
			if (isset($producto) and ($producto["NOMBRE_PRODUCTO1"] == $bebida["NOMBRE_PRODUCTO1"])) { ?>
			<td class="celdaNombre"><?php echo $bebida["NOMBRE_PRODUCTO1"] ?></td>
    		<td class="celdaPrecio"><input id="PRECIO_PRODUCTO" name="PRECIO_PRODUCTO" value="<?php echo $bebida["PRECIO_PRODUCTO"] ?>"/></td>
    		<?php }	else { ?>
    		<input id="PRECIO_PRODUCTO" name="PRECIO_PRODUCTO" type="hidden" value="<?php echo $bebida["PRECIO_PRODUCTO"]; ?>"/>
    		<td class="celdaNombre"><?php echo $bebida["NOMBRE_PRODUCTO1"] ?></td>
    		<td class="celdaPrecio"><?php echo $bebida["PRECIO_PRODUCTO"] ?></td>
    		<?php } ?>
    		
        	<td class="edit">
        		<?php if (isset($producto) and ($producto["NOMBRE_PRODUCTO1"] == $bebida["NOMBRE_PRODUCTO1"])) { ?>
        			<button type="submit" id="grabar" name="grabar" class="botonEditar">OK</button>
        		<?php } else {?>
        			<button type="submit" id="editar" name="editar" class="botonEditar">Edit</button></td>
        		<?php } ?>
        	<td class="delete">
        		<button type="submit" id="borrar" name="borrar" class="botonDelete">Delete</button></td> 
		</form>
	</tr>
       <?php
        }
        }
        ?>
    </table>
</div>

<div id="Postres" class="tabcontent">
   <table class="tablaCarta">
	<tr>
		<th class="celdaNombre1">Nombre</th>
    	<th class="celdaPrecio1">Precio</th>
    	<th class="blanco"></th>
        <th class="blanco1"></th>
	</tr>
	<?php foreach ($productos as $postre){ if($postre["DESCRIPCION"] == 'Postre') { ?>
	<tr>
		<form method="post" action="controlador_productos.php">
			<input id="ID_PRODUCTO" name="ID_PRODUCTO" type="hidden" value="<?php echo $postre["ID_PRODUCTO"]; ?>" />
			<input id="NOMBRE_PRODUCTO1" name="NOMBRE_PRODUCTO1" type="hidden" value="<?php echo $postre["NOMBRE_PRODUCTO1"]; ?>" />
			<input id="PRECIO_PRODUCTO" name="PRECIO_PRODUCTO" type="hidden" value="<?php echo $postre["PRECIO_PRODUCTO"]; ?>" />
			<input id="DESCRIPCION" name="DESCRIPCION" type="hidden" value="<?php echo $postre["DESCRIPCION"]; ?>" /> 
			<input id="CANTIDAD" name="CANTIDAD" type="hidden" value="<?php echo $postre["CANTIDAD"]; ?>" />
			
			<?php 
			if (isset($producto) and ($producto["NOMBRE_PRODUCTO1"] == $postre["NOMBRE_PRODUCTO1"])) { ?>
			<td class="celdaNombre"><?php echo $postre["NOMBRE_PRODUCTO1"] ?></td>
    		<td class="celdaPrecio"><input id="PRECIO_PRODUCTO" name="PRECIO_PRODUCTO" value="<?php echo $postre["PRECIO_PRODUCTO"] ?>"/></td>
    		<?php }	else { ?>
    		<input id="PRECIO_PRODUCTO" name="PRECIO_PRODUCTO" type="hidden" value="<?php echo $postre["PRECIO_PRODUCTO"]; ?>"/>
    		<td class="celdaNombre"><?php echo $postre["NOMBRE_PRODUCTO1"] ?></td>
    		<td class="celdaPrecio"><?php echo $postre["PRECIO_PRODUCTO"] ?></td>
    		<?php } ?>
    		
        	<td class="edit">
        		<?php if (isset($producto) and ($producto["NOMBRE_PRODUCTO1"] == $postre["NOMBRE_PRODUCTO1"])) { ?>
        			<button type="submit" id="grabar" name="grabar" class="botonEditar">OK</button>
        		<?php } else {?>
        			<button type="submit" id="editar" name="editar" class="botonEditar">Edit</button></td>
        		<?php } ?>
        	<td class="delete">
        		<button type="submit" id="borrar" name="borrar" class="botonDelete">Delete</button></td> 
		</form>
	</tr>
       <?php
        }
        }
        ?>
    </table>
</div>


<script>
function abrirProducto(tipoProducto, tablaProductos) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" cursor", "");
  }
  document.getElementById(tablaProductos).style.display = "block";
  tipoProducto.currentTarget.className += " cursor";
}

// Coge el elemento con id="default" y lo pone como abierto al abrir la pagina
document.getElementById("default").click();
</script>
 
</body>
</html>
