<?php
session_start();

if (isset($_REQUEST["FECHA_INICIO"]) and isset($_REQUEST["FECHA_FIN"]) ) {
    $intervalo["FECHA_INICIO"] = $_REQUEST["FECHA_INICIO"];
    $intervalo["FECHA_FIN"] = $_REQUEST["FECHA_FIN"];

    $_SESSION["intervalo"] = $intervalo;

    if (isset($_REQUEST["obtenerPedidos"])) Header("Location: obtenerPedidos.php");
    else Header("Location: muestraDatos.php");
} else if(isset($_REQUEST["ordenProductos"])){
    $_SESSION["ordenProductos"] = $_REQUEST["ordenProductos"];
    Header("Location: muestraDatos.php");
}
else
    Header("Location: muestraDatos.php");
?>