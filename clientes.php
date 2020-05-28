<?php
require_once("gestionBD.php");

$conexion = crearConexionBD();
$clientes = $conexion->query("SELECT ID_CLIENTE, TLF_CLIENTE, NOMBRE_CLIENTE, APELLIDOS_CLIENTE FROM CLIENTE");

session_start();

if (!isset($_SESSION['formulario_cliente'])) {

    $formulario_cliente['TLF_CLIENTE'] = "";
    $formulario_cliente['NOMBRE_CLIENTE'] = "";
    $formulario_cliente['APELLIDOS_CLIENTE'] = "";

    $_SESSION['formulario_cliente'] = $formulario_cliente;
}
else
    $formulario_cliente = $_SESSION['formulario_cliente'];

if (isset($_SESSION["errores"]))
    $errores = $_SESSION["errores"];
if (isset($_SESSION["login"]))
    $login = $_SESSION["login"];
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/styleClientes.css">
    <title>Clientes</title>
</head>
<body>
<div>
    <?php
    include_once("Header.html");
    ?>
</div>

<?php
// Mostrar los erroes de validación (Si los hay)
if (isset($errores) && count($errores)>0) {
    echo "<div id=\"div_errores\" class=\"error\">";
    echo "<h4> Ha cometido errores al realizar el formulario:</h4>";
    foreach($errores as $error) echo $error;
    echo "</div>";
}
?>

<div class="muestra_clientes">
    <table class="tabla_clientes">
        <tr>
            <th>ID_CLIENTE</th>
            <th>TLF_CLIENTE</th>
            <th>NOMBRE_CLIENTE</th>
            <th>APELLIDOS_CLIENTE</th>
            <th></th>
        </tr>
        <?php foreach ($clientes as $cliente) { ?>
            <tr>
                <td><?php echo $cliente["ID_CLIENTE"] ?></td>
                <td><?php echo $cliente["TLF_CLIENTE"] ?></td>
                <td><?php echo $cliente["NOMBRE_CLIENTE"] ?></td>
                <td><?php echo $cliente["APELLIDOS_CLIENTE"] ?></td>
                <?php if ($login["categoria"] == "GERENTE")  {
                    echo '<td><button>EDIT</button></td>';
                } ?>
            </tr
            <?php
        } ?>
        <?php if ($login["categoria"] == "GERENTE")  {
        echo '<form id="addCliente" method="get" action="validacion_add_cliente.php" novalidate>
            <td></td>
            <td><input id="TLF_CLIENTE" name="TLF_CLIENTE" type="text" size="40" value="' . $formulario_cliente['TLF_CLIENTE'] . '" required/></td>
            <td><input id="NOMBRE_CLIENTE" name="NOMBRE_CLIENTE" type="text" size="40" value="' . $formulario_cliente['NOMBRE_CLIENTE'] . '" required/></td>
            <td><input id="APELLIDOS_CLIENTE" name="APELLIDOS_CLIENTE" type="text" size="40" value="' . $formulario_cliente['APELLIDOS_CLIENTE'] . '" required/></td>
            <td><input type="submit" value="ADD" /></td>
         </form>';
         } ?>
    </table>
</div>
</body>
</html>
