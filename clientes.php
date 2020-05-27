<?php
require_once("gestionBD.php");

$conexion = crearConexionBD();
$clientes = $conexion->query("SELECT ID_CLIENTE, TLF_CLIENTE, NOMBRE_CLIENTE, APELLIDOS_CLIENTE FROM CLIENTE");
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

<div class="muestra_clientes">
    <table class="tabla_clientes">
        <tr>
            <th>ID_CLIENTE</th>
            <th>TLF_CLIENTE</th>
            <th>NOMBRE_CLIENTE</th>
            <th>APELLIDOS_CLIENTE</th>
        </tr>
        <?php foreach ($clientes as $cliente) { ?>
            <tr>
                <td><?php echo $cliente["ID_CLIENTE"] ?></td>
                <td><?php echo $cliente["TLF_CLIENTE"] ?></td>
                <td><?php echo $cliente["NOMBRE_CLIENTE"] ?></td>
                <td><?php echo $cliente["APELLIDOS_CLIENTE"] ?></td>
                <td><button>EDIT</button></td>
            </tr>

            <?php
        } ?>
    </table>
</div>
</body>
</html>
