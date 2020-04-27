<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/adminCarta.css">
	<title>adminCarta</title>
</head>
<body>
	
<div class=divHome>
    <table class=tableHome>
    <tr>
    	<th class=home><a class=enlaceHome href="menu.html">Home</a></button>
    </table>
</div>

<div class=adminPaginas>
	<table class=tablaEnlaces>
	<tr>
		<th class=botonCarta><a class=enlace href="adminCarta.php">Gestión Carta</a></th>
		<th class=boton><a class=enlace href="adminMesas.php">Gestión Mes</a></th>
		<th class=boton><a class=enlace href="adminEmpleados.php">Empleados</a></th>
		<th class=boton><a class=enlace href="adminEstadisticas.php">Estadisticas</a></th>
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
  <table class=tablaCarta>
	<tr>
		<th class=celdaNombre1>Nombre</th>
    	<th class=celdaPrecio1>Precio</th>
        <th class=blanco></th>
        <th class=blanco1></th>
	</tr>
    
	<tr>
		<td class=celdaNombre>xd</td>
    	<td class=celdaPrecio>xddd</td>
        <td class=edit><button type="submit" class=botonEditar>Edit</button></td>
        <td class=delete><button type="reset" class=botonDelete>Delete</button></td> 
	</tr>
    
    <tr>
		<td class=celdaNombre>Prueba para ver si el tab se agranda </td>
    	<td class=celdaPrecio>cuando añado fila a la tabla</td>
        <td class=edit><button type="submit" class=botonEditar>Edit</button></td>
        <td class=delete><button type="reset" class=botonDelete>Delete</button></td>
	</tr>
    
    <tr>
		<td class=celdaNombre>Viva</td>
    	<td class=celdaPrecio>España</td>
        <td class=edit><button type="submit" class=botonEditar>Edit</button></td>
        <td class=delete><button type="reset" class=botonDelete>Delete</button></td>
	</tr>
  
  </table>
  
  <table class=tableAdd>
   <tr>
   		<td class=add><button class=botonAdd>+</button></td>
	</tr>
  </table>
  
</div>

<div id="Combinados" class="tabcontent">
   <table class=tablaCarta>
	<tr>
		<th class=celdaNombre1>Nombre</th>
    	<th class=celdaPrecio1>Precio</th>
    	<th class=blanco></th>
        <th class=blanco1></th>
	</tr>
	<tr>
		<td class=celdaNombre>hola</td>
    	<td class=celdaPrecio>paris</td>
        <td class=edit><button type="submit" class=botonEditar>Edit</button></td>
        <td class=delete><button type="reset" class=botonDelete>Delete</button></td>
	</tr>
    </table>
    
    <table class=tableAdd>
   <tr>
   		<td class=add><button class=botonAdd>+</button></td>
	</tr>
  </table>
  
</div>

<div id="Carnes" class="tabcontent">
   <table class=tablaCarta>
	<tr>
		<th class=celdaNombre1>Nombre</th>
    	<th class=celdaPrecio1>Precio</th>
    	<th class=blanco></th>
        <th class=blanco1></th>
	</tr>
	<tr>
		<td class=celdaNombre>hola</td>
    	<td class=celdaPrecio>tokio</td>
        <td class=edit><button type="submit" class=botonEditar>Edit</button></td>
        <td class=delete><button type="reset" class=botonDelete>Delete</button></td>
	</tr>
    </table>
    
    <table class=tableAdd>
   <tr>
   		<td class=add><button class=botonAdd>+</button></td>
	</tr>
  </table>
  
</div>

<div id="Pescados" class="tabcontent">
   <table class=tablaCarta>
	<tr>
		<th class=celdaNombre1>Nombre</th>
    	<th class=celdaPrecio1>Precio</th>
    	<th class=blanco></th>
        <th class=blanco1></th>
	</tr>
	<tr>
		<td class=celdaNombre>hola</td>
    	<td class=celdaPrecio>asdfghjkl</td>
        <td class=edit><button type="submit" class=botonEditar>Edit</button></td>
        <td class=delete><button type="reset" class=botonDelete>Delete</button></td>
	</tr>
    </table>
    
    <table class=tableAdd>
   <tr>
   		<td class=add><button class=botonAdd>+</button></td>
	</tr>
  </table>
  
</div>

<div id="Bebidas" class="tabcontent">
   <table class=tablaCarta>
	<tr>
		<th class=celdaNombre1>Nombre</th>
    	<th class=celdaPrecio1>Precio</th>
    	<th class=blanco></th>
        <th class=blanco1></th>
	</tr>
	<tr>
		<td class=celdaNombre>hola</td>
    	<td class=celdaPrecio>5678</td>
        <td class=edit><button type="submit" class=botonEditar>Edit</button></td>
        <td class=delete><button type="reset" class=botonDelete>Delete</button></td>
	</tr>
    </table>
    
    <table class=tableAdd>
   <tr>
   		<td class=add><button class=botonAdd>+</button></td>
	</tr>
  </table>
  
</div>

<div id="Postres" class="tabcontent">
   <table class=tablaCarta>
	<tr>
		<th class=celdaNombre1>Nombre</th>
    	<th class=celdaPrecio1>Precio</th>
    	<th class=blanco></th>
        <th class=blanco1></th>
	</tr>
	<tr>
		<td class=celdaNombre>hola</td>
    	<td class=celdaPrecio>1234</td>
        <td class=edit><button type="submit" class=botonEditar>Edit</button></td>
        <td class=delete><button type="reset" class=botonDelete>Delete</button></td>
	</tr>
    </table>
    
    <table class=tableAdd>
   <tr>
   		<td class=add><button class=botonAdd>+</button></td>
	</tr>
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
