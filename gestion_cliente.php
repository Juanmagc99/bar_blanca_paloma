<?php
session_start();

require_once("gestionBD.php");

if (isset($_SESSION["formulario_cliente"])) {
    $nuevoUsuario = $_SESSION["formulario_cliente"];
    $_SESSION["formulario_cliente"] = null;
    $_SESSION["errores"] = null;
}
else
    Header("Location: clientes.php");

$conexion = crearConexionBD();
add_cliente($conexion, $nuevoUsuario)
?>

<?php
 function add_cliente($conexion,$cliente) {
	 
	try {
		$consulta = "CALL ADD_CLIENTE(:TLF_CLIENTE, :NOMBRE_CLIENTE, :APELLIDOS_CLIENTE)";
		$stmt=$conexion->prepare($consulta);
		
		$stmt->bindParam(':TLF_CLIENTE',$cliente["TLF_CLIENTE"]);
		$stmt->bindParam(':NOMBRE_CLIENTE',$cliente["NOMBRE_CLIENTE"]);
		$stmt->bindParam(':APELLIDOS_CLIENTE',$cliente["APELLIDOS_CLIENTE"]);

		$stmt->execute();
		
		return true;
		
	}catch(PDOException $e){
		return false;
		
	}
	
}
?>