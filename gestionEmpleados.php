<!DOCTYPE html>
<html>
<head>
	<link rel='stylesheet' type='text/css' href='style_gestionempleados.css'/>
	<title>Empleados</title>
</head>
<body>

	<table class=tablaEnlaces>
	<tr>
		<th class=boton><a class=enlace href="adminCarta.php">Gestión Carta</a></th>
		<th class=botonMesa><a class=enlace href="adminMesas.php">Gestión Mesas</a></th>
		<th class=boton><a class=enlace href="adminEmpleados.php">Empleados</a></th>
		<th class=boton><a class=enlace href="adminEstadisticas.php">Estadisticas</a></th>
	</tr>
    </table>

	<button class="enlaceHome" href="menu.html">Home</button>

	<div id='tablaEmpleados' class='tablaEmpleados'>
		<table style="width:80%">
			<tr>
				<th>DNI</th>
				<th>Nombre</th>
				<th>Apellidos</th>
				<th>Tlf</th>
				<th>Poblacion</th>
				<th>Cod postal</th>
				<th>Fecha alta</th>
				<th>Categoria</th>
				<th>Turno</th>
			</tr>
			<tr>
				<td>12345678A</td>
				<td>Jill</td>
				<td>Smith</td>
				<td>123456789</td>
				<td>Sevilla</td>
				<td>41012</td>
				<td>1-JAN-2020</td>
				<td>Cocinero</td>
				<td>Mañana</td>
			</tr>
			<tr>
				<td>12345678B</td>
				<td>Eve</td>
				<td>Jackson</td>
				<td>987654321</td>
				<td>Sevilla</td>
				<td>41007</td>
				<td>2-FEB-2020</td>
				<td>Camarero</td>
				<td>Tarde</td>
			</tr>
		</table>
	</div>

	<button class="edit_button" onclick="actualizaEmpleado()">Edit</button>
		
	<button class="add_button" onclick="insertaEmpleado()">+</button>

</body>