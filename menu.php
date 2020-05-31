<?php
	session_start();

	if (!isset($_SESSION['login']))
		header("Location: login_sesion.php");
    $login = $_SESSION['login'];
 ?>
<!DOCTYPE html>
<html>
    <head>
        <style>
            body {
                background-color: #0F398C;
                font-family: "Lato", sans-serif;
                font-weight: bold;
            }
            h1 {
                text-align: center;
            }
            img {
                display: block;
                margin-left: auto;
                margin-right: auto;
                width: 10%;
                height: 10%;
            }

            a:link, a:visited {
                background-color: #05CB74;
                border-color: #05CB74;
                color: black;
                border-style: outset;
                padding: 75px;
                font-size:200%;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                margin: 0 auto;
            }

            a:hover, a:active {
                background-color: #29912d;
            }

        </style>
    </head>
    <body>
        <img src="Imagenes/Paloma.png" alt="Logo Blanca Paloma">
        <h1>Bar Blanca Paloma</h1>
        <h2>Bienvenido</h2>
        <a href="clientes.php">Clientes</a>
        <a href="reservas.php">Reservas</a>
        <a href="mesas.php">Mesas</a>
        <?php if ($login["categoria"] == "GERENTE") {	?>
            <a href="adminCarta.php">Carta</a>
            <a href="adminEmpleados.php">Empleados</a>
        <?php }
        else {	?>
            <a href="Carta.php">Carta</a>
        <?php } ?>

        <p><a href="logout.php">Cerrar sesión</a></p>


    </body>
</html>