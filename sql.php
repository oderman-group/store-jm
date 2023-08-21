<?php
session_start();
include("conexion.php");
error_reporting (E_ALL ^ E_NOTICE ^ E_WARNING);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'librerias/phpmailer/Exception.php';
require 'librerias/phpmailer/PHPMailer.php';
require 'librerias/phpmailer/SMTP.php';

//HACER PEDIDO
if($_POST["idSQL"]==1){
	
	if($pagosPendientes>0){
		echo '<center>
				<div style="padding:10px; margin:20px; width:80%; height:200px; background-color:#c92d22; border-radius:5px; font-family:arial; text-align:justify;">
					<h1 style="color:#FFF;">Alerta</h1>
					<p style="color: tomato;">
										Aún tiene una transacción en proceso de verificación. Por favor espere unos minutos.<br>
										Para conocer sus pedidos y el estado de la transacción vaya a la opción <b><a href="mis-pedidos.php">Mis Pedidos</a></b>.
									</p>
				</div>
				<a href="javascript:history.go(-1);" style="padding:10px; margin:20px; background-color:#c92d22; border-radius:5px; font-family:arial; text-decoration:none; color:#FFF;">REGRESAR Y VERIFICAR</a>
			</center>';
		exit();
	}
	
	mysqli_query($conexion,"INSERT INTO store_pedidos(ped_fecha_pedido, ped_estado, ped_total_pagar, ped_ciudad, ped_direccion, ped_telefono, ped_documento, ped_nombre, ped_email, ped_descuento, ped_cliente)
	VALUES(now(), 1, '".$_POST["totalaPagar"]."', '".$_POST["ciudad"]."', '".$_POST["dir"]."', '".$_POST["celular"]."', '".$_POST["doc"]."', '".$_POST["nombre"]."', '".$_POST["email"]."', '".$_POST["dcto"]."', '".$_SESSION["idC"]."')");
	
	$idInsertU = mysqli_insert_id($conexion);
	
	mysqli_query($conexion,"INSERT INTO store_respuesta_pasarela(respz_pedido, respz_id_comercio)
	VALUES('".$idInsertU."', '24497')");
	
	
	$carrito = mysqli_query($conexion,"SELECT * FROM store_carrito
	INNER JOIN productos ON prod_id=car_producto
	WHERE car_cliente='".$_SESSION["idC"]."'");
	
	while($car=mysqli_fetch_array($carrito)){
								
		$utilidadWeb = $car['prod_descuento_web']/100;
		$precioWeb = $car['prod_costo'] + ($car['prod_costo']*$utilidadWeb);
		$precioWebConIva = $precioWeb + ($precioWeb*0.19);
		
		mysqli_query($conexion,"INSERT INTO store_pedidos_items(pedit_pedido, pedit_producto, pedit_cantidad, pedit_valor_base, pedit_impuesto, pedit_descuento)VALUES('".$idInsertU."', '".$car['car_producto']."', '".$car['car_cantidad']."', '".$precioWebConIva."', '0', '0')");
		
		
		mysqli_query($conexion,"UPDATE productos SET prod_existencias=prod_existencias-".$car['car_cantidad']." WHERE prod_id='".$car['car_producto']."'");
		
	}
	
	mysqli_query($conexion,"DELETE FROM store_carrito WHERE car_cliente='".$_SESSION["idC"]."'");
	
	
	$pedido = $idInsertU;
	$totalaPagar = $_POST["totalaPagar"];
	
	
	$fin =  '<html><body style="background-color:#E6E6E6;">';
	$fin .= '
				<center>
					<p align="center"><img src="https://store.jmequipos.com/img/logos/logo-white.png" width="150"></p>
					<div style="font-family:arial; background:#FFF; width:600px; color:#000; text-align:justify; padding:15px; border-radius:10px;">
						Saludos!<br>
						'.strtoupper($_POST["nombre"]).', tu pedido fue registrado correctamente y lo estamos preparando para enviarlo.<br>
						Recuerda que si escogiste un medio de pago en efectivo, una vez hecho el pago debes enviar el soporte al correo <b>store@jmequipos.com</b>.<br>
						Muchas gracias por realizar tu pedido con nosotros.
						<p align="center" style="color:#399;">
							<img src="https://store.jmequipos.com/img/logos/logo-white.png" width="50"><br>
							¡Que tengas un excelente d&iacute;a!<br>
							<a href="https://store.jmequipos.com">www.store.jmequipos.com</a>
						</p>
					</div>
				</center>
				<p>&nbsp;</p>
			';	
	$fin .='';						
	$fin .=  '<html><body>';
	
	// Instantiation and passing `true` enables exceptions
		$mail = new PHPMailer(true);
		echo '<div style="display:none;">';
			try {
				//Server settings
				$mail->SMTPDebug = 2;                                       // Enable verbose debug output
				$mail->isSMTP();                                            // Set mailer to use SMTP
				$mail->Host       = 'mail.jmequipos.com';  // Specify main and backup SMTP servers
				$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
				$mail->Username   = 'store@jmequipos.com';                     // SMTP username
				$mail->Password   = 'store2019$';                               // SMTP password
				$mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
				$mail->Port       = 465;                                    // TCP port to connect to

				//Recipients
				$mail->setFrom('store@jmequipos.com', 'Store JM');
				
				$mail->addAddress($_POST["email"], $_POST["nombre"]);     // Add a recipient
				$mail->addAddress('store@jmequipos.com', 'Store JM');     // Add a recipient
				$mail->addAddress('gerencia@jmequipos.com', 'Gerencia JM');     // Add a recipient
				$mail->addAddress('jmendoza@jmequipos.com', 'Store JM');     // Add a recipient
				$mail->addAddress('administrativa@jmequipos.com', 'Administrativa');     // Add a recipient
				$mail->addAddress('recepcion@jmequipos.com', 'Recepcion');     // Add a recipient
				$mail->addAddress('jaime@jmequipos.com', 'Jaime');     // Add a recipient
				$mail->addAddress('ventas@jmequipos.com', 'Jaime');     // Add a recipient


				// Content
				$mail->isHTML(true);                                  // Set email format to HTML
				$mail->Subject = 'STORE JM - Pedido en la Store JM';
				$mail->Body = $fin;
				$mail->CharSet = 'UTF-8';

				$mail->send();
				echo 'Fin del proceso.';
			} catch (Exception $e) {echo "Error: {$mail->ErrorInfo}";}
		echo '</div>';
	
	$firmaDatos = 'C4budLS1xJFM8LwZQNQt218wHx~764579~'.$idInsertU.'~'.$totalaPagar.'~COP';
	$firma = md5($firmaDatos);
?>	

<!--
<form method="post" name="frm_botonPayU" action="https://checkout.payulatam.com/ppp-web-gateway-payu"> 
								  <input name="merchantId"    type="hidden"  value="764579">
								  <input name="accountId"     type="hidden"  value="771173">
								  <input name="description"   type="hidden"  value="Compra en la tienda JM">
								  <input name="referenceCode" type="hidden"  value="<?=$idInsertU;?>" >
								  <input name="amount"        type="hidden"  value="<?=$totalaPagar;?>">
								  <input name="tax"           type="hidden"  value="0">
								  <input name="taxReturnBase" type="hidden"  value="0">
								  <input name="currency"      type="hidden"  value="COP">
								  <input name="signature"     type="hidden"  value="<?=$firma;?>">
								  <input name="test"          type="hidden"  value="0">
								  <input name="buyerFullName" type="hidden"  value="<?=$_POST["nombre"];?>">	
								  <input name="buyerEmail"    type="hidden"  value="<?=$_POST["email"];?>">
								  <input name="shippingAddress" type="hidden"  value="<?=$_POST["dir"];?>">
								  <input name="shippingCity"  type="hidden"  value="<?=$_POST["ciudad"];?>">
								  <input name="shippingCountry" type="hidden"  value="CO">
								  <input name="telephone"     type="hidden"  value="<?=$_POST["celular"];?>">	
								  <input name="responseUrl"    type="hidden"  value="https://jmequipos.com/respuesta.php">
								  <input name="confirmationUrl"    type="hidden"  value="https://jmequipos.com/respuesta.php">
								  <input name="extra1"    type="hidden"  value="<?=$_POST["nombre"];?>">
								</form>

		<script type="text/javascript">
			document.frm_botonPayU.submit();
		</script>-->
								




								<form method="post" name="frm_botonZona" action="pagos-online-pruebas/consumir.php">
								  <input name="str_descripcion_pago"   type="hidden"  value="Compra en la tienda JMEQUIPOS">
								  <input name="str_id_pago" type="hidden"  value="<?=$pedido;?>" >
								  <input name="flt_total_con_iva"        type="hidden"  value="<?=$totalaPagar;?>">
								  <input name="str_nombre_cliente" type="hidden"  value="<?=$_POST["nombre"];?>">
									<input name="str_apellido_cliente" type="hidden"  value="N/R">
								  <input name="str_email"    type="hidden"  value="<?=$_POST["email"];?>">
								  <input name="str_telefono_cliente"     type="hidden"  value="<?=$_POST["celular"];?>">
								  <input name="str_id_cliente"     type="hidden"  value="<?=$_POST["doc"];?>">
								</form>

		<script type="text/javascript">
			document.frm_botonZona.submit();
		</script>
<?php
	
	exit();
}
//Login
if($_POST["idSQL"]==2){
	
	$usrExiste = mysqli_query($conexion,"SELECT * FROM store_clientes WHERE scli_email='".trim($_POST["email"])."'");
	$numE = mysqli_num_rows($usrExiste);
	if($numE==0)
	{
		header("Location:login.php?error=1");
		exit();	
	}
	
	$rst_usr = mysqli_query($conexion,"SELECT * FROM store_clientes WHERE scli_email='".trim($_POST["email"])."' AND scli_clave='".$_POST["clave"]."'");
	
	
	$num = mysqli_num_rows($rst_usr);
	$fila = mysqli_fetch_array($rst_usr);
	if($num>0)
	{
		$_SESSION["idC"] = $fila[0];
		$_SESSION["nameC"] = $fila[3];
		header("Location:carrito-resumen.php");	
		exit();
	}else{
		header("Location:login.php?error=2");
		exit();
	}
}

//Registro
if($_POST["idSQL"]==3){
	
	if(trim($_POST["email"])=="" or trim($_POST["clave"])=="" or trim($_POST["nombre"])==""){
		echo '<center>
				<div style="padding:10px; margin:20px; width:80%; height:200px; background-color:#c92d22; border-radius:5px; font-family:arial; text-align:justify;">
					<h1 style="color:#FFF;">Alerta</h1>
					<p style="color:#FFF;">Debe llenar todos los campos para continuar.</p>
				</div>
				<a href="javascript:history.go(-1);" style="padding:10px; margin:20px; background-color:#c92d22; border-radius:5px; font-family:arial; text-decoration:none; color:#FFF;">REGRESAR Y VERIFICAR</a>
			</center>';
		exit();
	}
	
	$emailD = mysqli_num_rows(mysqli_query($conexion,"SELECT * FROM store_clientes WHERE scli_email='".$_POST["email"]."'"));
	if($emailD>0){
		echo '<center>
				<div style="padding:10px; margin:20px; width:80%; height:200px; background-color:#c92d22; border-radius:5px; font-family:arial; text-align:justify;">
					<h1 style="color:#FFF;">Alerta</h1>
					<p style="color:#FFF;">Este email (<b>'.$_POST["email"].'</b>) ya est&aacute; registrado. Por favor verifica.</p>
				</div>
				<a href="javascript:history.go(-1);" style="padding:10px; margin:20px; background-color:#c92d22; border-radius:5px; font-family:arial; text-decoration:none; color:#FFF;">REGRESAR Y VERIFICAR</a>
			</center>';
		exit();
	}
	
	$clave = rand(10000,99999);
	mysqli_query($conexion,"INSERT INTO store_clientes(scli_email, scli_clave, scli_nombre)
	VALUES('".strtolower($_POST["email"])."','".$_POST["clave"]."','".strtoupper($_POST["nombre"])."')");
	
	$idInsertU = mysqli_insert_id($conexion);
	
	$_SESSION["idC"] = $idInsertU;
	$_SESSION["nameC"] = strtoupper($_POST["nombre"]);
	header("Location:carrito-resumen.php");	
	exit();
}



###########################GET GET##############################################
//AGREGAR AL CARRITO
if($_GET["get"]==2){
	$carrito = mysqli_query($conexion,"SELECT * FROM store_carrito
	INNER JOIN productos ON prod_id=car_producto
	WHERE car_cliente='".$_SESSION["idC"]."' AND car_producto='".$_GET["pd"]."'");

	$cart = mysqli_fetch_array($carrito);
	$num = mysqli_num_rows($carrito);
	
	if($num==0){
		mysqli_query($conexion,"INSERT INTO store_carrito(car_cliente, car_producto, car_cantidad, car_momento)VALUES('".$_SESSION["idC"]."','".$_GET["pd"]."',1,now())");
	}else{
		/*if(($cart['car_cantidad']+1)>$cart['prod_existencias']){		
			echo "Se agotaron las existencias";
			exit();
		}*/
		mysqli_query($conexion,"UPDATE store_carrito SET car_cantidad=car_cantidad+1, car_momento_actualizado=now() WHERE car_cliente='".$_SESSION["idC"]."' AND car_producto='".$_GET["pd"]."'");
	}
	echo '<script type="text/javascript">window.location.href="'.$_SERVER["HTTP_REFERER"].'";</script>';
	exit();
}
//QUITAR AL CARRITO
if($_GET["get"]==3){
	$carrito = mysqli_query($conexion,"SELECT * FROM store_carrito
	INNER JOIN productos ON prod_id=car_producto
	WHERE car_cliente='".$_SESSION["idC"]."' AND car_producto='".$_GET["pd"]."'");

	$cart = mysqli_fetch_array($carrito);
	$num = mysqli_num_rows($carrito);
	if($cart["car_cantidad"]==1){
		mysqli_query($conexion,"DELETE FROM store_carrito WHERE car_cliente='".$_SESSION["idC"]."' AND car_producto='".$_GET["pd"]."'");
	}else{
		mysqli_query($conexion,"UPDATE store_carrito SET car_cantidad=car_cantidad-1, car_momento_actualizado=now() WHERE car_cliente='".$_SESSION["idC"]."' AND car_producto='".$_GET["pd"]."'");
	}
	echo '<script type="text/javascript">window.location.href="'.$_SERVER["HTTP_REFERER"].'";</script>';
	exit();
}
//ELIMINAR DEL CARRITO
if($_GET["get"]==4){
	mysqli_query($conexion,"DELETE FROM store_carrito WHERE car_id='".$_GET["item"]."'");

	echo '<script type="text/javascript">window.location.href="'.$_SERVER["HTTP_REFERER"].'";</script>';
	exit();
}
?>