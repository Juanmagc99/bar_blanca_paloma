<?php
session_start();
require_once("gestionBD.php");
require_once("gestionMesas.php");

$conexion = crearConexionBD();


if (isset($_SESSION["login"])) {
    $usuario = $_SESSION["login"];
} else {
    Header("Location: login_sesion.php");
}

if (isset($_SESSION["idMesa"])){
    $id = $_SESSION["idMesa"];
    unset($_SESSION["idMesa"]);
}

$mesas_interiores = consultarMesasInterior($conexion);
$mesas_exteriores = consultarMesasExterior($conexion);


$reservas = $conexion->query("SELECT ID_MESA1, TO_CHAR( HORAENTRADA_RESERVA, 'YYYY-MM-DD HH24:MI:SS' ) AS HORA_ENTRADA
,TO_CHAR( HORASALIDA_RESERVA, 'YYYY-MM-DD HH24:MI' ) AS HORA_SALIDA FROM RESERVA");

cerrarConexionBD($conexion);

$contendor = array();
$ahora = date('Y-m-d H:i', strtotime("-1 hours"));
foreach ($reservas as $row) {
    array_push($contendor, $row);
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/styleMesa.css">
    <title>Mesa</title>
</head>
<body>
<div>
    <?php
    include_once("Header.html");
    ?>
</div>
<div class="seleccion_mesas">
    <button class="boton_mesa" onclick="openMesa(event, 'INTERIOR') " id="default">
        INTERIOR
    </button>
    <button class="boton_mesa" onclick="openMesa(event, 'EXTERIOR')">
        EXTERIOR
    </button>
</div>

<div class="muestra_mesas" id="INTERIOR">
    <table class="tabla_mesas">
        <tr>
            <th>ID_MESA</th>
            <th>ESTADO</th>
        </tr>
        <?php foreach ($mesas_interiores as $mesa) { ?>
        <form method="post" action="controlador_mesas.php">
            <input id="ID_MESA" name="ID_MESA" type="hidden" value="<?php echo $mesa["ID_MESA"]; ?>" />
                <td><?php echo $mesa["ID_MESA"] ?></td>
                <td><?php foreach ($contendor as $res) {
                        $fecha_entrada = $res["HORA_ENTRADA"];
                        $fecha_salida = $res["HORA_SALIDA"];
                        $estado_mesa = "DISPONIBLE";
                        if (strcmp($res["ID_MESA1"], $mesa["ID_MESA"]) == 0 && ($fecha_entrada > $ahora &&
                                $fecha_salida < $ahora)) {
                            $estado_mesa = "OCUPADO";
                        }
                    }
                    echo $estado_mesa;
                    ?></td>
                <td class="datos">
                    <button type="submit" id="enviar_datos" name="enviar_datos" class="botonDatos">Factura</button></td>
                </td>
                <?php if ($mesa["DNI_EMPLEADO1"] == $usuario["nif"]) { ?>
                    <td>&#8592</td>
                <?php } ?>
        </form>
            </tr>

            <?php
        } ?>
    </table>
</div>
<div class="muestra_mesas" id="EXTERIOR">
    <table class="tabla_mesas">
        <tr>
            <th>ID_MESA</th>
            <th>ESTADO</th>
        </tr>
        <?php foreach ($mesas_exteriores as $mesa) { ?>
            <form method="post" action="controlador_mesas.php">
                <input id="ID_MESA" name="ID_MESA" type="hidden" value="<?php echo $mesa["ID_MESA"]; ?>" />
                <td><?php echo $mesa["ID_MESA"] ?></td>
                <td><?php foreach ($contendor as $res) {
                        $fecha_entrada = $res["HORA_ENTRADA"];
                        $fecha_salida = $res["HORA_SALIDA"];
                        $estado_mesa = "DISPONIBLE";
                        if (strcmp($res["ID_MESA1"], $mesa["ID_MESA"]) == 0 && ($fecha_entrada > $ahora &&
                                $fecha_salida < $ahora)) {
                            $estado_mesa = "OCUPADO";
                        }
                    }
                    echo $estado_mesa;
                    ?></td>
                <td class="datos">
                    <button type="submit" id="enviar_datos" name="enviar_datos" class="botonDatos">Factura</button></td>
                </td>
                <?php if ($mesa["DNI_EMPLEADO1"] == $usuario["nif"]) { ?>
                    <td>&#8592</td>
                <?php } ?>
            </form>
            </tr>

            <?php
        } ?>
    </table>
</div>


<script>
    function openMesa(evt, tablaMesa) {
        var i, tab_mesa, boton_mesa;

        tab_mesa = document.getElementsByClassName("muestra_mesas");
        for (i = 0; i < tab_mesa.length; i++) {
            tab_mesa[i].style.display = "none";
        }

        boton_mesa = document.getElementsByClassName("boton_mesa");
        for (i = 0; i < tab_mesa.length; i++) {
            boton_mesa[i].className = boton_mesa[i].className.replace(" active", "")
        }

        document.getElementById(tablaMesa).style.display = "block";
        evt.currentTarget.className += " active";
    }

    document.getElementById("default").click();
</script>
</body>
</html>