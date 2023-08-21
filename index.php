<?php
session_start();
include("conexion.php");
?>

<?php include("head.php");?>

</head>

<body>

    <?php include("loading.php");?>

    <!-- start main-wrapper section -->
    <div class="main-wrapper">

        <?php include("menu.php");?>

		<p>&nbsp;</p>
        <section>
            <div class="container">
                <div class="row">
					<!--
					<p>
						<img src="banerT.jpg">
					</p>-->
					
					<!-- start contact form -->
                    <div class="col-lg-12" align="center">
                       
                            <form method="get" action="index.php">
								
                                <div class="row" align="center">
                                    <div class="col-md-10">
                                        <input type="text" class="medium-input" maxlength="50" placeholder="Búsqueda" required="required" name="busqueda" value="<?php if(!empty($_GET["busqueda"])){ echo $_GET["busqueda"];}?>" />
                                    </div>
									
                                    <div class="col-md-2 sm-margin-30px-bottom">
                                        <button type="submit" class="butn"><span>Buscar</span></button>
                                    </div>
                                </div>
                            </form>
                        
                    </div>
                    <!-- end contact form  -->

                    <!-- start product grid left panel -->
                    <div class="col-lg-3 col-md-12">

                        <div id="accordion" class="accordion-style2 margin-20px-bottom">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Categorías</button>
                                    </h5>
                                </div>
                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="card-body">
                                        <ul class="list-style-5">
											<li><a href="index.php">TODOS</a></li>
											<?php
											$categorias = mysqli_query($conexion,"SELECT * FROM productos_categorias 
											LEFT JOIN productos ON prod_categoria=catp_id AND prod_visible_web=1 AND prod_precio>0
											WHERE catp_grupo=2
											GROUP BY catp_id
											");
											while($cat = mysqli_fetch_array($categorias)){
												if(!empty($_GET["cat"]) && $_GET["cat"]==$cat[0]){
											?>
                                            	<li><span style="color: darkblue; font-weight: bold;"><?=strtoupper($cat[1]);?></span></li>
											<?php 
												}else{
											?>
												<li><a href="index.php?cat=<?=$cat[0];?>"><?=strtoupper($cat[1]);?></a></li>
											<?php
												}
											}
											?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
							
                        </div>
						
						<div id="accordion2" class="accordion-style2 margin-20px-bottom">
                            <div class="card">
                                <div class="card-header" id="marcas">
                                    <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#marcas" aria-expanded="true" aria-controls="marcas">Marcas</button>
                                    </h5>
                                </div>
                                <div id="marcas" class="collapse show" aria-labelledby="marcas" data-parent="#accordion2">
                                    <div class="card-body">
                                        <ul class="list-style-5">
											<li><a href="index.php">TODOS</a></li>
											<?php
											$categorias = mysqli_query($conexion,"SELECT * FROM marcas
											INNER JOIN productos ON prod_marca=mar_id AND prod_visible_web=1 AND prod_precio>0
											GROUP BY mar_id
											");
											while($cat = mysqli_fetch_array($categorias)){
												if(!empty($_GET["marca"]) && $_GET["marca"]==$cat[0]){
											?>
                                            	<li><span style="color: darkblue; font-weight: bold;"><?=strtoupper($cat[1]);?></span></li>
											<?php 
												}else{
											?>
												<li><a href="index.php?marca=<?=$cat[0];?>#productos"><?=strtoupper($cat[1]);?></a></li>
											<?php
												}
											}
											?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
							
                        </div>
						
						<!--
                        <div class="offer-banner bg-theme text-center sm-display-none">
                            <a href="javascript:void(0)"><img src="img/shop/left-panel-banner.png" alt="" /></a>
                        </div>
						-->
						
                    </div>
                    <!-- end product grid left panel -->

                    <!-- start right panel section -->
                    <div class="col-lg-9 col-md-12 padding-30px-left sm-padding-15px-lr">

               

                        <div class="row product-grid margin-50px-bottom sm-margin-30px-bottom">

							<?php
							$filtro = '';
							if(!empty($_GET["cat"])){$filtro .= " AND prod_categoria='".$_GET["cat"]."'";}
							if(!empty($_GET["marca"])){$filtro .= " AND prod_marca='".$_GET["marca"]."'";}
							if(!empty($_GET["busqueda"])){$filtro .= " AND (prod_nombre LIKE '%".$_GET["busqueda"]."%' OR prod_descripcion_corta LIKE '%".$_GET["busqueda"]."%')";}
							
							$productos = mysqli_query($conexion,"SELECT * FROM productos
							WHERE prod_visible_web=1 AND prod_precio>0 $filtro
							ORDER BY prod_foto DESC, prod_posicion
							");
							while($prod = mysqli_fetch_array($productos)){
								
								$foto = $prod['prod_foto'];
								if($prod['prod_foto']==""){
									$foto = 'sinfoto.png';
								}
								
								$precioConIva = $prod['prod_precio'] + ($prod['prod_precio']*0.19);
								
								$utilidadWeb = $prod['prod_descuento_web']/100;
								$precioWeb = $prod['prod_costo'] + ($prod['prod_costo']*$utilidadWeb);
								$precioWebConIva = $precioWeb + ($precioWeb*0.19);
								
								if($precioWebConIva>$precioConIva) continue;
								if($precioWeb=='0' or $precioConIva=='0') continue;
							?>
                            <div class="col-xl-4 col-md-6 margin-30px-bottom sm-margin-20px-bottom">
                                <div class="border">

                                    <a href="detalle.php?id=<?=$prod['prod_id'];?>" class="product-block" title="<?=$prod['prod_nombre'];?>">
                                        <!--<div class="label-offer bg-red">Sale</div>-->
										<img src="https://softjm.com/usuarios/files/productos/<?=$foto;?>" alt="" class="imagenProducto" />
									</a>
                                    
									<div class="product-info">
                                        
										<a href="detalle.php?id=<?=$prod['prod_id'];?>"><?=$prod['prod_nombre'];?></a>
                                        
										<p class="price text-center no-margin">
                                            <span class="red line-through margin-10px-right">$<?=number_format($precioConIva,0,".",",");?></span>
                                            <span>$<?=number_format($precioWebConIva,0,".",",");?></span>
                                        </p>
										
                                    </div>
									
									
                                    <div class="buttons">
                                        
										<a href="detalle.php?id=<?=$prod['prod_id'];?>" class="bg-extra-dark-gray text-white"><i class="fas fa-eye margin-10px-right"></i>Detalles</a>
										
										<?php if(!empty($_SESSION["idC"])){?>
                                        	<a href="#sql.php?get=2&pd=<?=$prod['prod_id'];?>" id="<?=$prod['prod_id'];?>" onClick="carrito(this.id)" class="bg-theme text-white"><i class="fas fa-shopping-cart margin-10px-right"></i>Añadir</a>
										<?php }else{?>
											<a href="login.php" class="bg-theme text-white"><i class="fas fa-shopping-cart margin-10px-right"></i>Añadir</a>
										<?php }?>
                                    </div>

                                </div>
                            </div>
							<?php }?>


                        </div>
						
						<!--
                        <div class="row">
                            <div class="col-12 no-padding sm-padding-15px-lr">
                                <div class="pagination text-small text-uppercase text-extra-dark-gray">
                                    <ul>
                                        <li><a href="javascript:void(0);"><i class="fas fa-long-arrow-alt-left margin-5px-right xs-display-none"></i> Prev</a></li>
                                        <li class="active"><a href="javascript:void(0);">1</a></li>
                                        <li><a href="javascript:void(0);">2</a></li>
                                        <li><a href="javascript:void(0);">3</a></li>
                                        <li><a href="javascript:void(0);">Next <i class="fas fa-long-arrow-alt-right margin-5px-left xs-display-none"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
						-->

                    </div>
                    <!-- end right panel section -->

                </div>
            </div>
        </section>

       

        <?php include("footer.php");?>

    </div>
    <!-- end main-wrapper section -->

    <!-- start scroll to top -->
    <a href="javascript:void(0)" class="scroll-to-top"><i class="fa fa-angle-up" aria-hidden="true"></i></a>
    <!-- end scroll to top -->

    <!-- all js include start -->

    

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

    <!-- jquery.magnific-popup js -->
    <script src="js/jquery.magnific-popup.min.js"></script>

    <!-- isotope.pkgd.min js -->
    <script src="js/isotope.pkgd.min.js"></script>

    <!-- map js -->
    <script src="js/map.js"></script>

    <!-- custom scripts -->
    <script src="js/main.js"></script>

    <!-- all js include end -->

</body>

</html>