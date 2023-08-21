<?php
session_start();
include("conexion.php");
if(!empty($_SESSION["idC"])) {
	header("Location:carrito-resumen.php");
	exit();
}	 
?>