<?php
session_start();

if (isset($_SESSION["producto_nuevo"])) {
    $producto = $_SESSION["producto_nuevo"];
    unset($_SESSION["producto_nuevo"]);

    require_once("gestionBD.php");
    require_once("gestionFacturas.php");


    $conexion = crearConexionBD();
    $excepcion = añadir_producto_factura($conexion, $producto["ID_PEDIDO_NUEVO"], $producto["NOMBRE_NUEVO"], $producto["CANTIDAD_NUEVO"]);
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
