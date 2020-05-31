<?php
	session_start();

	if (!isset($_SESSION['login']))
		header("Location: login_sesion.php");
 ?>
<!DOCTYPE html>
<html>
    <head>
        <style>
            body {
                background-color: lightskyblue;
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
            .carta {
                border: medium dotted red;
            }
            mesas {

            }
            reservas {

            }
            admin {

            }
        </style>
    </head>
    <body>
        <img src="../../Desktop/bar_blanca_paloma/Imagenes/Paloma.png" alt="Logo Blanca Paloma">
        <h1>Bar Blanca Paloma</h1>
        <h2>Bienvenido</h2>
        <a id="carta" href="carta.html">Carta</a>
        <a id="mesas" href="mesas.html">Mesas</a>
        <a id="reservas" href="reservas.html">Reservas</a>
        <a id="admin" href="adminCarta.php">Admin</a>
        
        <p><?php if (isset($_SESSION['login'])) {	?>
					<a href="logout.php">Desconectar</a>
					<?php } ?></p>
    </body>
</html>