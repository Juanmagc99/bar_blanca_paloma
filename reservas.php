<?php
require_once("gestionBD.php");

$conexion = crearConexionBD();
$reservas= $conexion->query("SELECT ID_RESERVA, TO_CHAR( HORAENTRADA_RESERVA, 'YYYY-MM-DD HH24:MI:SS' ) AS HORA_ENTRADA
,TO_CHAR( HORASALIDA_RESERVA, 'YYYY-MM-DD HH24:MI' ) AS HORA_SALIDA, ID_CLIENTE1, ID_MESA1 FROM RESERVA");


$contendor = array();
$ahora = date('Y-m-d H:i');
foreach($reservas as $row) {
    array_push($contendor, $row);
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/styleReservas.css">
    <title>Reservas</title>
</head>
<body>
<div>
    <?php
    include_once("Header.html");
    ?>
</div>

<div class="muestra_reservas">
    <table class="tabla_reservas">
        <tr>
            <th>id_reserva</th>
            <th>HoraEntrada_reserva</th>
            <th>HoraSalida_reserva</th>
            <th>id_cliente1</th>
            <th>id_mesa1</th>
        </tr>
        <?php foreach ($reservas as $reserva) { ?>
            <tr>
                <td><?php echo $reserva["ID_RESERVA"] ?></td>
                <td><?php echo $reserva["HORA_ENTRADA"] ?></td>
                <td><?php echo $reserva["HORA_SALIDA"] ?></td>
                <td><?php echo $reserva["ID_CLIENTE1"] ?></td>
                <td><?php echo $reserva["ID_MESA1"] ?></td>
                <td><button>EDIT</button></td>
            </tr>

            <?php
        } ?>
    </table>
</div>
</body>
</html>
