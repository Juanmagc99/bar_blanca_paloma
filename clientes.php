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
            <th class="cabecera">ID</th>
            <th class="cabecera">TELÉFONO</th>
            <th class="cabecera">NOMBRE</th>
            <th class="cabecera">APELLIDOS</th>
            <th class="botones"></th>
        </tr>

        <?php foreach ($clientes as $cliente) { ?>
            <tr>
                <form name="gestionCliente" id="gestionCliente" method="post" action="gestionClientes.php" onsubmit="return validarDatos('gestionCliente')">
                    <input id="ID_CLIENTE" name="ID_CLIENTE" type="hidden" value="<?php echo $cliente["ID_CLIENTE"]; ?>" required/>
                    <input id="TLF_CLIENTE" name="TLF_CLIENTE" type="hidden" value="<?php echo $cliente["TLF_CLIENTE"]; ?>" pattern="[0-9]{9}" required/>
                    <input id="NOMBRE_CLIENTE" name="NOMBRE_CLIENTE" type="hidden" value="<?php echo $cliente["NOMBRE_CLIENTE"]; ?>" required/>
                    <input id="APELLIDOS_CLIENTE" name="APELLIDOS_CLIENTE" type="hidden" value="<?php echo $cliente["APELLIDOS_CLIENTE"]; ?>" required/>

                    <td><?php echo $cliente["ID_CLIENTE"] ?></td>
                    <?php if (isset($CLIENTE_EDIT) && $cliente["ID_CLIENTE"] == $CLIENTE_EDIT["ID_CLIENTE"]) { ?>
                        <td><input id="TLF_CLIENTE" name="TLF_CLIENTE" type="text" size="40" value="<?php echo $cliente['TLF_CLIENTE']?>" pattern="[0-9]{9}" required/></td>
                        <td class="datos"><input id="NOMBRE_CLIENTE" name="NOMBRE_CLIENTE" type="text" size="40" value="<?php echo $cliente['NOMBRE_CLIENTE']?>" required/></td>
                        <td class="datos"><input id="APELLIDOS_CLIENTE" name="APELLIDOS_CLIENTE" type="text" size="40" value="<?php echo $cliente['APELLIDOS_CLIENTE']?>" required/></td>
                    <?php }	else { ?>
                        <td class="datos"><?php echo $cliente["TLF_CLIENTE"] ?></td>
                        <td class="datos"><?php echo $cliente["NOMBRE_CLIENTE"] ?></td>
                        <td class="datos"><?php echo $cliente["APELLIDOS_CLIENTE"] ?></td>
                    <?php } ?>
                        <?php if (!isset($CLIENTE_EDIT)) { ?>
                            <td class="botones"><button type="submit" id="editar" name="editar" class="botonEdit">Edit</button>
                            <button type="submit" id="copiar" name="copiar" class="botonCopy">Copy</button>
                            <button type="submit" id="borrar" name="borrar" class="botonDelete">Delete</button></td>
                        <?php }	else { ?>
                            <td><button type="submit" id="grabar" name="grabar" class="botonGrabar">OK</button></td>
                        <?php } ?>
                </form>
            </tr>
            <form name="addCliente" id="addCliente" method="get" action="gestionClientes.php" onsubmit="return validarDatos('addCliente')">
                <tr>
                <td></td>
                <td><input id="TLF_CLIENTE" name="TLF_CLIENTE" type="text" size="40" value="<?php echo $formulario_cliente['TLF_CLIENTE']?>" pattern="[0-9]{9}" required/></td>
                <td><input id="NOMBRE_CLIENTE" name="NOMBRE_CLIENTE" type="text" size="40" value="<?php echo $formulario_cliente['NOMBRE_CLIENTE']?>" required/></td>
                <td><input id="APELLIDOS_CLIENTE" name="APELLIDOS_CLIENTE" type="text" size="40" value="<?php echo $formulario_cliente['APELLIDOS_CLIENTE']?>" required/></td>
                <td><input type="submit" value="ADD" /></td>
                </tr>
             </form>
    </table>
</div>
<script>
    function validarDatos(name) {
        var tlf = document.forms[name]["TLF_CLIENTE"].value;
        var nombre = document.forms[name]["NOMBRE_CLIENTE"].value;
        var apellidos = document.forms[name]["APELLIDOS_CLIENTE"].value;
        if (nombre == "")
            return false;
        if (apellidos == "")
            return false;
        if (!tlf.match("[0-9]{9}"))
            return false;
    }
</script>
</body>
</html>