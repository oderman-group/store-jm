<?php
include("sesion.php");
?>

<?php include("head.php");?>

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
                            <h4>Carrito de compras</h4>
                        </div>
						
						<h6><b>NOTA:</b> Recuerde que los precios no incluyen el precio de envío.</h6>
                        
						 <div class="cart-table-container">
                            <table class="table table-cart">
                                <thead>
                                    <tr>
                                        <th class="product-col">Producto</th>
                                        <th class="price-col">Precio</th>
                                        <th class="qty-col">Cant</th>
                                        <th>Subtotal</th>
										<th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
									<?php
									$carrito = mysqli_query($conexion,"SELECT * FROM store_carrito
									INNER JOIN productos ON prod_id=car_producto
									WHERE car_cliente='".$_SESSION["idC"]."'");
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
														
														$totalXproducto = $precioWebConIva*$car['car_cantidad'];
														$sumaCart += $totalXproducto;
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
                                            <a href="sql.php?get=3&pd=<?=$car['prod_id'];?>" class="button tiny">-</a> 
											<span style="font-size: 25px;"><?=$car['car_cantidad'];?></span> 
											<a href="sql.php?get=2&pd=<?=$car['prod_id'];?>" class="button tiny">+</a>
                                        </td>
                                        <td>$<?php echo number_format($totalXproducto,0,",",".");?></td>
										<td><h5><a href="sql.php?get=4&item=<?=$car['car_id'];?>" onClick="if(!confirm('Desea eliminar este producto del carrito?')){return false;}">X</a></h5></td>
                                    </tr>
									<?php }?>
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <td colspan="5" class="clearfix">
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
                            <h5>Resúmen del pedido</h5>
                        </div>
						
						<?php
						$tranoche = mysqli_fetch_array(mysqli_query($conexion,"SELECT TIMESTAMPDIFF(MINUTE, '2019-12-09 10:00:00', now()), TIMESTAMPDIFF(MINUTE, '2019-12-10 01:00:00', now())"));
						$dcto = 0;
						if($tranoche[0]>=0 and $tranoche[1]<=0){
							$dcto = ($sumaCart * 0.1);
						}
						$totalaPagar = round(($sumaCart - $dcto),0);
						?>
						
						<p style="font-size: 20px; color: darkblue;">
						<b>Total:</b> $<?php echo number_format($sumaCart,0,",",".");?><br>
						<b>Descuento:</b> $<?php echo number_format($dcto,0,",",".");?><br>
						<b>Total a pagar:</b> $<?php echo number_format($totalaPagar,0,",",".");?> 
						</p>	
						
                        <div class="section-heading left">
                            <h5>Datos de envío</h5>
                        </div>
						
						<h6><b>IMPORTANTE:</b> Si va a escoger un medio de pago en efectivo, recuerde que, una vez hecho el pago, debe enviar el soporte al correo <b>store@jmequipos.com</b></h6>
						
                        <div class="contact-form-box margin-30px-top">
                            <div class="no-margin-lr" id="success-contact-form" style="display: none;"></div>
							
                            <script type="text/javascript">
								function misPedidos(){
									setTimeout(function(){
										window.location.href="mis-pedidos.php";
									},2000);
								}

								
							</script>
							
							<form method="post" action="sql.php" target="_blank">
								<input type="hidden" name="idSQL" value="1">
								<input type="hidden" name="totalaPagar" value="<?=round($totalaPagar,0);?>">
								<input type="hidden" name="dcto" value="<?=round($dcto,0);?>">
								
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="text" class="medium-input" maxlength="50" placeholder="Nombre *" required="required" name="nombre" value="<?=$datosCliente['scli_nombre'];?>" />
                                    </div>
									<div class="col-md-12">
                                        <input type="email" class="medium-input" maxlength="70" placeholder="E-mail *" required="required" name="email" value="<?=$datosCliente['scli_email'];?>" />
                                    </div>
									
									<div class="col-md-12">
                                        <input type="text" class="medium-input" maxlength="50" placeholder="Documento *" required name="doc" />
                                    </div>
									<div class="col-md-12">
                                        <input type="text" class="medium-input" maxlength="70" placeholder="Celular *" required="required" name="celular" />
                                    </div>
									<div class="col-md-12">
                                        <input type="text" class="medium-input" maxlength="70" placeholder="Ciudad *" required="required" name="ciudad" />
                                    </div>
                                    <div class="col-md-12">
                                        <input type="text" class="medium-input" maxlength="70" placeholder="Dirección *" required="required" name="dir" />
                                    </div>

                                    <hr>
                                    <span style="font-size:15px; margin-bottom: 10px; color: darkblue;"><b>SALDO:</b> Si usted es cliente activo de <b>JM EQUIPOS</b> y tiene saldo acumulado, puede redimirlo. En tal caso coloque su usuario y clave para hacer la validación.</span>

                                    <div class="col-md-12">
                                        <input type="text" class="medium-input" maxlength="70" placeholder="Usuario/Documento *" name="usuario" />
                                    </div>
                                    <div class="col-md-12">
                                        <input type="password" class="medium-input" maxlength="70" placeholder="Contraseña *" name="clave" />
                                    </div>


									<?php 
									if($pagosPendientes==0){
									?>
                                    <div class="col-md-12 sm-margin-30px-bottom">
                                        <button onClick="misPedidos()" type="submit" class="butn"><span>Ir al pago</span></button>
                                    </div>
									<?php }else{?>
									<p style="color: tomato;">
										Aún tiene una transacción en proceso de verificación. Por su seguridad financiera, por favor espere unos 20 minutos para evitar duplicidad en sus pagos.<br>
										Para conocer sus pedidos y el estado de la transacción vaya a la opción <b><a href="mis-pedidos.php">Mis Pedidos</a></b>.
									</p>
									<?php  }?>
										
                                </div>
                            </form>
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