<?php
session_start();

if (isset($_SESSION["intervalo"])) {
    $intervalo = $_SESSION["intervalo"];
    unset($_SESSION["intervalo"]);

    require_once("gestionBD.php");
    require_once("gestionDatos.php");


    $conexion = crearConexionBD();
    $pedidos = obtenPedidos($conexion, $intervalo["FECHA_INICIO"], $intervalo["FECHA_FIN"]);
    cerrarConexionBD($conexion);
    $_SESSION["pedidos"] = $pedidos;


}

Header("Location: muestraDatos.php");
?>
