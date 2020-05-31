<?php

session_start();



if (isset($_REQUEST["ID_MESA"])) {
    $id = $_REQUEST["ID_MESA"];


    $_SESSION["idMesa"] = $id;

    if (isset($_REQUEST["enviar_datos"])) Header("Location: factura.php");
}
else
    Header("Location: mesas.php");
?>
