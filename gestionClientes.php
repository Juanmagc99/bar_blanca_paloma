<?php
	session_start();
    require_once("gestionBD.php");

    /* =======================================================
                        EDITAR Y BORRAR
    ======================================================= */
    if (isset($_REQUEST["ID_CLIENTE"])) {
        $cliente["ID_CLIENTE"] = $_REQUEST["ID_CLIENTE"];
        $cliente["TLF_CLIENTE"] = $_REQUEST["TLF_CLIENTE"];
        $cliente["NOMBRE_CLIENTE"] = $_REQUEST["NOMBRE_CLIENTE"];
        $cliente["APELLIDOS_CLIENTE"] = $_REQUEST["APELLIDOS_CLIENTE"];

        if (!validarDatosUsuario($cliente)) return;

        if (!isset($_REQUEST["copiar"])) {
            if (isset($_REQUEST["editar"])) {
                $_SESSION["CLIENTE_EDIT"] = $cliente;
            } else if (isset($_REQUEST["grabar"])) {
                unset($_SESSION["CLIENTE_EDIT"]);
                $conexion = crearConexionBD();
                update_cliente($conexion, $cliente);
                cerrarConexionBD($conexion);
            } else if (isset($_REQUEST["borrar"])) {
                $conexion = crearConexionBD();
                remove_cliente($conexion, $cliente["ID_CLIENTE"]);
                cerrarConexionBD($conexion);
            }
            Header('Location: clientes.php');
            return;
        }
    }

    /* =======================================================
                            FORMULARIO
       ======================================================= */
	if (isset($_SESSION["formulario_cliente"])) {

		$nuevoCliente["TLF_CLIENTE"] = $_REQUEST["TLF_CLIENTE"];
		$nuevoCliente["NOMBRE_CLIENTE"] = $_REQUEST["NOMBRE_CLIENTE"];
		$nuevoCliente["APELLIDOS_CLIENTE"] = $_REQUEST["APELLIDOS_CLIENTE"];
	}
	else 
		Header("Location: clientes.php");

	$_SESSION["formulario_cliente"] = $nuevoCliente;

	if (validarDatosUsuario($nuevoCliente)) {
        $conexion = crearConexionBD();
        if (add_cliente($conexion, $nuevoCliente))
            unset($_SESSION["formulario_cliente"]);
        cerrarConexionBD($conexion);
        Header('Location: clientes.php');
	}
		
	// Validación en servidor del formulario
	function validarDatosUsuario($nuevoCliente){
        unset($_SESSION["errores_cliente"]);
        //Validacion tlfn 9 digitos
        if(!preg_match("/^[0-9]{9}$/", $nuevoCliente["TLF_CLIENTE"])){
            $errores_cliente[] = "<p>Formato de numero de teléfono incorrecto: " . $nuevoCliente["TLF_CLIENTE"]. "</p>";
        }

        if ($nuevoCliente["NOMBRE_CLIENTE"] == "")
            $errores_cliente[] = "<p>El nombre no puede estar vacio</p>";

        if ($nuevoCliente["APELLIDOS_CLIENTE"] == "")
            $errores_cliente[] = "<p>Los apellidos no pueden estar vacios</p>";

        if (count($errores_cliente)>0) {
            $_SESSION["errores_cliente"] = $errores_cliente;
            Header('Location: clientes.php');
            return false;
        } else {
            return true;
        }
	}

	//Añadir a la base de datos
	function add_cliente($conexion,$cliente)
	{
		try {
			$consulta = "CALL ADD_CLIENTE(:TLF_CLIENTE, :NOMBRE_CLIENTE, :APELLIDOS_CLIENTE)";
			$stmt = $conexion->prepare($consulta);

			$stmt->bindParam(':TLF_CLIENTE', $cliente["TLF_CLIENTE"]);
			$stmt->bindParam(':NOMBRE_CLIENTE', $cliente["NOMBRE_CLIENTE"]);
			$stmt->bindParam(':APELLIDOS_CLIENTE', $cliente["APELLIDOS_CLIENTE"]);

			$stmt->execute();

			return true;

		}
		catch (PDOException $e) {
			return false;
		}
	}

    //Eliminar de la base de datos
    function remove_cliente($conexion,$ID_CLIENTE) {
        try {
            $stmt=$conexion->prepare('CALL BORRAR_CLIENTE(:ID_CLIENTE)');
            $stmt->bindParam(':ID_CLIENTE',$ID_CLIENTE);
            $stmt->execute();
            return true;
        } catch(PDOException $e) {
            return false;
        }
    }

	function update_cliente($conexion, $cliente) {
        try {
            $stmt=$conexion->prepare('CALL EDITAR_CLIENTE(:ID_CLIENTE,:TLF_CLIENTE,:NOMBRE_CLIENTE,:APELLIDOS_CLIENTE)');
            $stmt->bindParam(':ID_CLIENTE',$cliente['ID_CLIENTE']);
            $stmt->bindParam(':TLF_CLIENTE',$cliente['TLF_CLIENTE']);
            $stmt->bindParam(':NOMBRE_CLIENTE',$cliente['NOMBRE_CLIENTE']);
            $stmt->bindParam(':APELLIDOS_CLIENTE',$cliente['APELLIDOS_CLIENTE']);
            $stmt->execute();
            return true;
        } catch(PDOException $e) {
            return false;
        }
    }
?>