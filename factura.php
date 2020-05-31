<?php
session_start();
require_once("gestionBD.php");
require_once("gestionFacturas.php");


$conexion = crearConexionBD();
if (isset($_SESSION["idMesa"])) {
    $idMesa = $_SESSION["idMesa"];
    $facturas = facturaEnCurso($conexion, $_SESSION["idMesa"]);
    $productos = $conexion->query("SELECT * FROM PRODUCTO");
    $contendor = array();
    foreach ($productos as $row) {
        array_push($contendor, $row);
    }
}

if (isset($_SESSION["producto_factura"])) {
    $producto = $_SESSION["producto_factura"];
    unset($_SESSION["producto_factura"]);
}

if (!empty($facturas)) {
    foreach ($facturas as $f) {
        $productos_pedidos = productosEnFactura($conexion, $f["ID_PEDIDO"]);
        $idPedido = $f["ID_PEDIDO"];
    }
}


cerrarConexionBD($conexion);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Factura</title>
    <link rel="stylesheet" type="text/css" href="css/factura.css">
</head>
<body>
<div>
    <?php
    include_once("Header.html");
    ?>
</div>
<div class="muestra_factura">
    <table class="tabla_factura">

        <?php
        if (isset($productos_pedidos) and !empty($productos_pedidos)) {
            $res = 0;?>

            <tr>
                <th>Nombre</th>
                <th>Cantidad</th>
                <th>Precio</th>
            </tr>

            <?php foreach ($productos_pedidos as $p) {
                ?>

                    <tr>
                        <form method="post" action="controlador_factura.php">
                            <input id="ID_LINEA_PEDIDO" name="ID_LINEA_PEDIDO" type="hidden"
                                   value="<?php echo $p["ID_LINEA_PEDIDO"]; ?>"/>
                            <input id="ID_PEDIDO1" name="ID_PEDIDO1" type="hidden"
                                   value="<?php echo $p["ID_PEDIDO1"]; ?>"/>
                            <input id="NOMBRE_PRODUCTO2" name="NOMBRE_PRODUCTO2" type="hidden"
                                   value="<?php echo $p["NOMBRE_PRODUCTO2"]; ?>"/>
                            <input id="CANTIDAD_PEDIDO" name="CANTIDAD_PEDIDO" type="hidden"
                                   value="<?php echo $p["CANTIDAD_PEDIDO"]; ?>"/>
                            <?php
                            if (isset($producto) and $producto["ID_LINEA_PEDIDO"] == $p["ID_LINEA_PEDIDO"]) { ?>
                                <td class="celdaNombre"><?php echo $p["NOMBRE_PRODUCTO2"] ?></td>
                                <td class="celdaCantidad""><input id="CANTIDAD_PEDIDO" name="CANTIDAD_PEDIDO"
                                                                  value="<?php echo $p["CANTIDAD_PEDIDO"] ?>"/></td>
                                <td><?php foreach ($contendor as $p_aux){
                                        if(strcmp($p["NOMBRE_PRODUCTO2"], $p_aux["NOMBRE_PRODUCTO1"]) == 0){
                                            echo $p["CANTIDAD_PEDIDO"]*$p_aux["PRECIO_PRODUCTO"];

                                        }
                                    }
                                    ?></td>
                            <?php } else { ?>
                                <input id="CANTIDAD_PEDIDO" name="CANTIDAD_PEDIDO" type="hidden"
                                       value="<?php echo $p["CANTIDAD_PEDIDO"]; ?>"/>
                                <td class="celdaNombre"><?php echo $p["NOMBRE_PRODUCTO2"] ?></td>
                                <td class="celdaCantidad"><?php echo $p["CANTIDAD_PEDIDO"] ?></td>
                                <td><?php foreach ($contendor as $p_aux){
                                        if(strcmp($p["NOMBRE_PRODUCTO2"], $p_aux["NOMBRE_PRODUCTO1"]) == 0){
                                            echo $p["CANTIDAD_PEDIDO"]*$p_aux["PRECIO_PRODUCTO"];
                                            $res += $p["CANTIDAD_PEDIDO"]*$p_aux["PRECIO_PRODUCTO"];
                                        }
                                    }
                                    ?></td>
                            <?php } ?>

                            <td class="edit">
                                <?php if (isset($producto) and ($producto["ID_LINEA_PEDIDO"] == $p["ID_LINEA_PEDIDO"])) { ?>
                                    <button type="submit" id="grabar" name="grabar" class="botonEditar">OK</button>
                                <?php } else { ?>
                                <button type="submit" id="editar" name="editar" class="botonEditar">Edit</button>
                            </td>
                        <?php } ?>
                            <td class="delete">
                                <button type="submit" id="borrar" name="borrar" class="botonDelete">Delete</button>
                            </td>
                        </form>
                    </tr>

                    <?php

            }?>

            <tr class="Añadir">
                <form method="post" action="controlador_factura.php">
                    <input id="ID_PEDIDO_NUEVO" name="ID_PEDIDO_NUEVO" type="hidden" value="<?php echo $idPedido; ?>"/>
                    <td><input id="NOMBRE_NUEVO" name="NOMBRE_NUEVO" type="text"/></td>
                    <td><input id="CANTIDAD_NUEVO" name="CANTIDAD_NUEVO" type="text"/></td>
                    <td>
                        <button type="submit" id="añadir" name="añadir" class="botonAñadir">Añadir</button>
                    </td>
            </td>
            </form>
            </tr>

            <tr class="Cerrar">
                <form method="post" action="controlador_factura.php">
                    <input id="ID_PEDIDO_CERRAR" name="ID_PEDIDO_CERRAR" type="hidden" value="<?php echo $idPedido; ?>"/>
                    <td style="visibility:hidden;">
                    <td style="visibility:hidden;">
                    <td>
                        <button type="submit" id="cerrar" name="cerrar" class="botonCerrar">Cerrar</button>
                    </td>
                </form>
            </tr>
            <tr class="Resultado">
                    <td style="visibility:hidden;">
                    <td>
                        <?php echo $res;?>
                    </td>

            </tr>

        <?php } else { ?>
            <h1>No existe un pedido abierto para esta mesa</h1>
            <h1>¿Quieres agregar una factura nueva?</h1>
        <form method="post" action="controlador_factura.php">
            <input id="ID_MESA" name="ID_MESA" type="hidden" value="<?php echo $idMesa; ?>"/>
            <div align="center">
                <button type="submit" id="crear" name="crear" class="botonCrear">Crear factura nueva</button>
            </div>
        </form>
        <?php }
        ?>
    </table>
</div>
</body>
</html>