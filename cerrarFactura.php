<?php
session_start();

if (isset($_SESSION["idCerrar"])) {
    $idCerrar = $_SESSION["idCerrar"];
    unset($_SESSION["idCerrar"]);

    require_once("gestionBD.php");
    require_once("gestionFacturas.php");


    $conexion = crearConexionBD();
    $excepcion = cerrarFactura($conexion, $idCerrar);
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
