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

if (isset($_SESSION["errores_cliente"]))
    $errores_cliente = $_SESSION["errores_cliente"];
if (isset($_SESSION["CLIENTE_EDIT"]))
    $CLIENTE_EDIT = $_SESSION["CLIENTE_EDIT"];
if (isset($_SESSION["login"]))
    $login = $_SESSION["login"];
else Header("Location: login_sesion.php");
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
// Mostrar los errores de validación (Si los hay)
if (isset($errores_cliente) && count($errores_cliente)>0) {
    echo "<div id=\"div_errores\" class=\"error\">";
    echo "<h4> Ha cometido errores al realizar el formulario:</h4>";
    foreach($errores_cliente as $error) echo $error;
    echo "</div>";
}
?>

<h1>Clientes</h1>
<div class="muestra_clientes">
    <table class="tabla_clientes">
        <tr>
            <th>ID</th>
            <th>TELÉFONO</th>
            <th>NOMBRE</th>
            <th>APELLIDOS</th>
        </tr>

        <?php foreach ($clientes as $cliente) { ?>
            <tr>
                <form method="post" action="gestionClientes.php">
                    <input id="ID_CLIENTE" name="ID_CLIENTE" type="hidden" value="<?php echo $cliente["ID_CLIENTE"]; ?>" />
                    <input id="TLF_CLIENTE" name="TLF_CLIENTE" type="hidden" value="<?php echo $cliente["TLF_CLIENTE"]; ?>" />
                    <input id="NOMBRE_CLIENTE" name="NOMBRE_CLIENTE" type="hidden" value="<?php echo $cliente["NOMBRE_CLIENTE"]; ?>" />
                    <input id="APELLIDOS_CLIENTE" name="APELLIDOS_CLIENTE" type="hidden" value="<?php echo $cliente["APELLIDOS_CLIENTE"]; ?>" />

                    <td><?php echo $cliente["ID_CLIENTE"] ?></td>
                    <?php if (isset($CLIENTE_EDIT) && $cliente["ID_CLIENTE"] == $CLIENTE_EDIT["ID_CLIENTE"]) { ?>
                        <td><input id="TLF_CLIENTE" name="TLF_CLIENTE" type="text" size="40" value="<?php echo $cliente['TLF_CLIENTE']?>" required/></td>
                        <td><input id="NOMBRE_CLIENTE" name="NOMBRE_CLIENTE" type="text" size="40" value="<?php echo $cliente['NOMBRE_CLIENTE']?>" required/></td>
                        <td><input id="APELLIDOS_CLIENTE" name="APELLIDOS_CLIENTE" type="text" size="40" value="<?php echo $cliente['APELLIDOS_CLIENTE']?>" required/></td>
                    <?php }	else { ?>
                        <td><?php echo $cliente["TLF_CLIENTE"] ?></td>
                        <td><?php echo $cliente["NOMBRE_CLIENTE"] ?></td>
                        <td><?php echo $cliente["APELLIDOS_CLIENTE"] ?></td>
                    <?php } ?>
                    <?php if ($login["categoria"] == "GERENTE")  { ?>
                        <?php if (!isset($CLIENTE_EDIT)) { ?>
                            <td><button type="submit" id="editar" name="editar" class="botonEdit">Edit</button></td>
                            <td><button type="submit" id="copiar" name="copiar" class="botonCopy">Copy</button></td>
                            <td><button type="submit" id="borrar" name="borrar" class="botonDelete">Delete</button></td>
                        <?php }	else { ?>
                            <td><button type="submit" id="grabar" name="grabar" class="botonGrabar">OK</button></td>
                        <?php } ?>
                        <?php
                    } ?>
                </form>
            </tr>
            <?php
        } ?>
        <?php if ($login["categoria"] == "GERENTE")  { ?>
            <form id="addCliente" method="get" action="gestionClientes.php" novalidate>
                <tr>
                <td></td>
                <td><input id="TLF_CLIENTE" name="TLF_CLIENTE" type="text" size="40" value="<?php echo $formulario_cliente['TLF_CLIENTE']?>" required/></td>
                <td><input id="NOMBRE_CLIENTE" name="NOMBRE_CLIENTE" type="text" size="40" value="<?php echo $formulario_cliente['NOMBRE_CLIENTE']?>" required/></td>
                <td><input id="APELLIDOS_CLIENTE" name="APELLIDOS_CLIENTE" type="text" size="40" value="<?php echo $formulario_cliente['APELLIDOS_CLIENTE']?>" required/></td>
                <td><input type="submit" value="ADD" /></td>
                </tr>
             </form>
            <?php
        } ?>
    </table>
</div>
</body>
</html>
