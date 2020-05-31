<?php
session_start();

if (isset($_REQUEST["ID_LINEA_PEDIDO"])) {
    $producto["ID_LINEA_PEDIDO"] = $_REQUEST["ID_LINEA_PEDIDO"];
    $producto["ID_PEDIDO1"] = $_REQUEST["ID_PEDIDO1"];
    $producto["NOMBRE_PRODUCTO2"] = $_REQUEST["NOMBRE_PRODUCTO2"];
    $producto["CANTIDAD_PEDIDO"] = $_REQUEST["CANTIDAD_PEDIDO"];

    $_SESSION["producto_factura"] = $producto;

    if (isset($_REQUEST["editar"])) Header("Location: factura.php");
    else if (isset($_REQUEST["grabar"])) Header("Location: editarProductoFactura.php");
    else Header("Location: borrarProductoFactura.php");

} elseif (isset($_REQUEST["ID_PEDIDO_NUEVO"])) {
    $producto["ID_PEDIDO_NUEVO"] = $_REQUEST["ID_PEDIDO_NUEVO"];
    $producto["NOMBRE_NUEVO"] = $_REQUEST["NOMBRE_NUEVO"];
    $producto["CANTIDAD_NUEVO"] = $_REQUEST["CANTIDAD_NUEVO"];
    $_SESSION["producto_nuevo"] = $producto;

    if (isset($_REQUEST["añadir"])) Header("Location: addProductoFactura.php");

} else if (isset($_REQUEST["ID_PEDIDO_CERRAR"])){
    $cerrar["ID_PEDIDO_CERRAR"] = $_REQUEST["ID_PEDIDO_CERRAR"];
    $cerrar["IMPORTE"] = $_REQUEST["IMPORTE"];
    $_SESSION["cerrar"] = $cerrar;

    if (isset($_REQUEST["cerrar"])) Header("Location: cerrarFactura.php");

} else if (isset($_REQUEST["ID_MESA"])) {
    $nueva_factura["ID_MESA"] = $_REQUEST["ID_MESA"];
    $_SESSION["nueva_factura"] = $nueva_factura;

    if (isset($_REQUEST["crear"])) Header("Location: addFactura.php");
} else
    Header("Location: factura.php");
?>
