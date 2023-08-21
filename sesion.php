<?php
session_start();
include("conexion.php");
if($_SESSION["idC"]=="") {
	header("Location:login.php");
	exit();
}else{
	$datosCliente = mysqli_fetch_array(mysqli_query($conexion,"SELECT * FROM store_clientes WHERE scli_id='".$_SESSION["idC"]."'"));
	
	//Verificar pagos pendientes
	$pagosPendientes = mysqli_num_rows(mysqli_query($conexion,"SELECT * FROM store_respuesta_pasarela 
	INNER JOIN store_pedidos ON ped_id=respz_pedido AND ped_cliente='".$_SESSION["idC"]."'
	WHERE (respz_estado=999 OR respz_estado=4001 OR respz_estado IS NULL OR respz_estado='') AND TIMESTAMPDIFF(MINUTE,respz_fecha, now())<=20"));
	
	//select TIMESTAMPDIFF(MINUTE,respz_fecha,now()) as minutos from odermancom_jm_crm.store_respuesta_pasarela WHERE respz_id=42;
}
?>