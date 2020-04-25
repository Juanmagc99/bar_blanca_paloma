<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/adminCarta.css">
	<title>adminCarta</title>
</head>
<body>

	<table class=tablaEnlaces>
	<tr>
		<th class=botonCarta><a class=enlace href="adminCarta.php">Gestión Carta</a></th>
		<th class=boton><a class=enlace href="adminMesas.php">Gestión Mes</a></th>
		<th class=boton><a class=enlace href="adminEmpleados.php">Empleados</a></th>
		<th class=boton><a class=enlace href="adminEstadisticas.php">Estadisticas</a></th>
	</tr>
    </table>
    
    //Esta es la vertical tab
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
	</tr>
	<tr>
		<td class=celdaNombre>xd</td>
    	<td class=celdaPrecio>xddd</td>
	</tr>
    </table>
</div>

<div id="Combinados" class="tabcontent">
   <table class=tablaCarta>
	<tr>
		<th class=celdaNombre1>Nombre</th>
    	<th class=celdaPrecio1>Precio</th>
	</tr>
	<tr>
		<td class=celdaNombre>hola</td>
    	<td class=celdaPrecio>paris</td>
	</tr>
    </table> 
</div>

<div id="Carnes" class="tabcontent">
   <table class=tablaCarta>
	<tr>
		<th class=celdaNombre1>Nombre</th>
    	<th class=celdaPrecio1>Precio</th>
	</tr>
	<tr>
		<td class=celdaNombre>hola</td>
    	<td class=celdaPrecio>tokio</td>
	</tr>
    </table>
</div>

<div id="Pescados" class="tabcontent">
   <table class=tablaCarta>
	<tr>
		<th class=celdaNombre1>Nombre</th>
    	<th class=celdaPrecio1>Precio</th>
	</tr>
	<tr>
		<td class=celdaNombre>hola</td>
    	<td class=celdaPrecio>asdfghjkl</td>
	</tr>
    </table>
</div>

<div id="Bebidas" class="tabcontent">
   <table class=tablaCarta>
	<tr>
		<th class=celdaNombre1>Nombre</th>
    	<th class=celdaPrecio1>Precio</th>
	</tr>
	<tr>
		<td class=celdaNombre>hola</td>
    	<td class=celdaPrecio>5678</td>
	</tr>
    </table>
</div>

<div id="Postres" class="tabcontent">
   <table class=tablaCarta>
	<tr>
		<th class=celdaNombre1>Nombre</th>
    	<th class=celdaPrecio1>Precio</th>
	</tr>
	<tr>
		<td class=celdaNombre>hola</td>
    	<td class=celdaPrecio>1234</td>
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
