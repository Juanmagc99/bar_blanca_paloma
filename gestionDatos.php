<?php

    function obtenPedidos($conexion,$f_inicio,$f_fin){
        $consulta = "SELECT * FROM PEDIDO WHERE FECHA_PEDIDO >= TO_DATE(:f_inicio,'YYYY-MM-DD HH24:MI') AND FECHA_PEDIDO <= TO_DATE(:f_fin,'YYYY-MM-DD HH24:MI') AND ESTADO_PEDIDO = 'PAGADO'";

        $stmt = $conexion->prepare($consulta);
        $stmt->bindParam(':f_inicio', date('Y-m-d H:i',strtotime($f_inicio)));
        $stmt->bindParam(':f_fin', date('Y-m-d H:i',strtotime($f_fin)));
        $stmt->execute();
        return  $stmt->fetchAll();
    }



?>
