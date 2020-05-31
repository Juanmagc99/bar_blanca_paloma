<?php
session_start();

if (isset($_SESSION["cerrar"])) {
    $cerrar = $_SESSION["cerrar"];
    unset($_SESSION["cerrar"]);

    require_once("gestionBD.php");
    require_once("gestionFacturas.php");


    $conexion = crearConexionBD();
    $excepcion = cerrarFactura($conexion,$cerrar["ID_PEDIDO_CERRAR"],$cerrar["IMPORTE"]);
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
