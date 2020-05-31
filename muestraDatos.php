<?php
session_start();
require_once("gestionBD.php");
require_once("gestionDatos.php");

if (isset($_SESSION["login"])) {
    $usuario = $_SESSION["login"];
} else {
    Header("Location: login_sesion.php");
}

$conexion = crearConexionBD();
$productos = $conexion->query("SELECT DISTINCT NOMBRE_PRODUCTO2,SUM(CANTIDAD_PEDIDO) FROM LINEAPEDIDO GROUP BY NOMBRE_PRODUCTO2");
cerrarConexionBD($conexion);

?>
<!DOCTYPE html>
<html>
<head>
    <title>DatosImportantes</title>
    <link rel="stylesheet" type="text/css" href="css/factura.css">
</head>
<body>
<?php
include_once("Header.html");
?>

<form method="post" action="controladorDatos.php">
    <input id="FECHA_INICIO" name="FECHA_INICIO" type="datetime-local"/>
    <input id="FECHA_FIN" name="FECHA_FIN" type="datetime-local"/>
    <button type="submit" id="obtenerPedidos" name="obtenerPedidos" class="obtenerPedidos">Dame los pedidos</button>
</form>

<form method="post" action="controladorDatos.php">
    <button type="submit" id="ordenProductos" name="ordenProductos" class="ordenProductos">Dame los productos</button>
</form>

<?php
    if (isset($_SESSION["pedidos"])) {
        $pedidos = $_SESSION["pedidos"];
        unset($_SESSION["pedidos"]);
        $res = 0;
        ?>
        <div class="muestra">
            <table class="tabla">
                <tr>
                    <th>IP_PEDIDO</th>
                    <th>IMPORTE</th>
                </tr>
                <?php foreach ($pedidos as $p) { ?>
                    <tr>
                        <td><?php echo $p["ID_PEDIDO"] ?></td>
                        <td><?php echo $p["IMPORTE"] ?></td>
                    </tr>
                    <?php
                $res+= $p["IMPORTE"];} ?>
                <tr>
                    <td>Total facturado</td>
                    <td><?php echo $res ?></td>
                </tr>
            </table>
        </div>
    <?php }
    ?>

    <?php if(isset($_SESSION["ordenProductos"])){
        unset($_SESSION["ordenProductos"]);
    ?>
    <div class="muestra">
        <h1>Productos mas vendidos</h1>
        <table class="tabla">
            <tr>
                <th>Nombre</th>
                <th>Cantidad</th>
            </tr>

        <?php foreach ($productos as $p){?>
        <tr>
            <td><?php echo $p[0]?></td>
            <td><?php echo $p[1]?></td>
        </tr>
        <?php }
        ?>
        </table>
    </div>
    <?php }?>
</body>
</html>
