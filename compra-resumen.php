<?php
include("sesion.php");
/*
https://store.jmequipos.com/compra-resumen.php?
merchantId=764579
&merchant_name=JMENDOZA+EQUIPOS+SAS
&merchant_address=CALLE+30B+N+71-42
&telephone=3220619
&merchant_url=https%3A%2F%2Fwww.jmequipos.com

&transactionState=7
&lapTransactionState=PENDING
&message=PENDING
&referenceCode=01_40_17_118
&reference_pol=1142372006
&transactionId=cf7e64da-b4a0-427b-9fe6-533907da11ce
&description=Compra+en+la+tienda+JMEQUIPOS
&trazabilityCode=
&cus=
&orderLanguage=es
&extra1=jhon+oderman
&extra2=
&extra3=
&polTransactionState=14
&signature=e85d1d0e504c4d875f1567e307c4ae86
&polResponseCode=25
&lapResponseCode=PENDING_TRANSACTION_CONFIRMATION
&risk=
&polPaymentMethod=36
&lapPaymentMethod=BANK_REFERENCED
&polPaymentMethodType=10
&lapPaymentMethodType=BANK_REFERENCED
&installmentsNumber=1
&TX_VALUE=541325.00
&TX_TAX=.00
&currency=COP
&lng=es
&pseCycle=
&buyerEmail=jhooderman%40gmail.com
&pseBank=
&pseReference1=
&pseReference2=
&pseReference3=
&authorizationCode=
*/

mysqli_query($conexion,"UPDATE store_pedidos SET ped_estado='".$_GET["transactionState"]."' WHERE ped_id='".$_GET["referenceCode"]."'");

$pedido = mysqli_fetch_array(mysqli_query($conexion,"SELECT * FROM store_pedidos WHERE ped_id='".$_GET["referenceCode"]."'"));

