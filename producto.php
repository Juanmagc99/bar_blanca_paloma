<?php
require_once("gestionBD.php");

$conexion = crearConexionBD();
$productos = $conexion->query("SELECT ID_PRODUCTO, NOMBRE_PRODUCTO1, PRECIO_PRODUCTO, DESCRIPCION, CANTIDAD FROM PRODUCTO");
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/styleProductos.css">
    <title>Productos</title>
</head>
<body>
<div>
    <?php
    include_once("Header.html");
    ?>
</div>

<div class="muestra_productos">
    <table class="tabla_productos">
        <tr>
            <th>ID_PRODUCTO</th>
            <th>NOMBRE_PRODUCTO1</th>
            <th>PRECIO_PRODUCTO</th>
            <th>DESCRIPCION</th>
            <th>CANTIDAD</th>
        </tr>
        <?php foreach ($productos as $producto) { ?>
            <tr>
                <td><?php echo $producto["ID_PRODUCTO"] ?></td>
                <td><?php echo $producto["NOMBRE_PRODUCTO1"] ?></td>
                <td><?php echo $producto["PRECIO_PRODUCTO"] ?></td>
                <td><?php echo $producto["DESCRIPCION"] ?></td>
                <td><?php echo $producto["CANTIDAD"] ?></td>
                <td><button>EDIT</button></td>
            </tr>

            <?php
        } ?>
    </table>
</div>
</body>
</html>
