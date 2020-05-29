<?php

function consultarMesasInterior($conexion) {
    $consulta = "SELECT * FROM MESA WHERE TIPO_MESA = 'INTERIOR' ";
    return $conexion->query($consulta);
}

function consultarMesasExterior($conexion) {
    $consulta = "SELECT * FROM MESA WHERE TIPO_MESA = 'EXTERIOR' ";
    return $conexion->query($consulta);
}


?>
