<?php
    session_start();
    require_once("gestionBD.php");

    /* =======================================================
                        EDITAR Y BORRAR
    ======================================================= */
    if (isset($_REQUEST["ID_RESERVA"])) {
        $reserva["ID_RESERVA"] = $_REQUEST["ID_RESERVA"];
        $reserva["HORA_ENTRADA"] = date('Y-m-d H:i',strtotime($_REQUEST["HORA_ENTRADA"]));
        $reserva["HORA_SALIDA"] = date('Y-m-d H:i',strtotime($_REQUEST["HORA_SALIDA"]));
        $reserva["ID_CLIENTE1"] = $_REQUEST["ID_CLIENTE1"];
        $reserva["ID_MESA1"] = $_REQUEST["ID_MESA1"];

        if (!validarDatosUsuario($reserva)) return;

        if (!isset($_REQUEST["copiar"])) {
            if (isset($_REQUEST["editar"])) {
                $_SESSION["RESERVA_EDIT"] = $reserva;
            } else if (isset($_REQUEST["grabar"])) {
                unset($_SESSION["RESERVA_EDIT"]);
                $conexion = crearConexionBD();
                update_reserva($conexion, $reserva);
                cerrarConexionBD($conexion);
            } else if (isset($_REQUEST["borrar"])) {
                $conexion = crearConexionBD();
                remove_reserva($conexion, $reserva["ID_RESERVA"]);
                cerrarConexionBD($conexion);
            }
            Header('Location: reservas.php');
            return;
        }
    }

/* =======================================================
                        FORMULARIO
   ======================================================= */
    if (isset($_SESSION["formulario_reserva"])) {

        $nuevaReserva["HORA_ENTRADA"] = date('Y-m-d H:i',strtotime($_REQUEST["HORA_ENTRADA"]));
        $nuevaReserva["HORA_SALIDA"] = date('Y-m-d H:i',strtotime($_REQUEST["HORA_SALIDA"]));
        $nuevaReserva["ID_CLIENTE1"] = $_REQUEST["ID_CLIENTE1"];
        $nuevaReserva["ID_MESA1"] = $_REQUEST["ID_MESA1"];
    }
    else
        Header("Location: reservas.php");

    $_SESSION["formulario_reserva"] = $nuevaReserva;

    if (validarDatosUsuario($nuevaReserva)) {
        $conexion = crearConexionBD();
        if (add_reserva($conexion, $nuevaReserva))
            unset($_SESSION["formulario_reserva"]);
        cerrarConexionBD($conexion);
        Header('Location: reservas.php');
    }

    // Validación en servidor del formulario
    function validarDatosUsuario($nuevaReserva){
        unset($_SESSION["errores_reserva"]);
        $conexion = crearConexionBD();
        //Existe el cliente?
        if(!existe_cliente($conexion, $nuevaReserva["ID_CLIENTE1"])){
            $errores_reserva[] = "<p>No existe un cliente con esta ID: " . $nuevaReserva["ID_CLIENTE1"]. "</p>";
        }
        //Existe la mesa?
        if(!existe_mesa($conexion, $nuevaReserva["ID_MESA1"])){
            $errores_reserva[] = "<p>No existe una mesa con esta ID: " . $nuevaReserva["ID_MESA1"]. "</p>";
        }

        //validar fecha y hora
        if (!validaFecha($nuevaReserva["HORA_SALIDA"]))
            $errores_reserva[] = "<p>La hora de salida usa un formato incorrecto: " . $nuevaReserva["HORA_SALIDA"]. "</p>";

        if (!validaFecha($nuevaReserva["HORA_ENTRADA"]))
            $errores_reserva[] = "<p>La hora de entrada usa un formato incorrecto: " . $nuevaReserva["HORA_ENTRADA"]. "</p>";

        $salida = date('Y-m-d H:i', strtotime($nuevaReserva["HORA_SALIDA"]));
        $entrada = date('Y-m-d H:i', strtotime($nuevaReserva["HORA_ENTRADA"]));
        if ($salida <= $entrada)
            $errores_reserva[] = "<p>La hora de salida no puede ser menor o igual a la de entrada.";

        if (count($errores_reserva)>0) {
            $_SESSION["errores_reserva"] = $errores_reserva;
            Header('Location: reservas.php');
            return false;
        } else {
            return true;
        }
    }

    function validaFecha($date, $format = 'Y-m-d H:i') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    function existe_cliente($conexion, $id_cliente1) {
        try {
            $consulta = "SELECT COUNT(*) AS TOTAL FROM CLIENTE WHERE ID_CLIENTE=:id_cliente1";
            $stmt = $conexion->prepare($consulta);
            $stmt->bindParam(':id_cliente1',$id_cliente1);
            $stmt->execute();
            return $stmt->fetchColumn() != 0;
        }
        catch (PDOException $e) {
            return false;
        }
    }

    function existe_mesa($conexion, $id_mesa1) {
        try {
            $consulta = "SELECT COUNT(*) AS TOTAL FROM MESA WHERE ID_MESA=:id_mesa1";
            $stmt = $conexion->prepare($consulta);
            $stmt->bindParam(':id_mesa1',$id_mesa1);
            $stmt->execute();
            return $stmt->fetchColumn() != 0;
        }
        catch (PDOException $e) {
            return false;
        }
    }

    //Añadir a la base de datos
    function add_reserva($conexion,$reserva)
    {
        try {
            $consulta = "CALL ADD_RESERVA(TO_DATE(:HORA_ENTRADA, 'YYYY-MM-DD HH24:MI'), TO_DATE(:HORA_SALIDA, 'YYYY-MM-DD HH24:MI'), :ID_CLIENTE1, :ID_MESA1)";
            $stmt = $conexion->prepare($consulta);

            $stmt->bindParam(':HORA_ENTRADA', $reserva["HORA_ENTRADA"]);
            $stmt->bindParam(':HORA_SALIDA', $reserva["HORA_SALIDA"]);
            $stmt->bindParam(':ID_CLIENTE1', $reserva["ID_CLIENTE1"]);
            $stmt->bindParam(':ID_MESA1', $reserva["ID_MESA1"]);

            $stmt->execute();

            return true;

        }
        catch (PDOException $e) {
            return false;
        }
    }

    //Eliminar de la base de datos
    function remove_reserva($conexion,$ID_RESERVA) {
        try {
            $stmt=$conexion->prepare('CALL BORRAR_RESERVA(:ID_RESERVA)');
            $stmt->bindParam(':ID_RESERVA',$ID_RESERVA);
            $stmt->execute();
            return true;
        } catch(PDOException $e) {
            return false;
        }
    }

    function update_reserva($conexion, $reserva) {
        try {
            $stmt=$conexion->prepare("CALL EDITAR_RESERVA(:ID_RESERVA,TO_DATE(:HORA_ENTRADA, 'YYYY-MM-DD HH24:MI'), TO_DATE(:HORA_SALIDA, 'YYYY-MM-DD HH24:MI'),:ID_CLIENTE1,:ID_MESA1)");
            $stmt->bindParam(':ID_RESERVA',$reserva['ID_RESERVA']);
            $stmt->bindParam(':HORA_ENTRADA', $reserva["HORA_ENTRADA"]);
            $stmt->bindParam(':HORA_SALIDA', $reserva["HORA_SALIDA"]);
            $stmt->bindParam(':ID_CLIENTE1', $reserva["ID_CLIENTE1"]);
            $stmt->bindParam(':ID_MESA1', $reserva["ID_MESA1"]);
            $stmt->execute();
            return true;
        } catch(PDOException $e) {
            return false;
        }
    }
?>