<?php
session_start();

if (isset($_SESSION["producto_factura"])) {
    $producto = $_SESSION["producto_factura"];
    unset($_SESSION["producto_factura"]);

    require_once("gestionBD.php");
    require_once("gestionFacturas.php");


    $conexion = crearConexionBD();
    $excepcion = editar_cantidad_factura($conexion,$producto["ID_LINEA_PEDIDO"],$producto["CANTIDAD_PEDIDO"]);
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