if($_GET["transactionState"]==4){
	$clave1 = rand(10000,99999);
	$clave2 = rand(10000,99999);

	mysqli_query($conexion,"INSERT INTO clientes(cli_nombre, cli_referencia, cli_categoria, cli_email, cli_telefono, cli_ciudad, cli_usuario, cli_clave, cli_direccion, cli_zona, cli_fecha_registro, cli_fecha_ingreso, cli_clave_documentos)
	VALUES('".$_POST["nombre"]."', 'Pedidos Store', '2', '".$pedido['ped_email']."', '".$pedido['ped_telefono']."', 1, '".trim($pedido['ped_documento'])."', '".$clave1."', '".strtoupper($pedido['ped_direccion'])."', 1, now(), now(), '".$clave2."')");

}
?>
<!DOCTYPE html>
<html lang="zxx">

<head>

    <!-- metas -->
    <meta charset="utf-8">
    <meta name="author" content="Jhon Oderman" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="keywords" content="JM EQUIPOS" />
    <meta name="description" content="JMEQUIPOS" />


    <!-- favicon -->
    <link rel="shortcut icon" href="img/logos/favicon.png">
    <link rel="apple-touch-icon" href="img/logos/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="72x72" href="img/logos/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="img/logos/apple-touch-icon-114x114.png">

	<!-- title  -->
    <title>Resúmen de compra</title>

    <!-- bootstrap css -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- font awesome css -->
    <link href="css/fontawesome-all.min.css" rel="stylesheet">

    <!-- et-line icon css -->
    <link href="css/et-line.css" rel="stylesheet">

    <!-- revolution slider css -->
    <link rel="stylesheet" href="css/rev_slider/settings.css">
    <link rel="stylesheet" href="css/rev_slider/layers.css">
    <link rel="stylesheet" href="css/rev_slider/navigation.css">

    <!-- magnific popup css -->
    <link href="css/magnific-popup.css" rel="stylesheet">

    <!-- owl carousel css -->
    <link href="css/owl.carousel.css" rel="stylesheet">

    <!-- template default css -->
    <link href="css/default.css" rel="stylesheet">

    <!-- navigation css -->
    <link href="css/nav-menu.css" rel="stylesheet">

    <!-- custom css -->
    <link href="css/styles-3.css" rel="stylesheet" id="colors">

	<style type="text/css">
		.imagenProducto{
			width: 300px !important;
			height: 300px !important;
		}
	</style>

</head>

<body>

    <?php include("loading.php");?>

    <!-- start main-wrapper section -->
    <div class="main-wrapper">

        <?php include("menu.php");?>

       <p>&nbsp;</p>

        <!-- start contact section -->
        <section id="contacto">
            <div class="container">
                <div class="row">
                    <!-- start contact form -->
                    <div class="col-lg-8">
                        <div class="section-heading left">
                            <h4>Productos</h4>
                        </div>
						
						
						<h6><b>NOTA:</b> Se enviarán de inmediato los productos que tenemos en existencia y el restante en un máximo de 20 días.</h6>
                        
						 <div class="cart-table-container">
                            <table class="table table-cart">
                                <thead>
                                    <tr>
                                        <th class="product-col">Producto</th>
                                        <th class="price-col">Precio</th>
                                        <th class="qty-col">Cant</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
									<?php
									$carrito = mysqli_query($conexion,"SELECT * FROM store_pedidos_items
									INNER JOIN productos ON prod_id=pedit_producto
									WHERE pedit_pedido='".$_GET["referenceCode"]."'");
									$numCar = mysqli_num_rows($carrito);
									if($numCar==0){
										//echo '<script type="text/javascript">window.location.href="index.php";</script>';
										//exit();
									}
										$sumaCart = 0;
									  while($car = mysqli_fetch_array($carrito)){
										$foto = $car['prod_foto'];
														if($car['prod_foto']==""){
															$foto = 'sinfoto.png';
														}
														
														$precioConIva = $car['prod_precio'] + ($car['prod_precio']*0.19);
								
														$utilidadWeb = $car['prod_descuento_web']/100;
														$precioWeb = $car['prod_costo'] + ($car['prod_costo']*$utilidadWeb);
														$precioWebConIva = $precioWeb + ($precioWeb*0.19);
														
														$totalXproducto = $precioWebConIva*$car['pedit_cantidad'];
														$suma += $totalXproducto;
									?>
                                    <tr class="product-row">
                                        <td class="product-col">
                                            <figure class="product-image-container">
                                                <a href="detalle.php?id=<?=$car['prod_id'];?>" class="product-image">
                                                    <img src="https://softjm.com/usuarios/files/productos/<?=$foto;?>" alt="product" width="50">
                                                </a>
                                            </figure>
                                                <a href="detalle.php?id=<?=$car['prod_id'];?>"><?=$car['prod_nombre'];?></a>
                                        </td>
                                        <td>$<?php echo number_format($precioWebConIva,0,",",".");?></td>
                                        <td>
                                            <span style="font-size: 25px;"><?=$car['pedit_cantidad'];?></span>
                                        </td>
                                        <td>$<?php echo number_format($totalXproducto,0,",",".");?></td>
                                    </tr>
									<?php }?>
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="clearfix">
                                            <div class="float-left">
                                                <a href="index.php" class="btn btn-outline-secondary">Continuar Comprando</a>
                                            </div><!-- End .float-left -->
											
											<!--
                                            <div class="float-right">
                                                <a href="#" class="btn btn-outline-secondary btn-clear-cart">Clear Shopping Cart</a>
                                                <a href="#" class="btn btn-outline-secondary btn-update-cart">Update Shopping Cart</a>
                                            </div><!-- End .float-right --
                                        </td>
										-->
                                    </tr>
                                </tfoot>
                            </table>
                        </div><!-- End .cart-table-container -->
						
                    </div>
                    <!-- end contact form  -->

                    <!-- start contact detail -->
                    <div class="col-lg-4">
						<div class="section-heading left">
                            <h5>Resúmen de compra</h5>
                        </div>
						
						<p style="font-size: 20px; color: darkblue;">
						<b>Total Neto:</b> $<?php echo number_format($pedido['ped_total_pagar'],0,",",".");?> 
						</p>	
						
                        <div class="section-heading left">
                            <h5>Datos del comprador</h5>
                        </div>
						
						<p><b>DOCUMENTO:</b> <?=$pedido['ped_documento'];?></p>
						<p><b>NOMBRE:</b> <?=$pedido['ped_nombre'];?></p>
						<p><b>EMAIL:</b> <?=$pedido['ped_email'];?></p>
						<p><b>CELULAR:</b> <?=$pedido['ped_telefono'];?></p>
						<p><b>CIUDAD:</b> <?=$pedido['ped_ciudad'];?></p>
						<p><b>DIRECCIÓN:</b> <?=$pedido['ped_direccion'];?></p>
						
                        <div class="contact-form-box margin-30px-top">
                            <div class="no-margin-lr" id="success-contact-form" style="display: none;"></div>
                            
                        </div>
                    </div>
                    <!-- end contact detail -->
                </div>
            </div>
        </section>
        <!-- end contact section -->
 
        <?php include("footer.php");?>

    </div>
    <!-- end main-wrapper section -->

    <!-- start scroll to top -->
    <a href="javascript:void(0)" class="scroll-to-top"><i class="fas fa-angle-up" aria-hidden="true"></i></a>
    <!-- end scroll to top -->

    <!-- all js include start -->

    <!-- jQuery -->
    <script src="js/jquery.min.js"></script>

    <!-- modernizr js -->
    <script src="js/modernizr.js"></script>

    <!-- bootstrap -->
    <script src="js/bootstrap.min.js"></script>

    <!-- navigation -->
    <script src="js/nav-menu.js"></script>

    <!-- tab -->
    <script src="js/easy.responsive.tabs.js"></script>

    <!-- owl carousel -->
    <script src="js/owl.carousel.js"></script>

    <!-- jquery.counterup.min -->
    <script src="js/jquery.counterup.min.js"></script>

    <!-- stellar js -->
    <script src="js/jquery.stellar.min.js"></script>

    <!-- waypoints js -->
    <script src="js/waypoints.min.js"></script>

    <!-- tab js -->
    <script src="js/tabs.min.js"></script>

    <!-- countdown js -->
    <script src="js/countdown.js"></script>

    <!-- jquery.magnific-popup js -->
    <script src="js/jquery.magnific-popup.min.js"></script>

    <!-- isotope.pkgd.min js -->
    <script src="js/isotope.pkgd.min.js"></script>

    <!-- map js -->
    <script src="js/map.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCIy8l8gSJaMoUvCZJv8AyCAw3CU07nCKs&amp;callback=initMap" async defer></script>

    <!-- custom scripts -->
    <script src="js/main.js"></script>

    <!-- all js include end -->

</body>

</html>