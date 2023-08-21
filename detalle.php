<?php
session_start();
include("conexion.php");
?>
<?php
$producto = mysqli_fetch_array(mysqli_query($conexion,"SELECT * FROM productos WHERE prod_id='".$_GET["id"]."'"));
$foto = $producto['prod_foto'];
if($producto['prod_foto']==""){
	$foto = 'sinfoto.png';
}
$precioConIva = $producto['prod_precio'] + ($producto['prod_precio']*0.19);
								
$utilidadWeb = $producto['prod_descuento_web']/100;
$precioWeb = $producto['prod_costo'] + ($producto['prod_costo']*$utilidadWeb);
$precioWebConIva = $precioWeb + ($precioWeb*0.19);
?>

<?php include("head.php");?>

</head>

<body>

    <!-- start main-wrapper section -->
    <div class="main-wrapper position-inherit">

        <?php include("menu.php");?>
		<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
		
        <!-- start page title section -->
        <section class="page-title-section bg-img cover-background" data-overlay-dark="7" data-background="img/bg/bProductos.jpg">
            <div class="container">

                <div class="row">
                    <div class="col-md-7 col-sm-12">
                        <h1><?=$producto['prod_nombre'];?></h1>
                    </div>
                    <div class="col-md-5 col-sm-12">
                        <ul class="text-right xs-text-left sm-margin-8px-top xs-margin-5px-top">
                            <li><a href="index.php">Productos</a></li>
                            <li><a href="javascript:void(0)"><?=$producto['prod_nombre'];?></a></li>
                        </ul>
                    </div>
                </div>

            </div>
        </section>
        <!-- end page title section -->

        <section>
            <div class="container">

                <!-- Start Product Section -->
                <div class="row margin-90px-bottom md-margin-70px-bottom sm-margin-50px-bottom">
                    <div class="col-lg-5 sm-text-center sm-margin-30px-bottom">

                        <!-- product left start -->
                        <div class="xzoom-container">
                            <img class="xzoom5 margin-30px-bottom" id="xzoom-magnific" src="https://softjm.com/usuarios/files/productos/<?=$foto;?>" xoriginal="https://softjm.com/usuarios/files/productos/<?=$foto;?>" />
							
							
                            <div class="xzoom-thumbs no-margin">
								<a href="https://softjm.com/usuarios/files/productos/<?=$foto;?>"><img class="xzoom-gallery5" width="80" src="https://softjm.com/usuarios/files/productos/<?=$foto;?>" xpreview="https://softjm.com/usuarios/files/productos/<?=$foto;?>" title="<?=$producto['prod_nombre'];?>"></a>
								
								<?php
								$fotos = mysqli_query($conexion,"SELECT * FROM productos_galeria WHERE pgal_producto='".$_GET["id"]."'");
								while($foto = mysqli_fetch_array($fotos)){
								?>	
                                <a href="https://softjm.com/usuarios/files/productos/galeria/<?=$foto['pgal_foto'];?>"><img class="xzoom-gallery5" width="80" src="https://softjm.com/usuarios/files/productos/galeria/<?=$foto['pgal_foto'];?>" xpreview="https://softjm.com/usuarios/files/productos/galeria/<?=$foto['pgal_foto'];?>" title="<?=$producto['prod_nombre'];?>"></a>
								<?php }?>
                            </div>
							
							
                        </div>
                        <!-- product left end -->

                    </div>
                    <div class="col-lg-7 padding-40px-left sm-padding-15px-lr">
                        <div class="product-detail">
                            <h3 class="margin-8px-bottom"><?=$producto['prod_nombre'];?> </h3>
                            <div class="bg-theme separator-line-horrizontal-full margin-20px-bottom"></div>
                            <!--<p class="rating-text"><span>Sku:</span> <span class="font-500 theme-color"><?=$producto['prop_id'];?></span></p>-->
							
							<h3>
                            	<span class="red line-through margin-10px-right">$<?=number_format($precioConIva,0,".",",");?></span>
                            	<span>$<?=number_format($precioWebConIva,0,".",",");?></span>
                            </h3>
							
                            <p><?=$producto['prod_descripcion_corta'];?></p>
                            

                            <div class="row margin-20px-bottom">
                                <div class="col-lg-12">
									
                                    <?php if(!empty($producto['prod_ficha'])){?>
										<a href="https://jmequipos.com/archivos/fichas/<?=$producto['prod_ficha'];?>" class="butn theme margin-15px-right xs-margin-10px-bottom" target="_blank"><span><i class="fas fa-file margin-5px-right"></i> Ficha técnica</span></a>
									<?php }?>
										
										<?php if(!empty($_SESSION["idC"])){?>
                                    	<a href="#sql.php?get=2&pd=<?=$producto['prod_id'];?>" id="<?=$producto['prod_id'];?>" onClick="carrito(this.id)" class="butn margin-15px-right xs-margin-10px-bottom" style="background-color: darkblue;"><span><i class="fas fa-shopping-cart margin-5px-right"></i> Añadir al carrito</span></a>
										<?php }else{?>
											<a href="login.php" class="butn margin-15px-right xs-margin-10px-bottom" style="background-color: darkblue;"><span><i class="fas fa-shopping-cart margin-5px-right"></i> Añadir al carrito</span></a>
										<?php }?>
									
										<!--
										<a href="sql.php?get=1&totalaPagar=<?=round($precioWebConIva,0);?>&idP=<?=$producto['prod_id'];?>&nombP=<?=$producto['prod_nombre'];?>" class="butn margin-15px-right xs-margin-10px-bottom" style="background-color: darkred;" target="_blank"><span><i class="fas fa-credit-card margin-5px-right"></i> Comprar Ahora</span></a>-->
									
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- End Product Section -->

                <!-- Start Product Description -->
                <div class="row margin-70px-bottom md-margin-70px-bottom sm-margin-50px-bottom">

                    <div class="col-12">
                        <div class="horizontaltab tab-style5">
                            <ul class="resp-tabs-list hor_1 text-left">
                                <li>Descripción</li>
                                <!--<li>Vídeo</li>-->
                            </ul>
                            <div class="resp-tabs-container hor_1">
                                <div>
                                    <?=$producto['prod_descripcion_larga'];?>
                                </div>
                                <div>
                                    <div class="row">
                                        <div class="col-md-12">
											<?php if(!empty($producto['prod_video'])){?>
                                            	<iframe width="560" height="315" src="https://www.youtube.com/embed/<?=$producto['prod_video'];?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
											<?php }?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Product Description -->

                <!-- Start Related Product --
                <div class="row">
                    <div class="col-12">
                        <div class="section-heading title-style3">
                            <h3 class="font-size22 xs-font-size18">Productos relacionados</h3>
                        </div>
                    </div>

                    <div class="carousel-style4 col-12">
                        <div class="product-grid control-top owl-carousel owl-theme">

							<?php
							$productos_relacionados = mysqli_query($conexion,"SELECT * FROM productos WHERE prod_categoria='".$producto['prod_categoria']."' AND prop_id!='".$producto['prop_id']."'");
							while($pr = mysqli_fetch_array($productos_relacionados)){
							?>
                            <div class="border">
                                <a href="detalle.php?id=<?=$pr['prop_id'];?>" class="product-block">
									<img src="../imagenes/productos/<?=$pr['prod_img_ppal'];?>" alt="" width="200" height="200" />
								</a>
                                <div class="product-info">
                                    <a href="detalle.php?id=<?=$pr['prop_id'];?>"><?=$pr['prod_nombre'];?></a>
                                </div>
                            </div>
							<?php }?>
							

                        </div>
                    </div>

                </div>
                <!-- End Related Product -->

            </div>
        </section>


        <?php include("marcas.php");?>
		
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

    <!-- zoom js -->
    <script src="js/xzoom.js"></script>

    <!-- setup js -->
    <script src="js/setup.js"></script>

    <!-- map js -->
    <script src="js/map.js"></script>

    <!-- custom scripts -->
    <script src="js/main.js"></script>

    <!-- all js include end -->

</body>

</html>