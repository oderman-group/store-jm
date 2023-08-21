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
                            <h4>Mis pedidos</h4>
                        </div>
						
						<div class="float-left" style="margin: 10px;">
                                                <a href="mis-pedidos.php" class="btn btn-outline-secondary">Refrescar página</a>
                                            </div><!-- End .float-left -->
                        
						 <div class="cart-table-container">
                            <table class="table table-cart">
                                <thead>
                                    <tr>
                                        <th class="product-col">Fecha</th>
                                        <th class="price-col">Id Pedido</th>
                                        <th class="qty-col">Estado</th>
										<th class="qty-col">Forma de Pago</th>
										<th class="qty-col">&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
									<?php
									$estadosPedido = array(200=>"Iniciado", 777=>"Declinado", 888=>"Por iniciar", 999=>"Por finalizar", 4001=>"Pendiente", 1=>"OK", 1=>"OK", 1000=>"Rechazado", ""=>"Desconocido", 4000=>"Rechazado CR", 4003=>"Error CR", 1001=>"Error entre ACH y el banco", 1002=>"Rechazado");
									
									$formaPago = array(29=>"PSE", 32=>"TC", 41=>"PDF en ZP", 42=>"GANA", 45=>"Tarjeta tuya", ""=>"Desconocido", 0=>"Desconocido");
									
									$pedidos = mysqli_query($conexion,"SELECT * FROM store_respuesta_pasarela
									INNER JOIN store_pedidos ON ped_id=respz_pedido AND ped_cliente='".$_SESSION["idC"]."'
									ORDER BY respz_id DESC
									");
									while($ped = mysqli_fetch_array($pedidos)){
									?>
                                    <tr class="product-row">
                                        <td><?php echo $ped['respz_fecha'];?></td>
										<td><?php echo $ped['respz_pedido'];?></td>
										<td><?php echo $estadosPedido[$ped['respz_estado']];?></td>
										<td><?php echo $formaPago[$ped['respz_forma_pago']];?></td>
										<td>
											<?php if($ped['respz_estado']==999 or $ped['respz_estado']==4001 or $ped['respz_estado']==""){?>
												<a href="../verificar-respuesta.php?idPay=<?=$ped['respz_pedido'];?>" target="_blank" style="color: blue; text-decoration: underline;" onClick="refrescar()">Consultar estado</a>
											<?php }?>
										</td>
                                    </tr>
									<?php }?>
                                </tbody>
                            </table>
                        </div><!-- End .cart-table-container -->
						
						<script>
							function refrescar(){
								location.reload();
							}
						</script>
						
                    </div>
                    <!-- end contact form  -->

                    
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