<?php

function consultarCarta($conexion) {
    $consulta = "SELECT NOMBRE, PRECIO, CANTIDAD FROM PRODUCTO";
    return $conexion->query($consulta);
}
?>