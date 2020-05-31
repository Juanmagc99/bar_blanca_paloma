<?php
require_once("gestionBD.php");

$conexion = crearConexionBD();
$reservas= $conexion->query("SELECT ID_RESERVA, TO_CHAR( HORAENTRADA_RESERVA, 'YYYY-MM-DD HH24:MI' ) AS HORA_ENTRADA
,TO_CHAR( HORASALIDA_RESERVA, 'YYYY-MM-DD HH24:MI' ) AS HORA_SALIDA, ID_CLIENTE1, ID_MESA1 FROM RESERVA");
session_start();

if (!isset($_SESSION['formulario_reserva'])) {

    $formulario_reserva['HORA_ENTRADA'] = "";
    $formulario_reserva['HORA_SALIDA'] = "";
    $formulario_reserva['ID_CLIENTE1'] = "";
    $formulario_reserva['ID_MESA1'] = "";

    $_SESSION['formulario_reserva'] = $formulario_reserva;
}
else
    $formulario_reserva = $_SESSION['formulario_reserva'];

if (isset($_SESSION["errores_reserva"]))
    $errores_reserva = $_SESSION["errores_reserva"];
if (isset($_SESSION["RESERVA_EDIT"]))
    $RESERVA_EDIT = $_SESSION["RESERVA_EDIT"];
if (isset($_SESSION["login"]))
    $login = $_SESSION["login"];
else Header("Location: login_sesion.php");
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

<?php
// Mostrar los errores de validación (Si los hay)
if (isset($errores_reserva) && count($errores_reserva)>0) {
    echo "<div id=\"div_errores\" class=\"error\">";
    echo "<h4> Ha cometido errores al realizar el formulario:</h4>";
    foreach($errores_reserva as $error) echo $error;
    echo "</div>";
}
?>

<div class="muestra_reservas">
    <table class="tabla_reservas">
        <tr>
            <th>ID</th>
            <th>HORA ENTRADA</th>
            <th>HORA SALIDA</th>
            <th>ID CLIENTE</th>
            <th>ID MESA</th>
        </tr>

        <?php foreach ($reservas as $reserva) { ?>
            <tr>
                <form name="gestionReservas" id="gestionReservas" method="post" action="gestionReservas.php" onsubmit="return validarDatos('gestionReservas')">
                    <input id="ID_RESERVA" name="ID_RESERVA" type="hidden" value="<?php echo $reserva["ID_RESERVA"]; ?>" required/>
                    <input id="HORA_ENTRADA" name="HORA_ENTRADA" type="hidden" value="<?php echo $reserva["HORA_ENTRADA"]; ?>" required/>
                    <input id="HORA_SALIDA" name="HORA_SALIDA" type="hidden" value="<?php echo $reserva["HORA_SALIDA"]; ?>" required/>
                    <input id="ID_CLIENTE1" name="ID_CLIENTE1" type="hidden" value="<?php echo $reserva["ID_CLIENTE1"]; ?>" required/>
                    <input id="ID_MESA1" name="ID_MESA1" type="hidden" value="<?php echo $reserva["ID_MESA1"]; ?>" required/>

                    <td><?php echo $reserva["ID_RESERVA"] ?></td>
                    <?php if (isset($RESERVA_EDIT) && $reserva["ID_RESERVA"] == $RESERVA_EDIT["ID_RESERVA"]) { ?>
                        <td><input id="HORA_ENTRADA" name="HORA_ENTRADA" type="datetime-local" size="40" value="<?php echo date('Y-m-d\TH:i', strtotime($reserva["HORA_ENTRADA"]));?>" required/></td>
                        <td><input id="HORA_SALIDA" name="HORA_SALIDA" type="datetime-local" size="40" value="<?php echo date('Y-m-d\TH:i', strtotime($reserva["HORA_SALIDA"]));?>" required/></td>
                        <td><input id="ID_CLIENTE1" name="ID_CLIENTE1" type="text" size="40" value="<?php echo $reserva['ID_CLIENTE1']?>" required/></td>
                        <td><input id="ID_MESA1" name="ID_MESA1" type="text" size="40" value="<?php echo $reserva['ID_MESA1']?>" required/></td>
                    <?php }	else { ?>
                        <td><?php echo $reserva["HORA_ENTRADA"] ?></td>
                        <td><?php echo $reserva["HORA_SALIDA"] ?></td>
                        <td><?php echo $reserva["ID_CLIENTE1"] ?></td>
                        <td><?php echo $reserva["ID_MESA1"] ?></td>
                    <?php } ?>
                        <?php if (!isset($RESERVA_EDIT)) { ?>
                            <td><button type="submit" id="editar" name="editar" class="botonEdit">Edit</button></td>
                            <td><button type="submit" id="borrar" name="borrar" class="botonDelete">Delete</button></td>
                        <?php }	else { ?>
                            <td><button type="submit" id="grabar" name="grabar" class="botonGrabar">OK</button></td>
                        <?php } ?>
                </form>
            </tr>
            <?php
        } ?>
            <form name="addReserva" id="addReserva" method="get" action="gestionReservas.php" onsubmit="return validarDatos('addReserva')">
                <tr>
                    <td></td>
                    <td><input id="HORA_ENTRADA" name="HORA_ENTRADA" type="datetime-local" size="40" value="<?php echo date('Y-m-d\TH:i', strtotime($formulario_reserva["HORA_ENTRADA"]));?>" required/></td>
                    <td><input id="HORA_SALIDA" name="HORA_SALIDA" type="datetime-local" size="40" value="<?php echo date('Y-m-d\TH:i', strtotime($formulario_reserva["HORA_SALIDA"]));?>" required/></td>
                    <td><input id="ID_CLIENTE1" name="ID_CLIENTE1" type="text" size="40" value="<?php echo $formulario_reserva['ID_CLIENTE1']?>" required/></td>
                    <td><input id="ID_MESA1" name="ID_MESA1" type="text" size="40" value="<?php echo $formulario_reserva['ID_MESA1']?>" required/></td>
                    <td><input type="submit" value="ADD" /></td>
                </tr>
            </form>
    </table>
</div>

<script>
    function validarDatos(name) {
        var HORA_ENTRADA = document.forms[name]["HORA_ENTRADA"].value;
        var HORA_SALIDA = document.forms[name]["HORA_SALIDA"].value;
        var ID_CLIENTE1 = document.forms[name]["ID_CLIENTE1"].value;
        var ID_MESA1 = document.forms[name]["ID_MESA1"].value;
        if (HORA_ENTRADA == "")
            return false;
        if (HORA_SALIDA == "")
            return false;
        if (ID_CLIENTE1 == "")
            return false;
        if (ID_MESA1 == "")
            return false;
        return true;
    }
</script>
</body>
</html>