<header class="header-style6">
			
			<!--
			<div id="top-bar">
                <div class="container">
                    <div class="row">
                        <div class="col-md-9 col-xs-12">
                            <div class="top-bar-info">
                                <ul>
                                    <li><i class="fas fa-phone"></i>PBX: (574) 322 06 19</li>
									<li><i class="fas fa-mobile-alt"></i>(310) 798 35 26 - (320) 235 4380</li>
                                    <li><i class="fas fa-envelope"></i>ventas@jmequipos.com</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-3 xs-display-none">
                            <ul class="top-social-icon">
                                <li><a href="https://www.facebook.com/people/Jmendoza-Equipos/100001538321897" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="https://www.youtube.com/channel/UCAwK97o9sCFPoxMJJC4UrHA" target="_blank"><i class="fab fa-youtube"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
			-->
	
            <div class="navbar-default">
                <!-- Start Top Search --
                <div class="top-search white">
                    <div class="container">
						<form action="productos.php" method="get">
                        <div class="input-group">
							
                            <span class="input-group-addon"><i class="fas fa-search"></i></span>
							
                            <input type="text" class="form-control" name="busqueda" value="<?=$_GET["busqueda"];?>" placeholder="Buscar...">
							
                            <span class="input-group-addon close-search"><i class="fas fa-times"></i></span>
							
                        </div>
						</form>	
                    </div>
                </div>
                <!-- End Top Search -->
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-12">
                            <div class="menu_area alt-font">
                                <nav class="navbar navbar-expand-lg navbar-light no-padding">

                                    <div class="navbar-header navbar-header-custom">
                                        <!-- Start Logo -->
                                        <a href="index.php" class="navbar-brand logowhite"><img id="logo" src="img/logos/logo-white.png" alt="logo" width="50"></a>
                                        <!-- End Logo -->
                                    </div>

                                    <div class="navbar-toggler"></div>

                                    <!-- Menu Area -->
                                    <ul class="navbar-nav ml-auto" id="nav" style="display: none;">
										<li><a href="index.php">Productos</a></li>
										<?php if(!empty($_SESSION["idC"])){?>
                                        	<li><a href="carrito-resumen.php">Ir al carrito</a></li>
											<li><a href="#">|</a></li>
											<li><a href="#" style="color: yellow;"><?=$_SESSION["nameC"];?></a></li>
											<li><a href="mis-pedidos.php" style="color: yellow;">Mis Pedidos</a></li>
											<li><a href="salir.php" style="color: yellow;">Salir</a></li>
										<?php }else{?>
											<li><a href="login.php">Login/Registro</a></li>
										<?php }?>
                                    </ul>
                                    <!-- End Menu Area -->
									
									<?php if(!empty($_SESSION["idC"])){?>
                                    <div  class="attr-nav sm-no-margin sm-margin-70px-right xs-margin-65px-right">
										<ul>
                                            <li id="respCarrito" class="dropdown sm-margin-20px-right xs-margin-15px-right">
											</li>
                                        </ul>		
                                    </div>
									<?php }?>
                                    <!-- End Atribute Navigation -->

                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </header>