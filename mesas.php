<?php
require_once("gestionBD.php");

$conexion = crearConexionBD();
$mesas_interiores = $conexion->query("SELECT * FROM MESA WHERE TIPO_MESA = 'INTERIOR' ");
$mesas_exteriores = $conexion->query("SELECT * FROM MESA WHERE TIPO_MESA = 'EXTERIOR' ");
$reservas1 = $conexion->query("SELECT ID_MESA1, HORAENTRADA_RESERVA,HORASALIDA_RESERVA FROM RESERVA");
$reservas2 = $reservas1;
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/styleMesa.css">
    <title>Carta</title>
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
            <tr>
                <td><?php echo $mesa["ID_MESA"] ?></td>
                <td><?php foreach ($reservas1 as $res){
                        if (strcmp($res["ID_MESA1"],$mesa["ID_MESA"]) == 0){
                            echo $res["HORAENTRADA_RESERVA"];
                        }
                    }
                    $reservas1 = reset($reservas1);
                    ?></td>
                <td><button>EDIT</button></td>
                <td><button>FACTURA</button></td>
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
            <tr>
                <td><?php echo $mesa["ID_MESA"] ?></td>
                <td><?php foreach ($reservas2 as $res){
                        if (strcmp($res["ID_MESA1"],$mesa["ID_MESA"]) == 0){
                            echo $res["HORAENTRADA_RESERVA"];
                        }
                    }
                    ?></td>
                <td><button>EDIT</button></td>
                <td><button>FACTURA</button></td>
            </tr>
            <?php
        } ?>
    </table>
</div>
<?php
$hoy = getdate();
print_r(date('Y-m-d
H:i'));
?>



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