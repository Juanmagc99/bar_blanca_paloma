<?php
	session_start();
	
	if (isset($_SESSION["formulario_reserva"])) {

        $nuevaReserva["HORA_ENTRADA"] = $_REQUEST["HORA_ENTRADA"];
        $nuevaReserva["HORA_SALIDA"] = $_REQUEST["HORA_SALIDA"];
        $nuevaReserva["ID_CLIENTE1"] = $_REQUEST["ID_CLIENTE1"];
        $nuevaReserva["ID_MESA1"] = $_REQUEST["ID_MESA1"];
	}
	else 
		Header("Location: reservas.php");

	$_SESSION["formulario_reserva"] = $nuevaReserva;

 
	$errores_reserva = validarDatosUsuario($nuevaReserva);
	if (count($errores_reserva)>0) {
		$_SESSION["errores_reserva"] = $errores_reserva;
		Header('Location: reservas.php');
	} else {
		require_once("gestionBD.php");

		$conexion = crearConexionBD();
        if (add_reserva($conexion, $nuevaReserva)) {
            $_SESSION["formulario_reserva"] = null;
            $_SESSION["errores_reserva"] = null;
        }
		cerrarConexionBD($conexion);
		Header('Location: reservas.php');
	}
		
	// Validación en servidor del formulario
	function validarDatosUsuario($nuevaReserva){
		return false;
	}

	//Añadir a la base de datos
	function add_reserva($conexion,$reserva)
	{
		try {
			$consulta = "CALL ADD_RESERVA(:HORA_ENTRADA, :HORA_SALIDA, :ID_CLIENTE1, :ID_MESA1)";
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
?>