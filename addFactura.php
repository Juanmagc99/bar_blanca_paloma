<?php
session_start();

if (isset($_SESSION["nueva_factura"])) {
    $nueva_factura = $_SESSION["nueva_factura"];
    unset($_SESSION["nueva_factura"]);

    require_once("gestionBD.php");
    require_once("gestionFacturas.php");


    $conexion = crearConexionBD();
    $excepcion = añadir_factura($conexion, $nueva_factura["ID_MESA"]);
    cerrarConexionBD($conexion);

    if ($excepcion<>"") {
        $_SESSION["excepcion"] = $excepcion;
        $_SESSION["destino"] = "factura.php";
        Header("Location: excepcion.php");
    } else
        Header("Location: factura.php");

}

Header("Location: factura.php");
?>